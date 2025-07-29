<?php

namespace App\Http\Controllers;

use App\Enums\RoleEnum;
use App\Exports\UserExport;
use App\Mail\GeneralMail;
use App\Models\Branch;
use App\Models\Notification;
use App\Models\Role;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    public function list()
    {
        $users = User::all();
        $userCount = $users->count();
        $verified = User::whereNotNull('email_verified_at')->get()->count();
        $notVerified = User::whereNull('email_verified_at')->get()->count();
        $usersUnique = $users->unique(['email']);
        $userDuplicates = $users->diff($usersUnique)->count();

        return view('content.users.index', [
            'totalUser' => $userCount,
            'verified' => $verified,
            'notVerified' => $notVerified,
            'userDuplicates' => $userDuplicates,
        ]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $columns = [
            'id',
            'first_name',
            'email',
            'email_verified_at',
            'phone',
            'status',
            'created_at',
        ];

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumn = $columns[$request->input('order.0.column')];
        $orderDirection = $request->input('order.0.dir');
        $searchValue = $request->input('search.value');
        $query = User::query();

        $admin = Auth::user();

        $query->whereHas('roles', function ($roleQuery) {
            $roleQuery->where('name', '<>', RoleEnum::toString(1));
        });


        // Filter based on admin's role
        if ($admin && isset($admin->roles[0]->name) && $admin->roles[0]->name == RoleEnum::toString(2)) {
            $query->whereHas('branches', function ($branchQuery) use ($admin) {
                $branchQuery->where('id', $admin->branches[0]->id);
            });
        }

        $totalData = $query->count();

        if (!empty($searchValue)) {
            $query->where(function ($innerQuery) use ($searchValue) {
                $innerQuery->where('id', 'LIKE', "%{$searchValue}%")
                    ->orWhere('first_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('last_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('phone', 'LIKE', "%{$searchValue}%")
                    ->orWhere('email', 'LIKE', "%{$searchValue}%");
            });
        }

        $totalFiltered = $query->count();

        $users = $query->offset($start)
            ->limit($limit)
            ->orderBy($orderColumn, $orderDirection)
            ->get();

        $data = [];

        foreach ($users as $index => $user) {
            $nestedData['id'] = $user->id;
            $nestedData['fake_id'] = $start + $index + 1;
            $nestedData['name'] = $user->first_name . ' ' . $user->last_name;
            $nestedData['email'] = $user->email;
            $nestedData['email_verified_at'] = $user->email_verified_at;
            $nestedData['phone'] = $user->phone;
            $nestedData['branch'] = $user->branches->first()->name . ' (' . optional($user->branches->first())->branch_code. ')';
            $nestedData['role'] = $user->roles->first()->name;
            $nestedData['status'] = $user->status;

            $data[] = $nestedData;
        }

        $response = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'code' => 200,
            'data' => $data,
        ];

        return response()->json($data ? $response : [
            'message' => 'Internal Server Error',
            'code' => 500,
            'data' => [],
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $roles = Role::get();
        $branches = Branch::where('status', 1);
        $admin = auth()->user();
        if (isset($admin->roles[0]) && $admin->roles[0]->name == RoleEnum::toString(2)) {
            $branches = $branches->where('id', $admin->branches[0]->id);
        }
        $branches = $branches->get();

        return view('content.users.create', compact('roles', 'branches'));
    }

    public function export()
    {
        return Excel::download(new UserExport(), 'users.xlsx');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        try {

            DB::beginTransaction();

            $password = Str::random(8);
            $user = User::create([
                "first_name" => $request->input('first_name'),
                "last_name" => $request->input('last_name'),
                "email" => $request->input('email'),
                // "phone" => str_replace(' ', '', $request->input('phone')),
                "phone" => $request->input('phone'),
                "password" => bcrypt($password),
                "created_by" => auth()->user()->id ?? 1,
            ]);

            DB::table('branch_users')->insert([
                'user_id' => $user->id,
                'branch_id' => $request->input('branch_id'),
            ]);

            $userRole = new UserRole();
            $userRole->user_id = $user->id;
            $userRole->role_id = $request->input('role_id');
            $userRole->save();

            $role = Role::find($userRole->role_id);

            $notificationData = [
                "branch_id" => $request->input('branch_id'),
                "title" => "Profile Created",
                "description" => "$user->first_name $user->last_name account has been created by " . auth()->user()->first_name,
                "menu" => "Users",
            ];
            Notification::createNotification($notificationData);

            $user_details['name'] = $user->first_name . ' ' . $user->last_name;
            $user_details['subject'] = "Welcome to KN Express";
            $user_details['email'] = $user->email;
            $user_details['message'] = "For login into your $role->name account, Please verify the email first by <a href='" . url("auth/confirm-user-mail/{$user->id}") . "'>clicking here</a><br><br>
            Username: $user->email<br>
            Password: $password";

            Mail::send(new GeneralMail($user_details));

            DB::commit();
            return redirect()->route('user.list')->with(["status" => true, "message" => "Record added successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not added. Please try again later..!"]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        return view('content.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $roles = Role::get();
        $branches = Branch::where('status', 1);
        $admin = auth()->user();
        if (isset($admin->roles[0]) && $admin->roles[0]->name == RoleEnum::toString(2)) {
            $branches = $branches->where('id', $admin->branches[0]->id);
        }
        $branches = $branches->get();

        return view('content.users.edit', compact('user', 'roles', 'branches'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            DB::beginTransaction();

            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                "updated_by" => auth()->user()->id ?? 1,
            ]);

            DB::table('role_user')->where('user_id', $user->id)->delete();
            DB::table('branch_users')->where('user_id', $user->id)->delete();

            DB::table('branch_users')->insert([
                'user_id' => $user->id,
                'branch_id' => $request->input('branch_id'),
            ]);

            $userRole = new UserRole();
            $userRole->user_id = $user->id;
            $userRole->role_id = $request->input('role_id');
            $userRole->save();

            $admin = auth()->user();
            $role = isset(auth()->user()->roles[0]) ? auth()->user()->roles[0]->name : 'Super-Admin';

            $notificationData = [
                "branch_id" => $request->input('branch_id'),
                "title" => "Profile Updated",
                "description" => "$user->first_name $user->last_name account has been updated by " . auth()->user()->first_name,
                "menu" => "Users",
            ];
            Notification::createNotification($notificationData);

            $user_details['name'] = $user->first_name . ' ' . $user->last_name;
            $user_details['subject'] = "Profile Updated";
            $user_details['email'] = $user->email;
            $user_details['message'] = "Your profile has been updated by $admin->first_name $admin->last_name ($role) please login into your account and confirm the details.";

            Mail::send(new GeneralMail($user_details));

            DB::commit();
            return redirect()->route('user.list')->with(["status" => true, "message" => "Record updated successfully..!"]);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return redirect()->back()->with(["status" => false, "message" => "Record not updated. Please try again later..!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            DB::beginTransaction();

            $notificationData = [
                "branch_id" => $user->branches[0]->id,
                "title" => "Profile Deleted",
                "description" => "$user->first_name $user->last_name account has been deleted by " . auth()->user()->first_name,
                "menu" => "Users",
            ];
            Notification::createNotification($notificationData);

            $user->delete();

            DB::commit();
            return response()->json(["status" => true, "message" => "Record deleted successfully..!"], 200);
        } catch (\Exception $e) {
            info($e->getMessage());
            DB::rollBack();
            return response()->json(["status" => false, "message" => "Record not deleted. Please try again later..!"], 405);
        }
    }
}

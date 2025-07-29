@extends('layouts/layoutMaster')

@section('title', 'User Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    <script>
        $(function () {
            $("#role_id").select2();
            $("#branch_id").select2();
        });

    </script>
    <script>
        $(function () {
            @if (session('message'))
            @if (session('status'))
            toastr.success("{{ session('message') }}");
            @else
            toastr.error("{{ session('message') }}");
            @endif
            @endif

            @if ($errors->any())
            @foreach ($errors->all() as $error)
            toastr.error("{{ $error }}");
            @endforeach
            @endif
        });
    </script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href="{{ route('user.list') }}">Users</a> / Edit</span>
            </h4>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update User</h5>
                </div>
                <div class="card-body">

                    <form class="add-new-user pt-0 needs-validation" id="addNewUserForm"
                          action="{{ route('user.update', ['user' => $user->id]) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="row">

                            <div class="mb-3 col-sm-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" placeholder="First Name"
                                       name="first_name" aria-label="First Name" value="{{ $user->first_name }}">
                                @error('first_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" placeholder="Last Name"
                                       name="last_name" aria-label="Last Name" value="{{ $user->last_name }}">
                                @error('last_name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Email"
                                       aria-label="Email"
                                       name="email" value="{{ $user->email }}">
                                @error('email')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" placeholder="Phone"
                                       aria-label="Phone"
                                       name="phone" value="{{ $user->phone }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="branch_id" class="form-label">Branch</label>
                                <select class="form-select select2" required id="branch_id" name="branch_id"
                                        aria-label="Origin">
                                    <option value="{{null}}">Select</option>
                                    @foreach($branches as $branch)
                                        <option
                                            @if(isset($user->branches[0]->id) && $branch->id == $user->branches[0]->id) selected
                                            @endif value="{{ $branch->id }}">
                                            {{ $branch->name }} ({{ $branch->branch_code }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('branch_id')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="role" class="form-label">Role</label>
                                <select class="form-select select2" id="role_id" name="role_id"
                                        aria-label="Role">
                                    <option value="{{null}}">Select</option>
                                    <option
                                        @if(isset($user->roles[0]->id) && \App\Enums\RoleEnum::ADMIN == $user->roles[0]->id) selected
                                        @endif value="{{ \App\Enums\RoleEnum::ADMIN }}">{{ \App\Enums\RoleEnum::toString(2) }}</option>
                                    <option
                                        @if(isset($user->roles[0]->id) && \App\Enums\RoleEnum::BRANCHMANAGER == $user->roles[0]->id) selected
                                        @endif value="{{ \App\Enums\RoleEnum::BRANCHMANAGER }}">{{ \App\Enums\RoleEnum::toString(3) }}</option>
                                    <option
                                        @if(isset($user->roles[0]->id) && \App\Enums\RoleEnum::DELIVERYAGENT == $user->roles[0]->id) selected
                                        @endif value="{{ \App\Enums\RoleEnum::DELIVERYAGENT }}">{{ \App\Enums\RoleEnum::toString(4) }}</option>
                                </select>
                                @error('role_id')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            {{--                            <div class="mb-3 col-sm-6">--}}
                            {{--                                <label for="role" class="form-label">Role</label>--}}
                            {{--                                <select class="form-select select2" id="role_id" name="role_id"--}}
                            {{--                                        aria-label="Role">--}}
                            {{--                                    <option value="{{null}}">Select</option>--}}
                            {{--                                    @foreach($roles as $role)--}}
                            {{--                                        <option @if(isset($user->roles[0]->id) && $role->id == $user->roles[0]->id) selected--}}
                            {{--                                                @endif value="{{ $role->id }}">{{ $role->name }}</option>--}}
                            {{--                                    @endforeach--}}
                            {{--                                </select>--}}
                            {{--                                @error('role')--}}
                            {{--                                <div class="text-danger">{{$message}}</div>--}}
                            {{--                                @enderror--}}
                            {{--                            </div>--}}

                        </div>

                        <button type="submit" class="btn btn-primary">Submit</button>
                        <button type="reset" class="btn btn-secondary me-3">Reset</button>
                        <a href="{{route('user.list')}}" class="btn btn-danger me-3">Back</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

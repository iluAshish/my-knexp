@extends('layouts/layoutMaster')

@section('title', 'Order Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
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
        const getPermissions = @json(auth()->user()->roles);
        const getDirectPermissions = @json(auth()->user()->permissions);
        const userRole = getDirectPermissions.length ? 'super-admin' : getPermissions[0].name;
        const userPermissions = getDirectPermissions.length ? [] : getPermissions[0].permissions;

        function hasPermission(permissionName) {
            if (userRole === 'super-admin') {
                return true;
            }

            return userPermissions.some(permission => permission.name === permissionName);
        }


    </script>
    <script src="{{ asset('js/notifications.js') }}"></script>
    <script>
        $(function() {
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

    @php
        \App\Models\Notification::where('user_id', auth()->user()->id)->whereNull('read_at')->update(['read_at' => now()]);
    @endphp
    <!-- Notifications List Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Notifications</h5>
            @permission('notification.export')
                <span class="float-end">
                    <a href="{{ route('notification.export') }}">
                        <button class="btn btn-secondary btn-label-primary" tabindex="0" aria-controls="DataTables_Table_0"
                                type="button" aria-haspopup="dialog" aria-expanded="false">
                            <span><i class="ti ti-logout rotate-n90 me-2"></i>Export Full</span><span class="dt-down-arrow"></span>
                        </button>
                    </a>
                </span>
            @endpermission
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-notifications table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>User</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Menu</th>
                        <th>Created By</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

@endsection

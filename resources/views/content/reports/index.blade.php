@extends('layouts/layoutMaster')

@section('title', 'Report')

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
    <script src="{{ asset('js/reports.js') }}"></script>
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

            $("#export-link").on("click", function (e) {
                e.preventDefault();

                let startDate = $("#filter-start-date").val();
                let endDate = $("#filter-end-date").val();
                let status = $("#status").val();
                let branchId = $("#branch_id").val();
                let stateId = $("#state_id").val();

                let exportLink = $(this).attr("href");
                exportLink += `?start_date=${startDate}&end_date=${endDate}&status=${status}&branch_id=${branchId}&state_id=${stateId}`;

                window.location.href = exportLink;
            });

            $(".form-select").select2();
            $('#reset-form').on('click', function(e) {
                $(".form-select").val(null);
            });
        });
    </script>
@endsection

@section('content')

    <!-- Orders List Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Reports</h5>
        </div>

        <div class="card-body">
            @permission('report.export')
            <span class="float-end">
                <a href="{{ route('report.export') }}" id="export-link">
                    <button class="btn btn-secondary btn-label-primary" tabindex="0" aria-controls="DataTables_Table_0"
                            type="button" aria-haspopup="dialog" aria-expanded="false">
                        <span><i class="ti ti-logout rotate-n90 me-2"></i>Export Full</span><span
                            class="dt-down-arrow"></span>
                    </button>
                </a>
            </span>
            @endpermission
            <form id="filter-form">
                @csrf
                <div class="row">
                    <div class="col-12 col-sm-12 d-flex gap-1 pe-4 ps-1 manage-col manage-col-wrap">

                        <div class="col-sm-2">
                            <label class="form-label" for="filter-start-date">From</label>
                            <input type="date" class="form-control" name="start_date" id="filter-start-date">
                        </div>
                        <div class="col-sm-2">
                            <label class="form-label" for="filter-end-date">To</label>
                            <input type="date" class="form-control" name="end_date" id="filter-end-date">
                        </div>

                        <div class="col-sm-2">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select" name="status" id="status">
                                <option value="{{null}}">Select</option>
                                @foreach(\App\Enums\ShipmentStatusEnum::all() as $status)
                                    <option value="{{$status}}">{{$status}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label for="branch_id" class="form-label">Origin</label>
                            <select class="form-select" id="branch_id" name="branch_id"
                                    aria-label="Origin">
                                <option value="{{null}}">Select</option>
                                @foreach($branches as $branch)
                                    <option value="{{ $branch->id }}">
                                        {{ $branch->name }} ({{ $branch->branch_code }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label for="state_id" class="form-label">Destination</label>
                            <select class="form-select" id="state_id" name="state_id"
                                    aria-label="Destination">
                                <option value="{{null}}">Select</option>
                                @foreach($states as $state)
                                    <option value="{{ $state->id }}">
                                        {{ $state->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="col-sm-2 ps-1" style="display: flex; align-items: flex-end;">
                        <label class="form-label">&nbsp;</label>
                        <button type="button" class="btn btn-info" id="filter-table"
                                style="margin-top: 10px;">Filter
                        </button>
                        <button type="reset" class="btn btn-secondary" id="reset-form" style="margin-top: 10px; margin-left: 5px;">Reset</button>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-reports table">
                <thead class="border-top">
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Order Number</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Shipment Date</th>
                    <th>Origin</th>
                    <th>Destination</th>
                    <th>Updated By</th>
                    <th>Status</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>

@endsection

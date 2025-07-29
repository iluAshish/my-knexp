@extends('layouts/layoutMaster')

@section('title', 'Shipment Management')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css') }}"/>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
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
    <script>

        const RECEIVED = 'Shipment Received';
        const PROCESSING = 'Shipment Processing';
        const DEPARTED_FROM_AIRPORT = 'Departed from Manila Airport';
        const ARRIVED_AT_AIRPORT = 'Arrived at Dubai Airport';
        const CLEARANCE_PROCESSING = 'Clearance Processing';
        const OUT_FOR_DELIVERY = 'Out for Delivery';
        const DELIVERED = 'Delivered';

        const statusLabels = {
            [RECEIVED]: '<span class="badge bg-label-primary">Shipment Received</span>',
            [PROCESSING]: '<span class="badge bg-label-secondary">Shipment Processing</span>',
            [DEPARTED_FROM_AIRPORT]: '<span class="badge bg-label-success">Departed from Manila Airport</span>',
            [ARRIVED_AT_AIRPORT]: '<span class="badge bg-label-danger">Arrived at Dubai Airport</span>',
            [CLEARANCE_PROCESSING]: '<span class="badge bg-label-dark">Clearance Processing</span>',
            [OUT_FOR_DELIVERY]: '<span class="badge bg-label-warning">Out for Delivery</span>',
            [DELIVERED]: '<span class="badge bg-label-info">Delivered</span>',
        };
    </script>
    <script src="{{ asset('js/shipments.js') }}"></script>
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
    <script>
        $(function () {
            $(".status").select2();

            let dateLockWeeks = @json($dateLockWeeks);
            let dateLockDays = @json($dateLockDays);
            $(".shipment_date").datepicker({
                beforeShowDay: function (date) {
                    let day = date.getDay();
                    let formattedDate = $.datepicker.formatDate("yy-mm-dd", date);
                    if (dateLockWeeks.includes(day.toString())) {
                        return dateLockDays.includes(formattedDate) ? [false, "disabled"] : [true, ""];
                    } else {
                        return [false, "disabled"];
                    }
                },
            });

            $(document).on('click', '.update-record', function () {

                var shipment_date = $("#shipment_date").val();
                var status = $("#status").val();

                if (!shipment_date.length || !status.length) {
                    toastr.error('Shipment Date/Status required');
                    return false;
                }


                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, update it!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        $("#bulk-update").submit();
                    }

                });
            });

        });
    </script>
@endsection

@section('content')

    @if(auth()->user()->hasPermissionTo('order.updateshipmentstatusbulk') || auth()->user()->hasDirectPermissionTo('order.updateshipmentstatusbulk'))

        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Shipment Updates</h5>
            </div>
            <div class="card-body">
                <form id="bulk-update" action="{{ route('order.updateShipmentStatusBulk') }}" method="post">
                    @csrf
                    <div class="row align-items-end ">

                        <div class="col-sm-4">
                            <label for="shipment_date" class="form-label">Shipment Date</label>
                            <input type="text" readonly class="form-control datepicker shipment_date" required
                                   placeholder="Shipment Date"
                                   id="shipment_date"
                                   name="shipment_date" aria-label="Shipment Date">
                        </div>

                        <div class="col-sm-4">
                            <label class="form-label" for="status">Status</label>
                            <select class="form-select status" name="status" id="status" required>

                                    <option value="{{null}}">Select Status</option>
                                @foreach (\App\Enums\ShipmentStatusEnum::all() as $shipmentStatus)
                                    @if(in_array($shipmentStatus,[\App\Enums\ShipmentStatusEnum::RECEIVED])) @continue @endif
                                    <option value="{{ $shipmentStatus }}">
                                        {{ $shipmentStatus }}</option>
                                @endforeach

                            </select>
                        </div>
                        <div class="col-sm-4">
                            <button class="btn btn-primary update-record" type="button">Update</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
        <br>

    @endif

    <!-- Shipments List Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Shipments</h5>
        </div>

        <form>
            @csrf
            <div class="row card-body">

                <div class="col-sm-2">
                    <label for="shipment_date" class="form-label">Shipment Date</label>
                    <input type="text" readonly class="form-control datepicker shipment_date" required id="shipment_date2"
                           placeholder="Shipment Date"
                           name="shipment_date" aria-label="Shipment Date">
                </div>

                <div class="col-sm-2">
                    <label class="form-label" for="status2">Status</label>
                    <select class="form-select status" name="status" id="status2">
                        <option value="{{null}}">Select</option>
                        @foreach(\App\Enums\ShipmentStatusEnum::all() as $status)
                            <option value="{{$status}}">{{$status}}</option>
                        @endforeach
                    </select>
                </div>


                <div class="col-sm-2 ps-1" style="display: flex; align-items: flex-end;">
                    <label class="form-label">&nbsp;</label>
                    <button type="button" class="btn btn-info" id="filter-table"
                            style="margin-top: 10px;">Filter
                    </button>
                </div>

            </div>
        </form>

        <div class="card-datatable table-responsive">
            <table class="datatables-shipments table">
                <thead class="border-top">
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Order Number</th>
                    <th>Shipment Date</th>
                    <th>Status</th>
                    <th>Date Time</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>

@endsection

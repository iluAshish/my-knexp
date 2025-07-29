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
    <script src="{{ asset('js/orders.js') }}"></script>
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

    <!-- Orders List Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Orders</h5>
            @permission('order.export')
                <span class="float-end">
                <a href="{{ route('order.export') }}">
                    <button class="btn btn-secondary btn-label-primary" tabindex="0" aria-controls="DataTables_Table_0"
                            type="button" aria-haspopup="dialog" aria-expanded="false">
                        <span><i class="ti ti-logout rotate-n90 me-2"></i>Export Full</span><span class="dt-down-arrow"></span>
                    </button>
                </a>
            </span>
            @endpermission
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-orders table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Order Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Shipment Date</th>
                        <th>Updated By</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
        </div>

    </div>

    <div class="modal fade" id="statusModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h5 class="modal-title" id="exampleModalLabel">Update Shipment Status</h5>
                </div>
                <form class="row g-3" action="{{ route('order.updateShipmentStatus') }}" method="POST">
                    @csrf
                    <input type="hidden" id="order_id" name="order_id">
                    <div class="modal-body">
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="order_status">Status</label>
                            <select class="form-control select2" name="order_status" id="order_status" required>

                                @foreach (\App\Enums\ShipmentStatusEnum::all() as $shipmentStatus)
                                    @if(in_array($shipmentStatus,[\App\Enums\ShipmentStatusEnum::RECEIVED])) @continue @endif
                                    <option value="{{ $shipmentStatus }}">
                                        {{ $shipmentStatus }}</option>
                                @endforeach

                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary close-modal" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection

@extends('layouts/layoutMaster')

@section('title', 'Delivery Comment')

@section('vendor-style')
    <style>
        @media (max-width:375px) {
            .delivery-agent-text {
                font-size: 9px!important;
            }
        }
    </style>
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
    <script src="{{ asset('js/delivery-comments.js') }}"></script>
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
            <h5 class="card-title mb-0">Delivery Comments</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-delivery-comments table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Order#</th>
                        <th>Status</th>
                        <th>Customer Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Shipment Date</th>
                        <th>Origin</th>
                        <th>Destination</th>
                        <th>Comments</th>
                        <th>Delivery Agent</th>
                        <th>Updated By</th>
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
                <form class="row g-3" action="{{ route('deliverycomment.updateshipmentstatus') }}" method="POST">
                    @csrf
                    <input type="hidden" id="order_id" name="order_id">
                    <div class="modal-body">
                        <div class="col-12 col-md-12">
                            <label class="form-label" for="order_status">Status</label>
                            <input readonly disabled class="form-control" type="text" value="{{\App\Enums\ShipmentStatusEnum::DELIVERED}}" id="order_status">
                        </div>
                        <div class="col-12 col-md-12 pt-1">
                            <label class="form-label" for="comments">Comment</label>
                            <textarea class="form-control" name="comments" id="comments" cols="5" rows="5"></textarea>
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

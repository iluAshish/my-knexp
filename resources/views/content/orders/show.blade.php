@extends('layouts/layoutMaster')

@section('title', 'Order Management')

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

@section('content')

    <div class="container">
        <div class="row">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href="{{ route('order.list') }}">Orders</a> / View</span>
            </h4>

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Order</h5>
                </div>


                <div class="card-body pt-4">
                    <p>Customer Details</p>

                    <div class="row">

                        <div class="mb-3  col-sm-6">
                            <label for="first_name" class="form-label">First Name</label>
                            <input disabled readonly type="text" class="form-control" id="first_name" aria-label="First Name"
                                   value="{{ $order->customer->first_name }}">
                        </div>

                        <div class="mb-3  col-sm-6">
                            <label for="last_name" class="form-label">Last Name</label>
                            <input disabled readonly type="text" class="form-control" required id="last_name" placeholder="Last Name"
                                   name="customer[last_name]" aria-label="Last Name" value="{{ $order->customer->last_name }}">
                        </div>

                        <div class="mb-3  col-sm-6">
                            <label for="email" class="form-label">Email</label>
                            <input disabled readonly type="email" class="form-control" required id="email" placeholder="Email"
                                   aria-label="Email" name="customer[email]" value="{{ $order->customer->email }}">
                        </div>

                        <div class="mb-3  col-sm-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input disabled readonly type="tel" class="form-control" required id="phone" placeholder="Phone"
                                   aria-label="Phone" name="customer[phone]" value="{{ $order->customer->phone }}">
                        </div>

                        <div class="mb-3  col-sm-6">
                            <label for="address" class="form-label">Address</label>
                            <textarea disabled readonly class="form-control" required id="address" aria-label="Address"
                                      name="customer[address]">{{ $order->customer->address }}</textarea>
                        </div>

                    </div>

                </div>


                <div class="card-body">
                    <p>Order Details</p>

                    <div class="row">

                        <div class="mb-3 col-sm-6">
                            <label for="branch_id" class="form-label">Origin</label>
                            <select disabled readonly class="form-select select2" required id="branch_id" name="branch_id"
                                    aria-label="Origin">
                                <option value="{{null}}">{{ $order->originBranch->name }}</option>
                            </select>

                        </div>

                        <div class="mb-3 col-sm-6">
                            <label for="state_id" class="form-label">Destination</label>
                            <select disabled readonly class="form-select select2" required id="state_id" name="state_id"
                                    aria-label="Destination">
                                <option value="{{null}}">{{ $order->destinationState->name }}</option>

                            </select>

                        </div>

                        <div class="mb-3 col-sm-6">
                            <label for="shipment_date" class="form-label">Shipment Date</label>
                            <input disabled readonly type="date" class="form-control" required id="shipment_date"
                                   placeholder="Shipment Date"
                                   name="shipment_date" aria-label="Shipment Date"
                                   value="{{ $order->shipment_date }}">

                        </div>

                        <div class="mb-3 col-sm-6">
                            <label for="items" class="form-label">Items</label>
                            <input disabled readonly type="number" class="form-control" required id="items" placeholder="Items"
                                   name="items" aria-label="Items"
                                   value="{{ $order->items }}">

                        </div>
                        
                        <div class="mb-3 col-sm-6">
                            <label for="state_id" class="form-label">Service Types </label>
                            <select class="form-select select2" id="servicetype" name="servicetype" disabled readonly
                                    aria-label="Service Types">
                                <option value="{{null}}">Select</option>
                                <option value="AIR CARGO" @if($order->servicetype == 'AIR CARGO') selected
                                            @endif>
                                   AIR CARGO
                                </option>
                                    
                                <option value="SEA CARGO" @if($order->servicetype == 'SEA CARGO') selected
                                            @endif>
                                   SEA CARGO
                                </option>
                            </select>
                        </div>

                        <p class="pt-4">Sender Details <span>(optional)</span></p>
                        <div class="mb-3 col-sm-6">
                            <label for="name" class="form-label">Name</label>
                            <input disabled readonly type="text" class="form-control" id="name" placeholder="Name"
                                   name="sender[name]" aria-label="Name"
                                   value="{{ $order->name ?? '-' }}">

                        </div>

                        <div class="mb-3 col-sm-6">
                            <label for="email" class="form-label">Email</label>
                            <input disabled readonly type="email" class="form-control" id="email" placeholder="Email"
                                   aria-label="Email" name="sender[email]" value="{{ $order->email ?? '-' }}">

                        </div>

                        <div class="mb-3 col-sm-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input disabled readonly type="phone" class="form-control" id="phone" placeholder="Phone"
                                   aria-label="Phone" name="sender[phone]" value="{{ $order->phone ?? '-' }}">

                        </div>

                        <div class="mb-3 col-sm-6">
                            <label for="address" class="form-label">Address</label>
                            <textarea disabled readonly class="form-control" id="address" aria-label="Address"
                                      name="sender[address]">{{ $order->address ?? '-' }}</textarea>
                        </div>

                    </div>

                <a href="{{route('order.list')}}" class="btn btn-danger me-3">Back</a>
                </div>

            </div>
        </div>
    </div>

@endsection
@extends('layouts/layoutMaster')

@section('title', 'Branch View - Pages')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href="{{ route('branch.list') }}">Branches</a> / View</span>
            </h4>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Branch</h5>
                </div>
                <div class="card-body">

                        <div class="row">

                            <div class="mb-3 col-sm-6">
                                <label class="form-label" for="state_id">State</label>
                                <select disabled readonly id="state_id" class="form-select select2">
                                        <option>{{ $branch->state->name }}</option>
                                </select>
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="name" class="form-label">Branch Name</label>
                                <input disabled readonly type="text" class="form-control" placeholder="Branch Name"
                                       id="name" aria-label="Branch Name" value="{{ $branch->name }}">
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="branch_code" class="form-label">Branch Code</label>
                                <input disabled readonly type="text" class="form-control" placeholder="Branch Code"
                                       id="branch_code" aria-label="Branch Code" value="{{ $branch->branch_code }}"
                                       pattern="[A-Za-z0-9]{4}"
                                       title="Branch code must be 4 characters (letters or digits)">
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input disabled readonly type="tel" class="form-control" placeholder="Phone"
                                       aria-label="Phone"
                                       id="phone" value="{{ $branch->phone }}">
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="address" class="form-label">Address</label>
                                <input disabled readonly type="text" class="form-control" placeholder="Address"
                                       id="address" aria-label="Address" value="{{ $branch->address }}">
                            </div>
                        </div>

                        <a href="{{route('branch.list')}}" class="btn btn-danger me-3">Back</a>

                </div>
            </div>
        </div>
    </div>

@endsection

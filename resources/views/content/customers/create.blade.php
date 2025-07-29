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
    <script src="{{ asset('/js/customer-validation.js') }}"></script>
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
                <span class="text-muted fw-light"><a href="{{ route('customer.list') }}">Customers</a> / Create</span>
            </h4>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create New Customer</h5>
                </div>
                <div class="card-body">

                    <form class="add-new-user pt-0 needs-validation" id="addNewCustomerForm"
                          action="{{ route('customer.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            <div class="mb-3 col-sm-6">
                                <label for="first_name" class="form-label">First Name <span class="text-danger">*</span></label>
                                <input required type="text" class="form-control" id="first_name" placeholder="First Name"
                                       name="first_name" aria-label="First Name" value="{{ old('first_name') }}">
                                @error('first_name')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="last_name" class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input required type="text" class="form-control" id="last_name" placeholder="Last Name"
                                       name="last_name" aria-label="Last Name" value="{{ old('last_name') }}">
                                @error('last_name')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                <input required type="email" class="form-control" id="email" placeholder="Email"
                                    pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                                       aria-label="Email" name="email" value="{{ old('email') }}">
                                @error('email')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="phone" class="form-label">Phone <span class="text-danger">*</span> <small class="text-muted">(with country code)</small></label>
                                <input required type="number" class="form-control" id="phone" placeholder="+971560000000"
                                       aria-label="Phone" name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="text-danger">{{$message}}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="address" class="form-label">Address <span class="text-danger">*</span></label>
                                <input required type="text" class="form-control" id="address" placeholder="Address"
                                       name="address" aria-label="Address" value="{{ old('address') }}">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button class="btn btn-primary" id="submitButton">Submit</button>
                        <button type="reset" class="btn btn-secondary me-3">Reset</button>
                        <a href="{{route('customer.list')}}" class="btn btn-danger me-3">Back</a>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@extends('layouts/layoutMaster')

@section('title', 'Branch Management')

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
            $("#state_id").select2();
        });
    </script>
    <script src="{{ asset('/js/branch-validation.js') }}"></script>
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

            $('#state_id').select2({
                placeholder: "Select State"
            });
        });
    </script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h4 class="py-3 mb-4">

                <span class="text-muted fw-light"><a href="{{ route('branch.list') }}">Branches</a> / Create</span>
            </h4>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Create New Branch</h5>
                </div>
                <div class="card-body">

                    <form class="add-new-user pt-0 needs-validation" id="addNewCustomerForm"
                          action="{{ route('branch.store') }}" method="POST">
                        @csrf

                        <div class="row">

                            <div class="mb-3 col-sm-6">
                                <label class="form-label" for="state_id">State</label>
                                <select id="state_id" required name="state_id" class="form-select select2"
                                        data-allow-clear="true">
                                    <option></option>
                                    @foreach ($states as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="name" class="form-label">Branch Name</label>
                                <input required type="text" class="form-control" id="name" required placeholder="Branch Name"
                                       name="name" aria-label="Branch Name" value="{{ old('name') }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="branch_code" class="form-label">Branch Code</label>
                                <input required type="text" class="form-control" id="branch_code" placeholder="Branch Code"
                                       name="branch_code" aria-label="Branch Code" value="{{ old('branch_code') }}"
                                       pattern="[A-Za-z0-9]{4}"
                                       title="Branch code must be 4 characters (letters or digits)">
                                @error('branch_code')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>


                            <div class="mb-3 col-sm-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input required type="tel" class="form-control" id="phone" placeholder="Phone"
                                       aria-label="Phone"
                                       name="phone" value="{{ old('phone') }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="address" class="form-label">Address</label>
                                <input required type="text" class="form-control" id="address" placeholder="Address"
                                       name="address"
                                       aria-label="Address" value="{{ old('address') }}">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button class="btn btn-primary" id="submitButton">Submit</button>
                        <button type="reset" class="btn btn-secondary me-3">Reset</button>
                        <a href="{{route('branch.list')}}" class="btn btn-danger me-3">Back</a>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

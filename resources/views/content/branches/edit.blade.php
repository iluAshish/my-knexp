@extends('layouts/layoutMaster')

@section('title', 'Edit Branch')

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
    <script src="{{ asset('/js/branch-validation.js') }}"></script>
    <script>
        $(function () {
            $("#state_id").select2();
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
    <script src="{{ asset('/js/branch-validation.js') }}"></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href="{{ route('branch.list') }}">Branches</a> / Edit</span>
            </h4>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Branch</h5>
                </div>
                <div class="card-body">

                    <form class="add-new-user pt-0 needs-validation" id="addNewCustomerForm"
                          action="{{ route('branch.update', ['branch' => $branch->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="row">

                            <div class="mb-3 col-sm-6">
                                <label class="form-label" for="state_id">State</label>
                                <select required id="state_id" name="state_id" class="form-select select2">
                                    @foreach ($states as $item)
                                        <option
                                            value="{{ $item->id }}" {{ $branch->state_id == $item->id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                                @error('state_id')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="name" class="form-label">Branch Name</label>
                                <input required type="text" class="form-control" id="name" placeholder="Branch Name"
                                       name="name" aria-label="Branch Name" value="{{ $branch->name }}">
                                @error('name')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3 col-sm-6">
                                <label for="branch_code" class="form-label">Branch Code</label>
                                <input required type="text" class="form-control" id="branch_code" placeholder="Branch Code"
                                       name="branch_code" aria-label="Branch Code" value="{{ $branch->branch_code }}"
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
                                       name="phone" value="{{ $branch->phone }}">
                                @error('phone')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3 col-sm-6">
                                <label for="address" class="form-label">Address</label>
                                <input required type="text" class="form-control" id="address" placeholder="Address"
                                       name="address" aria-label="Address" value="{{ $branch->address }}">
                                @error('address')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <button class="btn btn-primary" id="submitButton">Submit</button>
                        <button type="reset" class="btn btn-secondary me-3">Reset</button>
                        <a href="{{ route('branch.list') }}" class="btn btn-danger me-3">Back</a>

                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

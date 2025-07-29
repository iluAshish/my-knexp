@extends('layouts/layoutMaster')

@section('title', 'Create Key Feature')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    {{-- <script src="{{ asset('assets/js/jquery.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/cleavejs/cleave-phone.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('js/home-keyfeature.js') }}"></script>
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
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ url('admin/home/keyfeature') }}">Key Features </a>/</span></span>
        Create Key Feature
    </h4>
    <div class="row">
        <!-- FormValidation -->
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Create Key Feature</h5>
                <div class="card-body">

                    <form method="POST" id="formValidationkeyfeatureCreate" action="{{ route('keyfeature.store') }}" class="row g-3"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" placeholder="Title"
                                    class="form-control required" autocomplete="off"
                                    value="{{ old('title', isset($keyfeature) ? $keyfeature->title : '') }}" maxlength="255">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">

                                <label for="number"> Number</label>
                                <input type="text" class="form-control required" min="0" id="number" maxlength="5"
                                    name="number" placeholder="Number"
                                    value="{{ isset($keyfeature) ? $keyfeature->number : '' }}">
                                @error('number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-md-6">

                                <label for="image">Image</label>
                                <div class="file-loading">
                                    <input id="image" name="image" type="file" class="form-control"
                                        accept="image/*">
                                </div>
                                <span class="caption_note">Note: Image dimension must be 100 X 100 PX and Size must be less
                                    than 512 KB</span>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="image_attribute">Image Attribute*</label>
                                <input type="text" id="image_attribute"
                                    value="{{ old('image_attribute', isset($keyfeature) ? $keyfeature->image_attribute : '') }}"
                                    class="form-control" placeholder='alt="Title"' name="image_attribute" />
                                @error('image_attribute')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-12">
                            <button type="button" name="submitButton" id="addButton"
                                class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /FormValidation -->

@endsection

@extends('layouts/layoutMaster')
@section('title', 'Edit Key Features')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <style>
        .custom-file input[type="file"] {
            display: none;
        }

        .image_box {
            border-radius: 10px;
            padding: 10px 0;
        }

        .image_box img {
            border-radius: ;
            border-radius: 5px;
        }
    </style>
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
    <script>
        jQuery(document).ready(function() {
            $('#image').bind('change', function() {
                var filename = $(this).val().split('\\').pop();
                console.log(filename);
                $(this).closest('.custom-file').find('span').text(filename);
            });
        });
    </script>
@endsection
@section('content')
<style>
    .column_align {
    padding-bottom: 22px !important;
  }
</style>
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ url('admin/home/keyfeature') }}">Key Features </a>/</span></span>
        Edit Key Features
    </h4>
    <div class="row">
        <!-- FormValidation -->
        <div class="col-12">
            <div class="card">
                <h5 class="card-header">Edit Key Feature</h5>
                <div class="card-body">

                    <form method="POST" id="formValidationkeyfeatureEdit"
                        action="{{ route('keyfeature.update', ['keyfeature' => $keyfeature->id]) }}" class="row g-3"
                        enctype="multipart/form-data">

                        @csrf

                        @method('PUT')

                        <div class="row">
                            <div class="form-group col-md-8">
                                <label for="title">Title</label>
                                <input type="text" name="title" id="title" placeholder="Title"
                                    class="form-control required" autocomplete="off"
                                    value="{{ old('title', isset($keyfeature) ? $keyfeature->title : '') }}" maxlength="50">
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group col-md-4">

                                <label for="number"> Number</label>
                                <input type="text" class="form-control required" min="0" maxlength="5" id="number"
                                    name="number" placeholder="Number"
                                    value="{{ old('number', isset($keyfeature) ? $keyfeature->counter : '') }}">
                                @error('number')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="form-group col-md-6">

                                <label for="image">Image</label>
                                @if ($keyfeature->image)
                                <div class="image_box">
                                    <img src="{{url('storage/images/keyfeature').'/'.$keyfeature->image}}" width="50px" alt="image">
                                </div>
                                @endif
                                <div class="input-group custom-file">
                                    <input class="form-control" type="file" id="image" name="image"
                                        value="{{ old('image', isset($keyfeature) ? $keyfeature->image : '') }}">
                                    <label class="input-group-text" for="image">Browse</label>
                                    <label class="form-control d-flex justify-content-start align-items-center" for="image">
                                        <span>Upload Image</span>
                                        <div class=" text-dark ms-auto"></div>
                                    </label>
                                </div>
                                <span class="caption_note">Note: Image dimension must be 100 X 100 PX and Size must be less
                                    than 512 KB</span>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 column_align">
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
                            <button type="button" name="submitButton" id="editButton"
                                class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- /FormValidation -->

@endsection

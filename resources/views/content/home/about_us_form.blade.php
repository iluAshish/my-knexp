@extends('layouts/layoutMaster')

@section('title', 'About Us')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
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
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>

@endsection

@section('page-script')
    <script src="{{ asset('js/home-about-us.js') }}"></script>
    {{-- <script src="{{asset('assets/js/forms-editors.js')}}"></script> --}}
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
    .column_align{
        padding-bottom: 22px !important;
    }
</style>
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"></span> Edit About Us
    </h4>
    <div class="row">
        <!-- FormValidation -->
        <div class="col-12">
            <div class="card">
                <div class="card-body p-3">

                    <form method="POST" id="formValidationabout"
                        action="{{ route('about-us.update', ['about_u' => $about_us_form->id]) }}" class="row g-3"
                        enctype="multipart/form-data">

                        <!-- Account Details -->
                        @csrf

                        @method('PUT')

                        <div class="col-md-6">
                            <label class="form-label" for="formValidationTitle">Title*</label>
                            <input type="text" id="formValidationTitle" class="form-control"
                                value="{{ old('title', isset($about_us_form) ? $about_us_form->title : '') }}"
                                placeholder="Title" name="title" />
                            @error('title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label class="form-label" for="sub_title">Sub Title*</label>
                            <input type="text" id="sub_title"
                                value="{{ old('sub_title', isset($about_us_form) ? $about_us_form->sub_title : '') }}"
                                class="form-control" placeholder="Sub Title" name="sub_title" />
                            @error('sub_title')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6">

                            @if ($about_us_form->image)
                                <div class="image_box">
                                    <img src="{{ url('storage/images/about-us') . '/' . $about_us_form->image }}"
                                        width="100px" alt="image">
                                </div>
                            @endif
                            <label for="image" class="form-label">Image*</label>
                            <div class="input-group custom-file">
                                <input class="form-control" type="file" id="image" name="image">
                                <label class="input-group-text" for="image">Browse</label>
                                <label class="form-control d-flex justify-content-start align-items-center" for="image">
                                    <span>Upload Icon</span>
                                    <div class=" text-dark ms-auto"></div>
                                </label>
                            </div>
                            <span class="caption_note">Note: Image size must be 830 x 1000</span>
                            @error('image')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-6 column_align">
                            <label class="form-label" for="image_attribute">Image Attribute*</label>
                            <input type="text" id="image_attribute"
                                value="{{ old('image_attribute', isset($about_us_form) ? $about_us_form->image_attribute : '') }}"
                                class="form-control" placeholder='alt="Title"' name="image_attribute" />
                            @error('image_attribute')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="description" class="form-label">Description 1*</label>
                            <input type="hidden" name="description" id="description"
                                value="{{ old('description', isset($about_us_form) ? $about_us_form->description : '') }}">
                            <div class="form-control" type="text" id="full-editor-1" placeholder='type..'></div>
                            @error('description')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="title_2" class="form-label">Title 2*</label>
                            <input class="form-control" type="text" placeholder='Title'
                                value="{{ old('title_2', isset($about_us_form) ? $about_us_form->title_2 : '') }}"
                                id="title_2" name="title_2">
                            @error('title_2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-md-12">
                            <label for="description_2" class="form-label">Description 2*</label>
                            <input type="hidden" name="description_2" id="description_2"
                                value="{{ old('description_2', isset($about_us_form) ? $about_us_form->description_2 : '') }}">
                            <div class="form-control" type="text" id="full-editor-2" placeholder='type..'></div>
                            @error('description_2')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-12">
                            <button type="button" name="submitButton" id="submitButton"
                                class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- /FormValidation -->
    </div>
    </div>
@endsection

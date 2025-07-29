@extends('layouts/layoutMaster')

@section('title', 'Edit Why Choose Us')

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
        .input-group.custom-file input[type="file"] {
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
        .column_align{
            padding-bottom: 22px;
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
    <script src="{{ asset('js/home-why-choose-us.js') }}"></script>
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
            $('#icon_1').bind('change', function() {
                var filename = $(this).val().split('\\').pop();
                console.log(filename);
                $(this).closest('.custom-file').find('span').text(filename);
            });
            $('#icon_2').bind('change', function() {
                var filename = $(this).val().split('\\').pop();
                console.log(filename);
                $(this).closest('.custom-file').find('span').text(filename);
            });
            $('#icon_3').bind('change', function() {
                var filename = $(this).val().split('\\').pop();
                console.log(filename);
                $(this).closest('.custom-file').find('span').text(filename);
            });
            $('#icon_4').bind('change', function() {
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
        <span class="text-muted fw-light"></span> Edit Why Choose Us
    </h4>
    <div class="row">
        <!-- FormValidation -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" id="formValidationWhy"
                        action="{{ route('whychooseus.update', ['whychooseu' => $why_choose_us->id]) }}" class="row g-3"
                        enctype="multipart/form-data">

                        <!-- Account Details -->
                        @csrf

                        @method('PUT')
                        <div class="row">
                            <div class="col-md-6">
                                <label class="form-label" for="title">Title*</label>
                                <input type="text" id="title" class="form-control"
                                    value="{{ old('title', isset($why_choose_us) ? $why_choose_us->title : '') }}"
                                    placeholder="Title" name="title" />
                                @error('title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label class="form-label" for="sub_title">Sub Title*</label>
                                <input type="text" id="sub_title"
                                    value="{{ old('sub_title', isset($why_choose_us) ? $why_choose_us->sub_title : '') }}"
                                    class="form-control" placeholder="Sub Title" name="sub_title" />
                                @error('sub_title')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                @if ($why_choose_us->image)
                                    <div class="image_box">
                                        <img src="{{ url('storage/images/whychooseus/image') }}/{{ @$why_choose_us->image }}"
                                            width="100px" alt="">
                                    </div>
                                @endif
                                <label for="image" class="form-label">Image*</label>
                                <div class="input-group custom-file">
                                    <input class="form-control" type="file" id="image" name="image">
                                    <label class="input-group-text" for="image">Browse</label>
                                    <label class="form-control d-flex justify-content-start align-items-center selectfile"
                                        for="image">
                                        <span>Upload Image</span>
                                        <div class=" text-dark ms-auto"></div>
                                    </label>
                                </div>
                                <span class="caption_note">Note: Image size must be 707 x 700</span>
                                @error('image')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 column_align">
                                <label class="form-label" for="image_attribute">Image Attribute*</label>
                                <input type="text" id="image_attribute"
                                    value="{{ old('image_attribute', isset($why_choose_us) ? $why_choose_us->image_attribute : '') }}"
                                    class="form-control" placeholder='alt="Title"' name="image_attribute" />
                                @error('image_attribute')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h4>Icon 1</h4>
                            </div>
                            <div class="col-md-4">
                                @if ($why_choose_us->icon_1)
                                    <div class="image_box">
                                        <img src="{{ url('storage/images/whychooseus/icon/') }}/{{ @$why_choose_us->icon_1 }}"
                                            alt="">
                                    </div>
                                @endif
                                <label for="icon_1" class="form-label">Icon Image 1*</label>
                                <div class="input-group custom-file">
                                    <input class="form-control" type="file" id="icon_1" name="icon_1">
                                    <label class="input-group-text" for="icon_1">Browse</label>
                                    <label class="form-control d-flex justify-content-start align-items-center"
                                        for="icon_1">
                                        <span>Upload Icon</span>
                                        <div class=" text-dark ms-auto"></div>
                                    </label>
                                </div>
                                <span class="caption_note">Note: Image size must be 70 x 70</span>
                                @error('icon_1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 column_align">
                                <label class="form-label" for="icon_title_1">Icon Title 1*</label>
                                <input type="text" id="icon_title_1"
                                    value="{{ old('icon_title_1', isset($why_choose_us) ? $why_choose_us->icon_title_1 : '') }}"
                                    class="form-control" placeholder='alt="Title"' name="icon_title_1" />
                                @error('icon_title_1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 column_align">
                                <label class="form-label" for="icon_desc_1">Icon Description 1*</label>
                                <input type="text" id="icon_desc_1"
                                    value="{{ old('icon_desc_1', isset($why_choose_us) ? $why_choose_us->icon_desc_1 : '') }}"
                                    class="form-control" placeholder='alt="Title"' name="icon_desc_1" />
                                @error('icon_desc_1')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h4>Icon 2</h4>
                            </div>
                            <div class="col-md-4">
                                @if ($why_choose_us->icon_2)
                                    <div class="image_box">
                                        <img src="{{ url('storage/images/whychooseus/icon/') }}/{{ @$why_choose_us->icon_2 }}"
                                            alt="">
                                    </div>
                                @endif
                                <label for="icon_2" class="form-label">Icon Image 2*</label>
                                <div class="input-group custom-file">
                                    <input class="form-control" type="file" id="icon_2" name="icon_2">
                                    <label class="input-group-text" for="icon_2">Browse</label>
                                    <label class="form-control d-flex justify-content-start align-items-center"
                                        for="icon_2">
                                        <span>Upload Icon</span>
                                        <div class=" text-dark ms-auto"></div>
                                    </label>
                                </div>
                                <span class="caption_note">Note: Image size must be 70 x 70</span>
                                @error('icon_2')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 column_align">
                                <label class="form-label" for="icon_title_2">Icon Title 2*</label>
                                <input type="text" id="icon_title_2"
                                    value="{{ old('icon_title_2', isset($why_choose_us) ? $why_choose_us->icon_title_2 : '') }}"
                                    class="form-control" placeholder='alt="Title"' name="icon_title_2" />
                                @error('icon_title_2')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 column_align">
                                <label class="form-label" for="icon_desc_2">Icon Description 2*</label>
                                <input type="text" id="icon_desc_2"
                                    value="{{ old('icon_desc_2', isset($why_choose_us) ? $why_choose_us->icon_desc_2 : '') }}"
                                    class="form-control" placeholder='alt="Title"' name="icon_desc_2" />
                                @error('icon_desc_2')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-12">
                                <h4>Icon 3</h4>
                            </div>
                            <div class="col-md-4">
                                @if ($why_choose_us->icon_3)
                                    <div class="image_box">
                                        <img src="{{ url('storage/images/whychooseus/icon/') }}/{{ @$why_choose_us->icon_3 }}"
                                            alt="">
                                    </div>
                                @endif
                                <label for="icon_3" class="form-label">Icon Image 3*</label>
                                <div class="input-group custom-file">
                                    <input class="form-control" type="file" id="icon_3" name="icon_3">
                                    <label class="input-group-text" for="icon_3">Browse</label>
                                    <label class="form-control d-flex justify-content-start align-items-center"
                                        for="icon_3">
                                        <span>Upload Icon</span>
                                        <div class=" text-dark ms-auto"></div>
                                    </label>
                                </div>
                                <span class="caption_note">Note: Image size must be 70 x 70</span>
                                @error('icon_3')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 column_align">
                                <label class="form-label" for="icon_title_3">Icon Title 3*</label>
                                <input type="text" id="icon_title_3"
                                    value="{{ old('icon_title_3', isset($why_choose_us) ? $why_choose_us->icon_title_3 : '') }}"
                                    class="form-control" placeholder='alt="Title"' name="icon_title_3" />
                                @error('icon_title_3')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-4 column_align">
                                <label class="form-label" for="icon_desc_3">Icon Description 3*</label>
                                <input type="text" id="icon_desc_3"
                                    value="{{ old('icon_desc_3', isset($why_choose_us) ? $why_choose_us->icon_desc_3 : '') }}"
                                    class="form-control" placeholder='alt="Title"' name="icon_desc_3" />
                                @error('icon_desc_3')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-3">
                                <button type="button" name="submitButton" id="submitButton"
                                    class="btn btn-primary">Submit</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <!-- /FormValidation -->
    </div>
    </div>


@endsection

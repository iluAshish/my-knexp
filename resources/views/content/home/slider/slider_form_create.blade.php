@extends('layouts/layoutMaster')

@section('title', 'Sliders')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css')}}"/>
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
    <script src="{{ asset('js/home-slider.js') }}"></script>
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
        <span class="text-muted fw-light"><a href="{{url('admin/home/slider')}}">Slider </a>/</span></span> Create Slider
    </h4>
    <div class="row">
        <!-- FormValidation -->
        <div class="col-12">
          <div class="card">
            <h5 class="card-header">Create Slider</h5>
            <div class="card-body">
      
              <form method="POST" id="formValidationSliderCreate" action="{{ url('admin/home/slider/')}}" class="row g-3" enctype="multipart/form-data" >
      
                <!-- Account Details -->
                @csrf
                <div class="col-md-6">
                  <label class="form-label" for="title">Title*</label>
                  <input type="text" id="title" class="form-control" value="{{old('title',isset($slider)?$slider->title:'')}}" placeholder="Title" name="title" />
                  @error('title')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                  <label class="form-label" for="sub_title">Sub Title*</label>
                  <input type="text" id="sub_title" value="{{old('sub_title',isset($slider)?$slider->sub_title:'')}}" class="form-control" placeholder="Sub Title" name="sub_title" />
                  @error('sub_title')
                  <div class="text-danger">{{$message}}</div>
                  @enderror
                </div>
                <div class="col-md-6">
                    <label for="image" class="form-label">Slider Image*</label>
                    <input class="form-control" type="file" id="image" name="image">
                    <span class="caption_note">Note: Image size must be 1920 x 1149</span>
                    @error('image')
                    <div class="text-danger">{{$message}}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label" for="image_attribute">Image Attribute*</label>
                    <input type="text" id="image_attribute" value="{{old('image_attribute',isset($slider)?$slider->image_attribute:'')}}" class="form-control" placeholder='alt="Title"' name="image_attribute" />
                    @error('image_attribute')
                    <div class="text-danger">{{$message}}</div>
                    @enderror    
                </div>
      
                <div class="col-12">
                  <button type="button" name="submitButton" id="addButton" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
          </div>
        </div>
        <!-- /FormValidation -->
      </div>
    </div>
@endsection

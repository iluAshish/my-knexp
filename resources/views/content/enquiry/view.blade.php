@extends('layouts/layoutMaster')

@section('title', 'Site Information')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    {{-- <link rel="stylesheet" href="{{asset('assets/kartik-v-bootstrap/css/fileinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/kartik-v-bootstrap/themes/explorer-fas/theme.css')}}"> --}}
    <style>
        .form-group  input,.form-group textarea{
  border-radius: 0 !important;
  margin-top: 10px !important;
  margin-bottom: 10px !important;
  display:block;
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
    {{-- <script src="{{asset('assets/kartik-v-bootstrap/js/fileinput.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/kartik-v-bootstrap/themes/fas/theme.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/kartik-v-bootstrap/themes/explorer-fas/theme.js')}}" type="text/javascript"></script> --}}

@endsection

@section('page-script')
    <script src="{{ asset('js/site-settings.js') }}"></script>
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
    @php
    use App\Models\Service;
    use Carbon\Carbon;
    $services = service::where('id',$enquiry->service_id)->get()->first();
    @endphp
		<div class="container-fluid">
			<h4 class="py-3 mb-4">
				<span class="text-muted fw-light"></span><a href="{{route('enquiry.list')}}"> Enquiries List </a>/ View
			</h4>
			<div class="row">
		  		<div class="col-md-12">
		    		<div class="card card-primary card-tabs">
		      			<div class="card-header ">
		        			<ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
	                  		<li class="nav-item">
	                    		<a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Basic Informations</a>
	                  		</li>
		        			</ul>
		      			</div>
		      			<div class="card-body">
		        			<div class="tab-content" id="custom-tabs-one-tabContent">
		          				<div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
		            				<div class="post">
		              					<strong><i class="fas fa-user mr-1"></i> Name</strong>
												    <p class="text-muted">
												    	{{$enquiry->name}}
												    </p>
										    <hr>
					        				<strong><i class="fas fa-pencil-alt mr-1"></i> Email</strong>
					        				<p class="text-muted">{{$enquiry->email}}</p>
						        		<hr>
					        				<strong><i class="fas fa-phone mr-1"></i>Phone Number</strong>
					        				<p class="text-muted">{{$enquiry->phone}}</p>
						        		<hr>
					        				<strong><i class="fas fa-serivce mr-1"></i>Service</strong>
					        				<p class="text-muted">{{ @$services->title }}</p>
						        		<hr>
										<strong><i class="fas fa-comment-alt mr-1"></i> Message</strong>
					        				<p class="text-muted">{{$enquiry->message}}</p>
						        		<hr>
							        	@if($enquiry->reply!=NULL)
						        			<strong><i class="fas fa-reply mr-1"></i> Replay</strong>
						        			<p class="text-muted">{{$enquiry->reply}}</p>
						        		    <hr>
											@php

										    @endphp

										    <strong><i class="fas fa-reply mr-1"></i> Replay Date</strong>
						        			<p class="text-muted"> {{ Carbon::parse($enquiry->reply_date)->format('d-m-Y') }}</p>
											<hr>
                                        @endif
                                        <strong><i class="fa fa-address-book mr-1"></i>created_at</strong>
                                        <p class="text-muted"> {{ Carbon::parse($enquiry->created_at)->format('d-m-Y') }}</p>
                                        <hr>
		            				</div>
		          				</div>
		        			</div>
		      			</div>
		    		</div>
		  		</div>
			</div>
		</div>


@endsection

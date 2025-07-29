@php
    $customizerHidden = 'customizer-hide';
    $configData = Helper::appClasses();
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Reset Password Cover - Pages')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
    <style>
        .auth-illustration {
            object-fit: cover;
            height: 848px !important;
            width: 100%;
        }
    </style>
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/Bootstrap5.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/formvalidation/dist/js/plugins/AutoFocus.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
    <script>
        $(function() {
            @if (session('message'))
            @if (session('status'))
            toastr.success("{{ session('message') }}");
            @else
            toastr.error("{{ session('message') }}");
            @endif
            @endif
        });
    </script>
@endsection

@section('content')
    <div class="authentication-wrapper authentication-cover authentication-bg ">
        <div class="authentication-inner row">

            <!-- /Left Text -->
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <img src="{{ asset('assets/img/backgrounds/5.jpg') }}" alt="auth-login-cover" class="img-fluid auth-illustration">
            </div>
            <!-- /Left Text -->

            <!-- Reset Password -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-4 p-sm-5">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-4">
                        <a href="{{ url('/') }}" class="app-brand-link gap-2">
                            <img src="{{asset('/assets/img/branding/logo.png')}}">
                        </a>
                    </div>
                    <!-- /Logo -->
                    <h3 class="mb-1 fw-bold">Reset Password 🔒</h3>
                    <p class="mb-4">for <span class="fw-bold">
                            @isset($email)
                                {{ $email }}
                            @endisset
                        </span></p>
                    <form id="formAuthentication" class="mb-3" action="{{ route('reset.password') }}" method="POST">
                        @csrf
                        <input type="hidden" name="email"
                               value="@isset($email){{ $email }}@endisset">
                        <input type="hidden" name="token"
                               value="@isset($token){{ $token }}@endisset">
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">New Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                       aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                                @error('password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="confirm-password">Confirm Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="confirm-password" class="form-control" name="confirm-password"
                                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                       aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                                @error('confirm-password')
                                <div class="text-danger">{{ $message }}</div>
                                @enderror
                        </div>
                        <button class="btn btn-primary d-grid w-100 mb-3">
                            Set new password
                        </button>
                        <div class="text-center">
                            <a href="{{ route('loginform') }}">
                                <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                                Back to login
                            </a>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /Reset Password -->
        </div>
    </div>
@endsection

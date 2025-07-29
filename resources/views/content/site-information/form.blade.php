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
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    {{-- <link rel="stylesheet" href="{{asset('assets/kartik-v-bootstrap/css/fileinput.css')}}">
    <link rel="stylesheet" href="{{asset('assets/kartik-v-bootstrap/themes/explorer-fas/theme.css')}}"> --}}
    <style>
        .form-group  input,.form-group textarea{
  border-radius: 0 !important;
  margin-top: 10px !important;
  margin-bottom: 10px !important;
  display:block;
}
.with-errors{
    color: red;
}
    </style>
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
        <script>
            jQuery(document).ready(function() {
                $('#logo').bind('change', function() {
                    var filename = $(this).val().split('\\').pop();
                    console.log(filename);
                    $(this).closest('.custom-file').find('span').text(filename);
                });
                $('#dashboard_logo').bind('change', function() {
                    var filename = $(this).val().split('\\').pop();
                    console.log(filename);
                    $(this).closest('.custom-file').find('span').text(filename);
                });
                $('#footer_logo').bind('change', function() {
                    var filename = $(this).val().split('\\').pop();
                    console.log(filename);
                    $(this).closest('.custom-file').find('span').text(filename);
                });
            });
        </script>
@endsection
@section('content')
    <h4 class="py-3 mb-4">
        <span class="text-muted fw-light"></span> Site Settings
    </h4>
    <div class="row">
        <!-- FormValidation -->
        <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form method="POST" id="formValidationSiteSetting"
                        action="{{ route('siteinformation.update', ['siteinformation' => $siteInformation->id]) }}"
                        class="row g-3" enctype="multipart/form-data">

                        <!-- Account Details -->
                        @csrf

                        @method('PUT')
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="brand_name">Brand Name*</label>
                                <input type="text" name="brand_name" id="brand_name" class="form-control required"
                                    placeholder="Brand Name" maxlength="230"
                                    value="{{ old('brand_name', @$siteInformation->brand_name) }}">
                                <div class="help-block with-errors" id="brand_name_error"></div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="email_recipient">Admin Email*</label>
                                <input type="text" name="email_recipient" id="email_recipient" class="form-control"
                                    placeholder="Admin Email" maxlength="230"
                                    value="{{ old('email_recipient', @$siteInformation->email_recipient) }}">
                                <div class="help-block with-errors" id="email_recipient_error"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="email">Email*</label>
                                <input type="text" name="email" id="email" class="form-control required"
                                    placeholder="Email" maxlength="230"
                                    value="{{ old('email', @$siteInformation->email) }}">
                                <div class="help-block with-errors" id="email_error"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="alternate_email">Alternate Email</label>
                                <input type="text" name="alternate_email" id="alternate_email" class="form-control"
                                    placeholder="Alternate Email" maxlength="230"
                                    value="{{ old('alternate_email', @$siteInformation->alternate_email) }}">
                                <div class="help-block with-errors" id="alternate_email_error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-4">
                                <label for="phone">Phone*</label>
                                <input type="text" name="phone" id="phone" class="form-control" placeholder="Phone"
                                    maxlength="230" value="{{ old('phone', @$siteInformation->phone) }}">
                                <div class="help-block with-errors" id="phone_error"></div>
                            </div>
                            <div class="form-group col-md-4">
                                <label for="landline">Phone 2</label>
                                <input type="text" name="landline" id="landline" class="form-control required"
                                    placeholder="Phone 2" maxlength="230"
                                    value="{{ old('landline', @$siteInformation->landline) }}">
                                <div class="help-block with-errors" id="landline_error"></div>
                            </div>

                            <div class="form-group col-md-4">
                                <label for="whatsapp_number">Whatsapp Number*</label>
                                <input type="text" name="whatsapp_number" id="whatsapp_number"
                                    class="form-control required" placeholder="Whatsapp Number" maxlength="230"
                                    value="{{ old('whatsapp_number', @$siteInformation->whatsapp_number) }}">
                                <div class="help-block with-errors" id="whatsapp_number_error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="logo"> Logo*</label>
                                @if ($siteInformation->logo_webp)
                                <div class="image_box">
                                    <img src="{{url('storage/site_information/logo/').'/'.$siteInformation->logo_webp}}" width="50px" alt="image">
                                </div>
                                @endif
                                <div class="input-group custom-file">
                                    <input id="logo" name="logo" class="form-control" type="file" accept="image/*">
                                    <label class="input-group-text" for="logo">Browse</label>
                                    <label class="form-control d-flex justify-content-start align-items-center"
                                        for="logo">
                                        <span>Upload Image</span>
                                        <div class=" text-dark ms-auto"></div>
                                    </label>
                                </div>
                                <span class="caption_note">Note: Image size must be 100 X 128 size will be no more than
                                    100KB</span>
                            </div>
                            <div class="form-group col-md-6 column_align">
                                <label for="logo_meta_tag"> Logo Attribute *</label>
                                <input type="text" id="logo_attribute" name="logo_attribute" class="form-control required placeholder-cls" placeholder="Alt='Logo Attribute'"
                                    maxlength="230"
                                    value="{{ old('logo_attribute', @$siteInformation->logo_attribute) }}">
                                <div class="help-block with-errors" id="logo_attribute_error"></div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="dashboard_logo"> Dashboard Logo*</label>
                                @if ($siteInformation->dashboard_logo)
                                <div class="image_box">
                                    <img src="{{url('storage/site_information/dashboard_logo/').'/'.$siteInformation->dashboard_logo}}" width="50px" alt="image">
                                </div>
                                @endif
                                <div class="input-group custom-file">
                                    <input id="dashboard_logo" name="dashboard_logo" type="file" class="form-control" accept="image/*">
                                    <label class="input-group-text" for="dashboard_logo">Browse</label>
                                    <label class="form-control d-flex justify-content-start align-items-center"
                                        for="dashboard_logo">
                                        <span>Upload Image</span>
                                        <div class=" text-dark ms-auto"></div>
                                    </label>
                                </div>
                                <span class="caption_note">Note: Image size must be 100 X 128 size will be no more than
                                    100KB</span>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="footer_logo">Footer Logo*</label>
                                @if ($siteInformation->footer_logo_webp)
                                <div class="image_box">
                                    <img src="{{url('storage/site_information/footer_logo/').'/'.$siteInformation->footer_logo_webp}}" width="50px" alt="image">
                                </div>
                                @endif

                                <div class="input-group custom-file">
                                    <input id="footer_logo" name="footer_logo" type="file" class="form-control" accept="image/*">
                                    <label class="input-group-text" for="footer_logo">Browse</label>
                                    <label class="form-control d-flex justify-content-start align-items-center"
                                        for="footer_logo">
                                        <span>Upload Image</span>
                                        <div class=" text-dark ms-auto"></div>
                                    </label>
                                </div>
                                <span class="caption_note">Note: Image size must be 150 X 273 size will be no more than
                                    100KB</span>
                            </div>
                            <div class="form-group col-md-6 column_align">
                                <label for="footer_logo_attribute">Footer Logo Attribute *</label>
                                <input type="text" id="footer_logo_attribute" name="footer_logo_attribute"
                                    class="form-control required placeholder-cls" placeholder="Alt='Logo Attribute'"
                                    maxlength="230"
                                    value="{{ old('footer_logo_attribute', @$siteInformation->footer_logo_attribute) }}">
                                <div class="help-block with-errors" id="footer_logo_attribute_error"></div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6">
                                <label for="working_hours" class="form-label">Working Hours</label>

                                <input type="hidden" name="working_hours" id="working_hours"
                                    value="{{ old('working_hours', isset($siteInformation) ? $siteInformation->working_hours : '') }}">
                                <div class="form-control" type="text" id="full-editor-1" placeholder='type..'></div>
                                @error('working_hours')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group col-md-6">
                                <label for="address">Address</label>
                                <textarea name="address" id="address" placeholder="Address" class="form-control tinyeditor"
                                    autocomplete="off">{{ old('address', @$siteInformation->address) }}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label> Facebook</label>
                                <input type="text" name="facebook_url" id="facebook_url" class="form-control"
                                    placeholder="Facebook"
                                    value="{{ old('facebook_url', @$siteInformation->facebook_url) }}" maxlength="230">
                            </div>
                            <div class="form-group col-md-4">
                                <label> Instagram</label>
                                <input type="text" name="instagram_url" id="instagram_url" class="form-control"
                                    placeholder="Instagram"
                                    value="{{ old('instagram_url', @$siteInformation->instagram_url) }}" maxlength="230">
                            </div>
                            <div class="form-group col-md-4">
                                <label> Twitter</label>
                                <input type="text" name="twitter_url" id="twitter_url" class="form-control"
                                    placeholder="Twitter"
                                    value="{{ old('twitter_url', @$siteInformation->twitter_url) }}" maxlength="230">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label> Linkedin</label>
                                <input type="text" name="linkedin_url" id="linkedin_url" class="form-control"
                                    placeholder="Linkedin"
                                    value="{{ old('linkedin_url', @$siteInformation->linkedin_url) }}" maxlength="230">
                            </div>
                            <div class="form-group col-md-4">
                                <label> Youtube</label>
                                <input type="text" name="youtube_url" id="youtube_url" class="form-control"
                                    placeholder="Youtube"
                                    value="{{ old('youtube_url', @$siteInformation->youtube_url) }}" maxlength="230">
                            </div>
                            <div class="form-group col-md-4">
                                <label> Pinterest</label>
                                <input type="text" name="pinterest_url" id="pinterest_url" class="form-control"
                                    placeholder="Pinterest"
                                    value="{{ old('pinterest_url', @$siteInformation->pinterest_url) }}" maxlength="230">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-4">
                                <label> Snapchat</label>
                                <input type="text" name="snapchat_url" id="snapchat_url" class="form-control"
                                    placeholder="Snapchat"
                                    value="{{ old('snapchat_url', @$siteInformation->snapchat_url) }}" maxlength="230">
                            </div>
                            <div class="form-group col-md-4">
                                <label>Tiktok</label>
                                <input type="text" name="tiktok_url" id="tiktok_url" class="form-control"
                                    placeholder="Tiktok" value="{{ old('tiktok_url', @$siteInformation->tiktok_url) }}"
                                    maxlength="230">
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="footer_text">Footer Text</label>
                                <textarea name="footer_text" id="footer_text" rows="6" cols="30" placeholder="Footer Text" class="form-control tinyeditor"
                                    autocomplete="off">{{ old('footer_text', @$siteInformation->footer_text) }}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="header_tag">Header Tag</label>
                                <textarea name="header_tag" id="header_tag" rows="6" cols="30" placeholder="Header Tag" class="form-control tinyeditor"
                                    autocomplete="off">{{ old('header_tag', @$siteInformation->header_tag) }}</textarea>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="footer_tag">Footer Tag</label>
                                <textarea name="footer_tag" id="footer_tag" rows="6" cols="30" placeholder="Footer Tag" class="form-control tinyeditor"
                                    autocomplete="off">{{ old('footer_tag', @$siteInformation->footer_tag) }}</textarea>
                            </div>

                            <div class="form-group col-md-6">
                                <label for="body_tag">Body Tag</label>
                                <textarea name="body_tag" id="body_tag" rows="6" cols="30" placeholder="Body Tag" class="form-control tinyeditor"
                                    autocomplete="off">{{ old('body_tag', @$siteInformation->body_tag) }}</textarea>
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
    </div>
    @section('page-script')
    <script type="text/javascript">
        $(document).ready(function () {

            $("#logo").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                initialPreviewShowDelete: false,
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: true,
                allowedFileTypes: ['image'],
                minImageWidth: 130,
                minImageHeight: 100,
                maxImageWidth: 130,
                maxImageHeight: 100,
                maxFileSize: 100,
                showRemove: true,
                @if(isset($siteInformation) && $siteInformation->logo!=NULL)
                initialPreview: ["{{asset($siteInformation->logo)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$siteInformation->logo))}}",
                    width: "120px",
                    key: "{{'SiteInformation/logo/'.$siteInformation->id.'/logo_webp' }}",
                }]
                @endif
            });
            $("#dashboard_logo").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                initialPreviewShowDelete: false,
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: true,
                allowedFileTypes: ['image'],
                minImageWidth: 203,
                minImageHeight: 156,
                maxImageWidth: 203,
                maxImageHeight: 156,
                maxFileSize: 100,
                showRemove: true,
                @if(isset($siteInformation) && $siteInformation->dashboard_logo!=NULL)
                initialPreview: ["{{asset($siteInformation->dashboard_logo)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$siteInformation->dashboard_logo))}}",
                    width: "120px",
                    key: "{{'SiteInformation/dashboard_logo/'.$siteInformation->id.'/dashboard_logo_webp' }}",
                }]
                @endif
            });

            $("#footer_logo").fileinput({
                'theme': 'explorer-fas',
                validateInitialCount: true,
                overwriteInitial: false,
                autoReplace: true,
                initialPreviewShowDelete: false,
                initialPreviewAsData: true,
                dropZoneEnabled: false,
                required: false,
                allowedFileTypes: ['image'],
                minImageWidth: 203,
                minImageHeight: 156,
                maxImageWidth: 203,
                maxImageHeight: 156,
                maxFileSize: 100,
                showRemove: true,
                @if(isset($siteInformation) && $siteInformation->footer_logo!=NULL)
                initialPreview: ["{{asset($siteInformation->footer_logo)}}",],
                initialPreviewConfig: [{
                    caption: "{{last(explode('/',$siteInformation->footer_logo))}}",
                    width: "120px",
                    key: "{{'SiteInformation/footer_logo/'.$siteInformation->id.'/footer_logo_webp' }}",
                }]
                @endif
            });


        });
    </script>
    @endsection
@endsection

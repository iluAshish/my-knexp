@extends('layouts/layoutMaster')

@section('title', 'Key Feature List')

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
    <script>
        var base_url = '<?php echo config('app.url'); ?>';

    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
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
    <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
            <h5 class="card-title mb-0">Manager Key Feature List</h5>
            {{-- <a type="button" href="{{ url('admin/home/keyfeature/create') }}" class="btn btn-primary">Add New Key
                Feature</a> --}}
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-users table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Image</th>
                        <th>TITLE</th>
                        <th>SORT ORDER </th>
                        {{-- <th>STATUS</th> --}}
                        <th>CREATED DATE </th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($keyfeatures as $keyfeature)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td><img src="{{url('storage/images/keyfeature').'/'.$keyfeature->image_webp}}" width="50px" alt="image"></td>
                            <td>{!! $keyfeature->title !!}</td>
                            <td>
                                <input type="text" name="sort_order" id="sort_order_{{ $loop->iteration }}"
                                    data-extra="id" data-extra_key="{{ $keyfeature->id }}" data-table="keyFeature"
                                    data-id="{{ $keyfeature->id }}" class="form-control common_sort_order"
                                    style="width:25%" value="{{ $keyfeature->sort_order }}" maxlength="2">
                            </td>
                            {{-- <td>
                                <label class="switch switch-primary">
                                    <input id="switch-state" type="checkbox" class="switch-input status_check"
                                        data-size="mini" data-url="/status-change" data-table="keyFeature"
                                        data-field="status" data-pk="{{ $keyfeature->id }}"
                                        {{ $keyfeature->status == '1' ? 'checked' : '' }}>
                                    <span class="switch-toggle-slider">
                                        <span class="switch-on"></span>
                                        <span class="switch-off"></span>
                                    </span>
                                </label>
                            </td> --}}
                            <td>{{ date('d-M-Y', strtotime($keyfeature->created_at)) }}</td>
                            <td class="text-right py-0 align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ url('admin/home/keyfeature/' . $keyfeature->id . '/edit') }}"
                                        class="btn btn-success mr-2 tooltips" title="Edit Key Feature"><i
                                            class="fas fa-edit"></i></a>
                                    {{-- <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                        title="Delete Key Feature" data-url="admin/home/keyfeature/"
                                        data-id="{{ $keyfeature->id }}"><i class="fas fa-trash"></i></a> --}}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection

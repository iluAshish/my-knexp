@extends('layouts/layoutMaster')

@section('title', 'Edit Day')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}" />
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script> --}}
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
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
    <script src="{{ asset('/js/day-validation.js') }}"></script>
@endsection

@section('content')

    <div class="container">
        <div class="row">
            <h4 class="py-3 mb-4">
                <span class="text-muted fw-light"><a href="{{ route('day.list') }}">Days</a> / Edit</span>
            </h4>
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Update Day</h5>
                </div>
                <div class="card-body">

                    <form class="add-new-user pt-0 needs-validation" id="addNewDayForm"
                        action="{{ route('day.update', ['day' => $day->id]) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="week_dates" class="form-label">Days</label>
                                <select id="week_days" name="week_days" class="form-select select2" data-allow-clear="true">
                                    @foreach ($daysArray as $key => $days)
                                    <option value="{{ $key }}" {{ $day->week_days == $key   ? 'selected="selected"' : '' }} day="{{ $day->week_days }}">{{ $days }}</option>
                                    @endforeach
                                </select>
                            @error('week_dates')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>
                        <button class="btn btn-primary" id="submitButton">Submit</button>
                        <button type="reset" class="btn btn-secondary me-3">Reset</button>
                        <a href="{{route('day.list')}}" class="btn btn-danger me-3">Back</a>

                    </form>

                </div>
            </div>
        </div>
    </div>



@endsection

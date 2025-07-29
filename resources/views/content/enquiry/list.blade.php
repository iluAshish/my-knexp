@extends('layouts/layoutMaster')

@section('title', 'Enquiries')

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
        .dt-buttons.btn-group.flex-wrap {
            display: block;
            text-align: right;
        }

        .card-datatable.table-responsive {
            padding: 10px;
        }
    </style>
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
        // function showSweetAlert() {
        //     Swal.fire({
        //         title: 'Demo SweetAlert',
        //         text: 'This is a demo of SweetAlert!',
        //         icon: 'success',
        //         confirmButtonText: 'OK'
        //     });
        // }
    </script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/enquires.js') }}"></script>
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
            
            $(document).on('click', '.close_modal', function() {
                $('#replay-modal').modal('hide');
            });
            $(document).on('click', '.replay_modal', function() {
                var request = $(this).data('request');
                var id = $(this).data('id');
                var replay = $(this).data('replay');
                $('#replay-modal').modal('show');
                $('#request_details').html('');
                $('#request_details').html(request);
                console.log(replay);
                if (replay == '') {
                    console.log(replay, '---');
                    $('#id').val(id);
                    $('#xtareareply').html('');
                    $('#replay_to_contact').show();
                } else {
                    console.log(replay, '---1');
                    $('#xtareareply').val(replay);
                    $('#replay_to_contact').hide();
                }
            });
            $(document).on('click', '#replay_to_senquiry', function(e) {

                e.preventDefault();
                var url = $('#url').val();
                $('#replay_to_senquiry').val('Please Wait..!');
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: $('#formWizard').serialize()+"&_token={{ csrf_token() }}",
                    url: base_url + '/admin/enquiries/' + url,
                    success: function(response) {
                        $('#replay_to_senquiry').val('Update Replay');
                        if (response.status == true) {

                            if (response.message == 'Already sent reply') {
                                Swal.fire({
                                    icon: 'info',
                                    title: "Not Sent",
                                    text: response.message,
                                    type: "info"
                                }, function() {
                                    $('#replay-modal').modal('hide');
                                    location.reload();
                                });

                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: "Success",
                                    text: response.message,
                                    type: "success"
                                }, function() {
                                    $('#replay-modal').modal('hide');
                                    location.reload();
                                });
                                //   Swal.fire('Error !', response.message, 'error');
                            }
                        } else {
                            if (response.message == 'Already sent reply') {
                                Swal.fire({
                                    icon: 'info',
                                    title: "Not Sent",
                                    text: response.message,
                                    type: "info"
                                }, function() {
                                    $('#replay-modal').modal('hide');
                                    location.reload();
                                });

                            } else {
                                Swal.fire('Error !', response.message, 'error');
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {

                    }
                });
            });
        });
    </script>

@endsection

@section('content')
    <div class="card">
        <div class="card-header d-flex justify-content-between mb-3">
            <h5 class="card-title mb-0">Manager Enquiries</h5>
        </div>
        @php
            use App\Models\Service;
        @endphp
        <div class="card-datatable table-responsive">
            <table class="datatables-enquiries table">
                <thead class="border-top">
                    <tr>
                        <th>.</th>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email </th>
                        <th>Phone</th>
                        <th>Service </th>
                        <th>CREATED DATE </th>
                        <th>ACTIONS</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($enquiries as $enquiry)
                        @php
                            $services = service::where('id', $enquiry->service_id)
                                ->get()
                                ->first();
                        @endphp
                        <tr>
                            <td><input type="checkbox" class="select-checkbox"></td>
                            <td>{{ $loop->iteration }}</td>
                            {{-- <td>{!! $enquiry->title !!}</td> --}}
                            <td>{{ $enquiry->name }}</td>
                            <td>{{ $enquiry->email }}</td>
                            <td>{{ $enquiry->phone }}</td>
                            <td>{{ @$services->title }}</td>
                            <td>{{ date('d-M-Y', strtotime($enquiry->created_at)) }}</td>
                            <td class="text-right py-0 align-middle">
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('enquiry.show', ['enquiry' => $enquiry->id]) }}"
                                        class="btn btn-success mr-2 tooltips" title="View Enquiry Enquiry"><i
                                            class="fas fa-eye"></i></a>
                                    <a href="#" class="btn btn-danger mr-2 delete_entry tooltips"
                                        title="Delete Enquiry" data-url="admin/enquiry/" data-id="{{ $enquiry->id }}"><i
                                            class="fas fa-trash"></i></a>

                                    <a class="btn btn-success mr-2 replay_modal" title="Replay Enquiry"
                                        href="javascript:void(0)" data-url="admin/enquiries/replay_to_quote"
                                        data-toggle="modal" data-replay="{{ $enquiry->reply }}"
                                        data-id="{{ $enquiry->id }}" data-request="{{ $enquiry->email }}"><i
                                            class="fa fa-reply fa-lg" style="color:red"></i></a>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>


            <!-- Shipments List Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Shipments</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-enquiries table">
                <thead class="border-top">
                <tr>
                    <th></th>
                    <th>Id</th>
                    <th>Order Number</th>
                    <th>Shipment Date</th>
                    <th>Status</th>
                    <th>Date Time</th>
                    <th>Actions</th>
                </tr>
                </thead>
            </table>
        </div>

    </div>

    </div>

    <div class="modal fade" id="replay-modal" aria-modal="true" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <form role="form" method="post" id="formWizard" class="quote_replay_form">
                    <div class="modal-header">
                        <h4 class="modal-title">Request Reply</h4>
                    </div>
                    <div class="modal-body">
                        @csrf
                        <div class="box-body">
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Request*</label>
                                        <textarea disabled="" id="request_details" class="form-control"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label> Reply*</label>
                                        <textarea class="form-control reply" id="xtareareply" name="replay" placeholder="Reply to request"></textarea>
                                    </div>
                                    <div class="help-block with-errors descc" id="reply_error"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="form-group">
                            <button type="button" class="btn btn-default pull-left close_modal" data-dismiss="modal">Close
                            </button>
                            <button class="btn btn-primary subm valon" id="replay_to_senquiry" type="button">Update
                                Reply</button>
                            <input type="hidden" id="url" name="url" value="enquiryreply">
                            <input type="hidden" id="id" name="id" value="">
                        </div>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection

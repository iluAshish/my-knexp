@extends('layouts/layoutMaster')

@section('title', 'Enquiry')

@section('vendor-style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}"/>
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/toastr/toastr.css') }}"/>
    <style>
        .hideme{
            pointer-events:all;
            display: none;
        }
        .replay_modal{
            cursor: pointer;
        }
    </style>
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/moment/moment.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/toastr/toastr.js') }}"></script>
@endsection

@section('page-script')
    <script>
        const getPermissions = @json(auth()->user()->roles);
        const getDirectPermissions = @json(auth()->user()->permissions);
        const userRole = getDirectPermissions.length ? 'super-admin' : getPermissions[0].name;
        const userPermissions = getDirectPermissions.length ? [] : getPermissions[0].permissions;

        function hasPermission(permissionName) {
            if (userRole === 'super-admin') {
                return true;
            }

            return userPermissions.some(permission => permission.name === permissionName);
        }


    </script>
    <script src="{{ asset('js/enquiries.js') }}"></script>
    <script>
        $(function () {
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
        $(document).on('click', '.close_modal', function() {
                $('#replay-modal').modal('hide');
                $('#xtareareply').prop('disabled',false);
            });
            $(document).on('click', '.replay_modal', function() {
                var request = $(this).data('request');
                var id = $(this).data('id');
                var reply = $(this).data('reply');
                $('#replay-modal').modal('show');
                $('#request_details').html('');
                $('#request_details').html(request);
                console.log(id,reply);
                if (reply == '') {
                    console.log(reply, '---');
                    $('#id').val(id);
                    $('#xtareareply').html('');
                    $('#replay_to_contact').show();
                } else {
                    console.log(reply, '---1',id);
                    $('#xtareareply').val(reply);
                    $('#id').val(id);
                    $('#replay_to_contact').hide();
                }
            });
            $(document).on('click', '#replay_to_senquiry', function(e) {

                e.preventDefault();
                var url = $('#url').val();
                console.log(url);
                $('#replay_to_senquiry').val('Please Wait..!');
                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    data: $('#formWizard').serialize()+"&_token={{ csrf_token() }}",
                    url: "{{ route('enquiry.replay') }}",
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
                                    window.location.href = baseUrl + 'admin/enquiries/';
                                });

                            } else {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Updated!',
                                    text: response.message,
                                    customClass: {
                                        confirmButton: 'btn btn-success'
                                    }
                                });
                                setTimeout(() => {
                                    $('#replay-modal').modal('hide');
                                    window.location.href = baseUrl + 'admin/enquiries/';
                                }, 2000);
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
                                    window.location.href = baseUrl + 'admin/enquiries/';
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
    </script>
@endsection

@section('content')

    <!-- Shipments List Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="card-title mb-0">Enquiries</h5>
        </div>
        <div class="card-datatable table-responsive">
            <table class="datatables-enquiries table">
                <thead class="border-top">
                    <tr>
                        <th></th>
                        <th>Id</th>
                        <th>Enquiry Number</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Service</th>
                        <th>Enquiry Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
            </table>
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
                            <input type="hidden" id="url" name="url" value="enquiryReply">
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

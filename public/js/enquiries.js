(function webpackUniversalModuleDefinition(root, factory) {
    if (typeof exports === 'object' && typeof module === 'object') module.exports = factory();
    else if (typeof define === 'function' && define.amd) define([], factory);
    else {
        var a = factory();
        for (var i in a) (typeof exports === 'object' ? exports : root)[i] = a[i];
    }
})(self, function () {
    return (function () {
        'use strict';
        var __webpack_exports__ = {};

        $(function () {
            var dt_user_table = $('.datatables-enquiries'),
                enquiryView = baseUrl + 'admin/enquiry/',
                select2 = $('.select2');

            if (select2.length) {
                var $this = select2;
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Select Country',
                    dropdownParent: $this.parent()
                });
            }

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            if (dt_user_table.length) {
                var dt_user = dt_user_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: baseUrl + 'admin/enquiry'
                    },
                    columns: [
                        {
                            data: ''
                        },
                        {
                            data: 'fake_id'
                        },
                        {
                            data: 'order_number'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'service_id'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'action'
                        }
                    ],
                    columnDefs: [
                        {
                            className: 'control',
                            searchable: false,
                            orderable: false,
                            responsivePriority: 2,
                            targets: 0,
                            render: function render(data, type, full, meta) {
                                return '';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 1,
                            render: function render(data, type, full, meta) {
                                return '<input type="checkbox" class="dt-checkboxes form-check-input enquiries" name="shipment[]" value="' + full.id + '">';

                            },
                            checkboxes: {
                                selectAllRender: '<input type="checkbox" class="form-check-input">'
                            }
                        },
                        {
                            targets: 2,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.order_number + '</span>';
                            }
                        },
                        {
                            targets: 3,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.name + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 4,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.email + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 5,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.service_id + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 6,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.created_at + '</span>';
                            }
                        },
                        {
                            // Actions
                            targets: -1,
                            title: 'Actions',
                            searchable: false,
                            orderable: false,
                            render: function render(data, type, full, meta) {
                                console.log(full);
                                return (
                                    '<div class="d-inline-block text-nowrap">' +
                                    (hasPermission('shipment.destroy')
                                        ? '<button class="btn btn-sm btn-icon delete-record" title="Delete" data-id="' +
                                        full.id +
                                        '"><i class="ti ti-trash"></i></button>'
                                        : '') +
                                    '<a title="View" href="' +
                                    enquiryView +
                                    full.id +
                                    '" class="ti ti-eye mx-2 ti-sm"></a>' +
                                    '<a title="Message" class="replay_modal ' + ((full.reply === null) ? '' : 'hideme') + '"  data-url="admin/enquiries/enquiryReply"' +
                                    'data-toggle="modal" data-reply="' + full.reply + '" data-id="' + full.id + '"' +
                                    ' data-request="' + full.email + '">' +
                                    '<i class="ti ti-message"><i></a>' +

                                    '</div>'
                                );

                            }
                        }
                    ],
                    order: [[0, 'DESC']],
                    dom:
                        '<"row mx-2"' +
                        '<"col-md-2"<"me-3"l>>' +
                        '<"col-md-10"<"dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0"fB>>' +
                        '>t' +
                        '<"row mx-2"' +
                        '<"col-sm-12 col-md-6"i>' +
                        '<"col-sm-12 col-md-6"p>' +
                        '>',
                    language: {
                        sLengthMenu: '_MENU_',
                        search: '',
                        searchPlaceholder: 'Search..'
                    },
                    buttons: [
                        {
                            extend: 'collection',
                            className: 'btn btn-label-primary dropdown-toggle mx-3',
                            text: '<i class="ti ti-logout rotate-n90 me-2"></i>Export',
                            buttons: [
                                {
                                    extend: 'csv',
                                    title: 'Enquires',
                                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [2, 3, 4, 5, 6]
                                    }
                                },
                                {
                                    extend: 'excel',
                                    title: 'Enquires',
                                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                    className: 'dropdown-item',
                                    exportOptions: {
                                        columns: [2, 3, 4, 5, 6]
                                    }
                                }
                            ]
                        },
                        {
                            text: '<i class="ti ti-trash me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Delete</span>',
                            className: 'btn btn-danger delete-records'
                        }
                    ],
                    // For responsive popup
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function header(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['name'];
                                }
                            }),
                            type: 'column',
                            renderer: function renderer(api, rowIdx, columns) {
                                var data = $.map(columns, function (col, i) {
                                    return col.title !== '' // ? Do not show row in modal popup if title is blank (for check box)
                                        ? '<tr data-dt-row="' +
                                        col.rowIndex +
                                        '" data-dt-column="' +
                                        col.columnIndex +
                                        '">' +
                                        '<td>' +
                                        col.title +
                                        ':' +
                                        '</td> ' +
                                        '<td>' +
                                        col.data +
                                        '</td>' +
                                        '</tr>'
                                        : '';
                                }).join('');
                                return data ? $('<table class="table"/><tbody />').append(data) : false;
                            }
                        }
                    }
                });
            }

            // Status
            dt_user_table.on('click', '.change-status', function (e) {
                e.preventDefault();
                let orderId = $(this).attr('data-id');

                let orderStatus = $(this).attr('data-status');

                $("#shipment_id").val(orderId);
                $("#order_status").val(orderStatus);
                // $("#order_status").select2();
                $("#statusModal").modal('show');
            });
            $(".close-modal").click(function () {
                $("#statusModal").modal('hide');
            });

            // Delete Record
            $(document).on('click', '.delete-records', function () {

                console.log($(".enquiries").length)
                let enquiryIds_new = [];
                $(".enquiries").each(function (index) {
                    if ($(this).prop('checked')) {
                        enquiryIds_new[index] = $(this).val();
                    }
                });

                console.log(enquiryIds_new);
                var active = false;
                if (enquiryIds_new.length) {
                    active = true;
                } else {
                    Swal.fire({
                        title: 'Please Select Enquiry!',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ok!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        },
                        buttonsStyling: false
                    }).then(function (result) {
                        active = false;
                    });
                }
                if (active) {
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Yes, delete it!',
                        customClass: {
                            confirmButton: 'btn btn-primary me-3',
                            cancelButton: 'btn btn-label-secondary'
                        },
                        buttonsStyling: false
                    }).then(function (result) {
                        if (result.value) {
                            let enquiryIds = [];
                            $(".enquiries").each(function (index) {
                                if ($(this).prop('checked')) {
                                    enquiryIds[index] = $(this).val();
                                }
                            });
                            // delete the data
                            $.ajax({
                                type: 'POST',
                                url: baseUrl + 'admin/enquiry/bulk-delete',
                                data: {
                                    "enquiry_ids": enquiryIds,
                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function success(response) {

                                    if (response.status) {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Deleted!',
                                            text: response.message,
                                            customClass: {
                                                confirmButton: 'btn btn-success'
                                            }
                                        });
                                    } else {
                                        Swal.fire({
                                            icon: 'error',
                                            title: 'Delete!',
                                            text: response.message,
                                            customClass: {
                                                confirmButton: 'btn btn-success'
                                            }
                                        });
                                    }
                                    dt_user.draw();
                                },
                                error: function error(_error) {
                                    console.log(_error);
                                }
                            });

                        }
                    });
                }
            });

            $(document).on('click', '.delete-record', function () {
                var shipment_id = $(this).data('id'),
                    dtrModal = $('.dtr-bs-modal.show');

                // hide responsive modal in small screen
                if (dtrModal.length) {
                    dtrModal.modal('hide');
                }

                // sweetalert for confirmation of delete
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                    customClass: {
                        confirmButton: 'btn btn-primary me-3',
                        cancelButton: 'btn btn-label-secondary'
                    },
                    buttonsStyling: false
                }).then(function (result) {
                    if (result.value) {
                        // delete the data
                        $.ajax({
                            type: 'DELETE',
                            url: baseUrl + `admin/enquiry/${shipment_id}`,
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function success(response) {

                                if (response.status) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Deleted!',
                                        text: response.message,
                                        customClass: {
                                            confirmButton: 'btn btn-success'
                                        }
                                    });
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Delete!',
                                        text: response.message,
                                        customClass: {
                                            confirmButton: 'btn btn-success'
                                        }
                                    });
                                }
                                dt_user.draw();
                            },
                            error: function error(_error) {
                                console.log(_error);
                            }
                        });

                    }
                });
            });

            $(document).on('click', '.create-record', function () {
                window.location.href = baseUrl + 'admin/enquiry/create';
            });
            // edit record
            $(document).on('click', '.edit-record', function () {
                var shipment_id = $(this).data('id');
                window.location.href = baseUrl + 'admin/enquiry/' + shipment_id + '/edit';
            });
        });
        /******/
        return __webpack_exports__;
        /******/
    })();
});

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
            var dt_user_table = $('.datatables-orders'),
                select2 = $('.select2'),
                userView = baseUrl + 'admin/order/',
                offCanvasForm = $('#offcanvasAddUser');
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
                        url: baseUrl + 'admin/order'
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
                            data: 'first_name'
                        },
                        {
                            data: 'customer_email'
                        },
                        {
                            data: 'customer_phone'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'origin'
                        },
                        {
                            data: 'destination'
                        },
                        {
                            data: 'shipment_date'
                        },
                        {
                            data: 'updated_by'
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
                                return '<span>' + full.fake_id + '</span>';
                            }
                        },
                        {
                            targets: 2,
                            render: function render(data, type, full, meta) {
                                return '<span class="badge bg-label-primary me-1">' + full.order_number + '</span>';
                            }
                        },
                        {
                            targets: 3,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.first_name + '</span>';
                            }
                        },
                        {
                            targets: 4,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.customer_email + '</span>';
                            }
                        },
                        {
                            targets: 5,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.customer_phone + '</span>';
                            }
                        },
                        {
                            targets: 6,
                            render: function render(data, type, full, meta) {
                                const badge = statusLabels[full.status] || '<span>' + full.status + '</span>';
                                return badge;
                                return hasPermission('order.updateshipmentstatus')
                                    ? badge + '<a href="#" class="change-status" data-status="' + full.status + '" data-id="' + full.id + '"><i class="ti ti-edit"></i></a>'
                                    : badge;
                            }
                        },
                        {
                            targets: 7,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.origin + '</span>';
                            }
                        },
                        {
                            targets: 8,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.destination + '</span>';
                            }
                        },
                        {
                            targets: 9,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.shipment_date + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 10,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.updated_by + '</span>';
                            }
                        },
                        {
                            // Actions
                            targets: -1,
                            title: 'Actions',
                            searchable: false,
                            orderable: false,
                            render: function render(data, type, full, meta) {
                                return (
                                    '<div class="d-inline-block text-nowrap">' +
                                    (hasPermission('order.edit')
                                        ? '<button class="btn btn-sm btn-icon edit-record" data-id="' +
                                        full.id +
                                        '"><i class="ti ti-edit"></i></button>'
                                        : '') +
                                    (hasPermission('order.destroy')
                                        ? '<button class="btn btn-sm btn-icon delete-record" data-id="' +
                                        full.id +
                                        '"><i class="ti ti-trash"></i></button>'
                                        : '') +
                                    (hasPermission('order.show')
                                        ? '<a href="' +
                                        userView +
                                        full.id +
                                        '" class="ti ti-eye mx-2 ti-sm"></a>'
                                        : '') +
                                    '</div>'
                                );
                            }
                        }
                    ],
                    order: [[1, 'desc']],
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
                                    title: 'Orders',
                                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                    className: 'dropdown-item'
                                },
                                {
                                    extend: 'excel',
                                    title: 'Orders',
                                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                    className: 'dropdown-item'
                                }
                            ]
                        },
                        {
                            text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New Order</span>',
                            className: 'add-new btn btn-primary create-record',
                            enabled: hasPermission('order.create')
                        }
                    ],
                    // For responsive popup
                    responsive: {
                        details: {
                            display: $.fn.dataTable.Responsive.display.modal({
                                header: function header(row) {
                                    var data = row.data();
                                    return 'Details of ' + data['order_number'];
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

                $("#order_id").val(orderId);
                $("#order_status").val(orderStatus);
                // $("#order_status").select2();
                $("#statusModal").modal('show');
            });
            $(".close-modal").click(function () {
                $("#statusModal").modal('hide');
            });

            // Delete Record
            $(document).on('click', '.delete-record', function () {
                var order_id = $(this).data('id'),
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
                            url: baseUrl + `admin/order/${order_id}`,
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

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'The Order is not deleted!',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.create-record', function () {
                window.location.href = baseUrl + 'admin/order/create';
            });
            // edit record
            $(document).on('click', '.edit-record', function () {
                var order_id = $(this).data('id');
                window.location.href = baseUrl + 'admin/order/' + order_id + '/edit';
            });
        });
        /******/
        return __webpack_exports__;
        /******/
    })();
});

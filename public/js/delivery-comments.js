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
            var dt_user_table = $('.datatables-delivery-comments'),
                select2 = $('.select2'),
                userView = baseUrl + 'admin/delivery-comment/',
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
                        url: baseUrl + 'admin/delivery-comment'
                    },
                    columns: [
                        {
                            data: ''
                        },
                        {
                            data: 'order_number'
                        },
                        {
                            data: 'status'
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
                            data: 'shipment_date'
                        },
                        {
                            data: 'origin'
                        },
                        {
                            data: 'destination'
                        },
                        {
                            data: 'comments'
                        },
                        {
                            data: 'comment_by'
                        },
                        {
                            data: 'updated_by'
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
                            targets: 1,
                            render: function render(data, type, full, meta) {
                                return '<span class="badge bg-label-primary me-1 delivery-agent-text">' + full.order_number + '</span>';
                            }
                        },
                        {
                            targets: 2,
                            render: function (data, type, full, meta) {
                                return full.status !== 'Delivered'
                                    ? `<span class="badge bg-label-warning delivery-agent-text">${full.status}</span><a href="#" class="change-status" data-status="${full.status}" data-id="${full.id}"><i class="ti ti-edit"></i></a>`
                                    : `<span class="badge bg-label-info delivery-agent-text">${full.status}</span>`;
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
                                return '<span>' + full.shipment_date + '</span>';
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
                                return '<span>' + full.comments + '</span>';
                            }
                        },
                        {
                            targets: 10,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.comment_by + '</span>';
                            }
                        },
                        {
                            targets: 11,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.updated_by + '</span>';
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
                    buttons: [],
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

            // // Status
            // dt_user_table.on('click', '.change-status', function (e) {
            //     e.preventDefault();
            //     let orderId = $(this).attr('data-id');
            //
            //     let orderStatus = $(this).attr('data-status');
            //
            //     $(".dtr-bs-modal").modal('hide');
            //     console.log('ok')
            //     $("#order_id").val(orderId);
            //     $("#order_status").val(orderStatus);
            //     // $("#order_status").select2();
            //     $("#statusModal").modal('show');
            // });
            $(".close-modal").click(function () {
                $("#statusModal").modal('hide');
            });

        });
        /******/
        return __webpack_exports__;
        /******/
    })();
});

$(function(){
    // Status

    $(document).on('click', '.change-status', function (e) {
        e.preventDefault();
        let orderId = $(this).attr('data-id');

        // let orderStatus = $(this).attr('data-status');

        $(".dtr-bs-modal").modal('hide');

        $("#order_id").val(orderId);
        // $("#order_status").val(orderStatus);
        $("#statusModal").modal('show');
    });
});

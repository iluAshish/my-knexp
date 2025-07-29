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
            var dt_user_table = $('.datatables-reports'),
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
                dt_user_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: baseUrl + 'admin/report',
                        data: function (d) {
                            d.start_date = $('#filter-start-date').val();
                            d.end_date = $('#filter-end-date').val();
                            d.status = $('#status').val();
                            d.branch_id = $('#branch_id').val();
                            d.state_id = $('#state_id').val();
                        },
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
                            data: 'shipment_date'
                        },
                        {
                            data: 'origin'
                        },
                        {
                            data: 'destination'
                        },
                        {
                            data: 'updated_by'
                        },
                        {
                            data: 'status'
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
                            searchable: false,
                            orderable: false,
                            targets: 2,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.order_number + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 3,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.first_name + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 4,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.customer_email + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 5,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.customer_phone + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 6,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.shipment_date + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 7,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.origin + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 8,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.destination + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 9,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.updated_by + '</span>';
                            }
                        },
                        {
                            searchable: false,
                            orderable: false,
                            targets: 10,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.status + '</span>';
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
                                    title: 'reports',
                                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                    className: 'dropdown-item',
                                },
                                {
                                    extend: 'excel',
                                    title: 'reports',
                                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                    className: 'dropdown-item',
                                }
                            ]
                        }
                    ]
                });
            }

            $("#filter-table").click(function () {
                dt_user_table.DataTable().draw();
            });
        });
        /******/
        return __webpack_exports__;
        /******/
    })();
});

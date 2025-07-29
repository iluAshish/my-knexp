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
            var dt_user_table = $('.datatables-shipments'),
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
                        url: baseUrl + 'admin/shipment',
                        data: function (d) {
                            d.status = $('#status2').val();
                            d.shipment_date = $('#shipment_date2').val();
                        }
                    },
                    columns: [
                        {
                            data: 'fake_id'
                        },
                        {
                            data: 'order_number'
                        },
                        {
                            data: 'shipment_date'
                        },
                        {
                            data: 'status'
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
                            searchable: false,
                            orderable: false,
                            targets: 0,
                            checkboxes: {
                                selectAllRender: '<input type="checkbox" class="form-check-input">'
                            },
                            render: function render(data, type, full, meta) {
                                return full.status !== "Shipment Received" ? '<input type="checkbox" class="dt-checkboxes form-check-input shipments" name="shipment[]" value="'+full.id+'">':'';
                            }
                        },
                        {
                            targets: 1,
                            searchable: false,
                            orderable: false,
                            render: function render(data, type, full, meta) {
                                return full.fake_id;
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
                                return '<span>' + full.shipment_date + '</span>';
                            }
                        },
                        {
                            targets: 4,
                            render: function render(data, type, full, meta) {
                                return statusLabels[full.status] || '<span>' + full.status + '</span>';
                            }
                        },
                        {
                            targets: 5,
                            render: function render(data, type, full, meta) {
                                return '<span>' + full.created_at + '</span>';
                            }
                        },
                        {
                            // Actions
                            targets: 6,
                            title: 'Actions',
                            searchable: false,
                            orderable: false,
                            render: function render(data, type, full, meta) {
                                return (
                                    '<div class="d-inline-block text-nowrap">' +
                                    (hasPermission('shipment.destroy') && full.status != "Shipment Received"
                                        ? '<button class="btn btn-sm btn-icon delete-record" data-id="' +
                                        full.id +
                                        '"><i class="ti ti-trash"></i></button>'
                                        : '') +
                                    '</div>'
                                );
                                // return (
                                //     '<div class="d-inline-block text-nowrap">' +
                                //     (hasPermission('shipment.edit')
                                //         ? '<button class="btn btn-sm btn-icon edit-record" data-id="' +
                                //         full.id +
                                //         '"><i class="ti ti-edit"></i></button>'
                                //         : '') +
                                //     (hasPermission('shipment.destroy')
                                //         ? '<button class="btn btn-sm btn-icon delete-record" data-id="' +
                                //         full.id +
                                //         '"><i class="ti ti-trash"></i></button>'
                                //         : '') +
                                //     (hasPermission('shipment.index')
                                //         ? '<a href="' +
                                //         userView +
                                //         full.id +
                                //         '" class="ti ti-eye mx-2 ti-sm"></a>'
                                //         : '') +
                                //     '</div>'
                                // );
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
                                    title: 'Shipments',
                                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                    className: 'dropdown-item',
                                },
                                {
                                    extend: 'excel',
                                    title: 'Shipments',
                                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                    className: 'dropdown-item',
                                }
                            ]
                        },
                        {
                            text: '<i class="ti ti-trash me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Delete</span>',
                            className: 'btn btn-danger delete-records',
                            enabled: hasPermission('shipment.bulkdelete')
                        }
                    ],
                    // For responsive popup
                });
            }

            // Delete Record
            $(document).on('click', '.delete-records', function () {

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
                        let shipmentIds = [];
                        $(".shipments").each(function (index) {
                            if ($(this).prop('checked')) {
                                shipmentIds[index] = $(this).val();
                            }
                        });
                        // delete the data
                        $.ajax({
                            type: 'POST',
                            url: baseUrl + 'admin/shipment/bulk-delete',
                            data: {
                                "shipment_ids": shipmentIds,
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
                            url: baseUrl + `admin/shipment/${shipment_id}`,
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

            $("#filter-table").click(function () {
                dt_user_table.DataTable().draw();
            });

        });
        /******/
        return __webpack_exports__;
        /******/
    })();
});

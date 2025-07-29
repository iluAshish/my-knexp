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
            var dt_branch_table = $('.datatables-dates'),
                select2 = $('.select2'),
                dateView = baseUrl + 'admin/date/',
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

            if (dt_branch_table.length) {
                var dt_branch = dt_branch_table.DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: baseUrl + 'admin/date'
                    },
                    columns: [
                        {
                            data: ''
                        },
                        {
                            data: 'fake_id'
                        },
                        {
                            data: 'date'
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
                                return '<span>'.concat(full.fake_id, '</span>');
                            }
                        },
                        {
                            targets: 2,
                            searchable: false,
                            orderable: false,
                            responsivePriority: 4,
                            render: function render(data, type, full, meta) {
                                return full['week_dates'];
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
                                    (hasPermission('datelockdate.edit')
                                        ? '<button class="btn btn-sm btn-icon edit-record" data-id="' +
                                        full.id +
                                        '"><i class="ti ti-edit"></i></button>'
                                        : '') +
                                    (hasPermission('datelockdate.destroy')
                                        ? '<button class="btn btn-sm btn-icon delete-record" data-id="' +
                                        full.id +
                                        '"><i class="ti ti-trash"></i></button>'
                                        : '') +
                                    (hasPermission('datelockdate.show')
                                        ? '<a href="' +
                                        dateView +
                                        full.id +
                                        '" class="ti ti-eye mx-2 ti-sm"></a>'
                                        : '') +
                                    '</div>'
                                );
                            }
                        }
                    ],
                    order: [[3, 'desc']],
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
                                    title: 'Branches',
                                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                    className: 'dropdown-item'
                                },
                                {
                                    extend: 'excel',
                                    title: 'Branches',
                                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                    className: 'dropdown-item'
                                }
                            ]
                        },
                        {
                            text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New Date</span>',
                            className: 'add-new btn btn-primary create-record',
                            enabled: hasPermission('datelockdate.create')
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

            // Delete Record
            $(document).on('click', '.delete-record', function () {
                var date_id = $(this).data('id'),
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
                            url: baseUrl + `admin/date/${date_id}`,
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
                                dt_branch.draw();
                            },
                            error: function error(_error) {
                                console.log(_error);
                            }
                        });

                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        Swal.fire({
                            title: 'Cancelled',
                            text: 'The Branch is not deleted!',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.create-record', function () {
                window.location.href = baseUrl + 'admin/date/create';
			});
            // edit record
            $(document).on('click', '.edit-record', function () {
                var date_id = $(this).data('id');
                window.location.href = baseUrl + 'admin/date/' + date_id + '/edit';

                // var date_id = $(this).data('id'),
                //     dtrModal = $('.dtr-bs-modal.show');
                // console.log(date_id);
                // hide responsive modal in small screen
                // if (dtrModal.length) {
                //     dtrModal.modal('hide');
                // }

                // changing the title of offcanvas
                // $('#offcanvasAddUserLabel').html('Edit User');

                // get data
                // $.get(''.concat(baseUrl, 'admin/date/').concat(date_id, '/edit'), function (data) {
                //     $('#date_id').val(data.id);
                //     $('#add-user-first_name').val(data.first_name);
                //     $('#add-user-last_name').val(data.last_name);
                //     $('#add-user-email').val(data.email);
                // });
            });
        });
        /******/ return __webpack_exports__;
        /******/
    })();
});

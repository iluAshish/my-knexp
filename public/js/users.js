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
            var dt_user_table = $('.datatables-users'),
                select2 = $('.select2'),
                userView = baseUrl + 'admin/user/',
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
                        url: baseUrl + 'admin/user'
                    },
                    columns: [
                        {
                            data: ''
                        },
                        {
                            data: 'id'
                        },
                        {
                            data: 'name'
                        },
                        {
                            data: 'email'
                        },
                        {
                            data: 'email_verified_at'
                        },
                        {
                            data: 'phone'
                        },
                        {
                            data: 'branch'
                        },
                        {
                            data: 'role'
                        },
                        {
                            data: 'status'
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
                            responsivePriority: 4,
                            render: function render(data, type, full, meta) {
                                return full['name'];
                            }
                        },
                        {
                            // User email
                            targets: 3,
                            render: function render(data, type, full, meta) {
                                var $email = full['email'];
                                return '<span class="user-email">' + $email + '</span>';
                            }
                        },
                        {
                            // email verify
                            targets: 4,
                            className: 'text-center',
                            render: function render(data, type, full, meta) {
                                var $verified = full['email_verified_at'];
                                return ''.concat(
                                    $verified
                                        ? '<i class="ti fs-4 ti-shield-check text-success"></i><span class="d-none">Verified</span>'
                                        : '<i class="ti fs-4 ti-shield-x text-danger" ></i><span class="d-none">Not Verified</span>'
                                );
                            }
                        },
                        {
                            targets: 5,
                            render: function render(data, type, full, meta) {
                                var phone = full['phone'];
                                return '<span class="user-email">' + phone + '</span>';
                            }
                        },
                        {
                            targets: 6,
                            render: function render(data, type, full, meta) {
                                var branch = full['branch'];
                                return '<span class="user-email">' + branch + '</span>';
                            }
                        },
                        {
                            targets: 7,
                            render: function render(data, type, full, meta) {
                                var role = full['role'];
                                return '<span class="user-email">' + role + '</span>';
                            }
                        },
                        {
                            targets: 8,
                            className: 'text-center',
                            render: function render(data, type, full, meta) {
                                let status = parseInt(full.status);
                                let userId = full.id;

                                return `
                                ${(status === 1) ? '<span class="d-none">Active</span>' : '<span class="d-none">In active</span>'}


                                    <label class="switch switch-primary">
                                        <input
                                            id="switch-state-${userId}"
                                            type="checkbox"
                                            class="switch-input status_check"
                                            data-size="mini"
                                            data-url="/status-change"
                                            data-table="User"
                                            data-field="status"
                                            data-pk="${userId}"
                                            ${(status === 1) ? 'checked' : ''}
                                        />
                                        <span class="switch-toggle-slider">
                                            <span class="switch-on"></span>
                                            <span class="switch-off"></span>
                                        </span>
                                    </label>
                                `;
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
                                    (hasPermission('user.edit')
                                        ? '<button class="btn btn-sm btn-icon edit-record" data-id="' +
                                        full.id +
                                        '"><i class="ti ti-edit"></i></button>'
                                        : '') +
                                    (hasPermission('user.destroy')
                                        ? '<button class="btn btn-sm btn-icon delete-record" data-id="' +
                                        full.id +
                                        '"><i class="ti ti-trash"></i></button>'
                                        : '') +
                                    (hasPermission('user.show')
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
                    order: [[6, 'desc']],
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
                                    extend: 'excel',
                                    title: 'Users',
                                    text: '<i class="ti ti-file-spreadsheet me-2"></i>Excel',
                                    className: 'dropdown-item',
                                },
                                {
                                    extend: 'csv',
                                    title: 'Users',
                                    text: '<i class="ti ti-file-text me-2" ></i>Csv',
                                    className: 'dropdown-item',
                                },
                            ]
                        },
                        {
                            text: '<i class="ti ti-plus me-0 me-sm-1"></i><span class="d-none d-sm-inline-block">Add New User</span>',
                            className: 'add-new btn btn-primary create-record',
                            enabled: hasPermission('user.create')
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
                var user_id = $(this).data('id'),
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
                            url: baseUrl + `admin/user/${user_id}`,
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
                            text: 'The User is not deleted!',
                            icon: 'error',
                            customClass: {
                                confirmButton: 'btn btn-success'
                            }
                        });
                    }
                });
            });

            $(document).on('click', '.create-record', function () {
                window.location.href = baseUrl + 'admin/user/create';
            });
            // edit record
            $(document).on('click', '.edit-record', function () {
                var user_id = $(this).data('id');
                window.location.href = baseUrl + 'admin/user/' + user_id + '/edit';

                // var user_id = $(this).data('id'),
                //     dtrModal = $('.dtr-bs-modal.show');
                // console.log(user_id);
                // hide responsive modal in small screen
                // if (dtrModal.length) {
                //     dtrModal.modal('hide');
                // }

                // changing the title of offcanvas
                // $('#offcanvasAddUserLabel').html('Edit User');

                // get data
                // $.get(''.concat(baseUrl, 'admin/user/').concat(user_id, '/edit'), function (data) {
                //     $('#user_id').val(data.id);
                //     $('#add-user-first_name').val(data.first_name);
                //     $('#add-user-last_name').val(data.last_name);
                //     $('#add-user-email').val(data.email);
                // });
            });
        });
        /******/
        return __webpack_exports__;
        /******/
    })();
});

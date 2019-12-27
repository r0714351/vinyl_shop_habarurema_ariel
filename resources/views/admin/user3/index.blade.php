@extends('layouts.template')

@section('title', 'Users3')

@section('main')
    <h1>Users (Expert)</h1>
    @include('shared.alert')
    <div class="table-responsive">
        <table class="table table-bordered table-striped" id="datatable">
            <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Active</th>
                <th>Admin</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>

            </tbody>
        </table>

    </div>



@endsection

@section('modal')
    {{ "Begin Edit Modal" }}
    <div class="modal" id="modal-users3">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">modal-genre-title</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="/admin/users3/" method="post" id="editForm">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" id="name"
                                   class="form-control"
                                   placeholder="Name"
                                   minlength="3"
                                   required
                                   value=" ">
                            <div class="invalid-feedback"></div>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" name="email" id="email"
                                   class="form-control"
                                   placeholder="Email"
                                   required
                                   value=" ">
                        </div>

                        <div class="form-group">
                            <label for="active">Active</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="active" id="active" value="1"
                                       checked>
                                <label class="form-check-label" for="active">
                                    Active
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="active" id="notactive" value="2">
                                <label class="form-check-label" for="notactive">
                                    Not active
                                </label>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="admin">Admin</label>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="admin" id="admin" value="1">
                                <label class="form-check-label" for="admin">
                                    Admin
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="admin" id="notadmin" value="2"
                                       checked>
                                <label class="form-check-label" for="notadmin">
                                    Not admin
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">Update user</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('script_after')
    <script>
        $(function () {
            loadTable();
        });

        // Load users with AJAX
        function loadTable() {
            $.getJSON('/admin/user3/qryUsers')
                .done(function (data) {
                    console.log('data', data);
                    // Clear tbody tag
                    $('tbody').empty();
                    // Loop over each item in the array
                    $.each(data, function (key, value) {
                        let tr = `<tr>
                               <th>${value.id}</th>
                               <td>${value.name}</td>
                               <td>${value.email}</td>
                               <td>${value.active}</td>
                               <td>${value.admin}</td>
                                <td data-id="${value.id}"
                                   data-records="${value.users_count}"
                                   data-name="${value.name}">
                                    <div class="btn-group btn-group-sm">
                                        <a href="#!" class="btn btn-outline-success btn-edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="#!" class="btn btn-outline-danger btn-delete">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                               </td>
                           </tr>`;
                        // Append row to tbody
                        $('tbody').append(tr);
                    });
                })
                .fail(function (e) {
                    console.log('error', e);
                })
        }

        $(function () {
            var table = $('#datatable').DataTable();

            // Start edit
            table.on('click'), 'btn-edit', function () {
                $tr = $(this).closest('tr');
                if ($($tr).hasClass('child')) {
                    $tr = $tr.prev('.parent');
                }

                var data = table.row($tr).data();
                console.log(data);

                $('#name').val(data[1]);
                $('#email').val(data[2]);
                $('#active').val(data[3]);
                $('#admin').val(data[4]);

                $('#editForm').attr('action', '/admin/users3' + data[0]);
                $('#modal-users3').modal('show');


            }
        });
    </script>

    <script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>
@endsection

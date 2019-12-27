@extends('layouts.template')

@section('title', 'Users2')

@section('main')
    <h1>Users (Advanced)</h1>

    <form method="get" action="/admin/users2" id="searchForm">
        <div class="row">
            <div class="col-sm-6 mb-2">
                <input type="text" class="form-control" name="name" id="name"
                       value="{{ request()->name }}"
                       placeholder="Filter Name or Email">
            </div>
            <div class="col-sm-4 mb-2">
                <select class="form-control" name="sort" id="sort">
                    @foreach($orderlist as $i => $order)
                        <option value={{$i}} {{ (request()->sort ==  $i ? 'selected' : '') }}>
                            {{$order["name"]}}</option>
                    @endforeach

                </select>
            </div>
            <div class="col-sm-2 mb-2">
                <button type="submit" class="btn btn-success btn-block">Search</button>
            </div>
        </div>
        @if ($users->count() == 0)
            <div class="alert alert-danger alert-dismissible fade show">
                Can't find anyone named <b>'{{ request()->name }}'</b>
                <button type="button" class="close" data-dismiss="alert">
                    <span>&times;</span>
                </button>
            </div>
        @endif
    </form>
    <hr>
    {{ $users->links() }}
    <div class="table-responsive">
        <table class="table">
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
            @foreach($users as $user)
                <tr class="uname">
                    <td class="id">{{ $user->id }}</td>
                    <td class="name">{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->active }}</td>
                    <td>{{ $user->admin }}</td>
                    <td>
                        <form action="/admin/users2/{{ $user->id }}" method="post" class="deleteForm">
                            @method('delete')
                            @csrf

                            <div class="btn-group btn-edit btn-group-sm">
                                <a href="#!"
                                   class="btn btn-outline-success @if($user->id == auth()->id())
                                       disabled @endif"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->name }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button @if($user->id == auth()->id())
                                        disabled
                                        @endif

                                        type="button" class="btn btn-delete btn-outline-danger"
                                        data-toggle="tooltip"
                                        title="Delete {{ $user->name }}">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </div>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
    {{ $users->links() }}
    @include('admin.users2.modal')
@endsection

@section('script_after')
    <script>
        $(function () {

            $('tbody').on('click', '.btn-delete', function () {
                // Get data attributes from td tag
                let id = $(this).closest('td').data('id');
                let name = $(this).closest('td').data('name');
                // Set some values for Noty
                let text = `<p>Delete the user <b>${name}</b>?</p>`;
                let type = 'warning';
                let btnText = 'Delete user';
                let btnClass = 'btn-success';

                // Show Noty
                let modal = new Noty({
                    timeout: false,
                    layout: 'center',
                    modal: true,
                    type: type,
                    text: text,
                    buttons: [
                        Noty.button(btnText, `btn ${btnClass}`, function () {
                            // Delete user and close modal
                            deleteUsers2(id);
                            modal.close();
                        }),
                        Noty.button('Cancel', 'btn btn-secondary ml-2', function () {
                            modal.close();
                        })
                    ]
                }).show();
            });

            // Delete a genre
            function deleteUser2(id) {
                // Delete the user from the database
                let pars = {
                    '_token': '{{ csrf_token() }}',
                    '_method': 'delete'
                };

                $.post(`/admin/users2/${id}`, pars, 'json')
                    .done(function (data) {
                        console.log('data', data);
                        // Show toast
                        new Noty({
                            type: data.type,
                            text: data.text
                        }).show();
                        // Rebuild the table
                        loadTable();
                    })
                    .fail(function (e) {
                        console.log('error', e);
                    });
            }

            $('tr').on('click', '.btn-edit', function () {
                // Get data attributes from td tag
                let id = $(this).closest("td").find("id").val();
                //let name = $(this).find("name").text();
                let name = $(this).closest("td").find("name").val();
                // Update modal
                $('.modal-title').text(`Edit ${name}`);
                $('form').attr('action', `/admin/users2/${id}`);
                $('#name').val(name);
                $('input[name="_method"]').val('put');
                // Show the modal
                $('#modal-users2').modal('show');
            });


        });

    </script>
@endsection



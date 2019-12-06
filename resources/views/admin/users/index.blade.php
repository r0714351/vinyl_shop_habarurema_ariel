@extends('layouts.template')

@section('title', 'Users')

@section('main')
    <h1>Users</h1>
    @include('shared.alert')
    <form method="get" action="/admin/users" id="searchForm">
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
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->active }}</td>
                    <td>{{ $user->admin }}</td>
                    <td>
                        <form action="/admin/users/{{ $user->id }}" method="post" class="deleteForm">
                            @method('delete')
                            @csrf

                            <div class="btn-group btn-group-sm">
                                <a href="/admin/users/{{ $user->id }}/edit"
                                   class="btn btn-outline-success @if($user->id == auth()->id())
                                       disabled @endif"
                                   data-toggle="tooltip"
                                   title="Edit {{ $user->name }}">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button @if($user->id == auth()->id())
                                        disabled
                                        @endif

                                        type="button" class="btn btn-outline-danger"
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
@endsection

@section('script_after')
    <script>
        $(function () {
            $('.deleteForm button').click(function () {
                let user = $(this).data('users');
                let msg = `Delete the user '${user}'?`;
                if (confirm(msg)) {
                    $(this).closest('form').submit();
                }
            })
        });
    </script>
@endsection

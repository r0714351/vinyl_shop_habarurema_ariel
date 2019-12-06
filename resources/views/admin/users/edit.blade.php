@extends('layouts.template')

@section('title', 'Edit User')

@section('main')
    <h1>Edit user: {{ $user->name }}</h1>
    <form action="/admin/users/{{ $user->id }}" method="post">
        @method('put')
        @csrf
        <div class="form-group">
            <label for="name">Name</label>
            <input type="text" name="name" id="name"
                   class="form-control @error('name') is-invalid @enderror"
                   placeholder="Name"
                   minlength="3"
                   required
                   value="{{ old('name', $user->name) }}">
            @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="text" name="email" id="email"
                   class="form-control @error('email') is-invalid @enderror"
                   placeholder="Email"
                   required
                   value="{{ old('email', $user->email) }}">
            @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="active">Active</label>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="active" id="active" value="1" checked>
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
                <input class="form-check-input" type="radio" name="admin" id="notadmin" value="2" checked>
                <label class="form-check-label" for="notadmin">
                    Not admin
                </label>
            </div>
        </div>
        <button type="submit" class="btn btn-success">Save User</button>
    </form>
@endsection

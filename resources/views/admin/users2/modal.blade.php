<div class="modal" id="modal-users2">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit {{ $user->name }}</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="/admin/users2/{id}" method="post">
                    @method('PUT')
                    @csrf
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" name="name" id="name"
                               class="form-control"
                               placeholder="Name"
                               minlength="3"
                               required
                               value="{{ old('name', $user->name) }}">
                        <div class="invalid-feedback"></div>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" name="email" id="email"
                               class="form-control"
                               placeholder="Email"
                               required
                               value="{{ old('email', $user->email) }}">
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
                    <button type="submit" class="btn btn-success">Update user</button>
                </form>
            </div>
        </div>
    </div>
</div>

@extends('layouts.app')

@section('content')

<div class="admin-page">

    <div class="page-header">
        <div>
            <h1>Edit User</h1>
            <p>Update user information, role, and account status.</p>
        </div>

        <a href="{{ route('admin.users.index') }}" class="btn-secondary">
            ← Back to Users
        </a>
    </div>


    <div class="form-card">

        @if (isset($errors) && $errors->any())
            <div class="alert-error">
                <strong>Please fix the following errors:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <form action="{{ route('admin.users.update', $user->id) }}" method="POST">

            @csrf
            @method('PUT')


            <div class="form-group">
                <label for="name">Full Name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $user->name) }}"
                    required
                >
            </div>


            <div class="form-group">
                <label for="email">Email Address</label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email', $user->email) }}"
                    required
                >
            </div>


            <div class="form-group">
                <label for="role">Role</label>

                <select id="role" name="role" required>

                    <option value="customer"
                        {{ old('role', $user->role) === 'customer' ? 'selected' : '' }}>
                        Customer
                    </option>

                    <option value="agent"
                        {{ old('role', $user->role) === 'agent' ? 'selected' : '' }}>
                        Agent
                    </option>

                    <option value="admin"
                        {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>
                        Admin
                    </option>

                </select>
            </div>


            <div class="form-group">
                <label for="status">Account Status</label>

                <select id="status" name="status" required>

                    <option value="active"
                        {{ old('status', $user->status) === 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ old('status', $user->status) === 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>
            </div>


            <div class="form-actions">

                <a href="{{ route('admin.users.index') }}" class="btn-secondary">
                    Cancel
                </a>

                <button type="submit" class="btn-primary">
                    Update User
                </button>

            </div>

        </form>

    </div>

</div>

@endsection
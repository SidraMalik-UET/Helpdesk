@extends('layouts.app')

@section('content')

<div class="admin-container">

    <div class="page-header">

        <div>
            <h1>Users</h1>
            <p>Manage HelpDesk users, roles and account status.</p>
        </div>

        <a href="{{ route('admin.users.create') }}" class="btn">
            + Add User
        </a>

    </div>


    @if(session('success'))

        <div class="success-message">
            {{ session('success') }}
        </div>

    @endif


    <div class="table-card">

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>

            </thead>


            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td>
                            #{{ $user->id }}
                        </td>

                        <td>
                            {{ $user->name }}
                        </td>

                        <td>
                            {{ $user->email }}
                        </td>

                        <td>
                            {{ ucfirst($user->role) }}
                        </td>

                        <td>
                            {{ ucfirst($user->status) }}
                        </td>

                        <td>
                            {{ $user->created_at->format('d M Y') }}
                        </td>

                        <td>

                            <a href="{{ route('admin.users.edit', $user) }}">
                                Edit
                            </a>


                            <form
                                action="{{ route('admin.users.destroy', $user) }}"
                                method="POST"
                                style="display:inline;"
                            >

                                @csrf

                                @method('DELETE')

                                <button
                                    type="submit"
                                    onclick="return confirm('Delete this user?')"
                                >
                                    Delete
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="7">
                            No users found.
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

<style>
    .admin-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 40px 30px 100px;
        min-height: calc(100vh - 180px);
    }

    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .page-header h1 {
        margin: 0 0 8px;
        font-size: 32px;
        color: #111827;
    }

    .page-header p {
        margin: 0;
        color: #6b7280;
        font-size: 15px;
    }

    .btn {
        display: inline-block;
        padding: 10px 18px;
        background: #111827;
        color: white;
        text-decoration: none;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
    }

    .btn:hover {
        background: #1f2937;
    }

    .success-message {
        margin-bottom: 20px;
        padding: 12px 16px;
        background: #ecfdf5;
        color: #047857;
        border: 1px solid #a7f3d0;
        border-radius: 6px;
    }

    .table-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow-x: auto;
        box-shadow: 0 2px 8px rgba(15, 23, 42, 0.04);
    }

    table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    th {
        padding: 16px 20px;
        text-align: left;
        background: #f8fafc;
        color: #374151;
        font-size: 13px;
        font-weight: 600;
        border-bottom: 1px solid #e5e7eb;
    }

    td {
        padding: 17px 20px;
        color: #4b5563;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
        white-space: nowrap;
    }

    tbody tr:last-child td {
        border-bottom: none;
    }

    tbody tr:hover {
        background: #f8fafc;
    }

    /* Give each column proper space */
    th:nth-child(1),
    td:nth-child(1) {
        width: 70px;
    }

    th:nth-child(2),
    td:nth-child(2) {
        min-width: 150px;
    }

    th:nth-child(3),
    td:nth-child(3) {
        min-width: 250px;
    }

    th:nth-child(4),
    td:nth-child(4) {
        min-width: 100px;
    }

    th:nth-child(5),
    td:nth-child(5) {
        min-width: 100px;
    }

    th:nth-child(6),
    td:nth-child(6) {
        min-width: 140px;
    }

    th:nth-child(7),
    td:nth-child(7) {
        min-width: 130px;
    }

    td a {
        color: #2563eb;
        text-decoration: none;
        margin-right: 14px;
        font-weight: 500;
    }

    td a:hover {
        text-decoration: underline;
    }

    td button {
        border: none;
        background: none;
        padding: 0;
        color: #dc2626;
        cursor: pointer;
        font-size: 14px;
        font-weight: 500;
    }

    td button:hover {
        text-decoration: underline;
    }

    /* Keep footer lower and page balanced */
    .admin-container {
        margin-bottom: 60px;
    }

    @media (max-width: 768px) {
        .admin-container {
            padding: 25px 15px 80px;
        }

        .page-header {
            align-items: flex-start;
            gap: 20px;
        }

        .page-header h1 {
            font-size: 28px;
        }
    }
</style>

@endsection
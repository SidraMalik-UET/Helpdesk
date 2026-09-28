@extends('layouts.app')

@section('content')

<div class="admin-page">

    <div class="page-header">
        <div>
            <h1>Ticket Categories</h1>
            <p>Manage categories used for support tickets.</p>
        </div>

        <a href="{{ route('admin.categories.create') }}" class="btn-primary">
            + Add Category
        </a>
    </div>

    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($categories->count())

        <div class="category-table">

            <div class="table-header">
                <div>Name</div>
                <div>Description</div>
                <div>Tickets</div>
                <div>Actions</div>
            </div>

            @foreach($categories as $category)

                <div class="table-row">

                    <div>
                        <strong>{{ $category->name }}</strong>
                    </div>

                    <div>
                        {{ $category->description ?: 'No description' }}
                    </div>

                    <div>
                        {{ $category->tickets()->count() }}
                    </div>

                    <div class="actions">

                        <a
                            href="{{ route('admin.categories.edit', $category) }}"
                            class="btn-edit"
                        >
                            Edit
                        </a>

                        <form
                            action="{{ route('admin.categories.destroy', $category) }}"
                            method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this category?');"
                        >

                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-delete">
                                Delete
                            </button>

                        </form>

                    </div>

                </div>

            @endforeach

        </div>

    @else

        <div class="empty-state">
            <h3>No categories found</h3>
            <p>Create your first ticket category.</p>

            <a
                href="{{ route('admin.categories.create') }}"
                class="btn-primary"
            >
                Add Category
            </a>
        </div>

    @endif

</div>

@endsection
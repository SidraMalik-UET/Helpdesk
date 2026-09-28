@extends('layouts.app')

@section('content')

<div class="admin-page">

    <div class="page-header">

        <div>
            <h1>Edit Category</h1>
            <p>Update this ticket category.</p>
        </div>

        <a
            href="{{ route('admin.categories.index') }}"
            class="btn-secondary"
        >
            Back to Categories
        </a>

    </div>

    @if(isset($errors) && $errors->any())

        <div class="alert-error">

            <strong>Please fix the following errors:</strong>

            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>

        </div>

    @endif

    <div class="form-card">

        <form
            action="{{ route('admin.categories.update', $category) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="form-group">

                <label for="name">
                    Category Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
                    required
                >

            </div>

            <div class="form-group">

                <label for="description">
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="5"
                >{{ old('description', $category->description) }}</textarea>

            </div>

            <button type="submit" class="btn-primary">
                Update Category
            </button>

        </form>

    </div>

</div>

@endsection
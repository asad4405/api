@extends('layouts.master')
@section('title')
    Edit Category
@endsection
@section('content')
<div class="row">
    <div class="m-auto col-lg-6">
        <div class="card">
            <div class="card-header">
                <h3>Edit Category</h3>
            </div>
            <div class="card-body">
                <form action="{{ env('CATEGORY_UPDATE') }}/{{ $category->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name" value="{{ $category->category_name }}">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category Image</label>
                        <input type="file" class="form-control" name="image">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection


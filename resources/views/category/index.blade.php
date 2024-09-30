@extends('layouts.master')
@section('title')
    Category List
@endsection
@section('content')
    <div class="row">
        <div class="m-auto col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Category List</h3>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <tr>
                            <th>SL</th>
                            <th>Category Name</th>
                            <th>Category Image</th>
                            <th>Action</th>
                        </tr>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $category->category_name }}</td>
                                <td>
                                    <img src="{{ env('FILE') }}/{{ $category->image }}" alt="">
                                </td>
                                <td>
                                    <a href="{{ env('CATEGORY_SHOW') }}/{{ $category->id }}" class="btn btn-info">Show</a>
                                    <a href="{{ route('category.edit',$category->id) }}" class="btn btn-primary">Edit</a>
                                    <a href="" class="btn btn-danger">Delete</a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.master')
@section('title')
    Show Category
@endsection
@section('content')
    <div class="row">
        <div class="m-auto col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h3>Show Category</h3>
                </div>
                <div class="card-body">
                    <table class="table table-borderd">
                        <tr>
                            <th>Header</th>
                            <th></th>
                            <th>Details</th>
                        </tr>
                        <tr>
                            <td>Category Name</td>
                            <td>:</td>
                            <td></td>
                            <td>@php
                                return $category->category_name
                                @endphp

                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@extends('layouts.admin')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Products </li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Product Detail</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                                </thead>
                                <tbody>

                                <tr>
                                    <td>Name</td><td>{{$det->name}}</td>
                                </tr>
                                <tr>
                                    <td>Company</td><td>{{$det->company}}</td>
                                </tr>
                                <tr>
                                    <td>Price</td><td>{{$det->price}}</td>
                                </tr>
                                <tr>
                                    <td>Image</td><td>{{$det->image}}</td>
                                </tr>
                                <tr>
                                    <td>Size</td><td>{{$det->size}}</td>
                                </tr>
                                <tr>
                                    <td>Isactive</td>
                                    <td>
                                        @if($det->isactive==0){{'No'}}
                                        @else{{'Yes'}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td>Rating</td><td>{{$det->rating}}</td>
                                </tr>
                                <tr>
                                    <td>Category Title</td><td>{{$det->category->title}}</td>
                                </tr>
                                <tr>
                                    <td>SubCategory ID</td><td>{{$det->subcategoryid}}</td>
                                </tr>
                                <tr>
                                    <td>SpacialCategory ID</td><td>{{$det->specialcategoryid}}</td>
                                </tr>
                                <tr>
                                    <td>Description</td><td>{{$det->description}}</td>
                                </tr>
                                <tr>
                                    <td>In The Box</td><td>{{$det->in_the_box}}</td>
                                </tr>
                                </tbody>

                            </table>
                        </div>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </section>
        <!-- /.content -->
    </div>

@endsection

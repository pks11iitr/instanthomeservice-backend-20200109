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
                            <li class="breadcrumb-item active">Products</li>
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
                            <h3 class="card-title">Products Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Company</th>
                                    <th>Price</th>
                                    <th>Image</th>
                                    <th>Size</th>
                                    <th>Isactive</th>
                                    <th>Rating</th>
                                    <th>Category Title</th>
                                    <th>Description</th>
                                    <th>Detail</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sel as $s)
                                    <tr>
                                        <td>{{$s->name}}</td>
                                        <td>{{$s->company}}</td>
                                        <td>{{$s->price}}</td>
                                        <td><img src="{{$s->image}}" height="50px" width="50px"/></td>
                                        <td>{{$s->size}}</td>
                                        <td>
                                            @if($s->isactive==0){{'No'}}
                                            @else{{'Yes'}}
                                            @endif
                                        </td>
                                        <td>{{$s->rating}}</td>
                                        <td>{{$s->category->title}}</td>
                                        <td>{{$s->description}}</td>
                                        <td><a href="{{route('products.detail',['id'=>$s->id])}}" class="btn btn-block btn-primary">Details</a></td>
                                        <td><a href="{{route('products.edit',['id'=>$s->id])}}" class="btn btn-success">Edit</a></td>
                                    </tr>
                                @endforeach
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

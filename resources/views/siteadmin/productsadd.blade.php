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
            <div class="container-fluid">
                <div class="row">
                    <!-- left column -->
                    <div class="col-md-12">
                        <!-- jquery validation -->
                        <div class="card card-primary">
                            <div class="card-header">
                                <h3 class="card-title">Products Add</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="post" enctype="multipart/form-data" action="{{route('products.store')}}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Name</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Company</label>
                                        <input type="text" name="company" class="form-control" id="exampleInputEmail1" placeholder="Company">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Price</label>
                                        <input type="text" name="price" class="form-control" id="exampleInputEmail1" placeholder="Price">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputimage">Image</label>
                                        <input type="file" name="productsimage" class="form-control" id="exampleInputimage" placeholder="">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Size</label>
                                        <input type="text" name="size" class="form-control" id="exampleInputEmail1" placeholder="Size">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputistop">Is Active</label>
                                        <select name="isactive" class="form-control" id="exampleInputistop" placeholder="">
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Rating</label>
                                        <input type="text" name="rating" class="form-control" id="exampleInputEmail1" placeholder="Rating">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Category ID</label>
                                        <select name="categoryid" class="form-control" id="exampleInputistop" placeholder="">
                                           @foreach($allcategories as $c)
                                            <option value="{{$c->id}}">{{$c->categoryid}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputdescription">Description</label>
                                        <textarea name="description" class="form-control" id="exampleInputdescription" placeholder="Description"></textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">In The Box</label>
                                        <input type="text" name="inthebox" class="form-control" id="exampleInputEmail1" placeholder="In The Box">
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                        <!-- /.card -->
                    </div>
                    <!--/.col (left) -->
                    <!-- right column -->
                    <div class="col-md-6">

                    </div>
                    <!--/.col (right) -->
                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection

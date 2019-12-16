@extends('layouts.app')

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
                            <form role="form" method="post" enctype="multipart/form-data" action="{{route('products.update',['id'=>$product->id])}}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Name</label>
                                        <input type="text" name="name" class="form-control" id="exampleInputName" placeholder="Name" value="{{$product->name}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Company</label>
                                        <input type="text" name="company" class="form-control" id="exampleInputEmail1" placeholder="Company" value="{{$product->company}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Price</label>
                                        <input type="text" name="price" class="form-control" id="exampleInputEmail1" placeholder="Price" value="{{$product->price}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputimage">Image</label>
                                        <input type="file" name="productsimage" class="form-control" id="exampleInputimage" placeholder="">
                                        <img src="{{$product->image}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Size</label>
                                        <input type="text" name="size" class="form-control" id="exampleInputEmail1" placeholder="Size" value="{{$product->size}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputistop">Is Active</label>
                                        <select name="isactive" class="form-control" id="exampleInputistop" placeholder="">
                                            <option value="1" {{$product->isactive==1?'selected':''}}>Yes</option>
                                            <option value="0" {{$product->isactive==0?'selected':''}}>No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Rating</label>
                                        <input type="text" name="rating" class="form-control" id="exampleInputEmail1" placeholder="Rating" value="{{$product->rating}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Category ID</label>
                                        <select name="categoryid" class="form-control" id="exampleInputistop" placeholder="">
                                            <option>Select Category ID</option>
                                            @foreach($allcategorys as $c)
                                                <option value="{{$c->id}}"   {{$product->categoryid==$c->id?'selected':''}}>{{$c->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputdescription">Description</label>
                                        <textarea name="description" class="form-control" id="exampleInputdescription" placeholder="Description">{{$product->description}}</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputtitle">In The Box</label>
                                        <input type="text" name="inthebox" class="form-control" id="exampleInputEmail1" placeholder="In The Box" value="{{$product->in_the_box}}">
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

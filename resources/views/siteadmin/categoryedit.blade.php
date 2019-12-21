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
                            <li class="breadcrumb-item active">Category</li>
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
                                <h3 class="card-title">Category Add</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="post" enctype="multipart/form-data" action="{{route('category.update',['id'=>$category->id])}}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputtitle">Title</label>
                                        <input type="text" name="title" class="form-control" id="exampleInputEmail1" placeholder="Title" value="{{$category->title}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputdescription">Description</label>
                                        <textarea name="description" class="form-control" id="exampleInputdescription" placeholder="Description">{{$category->description}}"</textarea>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputimage">Image</label>
                                        <input type="file" name="categoryimage" class="form-control" id="exampleInputimage" placeholder="">
                                        <img src="{{$category->image}}" height="100" width="200">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputparent">Parent Category(optional)</label>
                                        <select name="parent" class="form-control" id="exampleInputistop" placeholder="">
                                            <option value="">Select Parent Category</option>
                                            @foreach($allcategories as $c)
                                                <option value="{{$c->id}}"   {{$category->parent==$c->id?'selected':''}}>{{$c->title}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputistop">Is Active</label>
                                        <select name="isactive" class="form-control" id="exampleInputistop" placeholder="">
                                            <option value="1" {{$category->isactive==1?'selected':''}}>Yes</option>
                                            <option value="0" {{$category->isactive==0?'selected':''}}>No</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputistop">Istop</label>
                                        <select name="istop" class="form-control" id="exampleInputistop" placeholder="">
                                            <option value="1" {{$category->istop==1?'selected':''}}>Yes</option>
                                            <option value="0" {{$category->istop==0?'selected':''}}>No</option>
                                        </select>
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


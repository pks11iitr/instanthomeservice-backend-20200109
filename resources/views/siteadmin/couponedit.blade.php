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
                            <li class="breadcrumb-item active">Coupon</li>
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
                                <h3 class="card-title">Coupon Edit</h3>
                            </div>
                            <!-- /.card-header -->
                            <!-- form start -->
                            <form role="form" method="post" enctype="multipart/form-data" action="{{route('coupons.update',['id'=>$couponedit->id])}}">
                                @csrf
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="exampleInputname">Code</label>
                                        <input type="text" name="code" class="form-control" id="exampleInputName" value="{{$couponedit->code}}" placeholder="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputname">Title</label>
                                        <input type="text" name="title" class="form-control" id="exampleInputName" value="{{$couponedit->title}}" placeholder="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputname">Amount</label>
                                        <input type="text" name="amount" class="form-control" id="exampleInputName" value="{{$couponedit->amount}}" placeholder="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputistop">Type</label>
                                        <select name="type" class="form-control" id="exampleInputistop" placeholder="">
                                            <option value="fixed" {{$couponedit->type=='fixed'?'selected':''}}>Fixed</option>
                                            <option value="percent" {{$couponedit->type=='percent'?'selected':''}}>Percent</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputname">Max Number of times coupon can be used (leave 0 for no limit)</label>
                                        <input type="text" name="max_usage" class="form-control" id="exampleInputName" value="{{$couponedit->max_usage}}" placeholder="name">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputname">Validity</label>
                                        <input type="date" name="validity" class="form-control" id="exampleInputName" value="{{$couponedit->validity}}" placeholder="name">
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

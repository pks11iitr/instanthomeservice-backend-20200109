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
                            <li class="breadcrumb-item active">Order Items</li>
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
                            <h3 class="card-title">Completed Order Details</h3>
                            <br><span>Order Status: {{$order->status}}</span>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->details as $detail)
                                    <tr>
                                        <td>{{$detail->product->name}}</td>
                                        <td>{{$detail->price}}</td>
                                        <td>{{$detail->quantity}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.card-body -->
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
                                    <td>Name</td><td>{{$order->name}}</td>
                                </tr>
                                <tr>
                                    <td>Address</td><td>{{$order->address}}</td>
                                </tr>
                                <tr>
                                    <td>Address</td><td>{{$order->user->mobile}}</td>
                                </tr>
                                <tr>
                                    <td>Booking Date</td><td>{{$order->booking_date}}</td>
                                </tr>
                                <tr>
                                    <td>Booking Time</td><td>{{$order->time->name}}</td>
                                </tr>

                                </tbody>

                            </table>
                         </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Field</th>
                                    <th>Value</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->vendors as $vendor)
                                <tr>
                                    <td>Vendor Name</td><td>{{$vendor->name}}</td>
                                </tr>
                                <tr>
                                    <td>Vendor Mobile</td><td>{{$vendor->mobile}}</td>
                                </tr>
                                    @endforeach
                                </tbody>

                            </table>
                        </div>

                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Document Type</th>
                                    <th>Document View</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($documents as $doc)
                                    <tr>

                                        <td>
                                            {{substr($doc->doc_path, 0, strpos($doc->doc_path, "/"))}}
                                            </td>
                                        <td>
                                            <a href="{{URL::to('/')}}/uploads/{{$doc->doc_path}}" class="btn btn-warning">View</a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

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

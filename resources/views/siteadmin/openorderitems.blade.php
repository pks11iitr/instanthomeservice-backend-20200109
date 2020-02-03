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
                            <h3 class="card-title">Open Order Details</h3>
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
                                    <td>Booking Date</td><td>{{$order->booking_date}}</td>
                                </tr>
                                <tr>
                                    <td>Booking Time</td><td>{{$order->time->name??''}}</td>
                                </tr>
                                <tr>
                                    <td></td><td><div class="container">
                                            <!-- Trigger the modal with a button -->
                                            @if(in_array($order->status, ['new']))
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">Assign</button>
                                            @endif
                                            <!-- Modal -->
                                            <div class="modal fade" id="myModal" role="dialog">
                                                <div class="modal-dialog">

                                                    <!-- Modal content-->
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            <h4 class="modal-title"></h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <table id="example1" class="table table-bordered table-striped">
                                                                <thead>
                                                                <tr>
                                                                    <th>Vendor Name</th>
                                                                    <th>Vendor Mobile</th>
                                                                    <th>Button</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody>
                                                                @foreach($lists as $list)
                                                                    <tr>
                                                                        <td>{{$list->name}}</td>
                                                                        <td>{{$list->mobile}}</td>
                                                                        @foreach($order->vendors as $v)

                                                                        <td>
                                                                            @if($v->id==$list->id)
                                                                            <button type="button" class="btn btn-primary" data-toggle="modal">
                                                                                @if($v->pivot->status=='new')
                                                                                    {{'Waiting for accept'}}
                                                                                @elseif($v->pivot->status=='accepted')
                                                                                    {{'Accepted'}}
                                                                                @elseif($v->pivot->status=='rejected')
                                                                                    {{'Rejected'}}
                                                                                @elseif($v->pivot->status=='expired')
                                                                                    {{'Expired'}}
                                                                                @endif
                                                                            </button>
                                                                            @else
                                                                                <button type="button" class="btn btn-primary" data-toggle="modal">Assign</button>
                                                                            @endif
                                                                        </td>

                                                                        @endforeach
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>

                                                        {{--<div class="modal-footer">
                                                            <button type="button" class="btn btn-primary" data-dismiss="modal">Submit</button>
                                                        </div>--}}
                                                    </div>

                                                </div>
                                            </div>

                                        </div>
                                    </td>
                                </tr>

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

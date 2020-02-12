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
                            @if(in_array($order->status,['completed', 'paid']))
                                <br><span>Total Amount : {{$order->total_paid}}</span>
                            @endif
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
                                        <td>{{$detail->product->name??''}} [ {{$detail->product->category->title??''}} ]</td>
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

                                        <td></td>
                                        <td>
                                            <div class="container">
                                                <!-- Trigger the modal with a button -->

                                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">View Vendors</button>
                                                <!-- Modal -->
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
                            <th>Distance</th>
                            <th>Wallet Balance(in Rs.)</th>
                            <th>Button</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($lists as $list)
                            <tr>
                                <td>{{$list->name}}</td>
                                <td>{{$list->mobile}}</td>
                                <td>{{$list->distance??'NA'}}</td>
                                <td>{{\App\Models\Wallet::balance($list->id)}}</td>
                                    <td>

                                                @if(isset($vendors[$list->id]))
                                                    @if($vendors[$list->id]=='new')
                                                        {{'Waiting for accept'}}<a href="{{route('orders.revoke.order',['oid'=>$order->id, 'vid'=>$list->id])}}">Click to revoke</a>
                                                    @elseif($vendors[$list->id]=='accepted')
                                                        {{'Accepted'}}
                                                    @elseif($vendors[$list->id]=='rejected')
                                                        {{'Rejected'}}
                                                    @elseif($vendors[$list->id]=='expired')
                                                        {{'Expired'}}<a href="{{route('orders.assign.order',['oid'=>$order->id, 'vid'=>$list->id])}}">Click to reassign</a>
                                                    @elseif($vendors[$list->id]=='completed')
                                                        {{'Total Estimated'}}
                                                    @elseif($vendors[$list->id]=='paid')
                                                        {{'Payment Received'}}
                                                    @endif
                                                @else
                                                    <a href="{{route('orders.assign.order',['oid'=>$order->id, 'vid'=>$list->id])}}">Assign</a>
                                                @endif

                                    </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>

{{--<div class="modal fade" id="statusmodal" role="dialog">--}}
{{--        <div class="modal-dialog">--}}

{{--            <!-- Modal content-->--}}
{{--            <div class="modal-content">--}}
{{--                <div class="modal-header">--}}
{{--                    <h4 class="modal-title">Change Order Status</h4>--}}
{{--                    <button type="button" class="close" data-dismiss="modal">&times;</button>--}}
{{--                </div>--}}

{{--                <div class="modal-body">--}}
{{--                    <select name="new_status">--}}
{{--                        <option value="new">Mark as new</option>--}}
{{--                        <option value="declined">Decline order</option>--}}
{{--                    </select>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--        </div>--}}
{{--    </div>--}}

@endsection

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
                            <h3 class="card-title">Order Items Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Order Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($details as $detail)
                                    <tr>
                                        <td>{{$detail->product->name}}</td>
                                        <td>{{$detail->price}}</td>
                                        <td>{{$detail->quantity}}</td>
                                        <td>
                                                @if($detail->order_status=='processing')
                                                Processing <a href="{{route('order.status.change',['id'=>$detail->id])}}?type=delivered">Mark as delivered</a>
                                                @elseif($detail->order_status=='returned')
                                                 Returned
                                                @elseif($detail->order_status=='paid')
                                                     Paid <a href="{{route('order.status.change',['id'=>$detail->id])}}?type=delivered">Mark as processing</a>
                                                @elseif($detail->order_status=='pending')
                                                     Payment Pending
                                                @elseif($detail->order_status=='delivered')
                                                    Delivered <a href="{{route('order.status.change',['id'=>$detail->id])}}?type=completed">Mark as completed</a>
                                                @elseif($detail->order_status=='returnrequest')
                                                Delivered <a href="{{route('order.status.change',['id'=>$detail->id])}}?type=completed">Accept Return</a>
                                                @elseif($detail->order_status=='cancelled')
                                                    Cancelled
                                                @elseif($detail->order_status=='completed')
                                                Completed
                                                @endif
                                        </td>

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

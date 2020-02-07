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
                            <li class="breadcrumb-item active">Orders</li>
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
                            <h3 class="card-title">In process Orders Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>OrderID</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Customer(Mobile)</th>
                                    <th>Vendor(Name)</th>
                                    <th>Booking Date</th>
                                    <th>Booking Time</th>
                                    <th>Details</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sel as $s)
                                    <tr>
                                        <td>{{$s->id}}</td>
                                        <td>{{$s->name}}</td>
                                        <td>{{$s->address}}</td>
                                        <td>{{$s->user->mobile}}</td>
                                        <td>{{$s->user->name}}</td>
                                        <td>{{$s->booking_date}}</td>
                                        <td>{{$s->time->name}}</td>
                                        <td><a href="{{route('orders.inprocessdetails',['id'=>$s->id])}}" class="btn btn-primary">Details</a></td>
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

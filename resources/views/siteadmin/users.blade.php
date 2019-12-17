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
                            <li class="breadcrumb-item active">Users </li>
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
                            <h3 class="card-title">Users Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Address</th>
                                    <th>Status</th>
                                    <th>Email Verified</th>
                                    <th>Mobile Verified</th>
                                    <th>Created</th>
                                    <th>lat</th>
                                    <th>lang</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sel as $s)
                                <tr>
                                    <td>{{$s->name}}</td>
                                    <td>{{$s->email}}</td>
                                    <td>{{$s->mobile}}</td>
                                    <td>{{$s->address}}</td>
                                    <td>{{$s->status}}</td>
                                    <td>{{$s->email_verified_at}}</td>
                                    <td>{{$s->mobile_verified_at}}</td>
                                    <td>{{$s->created_at}}</td>
                                    <td>{{$s->lat}}</td>
                                    <td>{{$s->lang}}</td>
                                    <td><a href="usersdetail/{{$s->id}}" class="btn btn-block btn-primary">Details</a></td>
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

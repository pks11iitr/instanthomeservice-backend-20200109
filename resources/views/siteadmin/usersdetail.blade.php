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
                            <h3 class="card-title">Users Detail</h3>
                        </div>
                        <!-- /.card-header -->
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
                                    <td>Name</td><td>{{$det->name}}</td>
                                </tr>
                                <tr>
                                    <td>Email</td><td>{{$det->email}}</td>
                                </tr>
                                <tr>
                                    <td>Mobile</td><td>{{$det->mobile}}</td>
                                </tr>
                                <tr>
                                    <td>Address</td><td>{{$det->address}}</td>
                                </tr>
                                <tr>
                                    <td>Status</td><td>{{$det->status}}</td>
                                </tr>
                                <tr>
                                    <td>Email Verified</td><td>{{$det->email_verified}}</td>
                                </tr>
                                <tr>
                                    <td>Mobile Verified</td><td>{{$det->mobile_verified}}</td>
                                </tr>
                                <tr>
                                    <td>Remember Token</td><td>{{$det->remember_token}}</td>
                                </tr>
                                <tr>
                                    <td>Created</td><td>{{$det->created_at}}</td>
                                </tr>
                                <tr>
                                    <td>Lat</td><td>{{$det->lat}}</td>
                                </tr>
                                <tr>
                                    <td>Lang</td><td>{{$det->lang}}</td>
                                </tr>
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

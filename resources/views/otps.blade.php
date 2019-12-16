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
                            <li class="breadcrumb-item active">OTPS</li>
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
                            <h3 class="card-title">OTPS Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>User ID</th>
                                    <th>Otp</th>
                                    <th>Type</th>
                                    <th>expiry</th>
                                    <th>Isverified</th>
                                    <th>Created</th>
                                    <th>Updated</th>
                                    <th>Deleted</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($sel as $s)
                                    <tr>
                                        <td>{{$s->user_id}}</td>
                                        <td>{{$s->otp}}</td>
                                        <td>{{$s->type}}</td>
                                        <td>{{$s->expiry}}</td>
                                        <td>{{$s->isverified}}</td>
                                        <td>{{$s->created_at}}</td>
                                        <td>{{$s->updated_at}}</td>
                                        <td>{{$s->deleted_at}}</td>
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

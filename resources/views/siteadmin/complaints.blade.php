@extends('layouts.admin')
@section('content')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
            <script type="text/javascript">
                $(function () {
                    $("#mySelect").change(function () {
                        var selectedText = $(this).find("option:selected").text();
                        var is_resolved = $(this).val();
                        var user_id = $(this).data('id');

                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: 'complaints/update',
                            data: {'is_resolved': is_resolved, 'user_id': user_id},

                            success: function (data) {
                                console.log(data.success)
                            }
                        });
                        alert("succesfully resolved status");
                        $('#mySelect').click(function () {
                            window.location.reload();
                            location.reload(true);
                        });
                    });
                });
            </script>
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">

                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Complaints</li>
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
                            <h3 class="card-title">Complaints Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>OrderID</th>
                                    <th>UserID</th>
                                    <th>Attachment</th>
                                    <th>Description</th>
                                    <th>status</th>
                                    <th>Is Resolved</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($complaints as $complaint)
                                <tr>
                                    <td>{{$complaint->order_id}}</td>
                                    <td>{{$complaint->user->name??''}}</td>
                                    <td><img src="{{$complaint->attachment}}" height="50px" width="50px"/></td>
                                    <td>{{$complaint->description}}</td>
                                    <td >
                                        @if($complaint->is_resolved=='0')
                                            No
                                        @elseif($complaint->is_resolved=='1')
                                            Yes
                                        @endif
                                    </td>
                                    <td>
                                        <select name="mySelect"  id="mySelect" data-id="{{$complaint->id}}" class="form-control">
                                            <option value="">Status</option>
                                            <option value="1">Yes</option>
                                            <option value="0">No</option>
                                        </select>
                                    </td>
                                @endforeach
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

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
                        var status = $(this).val();
                        var user_id = $(this).data('id');

                        $.ajax({
                            type: "GET",
                            dataType: "json",
                            url: 'vendors/update',
                            data: {'status': status, 'user_id': user_id},

                            success: function (data) {
                                console.log(data.success)
                            }
                        });
                        alert("succesfully assign role");
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
                            <li class="breadcrumb-item active">Vendors </li>
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
                            <h3 class="card-title">Agreement Complete Table</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body" >
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Mobile</th>
                                    <th>Picture</th>
                                    <th>Status</th>
                                    <th>Agreement Signed</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($vendors as $vendor)
                                    <tr>
                                        <td>{{$vendor->name}}</td>
                                        <td>{{$vendor->email}}</td>
                                        <td>{{$vendor->mobile}}</td>
                                        <td><img src="{{$vendor->image}}" height="50px" width="50px"/></td>
                                        <td >
                                            @if($vendor->status=='0')
                                                InActive
                                            @elseif($vendor->status=='1')
                                                Active
                                            @elseif($vendor->status=='2')
                                                Deactivate
                                            @endif
                                        </td>
                                        <td>
                                            <select  name="mySelect"  id="mySelect" data-id="{{$vendor->id}}" class="form-control">
                                                <option value="">Select Role</option>
                                                <option value="0">InActive</option>
                                                <option value="1">Active</option>
                                                <option value="2">DeActive</option>
                                            </select>
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

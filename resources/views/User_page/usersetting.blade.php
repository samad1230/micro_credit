@extends('layouts.master-layouts')

@section('page-css')

@endsection
<?php $user_id =Auth::user()->role_id; ?>

@section('content')
    <div class="main-content pt-4">
        <div class="separator-breadcrumb border-top"></div>
        <div class="row mb-5">
            <div class="col-md-12 mx-auto">
                <div class="card">

                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="card-title">{{ ucwords(' Users add') }}</div>
                            </div>
                            <div class="col-md-6">
                                <button class="btn btn-primary btn-md float-right" type="button" data-toggle="modal" data-target="#adduser"><i class="i-Add text-white mr-2"></i> Add Users</button>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead class="btn-success">
                            <tr>
                                <th class="text-center">#</th>
                                <th class="text-center">{{ ucwords('Name') }}</th>
                                <th class="text-center">{{ ucwords('Email') }}</th>
                                <th class="text-center">{{ ucwords('Phone') }}</th>
                                <th class="text-center">{{ ucwords('User Type') }}</th>
                                <th class="text-center">{{ ucwords('Status') }}</th>
                                <th class="text-center">{{ ucwords('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach($users as $row)
                                <tr>
                                    <td>{{ $i}}</td>
                                    <td><a href="">
                                            <div class="ul-widget-app__profile-pic"><img class="profile-picture avatar-sm mb-2 rounded-circle img-fluid" src="{{ asset($row->image != null? 'Media/user_profile/'. $row->image:'') }}" alt="" />
                                                <span class="text-capitalize font-weight-bold">{{ $row->name }}</span>
                                            </div>
                                        </a></td>
                                    <td>{{ $row->email }}</td>
                                    <td>{{ $row->mobile != null?$row->mobile:'' }}</td>
                                    <td><a class="badge badge-primary m-2 p-2" href="#"><?php $role = $row->role_id; if ($role==1) {echo "Admin";}else if($role==2){echo "Manager";}else{echo "User";} ?></a></td>
                                    <td><span class="badge badge-success"><?php $statusnew = $row->status; if ($statusnew==1) {echo "Active";}else{echo "Inactive";} ?></span></td>
                                    <td>
                                    <?php
                                        if ($user_id==1){
                                            ?>
                                        <button type="button" class="btn btn-primary btn-sm user_edit" id="{{$row->id}}" ><i class="i-Edit"></i></button>
                                        <?php
                                        }else{
                                            ?>
                                        <button type="button" class="btn btn-primary btn-sm" id="" ><i class="i-Edit"></i></button>
                                        <?php
                                        }
                                    ?>


                                    </td>

                                </tr>
                                @php
                                    $i++;
                                @endphp
                            @endforeach
                            </tbody>
                        </table>
                        <div class="text-center">
                            {{ $users->links() }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



    <div class="modal fade" id="adduser" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">User Registration </h4>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{route('UserData.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="userName" for="">User name :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="username" class="form-control" id="userName" placeholder="User Name" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="EmailAdd" for="">Email Address :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="form-control" id="EmailAdd" autocomplete="off" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Password :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="password" class="form-control" id="" autocomplete="off" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Mobile :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="mobile" class="form-control" id="" autocomplete="off" placeholder="Mobile No">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">User Image :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" name="proficeimage" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="user_edit" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog model-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="">Update Profile</h4>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                        <form action="" class="edituser" method="POST"  enctype="multipart/form-data">
                        @method('PUT')
                        @csrf
                        <input type="hidden" name="oldimage" id="old_image">

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="userName" for="">User name :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" class="form-control" id="name_edit" placeholder="User Name" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="EmailAdd" for="">Email Address :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="form-control" id="Email_edit" autocomplete="off" placeholder="Email Address">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Password :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="newpassword" class="form-control" autocomplete="off" placeholder="Password">
                                </div>
                            </div>
                        </div>
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">Mobile :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="phone" class="form-control" id="mobile_edit" autocomplete="off" placeholder="Mobile No">
                                </div>
                            </div>
                        </div>

                        <div class="modal-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="" for="">User Image :</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="file" name="userimage" class="form-control">
                                </div>
                            </div>
                        </div>


                        <div class="modal-footer">
                            <button type="button" class="btn btn-warning" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

@endsection

@section('page-script')

    <script>
        $(function(){
            $('.user_edit').on('click', function(){
                var userid = $(this).attr("id");
                $.ajax({
                    type: 'GET',
                    url:'/UserData/'+userid+'/edit',
                    success: function (data) {
                        $("#old_image").val(data.image);
                        $("#name_edit").val(data.name);
                        $("#Email_edit").val(data.email);
                        $("#mobile_edit").val(data.mobile);
                        $('.edituser').attr('action', '/UserData/'+userid);
                    }
                });

                $("#user_edit").modal('show');

            });

        });
    </script>

@endsection



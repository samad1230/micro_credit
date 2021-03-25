<header class="main-header bg-white d-flex justify-content-between p-2">
    <div class="header-toggle">
        <div class="menu-toggle mobile-menu-icon">
            <div></div>
            <div></div>
            <div></div>
        </div><i class="i-Add-UserStar mr-3 text-20 cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Todo"></i><i class="i-Speach-Bubble-3 mr-3 text-20 cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Chat"></i><i class="i-Email mr-3 text-20 mobile-hide cursor-pointer" data-toggle="tooltip" data-placement="top" title="" data-original-title="Inbox"></i>
    </div>
    <div class="header-part-right">
{{--        <!-- Full screen toggle--><i class="i-Full-Screen header-icon d-none d-sm-inline-block" data-fullscreen=""></i>--}}
        <!-- Grid menu Dropdown-->
{{--        <div class="dropdown dropleft"><i class="i-Safe-Box text-muted header-icon" id="dropdownMenuButton" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"></i>--}}
{{--            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
{{--                <div class="menu-icon-grid"><a href="#"><i class="i-Shop-4"></i> Home</a><a href="#"><i class="i-Library"></i> UI Kits</a><a href="#"><i class="i-Drop"></i> Apps</a><a href="#"><i class="i-File-Clipboard-File--Text"></i> Forms</a><a href="#"><i class="i-Checked-User"></i> Sessions</a><a href="#"><i class="i-Ambulance"></i> Support</a></div>--}}
{{--            </div>--}}
{{--        </div>--}}

        <div class="dropdown">
            <div class="user col align-self-end">
                @php
                    use Illuminate\Support\Facades\Auth;$userdata = Auth::user();
                   if ($userdata != null){
                       if($userdata->image !=null){
                           $urlimage=URL::to('/Media/user_profile/'.$userdata->image);
                       }else{
                           $urlimage = URL::to('/Media/asset/avature.jpg');
                       }
                   }else{
                     $urlimage = URL::to('/Media/asset/avatar.png');
                   }
                @endphp
                <img src="{{$urlimage}}" id="userDropdown" alt="Image" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                    <div class="dropdown-header">
                        <i class="i-Lock-User mr-1"></i> {{Auth::user()->name}}
                    </div>
                    <a class="dropdown-item" data-toggle="modal" data-target="#updateprofile">Profile Update</a>

{{--                    <a class="dropdown-item" href="{{ route('logout') }}"--}}
{{--                       onclick="event.preventDefault();--}}
{{--                          document.getElementById('logout-form').submit();"><span class="edu-icon edu-locked author-log-ic"></span>--}}
{{--                        {{ __('Sign out') }}--}}
{{--                    </a>--}}

{{--                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">--}}
{{--                        @csrf--}}
{{--                    </form>--}}
                </div>
            </div>
        </div>
    </div>
</header>


<div class="modal fade" id="updateprofile" tabindex="1" role="dialog" aria-labelledby="" aria-hidden="true">
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
                <form action="{{route('profice_update')}}" method="POST" enctype="multipart/form-data">
                    {{csrf_field()}}

                    <input type="hidden" name="userid" value="{{$userdata->id}}">
                    <input type="hidden" name="nameold" value="{{$userdata->name}}">

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class=" " for="Showroom Name">Full Name</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" name="user_name" class="form-control" placeholder="Full Name" value="{{$userdata->name}}">
                            </div>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="" for="Contact">Contact</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="mobile" class="form-control" value="{{@$userdata->mobile}}" placeholder="Contact">
                            </div>
                        </div>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class="" for="Contact">Profile Image</label>
                            </div>
                            <div class="col-md-8">
                                <input type="file" name="profileimage" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class=" " for="Showroom Name">Old Password</label>
                            </div>
                            <div class="col-md-8">
                                <input type="password" name="oldpassword" class="form-control" placeholder="Old Password" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <label class=" " for="Showroom Name">New Password</label>
                            </div>
                            <div class="col-md-8">
                                <input type="password" name="newpassword" class="form-control" placeholder="New Password" autocomplete="off">
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

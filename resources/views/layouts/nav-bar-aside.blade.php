
<div class="sidebar-panel bg-white">
    <div class="gull-brand pr-3 text-center mt-4 mb-2 d-flex justify-content-center align-items-center"><img class="pl-3" src="{{asset('Media/asset/logo.png')}}" alt="alt" />
        <div class="sidebar-compact-switch ml-auto"><span></span></div>
    </div>


    <div class="scroll-nav ps ps--active-y" data-perfect-scrollbar="data-perfect-scrollbar" data-suppress-scroll-x="true">
        <div class="side-nav">
            <div class="main-menu">
                <ul class="metismenu" id="menu">
                    <li class="Ul_li--hover">
                        <a href="{{ route('admin.dashboard') }}">
                            <i class="i-Dashboard text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted{{request()->path() == 'admin/dashboard' ? ' font-weight-bold':''}}">Dashboard</span>
                        </a>
                    </li>

                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="#" {!! request()->path() == 'Member' || request()->path() == 'Member' || strpos(request()->path(),'member') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Love-User text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'Member' || request()->path() == 'Admin/All-Member' || strpos(request()->path(),'member') != false ? 'font-weight-bold':''}}">Members</span>
                        </a>

                        <ul class="mm-collapse {{ request()->path() == 'Member' || request()->path() == 'Admin/All-Member' || strpos(request()->path(),'member') != false ? 'mm-show':''}}">
                            <li class="item-name">
                                <a href="{{ route('Member.index') }}">
                                    <i class="nav-icon i-Add-User"></i>
                                    <span class="item-name {{ request()->path() == 'Member' ? 'font-weight-bold':''}}">Add New Member</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('admin.all-members') }}">
                                    <i class="nav-icon i-Checked-User"></i>
                                    <span class="item-name {{ request()->path() == 'Admin/All-Member' ? 'font-weight-bold':''}}">All Member</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="Ul_li--hover">
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                             document.getElementById('logout-form').submit();">
                            <i class="i-Power-3 text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted">Logout</span>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
<div class="switch-overlay"></div>

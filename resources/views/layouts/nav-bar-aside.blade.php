
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
                            <span class="item-name text-15 text-muted{{request()->path() == 'Admin/Dashboard' ? ' font-weight-bold':''}}">Dashboard</span>
                        </a>
                    </li>

                    <?php
                        if(\Illuminate\Support\Facades\Auth::user()->role_id ==1){
                        ?>


                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Registers' || request()->path() == 'Capital/Details' || request()->path() == 'Cash/Details' || strpos(request()->path(),'member') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Receipt text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'Registers' || request()->path() == 'Capital/Details' ||request()->path() == 'Cash/Details' || strpos(request()->path(),'member') != false ? 'font-weight-bold':''}}">Registers</span>
                        </a>
                        <ul class="mm-collapse {{ request()->path() == 'Registers' || request()->path() == 'Capital/Details' || request()->path() == 'Cash/Details' ? 'mm-show':'' }}">
                            <li class="item-name">
                                <a href="{{ route('Registers.index') }}">
                                    <i class="nav-icon i-Cash-register-2"></i>
                                    <span class="item-name {{ request()->path() == 'Registers' ? 'font-weight-bold':'' }}">Register Book</span>
                                </a>
                            </li>

                            <li class="item-name">
                                <a href="{{ route('Capital.details') }}">
                                    <i class="nav-icon i-Bar-Chart"></i>
                                    <span class="item-name {{ request()->path() == 'Capital/Details' ? 'font-weight-bold':'' }}">Capital Details</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('Cash.details') }}">
                                    <i class="nav-icon i-Receipt-3"></i>
                                    <span class="item-name {{ request()->path() == 'Cash/Details' ? 'font-weight-bold':'' }}">Cash Details</span>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <?php
                            }
                        ?>

                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Member' || request()->path() == 'Member' || strpos(request()->path(),'member') != false ? 'aria-expanded="true"':'' !!}>
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
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Member/Accounts' || request()->path() == 'Penalty/Details'|| request()->path() == 'Invest/Close' || strpos(request()->path(),'memberac') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Money-Bag text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'Member/Accounts' || request()->path() == 'Penalty/Details' ||request()->path() == 'Invest/Close' || strpos(request()->path(),'memberac') != false ? 'font-weight-bold':''}}"> Accounts</span>
                        </a>
                        <ul class="mm-collapse {{ request()->path() == 'Member/Accounts' || request()->path() == 'Penalty/Details' ||request()->path() == 'Invest/Close' || strpos(request()->path(),'memberac') != false ? 'mm-show':'' }}">
                            <li class="nav-item">
                                <a href="{{ route('member.accounts') }}">
                                    <i class="nav-icon i-Checked-User"></i>
                                    <span class="item-name {{ request()->path() == 'Member/Accounts' ? 'font-weight-bold':''}}">Member Accounts</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('investment.close') }}">
                                    <i class="nav-icon i-Checked-User"></i>
                                    <span class="item-name {{ request()->path() == 'Invest/Close' ? 'font-weight-bold':''}}">Invest Close</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('penalty.details')}}">
                                    <i class="nav-icon i-Checked-User"></i>
                                    <span class="item-name {{ request()->path() == 'Penalty/Details' ? 'font-weight-bold':''}}">Penalty Details</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Admin/Investment' || request()->path() == 'Pending/investment'|| request()->path() == 'Admin/All-Investment' || strpos(request()->path(),'Investment') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Money-Bag text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'Admin/Investment' || request()->path() == 'Pending/investment' ||request()->path() == 'Admin/All-Investment' || strpos(request()->path(),'Investment') != false ? 'font-weight-bold':''}}"> Investments</span>
                        </a>
                        <ul class="mm-collapse {{ request()->path() == 'Admin/Investment' || request()->path() == 'Pending/investment' ||request()->path() == 'Admin/All-Investment' || strpos(request()->path(),'Investment') != false ? 'mm-show':'' }}">
                            <li class="item-name">
                                <a href="{{ route('admin.investment') }}">
                                    <i class="nav-icon i-Folder-Add-"></i>
                                    <span class="item-name {{ request()->path() == 'Admin/Investment' ? 'font-weight-bold':'' }}">New Investment</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a href="{{ route('pending.investment') }}">
                                    <i class="nav-icon i-Clock-4"></i>
                                    <span class="item-name {{ request()->path() == 'Pending/investment' ? 'font-weight-bold':'' }}">Pending Invest</span>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{ route('active.all-Investment') }}">
                                    <i class="nav-icon i-Receipt-4"></i>
                                    <span class="item-name {{ request()->path() == 'Admin/All-Investment' ? 'font-weight-bold':'' }}">Active Investment</span>
                                </a>
                            </li>

                        </ul>
                    </li>


                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Collection/investment/Daily' ||request()->path() == 'Collection/Status' || strpos(request()->path(),'collect') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Financial text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'Collection/investment/Daily' ||request()->path() == 'Collection/Status' || strpos(request()->path(),'collect') != false ? 'font-weight-bold':''}}">Collection</span>
                        </a>
                        <ul class="mm-collapse {{ request()->path() == 'Collection/investment/Daily' || request()->path() == 'Collection/Status' || strpos(request()->path(),'collect') != false ? 'mm-show':'' }}">
                            <li class="item-name">
                                <a href="{{ route('collection.daily_installment') }}">
                                    <i class="nav-icon i-Clock-4"></i>
                                    <span class="item-name {{ request()->path() == 'Collection/investment/Daily' ? 'font-weight-bold':'' }}">Collection Daily</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a href="{{ route('collection.status') }}">
                                    <i class="nav-icon i-Clock-4"></i>
                                    <span class="item-name {{ request()->path() == 'Collection/Status' ? 'font-weight-bold':'' }}">Collection Status</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Product' || strpos(request()->path(),'product') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Clothing-Store text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'Product' || strpos(request()->path(),'product') != false ? 'font-weight-bold':''}}">Product Data</span>
                        </a>
                        <ul class="mm-collapse {{ request()->path() == 'Product' || strpos(request()->path(),'product') != false ? 'mm-show':'' }}">
                            <li class="item-name">
                                <a href="{{ route('Product.index') }}">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'Product' ? 'font-weight-bold':'' }}">Product</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Member/Savings' || strpos(request()->path(),'member') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Wallet text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'Member/Savings' || strpos(request()->path(),'member') != false ? 'font-weight-bold':''}}">Savings</span>
                        </a>
                        <ul class="mm-collapse {{ request()->path() == 'Member/Savings' || strpos(request()->path(),'saving') != false ? 'mm-show':'' }}">
                            <li class="item-name">
                                <a href="{{ route('member.saving-account') }}">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'Member/Savings' ? 'font-weight-bold':'' }}">Member Savings</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Member/Search' || strpos(request()->path(),'member') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Statistic text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'Member/Search' || strpos(request()->path(),'member') != false ? 'font-weight-bold':''}}">Reports</span>
                        </a>
                        <ul class="mm-collapse {{ request()->path() == 'Member/Search' || strpos(request()->path(),'saving') != false ? 'mm-show':'' }}">
                            <li class="item-name">
                                <a href="#">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'Member/Search' ? 'font-weight-bold':'' }}">Member Search</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a href="#">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'Member/Search' ? 'font-weight-bold':'' }}">Collection Search</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a href="#">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'Member/Search' ? 'font-weight-bold':'' }}">Pending Collection</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a href="#">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'Member/Search' ? 'font-weight-bold':'' }}">Total Investment</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a href="#">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'Member/Search' ? 'font-weight-bold':'' }}">Total Saving</span>
                                </a>
                            </li>
                        </ul>
                    </li>

{{--                    <li class="Ul_li--hover">--}}
{{--                        <a class="has-arrow" href="javascript:void (0)" >--}}
{{--                            <i class="i-Coins text-20 mr-2 text-muted"></i>--}}
{{--                            <span class="item-name text-15 text-muted">DPS</span>--}}
{{--                        </a>--}}
{{--                        <ul class="mm-collapse">--}}
{{--                            <li class="item-name">--}}
{{--                                <a href="javascript:void (0)">--}}
{{--                                    <i class="nav-icon i-Add-File"></i>--}}
{{--                                    <span class="item-name">Add New DPS</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="item-name">--}}
{{--                                <a href="javascript:void (0)" class="has-arrow">--}}
{{--                                    <i class="nav-icon i-Bar-Chart-3"></i>--}}
{{--                                    <span class="item-name">View in Chart</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}

{{--                            <li class="nav-item">--}}
{{--                                <a href="javascript:void (0)">--}}
{{--                                    <i class="nav-icon i-Receipt-3"></i>--}}
{{--                                    <span class="item-name">View Details</span>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}

                    <?php
                    if(\Illuminate\Support\Facades\Auth::user()->role_id ==1){
                    ?>
                    <li class="Ul_li--hover">
                        <a class="has-arrow" href="javascript:void (0)" {!! request()->path() == 'Company/Profile' || request()->path() == 'UserData' || strpos(request()->path(),'setting') != false ? 'aria-expanded="true"':'' !!}>
                            <i class="i-Gear text-20 mr-2 text-muted"></i>
                            <span class="item-name text-15 text-muted {{ request()->path() == 'CompanyProfice' || request()->path() == 'UserData' || strpos(request()->path(),'setting') != false ? 'font-weight-bold':''}}">Setting</span>
                        </a>
                        <ul class="mm-collapse {{ request()->path() == 'CompanyProfice' || request()->path() == 'UserData' || strpos(request()->path(),'setting') != false ? 'mm-show':'' }}">
                            <li class="item-name">
                                <a href="{{route('CompanyProfice.index')}}">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'CompanyProfice' ? 'font-weight-bold':'' }}">Company Profile</span>
                                </a>
                            </li>
                            <li class="item-name">
                                <a href="{{route('UserData.index')}}">
                                    <i class="nav-icon i-Bar-Chart-2"></i>
                                    <span class="item-name {{ request()->path() == 'UserData' ? 'font-weight-bold':'' }}">User Setting</span>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <?php
                    }
                    ?>
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

<div class="navbar-default sidebar" role="navigation">
    <div class="sidebar-nav navbar-collapse">
        <ul class="nav" >

            <li>
                <a href="#"><i class="fa fa-bar-chart-o fa-fw"></i> Division<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('admin.divisions')}}">List Division</a>
                    </li>
                    <li>
                        <a href="{{route('admin.divisions.new')}}">Add Division</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>

            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i> User<span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('admin.users')}}">List User</a>
                    </li>
                    <li>
                        <a href="{{route('admin.users.new')}}">Add User</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>


            <li>
                <a href="#"><i class="fa fa-users fa-fw"></i><span class="fa arrow"></span></a>
                <ul class="nav nav-second-level">
                    <li>
                        <a href="{{route('admin.users')}}">List User</a>
                    </li>
                    <li>
                        <a href="{{route('admin.users.new')}}">Add User</a>
                    </li>
                </ul>
                <!-- /.nav-second-level -->
            </li>
        </ul>
    </div>
    <!-- /.sidebar-collapse -->
</div>
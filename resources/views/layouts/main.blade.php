<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>HRM</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{asset('bootstrap/css/bootstrap.min.css')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('bower_components/font-awesome/css/font-awesome.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{asset('bower_components/Ionicons/css/ionicons.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('dist/css/AdminLTE.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
    folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{asset('dist/css/skins/_all-skins.min.css')}}">
    <!-- select2 css -->
    
    @yield('styles')
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> -->
  </head>
  <body class="hold-transition skin-blue   sidebar-mini">
    
    <div class="wrapper">
      <header class="main-header">
        <!-- Logo -->
        <a href="{{URL::to('/home')}}" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini"><b>H</b>R</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>HR</b>M</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
          <!--       <form class="navbar-form navbar-left" role="search">
            <div class="form-group">
              <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
            </div>
          </form> -->
          <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
              <!-- Messages: style can be found in dropdown.less-->
              <li class="dropdown messages-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <i class="fa fa-envelope-o"></i>
                  <span class="label label-success">4</span>
                </a>
                <ul class="dropdown-menu">
                  <li class="header">You have 4 messages</li>
                  <li>
                    <!-- inner menu: contains the actual data -->
                    <ul class="menu">
                      <li><!-- start message -->
                      <a href="#">
                        <div class="pull-left">
                          <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
                        </div>
                        <h4>
                        Support Team
                        <small><i class="fa fa-clock-o"></i> 5 mins</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <!-- end message -->
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <!-- <img src="../../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image"> -->
                        </div>
                        <h4>
                        AdminLTE Design Team
                        <small><i class="fa fa-clock-o"></i> 2 hours</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <!-- <img src="../../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image"> -->
                        </div>
                        <h4>
                        Developers
                        <small><i class="fa fa-clock-o"></i> Today</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <!-- <img src="../../dist/img/user3-128x128.jpg" class="img-circle" alt="User Image"> -->
                        </div>
                        <h4>
                        Sales Department
                        <small><i class="fa fa-clock-o"></i> Yesterday</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <div class="pull-left">
                          <!-- <img src="../../dist/img/user4-128x128.jpg" class="img-circle" alt="User Image"> -->
                        </div>
                        <h4>
                        Reviewers
                        <small><i class="fa fa-clock-o"></i> 2 days</small>
                        </h4>
                        <p>Why not buy a new awesome theme?</p>
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">See All Messages</a></li>
              </ul>
            </li>
            <!-- Notifications: style can be found in dropdown.less -->
            <li class="dropdown notifications-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-bell-o"></i>
                <span class="label label-warning">10</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 10 notifications</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-aqua"></i> 5 new members joined today
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-warning text-yellow"></i> Very long description here that may not fit into the
                        page and may cause design problems
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-users text-red"></i> 5 new members joined
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-shopping-cart text-green"></i> 25 sales made
                      </a>
                    </li>
                    <li>
                      <a href="#">
                        <i class="fa fa-user text-red"></i> You changed your username
                      </a>
                    </li>
                  </ul>
                </li>
                <li class="footer"><a href="#">View all</a></li>
              </ul>
            </li>
            <!-- Tasks: style can be found in dropdown.less -->
            <li class="dropdown tasks-menu">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <i class="fa fa-flag-o"></i>
                <span class="label label-danger">9</span>
              </a>
              <ul class="dropdown-menu">
                <li class="header">You have 9 tasks</li>
                <li>
                  <!-- inner menu: contains the actual data -->
                  <ul class="menu">
                    <li><!-- Task item -->
                    <a href="#">
                      <h3>
                      Design some buttons
                      <small class="pull-right">20%</small>
                      </h3>
                      <div class="progress xs">
                        <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                          <span class="sr-only">20% Complete</span>
                        </div>
                      </div>
                    </a>
                  </li>
                  <!-- end task item -->
                  <li><!-- Task item -->
                  <a href="#">
                    <h3>
                    Create a nice theme
                    <small class="pull-right">40%</small>
                    </h3>
                    <div class="progress xs">
                      <div class="progress-bar progress-bar-green" style="width: 40%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only">40% Complete</span>
                      </div>
                    </div>
                  </a>
                </li>
                <!-- end task item -->
                <li><!-- Task item -->
                <a href="#">
                  <h3>
                  Some task I need to do
                  <small class="pull-right">60%</small>
                  </h3>
                  <div class="progress xs">
                    <div class="progress-bar progress-bar-red" style="width: 60%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                      <span class="sr-only">60% Complete</span>
                    </div>
                  </div>
                </a>
              </li>
              <!-- end task item -->
              <li><!-- Task item -->
              <a href="#">
                <h3>
                Make beautiful transitions
                <small class="pull-right">80%</small>
                </h3>
                <div class="progress xs">
                  <div class="progress-bar progress-bar-yellow" style="width: 80%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                    <span class="sr-only">80% Complete</span>
                  </div>
                </div>
              </a>
            </li>
            <!-- end task item -->
          </ul>
        </li>
        <li class="footer">
          <a href="#">View all tasks</a>
        </li>
      </ul>
    </li>
    <!-- User Account: style can be found in dropdown.less -->
    {{-- <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <!-- <img src="../../dist/img/user2-160x160.jpg" class="user-image" alt="User Image"> -->
        <span class="hidden-xs">Alexander Pierce</span>
      </a>
      <ul class="dropdown-menu">
        <!-- User image -->
        <li class="user-header">
          <!-- <img src="../../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image"> -->
          <p>
            Alexander Pierce - Web Developer
            <small>Member since Nov. 2012</small>
          </p>
        </li>
        <!-- Menu Body -->
        <li class="user-body">
          <div class="row">
            <div class="col-xs-4 text-center">
              <a href="#">Followers</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Sales</a>
            </div>
            <div class="col-xs-4 text-center">
              <a href="#">Friends</a>
            </div>
          </div>
          <!-- /.row -->
        </li>
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="pull-left">
            <a href="#" class="btn btn-default btn-flat">Profile</a>
          </div>
          <div class="pull-right">
            <a href="#" class="btn btn-default btn-flat">Sign out</a>
          </div>
        </li>
      </ul>
    </li> --}}
    <li class="dropdown user user-menu">
      <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="hidden-xs">{{ Auth::user()->name }}</span>
      </a>
      {{-- <ul class="dropdown-menu">
        <!-- User image -->
        <!-- Menu Footer-->
        <li class="user-footer">
          <div class="pull-right">
            <a href="{{URL::to('/') . '/auth/logout'}}" class="btn btn-default btn-flat">Sign out</a>
            
          </div>
        </li>
      </ul> --}}
      <ul class="dropdown-menu">
        <li class="user-footer">
          <div class="pull-right">
            <a href="{{ route('logout') }}"
              onclick="event.preventDefault();
              document.getElementById('logout-form').submit();">
              Logout
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>
          </div>
        </li>
        <li class="user-footer">
          <div class="pull-right">
            <a href="{{URL::to('resetmypassword')}}">            <i class="fa "></i>Change Password</a>
          </div>
        </li>
        <li class="user-footer">
          <div class="pull-right">
            <a href="{{URL::to('/favourite_link')}}">            <i class="fa "></i>Shortcut Link Setup</a>
          </div>
        </li>
      </ul>
    </li>
    
    <!-- Control Sidebar Toggle Button -->
  </ul>
</div>
</nav>
</header>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
<!-- sidebar: style can be found in sidebar.less -->
<section class="sidebar">
<ul class="sidebar-menu" data-widget="tree">
  <!-- <li class="header">MAIN NAVIGATION</li> -->
  
  @permission('MainDashboardOption')
  <li {!! Request::is('home') ? ' class="active"' : null !!}>
    <a href="{{URL::to('/home')}}">
      <i class="fa fa-dashboard"></i>
      <span>Dashboard</span>
      <span class="pull-right-container">
      </span>
    </a>
  </li>
  @endpermission
  @permission('MainAdminOption')
  <li {!! Request::is('plant','designation','depertment','category','shift','bloodgroup','religion','maritalstatus','employee','location','section','employeejoin','leavetype','holiday','bulkdataupload','employeecard','employeetransfer','employeeresign','salarygrade','salaryheadgroup','salaryhead','salarygradesetup','leaveyear','leavetypeyear','shiftrole','employeecard/create','employee/create','bonus','bonus/create','employeepromotion','plant','plant_details','users','user_role','assigned_roles','role_permission','role','permission','permission/create','users/create','salaryincrement','salaryincrementpreviousdata','employeeinactive','employeeinactive/create','reactive','employeeresign/create','resignapproved','employeeidcard','employeelongservice','employeelongservice/create','employeetransfercreate','employeepromotioncreate','submitemployeeidcard','service_completed_list','plantwiseemployeelist','plantwiseemployeeadd','plantwithsection','plantwithsection/create','interval_time','device_config','overtime_config') ? ' class="active treeview"' : ' class="treeview"' !!}>
    
    <a href="#">
      <i class="fa fa-user-md"></i>
      <span>Admin</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      @permission('AdminConfiguration')

      <li {!! Request::is('plant','plant/create','designation','plant/create','depertment','depertment/create','category','category/create','shift','shift/create','bloodgroup','bloodgroup/create','religion','religion/create','maritalstatus','maritalstatus/create','location','location/create','section','section/create','leavetype','leavetype/create','holiday','holiday/create','bulkdataupload','leaveyear','leaveyear/create','leavetypeyear','leavetypeyear/create','shiftrole','shiftrole/create','salarygrade','salaryheadgroup','salaryhead','salarygradesetup','bonus','bonus/create','plantwithsection','plantwithsection/create','interval_time','device_config','overtime_config') ? ' class="active treeview"' : ' class="treeview"' !!} >

        <a href="#"><i class="fa fa-random"></i> Configuration
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">

          <li {!! Request::is('interval_time','device_config','overtime_config') ? ' class="active treeview"' : ' class="treeview"' !!} >
            <a href="#"><i class="fa fa-random"></i>Base Configuration
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">

              <li {!! Request::is('interval_time') ? '            class="active"' : null !!}>   <a href="{{URL::to('interval_time')}}">                   <i class="fa fa-circle-o"></i>Interval Time</a></li>
           
              <li {!! Request::is('device_config') ? '            class="active"' : null !!}>   <a href="{{URL::to('device_config')}}">                   <i class="fa fa-circle-o"></i>Device Config</a></li>

              <li {!! Request::is('overtime_config') ? '            class="active"' : null !!}>   <a href="{{URL::to('overtime_config')}}">                   <i class="fa fa-circle-o"></i>Overtime Config</a></li>


           
            </ul>
          </li>




          <li {!! Request::is('religion','religion/create') ? '            class="active"' : null !!}>   <a href="{{URL::to('religion')}}">            <i class="fa fa-circle-o"></i>Religion</a></li>
          <li {!! Request::is('bloodgroup','bloodgroup/create') ? '        class="active"' : null !!}>   <a href="{{URL::to('bloodgroup')}}">          <i class="fa fa-circle-o"></i>Blood Group</a></li>
          <li {!! Request::is('maritalstatus','maritalstatus/create') ? '  class="active"' : null !!}>   <a href="{{URL::to('maritalstatus')}}">       <i class="fa fa-circle-o"></i>Marital Status</a></li>
          <li {!! Request::is('depertment','depertment/create') ? '        class="active"' : null !!}>   <a href="{{URL::to('depertment')}}">          <i class="fa fa-circle-o"></i>Department</a></li>
          <li {!! Request::is('designation','designation/create') ? '      class="active"' : null !!}>   <a href="{{URL::to('designation')}}">         <i class="fa fa-circle-o"></i>Designation</a></li>
          <li {!! Request::is('category','category/create') ? '            class="active"' : null !!}>   <a href="{{URL::to('category')}}">            <i class="fa fa-circle-o"></i>Category</a></li>
          @permission('LocationSetup')
          <li {!! Request::is('location','location/create') ? '            class="active"' : null !!}>   <a href="{{URL::to('location')}}">            <i class="fa fa-circle-o"></i>Location</a></li>
          @endpermission
          <li {!! Request::is('plant','plant/create') ? '                  class="active"' : null !!}>   <a href="{{URL::to('plant')}}">               <i class="fa fa-circle-o"></i>Plant Setup</a></li>
          <li {!! Request::is('section','section/create') ? '              class="active"' : null !!}>   <a href="{{URL::to('section')}}">             <i class="fa fa-circle-o"></i>Sub-department</a></li>
          @permission('PlantWiseSubDept')
          <li {!! Request::is('plantwithsection','plantwithsection/create') ? 'class="active"' : null !!}>   <a href="{{URL::to('plantwithsection')}}">     <i class="fa fa-circle-o"></i>Plant Wise Sub.Dept</a></li>
          @endpermission
          <li {!! Request::is('shift','shift/create') ? '                  class="active"' : null !!}>   <a href="{{URL::to('shift')}}">               <i class="fa fa-circle-o"></i>Work Shifts</a></li>
          <li {!! Request::is('shiftrole','shiftrole/create') ? '          class="active"' : null !!}>   <a href="{{URL::to('shiftrole')}}">           <i class="fa fa-circle-o"></i>Shift Role</a></li>
          <li {!! Request::is('leavetype','leavetype/create') ? '          class="active"' : null !!}>   <a href="{{URL::to('leavetype')}}">           <i class="fa fa-circle-o"></i>Leave Type</a></li>
          <li {!! Request::is('leaveyear','leaveyear/create') ? '          class="active"' : null !!}>   <a href="{{URL::to('leaveyear')}}">           <i class="fa fa-circle-o"></i>Leave Year Setup</a></li>
          <li {!! Request::is('leavetypeyear','leavetypeyear/create') ? '  class="active"' : null !!}>   <a href="{{URL::to('leavetypeyear')}}">       <i class="fa fa-circle-o"></i>Yearly Leave Type Setup</a></li>
          <li {!! Request::is('holiday','holiday/create') ? '              class="active"' : null !!}>   <a href="{{URL::to('holiday')}}">             <i class="fa fa-circle-o"></i>Holiday Setup</a></li>
          <li {!! Request::is('bulkdataupload') ? '                        class="active"' : null !!}>   <a href="{{URL::to('bulkdataupload')}}">      <i class="fa fa-circle-o"></i>Bulk Data Upload</a></li>
          
          @permission('AdminSalaryConfiguration')
          @if (Config::get('module_config.payroll_module') == 1)
          <li {!! Request::is('salarygrade','salaryheadgroup','salaryhead','salarygradesetup','bonus','bonus/create','pf_confiq') ? ' class="active treeview"' : ' class="treeview"' !!} >
            <a href="#"><i class="fa fa-random"></i>Salary Configuration
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li {!! Request::is('salaryheadgroup') ? '        class="active"' : null !!}>   <a href="{{URL::to('salaryheadgroup')}}">               <i class="fa fa-circle-o"></i>Salary Head Group</a></li>
              <!-- <li {!! Request::is('pf_confiq') ? '          class="active"' : null !!}>   <a href="{{URL::to('pf_confiq')}}">                    <i class="fa fa-circle-o"></i>PF Config</a></li> -->
              <li {!! Request::is('salaryhead') ? '             class="active"' : null !!}>   <a href="{{URL::to('salaryhead')}}">                    <i class="fa fa-circle-o"></i>Add Salary Head</a></li>
              <li {!! Request::is('salarygrade') ? '            class="active"' : null !!}>   <a href="{{URL::to('salarygrade')}}">                   <i class="fa fa-circle-o"></i>Salary Grade</a></li>
              <li {!! Request::is('salarygradesetup') ? '       class="active"' : null !!}>   <a href="{{URL::to('salarygradesetup')}}">              <i class="fa fa-circle-o"></i>Salary Grade Setup</a></li>
              <li {!! Request::is('defaultsalaryheadsetup') ? ' class="active"' : null !!}>   <a href="{{URL::to('defaultsalaryheadsetup')}}">        <i class="fa fa-circle-o"></i>Default Head Setup</a></li>
              <li {!! Request::is('bonus') ? '                  class="active"' : null !!}>   <a href="{{URL::to('bonus')}}">                         <i class="fa fa-circle-o"></i>Bonus</a></li>
            </ul>
          </li>
          @endif
          @endpermission
        </ul>
      </li>
      @endpermission
      @permission('AdminEmployeeManagement')
      <li {!! Request::is('employee','employeejoin','employeecard','employeepromotion','employeetransfer','employeeresign','employeecard/create','employee/create','salaryincrement','salaryincrementpreviousdata','employeeinactive','employeeinactive/create','reactive','employeeresign/create','resignapproved','employeeidcard','employeelongservice','employeelongservice/create','employeetransfercreate','employeepromotioncreate','submitemployeeidcard','service_completed_list','plantwiseemployeelist','plantwiseemployeeadd') ? ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#"><i class="fa fa-user-plus"></i>Employee Management
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission('AddEmployee')
          <li {!! Request::is('employee','employee/create') ? '         class="active"' : null !!}>   <a href="{{URL::to('employee')}}">        <i class="fa fa-circle-o"></i>Add Employee</a></li>
          @endpermission
          @permission('EmployeeJoin')
          <li {!! Request::is('employeejoin') ? '     class="active"' : null !!}>   <a href="{{URL::to('employeejoin')}}">    <i class="fa fa-circle-o"></i>Active Employee List</a></li>
          @endpermission
          @permission('EmployeeCard')
          <li {!! Request::is('employeecard','employeecard/create') ? '     class="active"' : null !!}>   <a href="{{URL::to('employeecard')}}">    <i class="fa fa-circle-o"></i>Employee Card</a></li>
          @endpermission
          @permission('EmployeeQualification')
          <!-- <li class="treeview">
            <a href="#"><i class="fa fa-circle-o"></i> Qualifications
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li><a href="#"><i class="fa fa-circle-o"></i> Education</a></li>
              <li><a href="#"><i class="fa fa-circle-o"></i> Skills</a></li>
            </ul>
          </li> -->
          @endpermission
          @permission('CWEmployeeConfig')
          <li {!! Request::is('plantwisesalarycreate','plantwiseemployeeadd','plantwiseemployeelist') ? ' class="active treeview"' : ' class="treeview"' !!} >
            <a href="#"><i class="fa fa-circle-o"></i>CW Employee Config
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li {!! Request::is('plantwiseemployeeadd') ? 'class="active"' : null !!}>   <a href="{{URL::to('plantwiseemployeeadd')}}">     <i class="fa fa-circle-o"></i>Available List</a></li>
              <li {!! Request::is('plantwiseemployeelist') ? 'class="active"' : null !!}>   <a href="{{URL::to('plantwiseemployeelist')}}">     <i class="fa fa-circle-o"></i>Plant Wise Emp. List</a></li>
            </ul>
          </li>
          @endpermission
          @permission('EmployeeTransfer')
          <li {!! Request::is('employeetransfer','employeetransfercreate') ? '     class="active"' : null !!}>   <a href="{{URL::to('employeetransfer')}}">    <i class="fa fa-circle-o"></i>Employee Transfer</a></li>
          @endpermission
          @permission('EmployeePromotion')
          <li {!! Request::is('employeepromotion','employeepromotioncreate') ? '    class="active"' : null !!}>   <a href="{{URL::to('employeepromotion')}}">    <i class="fa fa-circle-o"></i>Employee Promotion</a></li>
          @endpermission
          @permission('EmployeeIncrement')
          <li {!! Request::is('salaryincrement','salaryincrementpreviousdata') ? '    class="active"' : null !!}>   <a href="{{URL::to('salaryincrement')}}">    <i class="fa fa-circle-o"></i>Salary Increment</a></li>
          @endpermission
          @permission('EmployeeResign')
          <li {!! Request::is('employeeresign','employeeresign/create','resignapproved') ? '     class="active"' : null !!}>   <a href="{{URL::to('employeeresign')}}">    <i class="fa fa-circle-o"></i>Employee Resign</a></li>
          @endpermission
          @permission('EmployeeInactive')
          <li {!! Request::is('employeeinactive','employeeinactive/create','reactive') ? '     class="active"' : null !!}>   <a href="{{URL::to('employeeinactive')}}">    <i class="fa fa-circle-o"></i>Employee Inactive</a></li>
          @endpermission
          @permission('EmployeeLongService')
          <li {!! Request::is('employeelongservice','employeelongservice/create','service_completed_list') ? '     class="active"' : null !!}>   <a href="{{URL::to('employeelongservice')}}">    <i class="fa fa-circle-o"></i>Employee Long Service</a></li>
          @endpermission
          @permission('EmployeeIdCardPrint')
          <li {!! Request::is('employeeidcard','submitemployeeidcard') ? '     class="active"' : null !!}>   <a href="{{URL::to('employeeidcard')}}">    <i class="fa fa-circle-o"></i>Employee Id Card Print</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission
      @permission('AdminUserManager')
      <li {!! Request::is('users','user_role','assigned_roles','role_permission','role','permission','permission/create','users/create') ? ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#">
          <i class="fa fa-user"></i>
          <span>User Manager</span>
          <i class="fa fa-angle-left pull-right"></i>
        </a>
        <ul class="treeview-menu">
          <li {!! Request::is('users','users/create') ? '               class="active"' : null !!}>  <a href="{{URL::to('/users')}}">                       <i class="fa fa-user-plus"></i>Create User</a></li>
          <!-- <li {!! Request::is('permissionlist','permission/create') ? ' class="active"' : null !!}>  <a href="{{URL::to('permissionlist')}}">               <i class="fa fa-plus"></i>Permission List</a></li> -->
<!--           <li {!! Request::is('permission','permission/create') ? '     class="active"' : null !!}>  <a href="{{URL::to('permission')}}">      <i class="fa fa-plus"></i>Permission List</a></li> -->
          <li {!! Request::is('role') ? '                               class="active"' : null !!}>  <a href="{{URL::to('/role')}}">                        <i class="fa fa-users"></i>Role</a></li>
          <li {!! Request::is('role_permission') ? '                    class="active"' : null !!}>  <a href="{{URL::to('/role_permission')}}">             <i class="fa fa-tasks"></i>Role Permission</a></li>
          <li {!! Request::is('assigned_roles') ? '                     class="active"' : null !!}>  <a href="{{URL::to('assigned_roles')}}">        <i class="fa fa-share-alt"></i>Roles Assign </a></li>
        </ul>
      </li>
      @endpermission
    </ul>
  </li>
  @endpermission
  @permission('MainAttendanceOption')
  <li {!! Request::is('attendancelist','absentlist','manual_attendance','manual_in','manual_out','manual_ot','manual_ot/create','manual_attendance_entry','manual_ot_all','machinedataupload','approvedholidaylist','data_process','holiday_process','hal_process','holiday_convert','holiday_process/create','holiday_convert/create','employeeleave','leaveapprove','holidayagainstleave','holidayagainstleavedaybook','holidayagainstleave/create','holidayagainstleavehistory','leaveapprovedlist','leaverejectedlist','rawdatacheck','manual_ot_process','manual_ot_view','ot_process_create') ? ' class="active treeview"' : ' class="treeview"' !!}>
    
    <a href="#">
      <i class="fa fa-clock-o"></i>
      <span>Attendance</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      @permission('AttendanceDataUpload')
      <li {!! Request::is('machinedataupload') ? '   class="active"' : null !!}>   <a href="{{URL::to('machinedataupload')}}">   <i class="fa fa-circle-o"></i>Data Upload</a></li>
      @endpermission
      @permission('AttendanceProcess')
      <li {!! Request::is('data_process') ? '        class="active"' : null !!}>   <a href="{{URL::to('data_process')}}">        <i class="fa fa-circle-o"></i>Attandance Process</a></li>
      @endpermission
      @permission('AttendanceList')
      <li {!! Request::is('attendancelist') ? '     class="active"' : null !!}>   <a href="{{URL::to('attendancelist')}}">        <i class="fa fa-circle-o"></i>Attendance List</a></li>
      @endpermission
      @permission('AttendanceManualOption')
      <li {!! Request::is('manual_attendance','manual_in','manual_out','manual_attendance_entry') ? '   class="active treeview"' : ' class="treeview"' !!} >
        <a href="#"><i class="fa fa-circle-o"></i>Manual Attendance
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission('ManualAttendanceEntry')
          <li {!! Request::is('manual_attendance','manual_attendance_entry') ? ' class="active"' : null !!}>   <a href="{{URL::to('manual_attendance')}}">  <i class="fa fa-circle-o"></i>Manual Attendance Entry</a></li>
          @endpermission
          @permission('ManualTotalAttendanceInOut')
          <li {!! Request::is('manual_in') ? '         class="active"' : null !!}>   <a href="{{URL::to('manual_in')}}">          <i class="fa fa-circle-o"></i>Total Attendance In Out</a></li>
          @endpermission
          <!-- @permission('ManualOut')
          <li {!! Request::is('manual_out') ? '        class="active"' : null !!}>   <a href="{{URL::to('manual_out')}}">         <i class="fa fa-circle-o"></i>Manual Attendance Out</a></li>
          @endpermission  -->
        </ul>
      </li>
      @endpermission
      @permission('AttendanceLeaveManagementOption')
      <li {!! Request::is('employeeleave','leaveapprove','holidayagainstleave','holidayagainstleavedaybook','holidayagainstleave/create','holidayagainstleavehistory','leaveapprovedlist','leaverejectedlist') ? ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#"><i class="fa fa-circle-o"></i>Leave Management
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission('LeaveAplication')
          <li {!! Request::is('employeeleave','leaveapprovedlist','leaverejectedlist') ? '        class="active"' : null !!}>   <a href="{{URL::to('employeeleave')}}">       <i class="fa fa-circle-o"></i>Leave Application</a></li>
          @endpermission
          @permission('LeaveAproval')
          <li {!! Request::is('leaveapprove') ? '         class="active"' : null !!}>   <a href="{{URL::to('leaveapprove')}}">        <i class="fa fa-circle-o"></i>Waiting for Leave Approval</a></li>
          @endpermission
          @permission('HolidayAgainstLeave')
          <li {!! Request::is('holidayagainstleave','holidayagainstleavehistory','holidayagainstleave/create') ? '  class="active"' : null !!}>   <a href="{{URL::to('holidayagainstleave')}}">        <i class="fa fa-circle-o"></i>Holiday Against Leave</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission
      @permission('AttendanceManualOTOption')
      <li {!! Request::is('manual_ot','manual_ot/create','manual_ot_all','manual_ot_process','manual_ot_view','ot_process_create') ? '   class="active treeview"' : ' class="treeview"' !!} >
        <a href="#"><i class="fa fa-circle-o"></i>Manual OT
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          
          @permission('ManualOTEntry')
          <li {!! Request::is('manual_ot','manual_ot/create') ? '     class="active"' : null !!}>   <a href="{{URL::to('manual_ot')}}">        <i class="fa fa-circle-o"></i>Manual OT Entry</a></li>
          @endpermission
          @permission('ManualOTEntryAll')
          <li {!! Request::is('manual_ot_all') ? '         class="active"' : null !!}>   <a href="{{URL::to('manual_ot_all')}}">          <i class="fa fa-circle-o"></i>Manual OT Entry All</a></li>
          @endpermission
          @permission('ManualOTEntryAll')
          @endpermission
          <li {!! Request::is('manual_ot_process','ot_process_create') ? '         class="active"' : null !!}>   <a href="{{URL::to('manual_ot_process')}}">          <i class="fa fa-circle-o"></i>Manual OT Process</a></li>
          <li {!! Request::is('manual_ot_view') ? '         class="active"' : null !!}>   <a href="{{URL::to('manual_ot_view')}}">          <i class="fa fa-circle-o"></i>Manual OT View & Edit</a></li>
          <!-- <li {!! Request::is('manual_ot_generate') ? '         class="active"' : null !!}>   <a href="{{URL::to('manual_ot_process')}}">          <i class="fa fa-circle-o"></i>Manual OT Genarate</a></li> -->
        </ul>
      </li>
      @endpermission
      @permission('HolidaySetupProcessOption')
      <li {!! Request::is('holiday_process','holiday_process/create','approvedholidaylist') ? '     class="active"' : null !!}>   <a href="{{URL::to('holiday_process')}}">     <i class="fa fa-circle-o"></i>Holiday Setup & Process</a></li>
      @endpermission
      @permission('HolidayConvertToWorkingOption')
      <li {!! Request::is('holiday_convert','holiday_convert/create') ? '     class="active"' : null !!}>   <a href="{{URL::to('holiday_convert')}}">     <i class="fa fa-circle-o"></i>Holiday Convert To Working</a></li>
      @endpermission
      @permission('AttendanceRawDataCheck')
      <li {!! Request::is('rawdatacheck') ? '     class="active"' : null !!}>   <a href="{{URL::to('rawdatacheck')}}">     <i class="fa fa-circle-o"></i>Raw Data Check</a></li>
      @endpermission
    </ul>
  </li>
  @endpermission
  


  @permission('MainEmployeeShiftOption')
  <li {!! Request::is ('employeeshiftlist','shiftroleemployee','shiftroleassign','shiftroleemployeelist','employeeshiftchange','previou_shiftrole_assign','employeeshiftlist_old','changeshift_multiple','change_employeeshift') ? ' class="active treeview"' : ' class="treeview"' !!}>
    <a href="#">
      <i class="fa fa-arrows-alt"> </i>
      <span>Employee Shift</span>
      
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      @permission('EmployeeShiftList')
      <li {!! Request::is('employeeshiftlist','employeeshiftlist_old','changeshift_multiple','change_employeeshift') ? '  class="active"' : null !!}>   <a href="{{URL::to('employeeshiftlist')}}">     <i class="fa fa-circle-o"></i>Employee Shift List</a></li>
      @endpermission
      @permission('ShiftRoleApply')
      <li {!! Request::is('shiftroleemployee','shiftroleassign','shiftroleemployeelist','previou_shiftrole_assign') ? '   class="active treeview"' : ' class="treeview"' !!} >
        <a href="#"><i class="fa fa-circle-o"></i>Shift Role Apply
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission('ShiftRoleApply')
          <li {!! Request::is('shiftroleemployee') ? '     class="active"' : null !!}>      <a href="{{URL::to('shiftroleemployee')}}">  <i class="fa fa-circle-o"></i>Available Employee</a></li>
          <!-- <li {!! Request::is('shiftroleemployeelist') ? '     class="active"' : null !!}>  <a href="{{URL::to('shiftroleemployeelist')}}">  <i class="fa fa-circle-o"></i>Role Wise Employee List</a></li> -->
          @endpermission
          @permission('ShiftRoleAssign')
          <li {!! Request::is('shiftroleassign','previou_shiftrole_assign') ? '     class="active"' : null !!}>  <a href="{{URL::to('shiftroleassign')}}">  <i class="fa fa-circle-o"></i>Shift Role Assign</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission
      @permission('PreviosShiftChange')
      <li {!! Request::is('employeeshiftchange') ? '  class="active"' : null !!}>   <a href="{{URL::to('employeeshiftchange')}}">     <i class="fa fa-circle-o"></i>Previous Shift Change</a></li>
      @endpermission
      @permission('PreviosShiftChange')
      <li {!! Request::is('wrongshiftassign') ? '  class="active"' : null !!}>   <a href="{{URL::to('wrongshiftassign')}}">     <i class="fa fa-circle-o"></i>Wrong Shift Assign</a></li>
      @endpermission
    </ul>
  </li>
  @endpermission
  


  
  @permission('MainPayrollOption')
  <li {!! Request::is('salarycreate','employeesalary','salaryprocess','payregister','salarygenerate','salaryextrafeatures','salaryextrafeatures/create','loanapplication','loanapplication/create','loantype','loantype/create','loanapprovedlist','loanledger','paidloanledger','otherfacility','otherfacilityprocess','otherfacilitygenerate','ofpayregister','cwsalaryprocess','cwpayregister','cwsalarygenerate','bonusgenerate','employeebonus','bonusprocess','plant_setup','plantwisesalarycreate','otherfacilityconfiq','otherfacilityconfiq/create','salaryprocess/create','cwemployeeinfo') ? ' class="active treeview"' : ' class="treeview"' !!}>
    <a href="#"><i class="fa fa-money"></i>
      <span>Payroll</span>
      <span class="pull-right-container">
        <i class="fa fa-angle-left pull-right"></i>
      </span>
    </a>
    <ul class="treeview-menu">
      
      @permission('PayrollSalaryOption')
      <li {!! Request::is('salarycreate','employeesalary','salaryprocess','payregister','salarygenerate','salaryextrafeatures','salaryextrafeatures/create','salaryprocess/create') ? ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#"><i class="fa fa-circle-o"></i>Salary
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission('EmployeeSalary')
          <li {!! Request::is('employeesalary') ? '   class="active"' : null !!}>   <a href="{{URL::to('employeesalary')}}">      <i class="fa fa-circle-o"></i>Employee Salary</a></li>
          @endpermission
          @permission('SalaryProcess')
          <li {!! Request::is('salaryprocess','salaryprocess/create') ? '    class="active"' : null !!}>   <a href="{{URL::to('salaryprocess')}}">       <i class="fa fa-circle-o"></i>Salary Process</a></li>
          @endpermission
          @permission('PayRegister')
          <li {!! Request::is('payregister') ? '      class="active"' : null !!}>   <a href="{{URL::to('payregister')}}">       <i class="fa fa-circle-o"></i>Pay Register</a></li>
          @endpermission
          @permission('SalaryGenerate')
          <li {!! Request::is('salarygenerate') ? '   class="active"' : null !!}>   <a href="{{URL::to('salarygenerate')}}">       <i class="fa fa-circle-o"></i>Salary Generate</a></li>
          @endpermission
          @permission('SalaryExtraFeatures')
          <li {!! Request::is('salaryextrafeatures','salaryextrafeatures/create') ? '   class="active"' : null !!}>   <a href="{{URL::to('salaryextrafeatures')}}">       <i class="fa fa-circle-o"></i>Salary Special Features</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission
      @permission('PayrollFringeBenefitsOption')
      <li {!! Request::is('otherfacility','otherfacilityprocess','otherfacilitygenerate','ofpayregister','otherfacilityconfiq','otherfacilityconfiq/create') ? ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#"><i class="fa fa-circle-o"></i>Fringe Benefits
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          
          @permission('OtherFacilityProcess')
          
          <li {!! Request::is('otherfacilityconfiq','otherfacilityconfiq/create') ?' class="active"' : null !!}>   <a href="{{URL::to('otherfacilityconfiq')}}">     <i class="fa fa-circle-o"></i>Fringe Benefits Config</a></li>
          
          @endpermission
          @permission('OtherFacility')
          <li {!! Request::is('otherfacility') ? '   class="active"' : null !!}>   <a href="{{URL::to('otherfacility')}}">      <i class="fa fa-circle-o"></i>Employee Fringe Benefits</a></li>
          @endpermission
          @permission('OtherFacilityProcess')
          <li {!! Request::is('otherfacilityprocess') ? '    class="active"' : null !!}>   <a href="{{URL::to('otherfacilityprocess')}}">       <i class="fa fa-circle-o"></i>Fringe Benefits Process</a></li>
          @endpermission
          @permission('OtherFacilityPayRegister')
          <li {!! Request::is('ofpayregister') ? '      class="active"' : null !!}>   <a href="{{URL::to('ofpayregister')}}">       <i class="fa fa-circle-o"></i>FB Pay Register</a></li>
          @endpermission
          @permission('OtherFacilityGenerate')
          <li {!! Request::is('otherfacilitygenerate') ? '   class="active"' : null !!}>   <a href="{{URL::to('otherfacilitygenerate')}}">       <i class="fa fa-circle-o"></i>Fringe Benefits Generate</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission
      @permission('PayrollCWSalaryOption')
      <li {!! Request::is('cwsalaryprocess','cwpayregister','cwsalarygenerate','plant_setup','plantwisesalarycreate','cwemployeeinfo') ? ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#"><i class="fa fa-circle-o"></i>CW Salary
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          
          <li {!! Request::is('plant_setup') ? '        class="active"' : null !!}>   <a href="{{URL::to('plant_setup')}}">          <i class="fa fa-circle-o"></i>Plant-Salary Setup</a></li>
          <li {!! Request::is('cwemployeeinfo') ? '     class="active"' : null !!}>   <a href="{{URL::to('cwemployeeinfo')}}">       <i class="fa fa-circle-o"></i>CW Employee Information</a></li>
          @permission('CWSalaryProcess')
          <li {!! Request::is('cwsalaryprocess') ? '    class="active"' : null !!}>   <a href="{{URL::to('cwsalaryprocess')}}">      <i class="fa fa-circle-o"></i>CW Salary Process</a></li>
          @endpermission
          @permission('CWPayRegister')
          <li {!! Request::is('cwpayregister') ? '      class="active"' : null !!}>   <a href="{{URL::to('cwpayregister')}}">        <i class="fa fa-circle-o"></i>CW Pay Register</a></li>
          @endpermission
          @permission('CWSalaryGenerate')
          <li {!! Request::is('cwsalarygenerate') ? '   class="active"' : null !!}>   <a href="{{URL::to('cwsalarygenerate')}}">     <i class="fa fa-circle-o"></i>CW Salary Generate</a></li>
          @endpermission
        </ul>
      </li>
      
      @endpermission
      @permission('PayrollBonusOption')
      <li {!! Request::is('bonusgenerate','employeebonus','bonusprocess') ? ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#"><i class="fa fa-circle-o"></i>Bonus
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          @permission('BonusProcess')
          <li {!! Request::is('bonusprocess') ? '    class="active"' : null !!}>   <a href="{{URL::to('bonusprocess')}}">       <i class="fa fa-circle-o"></i>Bonus Process</a></li>
          @endpermission
          @permission('EmployeeBonus')
          <li {!! Request::is('employeebonus') ? '   class="active"' : null !!}>   <a href="{{URL::to('employeebonus')}}">      <i class="fa fa-circle-o"></i>Employee Bonus</a></li>
          @endpermission
          @permission('BonusGenerate')
          <li {!! Request::is('bonusgenerate') ? '   class="active"' : null !!}>   <a href="{{URL::to('bonusgenerate')}}">      <i class="fa fa-circle-o"></i>Final Generate</a></li>
          @endpermission
        </ul>
      </li>
      @endpermission
      
      @permission('PayrollLoanManagementOption')
      <li {!! Request::is('loanapplication','loanapplication/create','loantype','loantype/create','loanapprovedlist','loanledger','paidloanledger') ? ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#"><i class="fa fa-circle-o"></i>Loan Management
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li {!! Request::is('loantype','loantype/create') ? '                                         class="active"' : null !!}>   <a href="{{URL::to('loantype')}}">          <i class="fa fa-circle-o"></i>Loan Type</a></li>
          <li {!! Request::is('loanapplication','loanapplication/create','loanapprovedlist') ? '        class="active"' : null !!}>   <a href="{{URL::to('loanapplication')}}">   <i class="fa fa-circle-o"></i>Loan Application</a></li>
          <li {!! Request::is('loanledger','paidloanledger') ? '                                                         class="active"' : null !!}>   <a href="{{URL::to('loanledger')}}">        <i class="fa fa-circle-o"></i>Loan Ledger</a></li>
        </ul>
      </li>
      @endpermission
      
    </ul>
  </li>
  @endpermission
  @permission('MainReportOption')
  <li {!! Request::is('reports') ? ' class="active treeview"' : null !!}>
    <a href="{{URL::to('/reports')}}">
      <i class="fa fa-book"></i>
      <span>Reports</span>
    </a></li>
    @endpermission
    
    @permission('MainDocumentArchiveOption')

    <li {!! Request::is('document_archive') ? ' class="active"' : null !!}>
      <a href="{{URL::to('/document_archive')}}">
        <i class="fa fa-history"></i>
        <span>Document Archive</span>
      </a></li>
      @endpermission

      @permission('MainKPIOption')
      <li {!! Request::is('task_department','task_department/create','kpi_assessment_date_year','kpi_date_setup','kpi_task','kpi_mark','kpi_task_details','kpi_task_details/create','kpi_employee','kpi_employee/create','kpi_increment_range','kpi_deptheadassign','kpi_deptheadassign/create','kpi_markdeduct','kpi_markdeduct/create','kpi_employee_list','kpi_employee_final_list','kpi_report') ?  ' class="active treeview"' : ' class="treeview"' !!}>
        <a href="#"><i class="fa fa-check"></i>
          <span>KPI</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        
        <ul class="treeview-menu">
          
          @permission('KPIAdminUser')
          <li {!! Request::is('task_department','task_department/create','kpi_assessment_date_year','kpi_date_setup','kpi_task','kpi_mark','kpi_task_details','kpi_task_details/create','kpi_increment_range','kpi_deptheadassign','kpi_deptheadassign/create','kpi_markdeduct','kpi_markdeduct/create','kpi_markdeduct','kpi_markdeduct/create') ? ' class="active treeview"' : ' class="treeview"' !!} >
            
            <a href="#"><i class="fa fa-random"></i> Configuration
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li {!! Request::is('kpi_assessment_date_year') ? '                   class="active"' : null !!}>   <a href="{{URL::to('kpi_assessment_date_year')}}">   <i class="fa fa-circle-o"></i>KPI Year Setup</a></li>
              <li {!! Request::is('kpi_date_setup') ? '                             class="active"' : null !!}>   <a href="{{URL::to('kpi_date_setup')}}">             <i class="fa fa-circle-o"></i>KPI Date Range Setup</a></li>
              <li {!! Request::is('kpi_mark') ? '                                   class="active"' : null !!}>   <a href="{{URL::to('kpi_mark')}}">                   <i class="fa fa-circle-o"></i>KPI Mark</a></li>
              <li {!! Request::is('kpi_increment_range') ? '                        class="active"' : null !!}>   <a href="{{URL::to('kpi_increment_range')}}">        <i class="fa fa-circle-o"></i>KPI Increment Range</a></li>
              <li {!! Request::is('task_department','task_department/create') ? '   class="active"' : null !!}>   <a href="{{URL::to('task_department')}}">            <i class="fa fa-circle-o"></i>Task Department</a></li>
              <li {!! Request::is('kpi_task') ? '                                   class="active"' : null !!}>   <a href="{{URL::to('kpi_task')}}">                   <i class="fa fa-circle-o"></i>KPI Task</a></li>
              <li {!! Request::is('kpi_task_details','kpi_task_details/create') ? ' class="active"' : null !!}>   <a href="{{URL::to('kpi_task_details')}}">           <i class="fa fa-circle-o"></i>KPI Task Details</a></li>
              <li {!! Request::is('kpi_markdeduct','kpi_markdeduct/create') ? '     class="active"' : null !!}>   <a href="{{URL::to('kpi_markdeduct')}}">             <i class="fa fa-circle-o"></i>Mark Deduct</a></li>
              <li {!! Request::is('kpi_deptheadassign','kpi_deptheadassign/create') ? '   class="active"' : null !!}>   <a href="{{URL::to('kpi_deptheadassign')}}">   <i class="fa fa-circle-o"></i>KPI Dept.Head Assign</a></li>
              
            </ul>
          </li>
          @endpermission

          @permission('KPIUserOnly')
          <li {!! Request::is('kpi_employee','kpi_employee/create','kpi_employee_list') ? ' class="active treeview"' : ' class="treeview"' !!} >
            <a href="#"><i class="fa fa-random"></i> Employee KPI
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li {!! Request::is('kpi_employee','kpi_employee/create') ? '                   class="active"' : null !!}>   <a href="{{URL::to('kpi_employee')}}">              <i class="fa fa-circle-o"></i>New Employee KPI</a></li>
              <li {!! Request::is('kpi_employee_list') ? '                                    class="active"' : null !!}>   <a href="{{URL::to('kpi_employee_list')}}">         <i class="fa fa-circle-o"></i>Employee KPI List</a></li>
            </ul>
          </li>
          @endpermission

          @permission('KPIAdminUser')
          <li {!! Request::is('kpi_employee_final_list') ? '                              class="active"' : null !!}>   <a href="{{URL::to('kpi_employee_final_list')}}">   <i class="fa fa-check-square"></i>Employee KPI Final List</a></li>
          <li {!! Request::is('kpi_report') ? '                                                   class="active"' : null !!}>   <a href="{{URL::to('kpi_report')}}">                <i class="fa fa-book"></i>KPI Report</a></li>
          @endpermission


        </li>
        @endpermission
      </ul>


      @permission('MobileAppsAttendance')
        <li {!! Request::is ('current_month_app_user','app_user_log') ? ' class="active treeview"' : ' class="treeview"' !!}>
          <a href="#">
            <i class="fa fa-mobile"> </i>
            <span>Mobile Apps Attendance</span>
            
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


            <li {!! Request::is('current_month_app_user') ? '  class="active"' : null !!}>   <a href="{{URL::to('current_month_app_user')}}">     <i class="fa fa-circle-o"></i>Current Month User</a></li>

            <li {!! Request::is('app_user_log') ? '  class="active"' : null !!}>   <a href="{{URL::to('app_user_log')}}">     <i class="fa fa-circle-o"></i>App User Log</a></li>


          </ul>
        </li>
        @endpermission


        <!-- Asset -->
        @permission('MobileAppsAttendance')
        <li {!! Request::is ('asset', 'assetstore', 'assetassign', 'assetreturn') ? ' class="active treeview"' : ' class="treeview"' !!}>
          <a href="#">
            <i class="fa fa-mobile"> </i>
            <span>Asset Management</span>
            
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li {!! Request::is('asset') ? '  class="active"' : null !!}>   
              <a href="{{ route('asset.index')}}">     
                <i class="fa fa-circle-o"></i>New Asset Entry
              </a>
            </li>

            <li {!! Request::is('assetstore') ? '  class="active"' : null !!}> 
              <a href="{{ route('assetstore.index')}}">     
                <i class="fa fa-circle-o"></i>Asset Store
              </a>
            </li>

            <li {!! Request::is('assetassign') ? '  class="active"' : null !!}> 
              <a href="{{ route('assetassign.index')}}">     
                <i class="fa fa-circle-o"></i>Asset Assign
              </a>
            </li>

            <li {!! Request::is('assetreturn') ? '  class="active"' : null !!}> 
              <a href="{{ route('assetreturn.index')}}">     
                <i class="fa fa-circle-o"></i>Asset Return
              </a>
            </li>
          </ul>
        </li>
        @endpermission

        <!-- skill -->
        @permission('MobileAppsAttendance')
        <li {!! Request::is ('skill', 'skillemployeewise') ? ' class="active treeview"' : ' class="treeview"' !!}>
          <a href="#">
            <i class="fa fa-mobile"> </i>
            <span>Skill Management</span>
            
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li {!! Request::is('skill') ? '  class="active"' : null !!}>   
              <a href="{{ route('skill.index')}}">     
                <i class="fa fa-circle-o"></i>New Skill Entry
              </a>
            </li>
            <li {!! Request::is('skillemployeewise') ? '  class="active"' : null !!}> 
              <a href="{{ route('skillemployeewise.index')}}">     
                <i class="fa fa-circle-o"></i>Assign Skill Employee
              </a>
            </li>
          </ul>
        </li>
        @endpermission




    </section>
    <!-- /.sidebar -->
  </aside>
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <!--     <section class="content-header">
      <h1>
      General Form Elements
      <small>Preview</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Forms</a></li>
        <li class="active">General Elements</li>
      </ol>
    </section> -->
    <section class="content" style="padding: 5px; margin-right: auto; margin-left: auto; padding-left: 5px; padding-right: 5px;">
      <div>
        @include('layouts/alert-message')
      </div>
      @yield('content')
    </section>
    <!-- Main content -->
    
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer" style="padding: 5px;">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.4.0
    </div>
    <strong>Copyright &copy; 2017-2019 <a href="http://i-infotechsolution.com" target="_blank">i-infotech </a></strong>
  </footer>
</div>
<script src="{{asset('plugins/jQuery/jquery-2.2.3.min.js')}}"></script>
<script src="{{asset('bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('dist/js/adminlte.min.js')}}"></script>
</body>
@yield('script')
</html>
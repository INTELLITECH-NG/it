	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
	    <!-- sidebar: style can be found in sidebar.less -->
	    <section class="sidebar">
	      <!-- Sidebar user panel -->
	      <div class="user-panel">
	        <div class="pull-left image">
	          <img src="{{ asset('assets/img/avatar5.png') }}" class="img-circle" alt="User Image">
	        </div>
	        <div class="pull-left info">
	          <p>{{ Auth::user()->name }}</p>
	          <i class="fa fa-circle text-success"></i> Online
	        </div>
	      </div>
	      <!-- sidebar menu: : style can be found in sidebar.less -->
	      <ul class="sidebar-menu" data-widget="tree">
	        <li class="header">NAVIGATION</li>
	        <li class="{{ url()->current() ==url('/home') ? 'active' : '' }}">
	          <a href="{{ url('/home') }}">
	            <i class="fa fa-connectdevelop "></i> <span>Home</span>
	          </a>
	        </li>
	        <li class="treeview {{ url()->current() == url('/sendMail') || url()->current() == url('/sendMail/form') || url()->current() == url('/sendMail/details/*') ? 'menu-open active' : '' }}">
	          <a href="#">
	            <i class="fa fa-paper-plane-o"></i> 
	            <span>Send Mail</span>            
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu" style="{{ url()->current() == url('/sendMail') || url()->current() == url('/sendMail/form') ? 'display:block' : '' }}" >
	            <li class="{{ url()->current() == url('/sendMail') ? 'active' : '' }}"><a href="{{ url('/sendMail') }}"><i class="fa fa-circle-o"></i> Send Mail List</a></li>
	            <li class="{{ url()->current() == url('/sendMail/form') ? 'active' : '' }}"><a href="{{ url('/sendMail/form') }}"><i class="fa fa-circle-o"></i> Send New Mail</a></li>
	          </ul>
	        </li>
	        <li class="treeview {{ url()->current() == url('/email') || url()->current() == url('/email/create') ? 'menu-open active' : '' }}">
	          <a href="#">
	            <i class="fa fa-envelope-o"></i>
	            <span>All Accounts</span>	            
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu" style="{{ url()->current() == url('/email') || url()->current() == url('/email/create') || url()->current() == url('/email/import') ? 'display:block' : '' }}" >
	            <li class="{{ url()->current() == url('/email') ? 'active' : '' }}"><a href="{{ url('/email') }}"><i class="fa fa-circle-o"></i> Account List</a></li>
	            <li class="{{ url()->current() == url('/email/create') ? 'active' : '' }}"><a href="{{ url('/email/create') }}"><i class="fa fa-circle-o"></i> Add Account</a></li>
	            <li class="{{ url()->current() == url('/email/import') ? 'active' : '' }}"><a href="{{ url('/email/import') }}"><i class="fa fa-circle-o"></i> Import Accounts</a></li>
	          </ul>
	        </li>
	        <li class="treeview {{ url()->current() == url('/group') || url()->current() == url('/group/create') ? 'menu-open active' : '' }}">
	          <a href="#">
	            <i class="fa fa-cubes"></i>
	            <span>Groups</span>	            
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	            <li class="{{ url()->current() == url('/group') ? 'active' : '' }}"><a href="{{ url('group') }}"><i class="fa fa-circle-o"></i> Group List</a></li>
	            <li class="{{ url()->current() == url('/group/create') ? 'active' : '' }}"><a href="{{ url('/group/create') }}"><i class="fa fa-circle-o"></i> Add Group</a></li>
	          </ul>
	        </li>
	        <li class="header">Settings</li>
	        <li class="{{ url()->current() ==url('/general-settings') ? 'active' : '' }}">
	          <a href="{{ url('/general-settings') }}">
	            <i class="fa fa-sliders"></i> <span>General Setting</span>
	          </a>
	        </li>
	        <li class="{{ url()->current() ==url('/personal-settings') ? 'active' : '' }}">
	          <a href="{{ url('/personal-settings') }}">
	            <i class="fa fa-user-o"></i> <span>Personal Setting</span>
	          </a>
	        </li>
	        <li class="treeview {{ url()->current() == url('/user') || url()->current() == url('/user/create') ? 'menu-open active' : '' }}">
	          <a href="#">
	            <i class="fa fa-users"></i> <span>Users</span>           
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	            <li class="{{ url()->current() == url('/user') ? 'active' : '' }}"><a href="{{ url('/user') }}"><i class="fa fa-circle-o"></i> User List</a></li>
	            <li class="{{ url()->current() == url('/user/create') ? 'active' : '' }}"><a href="{{ url('/user/create') }}"><i class="fa fa-circle-o"></i> Add User</a></li>
	          </ul>
	        </li>
	        <li class="treeview {{ url()->current() == url('/mailer') || url()->current() == url('/mailer/create') ? 'menu-open active' : '' }}">
	          <a href="{{ url('/mailer') }}">
	            <i class="fa fa-server"></i> <span>Mailer Setup</span>           
	            <span class="pull-right-container">
	              <i class="fa fa-angle-left pull-right"></i>
	            </span>
	          </a>
	          <ul class="treeview-menu">
	            <li class="{{ url()->current() == url('/mailer') ? 'active' : '' }}"><a href="{{ url('mailer') }}"><i class="fa fa-circle-o"></i> Mailer List</a></li>
	            <li class="{{ url()->current() == url('/mailer/create') ? 'active' : '' }}"><a href="{{ url('/mailer/create') }}"><i class="fa fa-circle-o"></i> Add Mailer</a></li>
	          </ul>
	        </li>
	        <li class="">
	          <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i><span>Log out</span>
	          </a>
			  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  {{ csrf_field() }}
              </form>
	        </li>
	      </ul>
	    </section>
	    <!-- /.sidebar -->
	</aside>
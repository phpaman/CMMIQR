<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="{{ asset('public/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
      <span class="brand-text font-weight-light">CMMI QR</span>
    </a>
    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('public/dist/img/avatar.png')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">ADMIN</a>
        </div>
      </div>
      <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div>
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item menu-open">
            <a href="{{ route('admin.dashboard')}}" class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{ route('admin.events')}}" class="nav-link {{ Request::routeIs('admin.events') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Events
              </p>
            </a>
          </li>
           <li class="nav-item {{ Request::routeIs('admin.mainattendees') ? 'menu-is-opening menu-open' : '' }} ">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-chart-pie"></i>
              <p>
                Attendees
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ route('admin.mainattendees')}}" class="nav-link {{ Request::routeIs('admin.mainattendees') ? 'active' : '' }}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Main Attendees</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item menu-open">
            <a href="{{ route('admin.sponsers')}}" class="nav-link {{ Request::routeIs('admin.sponsers') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Sponsers
              </p>
            </a>
          </li>
          <li class="nav-item menu-open">
            <a href="{{ route('admin.bookings')}}" class="nav-link {{ Request::routeIs('admin.bookings') ? 'active' : '' }}">
              <i class="nav-icon fas fa-book"></i>
              <p>
                Bookings
              </p>
            </a>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

<nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin') ? 'active' : ''}}" aria-current="page" href="{{ route('admin') }}">
          <span data-feather="home"></span>
          Dashboard
        </a>
        <a class="nav-link {{ Request::is('admin') ? 'active' : ''}}" aria-current="page" href="{{ route('admin') }}">
          <span data-feather="user"></span>
          Data Customer
        </a>
      </li>

        {{-- <a class="nav-link {{ Request::is('sales/customer/*') ? 'active' : ''}}" href="{{ route('sales.complate') }}">
          <span data-feather="user"></span>
          Customer
        </a>

        <a class="nav-link {{ Request::is('sales/antrian') ? 'active' : ''}}" href="{{ route('sales.antrian') }}">
          <span data-feather="chevrons-right"></span>
          Antrian
        </a>
   

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 border-bottom">
    </div>

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
        <span>aset</span>
      </h6>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 border-bottom">
    </div> --}}


    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
      <span>Coverage Area</span>
    </h6>

    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/area*') ? 'active' : ''}}" href="{{ route('admin.area') }}">
          <span data-feather="globe"></span>
          Area
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/placement*') ? 'active' : ''}}" href="{{ route('admin.placement') }}">
          <span data-feather="map-pin"></span>
          Placement
        </a>
      </li>
    </ul>

    <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
      <span>Persediaan</span>
    </h6>

    <ul class="nav flex-column mb-2">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin') ? 'active' : ''}}" href="{{ route('admin.area') }}">
          <span data-feather="hard-drive"></span>
          Modem
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('admin/tiang*') ? 'active' : ''}}" href="{{ route('admin.tiang') }}">
          <span data-feather="more-vertical"></span>
          Tiang
        </a>
      </li>
    </ul>
    
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-1 pb-2 mb-1 border-bottom">
    </div>

    <li class="nav-item">
      <form action="/" method="post">
        @csrf
        <button type="submit" class="nav-link border-0 bg-transparent">
          <span data-feather="log-out"></span> Logout
        </button>
      </form>
    </li>

  

  </ul>
  </div>

</nav>
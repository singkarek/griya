
<nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('sales') ? 'active' : ''}}" aria-current="page" href="/sales">
          <span data-feather="home"></span>
          Dashboard
        </a>
      </li>
      @cannot('admin')
        
      
      <li class="nav-item">
        <a class="nav-link {{ Request::is('sales/customers*') ? 'active' : ''}}" href="/sales/customers">
          <span data-feather="user"></span>
          Customers
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('sales/prosespemasangan*') ? 'active' : ''}}" href="/sales/prosespemasangan">
          <span data-feather="chevrons-right"></span>
          Progress Pemasangan 
        </a>
      </li>

      {{-- <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      </div> --}}

      {{-- <li class="nav-item">
        <a class="nav-link {{ Request::is('sales/customers/surveyadmin') ? 'active' : ''}}" href="/sales/customers/surveyadmin">
          <span data-feather="compass"></span>
          Survey Admin
        </a>
      </li> --}}
      @endcannot
      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
      </div>
    
      <li class="nav-item">
        <a class="nav-link {{ Request::is('sales/maps-access*') ? 'active' : ''}}" href="/sales/maps-access">
          <span data-feather="map"></span>
          Access (Drop Point)
        </a>
      </li> 

  </ul>
  </div>

</nav>
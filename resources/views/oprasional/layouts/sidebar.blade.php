
<nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">

      <li class="nav-item">
        <a class="nav-link {{ Request::is('oprasional') ? 'active' : ''}}" aria-current="page" href="/oprasional">
          <span data-feather="home"></span> Dashboard
        </a>
      </li>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      </div>

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
        <span>Work Orders</span>
      </h6>
  
      <li class="nav-item">
        {{-- <a class="nav-link {{ Request::is('admin/area*') ? 'active' : ''}}" aria-current="page" href="">
          <span data-feather="layers"></span> Pemasangan Baru Today
        </a> --}}
      </li>
      <li class="nav-item">
        <a class="nav-link {{ Request::is('oprasional/allpsb') ? 'active' : ''}}" aria-current="page" href="/oprasional/allpsb">
          <span data-feather="chevrons-right"></span> All Pemasangan Baru
        </a>
      </li>

      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-2 border-bottom">
      </div>

      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
        <span>New Cutomers</span>
      </h6>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('oprasional/antrian/requestvalidasi*') ? 'active' : ''}}" aria-current="page" href="/oprasional/antrian/requestvalidasi">
          <span data-feather="check"></span> Request Validasi
        </a>
      </li>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('oprasional/antrian/payment') ? 'active' : ''}}" aria-current="page" href="/oprasional/antrian/payment">
          <span data-feather="clock"></span> Wait List
        </a>
      </li>


      <li class="nav-item">
        <a class="nav-link {{ Request::is('oprasional/antrian/penjadwalan') ? 'active' : ''}}" aria-current="page" href="/oprasional/antrian/penjadwalan">
          <span data-feather="calendar"></span> Penjadwalan
        </a>
      </li>


      <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-1 border-bottom">
      </div>
      
      <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-2 mb-1 text-muted">
        <span>Olt</span>
      </h6>

      <li class="nav-item">
        <a class="nav-link {{ Request::is('validasi') ? 'active' : ''}}" aria-current="page" href="">
          <span data-feather="file-text"></span> Registrasi
        </a>
      </li>


  

  </ul>
  </div>

</nav>
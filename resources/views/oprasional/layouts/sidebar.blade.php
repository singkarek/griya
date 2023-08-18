
<nav id="sidebarMenu" class="col-md-2 col-lg-2 d-md-block bg-light sidebar collapse">
  <div class="position-sticky pt-3">
    <ul class="nav flex-column">
      <li class="nav-item">
        <a class="nav-link {{ Request::is('sales') ? 'active' : ''}}" aria-current="page" href="/sales">
          <span data-feather="home"></span>
          Dashboard
        </a>
      </li>



    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
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
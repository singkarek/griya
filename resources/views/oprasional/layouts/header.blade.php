
<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Griya | Oprasional</a>

    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    {{-- <input class="form-control form-control-dark w-100" type="text" placeholder="Search" aria-label="Search"> --}}
    <div class="navbar-nav">
      <div class="nav-item text-nowrap">

        <div class="row mx-5">
          <div class="col navbar-brand-a ">
            <a class="col navbar-brand-b {{ Request::is('sales*') ? 'navbar-brand-b.active' : ''}}" style="text-decoration: none;" href="/sales">Sales</a>
          </div>
          <div class="col navbar-brand-a ">
            <a class="col navbar-brand-b {{ Request::is('oprasional*') ? 'active' : ''}} " style="text-decoration: none;" href="/oprasional">Oprasional</a>
          </div>
          <div class="col navbar-brand-a ">
            <a class="navbar-brand-b " style="text-decoration: none;" href="/admin">Admin</a>
          </div>
        </div>

      </div>
    </div>
  </header>
@extends('sales.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Customers Prospects</h1>
</div>

@if ($errors->any())
<div class="alert alert-danger col-lg-9">
    <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

@if(session()->has('error'))
  <div class="alert alert-danger col-lg-9" role="alert">
      {{ session('error') }}
  </div>
@endif

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="table-responsive col-lg-9">

<a href="/sales/customers/create" class="btn btn-primary mb-3">Customer Baru</a>



  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Alamat</th>
        <th scope="col">No Tlp</th>
        <th scope="col">Action</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($customers as $customer )
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $customer->nama }}</td>
            <td>{{ $customer->alamat }}</td>
            <td>{{ $customer->no_tlp }}</td>
            <td>
              @if($customer->status_proggres == 'foto_rumah')
              <a href="/sales/customers/fotorumah/{{ $customer->id }}/edit" class="badge btn-success"><span data-feather="edit"></span> Foto Rumah</a>
              @endif

              @if($customer->status_proggres == 'koordinat')
              <a href="/sales/customers/koordinat/{{  $customer->id }}/edit" class="badge btn-success"><span data-feather="edit"></span> Koordinat Rumah</a>
              @endif

              @if($customer->status_proggres == 'access')
              <a href="/sales/customers/access/{{ $customer->id }}/edit" class="badge btn-success"><span data-feather="edit"></span> Pilih ODP</a>
              @endif

              @if($customer->status_proggres == 'jalur')
              <a href="/sales/customers/jalur/{{ $customer->id }}/edit" class="badge btn-success"><span data-feather="edit"></span> Buat Jalur</a>
              @endif

              @if($customer->status_proggres == 'siap_pengajuan')
                <form action="/sales/customers/pengajuan/{{ $customer->id }}" method="post" class="d-inline">
                    @csrf
                    <button class="badge btn-primary border-0" onclick="return confirm('Yakin Ajukan Pemasangan ?')"><span data-feather="edit"></span> Ajukan Pemasangan</button>
                </form>
              @endif

              {{-- <a href="/sales/prospect/{{ $customer->id }}/detail" class="badge btn-warning"><span data-feather="edit"></span> Detail</a> --}}
            </td>
          </tr>
      @endforeach
    </tbody>
  </table>
</div>


@endsection


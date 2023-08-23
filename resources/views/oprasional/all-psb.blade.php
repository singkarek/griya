@extends('oprasional.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">All Pemasangan Baru</h1>
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

{{-- {{ $customers }} --}}

<div class="table-responsive col-lg-9">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Paket layanan</th>
        <th scope="col">Alamat</th>
        <th scope="col">Tanggal</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($customers as $customer )
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $customer->nama }}</td>
            <td>{{ $customer->nama_layanan }}</td>
            <td>{{ $customer->alamat }}</td>
            <td>{{ $customer->tgl_jadwal }}</td>
            {{-- <td>
              @if($customer->status_wo == 'prosess_validasi')
                <a href="/oprasional/antrian/requestvalidasi/{{ $customer->pppoe_secret }}/edit" class="badge btn-success"><span data-feather="edit"></span> Konfigurasi</a>
              @endif
            </td> --}}
          </tr>
      @endforeach
    </tbody>
  </table>
</div>


@endsection


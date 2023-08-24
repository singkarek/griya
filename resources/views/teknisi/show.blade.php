@extends('teknisi.layouts.main')

@section('container')


  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    {{-- <h1 class="h2">selamat datang, {{ auth()->user()->name }}</h1> --}}
    <h1 class="h2">Teknisi</h1>
  </div>

{{-- {{ auth()->user()->is_admin }} --}}

{{-- {{ $customers }} --}}

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

{{ $customers }}

<div class="table-responsive col-lg-9">
  {{-- <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Paket layanan</th>
        <th scope="col">Alamat</th>
        <th scope="col">Action</th>
        <th scope="col">Detail</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($customers as $customer )
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $customer->nama }}</td>
            <td>{{ $customer->nama_layanan }}</td>
            <td>{{ $customer->alamat }}</td>
            <td>
              @if($customer->status_proggres == 'jadwal_terbit')
                <a href="/teknisi/{{ $customer->pppoe_secret }}/penarikan" class="badge btn-success"><span data-feather="edit"></span> Mulai Penarikan</a>
              @endif
              @if($customer->status_proggres == 'mulai_penarikan')
                <a href="/teknisi/{{ $customer->pppoe_secret }}/ajukanreg" class="badge btn-success"><span data-feather="edit"></span> Ajukan Regist</a>
              @endif
              @if($customer->status_proggres == 'ajukan_reg')
                Menunggu Registrasi
              @endif
            </td>
            <td>
              @if($customer->status_proggres == 'jadwal_terbit')
              <a href="/teknisi/{{ $customer->pppoe_secret }}/penarikan" class="badge btn-warning"><span data-feather="edit"></span> Detail</a>
              @else
              -
              @endif
            </td>
          </tr>
      @endforeach
    </tbody>
  </table>
</div> --}}


@endsection
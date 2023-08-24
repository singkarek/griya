@extends('sales.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Prosess Customer</h1>
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

<div class="table-responsive col-lg-10">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Paket layanan</th>
        <th scope="col">Alamat</th>
        <th scope="col">No Tlp</th>
        <th scope="col">Status</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($customers as $customer )
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $customer->nama }}</td>
            <td>{{ $customer->nama_layanan }}</td>
            <td>{{ $customer->alamat }}</td>
            <td>{{ $customer->no_tlp }}</td>
            <td>
              @if($customer->status_wo == 'prosess_validasi')
                Menunggu validasi
              @endif
              @if($customer->status_wo == 'tervalidasi' & $customer->subscribe_status == 'pra_wo')
                Menunggu payment
              @endif
              @if($customer->status_wo == 'tervalidasi' & $customer->subscribe_status == 'paid' & $customer->status_proggres == null)
                Menunggu Penjadwalan
              @endif
              @if($customer->status_wo == 'tervalidasi' & $customer->subscribe_status == 'paid' & $customer->status_proggres == 'jadwal_terbit')
                Menunggu Pemasangan
              @endif
              @if($customer->status_wo == 'tervalidasi' & $customer->subscribe_status == 'paid' & $customer->status_proggres == 'mulai_penarikan' || $customer->status_proggres == 'ajukan_reg')
                Prosess Pemasangan
              @endif
              @if($customer->status_wo == 'tervalidasi' & $customer->subscribe_status == 'paid' & $customer->status_proggres == 'reg_done')
                Pemasangan selesai
              @endif
            </td>
          </tr>
      @endforeach
    </tbody>
  </table>
</div>


@endsection


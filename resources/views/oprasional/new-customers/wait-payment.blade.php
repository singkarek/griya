@extends('oprasional.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-1 border-bottom">
    <h1 class="h4">Menunggu pembayaran</h1>
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
      </tr>
    </thead>
    <tbody>
      @foreach ($customers as $customer )
        @if($customer->subscribe_status == "pra_wo")
          
       
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $customer->nama }}</td>
            <td>{{ $customer->nama_layanan }}</td>
            <td>{{ $customer->alamat }}</td>
          </tr>

        @endif
      @endforeach
    </tbody>
  </table>
</div>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-1 border-bottom">
  <h1 class="h4">Menunggu Penjadwalan</h1>
</div>
{{-- {{ $customers }} --}}
<div class="table-responsive col-lg-9">
  <table class="table table-striped table-sm">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nama</th>
        <th scope="col">Paket layanan</th>
        <th scope="col">Alamat</th>
        <th scope="col">Tgl Pembayaran</th>
      </tr>
    </thead>
    <tbody>
      @foreach ($customers as $customer )
      @if($customer->subscribe_status == "paid")
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $customer->nama }}</td>
            <td>{{ $customer->nama_layanan }}</td>
            <td>{{ $customer->alamat }}</td>
            {{-- <td>{{ $customer->payment_date->format('d M Y') }}</td> --}}
            <td> {{ \Carbon\Carbon::parse($customer->payment_date)->format('d-M-Y H:i') }}</td>
          </tr>
        @endif
      @endforeach
    </tbody>
  </table>
</div>


@endsection


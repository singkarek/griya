@extends('admin.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Modem Tersedia</h1>
  </div>

  @if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
  @endif
{{-- {{ $modems }} --}}
  <a href="/admin/modem/create" class="btn btn-primary mb-3">Input Modem</a>

  <div class="table-responsive col-lg-9">
    <table class="table table-striped table-sm">
      <thead class="thead-light">
        <tr>
          <th class="w-10">#</th>
          <th class="w-45">Kode ref</th>
          <th class="w-45">Supplier</th>
          <th class="w-45">Brand</th>
          <th class="w-45">Type</th>
          <th class="w-45">Serial Number</th>
          <th class="w-45">Harga</th>
          <th class="w-45">Tanggal Belanja</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($modems as $modem )
        <tr>
          <td >{{ $loop->iteration }}</td>
          <td >{{ $modem->ref }}</td>
          <td >{{ $modem->supplier }}</td>
          <td >{{ $modem->brand }}</td>
          <td >{{ $modem->type }}</td>
          <td >{{ $modem->sn }}</td>
          <td >Rp {{ number_format( $modem->harga, 0, ',', '.') }} </td>
          <td >{{ $modem->tanggal_belanja }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection
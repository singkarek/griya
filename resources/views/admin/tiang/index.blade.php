@extends('admin.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Tiang Tersedia</h1>
  </div>

  @if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
  @endif

  <a href="{{ route('admin.tiang.create') }}" class="btn btn-primary mb-3">Input Tiang Baru</a>

  <div class="table-responsive col-lg-9">
    <table class="table table-striped table-sm">
      <thead class="thead-light">
        <tr>
          <th class="w-10">#</th>
          <th class="w-45">Kode ref</th>
          <th class="w-45">Nama Tiang</th>
          <th class="w-45">Vendor</th>
          <th class="w-45">Tinggi</th>
          <th class="w-45">Harga</th>
          <th class="w-45">Tanggal Belanja</th>


        </tr>
      </thead>
      <tbody>
        @foreach ($tiangs as $tiang )
        <tr>
          <td >{{ $loop->iteration }}</td>
          <td >{{ $tiang->ref }}</td>
          <td >{{ $tiang->nama_tiang }}</td>
          <td >{{ $tiang->vendor }}</td>
          <td >{{ $tiang->tinggi }}</td>
          <td > Rp {{ number_format( $tiang->harga, 0, ',', '.') }} </td>
          <td >{{ $tiang->created_at->format('d M Y') }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>




@endsection
@extends('admin.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Tiang</h1>
  </div>

  @if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
  @endif

  <a href="{{ route('admin.tiang.create') }}" class="btn btn-primary mb-3">Input Tiang Baru</a>

  <div class="table-responsive col-lg-9">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama Tiang</th>
          {{-- <th scope="col">Kode Area</th> --}}

        </tr>
      </thead>
      <tbody>
        @foreach ($tiangs as $tiang )
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $tiang->nama_tiang }}</td>
   
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection
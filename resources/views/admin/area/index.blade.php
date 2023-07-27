@extends('admin.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Area</h1>
  </div>

  @if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
  @endif

  <a href="{{ route('area.create') }}" class="btn btn-primary mb-3">Buat Area Baru</a>

  <div class="table-responsive col-lg-9">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama Area</th>
          <th scope="col">Kode Area</th>

        </tr>
      </thead>
      <tbody>
        @foreach ($areas as $area )
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $area->nama_area }}</td>
          <td>{{ $area->kode_area }}</td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection
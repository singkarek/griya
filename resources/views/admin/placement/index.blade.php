@extends('admin.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Placement</h1>
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
  
 

  <a href="{{ route('admin.placement.create') }}" class="btn btn-primary mb-3">Buat Placement Baru</a>

  
  <div class="table-responsive col-lg-9">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Nama Area</th>
          <th scope="col">Kode Area</th>
          <th scope="col">Nama Area</th>
          <th scope="col">Jenis Tempat</th>
          <th scope="col">Action</th>

        </tr>
      </thead>
      <tbody>
      
        @foreach ($places as $place )
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $place->nama_area }}</td>
          <td>{{ $place->kode_area }}</td>
          <td>{{ $place->nama_tempat }}</td>
          <td>{{ $place->jenis_tempat }}</td>
          <td>
            @if ($place->lat == "")
              <a href='/admin/placement/{{ $place->id }}/edit' class="badge btn-danger"><span data-feather="edit"></span> Add Koordinat</a>
            @else
            <a href='/admin/placement/{{ $place->id }}/edit' class="badge btn-warning"><span data-feather="edit"></span> Edit</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

@endsection
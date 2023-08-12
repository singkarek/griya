@extends('admin.layouts.main')

@section('container')
  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Konfigurasi Splitters - {{ $places[0]['nama_area'] }} - {{ $places[0]['kode_area'] }}</h1>
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
    {{-- <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Place</th>
          <th scope="col">Jenis Tempat</th>
          <th scope="col">Alamat</th>
          <th scope="col">Type Spliter</th>
          <th scope="col">Action</th>

        </tr>
      </thead>
      <tbody>
      
        @foreach ($places as $place => $nama_tempat)
        <tr>
          <td>{{ $loop->iteration }}</td>
           @if($place === 0 || $nama_tempat->nama_tempat !== $places[$place - 1]->nama_tempat)
            <td>{{ $nama_tempat->nama_tempat }}</td>
           @else
            <td> </td>
           @endif
          <td>
            {{ $nama_tempat->type_spliter }}
          </td>
          <td>
            @if($nama_tempat->alamat == null | $nama_tempat->jenis_tempat == null )
             -
            @else
              <a href='/admin/area/splitter/{{ $nama_tempat->id }}/edit/splitter' class="badge btn-success"><span data-feather="plus-square"></span> Add</a>
            @endif
          </td>
        </tr>
        @endforeach

      </tbody>
    </table> --}}
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          <th scope="col">#</th>
          <th scope="col">Place</th>
          <th scope="col">Jenis Tempat</th>
          <th scope="col">Alamat</th>
          <th scope="col">Type Spliter</th>
          <th scope="col">Action</th>

        </tr>
      </thead>
      <tbody>
      
        @foreach ($places as $place )
        <tr>
          <td>{{ $loop->iteration }}</td>
          <td>{{ $place->nama_tempat }}</td>
          <td>
             {{ $place->jenis_tempat == null ?  "-"  : $place->jenis_tempat }}
          </td>
          <td>
             {{ $place->alamat == null ? "-" : $place->alamat }}
          </td>
          <td>
             {{-- {{ $place->oke == null ? "-" : $place->oke }} --}} {{ $place->ok }}
          </td>
          <td>
            @if($place->alamat == null | $place->jenis_tempat == null )
             -
            @else
              <a href='/admin/area/splitter/{{ $place->id }}/edit/splitter' class="badge btn-success"><span data-feather="plus-square"></span> Add</a>
              <a href='/admin/area/splitter/{{ $place->id }}/remove/splitter' class="badge btn-danger"><span data-feather="minus-square"></span></a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
{{ $places[0] }}
@endsection
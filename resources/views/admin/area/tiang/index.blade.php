@extends('admin.layouts.main')

@section('container')


  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Konfigurasi Tiang - {{ $places[0]['nama_area'] }} - {{ $places[0]['kode_area'] }}</h1>
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

  {{-- {{ $places }} --}}

  <div class="table-responsive col-lg-9">
    <table class="table table-striped table-sm">
      <thead>
        <tr>
          {{-- <th scope="col">#</th> --}}
          <th scope="col">Place</th>
          <th scope="col">Jenis Tempat</th>
          <th scope="col">Nama Tiang</th>
          <th scope="col">Alamat</th>
          <th scope="col">Action</th>

        </tr>
      </thead>
      <tbody>
      
        @foreach ($places as $place )
        <tr>
          {{-- <td>{{ $loop->iteration }}</td> --}}
          <td>{{ $place->nama_tempat }}</td>
          <td>
             {{ $place->jenis_tempat == null ?  "-"  : $place->jenis_tempat }}
          </td>
          <td>
             {{ $place->nama_tiang == null ?  "-"  : $place->nama_tiang }}
          </td>
          <td>
            @if($place->alamat == null)
              -
            @else
              {{ $place->alamat }}
            @endif
          </td>
          <td>
            @if($place->jenis_tempat == null)
              <a href='/admin/area/tiang/{{ $place->placement_id }}/create/tempat' class="badge btn-danger"><span data-feather="plus-square"></span> Tiang</a>
              @else
              <a href='/admin/area/tiang/{{ $place->placement_id }}/edit/tempat' class="badge btn-warning"><span data-feather="edit"></span> Tiang</a>
            @endif
            @if ($place->lat == null)
              <a href='/admin/area/tiang/{{ $place->placement_id }}/edit/koordinat' class="badge btn-danger"><span data-feather="plus-square"></span> Koordinat</a>
            @else
            <a href='/admin/area/tiang/{{ $place->placement_id }}/edit/koordinat' class="badge btn-warning"><span data-feather="edit"></span> Koordinat</a>
            @endif
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
{{-- {{ $place }} --}}
@endsection
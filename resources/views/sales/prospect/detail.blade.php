@extends('sales.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Melengkapi</h1>
</div>

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="col-lg-9">

  <table class="table">
    <tbody>
      <tr>
        <th scope="row" >Foto KTP <span data-feather="chevrons-right"></span></i></th>
        <td><input class="form-control" type="file" id="formFile"></td>
        {{-- <td><a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Upload</a></td> --}}
      </tr>
      <tr>
        <th scope="row">Foto Rumah</th>
        <td><input class="form-control" type="file" id="formFile"></td>
        {{-- <td><a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Upload</a></td> --}}
      </tr>
      <tr>
        <th scope="row">Pilih koordinat rumah</th>
        {{-- <td><a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Chose</a></td> --}}
      </tr>
      <th scope="row">Pilih ODP</th>
      {{-- <td><a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Chose</a></td> --}}
      </tr>
      <tr>
        <th scope="row">Buat jalur</th>
        {{-- <td><a href="{{ route('sales.create') }}" class="btn btn-primary mb-3">Chose</a></td> --}}
      </tr>
    </tbody>
  </table>

  <button type="submit" class="btn btn-primary">Update Data</button>

</div>

@endsection
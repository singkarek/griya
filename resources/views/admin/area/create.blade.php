@extends('admin.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Area</h1>
</div>

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="col-lg-9">

<form method="post" action="/admin/create/area" autocomplete="">
    @csrf

        <div class="mb-2">
          <label for="nama_area" class="form-label">Nama Area</label>
          <input type="text" class="form-control @error('nama_area') is-invalid @enderror" id="nama_area" name='nama_area' required autofocus value="{{ 
           old('nama_area') }}">
          @error('nama_area')
              <div class="ivalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-2  col-lg-4">
            <label for="kode_area" class="form-label">Kode Area</label>
            <input maxlength="5" minlength="5" type="text" class="form-control @error('kode_area') is-invalid @enderror" id="kode_area" name='kode_area' required value="{{ 
             old('kode_area') }}">
            @error('kode_area')
                <div class="ivalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>

    <button type="submit" class="btn btn-primary ">Simpan</button>
  </form>

</div>

@endsection
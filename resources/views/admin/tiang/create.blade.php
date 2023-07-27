@extends('admin.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Input Tiang</h1>
</div>

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="col-lg-9">

<form method="post" action="/admin/tiang/store" autocomplete="">
    @csrf

      <div class="mb-2">
        <label for="harga" class="form-label">Total Harga</label>
        <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name='harga' required autofocus value="{{ 
          old('harga') }}">
        @error('harga')
            <div class="ivalid-feedback">
              {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="jumlah_tiang" class="form-label">Jumlah Tiang</label>
        <input type="text" class="form-control @error('jumlah_tiang') is-invalid @enderror" id="jumlah_tiang" name='jumlah_tiang' required autofocus value="{{ 
          old('jumlah_tiang') }}">
        @error('jumlah_tiang')
            <div class="ivalid-feedback">
              {{ $message }}
            </div>
        @enderror
      </div>



    <button type="submit" class="btn btn-primary ">Simpan</button>
  </form>

</div>

@endsection
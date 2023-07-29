@extends('admin.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h3">Input Tiang</h1>
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
        <label for="ref" class="h6 form-label">Kode Ref Belanja</label>
        <input maxlength="15" type="text" class="form-control @error('ref') is-invalid @enderror" id="ref" name='ref' required autofocus value="{{ 
          old('ref') }}">
        @error('ref')
            <div class="ivalid-feedback">
              {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-2">
        <label for="vendor" class="h6 form-label">Vendor Tiang</label>
        <input type="text" class="form-control @error('vendor') is-invalid @enderror" id="vendor" name='vendor' required value="{{ 
          old('vendor') }}">
        @error('vendor')
            <div class="ivalid-feedback">
              {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-3 ">
        <label for="tinggi" class="h6 form-label @error('tinggi') is-invalid @enderror" >Tinggi(M)</label>
        <select class="form-select" name="tinggi">
          <option value="7M-400-300" >7M-400-300</option>         
          <option value="9M-600-300" >9M-600-300</option>         
        </select>
      </div>

      <div class="mb-3 ">
        <label for="ukuran" class="h6 form-label @error('ukuran') is-invalid @enderror" >Ukuran(dim)</label>
        <select class="form-select" name="ukuran">
          <option value="4-3.5" >4-3.5"</option>         
          <option value="3-2.5" >3-2.5"</option>         
        </select>
      </div>

      <div class="mb-3 ">
        <label for="tebal" class="h6 form-label @error('tebal') is-invalid @enderror" >Tebal(mm)</label>
        <select class="form-select" name="tebal">
          <option value="2.8" >1.8 mm</option>         
          <option value="2.8" >2.8 mm</option>         
          <option value="3" >3 mm</option>         
        </select>
      </div>
      


      <div class="mb-3">
        <label for="harga" class="h6 form-label">Total Harga</label>
        <input type="text" class="form-control @error('harga') is-invalid @enderror" id="harga" name='harga' required value="{{ 
          old('harga') }}">
        @error('harga')
            <div class="ivalid-feedback">
              {{ $message }}
            </div>
        @enderror
      </div>

      <div class="mb-4">
        <label for="jumlah_tiang" class="h6 form-label">Jumlah Tiang</label>
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
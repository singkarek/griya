@extends('oprasional.layouts.main')

@section('container')

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

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
  {{-- <h1 class="h2">selamat datang, {{ auth()->user()->name }}</h1> --}}
  <h1 class="h2">Penjadwalan</h1>
</div>

{{-- < class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom"> --}}


<form>
  {{-- <label for="due_date">Due Date:</label>
  <input type="date" id="due_date" name="due_date">


  <div class="mb-2">
    <label for="nama_area" class="form-label">Nama Area</label>
    <input type="date" class="form-control @error('nama_area') is-invalid @enderror" id="nama_area" name='nama_area' required autofocus value="{{ 
     old('nama_area') }}">
    @error('nama_area')
        <div class="ivalid-feedback">
          {{ $message }}
        </div>
    @enderror
  </div> --}}



</form>

<form>
  <div>
    {{-- <label for="datepicker">Date:</label> --}}
    {{-- <input type="text" class="form-control" id="datepicker" name="datepicker" required> --}}
  </div>


  <div class="form-group mb-3 mt-3">
    <div class="row mb-2">
      <div class="col-md-3">
        <label for="type" class="h6 form-label" >Ketua tim</label>
        <select class="form-select" name="type">
          <option value="F607-V7" >F607-V7</option>         
          <option value="ZTE" >ZTE</option>         
        </select>
      </div>
      <div class="col-md-3">
        <label for="type" class="h6 form-label" >Helper 1</label>
        <select class="form-select" name="type">
          <option value="F607-V7" >F607-V7</option>         
          <option value="ZTE" >ZTE</option>         
        </select>
      </div>
      <div class="col-md-3">
        <label for="connector" class="h6 form-label" >Helper 2</label>
        <select class="form-select" name="connector">
          <option value="UPC" >UPC</option>         
          <option value="APC" >APC</option>         
        </select>
      </div>
      {{-- <div class="col-md-4">
        <label for="totalbelanja" class="h6 form-label">Total Item</label>
        <input type="number" class="form-control" id="totalbelanja" name='totalbelanja' disabled>
      </div> --}}
    </div>
  </div>


  <div class="form-group mb-3 mt-3">
    <div class="row mb-2">
      <div class="col-md-3">
        <label for="datepicker" class="h6 form-label">Tgl Pemasangan:</label>
        <input type="text" placeholder="02-10-1995" class="form-control" id="datepicker" name="datepicker" required autocomplete="off">
      </div>
      <div class="col-md-3">
        <label for="type" class="h6 form-label" >SN Modem</label>
        <select class="form-select" name="type">
          <option value="F607-V7" >F607-V7</option>         
          <option value="ZTE" >ZTE</option>         
        </select>
      </div>
      {{-- <div class="col-md-2">
        <label for="connector" class="h6 form-label" >Connector</label>
        <select class="form-select" name="connector">
          <option value="UPC" >UPC</option>         
          <option value="APC" >APC</option>         
        </select>
      </div>
      <div class="col-md-4">
        <label for="totalbelanja" class="h6 form-label">Total Item</label>
        <input type="number" class="form-control" id="totalbelanja" name='totalbelanja' disabled>
      </div> --}}
    </div>
  </div>

  <div class="mt-4">
    <button type="submit" class="btn btn-primary">Submit</button>
  </div>



</form>

<script>
  $(function() {
      $("#datepicker").datepicker({
          dateFormat: "dd-mm-yy",
          // maxDate: 0 // Batasi tanggal yang dapat dipilih hingga hari ini
      });
  });
  </script>
  
@endsection
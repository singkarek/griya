@extends('sales.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Customer</h1>
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

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="col-lg-9">

<form method="post" action="/sales/customers/store" autocomplete="">
    @csrf

          <div class="mb-3 ">
            <label for="metodes_id" class="h6 form-label @error('metodes_id') is-invalid @enderror" >Customer mendapatkan info dari ?</label>
            <select class="form-select" name="metodes_id">
              @foreach ($metodes as $metode)
              <option value="{{ $metode->id }}" >{{ $metode->metode}}</option>         
              @endforeach
              <option selected>--- Pilih Metode ---</option>
            </select>
        </div>

        <div class="mb-2">
          <label for="nama" class="h6 form-label">Nama Customer (Nama lengkap)</label>
          <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name='nama' required value="{{ 
           old('nama') }}">
          @error('nama')
              <div class="ivalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-2">
            <label for="alamat" class="h6 form-label">Alamat Customer (Domisili)</label>
            <input type="text" class="form-control @error('alamat') is-invalid @enderror" id="alamat" name='alamat' required value="{{ 
             old('alamat') }}">
            @error('alamat')
                <div class="ivalid-feedback">
                  {{ $message }}
                </div>
            @enderror
          </div>

        <div class="row mb-2">

            <div class="col">
                <label for="rt" class="h6 form-label">RT</label>
                <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name='rt' required value="{{ 
                 old('rt') }}">
                @error('rt')
                    <div class="ivalid-feedback">
                      {{ $message }}
                    </div>
                @enderror
              </div>

              <div class="col">
                <label for="rw" class="h6 form-label">RW</label>
                <input type="text" class="form-control @error('rw') is-invalid @enderror" id="rw" name='rw' required value="{{ 
                 old('rw') }}">
                @error('rw')
                    <div class="ivalid-feedback">
                      {{ $message }}
                    </div>
                @enderror
              </div>

        </div>

        <div class="mb-3">
            <label for="no_tlp" class="h6 form-label">No Tlp</label>
            <input type="number" class="form-control @error('no_tlp') is-invalid @enderror" id="no_tlp" name='no_tlp' required value="{{ 
                old('no_tlp') }}">
            @error('no_tlp')
                <div class="ivalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3 ">
            <label for="service_packages_id" class="h6 form-label @error('service_packages_id') is-invalid @enderror" >Paket layanan</label>
            <select class="form-select" name="service_packages_id">
              @foreach ($layananpakets as $paket)
              <option value="{{ $paket->id }}" >{{ $paket->nama_layanan}} | Rp {{ number_format( $paket->harga, 0, ',', '.') }}</option>         
              @endforeach
              <option selected>--- Pilih Paket ---</option>
            </select>
        </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>

</div>



@endsection
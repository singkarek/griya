@extends('sales.layouts.main')

@section('container')


<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Create Customer</h1>
</div>

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif

<div class="col-lg-9">

<form method="post" action="/sales/create/customer" autocomplete="">
    @csrf

        <div class="mb-2">
          <label for="nama" class="form-label">Nama Customer</label>
          <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name='nama' required autofocus value="{{ 
           old('nama') }}">
          @error('nama')
              <div class="ivalid-feedback">
                {{ $message }}
              </div>
          @enderror
        </div>

        <div class="mb-2">
            <label for="alamat" class="form-label">Alamat Customer</label>
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
                <label for="rt" class="form-label">RT</label>
                <input type="text" class="form-control @error('rt') is-invalid @enderror" id="rt" name='rt' required value="{{ 
                 old('rt') }}">
                @error('rt')
                    <div class="ivalid-feedback">
                      {{ $message }}
                    </div>
                @enderror
              </div>

              <div class="col">
                <label for="rw" class="form-label">RW</label>
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
            <label for="no_tlp" class="form-label">No Tlp</label>
            <input type="number" class="form-control @error('no_tlp') is-invalid @enderror" id="no_tlp" name='no_tlp' required value="{{ 
                old('no_tlp') }}">
            @error('no_tlp')
                <div class="ivalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="mb-3 ">
            <label for="id_paket_layanan" class="h6 form-label @error('id_paket_layanan') is-invalid @enderror" >Paket layanan</label>
            <select class="form-select" name="id_paket_layanan">
              @foreach ($layananpakets as $paket)
              <option value="{{ $paket->id }}" >{{ $paket->nama_layanan}} | Rp {{ number_format( $paket->harga, 0, ',', '.') }}</option>         
              @endforeach
              {{-- <option selected></option> --}}
            </select>
        </div>

    <button type="submit" class="btn btn-primary">Simpan</button>
  </form>

</div>



@endsection
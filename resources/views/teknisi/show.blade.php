@extends('teknisi.layouts.main')

@push('css')
<style>
  input.link-like {
  color: blue;
  }

</style>
@endpush


@section('container')


  <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    {{-- <h1 class="h2">selamat datang, {{ auth()->user()->name }}</h1> --}}
    <h1 class="h2">Teknisi</h1>
  </div>

{{-- {{ auth()->user()->is_admin }} --}}

{{-- {{ $customers }} --}}

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

{{-- {{ $customers }} --}}

{{-- <div class="table-responsive col-lg-11"> --}}

  <div class="form-group mb-2">
    <div class="row mb-2">
      <div class="col-md-3">
        <label for="area" class="h6 form-label">Nama</label>
        <input type="text" class="form-control" id="nama" name='nama' disabled value="{{ old('nama',$customers[0]->nama) }}">
      </div>
      <div class="col-md-3">
        <label for="alamat" class="h6 form-label">Alamat</label>
        {{-- <input type="text" class="form-control" id="alamat" name='alamat' disabled  value="{{ old('alamat',$customers[0]->alamat) }}"> --}}
        <input type="text" class="form-control link-like" id="alamat" value="{{ old('alamat',$customers[0]->alamat) }}" onclick="confirmAndOpenLink('https://www.google.com/maps/search/?api=1&query={{ $customers[0]->lat_customer }},{{ $customers[0]->lng_customer }}');" readonly  >
      </div>
      <div class="col-md-3">
        <label for="no_tlp" class="h6 form-label">Tlp(WA)</label>
        <input type="text" class="link-like form-control" id="no_tlp" value="{{ old('nama',$customers[0]->no_tlp) }}" onclick="confirmAndOpenLink('https://wa.me/{{ $customers[0]->no_tlp }}');" readonly>
      </div>

    </div>
</div>
<div class="form-group mb-2">
    <div class="row mb-2">
      <div class="col-md-2">
        <label for="nama_layanan" class="h6 form-label">Paket Layanan</label>
        <input type="text" class="form-control" id="nama_layanan" name='nama_layanan' disabled value="{{ old('nama_layanan',$customers[0]->nama_layanan) }}">
      </div>
      <div class="col-md-2">
        <label for="harga" class="h6 form-label">Paket Layanan</label>
        <input type="text" class="form-control" id="harga" name='harga' disabled value="{{ old('harga',$customers[0]->harga) }}">
      </div>

    </div>
</div>
<div class="form-group mb-4">
    <div class="row mb-2">
      <div class="col-md-3">
        <label for="area" class="h6 form-label">Area</label>
        <input type="text" class="form-control" id="area" name='area' disabled value="{{ old('harga',$customers[0]->nama_area) }}">
      </div>
      <div class="col-md-3">
        <label for="access" class="h6 form-label">Access</label>
        <input type="text" class="form-control link-like" id="access" value="{{ old('access', $customers[0]->kode_area." ".$customers[0]->parent_ke.".".$customers[0]->spliter_ke ) }}" onclick="confirmAndOpenLink('https://www.google.com/maps/search/?api=1&query={{ $customers[0]->lat_place }},{{ $customers[0]->lng_place }}');" readonly  >
      </div>
      <div class="col-md-3">
        <label for="access" class="h6 form-label">port ke</label>
        <input type="text" class="form-control" id="access" name='access' disabled value="{{ old('access', $customers[0]->port_access) }}">
      </div>
    </div>
</div>
<div class="form-group mb-4">
    <div class="row mb-2">
      <div class="col-md-3">
        <label for="area" class="h6 form-label">Perkiraan Panjang kabel</label>
        <input type="text" class="form-control" id="area" name='area' disabled value="{{ old('harga',$customers[0]->length_text) }}">
      </div>
      {{-- <div class="col-md-3">
        <label for="access" class="h6 form-label">Access</label>
        <input type="text" class="form-control" id="access" name='access' disabled value="{{ old('access', $customers[0]->kode_area." ".$customers[0]->parent_ke.".".$customers[0]->spliter_ke ) }}">
      </div>
      <div class="col-md-3">
        <label for="access" class="h6 form-label">port ke</label>
        <input type="text" class="form-control" id="access" name='access' disabled value="{{ old('access', $customers[0]->port_access) }}">
      </div>
    </div> --}}
</div>

{{-- </div> --}}

<script>
  function confirmAndOpenLink(url) {
    // Menampilkan kotak dialog konfirmasi
    var confirmation = confirm("Apakah Anda yakin ingin membuka tautan ini di tab baru?");
    
    // Jika pengguna mengkonfirmasi, buka tautan dalam tab baru
    if (confirmation) {
      window.open(url, '_blank');
    }
  }
  </script>

@endsection
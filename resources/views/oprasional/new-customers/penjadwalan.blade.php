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



<div class="form-group mb-3 mt-3">
  <div class="row mb-2">
    <div class="col-md-3">
      <label for="nameDropdown" class="h6 form-label" >Nama Customer</label>
      <select class="form-select" name="nameDropdown" id="nameDropdown">
        <option value="">Pilih Nama</option>
        @foreach($customers as $person)
            <option value="{{ $person['nama'] }}">{{ $person['nama'] }}</option>
        @endforeach         
      </select>
    </div>
</div>

<div class="form-group mb-3 mt-4">
  <div class="row mb-9">
    <div class="col-md-9">
      <input type="text" id="alamat" placeholder="Alamat" class="form-control" readonly>
    </div>
</div>

<div class="form-group mb-3 mt-2">
  <div class="row mb-2">
    <div class="col-md-3">
      <input type="text" id="paket_layanan" placeholder="Paket layanan" class="form-control" readonly>
    </div>
    <div class="col-md-3">
      <input type="text" id="harga" placeholder="Harga" class="form-control" readonly>
    </div>
    <div class="col-md-3">
      <input type="text" id="access" placeholder="Access" class="form-control" readonly>
    </div>
</div>



<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom col-lg-9">
</div>

<form>
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
  </div>

  <input type="text" id='pppoe_secret' value="" hidden>

  <div class="form-group mb-3 mt-3">
    <div class="row mb-2">
      <div class="col-md-3">
        <label for="datepicker" class="h6 form-label">Tgl Pemasangan:</label>
        <input type="text" placeholder="02-10-1995" class="form-control" id="datepicker" name="datepicker" required autocomplete="off">
      </div>
      <div class="col-md-3">
        <label for="type" class="h6 form-label" >SN Modem</label>
        <select class="form-select" name="type">
          @foreach ($modems as $modem )
            <option value="F607-V7" >{{ $modem->sn }}</option>         
          @endforeach        
        </select>
      </div>
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

  document.addEventListener('DOMContentLoaded', function() {
        const people = {!! json_encode($customers) !!};
        const nameDropdown = document.getElementById('nameDropdown');
        const harga = document.getElementById('harga');
        const alamat = document.getElementById('alamat');
        const paketlayanan = document.getElementById('paket_layanan');
        const access = document.getElementById('access');
        const pppoe_secret = document.getElementById('pppoe_secret');

        nameDropdown.addEventListener('change', function() {
          const selectedName = nameDropdown.value;
          const selectedPerson = people.find(person => person.nama === selectedName);
          console.log(selectedPerson)

            if (selectedPerson) {
              alamat.value = selectedPerson.alamat;
              paketlayanan.value = selectedPerson.nama_layanan;
              harga.value = selectedPerson.harga;
              pppoe_secret.value = selectedPerson.pppoe_secret;
              access.value = selectedPerson.kode_area+" "+`${selectedPerson.parent_ke}.${selectedPerson.spliter_ke}`;
            } else {
              alamat.value = '';
            }
        });
    });
  </script>
  
@endsection
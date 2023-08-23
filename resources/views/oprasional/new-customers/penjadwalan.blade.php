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

<form method="post" action="/oprasional/antrian/penjadwalan" autocomplete="">
  @csrf

<div class="form-group mb-3 mt-3">
  <div class="row mb-2">
    <div class="col-md-3">
      <label for="pppoe_secret" class="h6 form-label" >Nama Customer</label>
      <select class="form-select" name="pppoe_secret" id="pppoe_secret" required>
        <option value="">--- Pilih Nama ---</option>
        @foreach($customers as $person)
            <option value="{{ $person['pppoe_secret'] }}">{{ $person['nama'] }}</option>
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


  <div class="form-group mb-3 mt-3">
    <div class="row mb-2">
      <div class="col-md-3">
        <label for="katim_id" class="h6 form-label" >Ketua tim</label>
        <select class="form-select" name="katim_id" required>
          <option value="">--- Pilih Teknisi ---</option>
          @foreach ($teknisi as $tek )
            <option value="{{ $tek->karyawan_nip }}" >{{ $tek->nama_lengkap }}</option>         
          @endforeach        
        </select>
      </div>
      {{-- <div class="col-md-3">
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
      </div> --}}
  </div>


  <div class="form-group mb-3 mt-3">
    <div class="row mb-2">
      <div class="col-md-3">
        <label for="tgl_jadwal" class="h6 form-label">Tgl Pemasangan:</label>
        <input type="text" placeholder="02-10-1995" class="form-control" id="tgl_jadwal" name="tgl_jadwal" required autocomplete="off">
      </div>

      <div class="col-md-3">
        <label for="sn_modem" class="h6 form-label" >SN Modem</label>
        <select class="form-select" name="sn_modem" required>
          <option value="">--- Serial Number Modem ---</option>
          @foreach ($modems as $modem )
            <option value="{{ $modem->sn }}" >{{ $modem->sn }}</option>         
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
      $("#tgl_jadwal").datepicker({
          dateFormat: "dd-mm-yy",
          // maxDate: 0 // Batasi tanggal yang dapat dipilih hingga hari ini
      });
  });

  document.addEventListener('DOMContentLoaded', function() {
        const people = {!! json_encode($customers) !!};
        const pppoe_secret = document.getElementById('pppoe_secret');
        const harga = document.getElementById('harga');
        const alamat = document.getElementById('alamat');
        const paketlayanan = document.getElementById('paket_layanan');
        const access = document.getElementById('access');

        pppoe_secret.addEventListener('change', function() {
          const selectedName = pppoe_secret.value;
          const selectedPerson = people.find(person => person.pppoe_secret === selectedName);
          // console.log(selectedPerson)

          // console.log(harga)
            if (selectedPerson) {
              alamat.value = selectedPerson.alamat;
              paketlayanan.value = selectedPerson.nama_layanan;
              harga.value = 'Rp '+ selectedPerson.harga.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
              access.value = selectedPerson.kode_area+" "+`${selectedPerson.parent_ke}.${selectedPerson.spliter_ke}`;
            } else {
              alamat.value = '';
            }
        });
    });
  </script>
  
@endsection
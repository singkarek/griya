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

    <div class="mb-3 ">
        <label for="area_id" class="h6 form-label @error('area_id') is-invalid @enderror" >Area</label>
        <select class="form-select" name="area_id">
          @foreach ($areas as $area)
          <option value="{{ $area->id }}" >{{ $area->nama_area}} | {{ $area->kode_area }}</option>         
          @endforeach
        </select>
    </div>

    <div class="mb-3 ">
        <label for="nama_tempat" class="h6 form-label @error('nama_tempat') is-invalid @enderror" >Place</label>
        <select id='nama_tempat' class="form-select" name="nama_tempat">
          <option>Pilih Tiang</option>         
          <option value="Tiang Beton PLN" >Tiang Beton PLN</option>         
          <option value="Tiang Telkom Lama" >Tiang Telkom Lama</option>         
          <option value="Tiang Sendiri" >Tiang Sendiri</option>         
      
        </select>
    </div>

    <div class="mb-3" id="myDiv" hidden >
      <label for="tiang_id" class="h6 form-label @error('tiang_id') is-invalid @enderror" >Tiang</label>
      <select id="dropdown" class="form-select" name="tiang_id">

        <option>Pilih Tiang</option>
      </select>
    </div>



    <button type="submit" class="btn btn-primary ">Simpan</button>

  </form>

</div>


<script>
    const nama_tempat = document.querySelector('#nama_tempat');
    var divElement = document.getElementById("myDiv");
    var dropdownElement = document.getElementById('dropdown');

    nama_tempat.addEventListener('change', function(){
      var selectedValue = nama_tempat.value;

      if(selectedValue != "Tiang Sendiri"){
        divElement.hidden = true;
      }else{
        divElement.hidden = false;
        fetch('/admin/placement/create/tiangs')
          .then( response => response.json())
          .then( item =>  {

            item.tiangbos.forEach(item => {
              var optionElement = document.createElement('option');
              optionElement.value = item.id
              optionElement.innerText = `${item.nama_tiang} | ${item.tinggi} | ${item.vendor}`
              dropdownElement.appendChild(optionElement)
            })
        })
      }
    });

</script>

@endsection
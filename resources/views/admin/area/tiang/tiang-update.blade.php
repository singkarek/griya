@extends('admin.layouts.main')

@section('container')

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h3 class="h3">Jenis Tiang - {{ $place[0]['nama_area'] }} - {{ $place[0]['nama_tempat'] }}</h3>
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

@if(session()->has('error'))
    <div class="alert alert-danger col-lg-9" role="alert">
        {{ session('error') }}
    </div>
@endif

<div class="col-lg-9">

<form method="post" action="/admin/area/tiang/edit/tempat" autocomplete="">
  @csrf
    <div class="mb-3 ">
        {{-- <label for="jenis_tempat" class="h6 form-label @error('jenis_tempat') is-invalid @enderror" >Jenis Tempat</label> --}}
        <select id='jenis_tempat' class="form-select" name="jenis_tempat">
          <option value="">Pilih Tiang</option>         
          <option value="Tiang Beton PLN" >Tiang Beton PLN</option>         
          <option value="Tiang Telkom Lama" >Tiang Telkom Lama</option>         
          <option value="Tiang Sendiri" >Tiang Sendiri</option>         
        </select>
    </div>

    <div class="mb-3" id="myDiv" hidden >
      <label for="tiang_id" class="h6 form-label @error('tiang_id') is-invalid @enderror" >Tiang</label>
      <select id="dropdown" class="form-select" name="tiang_id">
        <option value="0">Pilih Tiang</option>
      </select>
    </div>
    <input type="text" value={{ $place[0]['id'] }} name='id' required hidden>
    <input type="text" value={{ $place[0]['area_id'] }} name='area_id' required hidden>
    <button type="submit" class="btn btn-primary ">Simpan</button>

  </form>

</div>

{{-- {{ $place }} --}}
<?php
$area_id = [$place[0]['area_id'],$type];
?>

<script>
    const jenis_tempat = document.querySelector('#jenis_tempat');
    var divElement = document.getElementById("myDiv");
    var dropdownElement = document.getElementById('dropdown');

    var area = @json($area_id)
     
    jenis_tempat.addEventListener('change', function(){
      var selectedValue = jenis_tempat.value;

      if(selectedValue != "Tiang Sendiri"){
        divElement.hidden = true;
      }else{
        const url = '/admin/area/tiang/tiangs/'+area[0]+'/'+area[1]
        fetch(url)
          .then( response => response.json())
          .then( item =>  {
            if(item.tiang.length == 0){
              return;
            }
            // console.log(item.tiang)
            divElement.hidden = false;
            item.tiang.forEach(item => {
              var optionElement = document.createElement('option');
              if(item["nama_tempat"] == null){
                optionElement.innerText = `${item.nama_tiang} | ${item.tinggi} | ${item.vendor}`
              }else{
                optionElement.innerText = `${item.nama_tiang} | ${item.tinggi} | ${item.vendor} | ${item.nama_tempat}`
              }
              optionElement.value = item.id
              
              dropdownElement.appendChild(optionElement)
            })
        })
      }
    });

</script>

@endsection
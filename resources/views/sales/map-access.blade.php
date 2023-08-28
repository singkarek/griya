@extends('sales.layouts.main')

@push('css')
    {{-- css google map --}}
    <link href="/css/map.css" rel="stylesheet">
@endpush

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

@if(session()->has('success'))
    <div class="alert alert-success col-lg-9" role="alert">
        {{ session('success') }}
    </div>
@endif
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Accsess</h1>
    </div>
    {{-- <form method="post" action="/admin/area/tiang/edit/koordinat" autocomplete=""> --}}
        {{-- @method('put') --}}
        {{-- @csrf --}}
    <div class="form-group mb-3">
        <div class="row mb-2">
            <div class="col-md-3">
                <input type="text" class="form-control" placeholder="Alamat atau Koordinat" id="locationInput" name='locationInput' required >
            </div>
            <div class="col-md-1">
            {{-- <input type="text" class="form-control" value="latitude" id="lat" name='lat' required hidden> --}}
                <button type="button" onclick="goToLocation()" class="btn btn-primary">Cari</button>
                {{-- <button type="button" onclick="goToLocation()">Go</button> --}}
            </div>
            <div class="col-md-2">
            {{-- <input type="text" class="form-control" value="latitude" id="lat" name='lat' required hidden> --}}
                {{-- <form action="">
                    @csrf
                    <input type="text" name="nama" class="mb-2 form-control">
                    <input type="text" name="no_tlp" class="mb-2 form-control"> --}}
                    <button type="button" onclick="showHiddenForm()" class="btn btn-success">Uncover</button>
            </div>
        </div>
    </div>  
 
    <div class="col-lg-5 uncover_form" hidden >
        <form method="post" action="/sales/uncover" >
            @csrf
            <input type="text" name="nama" placeholder="Nama Customer" class="mb-2 form-control" required>
            <input type="text" name="no_tlp" placeholder="Nomor Tlp 081xxxxx" class="mb-2 form-control" required>

            <input type="text" hidden id='sales_nip' value="{{ auth()->user()->karyawan_nip }}"    name='sales_nip'>
            <input type="text" hidden id='is_admin' value="{{ auth()->user()->is_admin }}"    name='is_admin'>
            <input type="text" hidden id='status_awal' value="uncover"    name='status_awal'>
            

            <input type="text" id='lat'    required hidden name='lat'>
            <input type="text" id='lng'    required hidden name='lng'>
            <input type="text" id='m_no'   required hidden name='m_no'>
            <input type="text" id='m_jln'  required hidden name='m_jln'>
            <input type="text" id='m_kel'  required hidden name='m_kel'>
            <input type="text" id='m_kec'  required hidden name='m_kec'>
            <input type="text" id='m_kota' required hidden name='m_kota'>
            <input type="text" id='m_type' required hidden name='m_type'>

            <button type="submit" class="btn btn-primary">Simpan Uncover</button>
        </form>
    </div>
        
    {{-- </form> --}}
@endsection
@section('map')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div id="map"></div>
    </div>
@endsection
{{-- <script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxdJw7g37bdvtT-zVLi6ab9NOG_EKY-CA&callback=initMap&v=weekly"
    defer
></script> --}}

<script
src="https://maps.googleapis.com/maps/api/js?key={{ config('app.gmap_key') }}&callback=initMap&v=weekly"
defer
>
</script>

<script>

function showHiddenForm() {
    var hiddenForm = document.querySelector(".uncover_form");
    
    if (hiddenForm.hasAttribute("hidden")) {
        hiddenForm.removeAttribute("hidden");
    } else {
        hiddenForm.setAttribute("hidden", "true");
    }
}
var map;
var marker;


async function getLocation() {
    try {
        const position = await new Promise((resolve, reject) => {
            navigator.geolocation.getCurrentPosition(resolve, reject);
        });
        var latitude = position.coords.latitude;
        var longitude = position.coords.longitude;
        return {"lat" : latitude, "long" : longitude}
    } catch (error) {
        console.error("Gagal mendapatkan lokasi: " + error.message);
    }
}

async function initMap() {
    let result = JSON.parse('{!! $accsess !!}')

    const data_koordinat = await getLocation()
    const myLatlng = { lat: data_koordinat.lat, lng: data_koordinat.long };
    // console.log(myLatlng)
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    const { LatLng } = await google.maps.importLibrary("core");
    const center = new LatLng({ lat: data_koordinat.lat, lng: data_koordinat.long });


      map = new google.maps.Map(document.getElementById('map'), {
        center: myLatlng,
        zoom: 18,
        mapId: "92f4247b6a730b7a",
      });


      marker = new google.maps.Marker({
        map: map,
        draggable: true,
        animation: google.maps.Animation.DROP,
        position: myLatlng
      });

    for (const property of result) {
        const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
            map,
            content: buildContent(property),
            position: { lat: parseFloat(property.lat), lng: parseFloat(property.lng) },
        });
    }
}


function goToLocation() {
    var input = document.getElementById('locationInput').value;
    var inputElement = document.getElementById('m_no')

    var lat = document.getElementById("lat");
    var lng = document.getElementById("lng");
    var m_no = document.getElementById("m_no");
    var m_jln = document.getElementById("m_jln");
    var m_kel = document.getElementById("m_kel");
    var m_kec = document.getElementById("m_kec");
    var m_kota = document.getElementById("m_kota");
    var m_type = document.getElementById("m_type");


    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ address: input }, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {

        var location = results[0].geometry.location;
        map.setCenter(location);
        marker.setPosition(location);

        const hasil = results[0]
        console.log(hasil)
        lat.value = hasil.geometry.location.lat()
        lng.value = hasil.geometry.location.lng()
        m_no.value = hasil.address_components[0].short_name
        m_jln.value = hasil.address_components[1].short_name
        m_kel.value = hasil.address_components[2].short_name
        m_kec.value = hasil.address_components[3].short_name
        m_kota.value = hasil.address_components[4].short_name
        m_type.value = hasil.address_components[0].types[0]


    } else {
        alert("Tidak ditemukan. Periksa alamat atau koordinat.");
    }
    });
}


function buildContent(property) {
    const priceTag = document.createElement("div");
    if(property.customers_count == 8){
        priceTag.className = "price-tag-penuh";
    }else if( property.customers_count == 6 | property.customers_count == 7 ){
        priceTag.className = "price-tag-awas";
    }else{
        priceTag.className = "price-tag";
    }
    priceTag.textContent = property.kode_area+" "+property.parent_ke+"."+property.spliter_ke+" - "+property.customers_count ;
    return priceTag;
}

window.initMap = initMap;
</script> 





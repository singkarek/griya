@extends('sales.layouts.main')

@push('css')
    {{-- css google map --}}
    <link href="/css/map.css" rel="stylesheet">
@endpush

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Accsess</h1>
    </div>
    {{-- <form method="post" action="/admin/area/tiang/edit/koordinat" autocomplete=""> --}}
        {{-- @method('put') --}}
        {{-- @csrf --}}
        <div class="row mb-2">
            <div class="col">
                <input type="text" class="form-control" placeholder="Alamat atau Koordinat" id="locationInput" name='locationInput' required >
            </div>
            <div class="col">
            {{-- <input type="text" class="form-control" value="latitude" id="lat" name='lat' required hidden> --}}
                <button type="button" onclick="goToLocation()" class="btn btn-primary">Cari</button>
                {{-- <button type="button" onclick="goToLocation()">Go</button> --}}
            </div>
        </div>
    {{-- </form> --}}
@endsection
@section('map')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div id="map"></div>
    </div>
@endsection
<script
    src="https://maps.googleapis.com/maps/api/js?key={{ env('GMAP_KEY') }}&callback=initMap&v=weekly"
    defer
></script>
    
<script>
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
    console.log(myLatlng)
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

    var geocoder = new google.maps.Geocoder();
    geocoder.geocode({ address: input }, function(results, status) {
    if (status === google.maps.GeocoderStatus.OK) {
        var location = results[0].geometry.location;
        map.setCenter(location);
        marker.setPosition(location);
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





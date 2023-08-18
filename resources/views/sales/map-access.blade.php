@extends('sales.layouts.main')

@push('css')
    {{-- css google map --}}
    <link href="/css/map.css" rel="stylesheet">
@endpush

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Accsess</h1>
    </div>
    <form method="post" action="/admin/area/tiang/edit/koordinat" autocomplete="">
        @method('put')
        @csrf
        <div class="row mb-2">
            <div class="col">
                <input type="text" class="form-control" value="Cari Alamat" id="alamat" name='alamat' required >
            </div>
            <input type="text" class="form-control" value="longtitude" id="lng" name='lng' 
            required hidden>
            <div class="col">
            <input type="text" class="form-control" value="latitude" id="lat" name='lat' required hidden>
                <button type="submitt" class="btn btn-primary">Cari</button>
            </div>
        </div>
    </form>
@endsection

@section('map')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div id="map"></div>
    </div>
@endsection

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxdJw7g37bdvtT-zVLi6ab9NOG_EKY-CA&callback=initMap&v=weekly"
    defer
    >
</script>
    
<script>
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

    console.log(result)
    const data_koordinat = await getLocation()
    const myLatlng = { lat: data_koordinat.lat, lng: data_koordinat.long };
    // console.log(myLatlng)
    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    const { LatLng } = await google.maps.importLibrary("core");
    const center = new LatLng({ lat: data_koordinat.lat, lng: data_koordinat.long });


    const map = new Map(document.getElementById("map"), {
        zoom: 18,
        center,
        mapId: "92f4247b6a730b7a",
    });

    let infoWindow = new google.maps.InfoWindow({
            content: "Kamu Disini !",
            position: myLatlng,
        });

    infoWindow.open(map);

    // marker = new google.maps.Marker({
    //         map,
    //         label: "kamu disini",
    //         position: center
    // });

    for (const property of result) {
        // console.log(parseFloat(property.lat))
        const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
            map,

            content: buildContent(property),
            position: { lat: parseFloat(property.lat), lng: parseFloat(property.lng) },
        });
    }
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
    // priceTag.textContent = property.customers_count+" | " + property.nama_tempat+" | "+property.kode_area+" "+property.parent_ke+"."+property.spliter_ke;
    priceTag.textContent = property.kode_area+" "+property.parent_ke+"."+property.spliter_ke+" | "+property.customers_count ;
    return priceTag;
}

window.initMap = initMap;
</script> 



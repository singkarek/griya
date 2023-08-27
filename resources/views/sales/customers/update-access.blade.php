@extends('sales.layouts.main')

@push('css')
    {{-- css google map --}}
    <link href="/css/map.css" rel="stylesheet">
@endpush

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Pilih Access(ODP) - {{ $customer->nama }}</h1>
    </div>
@endsection

@section('map')
    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div id="map"></div>
    </div>
@endsection



{{-- CDN AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous">
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
    let customer = JSON.parse('{!! $customer !!}')

    const data_koordinat = await getLocation()
    const myLatlng = { lat: parseFloat(customer.lat) , lng: parseFloat(customer.lng)  };

    const { Map } = await google.maps.importLibrary("maps");
    const { AdvancedMarkerElement } = await google.maps.importLibrary("marker");
    const { LatLng } = await google.maps.importLibrary("core");
    const center = new LatLng(myLatlng);

    const map = new Map(document.getElementById("map"), {
        zoom: 18,
        center,
        mapId: "92f4247b6a730b7a",
    });

    marker = new google.maps.Marker({
            map,
            label: customer.nama,
            position: center
    });

    for (const property of result) {
        const AdvancedMarkerElement = new google.maps.marker.AdvancedMarkerElement({
            map,
            content: buildContent(property),
            position: { lat: parseFloat(property.lat), lng: parseFloat(property.lng) },
        });
    
        AdvancedMarkerElement.addListener("click", () => {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            if (window.confirm("Pilih ODP Ini ?")) {
                    $.ajax({
                    method: 'put',
                    url: '/sales/customers/access',
                    data : { "spliter_id" : property.id, "coverage_areas_id" : property.coverage_areas_id , "customer_id" : customer.id},
                    success : function(data) {
                        window.location.href = "/sales/customers";
                    }
                });
            }
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



@extends('sales.layouts.main')

@push('css')
    {{-- css google map --}}
    <link href="/css/map.css" rel="stylesheet">
@endpush

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Data Placement</h1>
    </div>
    <form method="post" action='/sales/prospect/updateKoordinat' autocomplete="">
        @method('put')
        @csrf
        <div class="row mb-2">
            <div class="col">
                <input type="text" class="form-control" value="latitude" id="lat" name='lat' required>
            </div>
            <div class="col">
                <input type="text" class="form-control" value="longtitude" id="lng" name='lng' required>
                <input type="text" value={{ $prospect->id }} name='id' required hidden>
            </div>
            <div class="col">
                <button type="submitt" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>

    <div id="namamap" data='{{ $prospect->nama }} | {{ $prospect->alamat }}' ></div>
    <div id="mapexist" lat={{ $prospect->lat }} lng={{ $prospect->lng }}></div>
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
        const data_map  = document.querySelector('#mapexist');
        var lat = data_map.getAttribute("lat");
        var lng = data_map.getAttribute("lng");
    
        if(lat != 'lng='){
            console.log("masuk")
            return {"lat" : Number(lat), "long" : Number(lng)}
        }
            
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
        const nama_map  = document.querySelector('#namamap');
        const nama = nama_map.getAttribute("data")
        const f_lat  = document.querySelector('#lat');
        const f_lng  = document.querySelector('#lng');

        const data_koordinat = await getLocation()
        // console.log(data_koordinat)
        
        const myLatlng = { lat: data_koordinat.lat, lng: data_koordinat.long };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 20,
            center: myLatlng,
        });

        let infoWindow = new google.maps.InfoWindow({
            content: nama,
            position: myLatlng,
        });

        infoWindow.open(map);

        map.addListener("click", (mapsMouseEvent) => {
        
            infoWindow.close();
        
            infoWindow = new google.maps.InfoWindow({
            position: mapsMouseEvent.latLng,
            });
            
            f_lat.value = mapsMouseEvent.latLng.toJSON().lat
            f_lng.value = mapsMouseEvent.latLng.toJSON().lng

            infoWindow.setContent( nama );
            infoWindow.open(map);
        });
    }

    window.initMap = initMap;
</script> 

{{-- <script>
    function initMap() {
      const mapOptions = {
        center: { lat: 40.7128, lng: -74.0060 }, // Set your map center here
        zoom: 10,
      };

      const map = new google.maps.Map(document.getElementById("map"), mapOptions);

      // Coordinates of the two points
      const point1 = new google.maps.LatLng(40.7128, -74.0060);
      const point2 = new google.maps.LatLng(34.0522, -118.2437);

      // Calculate the distance between the two points
      const distanceInMeters = google.maps.geometry.spherical.computeDistanceBetween(point1, point2);

      // Convert distance to kilometers (optional)
      const distanceInKm = distanceInMeters / 1000;

      console.log("Distance in meters: " + distanceInMeters);
      console.log("Distance in kilometers: " + distanceInKm);
    }
</script> --}}






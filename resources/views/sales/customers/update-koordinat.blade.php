@extends('sales.layouts.main')

@push('css')
    {{-- css google map --}}
    <link href="/css/map.css" rel="stylesheet">
@endpush

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Upload Koordinat - {{ $customer->nama }}</h1>
    </div>

    <form method="post" action='/sales/customers/koordinat' autocomplete="">
        @method('put')
        @csrf
        <div class="row mb-2">
            <div class="col">
                <input type="text" class="form-control" value="latitude" id="lat" name='lat' readonly required>
            </div>
            <div class="col">
                <input type="text" class="form-control" value="longtitude" id="lng" name='lng' readonly required>
            </div>

            <input type="text" value={{ $customer->id }} name='id' required hidden>
            <div class="col">
                <button type="submitt" class="btn btn-primary">Simpan</button>
            </div>
        </div>

        <input type="text" id='m_no'   hidden name='m_no'>
        <input type="text" id='m_jln'  hidden name='m_jln'>
        <input type="text" id='m_kel'  hidden name='m_kel'>
        <input type="text" id='m_kec'  hidden name='m_kec'>
        <input type="text" id='m_kota' hidden name='m_kota'>
        <input type="text" id='m_type' hidden name='m_type'>


    </form>

    <div id="namamap" data='{{ $customer->nama }} | {{ $customer->alamat }}' ></div>
    <div id="mapexist" lat={{ $customer->lat }} lng={{ $customer->lng }}></div>
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
        var m_no = data_map.getAttribute("m_no");
        var m_jln = data_map.getAttribute("m_jln");
        var m_kel = data_map.getAttribute("m_kel");
        var m_kec = data_map.getAttribute("m_kec");
        var m_kota = data_map.getAttribute("m_kota");
        var m_type = data_map.getAttribute("m_type");
        
        if(lat != 'lng='){
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

            const geocoder = new google.maps.Geocoder();
            geocoder.geocode({ location: mapsMouseEvent.latLng }, (results, status) => {
                if (status === "OK") {
                    if (results[0]) {
                        // console.log(results[0])
                        // var dataArray = results[0].formatted_address.split(',');
                        // const alamat_jadi = dataArray.slice(0, 3);

                        
                        const hasil = results[0]
                        console.log(hasil);
                        console.log(hasil.address_components[0].types[0])

                        m_no.value = hasil.address_components[0].short_name
                        m_jln.value = hasil.address_components[1].short_name
                        m_kel.value = hasil.address_components[2].short_name
                        m_kec.value = hasil.address_components[3].short_name
                        m_kota.value = hasil.address_components[4].short_name
                        m_type.value = hasil.address_components[0].types[0]
                
                    } else {
                    console.log("Tidak ada hasil.");
                    }
                } else {
                    console.error("Geocode gagal: ", status);
                }
            });

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






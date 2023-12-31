@extends('admin.layouts.main')

@push('css')
    {{-- css google map --}}
    <link href="/css/map.css" rel="stylesheet">
@endpush

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Koordinat - {{ $data->nama_area }} - {{ $data->nama_tempat }}</h1>
    </div>
    <form method="post" action="/admin/area/tiang/edit/koordinat" autocomplete="">
        {{-- @method('put') --}}
        @csrf
        <div class="row mb-2">
            <div class="col">
                <input type="text" class="form-control" value="{{ $data->alamat }}" id="alamat" name='alamat' required >
            </div>
            <input type="text" class="form-control" value="longtitude" id="lng" name='lng' 
            required hidden>
            <input type="text" value={{ $data->id }} name='id' required hidden>
            <input type="text" value={{ $data->area_id }} name='area_id' required hidden>
            <div class="col">
            <input type="text" class="form-control" value="latitude" id="lat" name='lat' required hidden>
                <button type="submitt" class="btn btn-primary">Simpan</button>
            </div>
        </div>
    </form>

    <div id="namamap" data='{{ $data->kode_area }} | {{ $data->nama_tempat }} | {{ $data->jenis_tempat }}' ></div>
    <div id="mapexist" lat={{ $data->lat }} lng={{ $data->lng }}></div>
    {{-- {{ $data }} --}}
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
            // console.log("masuk")
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
        const alamat  = document.querySelector('#alamat');

        const data_koordinat = await getLocation()
        // console.log(data_koordinat)
        
        const myLatlng = { lat: data_koordinat.lat, lng: data_koordinat.long };

        const map = new google.maps.Map(document.getElementById("map"), {
            zoom: 25,
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
                        var dataArray = results[0].formatted_address.split(',');
                        const alamat_jadi = dataArray.slice(0, 3);

                        // console.log('oke');

                        // console.log(alamat);

                        alamat.value = alamat_jadi
                
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






<html>
  <head>
    <title>Event Click LatLng</title>
    <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

    <style>
        /* 
        * Always set the map height explicitly to define the size of the div element
        * that contains the map. 
        */
        #map {
        height: 100%;
        }

        /* 
        * Optional: Makes the sample page fill the window. 
        */
        /* html,
        body {
        height: 80%;
        margin: 0;
        padding: 0;
        } */
    </style>

    {{-- <link rel="stylesheet" type="text/css" href="./style.css" /> --}}

  </head>
  <body>




<div id="map"></div>

<form class="flex" method="post" action="/sales/create/customer" autocomplete="">
    @csrf
        <div class="mb-2">
            <label for="lat" class="form-label">lat</label>
            <input type="text" class="form-control" id="lat" name='lat'  required>
        </div>
        <div class="mb-2">
            <label for="lng" class="form-label">lng</label>
            <input type="text" class="form-control" id="lng" name='lng' required>
        </div>
</form>

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
    const f_lat  = document.querySelector('#lat');
    const f_lng  = document.querySelector('#lng');

    const data_koordinat = await getLocation()

    const myLatlng = { lat: data_koordinat.lat, lng: data_koordinat.long };

    const map = new google.maps.Map(document.getElementById("map"), {
        zoom: 25,
        center: myLatlng,
    });

    let infoWindow = new google.maps.InfoWindow({
        content: "Kamu Disini!",
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

        infoWindow.setContent(
        JSON.stringify(mapsMouseEvent.latLng.toJSON(), null, 2),
        );
        infoWindow.open(map);
    });
}

    window.initMap = initMap;
</script> 





  </body>
</html>
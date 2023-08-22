<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Create Place</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <style>
        #map {
            height: 100%;
        }

        html,
        body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        #controls {
            position: absolute;
            bottom: 100px;
            left: 100px;
            display: flex;
            flex-direction: column;
            width: 30%
        }

        .blink {
            animation: blink 1s linear infinite;
        }

        @keyframes blink {
            0% {
                opacity: 0;
            }

            50% {
                opacity: .5;
            }

            75% {
                opacity: 1;
            }

            100% {
                opacity: .5;
            }
        }
    </style>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body>
<div id="map"></div>
<div class="card border-0 shadow-lg" id="controls">
    <div class="card-body">
        <div class="row">
            <div class="col-12 d-grid mb-3 text-center">
                <div class="h4 fw-bold">CREATE PLACE</div>
            </div>
            <div class="d-grid col-12">
                <button class="btn btn-sm btn-success" id="start">START</button>
            </div>
            <div class="col-12 d-grid d-none">
                <button class="btn btn-sm btn-primary" id="save">SAVE</button>
            </div>
            <div class="col-12 d-grid mt-3">
                <a href="/oprasional/antrian/requestvalidasi/{{ $customer[0]->pppoe_secret }}/edit" class="btn btn-sm btn-light border">CANCEL</a>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"
integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
<script src="https://unpkg.com/measuretool-googlemaps-v3"></script>
<script
src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxdJw7g37bdvtT-zVLi6ab9NOG_EKY-CA&libraries=geometry&callback=initMap"
async defer></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
</script>

<script type = "text/javascript">
    let customer = JSON.parse('{!! $customer !!}')
    let points = JSON.parse('{!! $jalur !!}')

    let clat = points[0].lat
    let clng = points[0].lng
    let odplat = parseFloat(customer[0].access_lat)
    let odplng = parseFloat(customer[0].access_lng)
    let prospect_id = customer[0].prospects_id
    let pppoe_secret = customer[0].pppoe_secret
    
    const center = {
        lat: parseFloat(clat),
        lng: parseFloat(clng)
    };
    
    var map, measureTool;
    
    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center,
            zoom: 25,
            scaleControl: true,
            mapId: "92f4247b6a730b7a",
        });
    
        var customer = 'https://maps.google.com/mapfiles/kml/shapes/';
    
        const customer_new = new google.maps.Marker({
            position: center,
            icon: customer + 'man_maps.png',
            map,
        });
    
        const odp = new google.maps.Marker({
            map,
            position: {lat : odplat, lng : odplng},
            icon: customer + 'ranger_station_maps.png',
        });
        
        let latLng = [];
        $(function() {
        points.forEach(point => {
            latLng.push({
                lat: point.lat,
                lng: point.lng
            });
        });
        measureTool.start(latLng)
        })

        measureTool = new MeasureTool(map, {
            contextMenu: false,
            unit: MeasureTool.UnitTypeId.METRIC,
        });

        measureTool.addListener('measure_start', () => {
            let btnStart = $('#start');
            let btnSave = $('#save');
    
            $(btnStart).parent().addClass('d-none');
            $(btnSave).parent().removeClass('d-none');
        });
    
        measureTool.addListener('measure_end', (e) => {
            let btnStart    = $('#start');
            let btnSave     = $('#save');
            let customer_id = $("#customer_id").val();
    
            $(btnStart).parent().removeClass('d-none');
            $(btnSave).parent().addClass('d-none');;
    
            var points = e.result.points;
            var segments = e.result.segments;
    
            const places = {"prospect_id":prospect_id,"length":e.result.length,"length_text":e.result.lengthText}
            $.ajaxSetup({ headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') } });
            $.ajax({
                method: 'POST',
                url: '/oprasional/antrian/jalur/store',
                data: { 
                    "prospect_id"   : prospect_id,
                    "places"        : places, 
                    "points"        : e.result.points
                },
                success: function(data) {
                    if (data) {
                        console.log(data)
                        window.location.href = `/oprasional/antrian/requestvalidasi/${pppoe_secret}/edit`; 
                    }
                }
            })
        });
        // measureTool.addListener('measure_change', (e) => {});

    }
    

    document.querySelector('#start')
        .addEventListener('click', () => measureTool.start());
    document.querySelector('#save')
        .addEventListener('click', () => measureTool.end());

</script>
</body>

</html>
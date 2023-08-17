@extends('sales.layouts.main')

@push('css')
    {{-- css google map --}}
    <link href="/css/map.css" rel="stylesheet">
@endpush

@section('container')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Buat jalur - {{ $customer->nama }}</h1>
    </div>
   
    

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
                    <a href="#" class="btn btn-sm btn-light border">CANCEL</a>
                </div>
            </div>
        </div>
    </div>






    <div class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
        <div id="map"></div>

<script>
    let customer = JSON.parse('{!! $customer !!}')
    
        let clat = parseFloat(customer.lat_prospect)
        let clng = parseFloat(customer.lng_prospect)
        let odplat = parseFloat(customer.lat)
        let odplng = parseFloat(customer.lng)

        const center = {
            lat: clat,
            lng: clng
        };

        var map, measureTool;

        function initMap() {

            map = new google.maps.Map(document.getElementById('map'), {
                center,
                zoom: 18,
                scaleControl: true,
                mapId: "92f4247b6a730b7a"
            });

            var customer = 'https://maps.google.com/mapfiles/kml/shapes/';

            new google.maps.Marker({
                position: center,
                icon: customer + 'man_maps.png',
                map,
            });

            const odp = new google.maps.Marker({
                map,
                position: {lat : odplat, lng : odplng},
                icon: customer + 'ranger_station_maps.png',
            });

            measureTool = new MeasureTool(map, {
                contextMenu: false,
                unit: MeasureTool.UnitTypeId.METRIC,
            });

            measureTool.addListener('measure_start', () => {
                console.log("ok")
                let btnStart = $('#start');
                let btnSave = $('#save');

                $(btnStart).parent().addClass('d-none');
                $(btnSave).parent().removeClass('d-none');
            });

            measureTool.addListener('measure_end', (e) => {
                let btnStart = $('#start');
                let btnSave = $('#save');
                // let customer_id = $("#customer_id").val();

                $(btnStart).parent().removeClass('d-none');
                $(btnSave).parent().addClass('d-none');

                var points = e.result.points;
                var segments = e.result.segments;

                // console.log({"idc" : idc, "length" : e.result.length, "lengthText" : e.result.lengthText, points  : e.result.points, segments : e.result.segments});

                $.ajax({
                    method: 'POST',
                    url: '/api/tracks',
                    data: {"customer_id" : customer_id, "length" : e.result.length, "length_text" : e.result.lengthText, points  : e.result.points, segments : e.result.segments},
                    success: function(data) {
                        if (data) {
                            // console.log(data);
                            window.location.href = "/sales/customerclosings";
                        }
                    }
                })
            });

            measureTool.addListener('measure_change', (e) => {});
        }

        function showPlace(points) {
            let latLng = [];

            JSON.parse(points).forEach(point => {
                latLng.push({
                    lat: point.lat,
                    lng: point.lng
                });
            });

            measureTool.start(latLng);
        }

        function hidePlace() {
            measureTool.end();
        }



        document.querySelector('#start').addEventListener('click', () => measureTool.start());
        document.querySelector('#save').addEventListener('click', () => measureTool.end());
</script>
</div>
@endsection

<script
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxdJw7g37bdvtT-zVLi6ab9NOG_EKY-CA&callback=initMap&v=weekly"
    defer
    >
</script>

{{-- CDN AJAX --}}
<script src="https://code.jquery.com/jquery-3.6.4.min.js"
    integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous">
</script>

<script src="https://unpkg.com/measuretool-googlemaps-v3"></script>


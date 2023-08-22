<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
    {{-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> --}}
</head>

<body>
    <div id="map"></div>
  
    {{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"
        integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script> --}}

    <script src="https://unpkg.com/measuretool-googlemaps-v3"></script>

    <script
        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBxdJw7g37bdvtT-zVLi6ab9NOG_EKY-CA&libraries=geometry&callback=initMap"
        async defer></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous">
    </script> --}}

    <script>

        const center = {
            lat: -7.961559,
            lng: 112.614567,
        };

        var map, measureTool;

        function initMap() {

            map = new google.maps.Map(document.getElementById('map'), {
                center,
                zoom: 25,
                scaleControl: true
            });

            var measureTool = new MeasureTool(map, {
            // showSegmentLength: true,
            unit: MeasureTool.UnitTypeId.IMPERIAL // or just use 'imperial'
            });

            
            
            
        }
        
        

    </script>
</body>

</html>
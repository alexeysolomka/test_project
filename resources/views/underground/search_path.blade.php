<html>

<head>
    <meta name='viewport' content='initial-scale=1,maximum-scale=1,user-scalable=no' />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.css' rel='stylesheet' />

</head>

<body>
    <div>
        <form method="post" action="{{ route('underground.search') }}">
            @csrf
            <div>
                <label for="from">From</label>
                <select id="from" name="from" required>
                    @foreach($stations as $station)
                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label for="to">To</label>
                <select id="to" name="to">
                    @foreach($stations as $station)
                    <option value="{{ $station->id }}">{{ $station->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <button type="reset" id="search">Search</button>
            </div>
        </form>
    </div>
    <h1 id="nameRoute"></h1>
    <div id='map' style='width: 1000; height: 500px;'></div>
    <script>
        $(document).ready(function () {
        $.ajax({
            type: 'get',
            url: '{{ route('underground.getStations') }}',
            success: function (data) {
                mapboxgl.accessToken = 'pk.eyJ1IjoiZGFuaWxvMTMiLCJhIjoiY2sxYnN3dG9tMXBkazNsbXJ5aG5kejd0ciJ9.LqhgeQZAQpdBKd8cj9dICw';
                        var map = new mapboxgl.Map({
                        container: 'map',
                        style: 'mapbox://styles/mapbox/streets-v11',
                        center: [0, 0],
                        zoom: 2
                        });
                var length = data['stations'].length;
                var features = [];
                var geometry = [];
                var coordinates = [];
                for(var i = 0; i < length; i++) {
                    geometry = JSON.parse(data['stations'][i].point);
                    coordinates.push(geometry.coordinates.reverse());
                    features.push({
                        "type" : "Feature",
                        "geometry" : {
                            "type" : geometry.type,
                            "coordinates" : geometry.coordinates
                        },
                        "properties": {
                        "title": data['stations'][i].name,
                        "icon": "monument"
                        }
                    },);
                }
                map.on('load', function () {
                         map.addLayer({
                            "id": "points",
                            "type": "symbol",
                            "source": {
                            "type": "geojson",
                            "data": {
                            "type": "FeatureCollection",
                            "features": features
                            }
                            },
                            "layout": {
                            "icon-image": "{icon}-15",
                            "text-field": "{title}",
                            "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                            "text-offset": [0, 0.6],
                            "text-anchor": "top"
                                }
                            });
                            map.addLayer({
                            "id": "route",
                            "type": "line",
                            "source": {
                            "type": "geojson",
                            "data": {
                            "type": "Feature",
                            "properties": {},
                            "geometry": {
                            "type": "LineString",
                            "coordinates": coordinates
                            }
                            }
                            },
                            "layout": {
                            "line-join": "round",
                            "line-cap": "round"
                            },
                            "paint": {
                            "line-color": "#483D8B",
                            "line-width": 8
                            }
                            });
                            //short route
                            $('#search').on('click', function () {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            var from = $('#from').val();
            var to = $('#to').val();
            $.ajax({
            type: 'post',
            url: '{{ route('underground.search') }}',
            data: {_token: CSRF_TOKEN, message:$(".getinfo").val(), from: from, to: to},
            success: function (data) {
                var length = data['minRoute'].length;
                var geometry = [];
                var coordinates = [];
                var from = data['minRoute'][0].name;
                var to = data['minRoute'][length - 1].name;
                $('#nameRoute').text(from + ' - ' + to);
                for(var i = 0; i < length; i++) {
                    geometry = JSON.parse(data['minRoute'][i].point);
                    coordinates.push(geometry.coordinates.reverse());
                }
                map.addLayer({
                            "id": "shortRoute",
                            "type": "line",
                            "source": {
                            "type": "geojson",
                            "data": {
                            "type": "Feature",
                            "properties": {},
                            "geometry": {
                            "type": "LineString",
                            "coordinates": coordinates
                            }
                            }
                            },
                            "layout": {
                            "line-join": "round",
                            "line-cap": "round"
                            },
                            "paint": {
                            "line-color": "#228B22",
                            "line-width": 8
                            }
                            });
            },
            error: function (e) {
                console.log(e);
                }
        });
        })
                        });
            },
            error: function (e) {
                console.log(e);
                }
        });
    });
    </script>
</body>

</html>
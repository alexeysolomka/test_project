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
    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    $.ajax({
        type: 'get',
        url: '{{ route('underground.getStations') }}',
        success: function (data) {
            //init map
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
            // make points stations on map
            for (var i = 0; i < length; i++) {
                geometry = JSON.parse(data['stations'][i].point);
                coordinates.push(geometry.coordinates.reverse());
                features.push({
                    "type": "Feature",
                    "geometry": {
                        "type": geometry.type,
                        "coordinates": geometry.coordinates
                    },
                    "properties": {
                        "description": '<strong>' + data['stations'][i].name + '</strong>',
                        "icon": "rail-metro"
                    }
                }, );
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
                        "icon-image": "{icon}",
                        "text-field": "{title}",
                        "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                        "text-offset": [0, 0.6],
                        "text-anchor": "top"
                    }
                });
                map.on('click', 'points', function (e) {
var coordinates = e.features[0].geometry.coordinates.slice();
var description = e.features[0].properties.description;
 
// Ensure that if the map is zoomed out such that multiple
// copies of the feature are visible, the popup appears
// over the copy being pointed to.
while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
}
 
new mapboxgl.Popup()
.setLngLat(coordinates)
.setHTML(description)
.addTo(map);
});
 
// Change the cursor to a pointer when the mouse is over the places layer.
map.on('mouseenter', 'places', function () {
map.getCanvas().style.cursor = 'pointer';
});
 
// Change it back to a pointer when it leaves.
map.on('mouseleave', 'places', function () {
map.getCanvas().style.cursor = '';
});

                //make lines of branches
                var branchesLength = data['branches'].length;
                var coordinates = [];
                var geometry = [];
                var colors = [];
                for (var i = 0; i < branchesLength; i++) {
                    colors[i] = getRandomColor();
                    coordinates = [];
                    var stationsLength = data['branches'][i].stations.length;
                    for (var j = 0; j < stationsLength; j++) {
                        geometry = JSON.parse(data['branches'][i].stations[j].point);
                        coordinates.push(geometry.coordinates.reverse());
                    }
                       map.addLayer({
                        "id": "route" + i,
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
                            "line-join": "bevel",
                            "line-cap": "butt"
                        },
                        "paint": {
                            "line-color": colors[i],
                            "line-width": 8
                        }
                    });
                }
                //search and pring short route
                $('#search').on('click', function () {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    var from = $('#from').val();
                    var to = $('#to').val();
                    $.ajax({
                        type: 'post',
                        url: '{{ route('underground.search') }}',
                        data: {
                            _token: CSRF_TOKEN,
                            message: $(".getinfo").val(),
                            from: from,
                            to: to
                        },
                        success: function (data) {
                            if(map.getSource('shortRoute')) {
                                map.removeLayer('shortRoute');
                                map.removeSource('shortRoute');
                            }
                            var length = data['minRoute'].length;
                            var geometry = [];
                            var coordinates = [];
                            var from = data['minRoute'][0].name;
                            var to = data['minRoute'][length - 1].name;
                            $('#nameRoute').text(from + ' - ' + to);
                            for (var i = 0; i < length; i++) {
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
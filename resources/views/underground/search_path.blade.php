<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
        integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v1.3.2/mapbox-gl.css' rel='stylesheet' />

    <title>Search short path</title>
</head>

<body>
    <div class="container">
        <div class="col-sx-1 mt-3" align="center">
            <h4>Search short path from station to station:</h4>
            <div class="col-md-6">
                {{ Form::model($station, ['action' => 'SearchShortPathController@search']) }}
                <div class="form-group">
                    {{ Form::label('from', 'From') }}
                    {{ Form::select('from', $stations->pluck('name', 'id'), '',
                                     ['class' => 'form-control', 'id' => 'from'])}}
                </div>
                <div class="form-group">
                    {{ Form::label('to', 'To') }}
                    {{ Form::select('to', $stations->pluck('name', 'id'), '',
                                         ['class' => 'form-control', 'id' => 'to'])}}
                </div>
                <div class="form-group">
                    {{ Form::button('Search Path', ['type' => 'submit', 'class' => 'btn btn-success', 'id' => 'search'] )  }}
                </div>
                {{ Form::close() }}
            </div>
        </div>
        <h4 id="spentTime"></h4>
        <div id='map' style='width: 1000; height: 500px;'></div>
    </div>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
        integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
    </script>
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
                    center: [36.232845, 49.988358],
                    zoom: 10
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
                    $('#search').on('click', function (e) {
                        e.preventDefault();
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
                                if (map.getSource('shortRoute')) {
                                    map.removeLayer('shortRoute');
                                    map.removeSource('shortRoute');
                                }
                                var length = data['minRoute'].length;
                                var geometry = [];
                                var coordinates = [];
                                var timeSpent = 0;
                                for (var i = 0; i < length; i++) {
                                    console.log(data['minRoute'][i]);
                                    geometry = JSON.parse(data['minRoute'][i].point);
                                    coordinates.push(geometry.coordinates.reverse());
                                    timeSpent += data['minRoute'][i].travel_time;
                                }
                                $('#spentTime').text('Spent time:~'+ Math.ceil(timeSpent / 60) + ' minutes');
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
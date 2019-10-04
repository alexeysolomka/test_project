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
        url: '{{ route('
        underground.getStations ') }}',
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
                        "title": data['stations'][i].name,
                        "icon": "monument"
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
                        "icon-image": "{icon}-15",
                        "text-field": "{title}",
                        "text-font": ["Open Sans Semibold", "Arial Unicode MS Bold"],
                        "text-offset": [0, 0.6],
                        "text-anchor": "top"
                    }
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
                        console.log(data['branches'][i].stations[j]);
                        geometry = JSON.parse(data['branches'][i].stations[j].point);
                        coordinates.push(geometry.coordinates.reverse());
                    }
                    console.log(coordinates);
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
                            "line-join": "round",
                            "line-cap": "round"
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
                        url: '{{ route('
                        underground.search ') }}',
                        data: {
                            _token: CSRF_TOKEN,
                            message: $(".getinfo").val(),
                            from: from,
                            to: to
                        },
                        success: function (data) {
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
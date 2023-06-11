@extends('coordinator.coordinator_master')
@section('coordinator')
    <style>
        #map {
            height: 500px;
            margin-left: 2rem;
            margin-right: 2rem;
        }

        .info-window-content {
            width: 150px;
            /* Adjust the width as needed */
            height: 100px;
            /* Adjust the height as needed */
        }
    </style>
    <div class="container-fluid px-4">
        <h1>Intern Company</h1>
        <br>
        <div id="map"></div>
        <br>
        <form action="{{ route('map.store') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="latitude">Latitude</label>
                <input type="text" class="form-control" id="latitude" aria-describedby="latitude" name="latitude"
                    placeholder="Enter latitude">
            </div>
            <div class="form-group">
                <label for="longitude">Longitude</label>
                <input type="text" class="form-control" id="longitude" placeholder="Enter longitude" name="longitude">
            </div>
            <div class="form-group">
                <label for="review">Review</label>
                <input type="textarea" class="form-control" id="review" placeholder="Enter review" name="review">
            </div>
            <div class="form-group">
                <label for="rating">Rating (1-5)</label>
                <input type="number" class="form-control" id="rating" min="1" max="5"
                    oninput="limitToMax(this, 5)" name="rating">
            </div>
            <div class="form-group">
                <label for="nameCompany">Company Name</label>
                <input type="text" class="form-control" id="nameCompany" placeholder="Enter company name"
                    name="nameCompany">
            </div>
            <div class="form-group">
                <label for="emailCompany">Company Email</label>
                <input type="text" class="form-control" id="emailCompany" placeholder="Enter company email"
                    name="emailCompany">
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            function initMap() {
                var map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 12,
                    center: {
                        lat: 0,
                        lng: 0
                    }, // Default center
                });

                var markers = []; // Array to store markers

                @foreach ($locations as $location)
                    var rating = {{ $location->rating }};
                    var markerColor = 'red';
                    if (rating >= 3 && rating < 4) {
                        markerColor = 'yellow';
                    } else if (rating >= 4 && rating <= 5) {
                        markerColor = 'green';
                    }

                    var iconUrl = 'https://maps.google.com/mapfiles/ms/icons/' + markerColor + '-dot.png';

                    var marker = new google.maps.Marker({
                        position: new google.maps.LatLng({{ $location->latitude }}, {{ $location->longitude }}),
                        map: map,
                        icon: {
                            url: iconUrl,
                            scaledSize: new google.maps.Size(32, 32) // Adjust the size as needed
                        }
                    });
                    markers.push(marker);

                    var content = '<div>{{ $location->nameCompany }}</div>' +
                        '<div>{{ $location->emailCompany }}</div>' +
                        '<div>Review: {{ $location->review }}</div>' +
                        '<div>Rating: {{ $location->rating }}</div>' +
                        '<form action="{{ route('map.destroy', $location->id) }}" method="POST" style="display: inline;">' +
                        '@csrf' +
                        '@method('DELETE')' +
                        '<button type="submit">Remove</button>' +
                        '</form>';

                    var infowindow = new google.maps.InfoWindow();

                    google.maps.event.addListener(marker, 'click', (function(marker, content, infowindow) {
                        return function() {
                            infowindow.setContent(content);
                            infowindow.open(map, marker);
                        };
                    })(marker, content, infowindow));

                    // Update the map center to the marker position
                    map.setCenter(marker.getPosition());
                @endforeach

                function removeMarker(index) {
                    markers[index].setMap(null);
                    // You can also make an AJAX request here to remove the marker from the database
                }
            }

            $(document).ready(function() {
                initMap();
            });

            function limitToMax(element, max) {
                if (parseInt(element.value) > max) {
                    element.value = max;
                }
            }
        </script>
        <script type="text/javascript" src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAP_KEY') }}&libraries">
        </script>
    </div>
@endsection

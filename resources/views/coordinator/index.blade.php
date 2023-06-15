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
                <label for="address">Address</label>
                <input type="text" class="form-control" id="address" aria-describedby="address" name="address"
                    placeholder="Enter address">
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

        <script type="text/javascript"
            src="https://maps.googleapis.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries=places"></script>
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            function initMap() {
                var map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 12,
                    center: {
                        lat: 3.15633,
                        lng: 101.61695
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
                        map: map,
                        position: {
                            lat: {{ $location->latitude }},
                            lng: {{ $location->longitude }}
                        },
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
                @endforeach

                function removeMarker(index) {
                    markers[index].setMap(null);
                    // You can also make an AJAX request here to remove the marker from the database
                }
            }

            $(document).ready(function() {
                initMap();
                initAutocomplete();
            });

            function limitToMax(element, max) {
                if (parseInt(element.value) > max) {
                    element.value = max;
                }
            }

            // Autocomplete address
            function initAutocomplete() {
                var input = document.getElementById('address');
                var autocomplete = new google.maps.places.Autocomplete(input);

                autocomplete.addListener('place_changed', function() {
                    var place = autocomplete.getPlace();
                    if (!place.geometry) {
                        // User entered the name of a Place that was not suggested and
                        // pressed the Enter key, or the Place Details request failed.
                        window.alert("No details available for input: '" + place.name + "'");
                        return;
                    }

                    // Set the value of the input field with the selected address
                    document.getElementById('address').value = place.formatted_address;
                });

                // Prevent form submission on Enter key press
                input.addEventListener('keydown', function(event) {
                    if (event.key === 'Enter') {
                        event.preventDefault();
                    }
                });
            }
        </script>
    </div>
@endsection

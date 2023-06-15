@extends('students.student_master')
@section('students')
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
        <h1 class="mt-4">Students</h1>
        <br>
        <div id="map" style="height: 500px;"></div>

        <div class="row mt-4">
            <div class="col-md-6 offset-md-3">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="companyName" placeholder="Enter company name">
                    <div class="input-group-append">
                        <button class="btn btn-primary" type="button" onclick="searchCompany()">Search</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid px-4 mt-4">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Review</th>
                        <th scope="col">Rating</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $number = 0; ?>
                    @foreach ($locations as $location)
                        <?php $number++; ?>
                        <tr>
                            <td>{{ $number }}</td>
                            <td>{{ $location->nameCompany }}</td>
                            <td>{{ $location->emailCompany }}</td>
                            <td>{{ $location->review }}</td>
                            <td>{{ $location->rating }}</td>
                            <td>button</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
        <script type="text/javascript">
            var map;
            var markers = [];

            function initMap() {
                map = new google.maps.Map(document.getElementById("map"), {
                    zoom: 12,
                    center: {
                        lat: 3.15633,
                        lng: 101.61695
                    }, // Default center
                });

                addMarkers();
            }

            function addMarkers() {
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

                    var infowindow = new google.maps.InfoWindow({
                        content: '<div>{{ $location->nameCompany }}</div>' +
                            '<div>{{ $location->emailCompany }}</div>' +
                            '<div>Review: {{ $location->review }}</div>' +
                            '<div>Rating: {{ $location->rating }}</div>' +
                            '<button onclick="sendEmail(\'{{ $location->emailCompany }}\')">Send Email</button>'
                    });

                    marker.infowindow = infowindow; // Store the infowindow as a property of the marker

                    marker.addListener('click', function() {
                        closeAllInfoWindows(); // Close all other infowindows before opening the clicked one
                        this.infowindow.open(map, this);
                    });
                @endforeach
            }

            function closeAllInfoWindows() {
                markers.forEach(function(marker) {
                    marker.infowindow.close();
                });
            }

            function searchCompany() {
                var companyName = document.getElementById("companyName").value;

                // Clear all markers from the map
                clearMarkers();

                // Filter markers based on company name
                var filteredMarkers = markers.filter(function(marker) {
                    var nameCompany = marker.infowindow.content.includes(companyName);
                    return nameCompany;
                });

                // Set the map center to the first filtered marker
                if (filteredMarkers.length > 0) {
                    map.setCenter(filteredMarkers[0].getPosition());
                }

                // Display the filtered markers on the map
                filteredMarkers.forEach(function(marker) {
                    marker.setMap(map);
                });
            }

            function clearMarkers() {
                markers.forEach(function(marker) {
                    marker.setMap(null);
                });
            }

            function sendEmail(email) {
                // Submit a form to the send-email route with the email parameter
                $.post('{{ route('send-email') }}', {
                    _token: '{{ csrf_token() }}',
                    email: email
                }).done(function(response) {
                    console.log(response); // Handle the response if needed
                }).fail(function(error) {
                    console.error(error); // Handle any error that occurs
                });
            }

            $(document).ready(function() {
                initMap();
            });
        </script>
        <script type="text/javascript"
            src="https://maps.google.com/maps/api/js?key={{ env('GOOGLE_MAPS_API_KEY') }}&libraries"></script>
    </div>
@endsection

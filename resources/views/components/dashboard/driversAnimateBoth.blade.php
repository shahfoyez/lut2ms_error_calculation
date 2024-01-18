<!--begin::drivers & map-->
<!--begin::Row-->
<div class="row g-5 g-xl-8 mb-5">
    <!--begin::Col-->
    <div class="col-xl-4">
        <!--begin::List Widget 4-->
        <div class="card card-xl-stretch mb-xl-8">
            <!--begin::Header-->
            <div class="card-header border-0 pt-5">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bolder text-dark">Top Drivers</span>
                    <span class="text-muted mt-1 fw-bold fs-7">With Highest Number of Trips</span><i class="fa-solid fa-van-shuttle"></i>
                </h3>
            </div>
            <!--end::Header-->
            <!--begin::Body-->
            <div class="card-body pt-5">
                @foreach ($drivers as $driver)
                <!--begin::Item-->
                <div class="d-flex align-items-sm-center mb-7">
                    <!--begin::Symbol-->
                    <div class="symbol symbol-50px me-5">
                        <img src="{{ $driver->image ? asset($driver->image) : asset('assets/uploads/default/defaultProfile.webp') }}" class="align-self-center" alt="" />
                    </div>
                    <!--end::Symbol-->
                    <!--begin::Section-->
                    <div class="d-flex align-items-center flex-row-fluid flex-wrap">
                        <div class="flex-grow-1 me-2">
                            <a href="/employee/employeeEdit/{{ $driver->id }}" class="text-gray-800 text-hover-primary fs-6 fw-bolder">{{ $driver->name }}</a>
                            <span class="text-muted fw-bold d-block fs-7">ID: {{ $driver->idNumber }}</span>
                        </div>
                        <span class="badge badge-light fw-bolder my-2">{{ $driver->trips_count }} Trips</span>
                    </div>
                    <!--end::Section-->
                </div>
                <!--end::Item-->
                @endforeach
            </div>
            <!--end::Body-->
        </div>
        <!--end::List Widget 4-->
    </div>
    <!--end::Col-->
    <!--start::map-->
    <!--begin::Col-->
    <div class="col-xl-8">
        <div class="fv-row">
            <div id="map" style="height: 490px; width: 100%; border-radius: 10px"></div>
        </div>
    </div>
    <!--end::Col-->
    <!--end::map-->
</div>
<!--end::Row-->
<!--end::drivers & map-->
@section('mapScript')
    {{-- AIzaSyCHgH1gN5WHkJJXJRIlgH0EdebyJH3WaDM --}}
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCHgH1gN5WHkJJXJRIlgH0EdebyJH3WaDM&callback=initMap"></script>
    <script>
        var map;
        var markers = [];
        var stoppageMarkers = [];
        var noVehiclemarkers = [];
        stoppages = {!! json_encode($stoppages) !!};
        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: {lat: 24.8949, lng: 91.8687},
                zoom: 12,
                mapTypeControlOptions: {
                    style: google.maps.MapTypeControlStyle.HORIZONTAL_BAR,
                    position: google.maps.ControlPosition.TOP_RIGHT,
                },
                styles: [
                    {
                        featureType: 'poi',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    },
                    {
                        featureType: 'transit',
                        elementType: 'labels',
                        stylers: [{ visibility: 'off' }]
                    },
                ]
            });
            markerInitialize();
            addStoppages();
        }
        // Add new markers to the map and add a custom infowindow for each marker
        function markerInitialize(){
            $.ajax({
                url: "{{ url('/api/vehicles/location') }}",
                success: function(allData) {
                    let withLocationShow = allData.withLocationShow ?? null;
                    let withoutLocationHide = allData.withoutLocationHide ?? null;
                    let wlsLength =  Object.keys(withLocationShow).length;
                    let wlhLength =  Object.keys(withoutLocationHide).length;
                    if(wlsLength > 0 || wlhLength > 0){
                        if(wlsLength > 0){
                            for (const key in withLocationShow) {
                                addMarker(withLocationShow[key]);
                            }
                        }else{
                            noVehicle();
                        }
                        if(wlhLength > 0){
                            const colors = ['#50CD89', '#FFC700', '#009EF7', '#7239EA'];
                            let colorIndex = 0;
                            for (const route in withoutLocationHide) {
                                let routeDiv = document.createElement('div');
                                routeDiv.classList.add('foy_route_div');

                                let buttonHtml = '';
                                let routeVehicles = withoutLocationHide[route];
                                for(const vehicle in routeVehicles){
                                    let busName = routeVehicles[vehicle].vehicle.codeName;
                                    let tripRoute = routeVehicles[vehicle].trip.rout['route'];
                                    let tripStart = routeVehicles[vehicle].trip['tripStart'];
                                    buttonHtml += `<button class="foy_wlh_button"><div class="foy_wlh_button_contents"><p>${ busName }</p><p>${ tripStart }</p></div></button>`;
                                }
                                routeDiv.innerHTML = buttonHtml;

                                let containerDiv = document.createElement('div');
                                containerDiv.classList.add('foy_route_container');
                                containerDiv.innerHTML = `<button class="foy_wlh_heading_button" style="background-color: ${colors[colorIndex]}; border: ${colors[colorIndex]}"><div class="foy_wlh_button_contents"><p class="foy_route_heading_button">Route: ${ route }</p></div></button>`;
                                containerDiv.appendChild(routeDiv);

                                let headingButton = containerDiv.querySelector('.foy_route_heading_button');
                                headingButton.addEventListener('click', function() {
                                    routeDiv.classList.toggle('foy_route_div--hidden');
                                });

                                map.controls[google.maps.ControlPosition.TOP_LEFT].push(containerDiv);
                                colorIndex = (colorIndex + 1) % colors.length;
                            }
                        }
                    }else{
                        noVehicle();
                    }
                }
            });
        }
        // update marker position
        function addMarker(data) {
            var newlat = parseFloat(data.vehicle.location['lat']);
            var newlong = parseFloat(data.vehicle.location['long']);
            var driverName = data.trip.driver.name ?? 'No Driver';
            var routeNo = data.trip.rout.route;
            var distance = data.trip.trip_distance ? data.trip.trip_distance.distance : 0;
            var route = 'Route '+routeNo ?? 'No Route';
            var from =  data.trip['from'] ?? 'No Data';
            var dest =  data.trip['dest'] ?? 'No Data';
            var vehName = data.vehicle.codeName ?? 'No Name';
            {{--let iconPath = "{{ asset('/assets/uploads/default/mapVehicle.png') }}";--}}
            var iconPath = "{{ asset('/assets/uploads/default/vehicle') }}" + routeNo + ".png";
            console.log(iconPath);
            var marker = new google.maps.Marker({
                position: {lat: newlat, lng: newlong},
                map: map,
                icon: {
                    url: iconPath,
                    scaledSize: new google.maps.Size(35, 20),
                    // rotation: 180
                    // origin: new google.maps.Point(0, 0),
                    // anchor: new google.maps.Point(0, 0)
                },
                animation: google.maps.Animation.DROP,
            });

            // Marker circle
            var circle = new google.maps.Circle({
                map: map,
                radius: 200, // Circle radius in meters
                // center: {lat: location.lat, lng: location.lng},
                fillColor: '#FF0000',
                strokeColor: '#FF0000',
                strokeWeight: 1
            });
            // Add circle around marker
            circle.bindTo('center', marker, 'position');
            // Animate the circle
            var count = 0;
            window.setInterval(function() {
                count = (count + 1) % 200;
                // Update the radius of the circle
                circle.setOptions({
                    radius: (count + 50)
                });
            }, 10);

            // Info window content
            let infowindow = new google.maps.InfoWindow({
                content: `<div class="foy_map_infoWindow"><p class='m-0 foy_infoWindow_heading'>${vehName}</p><p class='m-0'>${route}</p><p class='m-0'>${driverName}</p><p class='m-0'> <i class="fas fa-solid fa-plane-arrival"></i> ${dest}</p><p class='m-0'>Distance: ${distance}m</p></div>`,
            });
            // All marker window open
            // infowindow.open(map, marker);
            // Click to open window
            marker.addListener('click', function() {
                // map.setZoom(15);
                // map.setCenter(marker.getPosition());
                infowindow.open(map, marker);
            });
            markers.push(marker);
        }
        // Fetch the location data and update the map every 5 seconds
        setInterval(function() {
            $.ajax({
                url: "{{ url('/api/vehicles/location') }}",
                success: function(allData) {
                    let withLocationShow = allData.withLocationShow ?? null;
                    var wlsLength = Object.keys(withLocationShow).length;
                    // refresh the page if new vehicle added to trip
                    if(wlsLength !== markers.length){
                        return location.reload();
                    }
                    if(wlsLength > 0){
                        var i = 0;
                        for (const key in withLocationShow) {
                            var newlat = parseFloat(withLocationShow[key].vehicle.location['lat']);
                            var newlong = parseFloat(withLocationShow[key].vehicle.location['long']);
                            // markers[i].setPosition({lat: newlat, lng: newlong});
                            // i++;
                            var newMarkerPosition = new google.maps.LatLng(newlat, newlong);

                            // Use the map's bounds to determine the new center
                            var bounds = new google.maps.LatLngBounds();
                            bounds.extend(newMarkerPosition);
                            var newMapCenter = bounds.getCenter();

                            animateMarkerAndMap(markers[i], newMarkerPosition, newMapCenter);
                            i++;
                        }
                        // New map variable to center map according to the markers
                        // var bounds = new google.maps.LatLngBounds();
                        // // Add markers to the bounds object
                        // markers.forEach(function(marker) {
                        //     bounds.extend(marker.getPosition());
                        // });
                        // // Center the map and zoom to fit the markers
                        // map.fitBounds(bounds);
                        // // set zoom level to 14
                        // map.setZoom(14);
                        // Center the map smoothly to fit the markers
                        // smoothPanTo(map, bounds.getCenter(), 14);
                    }else{
                        noVehicle();
                    }
                }
            });
        }, 5000);
        function addStoppages(){
            for (const key in stoppages) {
                let slat = parseFloat(stoppages[key].slat);
                let slon = parseFloat(stoppages[key].slon);
                var stoppageMarker = new google.maps.Marker({
                    position: {lat: slat, lng: slon},
                    map: map,
                    icon: {
                        url: "{{ asset('/assets/uploads/default/defaultMarker.png') }}",
                        scaledSize: new google.maps.Size(25, 25),
                    },
                });
                stoppageMarkers.push(stoppageMarker);
            }
        }
        function noVehicle(){
            // to stop marker blink every 5 seconds
            if(noVehiclemarkers.length >0){
                return;
            }else{
                // Create a Marker object at the map center
                let iconPath = "{{ asset('/assets/uploads/default/noVehicle.png') }}";
                noVehiclemarker = new google.maps.Marker({
                    position: map.getCenter(),
                    map: map,
                    icon: {
                        url: iconPath,
                        scaledSize: new google.maps.Size(35, 35),
                    },
                });
                // Create an InfoWindow object
                var nvInfowindow = new google.maps.InfoWindow({
                    content: `<div class="p-2"><h1 class="foy_vo_vehicle">No vehicle available!</h1></div>`
                });
                noVehiclemarker.addListener('click', function() {
                    nvInfowindow.open(map, noVehiclemarker);
                });
                // Open the InfoWindow on the Marker
                nvInfowindow.open(map, noVehiclemarker);
                noVehiclemarkers.push(noVehiclemarker);
                map.setZoom(12);
            }
        }
        // remove all existing markers
        function removeAllMarkers(){
            for (let i = 0; i < markers.length; i++) {
                markers[i].setMap(null);
            }
            // Clear the markers array
            markers = [];
        }
        function animateMarkerAndMap(marker, newMarkerPosition, newMapCenter) {
            var oldMarkerPosition = marker.getPosition();
            var step = 0;
            var numSteps = 100; // Adjust as needed for smoothness

            var deltaLatMarker = (newMarkerPosition.lat() - oldMarkerPosition.lat()) / numSteps;
            var deltaLngMarker = (newMarkerPosition.lng() - oldMarkerPosition.lng()) / numSteps;

            var oldMapCenter = map.getCenter();
            var deltaLatMap = (newMapCenter.lat() - oldMapCenter.lat()) / numSteps;
            var deltaLngMap = (newMapCenter.lng() - oldMapCenter.lng()) / numSteps;

            function moveMarkerAndMap() {
                oldMarkerPosition = new google.maps.LatLng(
                    oldMarkerPosition.lat() + deltaLatMarker,
                    oldMarkerPosition.lng() + deltaLngMarker
                );
                marker.setPosition(oldMarkerPosition);

                oldMapCenter = new google.maps.LatLng(
                    oldMapCenter.lat() + deltaLatMap,
                    oldMapCenter.lng() + deltaLngMap
                );
                map.panTo(oldMapCenter);

                if (step < numSteps) {
                    step++;
                    requestAnimationFrame(moveMarkerAndMap);
                }
            }

            moveMarkerAndMap();
        }

    </script>
@endsection

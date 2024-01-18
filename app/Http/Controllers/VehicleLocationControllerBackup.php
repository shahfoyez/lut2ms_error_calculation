<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Routex;
use App\Models\OnTripVehicle;
use App\Models\VehicleLocation;
use App\Http\Requests\StoreVehicleLocationRequest;
use App\Http\Requests\UpdateVehicleLocationRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VehicleLocationController extends Controller
{
    public function index()
    {
        return Routex::with('stoppages')->orderBy('route', 'ASC')->get();
    }
    public function routeVehicles($route)
    {
        $trips = Trip::with([
            'vehicle',
            'vehicle.location',
            'vehicle.activeTrip' => function ($query) {
                $query->with('driver')->where('status', 0);
            }])
            ->with('employee')
            ->where('route', $route)
            ->where('status', 0)
            ->latest()->get()->pluck('vehicle');
        if($trips->count() > 0) {
            return response()->json($trips);
        } else {
            throw new HttpResponseException(response()->json([
                'success'   => false,
            ]));
        }
    }

    // public function tripVehicles()
    // {
    //     $trips = Trip::with(['vehicle', 'vehicle.location', 'vehicle.activeTrip' => function ($query) {
    //             $query->with('driver')->where('status', 0);
    //         }])
    //         ->with('employee')
    //         ->where('status', 0)
    //         ->latest()->get()->pluck('vehicle');
    //     return $trips;
    // }

    public function vehiclesLocation()
    {

        // $trips = OnTripVehicle::with([
        //     'vehicle' => function ($query) {
        //         $query->select('id', 'codename', 'license', 'capacity');
        //     },
        //     'vehicle.location' => function ($query) {
        //         $query->select('id', 'vid', 'long', 'lat', 'date');
        //     },
        //     'vehicle.activeTrip' => function ($query) {
        //         $query->with('rout')->with(['driver'  => function ($query) {
        //             $query->select('id', 'name', 'idNumber', 'phone', 'image');
        //         }])->where('status', 0);
        //     }])
        //     ->where('show_map', 1)
        //     ->latest()->get()->pluck('vehicle');

        // $withLocationShow = $trips->filter(function ($item) {
        //     return $item['location'] !== null ;
        // });
        // $withLocationHide = $trips->filter(function ($item) {
        //     return $item['location'] !== null && $item['show_map'] === 0;
        // });
        // $withoutLocation = $trips->filter(function ($item) {
        //     return $item['location'] === null;
        // });
        // return $withLocationShow;

        $trips = OnTripVehicle::with([
                'trip',
                'trip.rout',
                'trip.driver'
                ])
            ->latest()->get();

        // return $trips;
        $withLocationShow = $trips->filter(function ($item) {
            return $item['vehicle']->location !== null && $item['show_map'] === 1;
        });
        $withLocationHide = $trips->filter(function ($item) {
            return $item['vehicle']->location && $item['show_map'] === 0;
        });
        $withoutLocation = $trips->filter(function ($item) {
            return $item['vehicle']->location === null;
        });


        // without pluck(works), need to change view if implimented
        // $trips = OnTripVehicle::with([
        //         'vehicle' => function ($query) {
        //             $query->select('id', 'codename', 'license', 'capacity');
        //         },
        //         'vehicle.location' => function ($query) {
        //             $query->select('id', 'vid', 'long', 'lat', 'date');
        //         }

        //     ])
        //     ->with(['trip' => function($query){
        //         $query->with(['driver'  => function ($query) {
        //             $query->select('id', 'name', 'idNumber', 'phone', 'image');
        //         }]);
        //     }])
        //     ->latest()->get(['id', 'vid', 'trip_id']);

        if($trips->count()>0) {
            return response()->json([
                'withLocationShow' => $withLocationShow,
                'withLocationHide' => $withLocationHide,
                'withoutLocation' => $withoutLocation,
            ]);
        } else {
            throw new HttpResponseException(response()->json([
                'error'   => true,
            ]));
        }
    }

    public function create()
    {
        //
    }

    //    public function store($vid, $long, $lat)
    //    {
    //
    //        $date = date("Y-m-d H:i:s");
    //        try {
    //            $location = VehicleLocation::updateOrCreate(
    //                [
    //                    'vid' => $vid
    //                ],
    //                [
    //                    'vid' => $vid,
    //                    'long' => $long,
    //                    'lat' => $lat,
    //                    'date' => $date,
    //                    'status' => 1
    //                ]
    //            );
    //
    //            $content = array(
    //                'success' => true,
    //                'data' => $location,
    //                'message' => trans('Location Updated successfully')
    //            );
    //            return response($content)->setStatusCode(200);
    //        } catch (\Exception $e) {
    //            $content = array(
    //                'success' => false,
    //                'data' => 'something went wrong.',
    //                'message' => 'There was an error while processing your request: ' .
    //                    $e->getMessage()
    //            );
    //            return response($content)->setStatusCode(500);
    //        }
    //
    //    }




    public function store($vid, $long, $lat)
    {
        // Step 1: Retrieve trip_id from on_trip_vehicle using Eloquent
        $onTripVehicle = OnTripVehicle::where('vid', $vid)->first();
        if (!$onTripVehicle) {
            // Vehicle is not on a trip, handle this case as needed.
            return response()->json(['success' => false, 'message' => 'Vehicle is not on a trip.']);
        }
        $tripId = $onTripVehicle->trip_id;
        // Step 2: Retrieve the latest VehicleLocation record
        $previousLocation = VehicleLocation::where('vid', $vid)
            ->orderBy('date', 'desc')
            ->first();
        // Step 3: Check if current and previous locations are the same
        if ($previousLocation && $previousLocation->lat == $lat && $previousLocation->long == $long) {
            return response()->json(['success' => true, 'message' => 'Location not changed.']);
        }
        // Step 4: Calculate distance
        $distance = 0;

        if ($previousLocation) {
            $distance = round($this->calculateDistance($previousLocation->lat, $previousLocation->long, $lat, $long), 4);
        }

        // Step 5: Update TripDistance table
        $tripDistance = VehicleTripDistance::updateOrInsert(
            [
                'trip_id' => $tripId
            ],
            [
                'distance' => DB::raw("distance + $distance")
            ]
        );
        // Step 5: Update VehicleLocation table
        $date = date("Y-m-d H:i:s");
        try {
            $location = VehicleLocation::updateOrCreate(
                [
                    'vid' => $vid
                ],
                [
                    'vid' => $vid,
                    'long' => $long,
                    'lat' => $lat,
                    'date' => $date,
                    'status' => 1
                ]
            );
            $distanceUp = VehicleTripDistance::where([
                'trip_id' => $tripId
            ])->get();
            $content = array(
                'success' => true,
                'data' => $location,
                'message' => trans('Location Updated successfully')
            );
            return response($content)->setStatusCode(200);
        } catch (\Exception $e) {
            $content = array(
                'success' => false,
                'data' => 'something went wrong.',
                'message' => 'There was an error while processing your request: ' .
                    $e->getMessage()
            );
            return response($content)->setStatusCode(500);
        }
    }
    function calculateDistance($lat1, $lon1, $lat2, $lon2, $unit = 'm')
    {
        // Radius of the Earth in different units
        $earthRadiusMeters = 6371000; // in meters
        $earthRadiusKm = 6371; // in kilometers
        $earthRadiusMiles = 3959; // in miles

        // Convert latitude and longitude from degrees to radians
        $lat1Rad = deg2rad($lat1);
        $lon1Rad = deg2rad($lon1);
        $lat2Rad = deg2rad($lat2);
        $lon2Rad = deg2rad($lon2);

        // Calculate the change in coordinates
        $deltaLat = $lat2Rad - $lat1Rad;
        $deltaLon = $lon2Rad - $lon1Rad;

        // Haversine formula
        $a = sin($deltaLat / 2) * sin($deltaLat / 2) +
            cos($lat1Rad) * cos($lat2Rad) *
            sin($deltaLon / 2) * sin($deltaLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        // Calculate the distance in different units
        $distanceMeters = $earthRadiusMeters * $c;
        $distanceKm = $earthRadiusKm * $c;
        $distanceMiles = $earthRadiusMiles * $c;
//        dd($distanceMeters, $distanceKm, $distanceMiles);
        // Return the distance based on the specified unit
        return match ($unit) {
            'km' => $distanceKm,
            'miles' => $distanceMiles,
            default => $distanceMeters,
        };
    }










    public function show(VehicleLocation $vehicleLocation)
    {
        //
    }

    public function edit(VehicleLocation $vehicleLocation)
    {
        //
    }

    public function update(UpdateVehicleLocationRequest $request, VehicleLocation $vehicleLocation)
    {
        //
    }

    public function destroy(VehicleLocation $vehicleLocation)
    {
        //
    }
}

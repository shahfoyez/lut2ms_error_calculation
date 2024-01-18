<?php

namespace App\Http\Controllers;

use App\Models\Error2Distance;
use App\Models\VehicleTripDistance;
use Carbon\Carbon;
use App\Models\Trip;
use App\Models\Routex;
use App\Models\OnTripVehicle;
use App\Models\VehicleLocation;
use App\Http\Requests\StoreVehicleLocationRequest;
use App\Http\Requests\UpdateVehicleLocationRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\DB;

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
        $trips = OnTripVehicle::with([
            'vehicle' => function ($query) {
                $query->select('id', 'codeName');
            },
            'vehicle.location'
        ])
        ->with([
            'trip' => function($query){
                $query->selectRaw("*, DATE_FORMAT(`start`, '%d %b, %h:%i %p') as tripStart")->orderBy('route', 'asc')->get();
            },
            'trip.rout' => function ($query) {
                $query->select('id', 'route');
            },
            'trip.driver' => function ($query) {
                $query->select('id', 'name');
            },
            'trip.tripDistance' => function ($query) {
                $query->select('trip_id','distance');
            },
        ])
        ->whereHas('trip', function ($query) {
            $query->whereDate('start', Carbon::today());
        })->get();
        // return $trips;

        // return $trips;
        $withLocationShow = $trips->filter(fn($item) => $item['vehicle']->location !== null && $item['show_map'] === 1);

        $withoutLocationHide = $trips->filter(function ($item) {
            return $item['vehicle']->location == null || $item['show_map'] === 0;
        })->groupBy(function ($trips) {
            return $trips->trip->rout->route;
        })->sortBy(function($routeGroup){
            // first() method to avoid collection
            return $routeGroup->first()->trip->rout->route;
        })->map(function($routeGroup){
            return $routeGroup->sortByDesc(function($trips){
                return $trips->trip->start;
            });
        });

        // without sortBy
        // $withoutLocationHide = $trips->filter(function ($item) {
        //     return $item['vehicle']->location == null || $item['show_map'] === 0;
        // })->groupBy(function ($trips) {
        //     return $trips->trip->rout->route;
        // })->map(function($routeGroup){
        //     return $routeGroup->sortByDesc(function($trips){
        //         return $trips->trip->start;
        //     });
        // });

        // old method
        // $withoutLocationHide = $withoutLocationHide->groupBy(function ($trips) {
        //     return $trips->trip->rout->route;
        // })->map(function($routeGroup){
        //     return $routeGroup->sortByDesc(function($trips){
        //         return $trips->trip->start;
        //     });
        // });
        return response()->json([
            'withLocationShow' => $withLocationShow,
            'withoutLocationHide' => $withoutLocationHide
        ]);
    }

    public function create()
    {
        //
    }
    public function store($vid, $long, $lat)
    {
        $onTripVehicle = OnTripVehicle::where('vid', $vid)->first();
        if (!$onTripVehicle) {
            return response()->json([
                'success' => false,
                'message' => 'Vehicle is not on a trip.',
                'model' => $onTripVehicle
            ]);
        }
        $tripId = $onTripVehicle->trip_id;
        $previousLocation = VehicleLocation::latest()->where('vid', $vid)->first();

        if ($previousLocation && $previousLocation->lat == $lat && $previousLocation->long == $long) {
            return response()->json(['success' => true, 'message' => 'Location not changed.']);
        }
        $distance = 0;

        if ($previousLocation) {
            $distance = round($this->calculateDistance($previousLocation->lat, $previousLocation->long, $lat, $long), 4);
        }
        if($distance < 6){
            $distance = 0;
        } else if($distance > 10000){
            $distance = 1;
        }
        ////////////////////////////////////////////////////////////////
//        $errorDistances = array(1, 2, 3, 4, 5, 8, 10, 12, 15, 18, 20, 22, 25);
//        foreach ($errorDistances as $distanceError){
//            $errorName = 'error_' . ($distanceError);
//            $errorPreviousLocation = Error2Distance::where('name', $errorName)
//                ->where('trip_id', $tripId)
//                ->where('status', 1)
//                ->first();
//
//            $errorPreviousLocationFinal =  $errorPreviousLocation ?? $previousLocation;
//            $errorDistance = 0;
//            $errorDistancesArray[] = array();
//            if ($errorPreviousLocationFinal) {
//                $errorDistance = round($this->calculateDistance($errorPreviousLocationFinal->lat, $errorPreviousLocationFinal->long, $lat, $long), 4);
//                $errorDistancesArray[] = $errorDistance;
//
//                if ($errorDistance < $distanceError) {
//                    if(!$errorPreviousLocation){
//                        Error2Distance::updateOrCreate(
//                            [
//                                'name' => $errorName,
//                                'trip_id' => $tripId,
//                            ],
//                            [
//                                'long' => $errorPreviousLocationFinal->long,
//                                'lat' => $errorPreviousLocationFinal->lat,
//                                'status' => 1
//                            ]
//                        );
//                    }
//                } else {
//                    // Find and update the existing Error2Distance record
//                    $ErrorDistance = Error2Distance::updateOrInsert(
//                        [
//                            'name' => $errorName,
//                            'trip_id' => $tripId,
//                        ],
//                        [
//                            'distance' => DB::raw("distance + $errorDistance"),
//                            'status' => 0
//                        ]
//                    );
//                    // Append $ErrorDistance to the array
//                    $errorDistancesArray[] = $ErrorDistance;
//                }
//            }
//        }

        //////////////////////////////////////////////////////


        // Update VehicleLocation and distance table
        try {
            DB::beginTransaction();
            // Update TripDistance table
            if($distance > 0){
                $tripDistance = VehicleTripDistance::updateOrInsert(
                    ['trip_id' => $tripId],
                    ['distance' => DB::raw("distance + $distance")]
                );
            }

            $date = Carbon::now();
            $location = VehicleLocation::updateOrCreate(
                ['vid' => $vid],
                [
                    'vid' => $vid,
                    'long' => $long,
                    'lat' => $lat,
                    'date' => $date,
                    'status' => 1
                ]
            );
            DB::commit();
            $content = array(
                'success' => true,
                'data' => $location,
//                'errorDistance' => $errorDistancesArray,
                'message' => trans('Location Updated successfully')
            );
            return response($content)->setStatusCode(200);
        } catch (\Exception $e) {
            DB::rollBack();
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
        // Return the distance based on the specified unit
        return match ($unit) {
            'km' => $distanceKm,
            'miles' => $distanceMiles,
            default => $distanceMeters,
        };
    }

    //    public function store($vid, $long, $lat)
    //    {
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

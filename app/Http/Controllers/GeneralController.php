<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\VehicleLocation;
use App\Models\VehicleTripDistance;
use Carbon\Carbon;
use GuzzleHttp\Client;
use App\Models\Vehicle;
use App\Models\Employee;

use App\Models\Stoppage;
use App\Models\OnTripVehicle;
use Illuminate\Support\Facades\DB;

class GeneralController extends Controller
{

    public function index(){
//        $trips = OnTripVehicle::with([
//            'vehicle' => function ($query) {
//                $query->select('id', 'codeName');
//            },
//            'vehicle.location'
//        ])->with([
//            'trip' => function($query){
//                $query->selectRaw("*, DATE_FORMAT(`start`, '%d %b, %h:%i %p') as tripStart")->get();
//            },
//            'trip.rout' => function ($query) {
//                $query->select('id', 'route');
//            },
//            'trip.driver' => function ($query) {
//                $query->select('id', 'name');
//            },
//            'trip.tripDistance' => function ($query) {
//                $query->select('trip_id','distance');
//            },
//        ])->whereHas('trip', function ($query) {
//            $query->whereDate('start', Carbon::today());
//        })->oldest()->get();
//
//        $withLocationShow = $trips->filter(
//            fn($item) => $item['vehicle']->location !== null && $item['show_map'] === 1
//        );
//
//        $withoutLocationHide = $trips->filter(function ($item) {
//            return $item['vehicle']->location == null || $item['show_map'] === 0;
//        })->groupBy(function ($trips) {
//            return $trips->trip->rout->route;
//        })->sortBy(function($routeGroup){
//            // first() method to avoid collection
//            // return $routeGroup->first()->trip->rout->route;
//        })
//        ->map(function($routeGroup){
//            return $routeGroup->sortByDesc(function($trips){
//                return $trips->trip->start;
//            });
//        });
        $onRoad =  $vehicles = Vehicle::where('status', 'trip')
        ->latest()
        ->get()->count();
        $onBoard = Vehicle::where('status', 'available')
        ->latest()
        ->get()->count();
        $maintenance = Vehicle::where('status', 'maintenance')
        ->latest()
        ->get()->count();
        $data = array(
            'onRoad' => $onRoad,
            'onBoard' => $onBoard,
            'maintenance' => $maintenance,
        );
        $drivers = Employee::where('designation', 1)
            ->withCount(['trips' => function($query) {
                $query->where('status', 1);
            }])
            ->orderBy('trips_count', 'DESC')
            // ->having('trips_count', '>', 0)
            ->take(6)
            ->get();
        $stoppages = Stoppage::all();

        // app/Helpers/helper
        // to get maintenance, trips & fuels data
        $tripsData = tripsData();
        $fuelsData = fuelsData();
        $maintenanceData = maintenanceData();
        $tripWithDistance = Trip::where('status', 0)
            ->with('trip2error')
            ->whereHas('trip2error')
            ->get();
//        dd($tripWithDistance);
        return view('dashboard', [
            'data' => $data,
            'drivers' => $drivers,
            'stoppages' => $stoppages,
            'maintenanceData' => $maintenanceData,
            'tripsData' => $tripsData,
            'fuelsData' =>  $fuelsData,
            'tripWithDistance' => $tripWithDistance
        ]);
    }
    // logbook
    public function logbook(){
        $vehicles = Vehicle::with('vehicleType')
            ->withSum('fuels', 'quantity')
            ->withSum('totalFuels', 'quantity')
            ->withSum('fuels', 'cost')
            ->withCount('trips')
            ->withMax('firstLastEntries', 'meter_entry')
            ->withMin('firstLastEntries', 'meter_entry')
            ->withMax('meterEntries', 'meter_entry')
            ->withMin('meterEntries', 'meter_entry')
            ->get();
        // dd($vehicles);
        return view('summery', [
            'vehicles' => $vehicles
        ]);
    }
    // summeryFilter
    public function summeryFilter()
    {
        $date = explode("-", request()->input('date'));
        $start = trim($date[0]);
        $end = trim($date[1]);

        $start =  Carbon::parse($start)->format('Y-m-d');
        $end =  Carbon::parse($end)->format('Y-m-d 23:59:59');

        $query = Vehicle::query();
        if(request()->input('date')){
            $vehicles = Vehicle::withSum(['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'quantity')
            ->withSum('totalFuels', 'quantity')
            ->withSum(
                ['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'cost'
            )
            ->withMax(
                ['fuels' => fn($query) => $query->whereBetween('date', [$start, $end])],'date'
            )
            ->withCount(
                ['trips' => fn($query) => $query->whereBetween('start', [$start, $end])],'start'
            )

            ->withMax('firstLastEntries', 'meter_entry')
            ->withMin('firstLastEntries', 'meter_entry')
            ->withMax(
                ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'meter_entry'
            )
            ->withMin(
                ['meterEntries' => fn($query) => $query->whereBetween('date', [$start, $end])],'meter_entry'
            )->get();
        }
        $start =  Carbon::parse($start)->format('d M Y');
        $end =  Carbon::parse($end)->format('d M Y');
        // dd($trips);
        return view('summery', [
            'vehicles' => $vehicles,
            'start' => $start,
            'end' => $end
        ]);

    }
}

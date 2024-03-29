<?php

use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\FuelController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MeterController;
use App\Http\Controllers\NoticeController;
use App\Http\Controllers\RoutexController;
use App\Http\Controllers\GeneralController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\GpsDeviceController;
use App\Http\Controllers\ReminderController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\StoppageController;
use App\Http\Controllers\MaintenanceController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/landing', function(){
    return view('landing');
});
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});
Route::middleware(['guest'])->group(function () {
    Route::controller(SessionController::class)->group(function () {
        Route::get('/', 'loginCreate')->name('login');

        Route::post('/createAccount', 'createAccount');
        Route::post('/session', 'check');
    });
});
// auth Middleware Group
Route::middleware(['auth'])->group(function () {
    // GeneralController Group
    Route::controller(GeneralController::class)->group(function () {
        Route::get('/test/locationUpdate/{vid}/{long}/{lat}', 'test');
        Route::get('/dashboard', 'index');
        Route::get('/summery/table', 'logbook');
        Route::get('/summery/filter', 'summeryFilter');
        // Route::get('/vehicleByRoute/{rout}', 'vehicleByRoute');
    });

    // UserController Group
    Route::controller(UserController::class)->group(function () {
        Route::get('/user/users', 'show');
        Route::get('/user/add', 'create');
        Route::post('/user/add', 'store');
        Route::get('/user/edit/{user}', 'edit');
        Route::post('/user/update/{user}', 'Update');
        Route::delete('/user/delete/{user}', 'destroy');

        Route::get('/user/profile', 'profile');
        Route::post('/user/profileUpdate/{user}', 'profileUpdate');
    });

    // EmployeeController Group
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/employee/employees', 'create');
        Route::get('/employee/employeeAdd', 'employeeAdd');
        Route::post('/employee/employeeAdd', 'store');
        Route::get('/employee/departments', 'departments');
        Route::get('/employee/designations', 'designations');
        Route::get('/employee/departmentAdd', 'departmentCreate');
        Route::get('/employee/designationAdd', 'designationCreate');
        Route::post('/employee/departmentAdd', 'departmentAdd');
        Route::post('/employee/designationAdd', 'designationAdd');
        // Employee EUD
        Route::get('/employee/employeeEdit/{employee}', 'edit');
        Route::post('/employee/employeeUpdate/{employee}', 'update');
        Route::delete('/employee/employeeDelete/{employee}', 'destroy');
        // Department EUD
        Route::get('/employee/departmentEdit/{department}', 'departmentEdit');
        Route::post('/employee/departmentUpdate/{department}', 'departmentUpdate');
        Route::get('/employee/designationEdit/{designation}', 'designationEdit');
        // Designation EUD
        Route::post('/employee/designationUpdate/{designation}', 'designationUpdate');
        Route::delete('/employee/designationDelete/{designation}', 'designationDestroy');
        Route::delete('/employee/departmentDelete/{department}', 'departmentDestroy');
    });

    // RouteManagementController Group
    Route::controller(RoutexController::class)->group(function () {
        Route::get('/route/routes', 'create');
        Route::get('/route/routeAdd', 'routeAdd');
        Route::post('/route/routeAdd', 'store');
        // Route EUD
        Route::get('/route/routeEdit/{route}', 'edit');
        Route::post('/route/routeUpdate/{route}', 'update');
        Route::delete('/route/routeDelete/{route}', 'destroy');
    });

    // StoppageManagementController Group
    Route::controller(StoppageController::class)->group(function () {
        Route::get('/route/stoppages', 'create');
        Route::get('/route/stoppageAdd', 'stopageAdd');
        Route::post('/route/stopageAdd', 'store');
        // Stoppage EUD
        Route::get('/route/stoppageEdit/{stoppage}', 'edit');
        Route::post('/route/stoppageUpdate/{stoppage}', 'update');
        Route::delete('/route/stoppageDelete/{stoppage}', 'destroy');
    });

    // VehicleManagementController Group
    Route::controller(VehicleController::class)->group(function () {
        Route::get('/vehicle/vehicles', 'create');
        Route::get('/vehicle/vehicleAdd', 'vehicleAdd');
        Route::post('/vehicle/vehicleAdd', 'store');
        Route::get('/requisition/vehicles', 'reqVehicles');
        // Vehicle EUD
        Route::get('/vehicle/vehicleEdit/{vehicle}', 'edit');
        Route::post('/vehicle/vehicleUpdate/{vehicle}', 'update');
        Route::delete('/vehicle/vehicleDelete/{vehicle}', 'destroy');

        // Vehicle type
        Route::get('/vehicle/vehicleTypes', 'vehicleTypes');
        Route::get('/vehicle/typeAdd', 'typeAdd');
        Route::post('/vehicle/typeAdd', 'typeStore');
        // Vehicle type EDU
        Route::get('/vehicle/typeEdit/{type}', 'typeEdit');
        Route::post('/vehicle/typeUpdate/{type}', 'typeUpdate');
        Route::delete('/vehicle/typeDelete/{type}', 'typeDestroy');

        // Filter
        Route::get('/vehicle/vehicles/filter', 'filter');
    });

    // TripController Group
     Route::controller(TripController::class)->group(function () {
        Route::get('/requisition/vehicles', 'reqVehicles');
        Route::get('/requisition/send/{vehicle}', 'vehicleCreate');
        Route::post('/requisition/vehicleSend', 'vehicleSend');
        Route::get('/requisition/reach/{vehicle}', 'vehicleReach');
        Route::get('/requisition/cancel/{vehicle}', 'vehicleCancel');

        Route::get('/trip/history', 'show');
        Route::get('/trip/vehicleTrips/{vehicle}', 'vehicleTrips');

        Route::get('/requisition/edit/{trip}', 'edit');
        Route::post('/requisition/update/{trip}', 'update');
        Route::delete('/requisition/delete/{trip}', 'destroy');

        // Filter
        Route::get('/requisition/vehicles/filter', 'filter');
        Route::get('/trip/history/filter', 'tripFilter');
        Route::get('/trip/vehicleTrips/{vehicle}/filter', 'vehicleTripsFilter');
    });

    // FuelController Group
    Route::controller(FuelController::class)->group(function () {
        Route::get('/fuel/fuelVehicles', 'index');
        Route::get('/fuel/fuelRecords', 'show');
        Route::get('/fuel/fuelAdd/{vehicle}', 'create');
        Route::post('/fuel/fuelAdd', 'store');

        Route::get('/fuel/vehicleFuels/{vehicle}', 'vehicleFuels');

        Route::get('/fuel/edit/{fuel}', 'edit');
        Route::post('/fuel/fuelUpdate/{fuel}', 'update');
        Route::delete('/fuel/fuelDelete/{fuel}', 'destroy');

        // Filter
        Route::get('/fuel/fuelVehicles/filter', 'filter');
        Route::get('/fuel/fuelRecords/filter', 'fuelRecordsfilter');
        Route::get('/fuel/vehicleFuels/{vehicle}/filter', 'vehicleFuelsFilter');
    });

    // MeterController Group
    Route::controller(MeterController::class)->group(function () {
        Route::get('/meter/meterVehicles', 'index');
        Route::get('/meter/meterEntries', 'show');
        Route::get('/meter/meterEntryAdd/{vehicle}', 'create');
        Route::post('/meter/meterEntryAdd', 'store');

        Route::get('/meter/vehicleMeterEntries/{vehicle}', 'vehicleMeterEntries');

        Route::get('/meter/edit/{meter}', 'edit');
        Route::post('/meter/update/{meter}', 'update');
        Route::delete('/meter/meterDelete/{meter}', 'destroy');

        // Filter
        Route::get('/meter/meterVehicles/filter', 'meterVehicleFilter');
        Route::get('/meter/meterEntries/filter', 'meterEntriesFilter');
        Route::get('/meter/vehicleMeterEntries/{vehicle}/filter', 'vehicleMeterEntriesFilter');
    });

    // MaintenanceController Group
    Route::controller(MaintenanceController::class)->group(function () {
        Route::get('/maintenance/maintenanceVehicles', 'index');
        Route::get('/maintenance/maintenanceRecords', 'show');
        Route::get('/maintenance/maintenanceAdd/{vehicle}', 'create');
        Route::post('/maintenance/maintenanceEntryAdd', 'store');

        Route::get('/maintenance/vehicleMaintenanceRecords/{vehicle}', 'vehicleMaintenanceEntries');
        Route::get('/maintenance/edit/{maintenance}', 'edit');
        Route::post('/maintenance/update/{maintenance}', 'update');
        Route::delete('/maintenance/delete/{maintenance}', 'destroy');
        // Filter
        Route::get('/maintenance/maintenanceVehicles/filter', 'maintenanceVehiclesFilter');
        Route::get('/maintenance/maintenanceRecords/filter', 'maintenanceRecordsFilter');
        // Route::get('/maintenance/vehicleMaintenanceRecords/{vehicle}', 'vehicleMaintenanceEntriesFilter');
    });

    // ReminderController Group
    Route::controller(ReminderController::class)->group(function () {
        Route::get('/reminder/reminders', 'index');
        Route::get('/reminder/reminderAdd', 'create');
        Route::post('/reminder/reminderAdd', 'store');

        // new added
        Route::get('/reminder/edit/{reminder}', 'edit');
        Route::post('/reminder/update/{reminder}', 'update');
        Route::delete('/reminder/delete/{reminder}', 'destroy');

        Route::get('/reminder/reminders/filter', 'filter');
    });
    // ChatController Group
    Route::controller(ChatController::class)->group(function () {
        Route::get('/chat/chats', 'create');
        Route::post('/chat/reply', 'reply');
        // search
        Route::get('/chat/chatSearch', 'search');
    });
    // NoticeController Group
    Route::controller(NoticeController::class)->group(function () {
        Route::get('/notice/notices', 'index');
        Route::get('/notice/noticeAdd', 'create');
        Route::post('/notice/noticeAdd', 'store');
        // EUD
        Route::get('/notice/noticeEdit/{notice}', 'edit');
        Route::post('/notice/noticeUpdate/{notice}', 'update');
        Route::delete('/notice/delete/{notice}', 'destroy');
    });
    // ScheduleController Group
    Route::controller(ScheduleController::class)->group(function () {
        Route::get('/schedule/schedules', 'index');
        Route::get('/schedule/scheduleAdd', 'create');
        Route::post('/schedule/scheduleAdd', 'store');
        // EUD
        Route::get('/schedule/scheduleEdit/{schedule}', 'edit');
        Route::post('/schedule/scheduleUpdate/{schedule}', 'update');
        Route::delete('/schedule/delete/{schedule}', 'destroy');
        // Route::get('/notice/notices/filter', 'filter');
    });

     // GpsDeviceController Group
     Route::controller(GpsDeviceController::class)->group(function () {
        Route::get('/vehicle/devices', 'index');
        Route::get('/vehicle/deviceAdd', 'deviceCreate');
        Route::post('/vehicle/deviceAdd', 'deviceAdd');

        // Employee EUD
        Route::get('/vehicle/deviceEdit/{gpsDevice}', 'edit');
        Route::post('/vehicle/deviceUpdate/{gpsDevice}', 'update');
        Route::delete('/vehicle/deviceDelete/{gpsDevice}', 'destroy');
    });

    // logout
    Route::post('/logout', [SessionController::class, 'destroy']);
});

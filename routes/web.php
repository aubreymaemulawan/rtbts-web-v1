<?php
use App\Events\GPSMoved;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ConductorController;
use App\Http\Controllers\DispatcherController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\RealTimeController;

use App\Models\Schedule;
use App\Models\Fare;
use App\Models\Company;
use App\Models\Trip;
use App\Models\Status;
use App\Models\Reminder;
use App\Models\PersonnelSchedule;
use App\Models\Position;


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

//  Passenger Web Views
Route::get('/',[MapsController::class,'landing_page']);
Route::get('/trip-page/{persched_id}',[MapsController::class,'trip_page']);
Route::get('/track-bus/{trip_id}',[MapsController::class,'map_page']);

// RealTime Passenger Tables
Route::get('/tbl-landing-trip', [RealTimeController::class, 'tbl_landing_trip']);
Route::get('/tbl-landing-fare', [RealTimeController::class, 'tbl_landing_fare']);
Route::get('/tbl-landing-schedule', [RealTimeController::class, 'tbl_landing_schedule']);
Route::get('/tbl-trip-page/{persched_id}', [RealTimeController::class, 'tbl_trip_page']);
Route::get('/tbl-map-status/{trip_id}', [RealTimeController::class, 'tbl_map_status']);

Auth::routes();

//  Admin Web Views
Route::group(['middleware' => ['auth', 'admin']], function() {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin');
    Route::get('/account',[PageController::class,'account']);
    Route::get('/bus',[PageController::class,'bus']);
    Route::get('/company',[PageController::class,'company']);
    Route::get('/discount',[PageController::class,'discount']);
    Route::get('/fare',[PageController::class,'fare']);
    Route::get('/location',[PageController::class,'location']);
    Route::get('/personnel',[PageController::class,'personnel']);
    Route::get('/personnel-schedule',[PageController::class,'personnel_schedule']);
    Route::get('/position',[PageController::class,'position']);
    Route::get('/reminder',[PageController::class,'reminder']);
    Route::get('/route',[PageController::class,'route']);
    Route::get('/schedule',[PageController::class,'schedule']);
    Route::get('/status',[PageController::class,'status']);
    Route::get('/trip',[PageController::class,'trip']);
    Route::get('/track',[PageController::class,'track']);
    Route::get('/profile',[PageController::class,'profile']);
    Route::get('/change-email',[PageController::class,'email']);
    Route::get('/change-password',[PageController::class,'password']);
    Route::get('/announcement', [PageController::class, 'announcement']);

    // RealTime Tables
    Route::get('/tbl-personnel', [RealTimeController::class, 'tbl_personnel']);
    Route::get('/tbl-account', [RealTimeController::class, 'tbl_account']);
    Route::get('/tbl-bus', [RealTimeController::class, 'tbl_bus']);
    Route::get('/tbl-route', [RealTimeController::class, 'tbl_route']);
    Route::get('/tbl-fare', [RealTimeController::class, 'tbl_fare']);
    Route::get('/tbl-schedule', [RealTimeController::class, 'tbl_schedule']);
    Route::get('/tbl-personnel-schedule', [RealTimeController::class, 'tbl_personnel_schedule']);
    Route::get('/tbl-trip', [RealTimeController::class, 'tbl_trip']);
    Route::get('/tbl-track', [RealTimeController::class, 'tbl_track']);
});

//  Conductor Web Views
Route::group(['middleware' => ['auth', 'conductor']], function() {
});

// Dispatcher Web Views
Route::group(['middleware' => ['auth', 'dispatcher']], function() {
    Route::get('/dispatcher', [DispatcherController::class, 'index'])->name('dispatcher');
    Route::get('/dispatcher-schedule', [PageController::class, 'dispatcher_schedule']);
    Route::get('/dispatcher-trip', [PageController::class, 'dispatcher_trip']);
    Route::get('/dispatcher-profile', [PageController::class, 'dispatcher_profile']);
    Route::get('/dispatcher-password', [PageController::class, 'dispatcher_password']);
    Route::get('/dispatcher-announcement', [PageController::class, 'dispatcher_announcement']);

    // RealTime Tables
    Route::get('/tbl-dispatcher-schedule', [RealTimeController::class, 'tbl_dispatcher_schedule']);
    Route::get('/tbl-dispatcher-trip', [RealTimeController::class, 'tbl_dispatcher_trip']);
    Route::get('/tbl-dispatcher-announcement', [RealTimeController::class, 'tbl_dispatcher_announcement']);
});

// Operator Web Views
Route::group(['middleware' => ['auth', 'operator']], function() {
    Route::get('/operator', [OperatorController::class, 'index'])->name('operator');
    Route::get('/operator-schedule', [PageController::class, 'operator_schedule']);
    Route::get('/operator-trip', [PageController::class, 'operator_trip']);
    Route::get('/operator-profile', [PageController::class, 'operator_profile']);
    Route::get('/operator-password', [PageController::class, 'operator_password']);
    Route::get('/operator-announcement', [PageController::class, 'operator_announcement']);

    // RealTime Tables
    Route::get('/tbl-operator-schedule', [RealTimeController::class, 'tbl_operator_schedule']);
    Route::get('/tbl-operator-trip', [RealTimeController::class, 'tbl_operator_trip']);
    Route::get('/tbl-operator-announcement', [RealTimeController::class, 'tbl_operator_announcement']);
});


// Route::get('/move/{lat}/{lng}/{bus_id}', function ($lat, $lng, $bus_id) {
    // event(new CarMoved(53.6304438,10.0472128));
    // event(new CarMoved(53.6304438,10.0472128));
    // event(new CarMoved(8.568734040858114, 124.5160877654278));
    // event(new CarMoved(8.563121236986808, 124.52285610750327));
    // event(new CarMoved(8.529465418727415, 124.57139625266046));
    // event(new CarMoved(8.532891468939592, 124.5701315522405));
//     if($bus_id == 2){
//         event(new GPSMoved($lat, $lng));
//         dump('Location Moved');
//     }
    
// });
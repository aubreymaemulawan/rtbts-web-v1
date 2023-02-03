<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Bus;
use App\Models\Company;
use App\Models\Discount;
use App\Models\Fare;
use App\Models\Location;
use App\Models\Personnel;
use App\Models\PersonnelSchedule;
use App\Models\Position;
use App\Models\Reminder;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Status;
use App\Models\Trip;
use App\Models\City;
use App\Models\Province;

date_default_timezone_set('Asia/Manila');

class RealTimeController extends Controller
{

    // ADMIN
    public function tbl_personnel(){
        $personnel = Personnel::orderBy('created_at','desc')->get();
        $company = Company::all();
        return view('admin.table.tbl-personnel',compact('personnel','company'));
    }

    public function tbl_account(){
        $account = Account::orderBy('created_at','desc')->get();
        $personnel = Personnel::all();
        $company = Company::all();
        return view('admin.table.tbl-account',compact('account','personnel','company'));
    }

    public function tbl_bus(){
        $bus = Bus::orderBy('created_at','desc')->get();
        $company = Company::all();
        return view('admin.table.tbl-bus',compact('bus','company'));
    }

    public function tbl_route(){
        $route = Route::orderBy('created_at','desc')->get();
        $company = Company::all();
        return view('admin.table.tbl-route',compact('route','company'));
    }

    public function tbl_fare(){
        $fare = Fare::orderBy('created_at','desc')->get();
        $route = Route::all();
        $company = Company::all();
        return view('admin.table.tbl-fare',compact('fare','route','company'));
    }

    public function tbl_schedule(){
        $schedule = Schedule::orderBy('created_at','desc')->get();
        $personnel_schedule = PersonnelSchedule::all();
        $company = Company::all();
        $route = Route::all();
        return view('admin.table.tbl-schedule',compact('schedule','personnel_schedule','company','route'));
    }

    public function tbl_personnel_schedule(){
        $personnel_schedule = PersonnelSchedule::orderBy('date','desc')->get();
        $trip = Trip::where('arrived',0)->get();
        $schedule = Schedule::all();
        $bus = Bus::all();
        $personnel = Personnel::all();
        $company = Company::all();
        return view('admin.table.tbl-personnel-schedule',compact('personnel_schedule','schedule','bus','personnel','company','trip'));
    }

    public function tbl_trip(){
        $trip = Trip::orderBy('created_at','desc')->get();
        $schedule = Schedule::all();
        $company = Company::all();
        return view('admin.table.tbl-trip',compact('trip','schedule','company'));
    }

    public function track(){
        $trip = Trip::all();
        $schedule = Schedule::all();
        $company = Company::all();
        return view('admin.table.tbl-track',compact('trip','schedule','company'));
    }

    // DISPATCHER
    public function tbl_dispatcher_schedule(){
        $personnel = Personnel::all();
        $schedule = Schedule::all();
        $trip = Trip::all();
        $personnel_schedule = PersonnelSchedule::orderBy('date','desc')->get();
        $company = Company::all();
        $route = Route::all();
        return view('dispatcher.table.tbl-schedule',compact('personnel','schedule','personnel_schedule','company','route','trip'));
    }

    public function tbl_dispatcher_trip(){
        $personnel = Personnel::all();
        $trip = Trip::orderBy('created_at','desc')->get();
        $schedule = Schedule::all();
        $company = Company::all();
        return view('dispatcher.table.tbl-trip',compact('personnel','trip','schedule','company'));
    }

    public function tbl_dispatcher_announcement(Request $request){
        $personnel_id = $request->user()->personnel_id;
        $com_id = Personnel::where('id',$personnel_id)->value('company_id');

        $personnel = Personnel::all();
        $company = Company::all();
        $announce = Reminder::where([['company_id', $com_id],['user_type',1]])->orWhere('user_type',3)->orWhere('user_type',6)->orderBy('created_at','desc')->get();
        return view('dispatcher.table.tbl-announcement',compact('personnel','announce','company',));
    }

    // OPERATOR
    public function tbl_operator_schedule(){
        $personnel = Personnel::all();
        $schedule = Schedule::all();
        $trip = Trip::all();
        $personnel_schedule = PersonnelSchedule::orderBy('date','desc')->get();
        $company = Company::all();
        $route = Route::all();
        return view('operator.table.tbl-schedule',compact('personnel','schedule','personnel_schedule','company','route','trip'));
    }

    public function tbl_operator_trip(){
        $personnel = Personnel::all();
        $trip = Trip::orderBy('created_at','desc')->get();
        $schedule = Schedule::all();
        $company = Company::all();
        return view('operator.table.tbl-trip',compact('personnel','trip','schedule','company'));
    }

    public function tbl_operator_announcement(Request $request){
        $personnel_id = $request->user()->personnel_id;
        $com_id = Personnel::where('id',$personnel_id)->value('company_id');

        $personnel = Personnel::all();
        $company = Company::all();
        $announce = Reminder::where([['company_id', $com_id],['user_type',1]])->orWhere('user_type',4)->orWhere('user_type',6)->orderBy('created_at','desc')->get();
        return view('operator.table.tbl-announcement',compact('personnel','announce','company',));
    }

    // PASSENGER
    public function tbl_landing_trip(){
        $trip = Trip::where('arrived',0)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at','desc')->get();
        $persched_today = PersonnelSchedule::whereDate('date', '=', date('Y-m-d'))->get();
        return view('table.tble-landing-trip',compact('trip','persched_today'));
    }

    public function tbl_landing_fare(){
        $fare = Fare::all();
        return view('table.tble-landing-fare',compact('fare'));
    }

    public function tbl_landing_schedule(){
        $date = strtotime("+1 day");
        $persched = PersonnelSchedule::whereDate('date', '=', date('Y-m-d',$date))->get();
        return view('table.tble-landing-schedule',compact('persched'));
    }

    public function tbl_trip_page($persched_id){
        $trip = Trip::where('personnel_schedule_id',$persched_id)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at','desc')->get();
        return view('table.tble-trip-page',compact('trip','persched_id'));
    }

    public function tbl_map_status($trip_id){
        $date = strtotime("+1 day");
        $route = Route::all();
        $company = Company::all();
        $trip = Trip::where('id',$trip_id)->first();
        $status = Status::where('trip_id',$trip_id)->latest('created_at')->first();
        $persched = PersonnelSchedule::whereDate('date', '=', date('Y-m-d'))->get();
        $ps_id = Trip::where('id',$trip_id)->value('personnel_schedule_id');
        $bus_id = PersonnelSchedule::where('id',$ps_id)->value('bus_id');
        // $lat = Position::where('bus_id',$bus_id)->latest('created_at')->value('latitude');
        // $long = Position::where('bus_id',$bus_id)->latest('created_at')->value('longitude');
        return view('table.tble-map-status',compact('trip_id','company','route','trip','status','persched','bus_id'));
    }

}
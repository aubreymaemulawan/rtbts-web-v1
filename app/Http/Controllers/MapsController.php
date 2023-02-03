<?php

namespace App\Http\Controllers;
use App\Events\GPSMoved;
use Illuminate\Support\Facades\Broadcast;
use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Trip;
use App\Models\PersonnelSchedule;
use App\Models\Position;
use App\Models\Status;
use App\Models\Route;
use App\Models\Schedule;
use App\Models\Fare;
use App\Models\Reminder;
date_default_timezone_set('Asia/Manila');

class MapsController extends Controller
{ 

    // Maps Views

    public function landing_page(){
        $date = strtotime("+1 day");
        $schedule = Schedule::all();
        $route = Route::all();
        $fare = Fare::all();
        $company = Company::all();
        $trip = Trip::where('arrived',0)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at','desc')->get();
        $status = Status::all();
        $persched_today = PersonnelSchedule::whereDate('date', '=', date('Y-m-d'))->get();
        $persched = PersonnelSchedule::whereDate('date', '=', date('Y-m-d',$date))->get();
        $announce = Reminder::where('user_type',1)->orWhere('user_type',5)->get();
        return view('landing-page',compact('schedule','fare','company','route','trip','status','announce','persched','persched_today'));
    }

    public function trip_page($persched_id){
        $trip = Trip::where('personnel_schedule_id',$persched_id)->whereDate('created_at', '=', date('Y-m-d'))->orderBy('created_at','desc')->get();
        return view('trip-page',compact('trip','persched_id'));
    }

    public function map_page($trip_id){
        $str = array();
        $trip = Trip::with('personnel_schedule')->where('id',$trip_id)->first();
        $status = Status::where('trip_id',$trip_id)->latest('created_at')->first();
        $persched = PersonnelSchedule::whereDate('date', '=', date('Y-m-d'))->get();
        $bus_id = $trip->personnel_schedule->bus_id;
        $from_to_location = $trip->personnel_schedule->schedule->route->from_to_location;
        $str = explode("-",$from_to_location);
        $origin = $str[0];
        $destination = $str[1];
        if($trip->inverse == 1){
            $orig_latitude = $trip->personnel_schedule->schedule->route->dest_latitude;
            $orig_longitude = $trip->personnel_schedule->schedule->route->dest_longitude;
            $dest_latitude = $trip->personnel_schedule->schedule->route->orig_latitude;
            $dest_longitude = $trip->personnel_schedule->schedule->route->orig_longitude;
        }else if($trip->inverse == 0){
            $orig_latitude = $trip->personnel_schedule->schedule->route->orig_latitude;
            $orig_longitude = $trip->personnel_schedule->schedule->route->orig_longitude;
            $dest_latitude = $trip->personnel_schedule->schedule->route->dest_latitude;
            $dest_longitude = $trip->personnel_schedule->schedule->route->dest_longitude;
        }
        return view('map-page',compact(
            'trip_id',
            'trip',
            'status',
            'persched',
            'bus_id',
            'orig_latitude','orig_longitude',
            'dest_latitude','dest_longitude',
            'origin','destination'
        ));
    }

    public function gps_maps(Request $request){
        // Validation Rules
        $request->validate([
            'api_key' => 'required', //Qwerty143
            'lat' => 'required',
            'lng' => 'required',
            'speed' => 'required',
            'bus_id' => 'required',
        ]);

        // Event
        event(new GPSMoved($request->lat, $request->lng, $request->bus_id));

        // Create Data in DB (Position Table)
        $data = new Position();
        $data->latitude = $request->lat;
        $data->longitude = $request->lng;
        $data->speed = $request->speed;
        $data->bus_id = $request->bus_id;

        // Save to DB
        $data->save();

        $response = "GPS Successfully saved to database.";
        return response()->json($response, 200);
        
    }

    public function track_position(Request $request){ //copy
        $request->validate([
            'company_id' => 'required'
        ]);
        $bus_id = 0;
        $bus_no = 0;
        $bus_type = 0;
        $bus_color = 0;
        $trip_id = 0;
        $trip_no = 0;
        $from_to_location = 0;
        $orig_latitude = 0;
        $orig_longitude = 0;
        $ongoing_trip = array();
        $trip_info = array();
        $str = '';
        $origin = '';
        $destination = '';        
        $bus_status = '';
        $trip = Trip::where('arrived',0)->get();
        foreach($trip as $key=>$tr){
            if($tr->personnel_schedule->schedule->company_id == $request->company_id){
                $status = Status::where('trip_id',$tr->id)->latest('created_at')->first();
                $bus_id = $tr->personnel_schedule->bus_id;
                $position = Position::where('bus_id', $bus_id)->latest('created_at')->first();
                if(!$status){
                    $bus_status = 'N/A';
                    $status_created = '';
                }else{
                    $bus_status = $status->bus_status;
                    $status_created = $status->created_at;
                }
                $str = explode("-",$tr->personnel_schedule->schedule->route->from_to_location);
                $origin = $str[0];
                $destination = $str[1];
                if($tr->inverse == 1){
                    $from_to_location = $destination.' - '.$origin;
                }else{
                    $from_to_location = $origin.' - '.$destination;
                }
                $orig_latitude = $position->latitude;
                $orig_longitude = $position->longitude;
                $bus_no = $tr->personnel_schedule->bus->bus_no;
                if($tr->personnel_schedule->bus->bus_type == 1){
                    $bus_type = "Airconditioned";
                }else{
                    $bus_type = "Non-Airconditioned";
                }
                $bus_color = $tr->personnel_schedule->bus->color;
                $trip_id = $tr->id;
                $trip_no = $tr->trip_no;
                $ongoing_trip[$key] = array($from_to_location, $orig_latitude, $orig_longitude, $bus_id, $bus_no, $bus_type, $bus_color, $trip_id, $trip_no, $bus_status, $status_created);
            }
        }
        $company = Company::all();
        return response()->json($ongoing_trip);
    }

} 

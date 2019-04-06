<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\day_attendance;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Validator;
use DB;
use App\store_attendance;
use auth;

class AttenceController extends Controller
{
   

    public function __construct(){

        return $this->middleware('auth:api');
   
 }

    public function day_att($id)
    {
      
       
        $month_attendance = day_attendance::where('user_id', Auth::user()->id)
        ->where('punch','in')
        ->orderBy('created_at', 'DESC')
        ->where(DB::raw("(DATE_FORMAT(created_at,'%m-%Y'))"),$id)

        ->select('id',DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'),DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y:%H-%i") as intime'),DB::raw('DATE_FORMAT(updated_at, "%d-%m-%Y:%H-%i") as outtime'))
       
        ->get();
       
       
        // $store = DB::table('stores')
        // ->join('categories', 'stores.category', '=', 'categories.id')
        // ->join('routes', 'stores.route_id', '=', 'routes.id')
        // ->select('stores.*','routes.route_name', 'categories.name')
        // ->where('stores.deleted_on_off','1')
        // ->paginate(10);
        // //return response()->json([ 'status' => 'Sucess','store'=>$store ], 200);
         return response()->json($month_attendance);
      

    }


    public function sto_att($id)
    {
      
       
        $store = DB::table('store_attendances')
        ->join('stores', 'stores.id', '=', 'store_attendances.store_id')
        ->select('store_attendances.id',DB::raw('DATE_FORMAT(store_attendances.created_at, "%d-%m-%Y") as date'),
        
        DB::raw('DATE_FORMAT(store_attendances.created_at, "%H-%i") as time'),'stores.store_name as store_name')
     
        ->orderBy('store_attendances.created_at', 'DESC')
        ->where(DB::raw("(DATE_FORMAT(store_attendances.created_at,'%d-%m-%Y'))"),$id)      
        
        ->where('store_attendances.user_id', Auth::user()->id)
        ->get();


    //     $sto_attendance = store_attendance::where('user_id', 5)       
    //     ->orderBy('created_at', 'DESC')
    //     ->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),$id)
    //     //  ->with(array('Store_name'=>function($query){
    //     //     $query->addSelect('store_name as name3');
    //     // }))
        
    //    ->with('Store_name')
    //     ->get();



       
       
        // $store = DB::table('stores')
        // ->join('categories', 'stores.category', '=', 'categories.id')
        // ->join('routes', 'stores.route_id', '=', 'routes.id')
        // ->select('stores.*','routes.route_name', 'categories.name')
        // ->where('stores.deleted_on_off','1')
        // ->paginate(10);
        // //return response()->json([ 'status' => 'Sucess','store'=>$store ], 200);
         return response()->json($store);
      

    }

 

    public function store(Request $request)
    {
   

        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required|numeric',           
            'latitude' => 'required',
            'longitude' => 'required',
             
        ]);

                 if ($validator->fails())
                 {
        return response()->json([ 'status' => 'Error','Message'=>'User not acceptable ' ], 200);
                 }
                 else
                 {

                


                    $entry=day_attendance::where('user_id',$request->input('user_id'))->orderBy('created_at', 'DESC')->get();
                   
                    if(count($entry)>=1)
                    {
                    $day_att=day_attendance::where('user_id',$request->input('user_id'))->orderBy('id', 'DESC')->first();                   
                    
                    $day_att->updated_at= new \DateTime();
                    $day_att->save();  
                    }


$store = new day_attendance;
$store->user_id=$request->input('user_id');  
$store->latitude=$request->input('latitude');
$store->longitude=$request->input('longitude');
$store->punch=$request->input('punch');
$store->date=date('d-m-Y');
$store->time=date('h:i:s');
$store->created_at= new \DateTime();
$store->updated_at= null;
$store->save();  


$day_attence=day_attendance::where('user_id',$request->input('user_id'))
->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),date('d-m-Y'))
->orderBy('created_at', 'DESC')->get();
//$route['day_attence']=count($day_attence);

return response()->json([ 'status' => 'Success','Message'=>'Your Store Update Sucessfully','Attence'=> count($day_attence)], 200);


                 }

    }


    public function create(Request $request)
    {
   

        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required|numeric',     
            'store_id' => 'required|numeric',           
            'route_id' => 'required|numeric',                 
            'latitude' => 'required',
            'longitude' => 'required',
             
        ]);

                 if ($validator->fails())
                 {
        return response()->json([ 'status' => 'Error','Message'=>'User not acceptable ' ], 200);
                 }
                 else
                 {

                   


$store = new store_attendance;
$store->user_id=$request->input('user_id');  
$store->store_id=$request->input('store_id');  
$store->route_id=$request->input('route_id');  
$store->latitude=$request->input('latitude');
$store->longitude=$request->input('longitude');
$store->date=date('d-m-Y');
$store->time=date('h:i:s');
$store->created_at= new \DateTime();

$store->save();  




return response()->json([ 'status' => 'Success','Message'=>'Your Store Update Sucessfully'], 200);


                 }

    }

  



   

 

  





}

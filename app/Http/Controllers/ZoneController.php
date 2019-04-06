<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\State;
use Illuminate\Support\Facades\View;
use DB;
use Validator;
use App\Zone;
use App\User;
use App\Country;
use App\zone_allocate;
use auth;

class ZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        //$states=state::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
      //  $zones=Zone::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();

        $zones= DB::table('zones')
        ->join('countries', 'zones.country_id', '=', 'countries.id')  
        ->join('states', 'zones.state_id', '=', 'states.id')     
        ->select('zones.name as name', 'countries.name as country','states.name as state', 'zones.id as id')
        ->get();
       
        return view('zone/index',['zones'=>$zones]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
        $states=state::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();    
        return view('zone/create',['states'=>$states,'countrys'=>$countrys]);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

 $validator = Validator::make($request->all(), 
      [   'name' => 'required',
          'state' => 'required',
          
      ],
      [
      'name.required'=>"Enter your Name",
      'state.required'=>"Select state",   
    
      ]);

        if ($validator->fails())
         {

            $notification = array(
            'message' => 'your data error.', 
            'alert-type' => 'warning' );      
             return redirect()->back()->withErrors($validator)->with($notification)->withInput();
         }

 else
         {
      
            $zone = new Zone;
            $zone->name=ucfirst($request->input('name'));    
            $zone->state_id=$request->input('state');    
            $zone->country_id=$request->input('country');
            $zone->created_user=Auth::user()->id;      
            $zone->status=1;
            $zone->deleted_on_off=1;  
            $zone->created_at= new \DateTime();
            $zone->save();
             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('zone')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //      $zone = Zone::find($id);
    //     if($zone->status==0)
    //     {
    //     $zone->status=1;

    //     $notification = array(
    //         'message' => 'zone is Unblocked', 
    //         'alert-type' => 'success');
    //           }
              
    //           else
    //             { 
    //                  $zone->status=0;
    //                  $notification = array(
    //         'message' => 'zone is blocked', 
    //         'alert-type' => 'error');
    //           }
              

    //     $zone->updated_at=new \DateTime();
    //     $zone->save();

    //     return Redirect::to('zone')->with($notification);//
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $zone = Zone ::find($id);
      $countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
      $states=state::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get(); 
      return view('zone.edit',['states'=>$states,'zone'=>$zone,'countrys'=>$countrys]);  
     // return View::make('zone.edit')->with('zone',$zone) ;
    }








    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
              
        $validator = Validator::make($request->all(), 
        [     
        'name' => 'required',     
        'state' => 'required',
            
        ],
        [
        'name.required'=>"Enter your Name",
        'state.required'=>"Select state",   
      
        ]);


        if ($validator->fails())
        {

           $notification = array(
           'message' => 'your data error.', 
           'alert-type' => 'warning' );      
            return redirect()->back()->withErrors($validator)->with($notification)->withInput();
        }

else
        {
     
           $zone = Zone ::find($id);           
           $zone->name=ucfirst($request->input('name'));    
           $zone->state_id=$request->input('state');
           $zone->country_id=$request->input('country'); 

         
           $zone->save();
            $notification = array(
           'message' => 'Your Sate details is updated', 
           'alert-type' => 'success' ); 
           return Redirect::to('zone')->with($notification);
       }

    


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $zone = Zone ::find($id);
            $zone->deleted_on_off= 0;
            $zone->deleted_at= new \DateTime();
            $zone->save();

            

                $notification = array(
            'message' => 'zone is Deleted', 
            'alert-type' => 'success');
            return Redirect::to('zone')->with($notification);  //
    }

    public function allocate_index()
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
        //$zones=Zone::with('Zone')->where('status', '1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();

       // $admins=User::where('role_id', '4')->where('status', '1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
       
        $zones=Zone::with('zone')->with(['z_u' => function($query) {
            $query->with('zone_user_name');
        }])->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();


        //return response()->json($zones);
        return view('zone/allocate',['zones'=>$zones]);  
    }



    public function allocate($id1,$id2)
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();

        $zone = Zone ::find($id2);
        $zone->user_id=$id1; 
        $zt=$zone->state_id;
        $ct=$zone->country_id;
        $zone->updated_at=new \DateTime();
        $zone->save(); 

        $sal=new zone_allocate;
        $sal->user_id=$id1; 
        $sal->zone_id=$id2; 
        $sal->state_id=$zt;
        $sal->country_id=$ct;
        $sal->created_user=Auth::user()->id;  
        $sal->created_at=new \DateTime();
        $sal->save(); 

        $notification = array(
            'message' => 'User Allocated To Zone', 
            'alert-type' => 'success' ); 
            return Redirect::to('zone_allocate')->with($notification);
        
    }
}


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Zone;
use Illuminate\Support\Facades\View;
use DB;
use Validator;
use App\District;
use App\User;
use App\State;
use App\Country;
use auth;
use App\district_allocate;


class DistrictController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        
    }


    public function index()
    {
        //$zones=zone::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();

        $districts= DB::table('districts')
        ->join('countries', 'districts.country_id', '=', 'countries.id')  
        ->join('states', 'districts.state_id', '=', 'states.id') 
        ->join('zones', 'districts.zone_id', '=', 'zones.id')       
        ->select('districts.name as name','zones.name as zone', 'countries.name as country','states.name as state', 'districts.id as id')
        ->get();

       // $districts=District::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        return view('district/index',['districts'=>$districts]);  
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
        $zones=Zone::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();    
        return view('district/create',['zones'=>$zones,'states'=>$states,'countrys'=>$countrys]);  
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
      [    'name' => 'required',
           'zone' => 'required',
           'state' => 'required',
           'country' => 'required',
         
          
      ],
      [
      'name.required'=>"Enter your Name",
      'zone.required'=>"Select zone",   
      'state.required'=>"Select state",  
      'country.required'=>"Select country",  
    
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
      
            $district = new district;
            $district->name=ucfirst($request->input('name'));     
            $district->zone_id=$request->input('zone'); 
            $district->state_id=$request->input('state'); 
            $district->country_id= $request->input('country'); 
            $district->created_user=Auth::user()->id;
            $district->status=1;
            $district->deleted_on_off=1;  
            $district->created_at= new \DateTime();
            $district->save();
             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('district')->with($notification);
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
    //      $district = District::find($id);
    //     if($district->status==0)
    //     {
    //     $district->status=1;

    //     $notification = array(
    //         'message' => 'district is Unblocked', 
    //         'alert-type' => 'success');
    //           }
              
    //           else
    //             { 
    //                  $district->status=0;
    //                  $notification = array(
    //         'message' => 'district is blocked', 
    //         'alert-type' => 'error');
    //           }
              

    //     $district->updated_at=new \DateTime();
    //     $district->save();

    //     return Redirect::to('district')->with($notification);//
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $district = District ::find($id);

      $countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
      $states=state::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();  
      $zones=zone::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get(); 
      return view('district.edit',['zones'=>$zones,'district'=>$district,'states'=>$states,'countrys'=>$countrys]);  
     // return View::make('district.edit')->with('district',$district) ;
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
        'zone' => 'required',
        'state' => 'required',
        'country' => 'required',
      
            
        ],
        [
        'name.required'=>"Enter your Name",
        'zone.required'=>"Select zone", 
        'state.required'=>"Select state",  
      'country.required'=>"Select country",    
      
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
     
           $district = district ::find($id);           
           $district->name=ucfirst($request->input('name'));    
           $district->zone_id=$request->input('zone');   
           $district->state_id=$request->input('state'); 
           $district->country_id= $request->input('country'); 
           $district->save();
            $notification = array(
           'message' => 'Your Sate details is updated', 
           'alert-type' => 'success' ); 
           return Redirect::to('district')->with($notification);
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
            $district = district ::find($id);
            $district->deleted_on_off= 0;
            $district->deleted_at= new \DateTime();
            $district->save();

            

                $notification = array(
            'message' => 'district is Deleted', 
            'alert-type' => 'success');
            return Redirect::to('district')->with($notification);  //
    }

    public function allocate_index()
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
        //$districts=district::with('District_Zone')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        
        // $admins=User::where('role_id', '4')->where('status', '1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        // $zones=Zone::where('status', '1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
       
        $districts=district::with(['District_Zone'=> function($query) {
        $query->with('zone');
        }])->with(['d_u' => function($query1)
         {
         $query1->with('zone_user_name');
        }])->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();

        return view('district/allocate',['districts'=>$districts]); 
        //return response()->json($districts);  
        
    }



    public function allocate($id1,$id2)
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();

        $district = district ::find($id2);
        $district->user_id=$id1; 
        $district->updated_at=new \DateTime();
        $zt=$district->zone_id;
        $st=$district->state_id;
        $ct=$district->country_id;
        $district->save(); 


        $sal=new district_allocate;
        $sal->user_id=$id1; 
        $sal->district_id=$id2; 
        $sal->state_id=$st;
        $sal->zone_id=$zt;
        $sal->country_id=$ct;
        $sal->created_at=new \DateTime();
        $sal->created_user=Auth::user()->id;
        $sal->save(); 

        $notification = array(
            'message' => 'User Allocated To State', 
            'alert-type' => 'success' ); 
            return Redirect::to('district_allocate')->with($notification);
        
    }

}


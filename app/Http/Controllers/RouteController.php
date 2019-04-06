<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\Routes;
use Illuminate\Support\Facades\View;
use DB;
use Validator;
use App\District;
use App\User;
use App\State;
use App\Country;
use App\Zone;
use auth;
use App\route_allocate;


class RouteController extends Controller
{
   
    public function __construct()
  {
      $this->middleware('auth');
      
  }
   
    public function index()
    {
        //$routes=route::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
        //$routes=Routes::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();

        $routes= DB::table('routes')
        ->join('countries', 'routes.country_id', '=', 'countries.id')  
        ->join('states', 'routes.state_id', '=', 'states.id') 
        ->join('zones', 'routes.zone_id', '=', 'zones.id')   
        ->join('districts', 'routes.district_id', '=', 'districts.id')      
        ->select('routes.name as name','districts.name as district','zones.name as zone', 'countries.name as country','states.name as state', 'routes.id as id')
        ->get();

        return view('route/index',['routes'=>$routes]);  
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
        $districts=District::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();    
        return view('route/create',['districts'=>$districts,'zones'=>$zones,'states'=>$states,'countrys'=>$countrys]);   
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
            'district' => 'required',
            'zone' => 'required',
           'state' => 'required',
           'country' => 'required',
          
      ],
      [
      'name.required'=>"Enter your Name",
      'district.required'=>"Select District",  
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
      
            $route = new Routes;
            $route->name=ucfirst($request->input('name'));    
            $route->district_id=$request->input('district'); 
            $route->zone_id=$request->input('zone');
            $route->state_id=$request->input('state');
            $route->country_id=$request->input('country');   
            $route->status=1;
            $route->deleted_on_off=1;  
            $route->created_at= new \DateTime();
            $route->created_user=Auth::user()->id;
            $route->save();
             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('route')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $route = Routes::find($id);
        if($route->status==0)
        {
        $route->status=1;

        $notification = array(
            'message' => 'route is Unblocked', 
            'alert-type' => 'success');
              }
              
              else
                { 
                     $route->status=0;
                     $notification = array(
            'message' => 'route is blocked', 
            'alert-type' => 'error');
              }
              

        $route->updated_at=new \DateTime();
        $route->save();

        return Redirect::to('route')->with($notification);//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $route = Routes ::find($id);
      $countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
        $states=state::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();  
        $zones=Zone::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();  
       
      $districts=District::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get(); 
      return view('route.edit',['districts'=>$districts,'route'=>$route,'zones'=>$zones,'states'=>$states,'countrys'=>$countrys]);   
     // return View::make('route.edit')->with('route',$route) ;
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
            'district' => 'required',
            'zone' => 'required',
            'state' => 'required',
            'country' => 'required',
            
        ],
        [
        'name.required'=>"Enter your Name",
        'district.required'=>"Select District",  
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
     
            $route = Routes ::find($id);           
           $route->name=ucfirst($request->input('name'));    
           $route->district_id=$request->input('district');  
           $route->zone_id=$request->input('zone');
           $route->state_id=$request->input('state');
           $route->country_id=$request->input('country');    
         
           $route->save();
            $notification = array(
           'message' => 'Your Sate details is updated', 
           'alert-type' => 'success' ); 
           return Redirect::to('route')->with($notification);
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
            $route = Route ::find($id);
            $route->deleted_on_off= 0;
            $route->deleted_at= new \DateTime();
            $route->save();

            

                $notification = array(
            'message' => 'route is Deleted', 
            'alert-type' => 'success');
            return Redirect::to('route')->with($notification);  //
    }


    public function allocate_index()
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
       // $routes=Routes::with('Route_District1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        //$admins=User::where('role_id', '5')->where('status', '1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        
        $routes=Routes::with(['Route_District1'=> function($query) {
            $query->with('District_Zone');
            }])->with(['d_u1' => function($query1)
             {
             $query1->with('district_user_name');
            }])->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        
        return view('route/allocate',['routes'=>$routes]); 
        //return response()->json($routes);   
    }


    public function allocate($id1,$id2)
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();

        $routes = Routes ::find($id2);
        $routes->user_id=$id1; 
        $routes->updated_at=new \DateTime();
        $dt=$routes->district_id;
        $zt=$routes->zone_id;
        $st=$routes->state_id;
        $ct=$routes->country_id;
        $routes->save(); 


        $sal=new route_allocate;
        $sal->user_id=$id1; 
        $sal->route_id=$id2; 
        $sal->district_id=$dt; 
        $sal->state_id=$st;
        $sal->zone_id=$zt;
        $sal->country_id=$ct;
        $sal->created_user=Auth::user()->id;
        $sal->created_at=new \DateTime();
        
        $sal->save(); 


        $notification = array(
            'message' => 'User Allocated To State', 
            'alert-type' => 'success' ); 
            return Redirect::to('route_allocate')->with($notification);
        
    }

}


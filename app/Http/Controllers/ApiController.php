<?php

namespace App\Http\Controllers;
use Auth;
use App\User;
use Illuminate\Http\Request;
use Validator;
use DB;
use GuzzleHttp\Psr7\Response;
use App\Routes;
use App\day_attendance;
use App\store_attendance;
use App\Stores;
use App\State; 
use App\Zone;

use App\product_category;
use App\state_allocate;
use App\route_allocate;


use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
class ApiController extends Controller
{
  

    public function __construct()
    {

        return $this->middleware('auth:api');
   
    }

    public function index($id)
    {
        $admin = User ::find($id);
      if($admin->role_id=='5')
      {
       
        $allocated=Routes::withCount('Route_shop')->
        withcount(['route_atten' => function ($query) 
               {
             $query->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),date('d-m-Y'));
               }])->where('status', '1')
               ->with(['route_allocated'=> function($que)
               {
                $que->where('date',date('d-m-Y'))->where('user_id', Auth::user()->id);
               }]
               )
        ->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        $routes=Array();
foreach($allocated as $all)
{
    if($all->route_allocated!='')
    {
        array_push($routes,$all);
    }
}



       
       
            }
            elseif($admin->role_id=='3')
            {

                $state = state_allocate::where('user_id',$id)->where('status','1')->first();
                $routes=Routes::withCount('Route_shop')->
                withcount(['route_atten' => function ($query) 
                {
                    $query->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),date('d-m-Y'));
                       }])->where('status', '1')
                      ->where('deleted_on_off', '1')->where('state_id',$state->state_id)->orderBy('created_at', 'DESC')->get();
            } 
            else
            {

                $routes=Routes::withCount('Route_shop')->
        withcount(['route_atten' => function ($query) {
                        $query->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),date('d-m-Y'));
               }])->where('status', '1')
              ->where('deleted_on_off', '1')->where('user_id',$id)->orderBy('created_at', 'DESC')->get();
            }
       
        $day_attence=day_attendance::where('user_id',$id)
        ->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),date('d-m-Y'))
        ->orderBy('created_at', 'DESC')->get();
        
        $route['routeList']=$routes;
        $route['day_attence']=count($day_attence);
        return response()->json($route); 
      
    
    }
    public function show($id)
    {
       
       // $routes=Routes::with('Route_shop')->where('status', '1')->where('deleted_on_off', '1')->where('user_id',$id)->orderBy('created_at', 'DESC')->get();
         
 
        $routes=Stores::withcount(['store_atten' => function ($query) 
        {$query->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),date('d-m-Y'));
        }])
        
        
        ->where('route_id', $id)->where('status', '1')->where('deleted_on_off', '1')
                 ->orderBy('latitude', 'ASC')
                    ->orderBy('longitude', 'ASC')
                    ->paginate(10);
        return response()->json($routes); 
      
    
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
  
    public function stores($id)
    {
        $store = DB::table('stores')
        ->join('categories', 'stores.category', '=', 'categories.id')
        ->join('countries', 'stores.country_id', '=', 'countries.id')
        ->join('routes', 'stores.route_id', '=', 'routes.id')
        ->join('zones', 'stores.zone_id', '=', 'zones.id')
        ->join('states', 'stores.state_id', '=', 'states.id')
        ->join('districts', 'stores.district_id', '=', 'districts.id')
        ->select('stores.*','routes.name as route_name', 'categories.name as category_name','zones.name as zone_name', 'states.name as state_name','countries.name as country_name', 'districts.name as district_name')
        ->where('stores.deleted_on_off','1')
        ->where('stores.status','1')
        ->where('stores.id',$id)
        ->first();
        //$sto['stoDet']=$store;


        $store_attendance=store_attendance::where('store_id',$id)
        ->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),date('d-m-Y'))
        ->orderBy('created_at', 'DESC')->get();
        
  

        if($store!='')
        {
        $store->store_atten_count=count($store_attendance);
        }


        return response()->json($store); 

    }

    public function pcat()
    {
        $product_categorys=product_category::where('deleted_on_off', '1')->where('status','1')->orderBy('name', 'ASC')->get();
      
        return response()->json($product_categorys); 
    }
 

    public function product($id)
    {
        if($id=='0')
        {
            $products = DB::table('products')
            ->join('product_units', 'products.unit_id', '=', 'product_units.id')
            ->join('product_categories', 'products.cat_id', '=', 'product_categories.id')
            ->select('products.*','product_units.name as units_name', 'product_categories.name as category_name')       
            ->where('products.deleted_on_off','1')            
            ->orderBy('products.name', 'ASC')
            ->paginate(10);
         

        }
        else
        {

            $products = DB::table('products')
            ->join('product_units', 'products.unit_id', '=', 'product_units.id')
            ->join('product_categories', 'products.cat_id', '=', 'product_categories.id')
            ->select('products.*','product_units.name as units_name', 'product_categories.name as category_name')    
            
            ->where('products.status','1')
            ->where('products.cat_id',$id)
            ->orderBy('products.name', 'ASC')
            ->paginate(10);
         


        }

        return response()->json($products); 



    }


    public function zone()
    {
       
        $states=State::where('user_id', Auth::user()->id)->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
     
        $s=Array();
        foreach($states as $sta)
        { 
        $s_id=$sta->id;
        array_push($s,$s_id);
        } 

    $zones=Zone::wherein('state_id', $s)->where('status', '1')->where('deleted_on_off', '1')->orderBy('name', 'ASC')->get();
     


        return response()->json($zones); 
    }
 

    public function zone_details($id,$date)
    {

            // $routes = DB::table('routes')
            // ->join('route_allocates', 'route_allocates.route_id', '=', 'routes.id')   
            // ->join('users', 'route_allocates.user_id', '=', 'users.id')  
            //  ->select('routes.*','users.name as user_name','users.id as user_id')       
            // ->where('routes.deleted_on_off','1')            
            // ->orderBy('routes.name', 'ASC')
            // ->where('routes.zone_id',$id)
            // ->where('route_allocates.date',$date)
            // ->paginate(10);




            $routes=Routes::with(['route_allocated' => function($que) use ($date)
                   {
                    $que->where('date',$date);
    
                   }])->where('zone_id',$id)
                  ->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->paginate(10);






            


        return response()->json($routes); 



    }

    public function sr_details($id)
    {
             $routes = DB::table('district_allocates')
            ->join('users', 'district_allocates.user_id', '=', 'users.id')           
            ->select('district_allocates.*','users.name as user_name')       
            ->where('users.deleted_on_off','1')            
            ->orderBy('users.name', 'ASC')
            ->where('district_allocates.zone_id',$id)
            ->get();
        return response()->json($routes); 



    }




    public function sr_store(Request $request)
    {
   

        $validator = Validator::make($request->all(), 
        [ 
            'user_id' => 'required|numeric',           
            'route_id' => 'required|numeric',
            'date'=>'required',
          
             
        ]);

                 if ($validator->fails())
                 {
        return response()->json([ 'status' => 'Error','Message'=>'User not acceptable ' ], 200);
                 }
                 else
                 {


$route = Routes ::find($request->input('route_id')); 
//$route->user_id=$request->input('user_id'); 
//$route->updated_at= new \DateTime();
$dt=$route->district_id;
$zt=$route->zone_id;
$st=$route->state_id;
$ct=$route->country_id;
//$route->save();  

$route_check = route_allocate::where('route_id',$request->input('route_id'))->where('date',$request->input('date'))->first(); 
if(count($route_check)>0)
{
    $route_check->user_id=$request->input('user_id'); 
    $route_check->updated_at=new \DateTime(); 
    $route_check->save(); 
}
else
{
$sal=new route_allocate;
$sal->user_id=$request->input('user_id'); 
$sal->route_id=$request->input('route_id');
$sal->district_id=$dt; 
$sal->state_id=$st;
$sal->zone_id=$zt;
$sal->country_id=$ct;
$sal->status=1;
$sal->date=$request->input('date');
$sal->created_user=Auth::user()->id;
$sal->created_at=new \DateTime();
$sal->save(); 
}




return response()->json([ 'status' => 'Success','Message'=>'User Allocated Sucessfully'], 200);


                 }

    }

   


    public function sm_to_sr()
    {
       $state = state ::where('user_id',Auth::user()->id)->get();
       if(count($state)>0)
       {

                $s=Array();
                foreach($state as $sta)
                { 
                $s_id=$sta->id;
                array_push($s,$s_id);
                } 

                $user = DB::table('district_allocates')
                ->leftjoin('users', 'district_allocates.user_id', '=', 'users.id')           
                ->select('district_allocates.user_id','users.name as user_name')       
                ->whereIn('district_allocates.state_id',$s)
                ->get();

       }
        else {
    $user=array();
        }
      
       return response()->json($user); 
    
    }
    


    public function sr_attence(Request $request)
    {
        $user_id=$request->input('user_id'); 
        $date=$request->input('date'); 


        $day_attendance = day_attendance::where('user_id',$user_id)
        ->where('punch','in')
        ->orderBy('created_at', 'DESC')
        ->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),$date)
        ->select('id',DB::raw('DATE_FORMAT(created_at, "%d-%m-%Y") as date'),DB::raw('DATE_FORMAT(created_at,"%d-%m-%Y:%H-%i") as intime'),DB::raw('DATE_FORMAT(updated_at,"%d-%m-%Y:%H-%i") as outtime'))
       ->get();


     


      $store_attendance = DB::table('store_attendances')
      ->join('stores', 'store_attendances.store_id', '=', 'stores.id')    
      ->join('routes', 'store_attendances.route_id', '=', 'routes.id')        
      ->select('store_attendances.id','store_attendances.date','store_attendances.time','stores.store_name as store_name','routes.name as route_name')       
      ->where('store_attendances.user_id',$user_id)
      ->where(DB::raw("(DATE_FORMAT(store_attendances.created_at,'%d-%m-%Y'))"),$date)
      ->get();

 
      
    $route_attendance=route_allocate::
    with(['route_allocate'=> function($query) 
    {
        $query->with('Route_shop');
        }])
    ->where(DB::raw("(DATE_FORMAT(created_at,'%d-%m-%Y'))"),$date) ->where('user_id',$user_id) 
    ->get();
     
      return response()->json([ 'day_attence' => $day_attendance,'store_attendance'=>$store_attendance,'route_attendance'=>$route_attendance], 200);

    
    
    }
    
    public function user_histry()
    {
        $admin = User ::find(Auth::user()->id);

        if($admin->role_id=='3')
        {


        }
        elseif($admin->role_id=='5')
        {

        }
        else
        {

        }
 

    }


    public function pwdchge(Request $request)
    {
        $admin = User ::find(Auth::user()->id);

        $oldpwd=$request->input('oldpwd');
        $newpwd=$request->input('newpwd');


        if ($admin && Hash::check($oldpwd, $admin->password))
         {
            

            $admin->password=bcrypt($request->input('newpwd'));  
            $admin->updated_at= new \DateTime();
            $admin->save();


            if (Auth::check())
     {
       
Auth::user()->AauthAcessToken()->delete();
return response()->json(['status' => 'success'], 200);
}
           
    
        }

        
        else
        {
            return response()->json(['status' => 'failed',
            'error'=>'OldPassword  Incorrect'], 200);
        }
 

    }






}
<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Facades\View;
use DB;
use Validator;
use App\Zone;
use App\State;
use App\District;
use App\Country;
use App\user_state;
use App\user_zone;
use App\user_district;
use auth;
use App\state_allocate;
use App\zone_allocate;
use App\district_allocate;

class AdminController extends Controller
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
        $admins=User::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        return view('admin/index',['admins'=>$admins]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $states=State::where('user_id','0')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();

        $states1=State::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        $countrys=Country::where('status', '1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        $admins=User::where('role_id', '3')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
       
        return view('admin/create',['countrys'=>$countrys,'admins'=>$admins,'states'=>$states ,'states1'=>$states1]); 
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
 [            
       'admin'=>'required',
 ],
 [
 'admin.required'=>"Select Admin Or Superadmin",    
 
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

      
if($request->input('admin')=='1' ||  $request->input('admin')=='2')
{
    

 $validator = Validator::make($request->all(), 
 [     'name' => 'required|string|max:255',
       'phone' => 'required|unique:users,phone',
       'email' => 'required|unique:users,email',           
       'password' => 'required|string|min:6|confirmed',            
       'admin'=>'required',
 ],
 [
 'name.required'=>"Enter your Name",
 'admin.required'=>"Select Admin Or Superadmin",   
 'phone' =>"Phone Number Already taken",
 'email' => "Email Already taken",        
 
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

    $admin = new User;
    $admin->name=$request->input('name');   
    $admin->email=$request->input('email');                   
    $admin->password=bcrypt($request->input('password'));  
    $admin->phone=$request->input('phone');   
    $admin->role_id=$request->input('admin');   
    $admin->created_user=Auth::user()->id;       
    $admin->status=1;
    $admin->deleted_on_off=1;  
    $admin->created_at= new \DateTime();
    $admin->save();
     $notification = array(
    'message' => 'your data inserted.', 
    'alert-type' => 'success' ); 
    return Redirect::to('admin')->with($notification);

}
}
else
{
   if($request->input('admin')=='3')
   {


    $validator = Validator::make($request->all(), 
    [     
        'name' => 'required|string|max:255',
        'phone' => 'required|unique:users,phone',
        'email' => 'required|unique:users,email',      
        'password' => 'required|string|min:6|confirmed',            
        'admin'=>'required',
        'check_state' => 'required',
        
    ],
    [
    
    'check_state.required'=>"Select State",   
  
    
    
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

            $admin = new User;
            $admin->name=$request->input('name');   
            $admin->email=$request->input('email');                   
            $admin->password=bcrypt($request->input('password'));  
            $admin->phone=$request->input('phone');   
            $admin->role_id=$request->input('admin'); 
            $admin->created_user=Auth::user()->id;          
            $admin->status=1;
            $admin->deleted_on_off=1;  
            $admin->created_at= new \DateTime();
            $admin->save();

            $admins=User::orderBy('id', 'DESC')->first();
            $state_all = $request->input('check_state');


          
    

            foreach($state_all as $sta)
            {
                
            $state = State ::find($sta);
            $c_id=$state->country_id;
            $state->user_id=$admins->id;
            $state->save(); 

            $sal=new state_allocate;
            $sal->user_id=$admins->id;
            $sal->state_id=$sta;  
            $sal->country_id=$c_id;
            $sal->status=1;
            $sal->created_user=Auth::user()->id;  
            $sal->created_at=new \DateTime();
            $sal->save(); 
           
            }

            

             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('admin')->with($notification);


         }

   }
   elseif($request->input('admin')=='4')
   {



    $validator = Validator::make($request->all(), 
    [  
    'name' => 'required|string|max:255',
    'phone' => 'required|unique:users,phone',
    'email' => 'required|unique:users,email',     
    'password' => 'required|string|min:6|confirmed',            
    'admin'=>'required', 
    'sm' => 'required',
    'check_zone' => 'required', 
    ],
    [
  
    'sm.required'=>"Select Sales Manager",   
    'check_zone' =>"Select Zone",
    
    
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

            $admin = new User;
            $admin->name=$request->input('name');   
            $admin->email=$request->input('email');                   
            $admin->password=bcrypt($request->input('password'));  
            $admin->phone=$request->input('phone');   
            $admin->role_id=$request->input('admin');         
            $admin->status=1;
            $admin->created_user=Auth::user()->id;  
            $admin->deleted_on_off=1;  
            $admin->created_at= new \DateTime();
            $admin->save();
            $admins=User::orderBy('id', 'DESC')->first();
           //$sm_admin=User::where('user_id',$request->input('state'))->first();
            $zone_all = $request->input('check_zone');


            foreach($zone_all as $sta)
            {

            $zone = Zone ::find($sta);
            $c_id=$zone->country_id;
            $s_id=$zone->state_id;
            $zone->user_id=$admins->id;
            $zone->save(); 

            $sal=new zone_allocate;
            $sal->zone_id=$sta; 
            $sal->user_id=$admins->id;
            $sal->state_id=$s_id;
            $sal->country_id=$c_id;
            $sal->status=1;
            $sal->created_user=Auth::user()->id;  
            $sal->created_at=new \DateTime();
            $sal->save(); 
           
            }





             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('admin')->with($notification);


         }

   }
   else
   {



    $validator = Validator::make($request->all(), 
    [     
        'name' => 'required|string|max:255',
        'phone' => 'required|unique:users,phone',
        'email' => 'required|unique:users,email',         
        'password' => 'required|string|min:6|confirmed',            
        'admin'=>'required',
        'state' => 'required',
        'zone' => 'required',   
        'district' => 'required',           
         
    ],
    [
   
    'state.required'=>"Select State",   
    'zone' =>"Select Zone",
    'district' =>"Select District",
    
    
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

            $admin = new User;
            $admin->name=$request->input('name');   
            $admin->email=$request->input('email');                   
            $admin->password=bcrypt($request->input('password'));  
            $admin->phone=$request->input('phone');   
            $admin->role_id=$request->input('admin');   
            $admin->created_user=Auth::user()->id;        
            $admin->status=1;
            $admin->deleted_on_off=1;  
            $admin->created_at= new \DateTime();
            $admin->save();

            $admins=User::orderBy('id', 'DESC')->first();
            $dis=district::find($request->input('district'));
            $zid=$dis->zone_id;
            $sid=$dis->state_id;
            $cid=$dis->country_id;

            $usr = new district_allocate;
            $usr->user_id=$admins->id;
            $usr->district_id=$request->input('district');  
            $usr->zone_id=$zid;  
            $usr->state_id=$sid; 
            $usr->created_user=Auth::user()->id;   
            $usr->country_id=$cid;  
            $usr->status=1;
            $usr->created_at= new \DateTime();
            $usr->save();


             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('admin')->with($notification);


         }



   }

}

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
    //      $admin = User::find($id);
    //     if($admin->status==0)
    //     {
    //     $admin->status=1;

    //     $notification = array(
    //         'message' => 'admin is Unblocked', 
    //         'alert-type' => 'success');
    //           }
              
    //           else
    //             { 
    //                  $admin->status=0;
    //                  $notification = array(
    //         'message' => 'Admin is blocked', 
    //         'alert-type' => 'error');
    //           }
              

    //     $admin->updated_at=new \DateTime();
    //     $admin->save();

    //     return Redirect::to('admin')->with($notification);//
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
     $admin = User ::find($id);
     $r_id=$admin->role_id;

     if($r_id=='3')
     {
        $ur=user_state::where('user_id',$id)->get();
     }
     elseif($r_id=='4')
     {
        $ur=user_zone::where('user_id',$id)->first();
     }
     elseif($r_id=='5')
     {
        $ur=user_district::where('user_id',$id)->first();
        
     }
     else
     {
         $ur='';
     }
    
   
   

      $countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
      $states=state::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();  
      $zones=Zone::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();  
      $districts=District::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get(); 
     // return View::make('admin.edit')->with('admin',$admin) ;

      return view('admin.edit',['r_id'=>$r_id,'ur'=>$ur,'districts'=>$districts,'admin'=>$admin,'zones'=>$zones,'states'=>$states,'countrys'=>$countrys]);   
    }


 public function password($id)
    {
      $admin = User ::find($id);
      return View::make('admin.admin.password')->with('admin',$admin) ; ////
    }

    public function password_update(Request $request, $id)
    {
         
        








 $this->validate($request,
       
        [
            'password' => 'required|string|min:6|confirmed',

        ]); 
            $admin = User ::find($id);           
            $admin->password=bcrypt($request->input('password'));  
            $admin->updated_at= new \DateTime();
            $admin->save();
            $notification = array(
            'message' => 'Your Password changed', 
            'alert-type' => 'success');
            return Redirect::to('admin')->with($notification);  

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
              'admin'=>'required',
        ],
        [
        'admin.required'=>"Select Admin Or Superadmin",    
        
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


            if($request->input('admin')=='1' ||  $request->input('admin')=='2')
{
    

 $validator = Validator::make($request->all(), 
 [     'name' => 'required|string|max:255',
        'phone' => 'unique:users,phone,'.$id.',id',           
        'email' => 'unique:users,email,'.$id.',id', 
       'admin'=>'required',
 ],
 [
 'name.required'=>"Enter your Name",
 'admin.required'=>"Select Admin Or Superadmin",   
 'phone' =>"Phone Number Already taken",
 'email' => "Email Already taken",        
 
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
        DB::delete('delete from user_states where user_id = ?',[$id]);
        DB::delete('delete from user_zones where user_id = ?',[$id]);
        DB::delete('delete from user_districts where user_id = ?',[$id]);

    $admin = User ::find($id);    
    $admin->name=$request->input('name');   
    $admin->email=$request->input('email');                   
    $admin->password=bcrypt($request->input('password'));  
    $admin->phone=$request->input('phone');   
    $admin->role_id=$request->input('admin');         
 
    $admin->updated_at= new \DateTime();
    $admin->save();
     $notification = array(
    'message' => 'your data inserted.', 
    'alert-type' => 'success' ); 
    return Redirect::to('admin')->with($notification);


}
}


else
{
   if($request->input('admin')=='3')
   {


    $validator = Validator::make($request->all(), 
    [     
        'name' => 'required|string|max:255',
        'phone' => 'unique:users,phone,'.$id.',id',           
        'email' => 'unique:users,email,'.$id.',id' ,          
              
        'admin'=>'required',
        'check_state' => 'required',
        
    ],
    [
    
    'check_state.required'=>"Select State",   
  
    
    
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

            $admin = User ::find($id);    
            $admin->name=$request->input('name');   
            $admin->email=$request->input('email');                   
            $admin->password=bcrypt($request->input('password'));  
            $admin->phone=$request->input('phone');   
            $admin->role_id=$request->input('admin');         
          
            $admin->updated_at= new \DateTime();
            $admin->save();

            DB::delete('delete from user_states where user_id = ?',[$id]);
            DB::delete('delete from user_zones where user_id = ?',[$id]);
            DB::delete('delete from user_districts where user_id = ?',[$id]);

            $state_all = $request->input('check_state');
            foreach($state_all as $sta)
            {
            $usr = new user_state;
            $usr->user_id=$id;
            $usr->state_id=$sta;  
            $usr->country_id=$request->input('country');  
            $usr->created_at= new \DateTime();
            $usr->save();
           
            }

            

             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('admin')->with($notification);


         }

   }
   elseif($request->input('admin')=='4')
   {



    $validator = Validator::make($request->all(), 
    [  
    'name' => 'required|string|max:255',
    'phone' => 'unique:users,phone,'.$id.',id',           
    'email' => 'unique:users,email,'.$id.',id',          
       
    'admin'=>'required', 
    'country' => 'required',
    'state' => 'required',
    'zone' => 'required', 
    ],
    [
    'country.required'=>"Select Country",
    'state.required'=>"Select State",   
    'zone' =>"Select Zone",
    
    
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

            $admin = User ::find($id);
            $admin->name=$request->input('name');   
            $admin->email=$request->input('email');                   
            $admin->password=bcrypt($request->input('password'));  
            $admin->phone=$request->input('phone');   
            $admin->role_id=$request->input('admin');         
            
            $admin->updated_at= new \DateTime();
            $admin->save();

          
            DB::delete('delete from user_states where user_id = ?',[$id]);
            DB::delete('delete from user_zones where user_id = ?',[$id]);
            DB::delete('delete from user_districts where user_id = ?',[$id]);

            $usr->user_id=$id;
            $usr->zone_id=$request->input('zone');  
            $usr->state_id=$request->input('state');  
            $usr->country_id=$request->input('country');  
            $usr->created_at= new \DateTime();
            $usr->save();


             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('admin')->with($notification);


         }

   }
   else
   {



    $validator = Validator::make($request->all(), 
    [     
        'name' => 'required|string|max:255',
        'phone' => 'unique:users,phone,'.$id.',id',           
        'email' => 'unique:users,email,'.$id.',id' ,      
           
        'admin'=>'required',
        'country' => 'required',
          'state' => 'required',
          'zone' => 'required',   
          'district' => 'required',           
         
    ],
    [
    'country.required'=>"Select Country",
    'state.required'=>"Select State",   
    'zone' =>"Select Zone",
    'district' =>"Select District",
    
    
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

            $admin = User ::find($id);
            $admin->name=$request->input('name');   
            $admin->email=$request->input('email');                   
            $admin->password=bcrypt($request->input('password'));  
            $admin->phone=$request->input('phone');   
            $admin->role_id=$request->input('admin');         
            
            $admin->updated_at= new \DateTime();
            $admin->save();

            DB::delete('delete from user_states where user_id = ?',[$id]);
            DB::delete('delete from user_zones where user_id = ?',[$id]);
            DB::delete('delete from user_districts where user_id = ?',[$id]);

            $usr = new user_district;
            $usr->user_id=$id;
            $usr->district_id=$request->input('district');  
            $usr->zone_id=$request->input('zone');  
            $usr->state_id=$request->input('state');  
            $usr->country_id=$request->input('country');  
            $usr->created_at= new \DateTime();
            $usr->save();


             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('admin')->with($notification);


         }



   }

}


        }

    }


//  $this->validate($request,
       
//         [
//             'name' => 'required|string|max:255',
//             'admin'=>'required',
//             'phone' => 'unique:users,phone,'.$id.',id',           
//             'email' => 'unique:users,email,'.$id.',id'
//         ],
//         [
//              'name.required'=>"Enter your Name",
//              'admin.required'=>"Select Admin Or Superadmin", 
//              'email.required'=>"Email Alredy Taken",
//              'phone.required'=>"Phone Number Alredy Taken",          

//             ]); 

//             $admin = User ::find($id);           
//             $admin->name=$request->input('name');
//             $admin->phone=$request->input('phone');
//             $admin->email=$request->input('email');
//             $admin->role_id=$request->input('admin');
            
//             $admin->updated_at= new \DateTime();
//             $admin->save();
//             $notification = array(
//             'message' => 'Your Employee details is updated', 
//             'alert-type' => 'success');
//             return Redirect::to('admin')->with($notification);


//     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $admin = User ::find($id);
            $admin->deleted_on_off= 0;
            $admin->deleted_at= new \DateTime();
            $admin->save();

            

                $notification = array(
            'message' => 'Employee is Deleted', 
            'alert-type' => 'success');
            return Redirect::to('admin')->with($notification);  //
    }


    public function getList($id)
    {

        $states = state_allocate::where("user_id",$id)->where('status','1')->get();
      

        $s=Array();
        foreach($states as $sta)
        { 
        $s_id=$sta->state_id;
        array_push($s,$s_id);
        } 
        $admins=Zone::where("user_id",'0')->whereIn('state_id',$s)->where('status','1')->get();
    
        return view('admin/allocate',['admins'=>$admins]);  
    }


    

    
    public function getuserzone(Request $request)
    {
      

       //  return response()->json($admins);
    }


    public function getzone(Request $request)
    {
        $states = DB::table("zones")
                    ->where("state_id",$request->country_id)
                    ->pluck("name","id");
        return response()->json($states);
    }
    public function getdistrict(Request $request)
    {
        $cities = DB::table("districts")
                    ->where("zone_id",$request->state_id)
                    ->pluck("name","id");
        return response()->json($cities);
    }






    public function getadminzone(Request $request)
    {
       
        $states = state_allocate::where("user_id",$request->country_id)->where('status','1')->get();
        
        $s=Array();
        foreach($states as $sta)
        {
           
        $s_id=$sta->state_id;
        array_push($s,$s_id);
        } 

      
        $admins = DB::table('zone_allocates')
        ->join('users', 'users.id', '=', 'zone_allocates.user_id')
        ->where('zone_allocates.status','1')
        ->whereIn('zone_allocates.state_id',$s)
        ->pluck('users.name as name','users.id as id');
        return response()->json($admins);


    }
    public function getadmindistrict(Request $request)
    {
        $s=Array();
        $states = zone_allocate::where("user_id",$request->state_id)->where('status','1')->get();
        foreach($states as $sta)
        {
          $s_id=$sta->zone_id;
          //$admins=Zone::where('state_id',$s_id)->where('status','1')->pluck("name","id");
         array_push($s,$s_id);
         
        } 
     
        $admins=district::whereIn('zone_id',$s)->where('status','1')->pluck("name","id");

        return response()->json($admins);
       
     
    }


  
}

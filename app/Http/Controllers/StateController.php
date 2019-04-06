<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;



use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use App\State;
use Illuminate\Support\Facades\View;
use DB;
use Validator;
use App\Country;
use App\User;
use App\state_allocate;
use auth;

class StateController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
        // $states=State::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();

        $states = DB::table('states')
        ->join('countries', 'states.country_id', '=', 'countries.id')       
        ->select('states.name as name', 'countries.name as country', 'states.id as id')
        ->get();

        return view('state/index',['states'=>$states]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
       // return view('state/create'); 
        return view('state/create',['countrys'=>$countrys]);  
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
      [    'name' => 'required|unique:states,name',
           'country' => 'required',
          
      ],
      [
      'name.required'=>"Enter your Name",
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
      
            $state = new State;
            $state->name=ucfirst($request->input('name'));    
            $state->country_id=$request->input('country');   
            $state->created_user=Auth::user()->id;   
            $state->status=1;
            $state->deleted_on_off=1;  
            $state->created_at= new \DateTime();
            $state->save();
             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('state')->with($notification);
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
    //      $state = State::find($id);
    //     if($state->status==0)
    //     {
    //     $state->status=1;

    //     $notification = array(
    //         'message' => 'state is Unblocked', 
    //         'alert-type' => 'success');
    //           }
              
    //           else
    //             { 
    //                  $state->status=0;
    //                  $notification = array(
    //         'message' => 'state is blocked', 
    //         'alert-type' => 'error');
    //           }
              

    //     $state->updated_at=new \DateTime();
    //     $state->save();

    //     return Redirect::to('state')->with($notification);//
    // }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $state = State ::find($id);
      $countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
      

      return view('state.edit',['state'=>$state,'countrys'=>$countrys]);  
    //  return View::make('state.edit')->with('state',$state) ;
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
              'country' => 'required',
              'name' => 'required|unique:states,name,'.$id.',id',
           
            
        ],
        [
        'name.required'=>"Enter your Name",
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
     
            $state = State ::find($id);           
           $state->name=ucfirst($request->input('name'));    
           $state->country_id=$request->input('country');                 
           $state->updated_at=new \DateTime();
           $state->save();
            $notification = array(
           'message' => 'Your Sate details is updated', 
           'alert-type' => 'success' ); 
           return Redirect::to('state')->with($notification);
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
            $state = State ::find($id);
            $state->deleted_on_off= 0;
            $state->deleted_at= new \DateTime();
            $state->save();

            

                $notification = array(
            'message' => 'State is Deleted', 
            'alert-type' => 'success');
            return Redirect::to('state')->with($notification);  //
    }

    public function allocate_index()
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
      //  $states=State::with('s_u')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        
        $states=State::with(['s_u' => function($query) {
            $query->with('user_name');
        }])->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        

       // $admins=User::where('role_id', '3')->where('status', '1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        return view('state/allocate',['states'=>$states]);  

      //  return response()->json($states);
    }

    public function allocate($id1,$id2)
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();

        $state = State ::find($id2);
        $state->user_id=$id1; 
        $ct=$state->country_id;
        $state->updated_at=new \DateTime();
        $state->save(); 

        $sal=new state_allocate;
        $sal->user_id=$id1; 
        $sal->state_id=$id2; 
        $sal->country_id=$ct; 
        $sal->created_user=Auth::user()->id;  
        $sal->created_at=new \DateTime();
        $sal->save(); 

        $notification = array(
            'message' => 'User Allocated To State', 
            'alert-type' => 'success' ); 
            return Redirect::to('state_allocate')->with($notification);
        
    }



}

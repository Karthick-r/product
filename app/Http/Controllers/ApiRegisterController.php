<?php

namespace App\Http\Controllers;
use Auth;

use App\User;
use Illuminate\Http\Request;

use Validator;
use App\Model\Admin\route;

use GuzzleHttp\Psr7\Response;
use App\District;
class ApiRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      

}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)

    { 


        $validator = Validator::make($request->all(), [
            'login' => 'required',
            'password' => 'required'
        ]);
 
        if ($validator->fails()) 
        {
            return response()->json(['status' => 'Failed',
            'error'=>$validator->errors()], 200);            
        }
        
        $field = filter_var($request->input('login'), FILTER_VALIDATE_INT) ? 'phone' : 'email';
       
        


        
        $request->merge([$field => $request->input('login')]);
 
                if(Auth::attempt($request->only($field, 'password')))
                {

                    $user = Auth::user();
                    if( $user->role_id==3 || $user->role_id==5 )
                    {

                    if( $user->deleted_on_off==1  )
                    {
                    if( $user->status==1  )
                    {

                    $success['id'] =  $user->id;
                    $success['Name'] =  $user->name;  
                    $success['Email'] =  $user->email;          
                    $success['Mobile'] =  $user->phone;  
                    $success['Role'] =  $user->role_id;   
                    $success['token'] =  $user->createToken('MyApp')->accessToken;
                    return response()->json([ 'status' => 'Success' ,'success' => $success], 200); 


                }

                else
                {
                   return response()->json(['status' => 'failed',
                    'error'=>'Your Account is blocked, please contact the admin'], 200);  
                }
                

            }

            else
            {
               return response()->json(['status' => 'failed',
                'error'=>'Please contact the admin'], 200);  
            }


                }

                else
                {
                    return response()->json(['status' => 'failed',
                    'error'=>'Email or Password is Incorrect, Unauthorized'], 200);
                }
            }

                else
                {
                    return response()->json(['status' => 'failed',
                    'error'=>'Email or Password is Incorrect, Unauthorized'], 200);
                }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function logout()
    { 
        if (Auth::check()) {
           
           
     Auth::user()->AauthAcessToken()->delete();

     return response()->json(200);

       
    }
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        

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
       
         

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //  API. Resources

    }

    public function zone()
    {
         //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
         $districts=district::with('District_Zone')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        
        return response()->json([ 'status' => 'Success' ,'success' => $districts], 200); 

    }



  





}
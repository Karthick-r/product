<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

use Auth;

use Validator;

use App\Profile;

use App\Players;

use App\Team;
use Illuminate\Support\Facades\Input;


class RegisterApiController extends Controller
{
    public function RegisterApi(Request $request){
        $this->validate($request,
        [
            'fname' => 'required|string|max:255',
            'password' => 'required|string|min:6|confirmed',
             'phone' => 'required|integer|unique:users'
           
             
       ]);

        
  
             $user = new User;
            $user->fname=$request->input('fname');
            $user->lname=$request->input('lname');
            $user->email=$request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->phone=$request->input('phone');
            $user->status=1;
            $user->deleted_on_off=1;
            $user->role_id= 1;
            $user->admin=0;
            if(Profile::where('refcode', '=', $request->ref)->exists()){

            $user->reff = 1;
           $user->refby = Profile::where('refcode', '=', $request->ref)->first()->refcode;
          }else{
            $user->reff = 0;
             $user->refby  = null;


           }


           
           
            $user->save();

            $player = new Players;



            $player->id =  $user->id;
            $player->players =  $request->fname;


            $player->save();
           
            
            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->fname;
            $success['id'] = $user->id;
            $success['referral_code'] = $user->refcode;
         

       return response()->json(['success'=>$success], 200);
       
                      
    }


public function checkref(Request $request){

if(Profile::where('refcode', '=', Input::get('ref'))->exists()){

return response()->json(['Success' => "Ref code found"]);


}else{

return response()->json(['Failed' => "Not found"]);

}

}


public function login(Request $request)
{

    $this->validate($request, [
        'login'    => 'required',
        'password' => 'required',
    ]);
 
    $login_type = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL ) 
        ? 'email'  
        : 'phone' 
        ;
 
    $request->merge([
        $login_type => $request->input('login')
    ]);
 
     
    if (Auth::attempt($request->only($login_type, 'password'))) {
        if(Auth::user()->role_id !== 1){
            return response()->json(['error'=>'you are blocked by admin'], 200);
            Auth::user()->AauthAcessToken()->delete();


        }else{
             $user = Auth::user();
             $success['id'] = $user->id;
             $success['name'] = $user->fname;
                       if(!$user->lname ){
                   $success['lname'] = "";

                    }else{
             $success['lname'] = Auth::user()->lname; 
        
                              }
                              if(!$user->email ){
                                $success['email'] = "";
             
                                 }else{
                          $success['email'] = Auth::user()->email;
                     
                                           }

           $success['phone'] = $user->phone;
                 if(Profile::where('user_id', '=', Auth::user()->id)->exists()){
                $success['img_url'] = $user->profile->avatar;
                $success['dob'] = $user->profile->dob;
                $success['profile_exists'] = 1;
                $success['ref_code'] = $user->profile->refcode;

            }else{
                $success['img_url'] = "";
                $success['profile_exists'] = 0;
                $success['dob'] = "";
                $success['ref_code'] = "";

            }
           
        $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], 200);
    }
}
    else{
        return response()->json(['error'=>'Your input pairs do not match our records'], 200);
    }
}
public function logout()
{ 
    if (Auth::check()) {
       
       
 Auth::user()->AauthAcessToken()->delete();

 return response()->json(['success' => 'You are logged out'],200);

   
}
    
}

public function inituser(Request $request,$id){



$teams  = Team::find($id);



 $teams->players()->attach($request->players);


 return response()->json(['Success' => 'Player added'], 200);

}


public function social(Request $request){

  $messages = [
    'access_code.unique' => 'You have already registered with this email account, you can login or register with new email account'
  ];

  $this->validate($request,
        [
            'fname' => 'required|string|max:255',
            'access_code' => 'required|unique:users',
             'phone' => 'required|integer|unique:users'

       ], $messages);


    $user = new User;
            $user->fname=$request->input('fname');
            $user->lname=$request->input('lname');
          
           $user->email = $request->email;
            $user->phone=$request->input('phone');
$user->password = bcrypt($request->access_code);
            $user->status=1;
            $user->deleted_on_off=1;
            $user->role_id= 1;
            $user->admin=0;
            if(Profile::where('refcode', '=', $request->ref)->exists()){

            $user->reff = 1;
           $user->refby = Profile::where('refcode', '=', $request->ref)->first()->refcode;
          }else{
            $user->reff = 0;
             $user->refby  = null;


           }

   $user->access_code = $request->access_code;




            $user->save();

            $player = new Players;



            $player->id =  $user->id;
            $player->players =  $request->fname;


            $player->save();


            $success['token'] = $user->createToken('MyApp')->accessToken;
            $success['name'] = $user->fname;
            $success['id'] = $user->id;
            $success['referral_code'] = $user->refcode;



return response()->json([
'success'=>$success
]);


}


public function sociallogin(Request $request){

  $this->validate($request,
        [
            'password' => 'required',
            'access_code' => 'required',
  

       ]);


          if(Auth::attempt(['access_code' => request('access_code'), 'password' => request('password')])){ 
        if(Auth::user()->role_id !== 1){
            return response()->json(['error'=>'you are blocked by admin'], 200);
            Auth::user()->AauthAcessToken()->delete();


        }else{
             $user = Auth::user();
             $success['id'] = $user->id;
             $success['name'] = $user->fname;
                       if(!$user->lname ){
                   $success['lname'] = "";

                    }else{
             $success['lname'] = Auth::user()->lname; 

                              }
                              if(!$user->email ){
                                $success['email'] = "";

                                 }else{
                          $success['email'] = Auth::user()->email;

                                           }

           $success['phone'] = $user->phone;
                 if(Profile::where('user_id', '=', Auth::user()->id)->exists()){
                $success['img_url'] = $user->profile->avatar;
                $success['dob'] = $user->profile->dob;
                $success['profile_exists'] = 1;
                $success['ref_code'] = $user->profile->refcode;

            }else{
                $success['img_url'] = "";
                $success['profile_exists'] = 0;
                $success['dob'] = "";
                $success['ref_code'] = "";

            }

        $success['token'] =  $user->createToken('MyApp')->accessToken;
            return response()->json(['success' => $success], 200);
    }
}
    else{
        return response()->json(['error'=>'Your input pairs do not match our records'], 200);
    }


}


}



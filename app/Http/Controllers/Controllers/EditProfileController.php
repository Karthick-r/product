<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Profile;
use App\User;
use App\Bowler;
use DB;
use App\Tournament;
use App\TournamentIn;
use App\MatchIn;
use Auth;
use App\Score;
use App\Team;
use Illuminate\Support\Facades\Input;
use File;
class EditProfileController extends Controller
{

    public function __construct(){

        return $this->middleware('auth:api');
   
 }
  
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

    
      
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, $id)
    {
      $this->validate($request, [
             'batsman' => 'required',
             'bowler' => 'required',
             'about' => 'required',
             'wicketkeeper' => 'required',
             'allrounder' => 'required',
             
      ]);
      if (Profile::where('user_id', Auth::user()->id)->exists()) {
        return response()->json(['Rejected' => Auth::user()->fname." you already have a profile"]);
      
    }
    else{

      $profile = new Profile;
      $users = User::where('id', $id)->first();


      $profile->batsman = $request->batsman;
      $profile->bowler = $request->bowler;
      $profile->about = $request->about;
      $profile->allrounder = $request->wicketkeeper;
     
      $profile->wicketkeeper = $request->wicketkeeper;
      
         $profile->zone = $request->zone;
$profile->country = $request->country;
$profile->city = $request->city;
$profile->pincode = $request->pincode;
if ($request->hasFile('avatar')) {
    $image = $request->avatar;
$image_new_name = time().$image->getClientOriginalName();

$image->move('upload', $image_new_name);
$profile->avatar = "upload/".$image_new_name;

}
else{

$profile->avatar = null;
}

$profile->refcode = "TF".Auth::user()->id;
if(Profile::where('refcode', '=', Auth::user()->refby)->exists()){

$chpoints = Profile::where('refcode', '=', Auth::user()->refby)->first();

if(Auth::user()->reff == 1){

$naming = DB::table('change_points')->where('id', '=', 1)->first();

$chpoints->points = $chpoints->points + $naming->rewards;

$profile->points = $naming->points;

$chpoints->save();

DB::table('credit_history')->insert([

'user_id' => $chpoints->user_id,
'credit' => $naming->rewards,
'reason' => 'coins for referral',
'value' => $naming->rewards." points incremented"

]);


DB::table('credit_history')->insert([ 

'user_id' => Auth::user()->id,
'credit' => $naming->points,
'reason' => 'Welcome credit',
'value' => $naming->points." points incremented"

]);

}

}

$profile->dob = $request->input('dob');
$profile->gender = $request->input('gender');
      $profile->user_id = Auth::user()->id;
      $profile->save();
      $users->fname = $request->fname;
      $users->lname = $request->lname;
      $users->save();
      
 

$tour_ins = new TournamentIn;

$tour_ins->user_id = Auth::user()->id;


$tour_ins->save();


$bow  = new Bowler;

$bow->user_id = Auth::user()->id;
      
$bow->save();


$scr = new Score;
$scr->user_id = Auth::user()->id;
$scr->save();





    
     return response()->json([
        "img url" => $profile->avatar,
      "ref_code" => $profile->refcode,
        "Success" => "profile created successfully"
    ]);

    }
}
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)


    {

        
      $profile = Profile::where('user_id' , $user_id)->first();

        

            // 'batsman' => 'required',
            // 'bowler' => 'required',
            // 'about' => 'required',
            // 'wicketkeeper' => 'required',
            // 'allrounder' => 'required',


            $teamname = $profile->batsman;
            $country = $profile->bowler;
            $state =$profile->about ;
            $city = $profile->wicketkeeper;
            $pin = $profile->allrounder;
             $zone = $profile->zone ;
             $countrys = $profile->country;
             $citys = $profile->city; 
           $pincode = $profile->pincode;
         $avatars = $profile->avatar;
          $dobs = $profile->dob;
            $genders = $profile->gender;
           $get =  DB::table('tournament_ins')
           ->where('user_id',Auth::user()->id)->first();   
           
           
           $bowlers =  DB::table('bowlers')
           ->where('user_id',Auth::user()->id)->first();
              
           if(DB::table('tournaments')
           ->where('user_id',Auth::user()->id)->exists()){
           $tours =  DB::table('tournaments')
           ->where('user_id',Auth::user()->id)->first()->tourtype;
            }
else{

$tours = null;
}
          
           $ts = DB::table('tournament_ins')->where('user_id',  '=', $user_id)->get();

           $scrs =  DB::table('scores')
           ->where('user_id', '=', $user_id)->first();

$value1 = array();

if(DB::table('match_ins')->where('user_id', '=', $user_id)->exists()){
  $ms = DB::table('match_ins')->where('user_id', '=', $user_id)->get();

$value= array();

foreach( $ms as $mss){


           $value[] = [
            'id' => $mss->id,
           'team' => Team::where('id', '=', $mss->team_id)->first()->teamname,
           'versus' => Team::where('id', '=', $mss->vsteam)->first()->teamname,
           'team score' => $mss->teamsc,
           'your score' => $mss->yourscore,
           'your wicket' => $mss->yourwicket,
           'opponent score' => $mss->comsc,

           'result' => $mss->result,
           'location' => $mss->location,

          'date' => $mss->created_at
        
          
           ];


}

}else{


$value = null;

}


foreach( $ts as $mss){


    $value1[] = [
        
    'awards' =>   $mss->awards,
     'awardsname' => $mss->awardsname

    ];  


}


        return response()->json([
        
                'user_id' => $profile->user_id,
                "name" => User::where('id', $user_id)->first()->fname,
               "lname" => User::where('id', $user_id)->first()->lname,
                "total_rewards" =>$profile->points,
                "total_matches"=> $get->noofinnings,
                "total_wickets"=> $get->totalwc,
                "total_runs"=> $get->totalsc,

                "img_url" => $avatars,
                "info" => [
                  "dob" => $dobs,
                 "place" => $citys,
                 'Batsman' =>  $teamname,
                  'bowler' => $country,
                'about' => $state,
               'wk' => $city,
        "pincode" => $pincode,

       "zone" => $zone,

      "country" => $countrys,
     "gender" => $genders,
    'allrounder' => $pin,

                ],

                "batsman" =>[
                    

                    "high score" => $scrs->highscore,
                    "average strike rate" => $scrs->avgst,
                    "half century" => $scrs->fifty,
                    "century" => $scrs->century,
                    "fours" => $scrs->fours,
                    "sixes" => $scrs->assets,
                    "total runs" =>$scrs->totruns

                    
                ],
                "bowler" =>[


                    'bowler' => $country,
                    "total_wickets"=> $bowlers->totalwc,
                    "economy" => $bowlers->ecrt,
                    "best bowling" => $bowlers->bb,
                    "hatricks" => $bowlers->hat,
                     "how wickets" => $bowlers->hw

                         
                ],
                "tournament" => $tours,
                
                "match_insghts" => 
                    
                    $value
                
                ,
            "awards" =>

                $value1


       

        
        ]);

          
            
        
        
            
                     
        
           
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


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        
        $app = Profile::find($id);


        $app->delete();

        
    }

    public function update(Request $request, $user_id)
    {

    
        $this->validate($request, [
            'batsman' => 'required',
            'bowler' => 'required',
            'about' => 'required',
            'wicketkeeper' => 'required',
            'allrounder' => 'required',
     ]);
   

  $profile =  Profile::where('user_id', $user_id)->first();

     $users = User::where('id', $user_id)->first();


     $profile->batsman = $request->input('batsman');
     $profile->bowler = $request->input('bowler');
     $profile->about = $request->input('about');
     $profile->zone = $request->input('zone');
     $profile->country = $request->input('country');
     $profile->city = $request->input('city');
     $profile->pincode = $request->input('pincode');
     $image = $request->avatar;

    if ($request->hasFile('avatar')) {

        
  File::delete(public_path($profile->avatar));


    $image = $request->avatar;
$image_new_name = time().$image->getClientOriginalName();

$image->move('upload', $image_new_name);
$profile->avatar = "upload/".$image_new_name;

}else{

$profile->avatar = $profile->avatar;

}
     $profile->dob = $request->input('dob');
    $profile->gender = $request->input('gender');
    $profile->wicketkeeper = $request->input('wicketkeeper');
     $profile->allrounder = $request->input('allrounder');
     $profile->user_id = Auth::user()->id;
     $profile->save();
     $users->fname = $request->fname;
     $users->lname = $request->lname;
     $users->save();

     $success = Auth::user()->fname . " your profile edited Successfully";
      return response()->json(['Success' => $success, 'img_url' => Auth::user()->profile->avatar]);

   
    }


public function checkref(Request $request){

if(Profile::where('refcode', '=', Input::get('ref'))->exists()){

return response()->json(['Success' => "Ref code found"]);


}else{

return response()->json(['Failed' => "Not found"]);

}

}

public function history(){

$hist = DB::table('credit_history')->where('user_id', '=', Auth::user()->id)->orderBy('created_at', 'asc')->get();

return response()->json($hist);

}


}






<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\User;
use App\Profile;
use Auth;
use Carbon\Carbon;
use Session;
use Hash;
use App\ChangePoints;
use DB;
use Illuminate\Support\Facades\Input;
use App\MatchIn;
use App\Scoresheet;
use App\Players;
use App\Tournament;
use Response;
use App\Team;
use App\Organize;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $val = Organize::all()->count();
        $play = Players::all()->count();
        $tour = Tournament::all()->count();
        $team = Team::all()->count();

        
        return view('home')->with('val', $val)->with('play', $play)->with('tour', $tour)->with('team', $team);
    }

  public function testpagi(){

  $user = User::where('id', '!=' , 0)->paginate(3);


  return response()->json([

       $user

    ]);

}

public function showprize(){

$val = ChangePoints::find(1);

return response()->json([
"user points" => Profile::where('user_id', '=', Auth::user()->id)->first()->points,
"price" => $val->prize
]);

}


public function dateshow(Request $request, $matchdate){
    $match = Organize::where('matchdate', $matchdate)->get();
    $matcha = Organize::where('matchdate','!=', $matchdate)->get();


    $data = array();
    $datas = array();

    foreach($match as $mas){
        $data[] = [
            "match_id" => $mas->id,
            "status" => 0,
               "teamname"        =>  $mas->oppo,
    
    "country" => $mas->country,
    
    "state" => $mas->state,
    
    "city" => $mas->city,
    "owner_id" => $mas->user_id,
        ];
    }


foreach($matcha as $fas){
    $datas[] = [
        "match_id" => $fas->id,
           "teamname"        =>  $fas->oppo,

"country" => $fas->country,

"state" => $fas->state,

"city" => $fas->city,
"owner_id" => $fas->user_id,
"status" => 1
    ];
}

return response()->json([
    "teams" => $data, $datas

]);


}


    public function detail(){


        $user = User::find($id)->first()->profile()->first();




        return response()->json(array('success' => [
            "id" => $user->id,
            'Batsman' =>  $user->batsman,
            'bowler' => $user->bowler,
            'about' => $user->about,
            'wk' => $user->wicketkeeper,
            'allrounder' => $user->allrounder
                    ]));



 


    }


    public function data(){
        $team = Team::all();
        return response()->json((array('Success' => $team)));

        
        
          





 


    }


    public function tour(){
  

        $team = Tournament::all();

        return Response::json(array('success' => $team));





}
    public function dashboard(){


        $valid = Carbon::now();

        $sheet = Scoresheet::where('live', '=', 1 )->take(5)->get();
$data = Organize::where('matchdate', '>', $valid)->take(4)->get();
$tour = Tournament::where('created_at', '>', $valid)->take(4)->get();
$scoresheet = array();


$org = array();

$tours = array();

foreach($sheet as $sheets){

    $scoresheet[] = [
        "id" => $sheets->id,
        "team1" => $sheets->team1,
        "team2" => $sheets->team2,
        "t1score" => $sheets->t1score,
        "t2team1" => $sheets->t2team1,
        "t1overs" => $sheets->t1overs,
        "t2overs" => $sheets->t2overs,
        "city" => $sheets->city,
        "city" => $sheets->city,
        ];

}

foreach($data as $orgs){
    $org[] = [

        "id" => $orgs->id,
         "team1" =>Team::where('id', '=', $orgs->whovswho)->first()->teamname,
        "team2" => Team::where('id', '=', $orgs->oppo)->first()->teamname,
        "venue" => $orgs->city,
        "date" => reset($orgs->created_at)
        
    ];






}

foreach($tour as $gain){
    $tours[] = [

        "id" => $gain->id,
        "name" => $gain->tourtype,
        "date" => $gain->created_at,
        "venue" => $gain->venue,
        "date" => reset($gain->created_at),
    ];
}



return response()->json([
    "live matches" => 
       $scoresheet
    ,

    "featured matches" => 
        $org
    ,
    "featured tournaments" =>
        $tours
    

]);



}

public function showusers(){

    $user = User::all();

$users = array();


foreach($user as $us){
    $app = "";
$valava = "";
    if(Profile::where('user_id', '=', $us->id)->exists()){
   $app = Profile::where('user_id', '=', $us->id)->first()->city . " " . Profile::where('user_id', '=', $us->id)->first()->country;
   $valava = Profile::where('user_id', '=', $us->id)->first()->avatar;    
}else{
$app ="no location";
$valava = null; 
   }



    $users[] = [
        'id' => $us->id,
        'name' => $us->fname ." ".$us->lname,
       'location' => $app ,
           'mailid' => $us->email,

        'avatar' => $valava

    ];
}

    return response()->json(
        $users
        
    );



}

public function checknum(){

$data = Input::get('email');
    if(User::where('phone', '=', Input::get('phone'))->count() > 0) {

         return response()->json([

             'Result' => 'Mobile number already exists'
         
             ]);

    }



else if(User::where('email', Input::get('email'))->exists() && $data  !== NULL ){



 return response()->json([

             'Result' => 'Email already exists'

             ]);



}

}

public function allusers(){
    $user = User::orderBy('created_at', 'desc')->where('role_id', '=', 1)->get();


    return view('userdata')->with('user', $user);
}


public function blocked($id){
    $user = User::find($id);



$user->role_id = 4;

$user->save();

Session::flash('success', 'User blocked');

return redirect()->back();
}
public function showpoints(){
    $change = ChangePoints::find(1);
    

    return view('pointsshow')->with('change', $change);
    
  
    }

public function changenumber(Request $request){

$change = ChangePoints::find(1);

$change->points = $request->points;
$change->rewards = $request->rewards;
$change->minus = $request->minus;
$change->prize = $request->prize;


$change->save();

Session::flash('success', 'Reward points changed');

return redirect()->back();
}



public function showmat(){
    $team = Team::all();

    return view('showmat')->with('team', $team);
}

public function showtournaments(){
    $tour = Tournament::all();

    return view('showtr')->with('tour', $tour);
}
public function showresults(){
    $org = Organize::all();

    return view('showorg')->with('org', $org);
}


public function vwpro($id){

    $prof = Profile::where('user_id' ,$id)->first();

    return view('vwprof')->with('prof', $prof);



}


public function upcoming(){
    $data = Carbon::now();
    $upcmng = Organize::where('matchdate', '>', $data)->get();

    return view('upcmng')->with('upcmng', $upcmng);

}

public function makelive($id){
    $match = Organize::find($id);

    $match->live = 1;

    $match->save();
$matchid = $match->id;
$matchteams = Team::where('id', $match->whovswho)->first();
$matchoppo = Team::where('id', $match->oppo)->first();


$plays  = Players::where('id', $match->whovswho)->get();
$playrs  = Players::where('id', $match->oppo)->get();


$players = array();

$players2 = array();

foreach($plays as $matches){
    $players[] = [
     'id' => $matches->id,

        'name' => $matches->players,
    ];
    
}

foreach($playrs as $matchs){
    $players2[] = [
     'id' => $matchs->id,
        'name' => $matchs->players,
    ];
    
}

    return response()->json([


        'id' => $matchid,
         'success' =>[
           'match_date' => $match->matchdate,
        'Team 1 name'  => $matchteams->teamname,
        
    
        "Team 2 name" => $match->teamname,

        'Team 1 players' =>  $players
        ,
        'Team 2 players' => $playrs,
        
        ]
    ]);
}

public function addplayer(Request $request,$id){
   $exists =  DB::table('players_team')->where('team_id', '=', $id)->where('players_id', '=', $request->players_id)->first();
    if($exists){

        return response()->json([
            'Failed' => 'player already added'
            ]);
    
    }else{
           DB::table('players_team')->insert(
            array('team_id' => $request->id,
                  'players_id' => $request->players_id,
               )
        );
    
        return response()->json([
        'Success' => 'player added successfully'
        ]);
        }
    }



public function seebusy(Request $request,$matchdate, $oppo){
  
if( Organize::where('matchdate', $matchdate)->where('oppo', '=', $oppo)->exists() || Organize::where('matchdate', $matchdate)->where('whovswho', '=', $oppo)->exists() )
{



 return response()->json([
         "Failed" => "team is busy"
   ]);

}


else {


 return response()->json([
         "Success" => "Team is available"
   ]);


}




}

public function showdetailmat($matchdate){

    $val = Carbon::now();
    
    
    
    $datas = Organize::where('matchdate', '>=', $matchdate)->where('live', '=', 0)->where('agree', '=', 1)->get();
 
   


   

    $datasr = Organize::where('live', '=', 1)->get();

    $datasrc = Organize::where('matchdate', '<=', $matchdate)->where('live', '=', 0)->where('agree', '=', 1)->get();
     




    
    $vals = array();
    
    
    $lv = array();
    $lsv = array();


    
    
    foreach($datas as $asv){
    
        $vals[] = [
    
    
            "matchId" => $asv->id,
            "team1 id" => $asv->whovswho,
            "team2 id" => $asv->oppo,
       "team1 name" => Team::where('id' , '=', $asv->whovswho)->first()->teamname,
              "team2 name" => Team::where('id' , '=', $asv->oppo)->first()->teamname,
              "date" => $asv->matchdate,
            "venue" => $asv->country. " " . $asv->state . " " . $asv->city
    





    ];
}

foreach($datasr as $lvs){

    $lv[] =
    
    
    [

        "matchId" => $lvs->id,
        "team1 id" => $lvs->whovswho,
        "team2 id" => $lvs->oppo,
         "team1 name" => Team::where('id' , '=', $lvs->whovswho)->first()->teamname,
         "team2 name" => Team::where('id' , '=', $lvs->oppo)->first()->teamname,
              "date" => $lvs->matchdate,
           
         "venue" => $lvs->country. " " . $lvs->state . " " . $lvs->city

    ];


}



foreach($datasrc as $lvsw){

if(MatchIn::where('team', '=', $lvsw->whovswho)->where('vsteam', '=', $lvsw->oppo)->where('matchdate', '=', $lvsw->matchdate)->exists()){

$result =  MatchIn::where('team', '=', $lvsw->whovswho)->where('vsteam', '=', $lvsw->oppo)->where('matchdate', '=', $lvsw->matchdate)->first()->result;



$won = Team::where('id', '=', $result)->first()->id;

}

else{

$won = "No result";

}



    $lsv[] = [


        "matchId" => $lvsw->id,
        "team1 id" => $lvsw->whovswho,
        "team2 id" => $lvsw->oppo,
 "team1 name" => Team::where('id' , '=', $lvsw->whovswho)->first()->teamname,
         "team2 name" => Team::where('id' , '=', $lvsw->oppo)->first()->teamname,
            "date" => $lvsw->matchdate,
            "result" => $won,
  "venue" => $lvsw->country . " " . $lvs->state . " " . $lvs->city






    ];


}





return response()->json([
    "Upcoming matches" => $vals,
    "live matches" => $lv,
    "completed matches" => $lsv

]);

}


public function mymat($id, $matchdate){
    $user = Organize::where('user_id', '=', Auth::user()->id)->where('matchdate', '>=', $matchdate)->where('live', '=', 0)->where('agree', '=', 1)->get();

    $usesr = Organize::where('user_id', '=', Auth::user()->id)->where('live', '=', 1)->get();
    $usebr = Organize::where('user_id', '=', Auth::user()->id)->where('matchdate', '<=', $matchdate)->where('live' ,'=', 0)->where('agree', '=', 1)->get();


    $lsv = array();

    $lsvw = array();
    $lssv = array();


foreach($user as $lvsw){


    $lsv[] = [


        "matchId" => $lvsw->id,
         "team1 id" => $lvsw->whovswho,
        "team2 id" => $lvsw->oppo,
         "team1 name" => Team::where('id' , '=', $lvsw->whovswho)->first()->teamname,
         "team2 name" => Team::where('id' , '=', $lvsw->oppo)->first()->teamname,
          "date" => $lvsw->matchdate,


        "venue" => $lvsw->country . " " . $lvsw->state . " " . $lvsw->city






    ];


}
foreach($usebr as $sd){

if(MatchIn::where('user_id', '=', Auth::user()->id)->where('team_id', '=', $sd->whovswho)->where('vsteam', '=', $sd->oppo)->where('matchdate', '=', $sd->matchdate)->exists()){

$mys = MatchIn::where('user_id', '=', Auth::user()->id)->where('team_id', '=', $sd->whovswho)->where('vsteam', '=', $sd->oppo)->where('matchdate', '=', $sd->matchdate)->first()->yourscore;

$myw = MatchIn::where('user_id', '=', Auth::user()->id)->where('team_id', '=', $sd->whovswho)->where('vsteam', '=', $sd->oppo)->where('matchdate', '=', $sd->matchdate)->first()->yourwicket;

$result =  MatchIn::where('user_id', '=', Auth::user()->id)->where('team_id', '=', $sd->whovswho)->where('vsteam', '=', $sd->oppo)->where('matchdate', '=', $sd->matchdate)->first()->result;


$won = Team::where('id','=', $result)->first()->teamname;
}else{

$mys = "Didn't bat";

$myw = "Didn't Bowl";
$won = "unknown";
}





    $lsvw[] = [


        "matchId" => $sd->id,
         "team1 id" => $sd->whovswho,
        "team2 id" => $sd->oppo,
         "team1 name" => Team::where('id' , '=', $sd->whovswho)->first()->teamname,
         "team2 name" => Team::where('id' , '=', $sd->oppo)->first()->teamname,
          "date" => $sd->matchdate,
          "myscore" =>$mys,
         "mywickets" =>$myw,
        "venue" => $sd->country . " " . $sd->state . " " . $sd->city,
        "result" => $won





    ];

   
}

foreach($usesr as $asp){


    $lssv[] = [


        "matchId" => $asp->id,
         "team1 id" => $asp->whovswho,
        "team2 id" => $asp->oppo,
         "team1 name" => Team::where('id' , '=', $asp->whovswho)->first()->teamname,
         "team2 name" => Team::where('id' , '=', $asp->oppo)->first()->teamname,
          "date" => $asp->matchdate,
        "venue" => $asp->country . " " . $asp->state . " " . $asp->city






    ];


}


return response()->json([
    "Upcoming matches" => $lsv,
    "live matches" => $lssv,
    "completed matches" => $lsvw

]);

}




public function load($id){

   
    $player = Team::find($id);

    
$play = DB::table('players_team')->where('team_id', $id)->get();




$data =  array();






 

foreach($play as $plays){





  $data[] =  [

"name" =>  User::where('id', $plays->players_id)->first()->fname . " " .User::where('id', $plays->players_id)->first()->lname,
"details" =>  Profile::where('user_id',  $plays->players_id)->get() 

];    

}








  

return response()->json([
"id" => $id,
  "teamname" => $player->teamname,     
  "players" =>      $data
          


    
]);




}


public function matchday($id){

   $match = Organize::find($id);

    $player = Team::where('id', '=', $match->whovswho)->first();

    
$play = DB::table('players_team')->where('team_id', $match->whovswho)->get();

$teamtwo = Team::where('id', '=', $match->oppo)->first();

    
$playtwo = DB::table('players_team')->where('team_id', '=' ,$match->oppo)->get();


$data =  array();

$vata =  array();





 

foreach($play as $plays){





  $data[] =  [

"name" =>  User::where('id', $plays->players_id)->first()->fname . " " .User::where('id', $plays->players_id)->first()->lname,
"number" => User::where('id', $plays->players_id)->first()->phone,
"details" =>  Profile::where('user_id',  $plays->players_id)->get() 

];    

}

foreach($playtwo as $two){





    $vata[] =  [
  
  "name" =>  User::where('id', $two->players_id)->first()->fname . " " .User::where('id', $two->players_id)->first()->lname,
 "number" => User::where('id', $two->players_id)->first()->phone,


  "details" =>  Profile::where('user_id',  $two->players_id)->get() 
  
  ];    
  
  }

$scorername = "";
if(!($match->scorer)){
    $scorername = "yet to choose";

}else{
    $scorername = User::where('id', '=', $match->scorer)->first()->fname . " " . User::where('id', '=', $match->scorer)->first()->lname ;

}





  

return response()->json([
"id" => $match->id,
"match date" => $match->matchdate,
"Place" => $match->country . " " . $match->state . " " . $match->city,
"scorer" => $match->scorer,



"scorer name" => $scorername ,

"organizer" => $match->user_id,
"overs" => $match->overs,

    
"Team 1" => ["id" => $player->id,
  "teamname" => $player->teamname,     
  "players" =>      $data
],
"team 2 " => [
    "id" => $teamtwo->id,
  "teamname" => $teamtwo->teamname,     
  "players" =>      $vata
]
    
]);



}




public function updatescorer(Request $request, $id){
    $match = Organize::find($id);
$val = ChangePoints::find(1);


if(Profile::where('user_id', '=',$match->user_id)->first()->points < $val->rewards){

return response()->json([
        "Failed" => "You don't have enough points, please buy using your paytm account"
    ]);


}else{

    $match->scorer =  $request->scorer;



$owner = $match->user_id;

$deduct = Profile::where('user_id', '=', $owner)->first();

$deduct->points = $deduct->points - $val->minus;

$deduct->save();

    $match->save();

DB::table('credit_history')->insert([

'user_id' => $owner,
'credit' => $val->minus,
'reason' => 'bought scoresheet',
'value' => $val->minus." points reduced"

]);



return response()->json([
        "Success" => "Scorer fixed, you can start the match now!!"
    ]);
}

}

public function forgetpass(Request $request, $phone){



$change = User::where('phone', $phone)->first();




$change->password = Hash::make($request->password);


$change->save();

return response()->json([
        "Success" => "Password successfully changed!"
    ]);



}


public function chck($phone){

if(User::where('phone', $phone)->exists()){


return response()->json([
        "Success" => "number found!"
    ]);



}else{


return response()->json([
        "Failed" => "Sorry account with that number not found"
    ]);



}


}

public function showsingleuser($id){


return response()->json([

"user" => Profile::where('user_id' , $id)->first()

]);


}





public function scoredata(){

    




}


public function checkwithdate(Request $request){


    $data =  $request->matchdate;
    $vr = Organize::where('matchdate', '=', $data)->paginate(10);
  if($request->has('city')){

    $vr = Organize::where('matchdate', '=', $data)->where('city', '=', $request->city)->paginate(10);

  }

    if($request->has('oppo')){
      $vr = Organize::where('whovswho', '=', $request->oppo)->orWhere('oppo', '=', $request->oppo)->where('matchdate', '=', $$request->matchdate)->paginate(10);
   
      

      

    }
    if($request->has('oppo') && $request->has('matchdate')){
        $vr = Organize::where('whovswho', '=', $request->oppo)->orWhere('oppo', '=', $request->oppo)->where('matchdate', '=', $request->matchdate)->paginate(10);
     
        
  
        
  
      }

   if($request->has('oppo') && $request->has('matchdate') && $request->has('city') ){
        $vr = Organize::where('whovswho', '=', $request->oppo)->orWhere('oppo', '=', $request->oppo)->where('matchdate', '=', $request->matchdate)->where('city', '=', $request->city)->paginate(10);
     
        
  
        
  
      }

    $vrs = array();
    $last = array();

    foreach($vr as $vrsv){
    
        $vrs[] = [
            "matchId" => $vrsv->id,
            "team1 id" => $vrsv->whovswho,
            "team2 id" => $vrsv->oppo,
       "team1 name" => Team::where('id' , '=', $vrsv->whovswho)->first()->teamname,
              "team2 name" => Team::where('id' , '=', $vrsv->oppo)->first()->teamname,
              "date" => $vrsv->matchdate,
            "venue" => $vrsv->country. " " . $vrsv->state . " " . $vrsv->city
    

    ];
    
}    



return response()->json([
    "matches" => $vrs
]);


}


public function checkwithteam(Request $request){

$super = Team::where('teamname', 'like','%'. $request->teamname. '%')->first();

$vrv = Organize::where('whovswho', '=', $super->id)->where('matchdate', '=', $request->matchdate)->orWhere('oppo', '=', $super->id)->where('matchdate', '=', $request->matchdate)->paginate(2);





      $datas =  array();

    foreach($vrv as $team){
    
        $datas[] = [
            "matchId" => $team->id,
            "team1 id" => $team->whovswho,
            "team2 id" => $team->oppo,
            "team1 name" => Team::where('id' , '=', $team->whovswho)->first()->teamname,
            "team2 name" => Team::where('id' , '=', $team->oppo)->first()->teamname,
             "date" => $team->matchdate,
             "venue" => $team->country. " " . $team->state . " " . $team->city
 
    ];
    }

    return response()->json([
    "matches" => $datas
    ]);

}

public function savepayment(Request $request){

DB::table('payments')->insert([

'user_id' => $request->user_id,
'status' => $request->status,
'orderid' => $request->orderid, 
'amount' => $request->amount,
'date' => $request->date,
'currency' => $request->currency,
'mode' => $request->mode
]);

$chpoints = Profile::where('user_id', '=', $request->user_id)->first();

$chpoints->points = $chpoints->points +  $request->credit;




DB::table('credit_history')->insert([

'user_id' => $chpoints->user_id,
'credit' => $request->credit,
'reason' => 'bought points through paytm',
'value' => $request->credit." points incremented"

]);


$chpoints->save();


return response()->json([

"Success" => "payment successful"

]);

}

public function removeplayer($team_id, $players_id){

DB::table('players_team')->where('team_id', '=',$team_id)->where('players_id', '=', $players_id)->delete();


return response()->json([

"Success" => "player removed successfully"

]);

}

public function agree($id){

$hello = Organize::where('id', '=',$id)->first();

$hello->agree = 1;

$hello->save();

return response()->json([

"Success" => "Match accepted"

]);

}


public function mknlv($id){


$app = Organize::find($id);

$app->live = 0;
$app->save();

return response()->json([

"Success" => "Match updated"

]);


}



}









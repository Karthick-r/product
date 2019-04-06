<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tournament;
use Auth;
use DB;
use App\User;
use Carbon\Carbon;
use App\Group;
use App\Team;
use App\Score;
use App\Scoresheet;
use App\Organize;

class TournamentController extends Controller
{
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
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
          
      'noofteams' => 'required',
            'tourtype' => 'required'

        ]);

$tour = new Tournament;

$tour->user_id = Auth::user()->id;
$tour->noofteams = $request->noofteams;
$tour->loc = $request->loc;
$tour->name = $request->name;

$tour->startingdate = $request->startingdate;

$tour->endingdate = $request->endingdate;
$tour->noofgroups = $request->noofgroups;
$tour->startingdate = $request->startingdate;
$tour->tourtype = $request->tourtype;
$tour->currency = $request->currency;
$tour->tourentry = $request->tourentry;
$tour->amount = $request->amount;
$tour->lastdayforpay = $request->lastdayforpay;
$tour->overs = $request->overs;
$tour->dresscode = $request->dresscode;
$tour->uniform = $request->uniform;


$tour->save();

$data = $request->teams;

$inci = 0;

for($i=1; $i <= sizeof($data); $i++){
     DB::table('team_tournament')->insert([ 
        "tournament_id" => $tour->id,
        "team_id" => $data[$inci]["team_id"],
        "created_at" => Carbon::now()
]);

$inci++;
}


return response()->json([
'Success' => 'Tournament Created SuccessFully',
"tournament_id" => $tour->id,
$data
]);



        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
     
if($tour = Tournament::find($id)->where('user_id', Auth::user()->id)->get()){



   $noofteams = $tour->noofteams;
   $tourtype = $tour->tourtype;

   $tourentry = $tour->tourentry;
   
   $currency = $tour->currency;


   $amount = $tour->amount;
$lastdayforpay = $tour->lastdayforpay;

$overs = $tour->overs;


$dresscode = $tour->dresscode;

$uniform = $tour->uniform;


return response()->json([

"user" => Auth::user()->fname,
"number of teams"  => $noofteams,
"Tournament type"  => $tourtype,
"Entry fee" => $tourentry,
"currency" => $currency,
"amount" => $amount,
"lastdayforpay" => $lastdayforpay,
 "overs" => $overs,
 "dresscode" => $dresscode,
 "uniform" => $uniform
    ]);
   



}
else{
    return response()->json([ 'Error' => 'Not your data' ], 200);


}
    }


      public function thing($tournament_id, $team_id){


    $app =  DB::table('team_tournament')->where('tournament_id', '=', $tournament_id)->where('team_id', '=', $team_id)->update(['accept' => 1]);
     
    


   

    return response()->json([
     'Success' => "Team Successfully Accepted"
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
    public function update(Request $request, $id)
    {
        $this->validate($request, [
          
            'user_id' => 'required',
            'noofteams' => 'required',
            'tourtype' => 'required',
            'tourentry' => 'required',
            'currency' => 'required|integer',

            'amount' => 'required',
            'lastdayforpay' => 'required',
            'overs' => 'required',
            'dresscode' => 'required',
            'uniform' => 'required',


        ]);

$tour = Tournament::find($id);

$tour->user_id = Auth::user()->id;
$tour->noofteams = $request->noofteams;
$tour->tourtype = $request->tourtype;
$tour->currency = $request->currency;
$tour->tourentry = $request->tourentry;
$tour->amount = $request->amount;
$tour->lastdayforpay = $request->lastdayforpay;
$tour->overs = $request->overs;
$tour->dresscode = $request->dresscode;
$tour->uniform = $request->uniform;


$tour->save();

return response()->json([
'Success' => 'Tournament updated SuccessFully'
]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function group(Request $request)
    {
        $gru = new Group;

       $gru->tournament_id = $request->tournament_id;
       $gru->groupname = $request->groupname;


       $gru->save();

       return response()->json([
          "Success" => 'Group created',
          'id' => $gru->id
       ]);

    }

   public function grs(Request $request, $id)
    {
        $gru = Group::find($id);

       $gru->tournament_id = $request->tournament_id;
       $gru->groupname = $request->groupname;


       $gru->save();

       return response()->json([
          "Success" => 'Group edited',
          'id' => $gru->id
       ]);

    }


        public function list($id)
    {
      
        $app = DB::table('team_tournament')->where('accept', '=', 1)->where('tournament_id', '=', $id)->get();


        $teams = array();


        foreach($app as $apps){

              $teams[] = [
                
                "id" =>Team::where('id', '=', $apps->team_id)->first()->id,
                "user_id" =>Team::where('id', '=', $apps->team_id)->first()->user_id,
                "teamname" =>Team::where('id', '=', $apps->team_id)->first()->teamname,
                "country" =>Team::where('id', '=', $apps->team_id)->first()->country,
                "state" =>Team::where('id', '=', $apps->team_id)->first()->state,
                "city" =>Team::where('id', '=', $apps->team_id)->first()->city,


            ];
           
        }


       return response()->json(
          $teams
       );

    }



  public function groupteam(Request $request)
    { 

        $app = $request->teams;

        $incre = 0;
      
        for($i = 1; $i <= sizeof($app); $i++){
            DB::table('group__team')->insert([
               "tournament_id" => $app[$incre]['tournament_id'],
               "team_id" => $app[$incre]['team_id'],
               "group_id" => $app[$incre]['group_id'],
               "created_at" => Carbon::now()

            ]);
             

            $incre++;
        }
            




       return response()->json([
       "Success" => "Teams added in group"                               
    ]);

    }

  public function listtour($id)
    {

        $app = Tournament::where('id', '=', $id)->first();

        $user = User::where('id', '=', $app->user_id)->first();

        $success["id"] = $app->id;
        $success["user_id"] = $app->user_id;
        $success["Owner_name"] = $user->fname . " " . $user->lname;

        $success["name"] = $app->name;
        $success["startingdate"] = $app->startingdate;
        $success["endingdate"] = $app->endingdate;
        $success["noofgroups"] = $app->noofgroups;
        $success["loc"] = $app->loc;
        $success["noofteams"] = $app->noofteams;
        $success["tourtype"] = $app->tourtype;
        $success["currency"] = $app->currency;
        $success["amount"] = $app->amount;
        $success["lastdayforpay"] = $app->lastdayforpay;
        $success["overs"] = $app->overs;
        $success["dresscode"] = $app->dresscode;
        $success["uniform"] = $app->uniform;

        return response()->json(
          $success
        
        );

    }

 public function listgroupstour($id){
   
     $grp = Group::where('tournament_id', '=', $id)->get();
  

$data = array();

foreach($grp as $group){

$data[] = [
"id" => $group->id,
"tournament_id" => $group->tournament_id,
"groupname" => $group->groupname,
"teams" => DB::table('group__team')->where('group_id', '=', $group->id)->get()

];
}
     


 

        return response()->json([
             "groups" => $data,
           
        ]);

    }


     public function showalltour(){
       
$val = Tournament::where('user_id', "!=", Auth::user()->id)->orderBy('created_at', 'desc')->paginate(10);


        $success = array();

        foreach ($val as $app) {

            $success[] = [
                "id" => $app->id,
                "user_id" => $app->user_id,
                "Owner_name" => User::where('id', '=', $app->user_id)->first()->fname . " " . User::where('id', '=', $app->user_id)->first()->lname,

                "name" => $app->name,
                "startingdate" => $app->startingdate,
                "endingdate" => $app->endingdate,
                "noofgroups" => $app->noofgroups,
                "loc" => $app->loc,
                "noofteams" => $app->noofteams,
                "tourtype" => $app->tourtype,
                "currency" => $app->currency,
                "amount" => $app->amount,
                "lastdayforpay" => $app->lastdayforpay,
                "overs" => $app->overs,
                "dresscode" => $app->dresscode,
                "uniform" => $app->uniform
            ];
        }


        return response()->json(

            $success
        );


    }
    public function showmytours()
    {
        $val = Tournament::where('user_id', "=", Auth::user()->id)->paginate(10);


        $success = array();

        foreach ($val as $app) {

            $success[] = [
                "id" => $app->id,
                "user_id" => $app->user_id,
                "Owner_name" => User::where('id', '=', $app->user_id)->first()->fname . " " . User::where('id', '=', $app->user_id)->first()->lname,

                "name" => $app->name,
                "startingdate" => $app->startingdate,
                "endingdate" => $app->endingdate,
                "noofgroups" => $app->noofgroups,
                "loc" => $app->loc,
                "noofteams" => $app->noofteams,
                "tourtype" => $app->tourtype,
                "currency" => $app->currency,
                "amount" => $app->amount,
                "lastdayforpay" => $app->lastdayforpay,
                "overs" => $app->overs,
                "dresscode" => $app->dresscode,
                "uniform" => $app->uniform
            ];
        }


        return response()->json(

            $success
        );

    }


 public function updategroup(Request $request, $id){

        DB::table('group__team')->where('group_id', '=', $id)->delete();



        $app = $request->teams;

        $incre = 0;

        for ($i = 1; $i <= sizeof($app); $i++) {
            DB::table('group__team')->insert([
                "tournament_id" => $app[$incre]['tournament_id'],
                "team_id" => $app[$incre]['team_id'],
                "group_id" => $app[$incre]['group_id'],
                "created_at" => Carbon::now()

            ]);

            $incre++;
        }
    
     return response()->json([
          "Success" => 'Success'
]);

}



    public function something(){

        return response()->json([
  "Works" => "do you know something? This is a great app and developed by vishgyana technoligies"
     ]   );

    }



   public function winnerteam($id){
       $app = Scoresheet::where('tournament', '=', $id)->get();
   

       $fresh = array();


       foreach($app as $apps){ 

        $fresh[] = Team::where('id', '=', $apps->winner)->first();


       }



       return response()->json(
      $fresh
       );

  


   }


public function getmatches($id){
    $app = Scoresheet::where('tournament', '=', $id)->get();


    $fresh = array();


    foreach($app as $apps){ 

     $fresh[] = Organize::where('id', '=', $apps->organize_id)->first();


    }



    return response()->json(
   $fresh
    );




}

public function gettourmatches($id){

    $app = Organize::where('tournament_id', '=', $id)->orderBy('created_at', 'asc')->get();
    $fresh = array();

     

  foreach($app as $apps){ 
if(Scoresheet::where('organize_id', '=', $apps->id)->exists()){

$win = Scoresheet::where('organize_id', '=', $apps->id)->first()->winner;

}   else{

$win  = "Not announced";

}


   $fresh[] = [
       "id" => $apps->id,
       "owner" => User::where('id', '=', $apps->user_id)->first()->fname . " " . User::where('id', '=', $apps->user_id)->first()->lname,
       "date" => $apps->matchdate,
       "scorer" => "Scorer will be decided on the match day",
       "Team 1" => $apps->whovswho,
       "Team 2" => $apps->oppo,
      "Team 1 name" => Team::where('id', '=', $apps->whovswho)->first()->teamname,
      "Team 2 name" => Team::where('id', '=', $apps->oppo)->first()->teamname,
        
     "winner"=> $win,
      "group" => '',
       "venue" => $apps->city . " " .  $apps->state . " " .  $apps->country
      ];
    }


    return response()->json($fresh);

}




}

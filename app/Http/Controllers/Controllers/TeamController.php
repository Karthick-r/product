<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

Use App\Team;
use Auth;

use App\Players;
use File;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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



$team = new Team;

$team->user_id = Auth::user()->id;
$team->teamname =  $request->teamname;
$team->country = $request->country;
$team->state =  $request->state;
$team->city = $request->city;
$team->pin =  $request->pin;
$team->tournament_id = $request->tournament_id;
$team->players = "players table";


if($request->hasFile('image')){   
  $image = $request->image;
$newname = time().$image->getClientOriginalName();

$image->move('upload',$newname);

$team->image = "upload/".$newname;
}
else{

$team->image = null;

}

$team->save();
   
    
      

        return response()->json([
            'id' => $team->id,
            'Success' => 'Your Team Created'
        ]);
   
   
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($user_id)
    {

   $team = Team::where('user_id' ,$user_id)->get();
  

    $teamss = Team::with('user')->where('user_id', '!=', Auth::user()->id)->get();
 $val = array();

    $ds = array();
    foreach($team as $tems){
        $val[] =[
            "id" => $tems->id,
            "owner" => Auth::user()->fname,
"owner_id" =>  Auth::user()->id,
            "teamname" => $tems->teamname,
    "country" => $tems->country,
    "state" => $tems->state,
    "city" => $tems->city,
    "pin" => $tems->pin,
      "image" => $tems->image
  ];
    }

    foreach($teamss as $teams){
        $ds[] =[

   
         'id' => $teams->id,
'owner_id' => $teams->user->id,
               "owner" => $teams->user->fname,

            "teamname" => $teams->teamname,
    "country" => $teams->country,
    "state" => $teams->state,
    "city" => $teams->city,
    "pin" => $teams->pin,
 "image" => $teams->image
        ];
    }

return response()->json([
"my team" => $val,

"other teams" => 
    $ds

], 200)
;











    





    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request,$id)
    {
        $team = Team::find($id);
       
$up = $team->image;
 
        if($team->user_id !== Auth::user()->id){
            return response()->json([
                'Failed' => 'Sorry, You are not allowed'
            ]); 
        }

        else{

           if($request->hasFile('image')){   
 
 

  $image = $request->image;
$newname = time().$image->getClientOriginalName();

$image->move('upload',$newname);

$up = "upload/".$newname;
}else{

$up = $up;

}

        
        $team->teamname = $request->teamname;

        $team->country = $request->country;
        $team->state = $request->state;
        $team->city = $request->city;
        $team->pin = $request->pin;
        $team->players = $request->players;
        $team->image = $up;
        $team->save();

        return response()->json([
            'Success' => 'Your Data updated'
        ]); 
    }
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
        //
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
}


<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Scoresheet;
use App\ScoreTeamOne;
use Auth;
use DB;
use App\MatchIn;
use Carbon\Carbon;
use App\Score;
use App\Bowler;
class ScoresheetController extends Controller
{

    public function __construct()
    {
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $sheet =  new Scoresheet;


        $sheet->organize_id = $request->organize_id;
        $sheet->date = $request->date;

        $sheet->time = $request->time;

        $sheet->team1 = $request->team1;
        $sheet->team2 = $request->team2;
        $sheet->t1score = $request->t1score;
        $sheet->t2team1 = $request->t2team1;
        $sheet->t1overs = $request->t1overs;
        $sheet->t2overs = $request->t2overs;
        $sheet->city = $request->city;
        $sheet->tournament = $request->tournament;
        $sheet->tosswon = $request->tosswon;
        $sheet->decision = $request->decision;
        $sheet->scorer = $request->scorer;
        $sheet->winner = $request->winner;
        $sheet->inningfirst = $request->inningfirst;
        $sheet->second = $request->second;
        $sheet->t1wickets = $request->t1wickets;
        $sheet->t2wickets = $request->t2wickets;


        $sheet->totalruns = $request->totalruns;
        $sheet->live = 0;


        $sheet->save();





   $data = $request->batsman;
      $inci = 0;
      for($i=1; $i <= sizeof($data); $i++){



        DB::table('score_team_ones')->insert([ 
            "scoresheet_id" => $sheet->id,
            'organize_id' => $data[$inci]['organize_id'],
            'team_id' => $data[$inci]['team_id'],
            'user_id' => $data[$inci]['user_id'],
            'score' => $data[$inci]['score'],
            'outby' => $data[$inci]['outby'],
            'strikerate' => $data[$inci]['strikerate'],
            'ballfaced' => $data[$inci]['ballfaced'],
            'wickettype' => $data[$inci]['wickettype'],
            'fours' => $data[$inci]['fours'],
            'sixes' => $data[$inci]['sixes'],
            'caughtby' => $data[$inci]['caughtby'],
            'created_at' => Carbon::now()

]
);

$app = Score::where('user_id', '=', $data[$inci]['user_id'])->first();

$fourdata = $app->fours;


if($data[$inci]['score'] > $app->highscore){
    $app->highscore = $data[$inci]['score'];
}
else{

    $app->highscore = $app->highscore;

}

$full = $data[$inci]['ballfaced'] * 100;
$fullb = $app->ballsfaced + $full;


if($app->totruns == 0 && $data[$inci]['score'] == 0){

$app->avgst = 0;

}

else if($fullb == 0){

$app->avgst = $app->avgst;
}
else{

$app->avgst =  $app->totruns + $data[$inci]['score'] / $fullb ;
}



if($data[$inci]['score'] >= 100){
    $app->century = $app->century + 1;
}

$app->fours = $fourdata + $data[$inci]['fours'];

if($data[$inci]['score'] >= 50 && $data[$inci]['score'] < 100 ){
    $app->fifty = $app->fifty + 1;
}

$app->assets = $app->assets + $data[$inci]['sixes'];
$app->totruns = $app->totruns + $data[$inci]['score'];
$app->ballsfaced = $app->ballsfaced + $data[$inci]['ballfaced'];

$app->save();

$mti = new MatchIn;

$mti->user_id = $data[$inci]['user_id'];

$mti->oranize_id = $data[$inci]['organize_id'];
$mti->team_id = $data[$inci]['team_id'];
$mti->vsteam = $request->team2;
$mti->teamsc =  $request->t1score;
$mti->yourscore = $data[$inci]['score'];
$mti->comsc =  $request->t2team1;

$mti->result =  $request->winner;
$mti->location  = $request->city;

$mti->matchdate = $request->date;

$mti->save();


$inci++;
}

$vala = 0;

        $vata = $request->bowler;
  for($j=1; $j <= sizeof($vata); $j++){
    DB::table('bowlers_team')->insert([ 
        "scoresheet_id" => $sheet->id,
        'team_id' => $vata[$vala]['team_id'],
        'organize_id' => $vata[$vala]['organize_id'],
        'user_id' => $vata[$vala]['user_id'],
        'overs' => $vata[$vala]['overs'],
        'wickets' => $vata[$vala]['wickets'],
        'economy' => $vata[$vala]['economy'],
        'maiden' => $vata[$vala]['maiden'],
        'runs' => $vata[$vala]['runs'],
        'created_at' => Carbon::now()


]
);

$bowd = Bowler::where('user_id', '=', $vata[$vala]['user_id'])->first();

$bowd->totalwc = $bowd->totalwc + $vata[$vala]['wickets'];



$bowd->ecrt = $vata[$vala]['economy'] ;
if($vata[$vala]['wickets'] > $bowd->bb){
    $bowd->bb = $vata[$vala]['wickets'] ;

}
$bowd->hat = $bowd->hat + $vata[$vala]['hatrick'] ;
$bowd->maiden = $bowd->maiden + $vata[$vala]['maiden']  ;
$bowd->save();

$vala++;
}



    return response()->json([
        "Success" => "Scoresheet"
     ]);


}

    public function finished($id)
    {
        
        $sheet = Scoresheet::find($id);

       $sheet->live = 0;
        $sheet->save();


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
         
    
  

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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




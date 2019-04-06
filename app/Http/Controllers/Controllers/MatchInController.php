<?php

namespace App\Http\Controllers;
use Auth;
use App\MatchIn;
use Illuminate\Http\Request;

class MatchInController extends Controller
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
     

        MatchIn::create([
            'user_id' => Auth::user()->id,
               'team' => $request->team,
               'vsteam' => $request->vsteam,
               'teamsc' => $request->teamsc,
               'yourscore' => $request->yourscore,
               'yourwicket' => $request->yourwicket,
               'comsc' => $request->comsc,
               'result' => $request->result,
               'location' => $request->location,


               
        ]);
        return response()->json([
            'Success' => 'Match insight data updated'
        ]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
       if($ms =MatchIn::find($id)->where('user_id', '=', Auth::user()->id)->first()){
            
        $team = $ms->team;
        $vsteam = $ms->vsteam;
        $teamsc = $ms->teamsc;
        $yourscore = $ms->yourscore;
        $yourwicket = $ms->yourwicket;
        $comsc = $ms->comsc;
        $result = $ms->result;
        $location = $ms->location;
       
        

       return response()->json([
        "user_id" => Auth::user()->id,
        "tournament" => $tour,
        "year" => $year,
        "team" => $team,
        "versus" => $vsteam,
        "teamscore" => $teamsc,
        "your score" => $yourscore,
        "Your Wicket" => $yourwicket,
        "opposite team score" => $comsc,
        "result" => $result,
        "location" => $location 
       ]);
       }
       else{
        return response()->json([
           
            "Failed" => "How do you think you can access this?"
        
            ]);


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
        if($ms =MatchIn::find($id)->where('user_id', '=', Auth::user()->id)->first()){

     

            $ms->team  = $request->team; 
            $ms->vsteam  = $request->vsteam;
            $ms->teamsc  = $request->teamsc;
            $ms->yourscore  = $request->yourscore;
            $ms->yourwicket  = $request->yourwicket;
            $ms->comsc  = $request->comsc;
            $ms->result  = $request->result;
            $ms->location  = $request->location;

            $ms->save();

   return response()->json([
       "success" => 'Match insights Updated Successfully!!'
   ]);


    }

    else{
        return response()->json([
            "Failed" => "How could you do that?"
        ]);
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
        //
    }
}



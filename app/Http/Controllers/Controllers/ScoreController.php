<?php

namespace App\Http\Controllers;
use Auth;
use App\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
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
    public function create(Request $request)
    {
        

        $this->validate($request, [
            'highscore' => 'required',
            'avgst' => 'required',
            'century' => 'required',
            'assets' => 'required',
            'outs' => 'required',


        ]);

        if(Score::where('user_id', Auth()->user()->id)->exists()){
            return response()->json(['Failed' => "You already have Score data" ]);

        }


        $score = Score::create([
          'user_id' => Auth::user()->id,
          'highscore' => $request->highscore,
          'avgst' => $request->avgst,
          'century' => $request->century,
          'assets' => $request->assets,
          'outs' => $request->outs
        ]);


        $success = Auth::user()->fname;
        return response()->json(['Success' => $success . "'s Score updated" ]);


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
    public function show($id)
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
        $this->validate($request, [
            'highscore' => 'required',
            'avgst' => 'required',
            'century' => 'required',
            'assets' => 'required',
            'outs' => 'required',


        ]);

      
     
         if($score = Score::find($id)->where('user_id', '=', Auth::user()->id)->first()){



            $score->highscore = $request->highscore;
            $score->avgst = $request->avgst;
            $score->century = $request->century;
            $score->assets = $request->assets;
            $score->outs = $request->outs;
         
                 $score->save();


        $success = Auth::user()->fname;
        return response()->json(['Success' => $success . "'s Score updated" ]);
    }
    
    
    else{
        return response()->json(['Failure' => "Try to access yours..." ]);

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



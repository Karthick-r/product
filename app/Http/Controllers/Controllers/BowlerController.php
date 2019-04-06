<?php

namespace App\Http\Controllers;

use Auth;
use App\Bowler;

use Illuminate\Http\Request;

class BowlerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $auth =  Auth::user();


        return response()->json('users', $users);
        
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
        Bowler::create([
            'totalwc' => $request->totalwc,
            'ecrt' => $request->ecrt,
            'bb' => $request->bb,
            'hat' => $request->hat,
            'hw' => $request->hw
          ]);

          return response()->json([
              'Success' => 'Bowler data updated'
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
       if($bowler = Bowler::find($id)->where('user_id', '=', Auth::user()->id)->first()){

        $totalwc = $bowler->totalwc;
        $ecrt = $bowler->ecrt;
        $bb =$bowler->bb ;
        $hat = $bowler->hat;
        $hw = $bowler->hw;
       
    
    
    return response()->json([
    
            'user_id' => Auth::user()->id,
    'total wickets' =>  $totalwc,
    'Economy rate' => $ecrt,
    'Best figure' => $bb,
    'hatricks' => $hat,
    'wickets by means of' => $hw,
    
    ]);
        }
    
    
        else{
            
            return response()->json([
            
                "failed" => "Not your data"
            
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
        

        if($bowler = Bowler::find($id)->where('user_id', '=', Auth::user()->id)->first()) {

            $bowler->totalwc = $request->totalwc;
            $bowler->ecrt = $request->ecrt;
            $bowler->bb = $request->bb;
         $bowler->hat = $request->hat;

         $bowler->hw = $request->hw;

 return response()->json([
              'Success' => 'Bowler data updated'
          ]);

        }  else{

            return response()->json([
                'Success' => 'Bowler data is not yours!!'
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

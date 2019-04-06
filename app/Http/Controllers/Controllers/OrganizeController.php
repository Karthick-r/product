<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Organize;
use Auth;

class OrganizeController extends Controller
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

        $this->validate($request, [
          
             'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin' => 'required|integer',
            'whovswho' => 'required',
            'currency' => 'required',
            'entryfee' => 'required',
           
            'overs' => 'required',
           
     

        ]);

        $organize = new Organize;



        $organize->user_id = Auth::user()->id;
        $organize->team_id = $request->team_id;
        $organize->tournament_id = $request->tournament_id;

        $organize->country = $request->country;
        $organize->state = $request->state;

        $organize->city = $request->city;
        $organize->pin = $request->pin;
        $organize->whovswho = $request->whovswho;
        $organize->currency = $request->currency;
        $organize->matchdate = $request->matchdate;
        $organize->oppo = $request->oppo;

        $organize->entryfee = $request->entryfee;
        $organize->lastdayforpay = $request->lastdayforpay;
        $organize->overs = $request->overs;
        $organize->dresscode = $request->dresscode;
        $organize->uniform = $request->uniform;
        $organize->scorer = $request->scorer;

        $organize->save();

       return response()->json([
           "id" => $organize->id,
           'Success' => 'Organized Successfully'
       ]) ;



 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    { 
        
        if($organize = Organize::find($id)->where('user_id' ,'=', Auth::user()->id)->first()){




        $teamname = $organize->country;
        $country = $organize->pin;
        $state =$organize->whovswho ;
        $city = $organize->currency;
        $pin = $organize->entryfee;
        $players = $organize->lastdayforpay;
        $overs =  $organize->overs;
        $dresscode = $organize->dresscode;
        $uniform = $organize->uniform;
       
    
    
    return response()->json([
    
            'user_id' => Auth::user()->id,
    'teamname' =>  $teamname,
    'country' => $country,
    'state' => $state,
    'city' => $city,
    'pin' => $pin,
    'players' => $players,
    'overs' => $overs,
    'dresscode' => $dresscode,
    'uniform' => $uniform
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
        
        $organize = Organize::find($id);


        $this->validate($request, [
          
            'user_id' => 'required',
            'country' => 'required',
            'state' => 'required',
            'city' => 'required',
            'pin' => 'required|integer',
            'whovswho' => 'required',
            'currency' => 'required',
           
            'lastdayforpay' => 'required',
            'overs' => 'required',
           


        ]);
        $organize->country = $request->country;
        $organize->state = $request->state;
        $organize->team_id = $request->team_id;

        $organize->city = $request->city;
        $organize->pin = $request->pin;
        $organize->whovswho = $request->whovswho;
        $organize->currency = $request->currency;
        $organize->entryfee = $request->entryfee;
        $organize->lastdayforpay = $request->lastdayforpay;
        $organize->overs = $request->overs;
        $organize->dresscode = $request->dresscode;
        $organize->uniform = $request->uniform;

        $organize->save();

       return response()->json([
           'success' => 'Match details edited Successfully'
       ]) ;


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


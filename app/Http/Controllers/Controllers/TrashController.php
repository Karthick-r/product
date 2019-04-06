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
class ProfileController extends Controller
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
    public function create(Request $request)
    {
      $this->validate($request, [
             'batsman' => 'required',
             'bowler' => 'required',
             'about' => 'required',
             'wicketkeeper' => 'required',
             'allrounder' => 'required',

      ]);
      if (Profile::where('user_id', Auth::user()->id)->exists()) {
        return response()->json(['Rejected' => Auth::user()->fname." you already have a profile"], 200);

    }
    else{

      $profile = new Profile();

      $profile->batsman = $request->input('batsman');
      $profile->bowler = $request->input('bowler');
      $profile->about = $request->input('about');

      $profile->wicketkeeper = $request->input('wicketkeeper');
      $profile->allrounder = $request->input('allrounder');
         $profile->zone=$request->input('zone');
$profile->country=$request->input('country');
$profile->city=$request->input('city');
$profile->pincode=$request->input('pincode');
$profile->avatar=$request->input('avatar');
$profile->dob=$request->input('dob');
$profile->gender=$request->input('gender');
      $profile->user_id = Auth::user()->id;
      $profile->save();

      $tour = new Tournament;
      $tour->user_id = Auth::user()->id;
      $tour->save();
 

$tour_ins = new TournamentIn;

$tour_ins->user_id = Auth::user()->id;


$tour_ins->save();


$bow  = new Bowler;

$bow->user_id = Auth::user()->id;

$bow->save();


$scr = new Score;
$scr->user_id = Auth::user()->id;
$scr->save();

$matchins = new Matchin;

$matchins->user_id = Auth::user()->id;
$matchins->save();


 

  $success = Auth::user()->fname . " profile created Successfully";
    return response()->json(['Sucess' => $success], 200);

    }

    }

  
    

        }
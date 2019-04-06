<?php

namespace App\Http\Controllers;

use App\zone_users;
use Illuminate\Http\Request;
use App\User;
use App\Zone;

class ZoneUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $admins=User::where('role_id', '5')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        $zones=Zone::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        
        return view('resp/index',['admins'=>$admins,'zones'=>$zones]);  
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\zone_users  $zone_users
     * @return \Illuminate\Http\Response
     */
    public function show(zone_users $zone_users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\zone_users  $zone_users
     * @return \Illuminate\Http\Response
     */
    public function edit(zone_users $zone_users)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\zone_users  $zone_users
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, zone_users $zone_users)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\zone_users  $zone_users
     * @return \Illuminate\Http\Response
     */
    public function destroy(zone_users $zone_users)
    {
        //
    }
}

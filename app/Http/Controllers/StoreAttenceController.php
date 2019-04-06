<?php

namespace App\Http\Controllers;

use App\store_attence;
use Illuminate\Http\Request;
use DB;
use Auth;

class StoreAttenceController extends Controller
{
   
   
    public function __construct()
  {
      $this->middleware('auth');
      
  }
   
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $store = DB::table('stores')
        ->join('categories', 'stores.category', '=', 'categories.id')
        ->join('routes', 'stores.route_id', '=', 'routes.id')
        ->select('stores.*','routes.name as route', 'categories.name as category')
        ->where('stores.deleted_on_off','1')
        ->get();
       
    
        return view('store/index',['store'=>$store ]);  
       

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $store = DB::table('store_attendances')
        ->join('stores', 'stores.id', '=', 'store_attendances.store_id')
        ->select('store_attendances.id',DB::raw('DATE_FORMAT(store_attendances.created_at, "%d-%m-%Y") as date'),
       DB::raw('DATE_FORMAT(store_attendances.created_at, "%H-%i") as time'),'stores.store_name as store_name')
     ->orderBy('store_attendances.created_at', 'DESC')
        ->where(DB::raw("(DATE_FORMAT(store_attendances.created_at,'%d-%m-%Y'))"),date('d-m-Y'))      
      ->get();
      return view('store/create',['store'=>$store]); 
      //return response()->json($store);  
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
     * @param  \App\store_attence  $store_attence
     * @return \Illuminate\Http\Response
     */
    public function show(store_attence $store_attence)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\store_attence  $store_attence
     * @return \Illuminate\Http\Response
     */
    public function edit(store_attence $store_attence)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\store_attence  $store_attence
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, store_attence $store_attence)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\store_attence  $store_attence
     * @return \Illuminate\Http\Response
     */
    public function destroy(store_attence $store_attence)
    {
        //
    }
}

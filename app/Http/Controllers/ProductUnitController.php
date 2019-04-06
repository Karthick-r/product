<?php

namespace App\Http\Controllers;
use App\product_unit;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\View;
use Validator;
use auth;


class ProductUnitController extends Controller
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
       $product_units=product_unit::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
    return view('product_unit/index',['product_units'=>$product_units]);

    }

    public function create()
    {
        return view('product_unit/create');//
    }

   
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), 
      [
       'name' => 'required|string|max:255|unique:product_units,name',   
      ]);

        if ($validator->fails())
         {

            $notification = array(
            'message' => 'your data error.', 
            'alert-type' => 'warning' );      
             return redirect()->back()->withErrors($validator)->with($notification);
         }

         else
         {
            $product_unit = new product_unit;
            $product_unit->name = $request->input('name');
            $product_unit->created_user=Auth::user()->id;
            $product_unit->save();
            $notification = array(
            'message' => 'your data is inserted.', 
            'alert-type' => 'success');
            return redirect()->back()->with($notification);
          }

    }
    

    public function show($id)
    {
        $product_unit = product_unit::find($id);
       
        if($product_unit->status==0)
        {
        $product_unit->status=1;
         $notification = array(
            'message' => 'Your product_unit is Unblocked', 
            'alert-type' => 'success');
              }
              else
                {      $product_unit->status=0;
                     $notification = array(
            'message' => 'Your product_unit is blocked', 
            'alert-type' => 'error');
              }

        $product_unit->updated_at=new \DateTime();
        $product_unit->save();



        return Redirect::to('shop_product_unit')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $product_unit =product_unit::find($id);
         return View::make('product_unit.edit')->with('product_unit',$product_unit) ;////
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
       $this->validate($request,
       
           [
           
            'name' => 'required|unique:product_units,name, '.$id.',id',
           ],

           [
            'name.required'=>"Enter your product_unit Name",
           ]); //

            $product_unit = product_unit::find($id);
            $product_unit->name = $request->input('name');
            $product_unit->updated_at=new \DateTime();
            $product_unit->save();
             $notification = array(
            'message' => 'Your Date is Updated', 
            'alert-type' => 'success');
            return Redirect::to('product_unit')->with($notification); // //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_unit = product_unit::find($id);
        $product_unit->deleted_on_off=0;
        $product_unit->deleted_at=new \DateTime();
        $product_unit->save();
        $notification = array(
            'message' => 'Your product_unit is Deleted', 
            'alert-type' => 'warning');
        return Redirect::to('product_unit')->with($notification); //
    }

}

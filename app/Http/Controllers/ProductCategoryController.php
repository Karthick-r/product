<?php

namespace App\Http\Controllers;

use App\product_category;
use Illuminate\Http\Request;



use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\View;
use Validator;
use auth;

class ProductCategoryController extends Controller
{
   
  public function __construct()
  {
      $this->middleware('auth');
      
  }
  public function index()
    {
       $product_categorys=product_category::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
    return view('product_category/index',['product_categorys'=>$product_categorys]);

    }

    public function create()
    {
        return view('product_category/create');//
    }

   
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), 
      [
       'name' => 'required|string|max:255|unique:product_categories,name',   
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
            $product_category = new product_category;
            $product_category->name = $request->input('name');
            $product_category->created_user=Auth::user()->id;
            $product_category->save();
            $notification = array(
            'message' => 'your data is inserted.', 
            'alert-type' => 'success');
            return redirect()->back()->with($notification);
          }

    }
    

    public function show($id)
    {
        $product_category = product_category::find($id);
       
        if($product_category->status==0)
        {
        $product_category->status=1;
         $notification = array(
            'message' => 'Your product_category is Unblocked', 
            'alert-type' => 'success');
              }
              else
                {      $product_category->status=0;
                     $notification = array(
            'message' => 'Your product_category is blocked', 
            'alert-type' => 'error');
              }

        $product_category->updated_at=new \DateTime();
        $product_category->save();



        return Redirect::to('shop_product_category')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $product_category =product_category::find($id);
         return View::make('product_category.edit')->with('product_category',$product_category) ;////
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
           
            'name' => 'required|unique:product_categories,name, '.$id.',id',
           ],

           [
            'name.required'=>"Enter your product_category Name",
           ]); //

            $product_category = product_category::find($id);
            $product_category->name = $request->input('name');
            $product_category->updated_at=new \DateTime();
            $product_category->save();
             $notification = array(
            'message' => 'Your Date is Updated', 
            'alert-type' => 'success');
            return Redirect::to('product_category')->with($notification); // //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product_category = product_category::find($id);
        $product_category->deleted_on_off=0;
        $product_category->deleted_at=new \DateTime();
        $product_category->save();
        $notification = array(
            'message' => 'Your product_category is Deleted', 
            'alert-type' => 'warning');
        return Redirect::to('product_category')->with($notification); //
    }

}

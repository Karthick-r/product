<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;
use App\category;
use Illuminate\Support\Facades\View;
use Validator;
use auth;



class CategoryController extends Controller
{
  
        public function __construct()
    {
        $this->middleware('auth');
        
    }

    public function index()
    {
       $categorys=category::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
    return view('category/index',['categorys'=>$categorys]);

    }

    public function create()
    {
        return view('category/create');//
    }

   
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), 
      [
       'name' => 'required|string|max:255|unique:categories,name',   
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
            $category = new category;
            $category->name = $request->input('name');
            $category->created_user=Auth::user()->id;
            $category->save();
            $notification = array(
            'message' => 'your data is inserted.', 
            'alert-type' => 'success');
            return redirect()->back()->with($notification);
          }

    }
    

    public function show($id)
    {
        $category = category::find($id);
       
        if($category->status==0)
        {
        $category->status=1;
         $notification = array(
            'message' => 'Your category is Unblocked', 
            'alert-type' => 'success');
              }
              else
                {      $category->status=0;
                     $notification = array(
            'message' => 'Your category is blocked', 
            'alert-type' => 'error');
              }

        $category->updated_at=new \DateTime();
        $category->save();



        return Redirect::to('shop_category')->with($notification);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
         $category =category::find($id);
         return View::make('category.edit')->with('category',$category) ;////
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
           
            'name' => 'required|unique:categories,name, '.$id.',id',
           ],

           [
            'name.required'=>"Enter your category Name",
           ]); //

            $category = category::find($id);
            $category->name = $request->input('name');
            $category->updated_at=new \DateTime();
            $category->save();
             $notification = array(
            'message' => 'Your Date is Updated', 
            'alert-type' => 'success');
            return Redirect::to('category')->with($notification); // //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $category = category::find($id);
        $category->deleted_on_off=0;
        $category->deleted_at=new \DateTime();
        $category->save();
        $notification = array(
            'message' => 'Your category is Deleted', 
            'alert-type' => 'warning');
        return Redirect::to('category')->with($notification); //
    }

    
}

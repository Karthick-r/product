<?php

namespace App\Http\Controllers;

use App\product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Redirect;

use Illuminate\Support\Facades\View;
use Validator;
use App\product_category;
use App\product_unit;
use auth;


class ProductController extends Controller
{
   
   
    public function __construct()
  {
      $this->middleware('auth');
      
  }
    public function index()
    {
        //$products=product::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
        $products=product::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        return view('product/index',['products'=>$products]);  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $productCategorys=product_category::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();    
        $product_units=product_unit::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();    
        
        return view('product/create',['productCategorys'=>$productCategorys,'product_units'=>$product_units]);  
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       

 $validator = Validator::make($request->all(), 
      [    'name' => 'required',
           'category' => 'required',
          'quantity' => 'required',
          'unit_id' => 'required',
          'price'=>'required',
          'image'=>'required|image|mimes:jpeg,png,jpg,gif|max:2048',   
          
      ],
      [
      'name.required'=>"Enter Product Name",
      'category.required'=>"Select Product Category",
      'quantity.required'=>"Enter Product Quantity",
      'unit_id.required'=>"Select Units",   
      'price.required'=>"Enter Product Price",
      'image.required'=>"select Image",
    
      ]);

        if ($validator->fails())
         {

            $notification = array(
            'message' => 'your data error.', 
            'alert-type' => 'warning' );      
             return redirect()->back()->withErrors($validator)->with($notification)->withInput();
         }

 else
         {


            
              $image=$request->file('image');
              $image_name='IMG_'.time().uniqid().'_'.$image->getClientOriginalName();
              $pathinfo='uploads/products/';
              $img=$image->move($pathinfo,$image_name);
      
            $product = new product;
            $product->name=ucfirst($request->input('name'));    
            $product->description=$request->input('description');    
            $product->price=$request->input('price');            
            $product->cat_id=$request->input('category');  
            $product->image=$image_name; 
            $product->quantity=$request->input('quantity');   
            $product->unit_id=$request->input('unit_id');  
            $product->status=1;
            $product->deleted_on_off=1;  
            $product->created_at= new \DateTime();
            $product->created_user=Auth::user()->id;
            $product->save();
             $notification = array(
            'message' => 'your data inserted.', 
            'alert-type' => 'success' ); 
            return Redirect::to('products')->with($notification);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
         $product = products::find($id);
        if($product->status==0)
        {
        $product->status=1;

        $notification = array(
            'message' => 'product is Unblocked', 
            'alert-type' => 'success');
              }
              
              else
                { 
                     $product->status=0;
                     $notification = array(
            'message' => 'product is blocked', 
            'alert-type' => 'error');
              }
              

        $product->updated_at=new \DateTime();
        $product->save();

        return Redirect::to('products')->with($notification);//
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $product = product ::find($id);
    
      $productCategorys=product_category::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();    
     $product_units=product_unit::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();    
        
      return view('product.edit',['productCategorys'=>$productCategorys,'product_units'=>$product_units,'product'=>$product]);  
     // return View::make('product.edit')->with('product',$product) ;
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
              
        $validator = Validator::make($request->all(), 
        [   'name' => 'required|unique:products,name,'.$id.',id',
      
              'district' => 'required',
            
        ],
        [
        'name.required'=>"Enter your Name",
        'district.required'=>"Select District",   
      
        ]);


        if ($validator->fails())
        {

           $notification = array(
           'message' => 'your data error.', 
           'alert-type' => 'warning' );      
            return redirect()->back()->withErrors($validator)->with($notification)->withInput();
        }

else
        {
     
            $product = products ::find($id);           
           $product->name=ucfirst($request->input('name'));    
           $product->district_id=$request->input('district');  
           
           $dis = District::find($product->district_id);
           $product->zone_id=$dis->zone_id;
           $product->state_id=$dis->state_id;
           $product->country_id=$dis->country_id;    
           $product->updated_at=new \DateTime();
         
           $product->save();
            $notification = array(
           'message' => 'Your Sate details is updated', 
           'alert-type' => 'success' ); 
           return Redirect::to('products')->with($notification);
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
            $product = product ::find($id);
            $product->deleted_on_off= 0;
            $product->deleted_at= new \DateTime();
            $product->save();

            

                $notification = array(
            'message' => 'product is Deleted', 
            'alert-type' => 'success');
            return Redirect::to('product')->with($notification);  //
    }


    public function allocate_index()
    {
        //$countrys=Country::orderBy('created_at', 'DESC')->where('deleted_on_off', '1')->where('status', '1')->get();
        $products=products::with('product_District1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        $admins=User::where('role_id', '5')->where('status', '1')->where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        return view('product/allocate',['products'=>$products,'admins'=>$admins]);  
    }


   
}

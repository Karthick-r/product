<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Stores;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Validator;
use App\category;

use DB;


class StoreController extends Controller
{
   

    public function __construct(){

        return $this->middleware('auth:api');
   
 }

    public function index()
    {
        $store = DB::table('stores')
        ->join('categories', 'stores.category', '=', 'categories.id')
        ->join('routes', 'stores.route_id', '=', 'routes.id')
        ->select('stores.*','routes.route_name', 'categories.name')
        ->where('stores.deleted_on_off','1')
        ->paginate(10);
        //return response()->json([ 'status' => 'Sucess','store'=>$store ], 200);
        return response()->json($store);
        // foreach($store as $sto)
        // {
        //     $vv[] =$sto->data;
        // }
       
        //echo $store;
       // print_r($store);

    }

 

    public function create()
    {
       
        $category=category::select('id', 'name')->where('deleted_on_off', '1')->where('status', '1')->orderBy('created_at', 'DESC')->get();
       
       // $cat['categoryList']=$category;
        return response()->json($category); 
       // return response()->json([ 'status' => 'Sucess','Route'=>$route,'Category'=>$category ], 200);
    }


    public function error(Request $request)
    {
       // echo $request->input('images'); 
        echo $request->file('images');
      
    }



   
    public function store(Request $request)
    {

$validator = Validator::make($request->all(), 
        [     
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric|unique:stores,store_phone',  
            'route_id' => 'required|numeric',
            'district_id' => 'required|numeric',
            'zone_id' => 'required|numeric',
            'state_id' => 'required|numeric', 
            'country_id' => 'required|numeric',             
            'user_id' => 'required|numeric',
            'latitude' => 'required',
            'longitude' => 'required',

        ],
        [     
            'name.required'=>"Enter your Name",
            'phone.required'=>"Enter your phone",  
            'route_id.required'=>"Enter your country",
            'user_id.required'=>"Enter your country",
         
        
        ]);
  
          if ($validator->fails())
           {
              return response()->json([ 'status' => 'Error','Message'=>'Something Went wrong' ], 200);
           }
         else
           {
              $store = new Stores;
         if($request->file('images')!='')
            {
             if($files=$request->file('images'))
                {
                    foreach($files as $file)
                    {
                        $name='IMG'.rand(10,1000).'_'.time().'_'.$file->getClientOriginalName();
                        $file->move('uploads/store/',$name);
                        $images[]=$name;
                    }
                }
                $ima=implode(",",$images);
                $store->image=$ima;   
            
            }
            else
            {
                $store->image='';  
            }
            
                       
                       
                        $store->store_name=$request->input('name');
                        $store->store_email=$request->input('email');
                        $store->gst_id=$request->input('gst_id');            
                        $store->category=$request->input('category');
                        $store->store_phone=$request->input('phone');
                        $store->contact_person=$request->input('contact_person');
                        $store->mobile=$request->input('mobile');                     
                        $store->remark=$request->input('remark');
                        $store->address=$request->input('address');
                        $store->latitude=$request->input('latitude');
                        $store->longitude=$request->input('longitude');
                        $store->route_id=$request->input('route_id'); 
                        $store->district_id=$request->input('district_id');
                        $store->zone_id=$request->input('zone_id');
                        $store->state_id=$request->input('state_id');
                        $store->country_id=$request->input('country_id');
                        $store->createdby_user_id=$request->input('user_id');         
                        $store->pincode=$request->input('pincode');
                        
                        $store->status=1;
                        $store->deleted_on_off=1;           
                        $store->created_at= new \DateTime();
                      
                        $store->save();  
                        return response()->json([ 'status' => 'Success','Message'=>'Your Store Sucessfully' ], 200);
        
                     
          }







    }
    public function image_delete(Request $request, $id)
    {
        $store = Stores ::find($id);

        if($request->input('image')!='')
        {
        
        if($store->image != "")
        {
        $img1=explode(',', $store->image);
      
          $vv=$request->input('image');

          if (($key = array_search($vv, $img1)) !== false)
         {
            unlink('uploads/store/'.$vv);
            unset($img1[$key]);
        }
        
        $img2=implode(",",$img1);
        $store->image=$img2;
        $store->updated_at= new \DateTime();
        $store->save();  

        }
    }


    }


    public function update(Request $request, $id)
    {
   

        $validator = Validator::make($request->all(), 
        [    
           
           
           
            'name' => 'required|string|max:255',        
            'route_id' => 'required|numeric',
           
            'latitude' => 'required',
            'longitude' => 'required',
            'phone' => 'required|unique:stores,store_phone, '.$id.',id'
             
        ],
        [         
            'phone.required'=>"Enter stores phone",  
        ]);

                 if ($validator->fails())
                 {
        return response()->json([ 'status' => 'Error','Message'=>'Your Phone number Allready Exit ' ], 200);
                 }
                 else
                 {


        $store = Stores ::find($id);

$input=$request->all();
$images=array();
if($request->file('images')!='')
{
if($files=$request->file('images'))
{
    foreach($files as $file)
    {
        $name='IMG'.rand(10,100).'_'.time().'_'.$file->getClientOriginalName();
        $file->move('uploads/store',$name);
        $images[]=$name;
    }
}
if($store->image!='')
{  
    $pre_img=$store->image;
    $img=implode(",",$images);
    $store->image=$pre_img.",".$img;
}
else
{
$store->image=implode(",",$images);
}
}





 
$store->store_name=$request->input('name');
$store->store_email=$request->input('email');
$store->gst_id=$request->input('gst_id');            
$store->category=$request->input('category');
$store->store_phone=$request->input('phone');
$store->contact_person=$request->input('contact_person');
$store->mobile=$request->input('mobile');                     
$store->remark=$request->input('remark');
$store->route_id=$request->input('route_id');  
$store->address=$request->input('address');
$store->latitude=$request->input('latitude');
$store->longitude=$request->input('longitude');

$store->pincode=$request->input('pincode');
$store->updated_at= new \DateTime();
$store->save();  


return response()->json([ 'status' => 'Success','Message'=>'Your Store Update Sucessfully' ], 200);


                 }

    }


  





}

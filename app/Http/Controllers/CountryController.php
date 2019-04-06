<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Country;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use auth;

class CountryController extends Controller
{

 
    public function __construct()
    {
        $this->middleware('auth');
        
    }
 

    public function index()
    {
         $countrys=Country::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
         return view('country/index',['countrys'=>$countrys]); 
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
       return view('country/create');   
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
      [  
      'name' => 'required|unique:countries,name',
          
      ],
      [       'name.required'=>"Enter Coutry Name", 
               ]);



 if ($validator->fails())
         {

            $notification = array(
            'message' => 'Enter Coutry Name', 
            'alert-type' => 'warning' );      
             return redirect()->back()->withErrors($validator)->with($notification)->withInput();
         }

 else
         {    
            $country = new Country;
            $country->name=ucfirst($request->input('name'));  
            $country->created_at=new \DateTime(); 
            $country->created_user=Auth::user()->id;
            $country->save();

            $notification = array(
            'message' => 'Your Country Details Insert', 
            'alert-type' => 'success');
            return Redirect::to('country')->with($notification);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    //      $country = Country::find($id);
    //     if($country->status==0)
    //     {
    //     $country->status=1;

    //     $notification = array(
    //         'message' => 'country is Unblocked', 
    //         'alert-type' => 'success');
    //           }
              
    //           else
    //             { 
    //                  $country->status=0;
    //                  $notification = array(
    //         'message' => 'country is blocked', 
    //         'alert-type' => 'error');
    //           }
              

    //     $country->updated_at=new \DateTime();
    //     $country->save();

    //     return Redirect::to('country')->with($notification);//
    // }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Model\Admin\price  $price
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $country = Country::find($id);
      return View::make('country.edit')->with('country',$country) ;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Model\Admin\price  $price
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

 $validator = Validator::make($request->all(), 
      [   

      'name' => 'required|unique:countries,name, '.$id.',id',
           
      ],
      [       'name.required'=>"Enter Country Name", 
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
      
            $country = Country::find($id); 
            $country->name=ucfirst($request->input('name'));         
            $country->updated_at= new \DateTime();
            $country->save();

            $notification = array(
            'message' => 'Your date is updated', 
            'alert-type' => 'success');
            return Redirect::to('country')->with($notification);
        }


          

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Model\Admin\price  $price
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
            $Country = Country ::find($id);
            $Country->deleted_on_off= 0;
            $Country->deleted_at= new \DateTime();
            $Country->save();  
                $notification = array(
            'message' => 'country is Deleted', 
            'alert-type' => 'success');
            return Redirect::to('country')->with($notification); 
    }

    public function allocate_index()
    {
        $countrys=Country::where('deleted_on_off', '1')->orderBy('created_at', 'DESC')->get();
        return view('country/allocate',['countrys'=>$countrys]); 
    }

  
    //
}

@extends('layouts.app')

@section('header-content')
<li class="m-nav__item">
<a href="{{ url('admin') }}" class="m-nav__link">
            <span class="m-nav__link-text">User Dateils</span>
        </a>
    </li>
    @endsection

@section('content')

<div class="row">
        <div class="col-xl-8 col-lg-8 offset-lg-2">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        <form class="m-form m-form--fit m-form--label-align-right" action="{{ route ('admin.update', $admin->id ) }}" method="POST">
                                 <input name="_method" type="hidden" value="PUT">
                                   {{ csrf_field() }}
              
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10 m--hide">
                                   
                                </div>
                            
                            <div class="form-group m-form__group row   @if ($errors->has('name')) {{'has-danger'}} @endif">
                                    <label for="example-text-input" class="col-2 col-form-label text-left"> Name</label>
                                    <div class="col-4">
                                        <input class="form-control m-input" name="name" type="text" value="{{ $admin->name }}" >
                                        @if ($errors->has('name'))
                                        <div class="form-control-feedback ">{{ $errors->first('name') }}</div>
                                       
                                        @endif
                                    </div>
                             </div>
    
                                 
                            <div class="form-group m-form__group row   @if ($errors->has('phone')) {{'has-danger'}} @endif">
                                <label for="example-text-input" class="col-2 col-form-label text-left"> Phone</label>
                                <div class="col-4">
                                    <input class="form-control m-input" name="phone" type="text" value="{{ $admin->phone }}" >
                                    @if ($errors->has('phone'))
                                    <div class="form-control-feedback ">{{ $errors->first('phone') }}</div>
                                   
                                    @endif
                                </div>
                            </div>
    
    
                            <div class="form-group m-form__group row   @if ($errors->has('email')) {{'has-danger'}} @endif">
                                <label for="example-text-input" class="col-2 col-form-label text-left"> Email</label>
                                <div class="col-4">
                                    <input class="form-control m-input" name="email" type="text" value="{{ $admin->email }}" >
                                    @if ($errors->has('email'))
                                    <div class="form-control-feedback ">{{ $errors->first('email') }}</div>
                                   
                                    @endif
                                </div>
                            </div>
    
    
                          
    
                            <div class="form-group m-form__group row   @if ($errors->has('admin')) {{'has-danger'}} @endif">
                                <label for="example-text-input" class="col-2 col-form-label text-left"> Choose User</label>
                               
                                    <div class="col-8" style="float:left;">


                                            
                                        <div class="m-radio-inline">
                                            <label class="m-radio">
                                            <input type="radio" name="admin"  onclick="del(2)" @if($admin->role_id==1) {{'checked'}} @endif value="1" > Admin User
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                <input type="radio" name="admin" onclick="del(2)" @if($admin->role_id==2) {{'checked'}} @endif  value="2"> Owner User
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                <input type="radio" name="admin"  onclick="del(3)" @if($admin->role_id==3) {{'checked'}} @endif  value="3"> Sales Manager
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                <input type="radio" name="admin" onclick="del(4)"  @if($admin->role_id==4) {{'checked'}} @endif  value="4"> Sales Officer
                                                <span></span>
                                            </label>
                                            <label class="m-radio">
                                                <input type="radio" name="admin" onclick="del(5)"  @if($admin->role_id==5) {{'checked'}} @endif  value="5"> Sales Resp
                                                <span></span>
                                            </label>
                                        </div>
                                    </div>
                                    @if ($errors->has('admin'))
                                    <div class="form-control-feedback ">{{ $errors->first('admin') }}</div>
                                   
                                    @endif
                               
                            </div>
                            <div id="txtHint">

                            </div>  
    
                            </div>
                            <div class="m-portlet__foot m-portlet__foot--fit">
                                <div class="m-form__actions">
                                    <div class="row">
                                        <div class="col-2">
                                            <!-- <a href=""  class="btn btn-sm btn-brand m-btn m-btn--icon m-btn--icon-only m-btn--custom m-btn--pill"><i class="fa fa-angle-double-left"></i></a>&nbsp;&nbsp;-->
                                        </div>
                                        <div class="col-2">                                           
                                          </div>
                                        <div class="col-4 offset-4">
                                            <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Update</button>&nbsp;&nbsp;
                                            <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Clear</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>

                      
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
            document.getElementById('con').style.display ='none';
            document.getElementById('sta').style.display ='none';
            document.getElementById('zon').style.display ='none';
            document.getElementById('dis').style.display ='none';
            document.getElementById('sta2').style.display ='none';   
            </script>
    
    @if(old('admin')=='3' || $admin->role_id==3) 
    
            <script>       
            document.getElementById('sta2').style.display ='block';        
            </script>
    
    @endif
    
    
    @if(old('admin')=='4' || $admin->role_id==4) 
    
            <script>
            document.getElementById('con').style.display ='block';
            document.getElementById('sta').style.display ='block';
            document.getElementById('zon').style.display ='block';
            document.getElementById('dis').style.display ='none';
            document.getElementById('sta2').style.display ='none'; 
            </script>
    
    @endif
    
    @if(old('admin')=='5' || $admin->role_id==5) 
    
            <script>
            document.getElementById('con').style.display ='block';
            document.getElementById('sta').style.display ='block';
            document.getElementById('zon').style.display ='block';
            document.getElementById('dis').style.display ='block';
            document.getElementById('sta2').style.display ='none'; 
            </script>
    
    @endif
    
    
    @endsection
    @section('script')
    
    
    
    <script>
    
    
    
              
    
            function del(str)
             {
            
       
               
               
                  if (str == "2") 
                  {
                    document.getElementById("txtHint").innerHTML = "";
                    document.getElementById('con').style.display ='none';
                    document.getElementById('sta').style.display ='none';
                    document.getElementById('zon').style.display ='none';
                    document.getElementById('dis').style.display ='none';
                    document.getElementById('sta2').style.display ='none'; 
                    return;
                } 
                else if(str == "4")
                {
                    onclick="del(5)"
                    document.getElementById("txtHint").innerHTML = "";
    
                    document.getElementById('con').style.display ='block';
                    document.getElementById('sta').style.display ='block';
                    document.getElementById('zon').style.display ='block';
                    document.getElementById('dis').style.display ='none';
                    document.getElementById('sta2').style.display ='none'; 
              
                    return;
    
                }
                else if(str == "5")
                {
                    document.getElementById("txtHint").innerHTML = "";
                    document.getElementById('con').style.display ='block';
                    document.getElementById('sta').style.display ='block';
                    document.getElementById('zon').style.display ='block';
                    document.getElementById('dis').style.display ='block';
                    document.getElementById('sta2').style.display ='none'; 
                    return;
    
                }
                else { 
                    document.getElementById('con').style.display ='none';
                    document.getElementById('sta').style.display ='none';
                    document.getElementById('zon').style.display ='none';
                    document.getElementById('dis').style.display ='none';
                    document.getElementById('sta2').style.display ='block';      
    
                    // if (window.XMLHttpRequest) {
                    //     // code for IE7+, Firefox, Chrome, Opera, Safari
                    //     xmlhttp = new XMLHttpRequest();
                    // } else {
                    //     // code for IE6, IE5
                    //     xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                    // }
                    // xmlhttp.onreadystatechange = function() {
                    //     if (this.readyState == 4 && this.status == 200) {
                    //         document.getElementById("txtHint").innerHTML = this.responseText;
                    //     }
                    // };
                    // xmlhttp.open("GET",'/get-list/'+str,true);
                    // xmlhttp.send();
        
     
        
        
                }
               
       
            
               
            }
             
            
        
            </script>   
            
    <script type="text/javascript">
       
       $('#state').change(function()
            {
                alert('yes');
            var countryID = $(this).val();    
            if(countryID){
                $.ajax({
                   type:"GET",
                   url:"{{url('get-zone-list')}}?country_id="+countryID,
                   success:function(res){               
                    if(res){
                        $("#zone").empty();
                        $("#zone").append('<option>Select</option>');
                        $.each(res,function(key,value){
                            $("#zone").append('<option value="'+key+'">'+value+'</option>');
                        });
                   
                    }else{
                       $("#zone").empty();
                    }
                   }
                });
            }else{
                $("#zone").empty();
                $("#district").empty();
            }      
           });
            $('#zone').on('change',function(){
            var stateID = $(this).val();    
            if(stateID){
                $.ajax({
                   type:"GET",
                   url:"{{url('get-district-list')}}?state_id="+stateID,
                   success:function(res){               
                    if(res){
                        $("#district").empty();
                        $.each(res,function(key,value){
                            $("#district").append('<option value="'+key+'">'+value+'</option>');
                        });
                   
                    }else{
                       $("#district").empty();
                    }
                   }
                });
            }else{
                $("#district").empty();
            }
                
           });
    
    </script>
    
    
    
    @endsection
    
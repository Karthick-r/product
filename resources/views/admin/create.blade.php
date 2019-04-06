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
                    <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('admin.store') }}" method="POST">

                          
                                    {{ csrf_field() }}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10 m--hide">
                               
                            </div>
                        
                        <div class="form-group m-form__group row   @if ($errors->has('name')) {{'has-danger'}} @endif">
                                <label for="example-text-input" class="col-2 col-form-label text-left"> Name</label>
                                <div class="col-4">
                                    <input class="form-control m-input" name="name" type="text" value="{{old('name')}}" >
                                    @if ($errors->has('name'))
                                    <div class="form-control-feedback ">{{ $errors->first('name') }}</div>
                                   
                                    @endif
                                </div>
                         </div>

                             
                        <div class="form-group m-form__group row   @if ($errors->has('phone')) {{'has-danger'}} @endif">
                            <label for="example-text-input" class="col-2 col-form-label text-left"> Phone</label>
                            <div class="col-4">
                                <input class="form-control m-input" name="phone" type="text" value="{{old('phone')}}" >
                                @if ($errors->has('phone'))
                                <div class="form-control-feedback ">{{ $errors->first('phone') }}</div>
                               
                                @endif
                            </div>
                        </div>


                        <div class="form-group m-form__group row   @if ($errors->has('email')) {{'has-danger'}} @endif">
                            <label for="example-text-input" class="col-2 col-form-label text-left"> User Id</label>
                            <div class="col-4">
                                <input class="form-control m-input" name="email" type="text" value="{{old('email')}}" >
                                @if ($errors->has('email'))
                                <div class="form-control-feedback ">{{ $errors->first('email') }}</div>
                               
                                @endif
                            </div>
                        </div>


                        <div class="form-group m-form__group row   @if ($errors->has('password')) {{'has-danger'}} @endif">
                            <label for="example-text-input" class="col-2 col-form-label text-left"> Password</label>
                            <div class="col-4">
                            <input class="form-control m-input" name="password" type="password" value="" >
                                @if ($errors->has('password'))
                                <div class="form-control-feedback ">{{ $errors->first('password') }}</div>
                               
                                @endif
                            </div>
                        </div>

                        <div class="form-group m-form__group row   @if ($errors->has('password')) {{'has-danger'}} @endif">
                            <label for="example-text-input" class="col-2 col-form-label text-left"> Conform Password </label>
                            <div class="col-4">
                                <input class="form-control m-input" name="password_confirmation" type="password" value="" >
                                @if ($errors->has('password_confirmation'))
                                <div class="form-control-feedback ">{{ $errors->first('password_confirmation') }}</div>
                               
                                @endif
                            </div>
                        </div>

                        <div class="form-group m-form__group row   @if ($errors->has('admin')) {{'has-danger'}} @endif">
                            <label for="example-text-input" class="col-2 col-form-label text-left"> Choose User</label>
                           
                                <div class="col-8" style="float:left;">
                                    <div class="m-radio-inline">
                                        <label class="m-radio">
                                        <input type="radio" name="admin" onclick="change()" value="1" @if(old('admin')=='1') {{'checked'}} @endif > Admin User
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="admin" onclick="change()" value="2"  @if(old('admin')=='2') {{'checked'}}@endif> Owner User
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="admin"  onclick="change(3)" value="3" @if(old('admin')=='3') {{'checked'}}@endif > Sales Manager
                                            <span></span> 
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="admin" onclick="change(4)" value="4" @if(old('admin')=='4') {{'checked'}}@endif> Sales Officer
                                            <span></span>
                                        </label>
                                        <label class="m-radio">
                                            <input type="radio" name="admin" onclick="change(5)" value="5" @if(old('admin')=='5') {{'checked'}}@endif> Sales Resp
                                            <span></span>
                                        </label>
                                    </div>

                                    @if ($errors->has('admin'))
                                    <div class="form-control-feedback ">{{ $errors->first('admin') }}</div>
                                   
                                    @endif
                                </div>
                              
                              
                        </div>

                       

                       
                    
                      <div id="sm">
                       
                        <div class="form-group m-form__group row   @if ($errors->has('sm')) {{'has-danger'}} @endif" >
                                <label for="example-text-input" class="col-2 col-form-label text-left"> Select Sales Manager</label>
                                <div class="col-4">
                                        <select class="form-control m-input"  name="sm" onchange="myFunction()" id="sm1">
                                               
                                            <option value="" >Select Sales Manager</option>
                                            @if(count($admins)>=1);
                                            @foreach($admins as $admin)
                                           <option value="{{$admin->id}}" >{{$admin->name}}</option>
                                            @endforeach
                                            @else
                                            <option value="0" >Create Country First</option>
                                            @endif  
                                        </select>
                                 
                                    @if ($errors->has('sm'))
                                    <div class="form-control-feedback ">{{ $errors->first('sm') }}</div>
                                   
                                    @endif
                                </div>
                            </div>


                            <div id="txtHint">
                            </div>
                                </div>




                                <div id="sr">
                                        <div class="form-group m-form__group row   @if ($errors->has('sm')) {{'has-danger'}} @endif" >
                                                <label for="example-text-input" class="col-2 col-form-label text-left"> Select Sales Manager</label>
                                                <div class="col-4">
                                                        <select class="form-control m-input"  name="state"  id="state">
                                                            <option value="" >Select Sales Manager</option>     
                                                            @if(count($admins)>=1);
                                                            @foreach($admins as $admin)
                                                           <option value="{{$admin->id}}" >{{$admin->name}}</option>
                                                            @endforeach
                                                            @else
                                                            <option value="0" >Create Country First</option>
                                                            @endif  
                                                        </select>
                                                 
                                                    @if ($errors->has('sm'))
                                                    <div class="form-control-feedback ">{{ $errors->first('sm') }}</div>
                                                   
                                                    @endif
                                                </div>
                                            </div>



                                            <div class="form-group m-form__group row   @if ($errors->has('zone')) {{'has-danger'}} @endif" id="zon">
                                                    <label for="example-text-input" class="col-2 col-form-label text-left"> Select Sales Office</label>
                                                           <div class="col-4">
                                                                   <select class="form-control m-input"  id="zone" name="zone"  >
                                                                       <option value="" >Select Sales Office</option>
                                                                      
                                                                       </select>
                                                            
                                                               @if ($errors->has('zone'))
                                                               <div class="form-control-feedback ">{{ $errors->first('zone') }}</div>
                                                              
                                                               @endif
                                                           </div>
                                                   </div>
                           
            
                              
                                                   <div class="form-group m-form__group row   @if ($errors->has('district')) {{'has-danger'}} @endif" id="dis" >
                                                        <label for="example-text-input" class="col-2 col-form-label text-left"> Select District</label>
                                                               <div class="col-4">
                                                                       <select class="form-control m-input"  id="district" name="district"  >
                                                                           <option value="" >Select District</option>
                                                                          
                                                                           </select>
                                                                
                                                                   @if ($errors->has('district'))
                                                                   <div class="form-control-feedback ">{{ $errors->first('district') }}</div>
                                                                  
                                                                   @endif
                                                               </div>
                                                       </div>


                                </div>


                                       <div id="sta2">
                                        <div class="form-group m-form__group row   @if ($errors->has('check_state')) {{'has-danger'}} @endif" >
                                             <label for="example-text-input" class="col-2 col-form-label text-left"> Select State</label>
                                                 <div class="col-4">
                                                    <div class="m-form__group form-group">
                                                            <div class="m-checkbox-list">
                                                                @if(count($states)>=1) 
                                                                    @foreach($states as $state)
                                                                            <label class="m-checkbox m-checkbox--state-brand">
                                                                                    <input name="check_state[]" value="{{$state->id}}" type="checkbox"> {{$state->name}}
                                                                                    <span></span>
                                                                                </label>
                                                                    @endforeach
                                                                @else
                                                                    <label class=""> <span class="has-danger"> Create State  </span>  </label>
                                                                @endif 
                                                            </div>
                                                    </div>
                                                 </div>
                                            </div>
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
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Add</button>&nbsp;&nbsp;
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
        document.getElementById('sta2').style.display ='none'; 
        document.getElementById('sm').style.display ='none'; 
        document.getElementById('sr').style.display ='none'; 
        </script>



@if(old('admin')=='3' ) 

    <script>       
     document.getElementById('sta2').style.display ='block'; 
        document.getElementById('sm').style.display ='none'; 
        document.getElementById('sr').style.display ='none';    
    </script>

@endif


@if(old('admin')=='4' ) 

    <script>
     document.getElementById('sta2').style.display ='none'; 
        document.getElementById('sm').style.display ='block'; 
        document.getElementById('sr').style.display ='none';   
    </script>

@endif

@if(old('admin')=='5' ) 

    <script>
     document.getElementById('sta2').style.display ='none'; 
        document.getElementById('sm').style.display ='none'; 
        document.getElementById('sr').style.display ='block';   
    </script>

@endif


@endsection







@section('script')
 
     
<script>
    function change(str)
     {
      
          if (str == "") 
          {
            document.getElementById('sm').style.display ='none'; 
            document.getElementById('sta2').style.display ='none'; 
            document.getElementById('sr').style.display ='none'; 
            return;
        } 
        else if (str == "3") 
          {
            document.getElementById('sm').style.display ='none'; 
            document.getElementById('sta2').style.display ='block'; 
            document.getElementById('sr').style.display ='none'; 
          } 
        
       else if (str == "4") 
          {
            document.getElementById('sm').style.display ='block'; 
            document.getElementById('sta2').style.display ='none'; 
            document.getElementById('sr').style.display ='none'; 
          } 

          else if (str == "5") 
          {
            document.getElementById('sm').style.display ='none'; 
            document.getElementById('sta2').style.display ='none'; 
            document.getElementById('sr').style.display ='block'; 
          } 
        
        
        else { 
            document.getElementById('sm').style.display ='none'; 
            document.getElementById('sta2').style.display ='none'; 
            document.getElementById('sr').style.display ='none'; 
            }
      
    
       
    }
    
</script>





<script>
    
    
    
              
    
        function myFunction()
         {
            var str= document.getElementById("sm1").value;
           //alert(str);
           if(str=='')
           {
            document.getElementById("txtHint").innerHTML = "";
           }
           else
           {
                if (window.XMLHttpRequest) 
                {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        document.getElementById("txtHint").innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET",'/clients/products/public/get-list/'+str,true);
                xmlhttp.send();
           }
        
           
        }
         
        
    
        </script>   


<script type="text/javascript">
   
    $('#state').change(function()
         {
             
         var countryID = $(this).val();    
         if(countryID){
             $.ajax({
                type:"GET",
                url:"{{url('get-admin-zone-list')}}?country_id="+countryID,
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
                url:"{{url('get-admin-district-list')}}?state_id="+stateID,
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


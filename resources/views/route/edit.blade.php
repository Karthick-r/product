@extends('layouts.app')

@section('header-content')
<li class="m-nav__item">
<a href="{{ url('route') }}" class="m-nav__link">
            <span class="m-nav__link-text">Route Dateils</span>
        </a>
    </li>
    @endsection

@section('content')

<div class="row">
        <div class="col-xl-8 col-lg-8 offset-lg-2">
            <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
                <div class="tab-content">
                    <div class="tab-pane active" id="m_user_profile_tab_1">
                        <form class="m-form m-form--fit m-form--label-align-right" action="{{ route ('route.update', $route->id ) }}" method="POST">
                                 <input name="_method" type="hidden" value="PUT">
                                   {{ csrf_field() }}
              
                            <div class="m-portlet__body">
                                <div class="form-group m-form__group m--margin-top-10 m--hide">
                                   
                                </div>
                                <div class="form-group m-form__group row   @if ($errors->has('country')) {{'has-danger'}} @endif" id="con">
                                        <label for="example-text-input" class="col-2 col-form-label text-left"> Select Country</label>
                                        <div class="col-4">
                                                <select class="form-control m-input"  name="country" id="exampleSelect1">
                                                       
                                                    @if(count($countrys)>=1);
                                                    @foreach($countrys as $country)
                                                   <option value="{{$country->id}}" >{{$country->name}}</option>
                                                    @endforeach
                                                    @else
                                                    <option value="0" >Create Country First</option>
                                                    @endif        
                                                      
                                                    </select>
                                                   
            
            
                                         
                                            @if ($errors->has('country'))
                                            <div class="form-control-feedback ">{{ $errors->first('country') }}</div>
                                           
                                            @endif
                                        </div>
                                    </div>
                           
                      
                                      <div class="form-group m-form__group row   @if ($errors->has('state')) {{'has-danger'}} @endif" id="sta">
                                            <label for="example-text-input" class="col-2 col-form-label text-left"> Select state</label>
                                            <div class="col-4">
                                                    <select class="form-control m-input"  name="state" id="state">
                                                          
                                                          
                                                        @if(count($states)>=1);
                                                        @foreach($states as $state)
                                                       <option value="{{$state->id}}"  @if($state->id==$route->state_id) {{'selected'}}@endif>{{$state->name}}</option>
                                                        @endforeach
                                                        @else
                                                        <option value="" >Create state First</option>
                                                        @endif        
                                                          
                                                        </select>
                                                       
                
                
                                             
                                                @if ($errors->has('state'))
                                                <div class="form-control-feedback ">{{ $errors->first('state') }}</div>
                                               
                                                @endif
                                            </div>
                                        </div>
                  
                                    
                       
        
                                        <div class="form-group m-form__group row   @if ($errors->has('zone')) {{'has-danger'}} @endif" id="zon">
                                                <label for="example-text-input" class="col-2 col-form-label text-left"> Select Zone</label>
                                                       <div class="col-4">
                                                               <select class="form-control m-input"  id="zone" name="zone"  >
                                                                    @foreach($zones as $zone)
                                                                    @if($zone->id== $route->zone_id)
                                                                    <option value="{{$zone->id}}" @if($zone->id== $route->zone_id) {{'selected'}}@endif>{{$zone->name}}</option>
                                                                        
                                                                    @endif
                                                                    @endforeach
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
                                                                        @foreach($districts as $district)
                                                                        @if($district->id== $route->zone_id)
                                                                        <option value="{{$district->id}}" @if($district->id== $route->district_id) {{'selected'}}@endif>{{$district->name}}</option>
                                                                            
                                                                        @endif
                                                                        @endforeach
                                                                       </select>
                                                            
                                                               @if ($errors->has('district'))
                                                               <div class="form-control-feedback ">{{ $errors->first('district') }}</div>
                                                              
                                                               @endif
                                                           </div>
                                                   </div>
    
    
                            
                    


                            
                            <div class="form-group m-form__group row   @if ($errors->has('name')) {{'has-danger'}} @endif">
                                    <label for="example-text-input" class="col-2 col-form-label text-left"> route Name</label>
                                    <div class="col-4">
                                        <input class="form-control m-input" name="name" type="text" value="{{ $route->name }}" >
                                        @if ($errors->has('name'))
                                        <div class="form-control-feedback ">{{ $errors->first('name') }}</div>
                                       
                                        @endif
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

@endsection



@section('script')
        
<script type="text/javascript">
   
    $('#state').change(function()
         {
             
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

@extends('layouts.app')
@section('header-content')
<li class="m-nav__item">
        <a href="" class="m-nav__link">
            <span class="m-nav__link-text">User Dateils</span>
        </a>
    </li>
    @endsection

@section('content')


		<!--begin::Portlet-->
        <div class="m-content">
               
                <div class="m-portlet m-portlet--mobile">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                   User Detail
                                </h3>
                            </div>
                        </div>
                        <div class="m-portlet__head-tools">
                            <ul class="m-portlet__nav">
                               
                             
                            </ul>
                        </div>
                    </div>
                    <div class="m-portlet__body">

                        <!--begin: Datatable -->
                        <table class="table table-striped- table-bordered table-hover table-checkable" id="m_table_1">
                            <thead>
                                <tr>
                                    <th>RNO</th>                                  
                                    <th>district</th>   
                                                    
                                                       
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>


                                    <?php $i=0;?>

                                     @foreach($districts as $district)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$district->name}}</td>
                                    <td>{{$district->district_zone->name}}</td>
                                    <td>{{$district->district_zone->zone->name}}</td>
                                            <input type="hidden" id="lan{{$i}}" value="{{$district->id}}">
                                    </td>

                                    <td>
        <div class="col-4">
                <select class="form-control m-input"  name="admin" id="exampleSelect1" onchange="showevent{{$i}}(this.value)">
                    @if(count($district->d_u)>=1)   
                    <option value="" >Select Sales Manager</option>                                                         
                    @foreach($district->d_u as $admin)
                    <option value="{{$admin->user_id}}" @if($admin->user_id==$district->user_id) {{'selected'}} @endif >{{$admin->district_user_name->name}}</option>
                    @endforeach
                    @else
                    <option value="0" >Create Sales Manager</option>
                    @endif
                </select>
            @if ($errors->has('admin'))
             <div class="form-control-feedback ">{{ $errors->first('admin') }}</div>
            @endif
        </div>

</td>  

                                  
                                </tr>


                                <script>
                                        function showevent{{$i}}(str) 
                                        {
                                         //alert(str);
                                          if (str=="") 
                                          {                                        
                                            document.getElementById("language").innerHTML="";
                                            return;
                                          } 
                                        
                                        else
                                          { 
                                        var zone = document.getElementById('lan{{$i}}').value;
                                        window.location.replace(`/clients/products/public/districtallocate/${str}/${zone}`); 
                                          
                                       // window.location.replace(`/districtallocate/${str}/${zone}`); 
                                         
                                          }
                                        }
                                        </script>

                                @endforeach
                           
                               
                              
                           
                            </tbody>
                        </table>
                    </div>
                </div>
               

                <!-- END EXAMPLE TABLE PORTLET-->
            </div>

        <!--end::Portlet-->
      
@endsection



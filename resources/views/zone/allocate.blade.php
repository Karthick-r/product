@extends('layouts.app')
@section('header-content')
<li class="m-nav__item">
        <a href="" class="m-nav__link">
            <span class="m-nav__link-text">Zone Dateils</span>
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
                                    <th>zone</th>   
                                    <th>Actions</th>
                                    <th>Allocate User</th>
                                </tr>
                            </thead>
                            <tbody>


                                    <?php $i=0;?>

                                     @foreach($zones as $zone)
                                <tr>
                                    <td>{{++$i}}</td>
                                <td>{{$zone->zone->name}}</td>

                                    <td>{{$zone->name}}
                                            <input type="hidden" id="lan{{$i}}" value="{{$zone->id}}">
                                    </td>

                                    <td>
        <div class="col-4">
                <select class="form-control m-input"  name="admin" id="exampleSelect1" onchange="showevent{{$i}}(this.value)">
                    @if(count($zone->z_u)>=1)   
                    <option value="" >Select Sales Manager</option>                                                         
                    @foreach($zone->z_u as $admin)
                    <option value="{{$admin->user_id}}" @if($admin->user_id==$zone->user_id) {{'selected'}} @endif >{{$admin->zone_user_name->name}}</option>
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
                                       window.location.replace(`/clients/products/public/zoneallocate/${str}/${zone}`); 
                                       // window.location.replace(`/zoneallocate/${str}/${zone}`); 
                                        
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
        <script>
                function clickAlert() {
                 var result = confirm("Are you sure want to Delete This User");
                  if(result ) 
                  { 
                   return true;
                  } 
                 else
                 {
                  return false;
                 }
              }
              </script>

@endsection



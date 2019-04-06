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
                                    <th>state</th>   
                                                    
                                                       
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>


                                    <?php $i=0;?>

                                     @foreach($states as $state)
                                <tr>
                                    <td>{{++$i}}</td>
                                    <td>{{$state->name}}
                                    <input type="hidden" id="lan{{$i}}" value="{{$state->id}}">
                                    </td>
                                    <td>
                                        
                                            <div class="col-4">
                                                    <select class="form-control m-input"  name="admin" id="exampleSelect1" onchange="showevent{{$i}}(this.value)">
                                                           
                                                            @if($state->user_id==0)
                                                            <option value="0"  >Allocate Sales Manager</option>
                                                            @endif  
                                                          
                                                        @if(count($admins)>=1)                                                        
                                                        @foreach($admins as $admin)
                                                    <option value="{{$admin->id}}" @if($admin->id==$state->user_id) {{'selected'}} @endif >{{$admin->name}}</option>
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
                                        var state = document.getElementById('lan{{$i}}').value;
                                        window.location.replace(`/clients/products/public/stateallocate/${str}/${state}`); 
                                         
                                       // window.location.replace(`/stateallocate/${str}/${state}`); 
                                         
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



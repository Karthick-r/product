@extends('layouts.app')

@section('header-content')
<li class="m-nav__item">
<a href="{{ url('product') }}" class="m-nav__link">
            <span class="m-nav__link-text">product Dateils</span>
        </a>
    </li>
    @endsection

@section('content')

<div class="row">
    <div class="col-xl-8 col-lg-8 offset-lg-2">
        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
            <div class="tab-content">
                <div class="tab-pane active" id="m_user_profile_tab_1">
                    <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('products.store') }}" method="POST"  enctype="multipart/form-data">

                          
                                    {{ csrf_field() }}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10 m--hide">
                               
                            </div>


                            <div class="form-group m-form__group row   @if ($errors->has('category')) {{'has-danger'}} @endif">
                                    <label for="example-text-input" class="col-2 col-form-label text-left"> Select Product Category</label>
                                    <div class="col-4">
                                            <select class="form-control m-input"  name="category" id="exampleSelect1">
                                                   
                                                @if(count($productCategorys)>=1);
                                                @foreach($productCategorys as $productCategory)
                                               <option value="{{$productCategory->id}}" >{{$productCategory->name}}</option>
                                                @endforeach
                                                @else
                                                <option value="0" >Create Category First</option>
                                                @endif        
                                                  
                                                </select>
                                               
        
        
                                     
                                        @if ($errors->has('category'))
                                        <div class="form-control-feedback ">{{ $errors->first('category') }}</div>
                                       
                                        @endif
                                    </div>
                                </div>


                        
                        <div class="form-group m-form__group row   @if ($errors->has('name')) {{'has-danger'}} @endif">
                                <label for="example-text-input" class="col-2 col-form-label text-left">product Name</label>
                                <div class="col-4">
                                    <input class="form-control m-input" name="name" type="text" value="" >
                                    @if ($errors->has('name'))
                                    <div class="form-control-feedback ">{{ $errors->first('name') }}</div>
                                   
                                    @endif
                                </div>
                         </div>

                         <div class="form-group m-form__group row   @if ($errors->has('quantity')) {{'has-danger'}} @endif">
                            <label for="example-text-input" class="col-2 col-form-label text-left">Product Quantity</label>
                            <div class="col-2">
                                <input class="form-control m-input" name="quantity" type="number" value="" >
                                @if ($errors->has('quantity'))
                                <div class="form-control-feedback ">{{ $errors->first('quantity') }}</div>
                               
                                @endif
                            </div>
                            <div class="col-2" @if ($errors->has('unit_id')) {{'has-danger'}} @endif">
                                <select class="form-control m-input"  name="unit_id" id="exampleSelect1">
                                                   
                                    @if(count($product_units)>=1);
                                    @foreach($product_units as $product_unit)
                                   <option value="{{$product_unit->id}}" >{{$product_unit->name}}</option>
                                    @endforeach
                                    @else
                                    <option value="0" >Create Unit First</option>
                                    @endif        
                                      
                                    </select>
                                @if ($errors->has('unit_id'))
                                <div class="form-control-feedback ">{{ $errors->first('unit_id') }}</div>
                               
                                @endif
                            </div>
                     </div>

                     <div class="form-group m-form__group row   @if ($errors->has('price')) {{'has-danger'}} @endif">
                        <label for="example-text-input" class="col-2 col-form-label text-left">Product Price</label>
                        <div class="col-4">
                            <input class="form-control m-input" name="price" type="text" value="" >
                            @if ($errors->has('price'))
                            <div class="form-control-feedback ">{{ $errors->first('price') }}</div>
                           
                            @endif
                        </div>
                 </div>


                 <div class="form-group m-form__group row   @if ($errors->has('image')) {{'has-danger'}} @endif">
                    <label for="example-text-input" class="col-2 col-form-label text-left">Product Price</label>
                    <div class="col-4">
                            <img id="blah" src="#" alt="your image" />

                        <input type="file" class="form-control" name="image" accept="image/*" onchange="readURL(this);" >
                        @if ($errors->has('image'))
                        <div class="form-control-feedback ">{{ $errors->first('image') }}</div>
                       
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
       function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#blah')
                        .attr('src', e.target.result)
                        .width(150)
                        .height(200);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }
</script>

@endsection


  


         <div class="form-group m-form__group row   @if ($errors->has('check_state')) {{'has-danger'}} @endif">
            <label for="example-text-input" class="col-2 col-form-label text-left"> Select Zone</label>
                <div class="col-4">
                    <div class="m-form__group form-group">
                            <div class="m-checkbox-list">
                            @if(count($admins)>=1)  

                          
                                    @foreach($admins as $admin)

                                            <label class="m-checkbox m-checkbox--state-brand">
                                                    <input name="check_zone[]" value="{{$admin->id}}" type="checkbox"> {{$admin->name}}
                                                    <span></span>
                                                </label>
                                @endforeach
                                
                                @else
                              
                             <label class="">
                                    <span class="has-danger"> Create State
                                </span>
                            </label>
                                @endif 
                                
                            </div>
                        </div>
                    </div>
                </div>
 



















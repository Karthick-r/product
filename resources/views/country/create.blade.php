@extends('layouts.app')

@section('header-content')
<li class="m-nav__item">
        <a href="{{url('country')}}" class="m-nav__link">
            <span class="m-nav__link-text">Country Dateils</span>
        </a>
    </li>
@endsection

@section('content')

<div class="row">
    <div class="col-xl-8 col-lg-8 offset-lg-2">
        <div class="m-portlet m-portlet--full-height m-portlet--tabs  ">
            <div class="tab-content">
                <div class="tab-pane active" id="m_user_profile_tab_1">
                    <form class="m-form m-form--fit m-form--label-align-right" action="{{ route('country.store') }}" method="POST">

                          
                                    {{ csrf_field() }}
                        <div class="m-portlet__body">
                            <div class="form-group m-form__group m--margin-top-10 m--hide">
                               
                            </div>
                            <div class="form-group m-form__group row">
                                <div class="col-10 ml-auto">
                                    <h3 class="m-form__section">Add Country</h3>
                                </div>
                            </div>
                        <div class="form-group m-form__group row   @if ($errors->has('name')) {{'has-danger'}} @endif">
                                <label for="example-text-input" class="col-2 col-form-label text-left">Country Name</label>
                                <div class="col-4">
                                    <input class="form-control m-input" name="name" type="text" value="" >
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
                                    </div>
                                    <div class="col-7 offset-3">
                                        <button type="submit" class="btn btn-accent m-btn m-btn--air m-btn--custom">Add</button>&nbsp;&nbsp;
                                        <button type="reset" class="btn btn-secondary m-btn m-btn--air m-btn--custom">Cancel</button>
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

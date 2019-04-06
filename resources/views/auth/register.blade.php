
<!DOCTYPE html>

<!-- 
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 4
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<html lang="en">

	<!-- begin::Head -->
    @include('layouts.head')

	<!-- end::Head -->

	<!-- begin::Body -->
	<body class="m--skin- m-header--fixed m-header--fixed-mobile m-aside-left--enabled m-aside-left--skin-dark m-aside-left--fixed m-aside-left--offcanvas m-footer--push m-aside--offcanvas-default">

		<!-- begin:: Page -->
		<div class="m-grid m-grid--hor m-grid--root m-page">
			<div class="m-login m-login--signin  m-login--5" id="m_login" style="background-image: url(../../../assets/app/media/img//bg/bg-3.jpg);">
				<div class="m-login__wrapper-1 m-portlet-full-height">
					<div class="m-login__wrapper-1-1">
						<div class="m-login__contanier">
							<div class="m-login__content">
								<div class="m-login__logo">
									<a href="#">
										<img src="../../../assets/app/media/img/logos/logo-2.png">
									</a>
								</div>
								<div class="m-login__title">
									<h3>JOIN OUR GREAT METRO COMMUNITY GET FREE ACCOUNT</h3>
								</div>
								<div class="m-login__desc">
									Amazing Stuff is Lorem Here.Grownng Team
								</div>
								<div class="m-login__form-action">
									<button type="button" id="m_login_signup" class="btn btn-outline-focus m-btn--pill">Get An Account</button>
								</div>
							</div>
						</div>
						<div class="m-login__border">
							<div></div>
						</div>
					</div>
				</div>
				<div class="m-login__wrapper-2 m-portlet-full-height">
					<div class="m-login__contanier">
						
						<div class="m-login__signin">
							<div class="m-login__head">
								<h3 class="m-login__title">Sign Up</h3>
								<div class="m-login__desc">Enter your details to create your account:</div>
							</div>
							<form class="m-login__form m-form" method="POST" action="{{ route('register') }}">
                                    {{ csrf_field() }}

                                    <div class="form-group m-form__group {{ $errors->has('company_name') ? ' has-error' : '' }}">
								
                                
                                            <input id="company_name" type="text"  placeholder="Company Name * " class="form-control m-input" name="company_name" value="{{ old('company_name') }}" required autofocus>
        
                                            @if ($errors->has('company_name'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('company_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
								<div class="form-group m-form__group {{ $errors->has('name') ? ' has-error' : '' }}">
								
                                
                                    <input id="name" type="text"  placeholder="Contact Person Name" class="form-control m-input" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('name') }}</strong>
                                        </span>
                                    @endif
                                </div>

                                <div class="form-group m-form__group {{ $errors->has('phone') ? ' has-error' : '' }}">
								
                                
                                        <input id="phone" type="text"  placeholder="Contact Phone*" class="form-control m-input" name="phone" value="{{ old('phone') }}" required autofocus>
    
                                        @if ($errors->has('phone'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('phone') }}</strong>
                                            </span>
                                        @endif
                                    </div>
								<div class="form-group m-form__group {{ $errors->has('email') ? ' has-error' : '' }}">
									
                                    <input id="email" type="email" placeholder="Eamil*" class="form-control m-input" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                                <div class="form-group m-form__group {{ $errors->has('address') ? ' has-error' : '' }}">
								
                                
                                        <input id="address" type="text"  placeholder="Address(optional)" class="form-control m-input" name="address" value="{{ old('address') }}" required autofocus>
    
                                        @if ($errors->has('address'))
                                            <span class="help-block">
                                                <strong>{{ $errors->first('address') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                    <div class="form-group m-form__group {{ $errors->has('city') ? ' has-error' : '' }}">
								
                                
                                            <input id="city" type="text"  placeholder="City(optional)" class="form-control m-input" name="city" value="{{ old('city') }}" required autofocus>
        
                                            @if ($errors->has('city'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>

                                        <div class="form-group m-form__group {{ $errors->has('district') ? ' has-error' : '' }}">
								
                                
                                                <input id="district" type="text"  placeholder="district(optional)" class="form-control m-input" name="district" value="{{ old('district') }}" required autofocus>
            
                                                @if ($errors->has('district'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('district') }}</strong>
                                                    </span>
                                                @endif
                                            </div>

                                        <div class="form-group m-form__group {{ $errors->has('state') ? ' has-error' : '' }}">
								
                                
                                                <input id="state" type="text"  placeholder="State(optional)" class="form-control m-input" name="state" value="{{ old('state') }}" required autofocus>
            
                                                @if ($errors->has('state'))
                                                    <span class="help-block">
                                                        <strong>{{ $errors->first('state') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="form-group m-form__group {{ $errors->has('country') ? ' has-error' : '' }}">
								
                                
                                                    <input id="country" type="text"  placeholder="Country(optional)" class="form-control m-input" name="country" value="{{ old('country') }}" required autofocus>
                
                                                    @if ($errors->has('country'))
                                                        <span class="help-block">
                                                            <strong>{{ $errors->first('country') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                                <div class="form-group m-form__group {{ $errors->has('pincode') ? ' has-error' : '' }}">
								
                                
                                                        <input id="pincode" type="text"  placeholder="Pincode(optional)" class="form-control m-input" name="pincode" value="{{ old('pincode') }}" required autofocus>
                    
                                                        @if ($errors->has('pincode'))
                                                            <span class="help-block">
                                                                <strong>{{ $errors->first('pincode') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
								<div class="form-group m-form__group{{ $errors->has('password') ? ' has-error' : '' }}">
							
                                
                                    <input id="password" type="password"  placeholder="Password*" class="form-control m-input" name="password" required>

                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                
                                </div>
								<div class="form-group m-form__group">

                                        <input id="password-confirm" type="password"  placeholder="Password Confirmation*" class="form-control m-input m-login__form-input--last" name="password_confirmation" required>
						
								</div>
								<div class="m-login__form-sub">
									<label class="m-checkbox m-checkbox--focus">
										<input type="checkbox" name="agree"> I Agree the <a href="#" class="m-link m-link--focus">terms and conditions</a>.
										<span></span>
									</label>
									<span class="m-form__help"></span>
								</div>
								<div class="m-login__form-action">
									<button id="m_login_signup_submit" type="submit" class="btn btn-focus m-btn m-btn--pill m-btn--custom m-btn--air">Sign Up</button>
									<button id="m_login_signup_cancel" class="btn btn-outline-focus m-btn m-btn--pill m-btn--custom">Cancel</button>
								</div>
							</form>
						</div>
					
					</div>
				</div>
			</div>
		</div>

		<!-- end:: Page -->

		<!--begin:: Global Mandatory Vendors -->
        @include('layouts.script')

		<!--end::Page Scripts -->
	</body>

	<!-- end::Body -->
</html>



{{-- <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Login</div>
    
                    <div class="panel-body">
                        <form class="form-horizontal" method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
    
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail Address</label>
    
                                <div class="col-md-6">
                                    <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus>
    
                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('email') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label for="password" class="col-md-4 control-label">Password</label>
    
                                <div class="col-md-6">
                                    <input id="password" type="password" class="form-control" name="password" required>
    
                                    @if ($errors->has('password'))
                                        <span class="help-block">
                                            <strong>{{ $errors->first('password') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div>
    
                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Login
                                    </button>
    
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
                                        Forgot Your Password?
                                    </a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>--}}




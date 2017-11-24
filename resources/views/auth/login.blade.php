@extends('layouts.app')

@section('content')
<div class="user-profile-wrap login-reg-wrap login-wrap">
                	
                    	<div class="row">
                        	<div class="col-md-12 col-sm-12 col-xs-12">
                            	<h1 class="user-profile-heading">log in</h1><hr/>
                            </div>
                        </div>
                
                    <div class="row">
                    	<div class="user-profile login-blk">
                                
       						<div class="col-md-12 col-sm-12 col-xs-12">	
                            
                                
                                <div class="row">
                                <div class="col-md-12 col-sm-12 col-xs-12">	
                            	 <form class="" method="POST" action="{{ route('login') }}">	
                                 {{ csrf_field() }}
                                            <div class="row">
                                    	<div class="col-md-12 col-sm-12 col-xs-12">
                                        	<div class="alert alert-danger alert-dismissable none">
               									Input valid email address or phone number.
             								 </div>
                                             <div class="alert alert-success none">
               									WE will send code within 10 mintus.
             								 </div>
                                        </div>
                                    </div>
                            	
                     			   
                            	<div class="row">
                                             	<div class="col-md-12 col-sm-12 col-xs-12">
                                                
                                          <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
                                              <label for="">Email Address</label>
                                              <input type="email" class="form-control Enter-Email-Forgot" name="email" id="email" placeholder="Enter Email Address" value="{{ old('email') }}" required>
                                               @if ($errors->has('email'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('email') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                          
                                          <div class="form-group m0 {{ $errors->has('password') ? ' has-error' : '' }}">
                                              <label for="">password</label>
                                              <input type="password" class="form-control Create-Pass" name="password" id="password" placeholder="Enter New Password" required>
                                               @if ($errors->has('password'))
                                                <span class="help-block">
                                                    <strong>{{ $errors->first('password') }}</strong>
                                                </span>
                                            @endif
                                          </div>
                                     </div>
                                     
                            <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="form-group">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Remember Me
                                    </label>
                                </div>
                            </div>
                        </div>
                             </div>
                             
                                          <div class="row">
                                             	<div class="col-md-12 col-sm-12 col-xs-12">
                                                 <button type="submit" class="btn btn-primary btn-login btn-Signin">
                                                        Login
                                                    </button>
                                                	
                                                </div>
                                             </div>
                                             
                                             <div class="row">
                                             	<div class="col-md-12 col-sm-12 col-xs-12">
                                                <div class="form-group">
                                                    	<a href="forgot-password.html" class="btn forogt-pass">Forgot password</a>
                                                    </div>
                                                 <!--   <a href="register.html" class="btn btn-default btn-login">register</a>-->
                                                </div>
                                             </div>
                                             </form>
                                             
                                        <!--      <div class="row">
                                             	<div class="col-md-12 col-sm-12 col-xs-12">
                                                	<p class="login-devices">Or sign in with one click</p>
                                                </div>
                                             </div>
                                             
                                            <div class="row">
                                             	<div class="col-md-12 col-sm-12 col-xs-12">
                                                
                                             	<div class="btn-acc-device">
                                                	<a href="#" class="btn btn-fb-login "><img src="images/fb.png"> sign in with facebook</a>
                                                </div>
                                                <div class="btn-acc-device">
                                                	<a href="#" class="btn btn-fb-login"><img src="images/google.png"> sign in with google</a>
                                                </div>
                                                
                                                </div>
                                             </div>-->
                                             
                                </div>
                                </div>
                            	
                               
                            </div>
                            
                         </div>       
                     </div>
                 </div>
            
@endsection

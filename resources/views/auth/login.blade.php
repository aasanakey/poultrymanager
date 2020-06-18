@extends('layouts.app')
@section('styles')
<style>
    #layoutAuthentication_content .card{
    background-image:url('/images/pic5.jpg');
    margin-bottom: 50px;
    }
    #layoutAuthentication_content .card-header{
        background-color:#000;
        color:white;
    }
    #layoutAuthentication_content form label{
        color:white;
        font-weight:bolder;
    }
    #layoutAuthentication_content a.small,.small >a{
        color:white;
        font-weight:bolder;
    }

</style>
@endsection
@section('content')
@include('layouts.logo')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Login</h3>
                     <a href="{{route('home')}}" class="btn" style="color:white;" title="Go to home"><i class="fas fa-arrow-left"> </i></a>
                </div>
                <div class="card-body">
                    <form action="{{ route('farm.manager.login')}}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmailAddress">Email</label>
                                    <input class="form-control py-4 @error('email') is-invalid @enderror" id="inputEmailAddress" name="email" type="email" value="{{ old('email') }}" placeholder="Enter email address" />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="small mb-1" for="inputPassword">Password</label>
                            <input class="form-control py-4 @error('password') is-invalid @enderror" id="inputPassword"  name="password" type="password" placeholder="Enter password" />
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input class="custom-control-input" id="rememberPasswordCheck" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}/>
                                <label class="custom-control-label" for="rememberPasswordCheck">Remember password</label>
                            </div>
                        </div>

                        <div class="form-group d-flex align-items-center justify-content-between mt-4 mb-0">
                            @if (Route::has('farm.manager.password.request'))
                                <a class="small" href="{{ route('farm.manager.password.request') }}">Forgot Password?</a>
                            @endif
                            <button  type="submit" class="btn btn-primary">Login</button>
                        </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                <div class="small"><a href="{{route('register')}}">Need an account? Sign up!</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection

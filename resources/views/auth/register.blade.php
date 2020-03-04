@extends('layouts.app')

@section('styles')
<style>
    #layoutAuthentication_content .card{
    background-image:url('/images/pic4.jpg');
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
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header">
                    <h3 class="text-center font-weight-light my-4">Create Account</h3>
                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            <span>{!! session()->get('success')!!} </span>
                        </div>
                    @endif
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            <span>{{ session()->get('resent')}} </span>
                        </div>
                    @endif
                </div>
                <div class="card-body">
                    <form action="{{ route('farm.post.register')}}" method="post">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputFarmName">Farm Name</label>
                                        {{-- <i class="fa fa-user" aria-hidden="true"></i> --}}
                                    <input class="form-control py-4 @error('farm_name') is-invalid @enderror" id="inputFarmName"
                                        type="text"  name="farm_name" value="{{ old('farm_name') }}" aria-describedby="farm_name_error"/>

                                    @error('farm_name')
                                        <span id="farm_name_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmail">Email</label>
                                    <input class="form-control py-4 @error('farm_email') is-invalid @enderror" id="inputEmail"
                                    type="email" name="farm_email" value="{{ old('farm_email') }}" aria-describedby="farm_email_error"/>

                                    @error('farm_email')
                                        <span id="farm_email_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="small mb-1" for="inputFarmContact">Farm Contact</label>
                                        <input class="form-control py-4 @error('farm_contact') is-invalid @enderror" id="inputFarmContact"
                                        type="text"  name="farm_contact" value="{{ old('farm_contact') }}" placeholder="eg 233-2000-66655" aria-describedby="farm_contact_error"/>

                                    @error('farm_contact')
                                        <span id="farm_contact_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label class="small mb-1" for="inputFarmLocation">Farm Address</label>
                                        <input class="form-control py-4 @error('farm_location') is-invalid @enderror" id="inputFarmLocation"
                                        type="text"  name="farm_location" value="{{ old('farm_location') }}" aria-describedby="farm_location_error"/>

                                    @error('farm_location')
                                        <span id="farm_location_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>

                    <div class="form-row">
                        <div class="col-md-12">
                            <div class="form-group">
                                    <label class="small mb-1" for="inputFarmManager">Farm Manager</label>
                                    <input class="form-control py-4 @error('farm_manager') is-invalid @enderror" id="inputFarmManager"
                                    type="text"  name="farm_manager" value="{{ old('farm_manager') }}" aria-describedby="farm_manager_error"/>

                                @error('farm_manager')
                                    <span id="farm_manager_error" class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    {{-- <div class="form-row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password" class="small mb-1">{{ __('Password') }}</label>
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password"  autocomplete="new-password">

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group ">
                                <label for="password-confirm" class="small mb-1">{{ __('Confirm Password') }}</label>
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation"  autocomplete="new-password">
                            </div>
                        </div>
                    </div> --}}
                    <div class="form-group mt-4 mb-0">
                        <button class="btn btn-primary btn-block" type="submit">Register</button>
                    </div>
                    </form>
                </div>
                <div class="card-footer text-center">
                    <div class="small"><a href="{{route('login')}}">Have an account? Go to login</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

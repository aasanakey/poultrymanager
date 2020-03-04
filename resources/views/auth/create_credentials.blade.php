@extends('layouts.app')

@section('styles')
<style>
    #layoutAuthentication_content .card{
    background-image:url('/images/pic4.jpg');
    margin-bottom: 50px;
    }
</style>
@endsection

@section('content')

@include('layouts.logo')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-7">
            <div class="card shadow-lg border-0 rounded-lg mt-5">
                <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Admin Account</h3></div>
                <div class="card-body">
                    <form action="{{ route('farm.post.credential.create')}}" method="post">
                        @csrf
                        <input type="hidden" name="farm_id" value="{{old('farm_id')? old('farm_id') : $id ?? null}}">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputFullName">fullname</label>
                                        {{-- <i class="fa fa-user" aria-hidden="true"></i> --}}
                                    <input class="form-control py-4 @error('fullname') is-invalid @enderror" id="inputFullName"
                                        type="text"  name="fullname" value="{{ old('fullname') }}" aria-describedby="fullname_error"/>

                                    @error('fullname')
                                        <span id="fullname_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="small mb-1" for="inputEmail">Email</label>
                                    <input class="form-control py-4 @error('email') is-invalid @enderror" id="inputEmail"
                                    type="email" name="email" value="{{ old('email') }}" aria-describedby="email_error"/>

                                    @error('email')
                                        <span id="email_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="form-group">
                                        <label class="small mb-1" for="inputFarmContact">Contact</label>
                                        <input class="form-control py-4 @error('contact') is-invalid @enderror" id="inputFarmContact"
                                        type="text"  name="contact" value="{{ old('contact') }}" placeholder="eg 233-2000-66655" aria-describedby="contact_error"/>

                                    @error('contact')
                                        <span id="contact_error" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>
                            {{-- <div class="col-md-6">
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
                            </div> --}}
                        </div>

                    <div class="form-row" hidden>
                        <div class="col-md-12">
                            <div class="form-group">
                                    <label class="small mb-1" for="inputFarmManager">Role</label>
                                    <input class="form-control py-4 @error('role') is-invalid @enderror" id="inputFarmManager"
                                    type="text"  name="role" value="SUPER_ADMIN" aria-describedby="role_error"/>

                                @error('role')
                                    <span id="role_error" class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-row">
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
                    </div>
                    <div class="form-group mt-4 mb-0">
                        <button class="btn btn-primary btn-block" type="submit">Create Account</button>
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

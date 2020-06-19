@extends('layouts.app')

@section('content')
@include('layouts.logo')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>{{ __('Reset Password') }}</h4>
                    <a href="{{route('farm.manager.password.request')}}" class="btn" style="color:white;" title="Go to home">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token ?? null }}">
                        <div class="form-row">
                           <div class="col-md-12">
                                <div class="form-group">
                                    <label for="email" class="small mb-1">{{ __('E-Mail Address') }}</label>
                                    <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ $email ?? old('email') }}" aria-describedby="email_error" required autocomplete="email" autofocus>

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
                                    <label for="password" class="small mb-1">{{ __('Password') }}</label>
                                    <input id="password" type="password" class="form-control py-4 @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                            </div>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12">
                                <div class="from-group">
                                    <label for="password-confirm" class="small mb-1">{{ __('Confirm Password') }}</label>
                                    <input id="password-confirm" type="password" class="form-control py-4" name="password_confirmation" required autocomplete="new-password">
                                </div>
                            </div>
                        </div>

                        <div class="form-row mb-0">
                            <div class="form-group col-md-6 offset-md-4 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

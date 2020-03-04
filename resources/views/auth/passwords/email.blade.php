@extends('layouts.app')

@section('content')
@include('layouts.logo')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header">{{ __('Reset Password') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf
                        <div class="form-row">
                            <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="email" class="small mb-1">{{ __('E-Mail Address') }}</label>
                                        <input id="email" type="email" class="form-control py-4 @error('email') is-invalid @enderror" 
                                        name="email" value="{{ old('email') }}" aria-describedby="email_error" required autocomplete="email" autofocus>
        
                                        @error('email')
                                            <span id="email_error" class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 mt-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Send Password Reset Link') }}
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

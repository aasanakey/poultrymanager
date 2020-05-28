
<div class="mt-4">
    @if (session()->has('success'))
        <div class="alert alert-success col-md-12" role="alert">
            <span>{{ session()->get('success')}} </span>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="alert alert-error" role="alert">
            <span>{{ session()->get('error')}} </span>
        </div>
    @endif
</div>
<div class="card shadow-lg border-0 rounded-lg mt-5">
    <div class="card-header"><h5 class="text-center font-weight-light my-4">Edit You Profile</h5></div>
    <div class="card-body">
        <form action="{{route('admin.edit.profile')}}" method="POST">
            @csrf
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="small mb-1" for="name">Name</label>
                    <input class="form-control py-4 @error('full_name') is-invalid @enderror" id="name" name="full_name" type="text" value="{{ old('full_name') ? old('full_name'): $user->full_name }}" placeholder="Enter email address" />
                    @error('full_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="small mb-1" for="email">Email</label>
                    <input class="form-control py-4 @error('email') is-invalid @enderror" id="email" name="email" type="email" value="{{ old('email') ? old('email'): $user->email }}" placeholder="" />
                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="form-row">
                <div class="form-group col-md-12">
                    <label class="small mb-1" for="contact">Contact</label>
                    <input class="form-control py-4 @error('contact') is-invalid @enderror" id="contact" name="contact" type="text" value="{{ old('contact') ? old('contact') : $user->contact}}" placeholder="" />
                    @error('contact')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
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
            <div class="form-row" style="display:flex;justify-content:center;">
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
    {{-- <div class="card-footer text-center">
    <div class="small"><a href="{{route('register')}}">Need an account? Sign up!</a></div>
    </div> --}}
</div>

{{-- id, farm_id, full_name, email, contact, role, email_verified_at, password, remember_token, created_at, updated_at --}}

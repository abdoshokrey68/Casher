@extends('layouts.app')

@section('content')
<div class="container members-box">
    <div class="row">
        <div class="col-md-5 m-auto mt-5">
            <div class="card m-auto mt-5">
                <div>
                    <h3 class="h3 text-center p-4">
                        <i class="fas fa-lock"></i>
                        @lang('site.reset_password')
                    </h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('password.update') }}">
                        @csrf

                        <input type="hidden" name="token" value="{{ $token }}">

                        <div class="row mb-3">
                            <label for="email" class="bold col-form-label"> @lang('site.email') </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="bold col-form-label"> @lang('site.passwor') </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="password-confirm" class="bold col-form-label"> @lang('site.confirm_password') </label>
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                        </div>

                        <div class="row mb-0">
                            <button type="submit" class="btn btn-primary">
                                @lang('site.reset_password')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

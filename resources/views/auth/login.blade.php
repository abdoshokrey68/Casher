@extends('layouts.app')

@section('content')
<div class="container members-box">
    <div class="row ">
        <div class="col-md-5 m-auto mt-5">
            <div class="card m-auto mt-5">
                <div>
                    <h3 class="h3 text-center p-4">
                        <i class="fas fa-user mr-2 ml-2"></i> @lang('site.login')
                    </h3>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}">
                        @csrf
                        <div class="row mb-3">

                                <label for="email" class="col-form-label bold"> @lang('site.email') </label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="row mb-3">
                            <label for="password" class="col-form-label bold"> @lang('site.password') </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>

                        <div class="row mb-3">
                                <div>
                                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label for="remember">
                                        @lang('site.remember_me')
                                    </label>
                                </div>
                        </div>

                        <div class="row mb-0">
                            <div class="">
                                <button type="submit" class="btn btn-primary mt-2">
                                    @lang('site.login')
                                </button>
                                @if (Route::has('password.request'))
                                    <a class="btn btn-link mt-2" href="{{ route('password.request') }}">
                                        @lang('site.forgot_password')
                                    </a>
                                @endif
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

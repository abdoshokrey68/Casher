@extends('layouts.app')

@section('content')
<div class="container members-box">
    <div class="row ">
        <div class="col-md-5 m-auto mt-5">
            <div class="card m-auto mt-5">
                <div>
                    <h3 class="h3 text-center p-4">
                        <i class="fas fa-lock"></i>
                        @lang('site.confirm_password')
                    </h3>
                </div>

                <div class="card-body">
                    @lang('site.pls_confirm')

                    <form method="POST" action="{{ route('password.confirm') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="password" class="bold col-form-label "> @lang('site.password') </label>
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <div>
                                <button type="submit" class="btn btn-primary">
                                    @lang('site.confirm_password')
                                </button>

                                @if (Route::has('password.request'))
                                    <a class="btn btn-link" href="{{ route('password.request') }}">
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

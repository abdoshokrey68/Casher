@extends('layouts.app')

@section('content')
<div class="container members-box">
    <div class="row">
        <div class="col-md-5 m-auto mt-5">
            <div class="card m-auto mt-5">
                <div>
                    <h3 class="h3 text-center p-4">
                        <i class="fas fa-lock"></i> @lang('site.reset_password')
                    </h3>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="row mb-3">
                            <label for="email" class="bold col-form-label "> @lang('site.email') </label>
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <button type="submit" class="btn btn-primary">
                                @lang('site.send_password')
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

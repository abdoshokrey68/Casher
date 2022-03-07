@extends('layouts.app')

@section('content')
<div class="container members-box">
    <div class="row">
        <div class="col-md-5 m-auto mt-5">
            <div class="card m-auto mt-5">
                <div>
                    <h3 class="h3 text-center p-4">
                        <i class="fas fa-envelope-open mr-2 ml-2"></i>
                        @lang('site.verification_email')
                    </h3>
                </div>

                <div class="card-body">
                    @if (session('resent'))
                        <div class="alert alert-success" role="alert">
                            @lang('site.link_verification')
                        </div>
                    @endif

                    @lang('site.before_proceeding')
                    @lang('site.not_receive'),
                    <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                        @csrf
                        <button type="submit" class="btn btn-link p-0 m-0 align-baseline"> @lang('site.request_another') </button>.
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

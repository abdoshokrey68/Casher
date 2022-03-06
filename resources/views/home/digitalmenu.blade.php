@extends('layouts.app')

@section('content')
    <div>
        <div>
            <digital-menu home="{{route('home')}}" casher_program="{{route('casher.program')}}" />
        </div>
    </div>
@endsection

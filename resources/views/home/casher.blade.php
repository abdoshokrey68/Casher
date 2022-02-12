@extends('layouts.home-layout')

@section('homecontent')
    <div>
        <div>
            <casher-program home="{{route('home')}}" />
        </div>
    </div>
@endsection

@extends('layouts.home-layout')

@section('homecontent')
    <div>
        <div>
            <home-component casher_route="{{route('casher.program')}}" />
        </div>
    </div>
@endsection

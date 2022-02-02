@extends('layouts.app')

@section('content')
    <div>
        <dashboard-store logout="{{route('logout')}}" store_id="{{$store_id}}" />
    </div>
@endsection

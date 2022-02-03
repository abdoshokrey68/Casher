@extends('layouts.app')

@section('content')
    <div>
        <dashboard-store logout="{{route('logout')}}" menu_link="{{route('store.menu', $store_id)}}" store_id="{{$store_id}}" />
    </div>
@endsection

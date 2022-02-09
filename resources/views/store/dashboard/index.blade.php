@extends('layouts.app')

@section('content')
    <div>
        {{-- {!! $html_data !!} --}}
        <dashboard-store logout="{{route('logout')}}" menu_link="{{route('store.menu', $store_id)}}" store_id="{{$store_id}}" />
    </div>
    <div>
        <main-footer />
    </div>
@endsection

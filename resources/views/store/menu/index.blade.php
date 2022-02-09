@extends('layouts.app')

@section('content')
    <div>
        <store-menu  store_id="{{$store_id}}" />
    </div>
    <div>
        <main-footer />
    </div>
@endsection


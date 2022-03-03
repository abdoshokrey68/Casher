@extends('layouts.app')

@section('content')
    <div>
        <div>
            <home-component casher_route="{{route('casher.program')}}" digital_menu="{{route('digital.menu')}}" />
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div>
        <div>
            <home-component casher_route="{{route('casher.program')}}" />
        </div>
    </div>
@endsection

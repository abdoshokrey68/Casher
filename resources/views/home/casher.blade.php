@extends('layouts.app')

@section('content')
    <div>
        <div>
            <casher-program home="{{route('home')}}" create_store="{{route('home.create-store')}}" />
        </div>
    </div>
@endsection

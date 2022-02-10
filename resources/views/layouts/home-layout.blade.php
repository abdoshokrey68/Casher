@extends('layouts.app')

@section('navbar')
    @extends('layouts.navbar')
@endsection

@section('content')
    @yield('homecontent')
@endsection


<notifications group="dashboard" />
<!-- VUE NOTIFICATION COMPONENT -->

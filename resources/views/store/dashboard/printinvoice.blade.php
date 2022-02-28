@extends('layouts.app')

@section('content')
    <div>
        <print-invoice store_id="{{$store_id}}" invoice_id="{{$invoice_id}}" />
    </div>
@endsection

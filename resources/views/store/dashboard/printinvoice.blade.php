<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Invoice</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
</head>
<body class="bg-body" dir="{{ LaravelLocalization::getCurrentLocaleDirection() }}">

    <div id="app">
        <print-invoice store_id="{{$store_id}}" invoice_id="{{$invoice_id}}" />
    </div>
</body>
{{-- <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script> --}}
{{-- <script src="{{asset('js/bootstrap.min.js')}}"></script> --}}
<script src="{{ asset('js/app.js') }}" defer></script>
</html>

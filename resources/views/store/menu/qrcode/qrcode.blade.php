<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

</head>
<style>
    .qr-page {
        background-size: inherit;
        background-repeat: no-repeat;
        min-width: 100vh
    }
    .bold {
        font-weight: bold
    }
    img {
        margin: auto;
        display: block;
        margin-top: 15px;
    }
    .text-center * {
        text-align: center
    }
    .col-md-6 {
        width: 50%
    }
</style>
<body>
    {{-- <div class="row qr-page" style="background-image: url('{{asset("image/menu/QR/border2.jpg")}}')"> --}}
        <div class="">
            <div class="card text-center">
                <h2 class="h2 bold"> {{$store->name}} </h2>
                <h3 class="h3"> Digital </h3>
                <h4 class="h4 bold"> MENU </h4>
                <h4 class="h4 bold"> here </h4>
                <img src="https://via.placeholder.com/150" >
                <img src="{{$url}}" >

            </div>
        </div>
    {{-- </div> --}}

</body>
</html>


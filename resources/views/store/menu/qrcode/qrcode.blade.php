@extends('layouts.app')


<style>
    .h1-size {
        font-size: 3em;
    }

    .h2-size {
        font-size: 1.5em;
    }
    .qr-page {
        /* background-size: inherit; */
        background-repeat: no-repeat;
        /* min-width: 100vh */
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
    .store-profile-image {
        position: absolute;
        left: 0;
        bottom: 0;
        width: 100px;
        height: 100px;
    }
    .qrcode-image{
        border: 15px solid #750304;
        padding: 5px;
        width: 200px !important;
        height: 200px !important;
    }
    .card {
        background-color: unset !important;
    }
</style>

@section('content')
    <div>
        {{-- <div class="row qr-page" style="background-image: url('{{asset("image/menu/QR/border2.jpg")}}')"> --}}
        <div class="row qr-page" >
            <div class="">
                <div class="card text-center">
                    <a href="{{route('download')}}">PDF Download</a>
                    <h1 class="h1-size bold"> {{$store->name}} </h1>
                    <h2 class="h2-size"> Digital </h2>
                    <h1 class="h1-size bold"> MENU </h1>
                    <h2 class="h2-size bold"> here </h2>
                    {{-- <h1 class="h1"> <i class="fas fa-down fa-2x"></i> </h1> --}}
                    {{-- <img src="{{asset("image/menu/QR/$menu->qrcode_name")}}" class="qrcode-image" alt="QrCode"> --}}
                    {{-- <img src="https://via.placeholder.com/150" > --}}
                    {{-- <div class="row mt-5">
                        <div class="col-md-6">
                            <img src="{{asset("image/stores/image/$store->image")}}" class="col-md-12" alt="">
                        </div>
                        <div class="col-md-6">
                            <div class="more-info">
                                <h2 class="h2-size">
                                    More Info
                                </h2>
                                <input type="text" class="form-control disabled mt-2" value="{{$store->phone}}" readonly="readonly" disabled >
                                <input type="text" class="form-control disabled mt-2" value="{{$store->email}}" readonly="readonly" disabled >
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
@endsection

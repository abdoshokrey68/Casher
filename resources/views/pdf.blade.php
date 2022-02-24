<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HTML 2 PDF</title>
        <style type="text/css">
            .center {
                text-align: center;
            }
        </style>
    </head>
    <body>
        <div class="center">
            <h1>This is heading</h1>
            <a href="{{route('download')}}">PDF Download</a>
        </div>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
        tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
        quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
        consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
        cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
        proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        {{-- <img src="{{ public_path("storage/images/".$user->profile_pic) }}" alt="" style="width: 150px; height: 150px;"> --}}


        {{-- <img src="{{asset("/image/menu/QR/$menu->qrcode_name")}}"  > --}}
        {{-- <img src="{{ public_path("image\menu\QR\\$menu->qrcode_name") }}" alt="" style="width: 150px; height: 150px;" > --}}
        {{-- <img src="{{asset("/image/menu/QR/border2.jpg")}}" > --}}

        {{-- <img src="public/storage/images/{{ $user->profile_pic }}" alt="" style="width: 150px; height: 150px;">
        <img src="public/storage/images/image_1.jpg" alt="" style="width: 150px; height: 150px;"> --}}

        <div class="visible-print text-center">
            {{-- {!! QrCode::wiFi([
                'encryption' => 'WPA',
                'ssid' => 'KHALED',
                'password' => '01144796899',
                'hidden' => 'true'
            ]);!!} --}}
        </div>

        {{-- {!! QrCode::size(100)->generate(Request::url()); !!} --}}
        <div>
            <div class="card">
                        <ul>
                    @foreach ($users as $user)
                            <li> {{$user->name}} </li>
                            <li> {{$user->email}} </li>
                            <hr>
                    @endforeach
                </ul>
            </div>
        </div>
    </body>
</html>

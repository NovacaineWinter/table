<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta property="siteurl" content="{{{url('/')}}}" />
    <meta property="chargeableinterval" content="{{{\App\config::where('name','=','chargeableInterval')->first()->integer}}}"

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">

    
    <title>Sign Up | Table Management</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/dataView.css') }}" rel="stylesheet">

    
</head>


<body>
    <div id="app">
        <div id="modal" class="uiPop hidden"></div>
        <div id="blankout" class="uiBlank hidden"></div>
        <div id="modalPopover" class="uiPop hidden"></div>
        <div id="modalBlankout" class="uiBlank hidden"></div>
        <div id="appContent">
            <div class="container">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://getaddress.io/js/jquery.getAddress-2.0.7.min.js"></script>
    
    <script src="{{ asset('js/dataView.js') }}"></script>
</body>
</html>

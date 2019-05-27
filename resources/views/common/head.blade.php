<head>
    <title>
        @yield('title')
    </title>
    <link rel="shortcut icon" href="{{asset('favicon.ico')}}"/>
    <meta charset="UTF-8">
    <meta name="author" content="Mladen Bošković"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="Just Write..."/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{asset('css/simpleLightbox.min.css')}}"/>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="{{asset('css/style.css')}}"/>
</head>
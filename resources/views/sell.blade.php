<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('vendor/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{asset('vendor/overlayScrollbars/css/OverlayScrollbars.min.css')}}">
    <link rel="stylesheet" href="{{asset('vendor/adminlte/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/sell.css')}}">
</head>
<body>
<div id="app">
    <sell></sell>
</div>
<script src="{{ asset('vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{asset('js/app.js')}}" ></script>
<script>
    if ($(".card").prop('scrollHeight') > $(".card").height() ) {
        alert('overflow!!!fk')
    }
    if ($(".card").prop('scrollWidth') > $(".card").width() ) {
        alert('overflow ')
    }
    $(".card").on('overflow',function (){
        alert('ok')
    })

    $(document).ready(function(){
        $('.card-body').overlayScrollbars({  });
        if($('.card-body').hasOverflow){
            alert('nm')
        }

    });

</script>
</body>
</html>

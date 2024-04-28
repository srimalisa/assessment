<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="ltr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="facebook-domain-verification" content="vso60muy8deqfdsso55c3w96y70kj4" />

    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '7150594791661483');
        fbq('track', 'PageView');
        </script>
        <noscript><img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=7150594791661483&ev=PageView&noscript=1"
        />
    </noscript>
    <!-- Meta Pixel Code -->
    
    <!-- End Meta Pixel Code -->
    <title> {{ env('APP_NAME') }}</title>
    <link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}">
    @include('layouts.skote.style')
</head>

<body data-topbar="light" data-layout="horizontal">
    
    {{-- @include('layouts.luma.preloader') --}}
    <div id="layout-wrapper">
        @include('layouts.skote.header')
        @yield('content')
        @include('layouts.skote.footer')
    </div>
@include('layouts.skote.script')
@include('layouts.vendor-scripts')
</body>

</html>

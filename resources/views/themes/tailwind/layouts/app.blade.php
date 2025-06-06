<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    @livewireStyles
    @if(isset($seo->title))
    <title>{{ $seo->title }}</title>
    @else
    <title>{{ setting('site.title', 'Laravel Wave') . ' - ' . setting('site.description', 'The Software as a Service
        Starter Kit built on Laravel & Voyager') }}</title>
    @endif

    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge"> <!-- † -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ url('/') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="{{ asset('vitrix/css/mystyle.css') }}" rel="stylesheet">
    <link rel="icon" href="{{ Voyager::image(setting('site.favicon', '/wave/favicon.png')) }}" type="image/x-icon">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    {{-- Social Share Open Graph Meta Tags --}}
    @if(isset($seo->title) && isset($seo->description) && isset($seo->image))
    <meta property="og:title" content="{{ $seo->title }}">
    <meta property="og:url" content="{{ Request::url() }}">
    <meta property="og:image" content="{{ $seo->image }}">
    <meta property="og:type" content="@if(isset($seo->type)){{ $seo->type }}@else{{ 'article' }}@endif">
    <meta property="og:description" content="{{ $seo->description }}">
    <meta property="og:site_name" content="{{ setting('site.title') }}">

    <meta itemprop="name" content="{{ $seo->title }}">
    <meta itemprop="description" content="{{ $seo->description }}">
    <meta itemprop="image" content="{{ $seo->image }}">

    @if(isset($seo->image_w) && isset($seo->image_h))
    <meta property="og:image:width" content="{{ $seo->image_w }}">
    <meta property="og:image:height" content="{{ $seo->image_h }}">
    @endif
    @endif

    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">

    @if(isset($seo->description))
    <meta name="description" content="{{ $seo->description }}">
    @endif

    <!-- Styles -->
    <link href="{{ asset('themes/' . $theme->folder . '/css/app.css') }}" rel="stylesheet">
</head>

<body
    class="flex flex-col min-h-screen @if(Request::is('/')){{ 'bg-black' }}@else{{ 'bg-black' }}@endif @if(config('wave.dev_bar')){{ 'pb-10' }}@endif">
    <button id="tetrisButton" aria-label="Tetris Button"></button>


    @php
    $path = request()->path();
    if (preg_match('#^payforms/[^/]+/[^/]+(/[^/]*)?$#', $path)) {
    $ocultarHeader = true;
    } else {
    $ocultarHeader = false;
    }
    @endphp

    @if(!$ocultarHeader)
    @if(config('wave.demo') && Request::is('/'))
    @include('theme::partials.demo-header')
    @endif

    @include('theme::partials.header')
    @endif


    <main class="flex-grow overflow-x-hidden ">
        @yield('content')
    </main>

    @if(!$ocultarHeader)
    @include('theme::partials.footer')

    @if(config('wave.dev_bar'))
    @include('theme::partials.dev_bar')
    @endif
    @endif



    <!-- Full Screen Loader -->
    <div id="fullscreenLoader"
        class="fixed inset-0 top-0 left-0 z-50 flex flex-col items-center justify-center hidden w-full h-full bg-gray-900 opacity-50">
        <svg class="w-5 h-5 mr-3 -ml-1 text-white animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
        <p id="fullscreenLoaderMessage" class="mt-4 text-sm font-medium text-white uppercase"></p>
    </div>
    <!-- End Full Loader -->




    @include('theme::partials.toast')
    @if(session('message'))
    <script>
        setTimeout(function(){ popToast("{{ session('message_type') }}", "{{ session('message') }}"); }, 10);
    </script>
    @endif
    @waveCheckout
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('vitrix/js/paymentform.js') }}"></script>
    <script src="{{ asset('vitrix/js/myscript.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>

    <script>
        @if(auth()->check())
            window.Echo.private(`balances.{{ auth()->user()->id }}`) // Reemplazamos USER_ID con el id del usuario autenticado
            .listen('.BalanceUpdated', (data) => {
    
                document.getElementById("balance_efectivo").innerText = `$${parseFloat(data.balance.replace(/[^0-9.-]+/g, '')).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
            });
        @else
           
            console.log('Usuario no autenticado');
        @endif
    </script>


@livewireScripts
</body>

</html>
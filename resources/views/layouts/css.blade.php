{{-- <link href="{{ asset('assets/media/app/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180" />
<link href="{{ asset('assets/media/app/favicon-32x32.png') }}" rel="icon" sizes="32x32" type="image/png" />
<link href="{{ asset('assets/media/app/favicon-16x16.png') }}" rel="icon" sizes="16x16" type="image/png" />
<link href="{{ asset('assets/media/app/favicon.ico') }}" rel="shortcut icon" /> --}}

<link href="{{ route('logo') }}" rel="apple-touch-icon" sizes="180x180" />
<link href="{{ route('logo') }}" rel="icon" sizes="32x32" type="image/png" />
<link href="{{ route('logo') }}" rel="icon" sizes="16x16" type="image/png" />
<link href="{{ route('logo') }}" rel="shortcut icon" />

<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
<link href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet" />
<link href="{{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet" />
{{-- <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet" /> --}}

<style>
    .single-ticker {
        height: 100%;
        overflow: hidden;
        position: relative;
    }

    .ticker-text {
        height: 100%;
        line-height: 100%;
        /* text-align: center; */
        
        animation: singleScrollUp 5s linear infinite;
    }
    .single-ticker:hover .ticker-text {
        animation-play-state: paused;
    }

    @keyframes singleScrollUp {
        0% {
            transform: translateY(100%);
        }
        15% {
            transform: translateY(0);
        }
        85% {
            transform: translateY(0);
        }
        100% {
            transform: translateY(-100%);
        }
    }
</style>
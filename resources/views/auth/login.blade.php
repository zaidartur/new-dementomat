<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">
    <head>
        <title>Metronic - Tailwind CSS Sign In</title>
    
        <meta charset="utf-8"/>
        <meta content="follow, index" name="robots"/>
        <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/authentication/classic/sign-in/index.html" rel="canonical"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <meta content="Sign in page using Tailwind CSS" name="description"/>
        <meta content="@keenthemes" name="twitter:site"/>
        <meta content="@keenthemes" name="twitter:creator"/>
        <meta content="summary_large_image" name="twitter:card"/>
        <meta content="Metronic - Tailwind CSS Sign In" name="twitter:title"/>
        <meta content="Sign in page using Tailwind CSS" name="twitter:description"/>
        <meta content="{{ asset('assets/media/app/og-image.png') }}" name="twitter:image"/>
        <meta content="https://127.0.0.1:8001/metronic-tailwind-html/demo1/authentication/classic/sign-in/index.html" property="og:url"/>
        <meta content="en_US" property="og:locale"/>
        <meta content="website" property="og:type"/>
        <meta content="@keenthemes" property="og:site_name"/>
        <meta content="Metronic - Tailwind CSS Sign In" property="og:title"/>
        <meta content="Sign in page using Tailwind CSS" property="og:description"/>
        <meta content="{{ asset('assets/media/app/og-image.png') }}" property="og:image"/>

        <link href="{{ asset('assets/media/app/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180"/>
        <link href="{{ asset('assets/media/app/favicon-32x32.png') }}" rel="icon" sizes="32x32" type="image/png"/>
        <link href="{{ asset('assets/media/app/favicon-16x16.png') }}" rel="icon" sizes="16x16" type="image/png"/>
        <link href="{{ asset('assets/media/app/favicon.ico') }}" rel="shortcut icon"/>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
        <link href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"/>

        @vite(['resources/metronic/css/styles.css', 'resources/js/app.js'])

        <!-- Page -->
        <style>
            .page-bg {
                background-image: url('{{ asset('assets/media/images/2600x1200/bg-10.png') }}');
            }
            .dark .page-bg {
                background-image: url('{{ asset('assets/media/images/2600x1200/bg-10-dark.png') }}');
            }
        </style>
    </head>
    <body class="antialiased flex h-full text-base text-foreground bg-background">
    
        <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
            <div class="kt-card max-w-[370px] w-full">
                <form action="{{ route('login') }}" class="kt-card-content flex flex-col gap-5 p-10" id="sign_in_form" method="POST">
                    @csrf
                    <div class="text-center mb-2.5">
                        <h3 class="text-lg font-medium text-mono leading-none mb-2.5">Sign in</h3>
                        <div class="flex items-center justify-center font-medium">
                            <span class="text-sm text-secondary-foreground me-1.5">
                                Need an account?
                            </span>
                            <a class="text-sm link" href="html/demo1/authentication/classic/sign-up.html">
                                Sign up
                            </a>
                        </div>
                        <x-auth-session-status class="mb-4" :status="session('status')" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="kt-form-label font-normal text-mono">Email</label>
                        <input class="kt-input" aria-invalid="true" placeholder="email@email.com" type="text" value="{{ old('email') }}" required>
                    </div>
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center justify-between gap-1">
                            <label class="kt-form-label font-normal text-mono">
                                Password
                            </label>
                            <a class="text-sm kt-link shrink-0" href="html/demo1/authentication/classic/reset-password/enter-email.html">
                                Forgot Password?
                            </a>
                        </div>
                        <div class="kt-input" data-kt-toggle-password="true">
                            <input name="user_password" placeholder="Enter Password" type="password" value="" required>
                            <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                                <span class="kt-toggle-password-active:hidden">
                                    <i class="ki-filled ki-eye text-muted-foreground"></i>
                                </span>
                                <span class="hidden kt-toggle-password-active:block">
                                    <i class="ki-filled ki-eye-slash text-muted-foreground"></i>
                                </span>
                            </button>
                        </div>
                    </div>
                    <label class="kt-label">
                        <input class="kt-checkbox kt-checkbox-sm" name="check" type="checkbox" value="1"/>
                        <span class="kt-checkbox-label">
                            Remember me
                        </span>
                    </label>
                    <button class="kt-btn kt-btn-primary flex justify-center grow">
                        Sign In
                    </button>
                </form>
            </div>
        </div>
        <!-- End of Page -->
        <!-- Scripts -->
        <script src="{{ asset('assets/js/core.bundle.js') }}"></script>
        <script src="{{ asset('assets/vendors/ktui/ktui.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
        <!-- End of Scripts -->

        <!-- Theme Mode -->
        <script>
            const defaultThemeMode = 'light'; // light|dark|system
            let themeMode;

            if (document.documentElement) {
                if (localStorage.getItem('kt-theme')) {
                    themeMode = localStorage.getItem('kt-theme');
                } else if (
                    document.documentElement.hasAttribute('data-kt-theme-mode')
                ) {
                    themeMode =
                        document.documentElement.getAttribute('data-kt-theme-mode');
                } else {
                    themeMode = defaultThemeMode;
                }

                if (themeMode === 'system') {
                    themeMode = window.matchMedia('(prefers-color-scheme: dark)').matches
                        ? 'dark'
                        : 'light';
                }

                document.documentElement.classList.add(themeMode);
            }
        </script>
        <!-- End of Theme Mode -->
    </body>
</html>
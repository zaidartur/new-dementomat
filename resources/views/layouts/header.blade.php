<header class="kt-header fixed top-0 z-10 start-0 end-0 flex items-stretch shrink-0 bg-background" data-kt-sticky="true" data-kt-sticky-class="border-b border-border" data-kt-sticky-name="header" id="header">
    <!-- Container -->
    <div class="kt-container-fixed flex justify-between items-stretch lg:gap-4" id="headerContainer">
        <!-- Mobile Logo -->
        <div class="flex gap-2.5 lg:hidden items-center -ms-1">
            <a class="shrink-0" href="/">
                <img class="max-h-[25px] w-full" src="{{ route('logo') }}" />
            </a>
            <div class="flex items-center">
                <button class="kt-btn kt-btn-icon kt-btn-ghost" data-kt-drawer-toggle="#sidebar">
                    <i class="ki-filled ki-menu text-xl">
                    </i>
                </button>
            </div>
        </div>
        <!-- End of Mobile Logo -->

        <!--Megamenu Contaoner-->
        <div class="flex items-stretch single-tickers" id="megaMenuContainer">
            <div class="py-4 px-7 md:py-5 md:px-0 ticker-text">
                <label class="font-medium block md:hidden cursor-pointers">Si Demen Tomat Terasi</label>
                <label class="font-medium invisible md:visible cursor-pointers">Sistem Deteksi Dini dan Pemantauan Tuberkolosis Mandiri, Terpadu, dan Terintegrasi | </label>
                <label class="font-medium invisible md:visible cursor-pointers">
                    {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }} 
                    <span class="ticker-text" id="timer"></span>
                </label>
            </div>
        </div>
        <!--End of Megamenu Contaoner-->
        
        <!-- Topbar -->
        <div class="flex items-center gap-2.5">
            <!-- Search -->
            {{-- <button
                class="group kt-btn kt-btn-ghost kt-btn-icon size-9 rounded-full hover:bg-primary/10 hover:[&_i]:text-primary"
                data-kt-modal-toggle="#search_modal">
                <i class="ki-filled ki-magnifier text-lg group-hover:text-primary">
                </i>
            </button> --}}
            <!-- End of Search -->
            <!-- Chat -->
            {{-- <button
                class="kt-btn kt-btn-ghost kt-btn-icon size-9 rounded-full hover:bg-primary/10 hover:[&_i]:text-primary"
                data-kt-drawer-toggle="#chat_drawer">
                <i class="ki-filled ki-messages text-lg">
                </i>
            </button> --}}
            <!--Chat Drawer-->
            {{-- <div class="hidden kt-drawer kt-drawer-end card flex-col max-w-[90%] w-[450px] top-5 bottom-5 end-5 rounded-xl border border-border" data-kt-drawer="true" data-kt-drawer-container="body" id="chat_drawer">
                <div></div>
            </div> --}}
            <!--End of Chat Drawer-->
            <!-- End of Chat -->
            <!-- Apps -->
            {{-- <div data-kt-dropdown="true" data-kt-dropdown-offset="10px, 10px"
                data-kt-dropdown-offset-rtl="-10px, 10px" data-kt-dropdown-placement="bottom-end"
                data-kt-dropdown-placement-rtl="bottom-start">
                <button
                    class="kt-btn kt-btn-ghost kt-btn-icon size-9 rounded-full hover:bg-primary/10 hover:[&_i]:text-primary kt-dropdown-open:bg-primary/10 kt-dropdown-open:[&_i]:text-primary"
                    data-kt-dropdown-toggle="true">
                    <i class="ki-filled ki-element-11 text-lg">
                    </i>
                </button>
                <div class="kt-dropdown-menu p-0 w-screen max-w-[320px]" data-kt-dropdown-menu="true">
                    <div
                        class="flex items-center justify-between gap-2.5 text-xs text-secondary-foreground font-medium px-5 py-3 border-b border-b-border">
                        <span>
                            Apps
                        </span>
                        <span>
                            Enabled
                        </span>
                    </div>
                    <div class="flex flex-col kt-scrollable-y-auto max-h-[400px] divide-y divide-border">
                        <div class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5">
                            <div class="flex items-center flex-wrap gap-2">
                                <div
                                    class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-border size-10">
                                    <img alt="" class="size-6"
                                        src="{{ asset('assets/media/brand-logos/jira.svg') }}">
                                    </img>
                                </div>
                                <div class="flex flex-col">
                                    <a class="text-sm font-semibold text-mono hover:text-primary" href="#">
                                        Jira
                                    </a>
                                    <span class="text-xs font-medium text-secondary-foreground">
                                        Project
                                        management
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                                <input class="kt-switch" type="checkbox" value="1" />
                            </div>
                        </div>
                        <div class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5">
                            <div class="flex items-center flex-wrap gap-2">
                                <div
                                    class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-border size-10">
                                    <img alt="" class="size-6"
                                        src="{{ asset('assets/media/brand-logos/inferno.svg') }}">
                                    </img>
                                </div>
                                <div class="flex flex-col">
                                    <a class="text-sm font-semibold text-mono hover:text-primary" href="#">
                                        Inferno
                                    </a>
                                    <span class="text-xs font-medium text-secondary-foreground">
                                        Ensures
                                        healthcare app
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                                <input checked="" class="kt-switch" type="checkbox" value="1" />
                            </div>
                        </div>
                        <div class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5">
                            <div class="flex items-center flex-wrap gap-2">
                                <div
                                    class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-border size-10">
                                    <img alt="" class="size-6"
                                        src="{{ asset('assets/media/brand-logos/evernote.svg') }}" />
                                </div>
                                <div class="flex flex-col">
                                    <a class="text-sm font-semibold text-mono hover:text-primary" href="#">
                                        Evernote
                                    </a>
                                    <span class="text-xs font-medium text-secondary-foreground">
                                        Notes management
                                        app
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                                <input checked="" class="kt-switch" type="checkbox" value="1" />
                            </div>
                        </div>
                        <div class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5">
                            <div class="flex items-center flex-wrap gap-2">
                                <div
                                    class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-border size-10">
                                    <img alt="" class="size-6"
                                        src="{{ asset('assets/media/brand-logos/gitlab.svg') }}" />
                                </div>
                                <div class="flex flex-col">
                                    <a class="text-sm font-semibold text-mono hover:text-primary" href="#">
                                        Gitlab
                                    </a>
                                    <span class="text-xs font-medium text-secondary-foreground">
                                        DevOps platform
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                                <input class="kt-switch" type="checkbox" value="1" />
                            </div>
                        </div>
                        <div class="flex items-center justify-between flex-wrap gap-2 px-5 py-3.5">
                            <div class="flex items-center flex-wrap gap-2">
                                <div
                                    class="flex items-center justify-center shrink-0 rounded-full bg-accent/60 border border-border size-10">
                                    <img alt="" class="size-6"
                                        src="{{ asset('assets/media/brand-logos/google-webdev.svg') }}" />
                                </div>
                                <div class="flex flex-col">
                                    <a class="text-sm font-semibold text-mono hover:text-primary" href="#">
                                        Google webdev
                                    </a>
                                    <span class="text-xs font-medium text-secondary-foreground">
                                        Building web
                                        expierences
                                    </span>
                                </div>
                            </div>
                            <div class="flex items-center gap-2 lg:gap-5">
                                <input checked="" class="kt-switch" type="checkbox" value="1" />
                            </div>
                        </div>
                    </div>
                    <div class="grid p-5 border-t border-t-border">
                        <a class="kt-btn kt-btn-outline justify-center" href="#">
                            Go to Apps
                        </a>
                    </div>
                </div>
            </div> --}}
            <!-- End of Apps -->
            <!-- User -->
            <div class="shrink-0" data-kt-dropdown="true" data-kt-dropdown-offset="10px, 10px"
                data-kt-dropdown-offset-rtl="-20px, 10px" data-kt-dropdown-placement="bottom-end"
                data-kt-dropdown-placement-rtl="bottom-start" data-kt-dropdown-trigger="click">
                <div class="cursor-pointer shrink-0" data-kt-dropdown-toggle="true">
                    <img alt="" class="size-9 rounded-full border-2 border-green-500 shrink-0"
                        src="{{ asset('assets/media/avatars/300-2.png') }}" />
                </div>
                <div class="kt-dropdown-menu w-[250px]" data-kt-dropdown-menu="true">
                    <div class="flex items-center justify-between px-2.5 py-1.5 gap-1.5">
                        <div class="flex items-center gap-2">
                            <img alt="" class="size-9 shrink-0 rounded-full border-2 border-green-500"
                                src="{{ asset('assets/media/avatars/300-2.png') }}" />
                            <div class="flex flex-col gap-1.5">
                                <span class="text-sm text-foreground font-semibold leading-none">
                                    {{ Auth::user()->name }}
                                </span>
                                <a class="text-xs text-secondary-foreground hover:text-primary font-medium leading-none"
                                    href="javascript:void(0)">
                                    {{ Auth::user()->hasRole('user') ? 'Pengguna' : (Auth::user()->hasRole('faskes') ? 'admin ' . Auth::user()->level : Auth::user()->level) }}
                                </a>
                            </div>
                        </div>
                    </div>
                    <ul class="kt-dropdown-menu-sub">
                        <li>
                            <div class="kt-dropdown-menu-separator">
                            </div>
                        </li>
                        <li>
                            @hasanyrole(['user'])
                            <a class="kt-dropdown-menu-link" href="{{ route('profile.user') }}">
                                <i class="ki-filled ki-profile-circle"></i>
                                Profile Saya
                            </a>
                            @endhasanyrole
                            @hasanyrole(['admin', 'superadmin', 'faskes'])
                            <a class="kt-dropdown-menu-link" href="{{ route('profile') }}">
                                <i class="ki-filled ki-profile-circle"></i>
                                Profile Saya
                            </a>
                            @endhasanyrole
                        </li>
                        {{-- <li data-kt-dropdown="true" data-kt-dropdown-placement="right-start"
                            data-kt-dropdown-trigger="hover">
                            <button class="kt-dropdown-menu-toggle" data-kt-dropdown-toggle="true">
                                <i class="ki-filled ki-setting-2">
                                </i>
                                My Account
                                <span class="kt-dropdown-menu-indicator">
                                    <i class="ki-filled ki-right text-xs">
                                    </i>
                                </span>
                            </button>
                            <div class="kt-dropdown-menu w-[220px]" data-kt-dropdown-menu="true">
                                <ul class="kt-dropdown-menu-sub">
                                    <li>
                                        <a class="kt-dropdown-menu-link" href="#">
                                            <i class="ki-filled ki-coffee">
                                            </i>
                                            Get
                                            Started
                                        </a>
                                    </li>
                                    <li>
                                        <a class="kt-dropdown-menu-link" href="#">
                                            <i class="ki-filled ki-some-files">
                                            </i>
                                            My
                                            Profile
                                        </a>
                                    </li>
                                    <li>
                                        <a class="kt-dropdown-menu-link" href="#">
                                            <span class="flex items-center gap-2">
                                                <i class="ki-filled ki-icon">
                                                </i>
                                                Billing
                                            </span>
                                            <span class="ms-auto inline-flex items-center"
                                                data-kt-tooltip="true" data-kt-tooltip-placement="top">
                                                <i
                                                    class="ki-filled ki-information-2 text-base text-muted-foreground">
                                                </i>
                                                <span class="kt-tooltip" data-kt-tooltip-content="true">
                                                    Payment
                                                    and
                                                    subscription
                                                    info
                                                </span>
                                            </span>
                                        </a>
                                    </li>
                                    <li>
                                        <a class="kt-dropdown-menu-link" href="#">
                                            <i class="ki-filled ki-medal-star">
                                            </i>
                                            Security
                                        </a>
                                    </li>
                                    <li>
                                        <a class="kt-dropdown-menu-link" href="#">
                                            <i class="ki-filled ki-setting">
                                            </i>
                                            Members
                                            & Roles
                                        </a>
                                    </li>
                                    <li>
                                        <a class="kt-dropdown-menu-link" href="#">
                                            <i class="ki-filled ki-switch">
                                            </i>
                                            Integrations
                                        </a>
                                    </li>
                                    <li>
                                        <div class="kt-dropdown-menu-separator">
                                        </div>
                                    </li>
                                    <li>
                                        <a class="kt-dropdown-menu-link" href="#">
                                            <span class="flex items-center gap-2">
                                                <i class="ki-filled ki-shield-tick">
                                                </i>
                                                Notifications
                                            </span>
                                            <input checked="" class="ms-auto kt-switch" name="check"
                                                type="checkbox" value="1" />
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <li>
                            <a class="kt-dropdown-menu-link" href="https://devs.keenthemes.com">
                                <i class="ki-filled ki-message-programming">
                                </i>
                                Dev Forum
                            </a>
                        </li>
                        <li>
                            <div class="kt-dropdown-menu-separator">
                            </div>
                        </li> --}}
                    </ul>
                    <div class="px-2.5 pt-1.5 mb-2.5 flex flex-col gap-3.5">
                        <div class="flex items-center gap-2 justify-between">
                            <span class="flex items-center gap-2">
                                <i class="ki-filled ki-moon text-base text-muted-foreground">
                                </i>
                                <span class="font-medium text-2sm">
                                    Dark Mode
                                </span>
                            </span>
                            <input class="kt-switch" data-kt-theme-switch-state="dark"
                                data-kt-theme-switch-toggle="true" name="check" type="checkbox" value="1" />
                        </div>
                        <a class="kt-btn kt-btn-outline justify-center w-full" href="javascript:void(0)" onclick="__logout()">
                            Log out
                        </a>
                    </div>
                </div>
            </div>
            <!-- End of User -->
        </div>
        <!-- End of Topbar -->
    </div>
    <!-- End of Container -->
</header>
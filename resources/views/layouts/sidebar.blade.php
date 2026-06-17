<div class="kt-sidebar bg-background border-e border-e-border fixed top-0 bottom-0 z-20 hidden lg:flex flex-col items-stretch shrink-0 [--kt-drawer-enable:true] lg:[--kt-drawer-enable:false]" data-kt-drawer="true" data-kt-drawer-class="kt-drawer kt-drawer-start top-0 bottom-0" id="sidebar">
    {{-- Header --}}
    <div class="kt-sidebar-header hidden lg:flex items-center relative justify-between px-3 lg:px-6 shrink-0" id="sidebar_header">
        <a class="dark:hidden" href="#">
            {{-- <img class="default-logo min-h-[22px] max-w-none" src="{{ asset('assets/media/app/default-logo.svg') }}" />
            <img class="small-logo min-h-[22px] max-w-none" src="{{ asset('assets/media/app/mini-logo.svg') }}" /> --}}
            <img class="default-logo min-h-[22px] max-w-none max-h-[62px]" src="{{ route('logo') }}" />
            <img class="small-logo min-h-[22px] max-w-none max-h-[36px]" src="{{ route('logo') }}" />
        </a>
        <a class="hidden dark:block" href="#">
            {{-- <img class="default-logo min-h-[22px] max-w-none" src="{{ asset('assets/media/app/default-logo-dark.svg') }}" />
            <img class="small-logo min-h-[22px] max-w-none" src="{{ asset('assets/media/app/mini-logo.svg') }}" /> --}}
            <img class="default-logo min-h-[22px] max-w-none max-h-[62px]" src="{{ route('logo') }}" />
            <img class="small-logo min-h-[22px] max-w-none max-h-[36px]" src="{{ route('logo') }}" />
        </a>
        <button
            class="kt-btn kt-btn-outline kt-btn-icon size-[30px] absolute start-full top-2/4 -translate-x-2/4 -translate-y-2/4 rtl:translate-x-2/4"
            data-kt-toggle="body" data-kt-toggle-class="kt-sidebar-collapse" id="sidebar_toggle">
            <i
                class="ki-filled ki-black-left-line kt-toggle-active:rotate-180 transition-all duration-300 rtl:translate rtl:rotate-180 rtl:kt-toggle-active:rotate-0">
            </i>
        </button>
    </div>

    <div class="kt-sidebar-content flex grow shrink-0 py-5 pe-2" id="sidebar_content">
        <div class="kt-scrollable-y-hover grow shrink-0 flex ps-2 lg:ps-5 pe-1 lg:pe-3"
            data-kt-scrollable="true" data-kt-scrollable-dependencies="#sidebar_header"
            data-kt-scrollable-height="auto" data-kt-scrollable-offset="0px"
            data-kt-scrollable-wrappers="#sidebar_content" id="sidebar_scrollable">
            <!-- Sidebar Menu -->
            <div class="kt-menu flex flex-col grow gap-1" data-kt-menu="true" data-kt-menu-accordion-expand-all="false" id="sidebar_menu">
                <div class="kt-menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('dashboard') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-element-11 text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Dashboards
                        </span>
                    </a>
                </div>

                @can('view pengguna')
                <div class="kt-menu-item {{ request()->routeIs('pengguna') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('pengguna') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-people text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Pengguna
                        </span>
                    </a>
                </div>
                @endcan

                @canany(['view cek jantung lab', 'view cek jantung nonlab'])
                <div class="kt-menu-item pt-2.25 pb-px">
                    <span class="kt-menu-heading uppercase text-xs font-medium text-muted-foreground ps-[10px] pe-[10px]">
                        Cek Kesehatan Jantung
                        <i class="ki-filled ki-pulse text-xs"></i>
                    </span>
                </div>
                @endcanany
                @can('view cek jantung lab')
                <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('dashboard') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-tablet-ok text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Cek Dengan Hasil Lab
                        </span>
                    </a>
                </div>
                @endcan
                @can('view cek jantung nonlab')
                <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('dashboard') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-tablet-delete text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Cek Tanpa Hasil Lab
                        </span>
                    </a>
                </div>
                @endcan

                @canany(['view hasil skrining', 'view cek dahak', 'view pemantauan obat', 'user skrining'])
                <div class="kt-menu-item pt-2.25 pb-px">
                    <span
                        class="kt-menu-heading uppercase text-xs font-medium text-muted-foreground ps-[10px] pe-[10px]">
                        Penanganan TBC <i class="ki-filled ki-virus text-xs"></i>
                    </span>
                </div>
                @endcanany
                @can('user skrining')
                <div class="kt-menu-item {{ request()->routeIs('skrining.user') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('skrining.user') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-shield-tick text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Skrining TBC
                        </span>
                    </a>
                </div>
                @endcan
                @can('view hasil skrining')
                <div class="kt-menu-item {{ request()->routeIs('skrining') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('skrining') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-cheque text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Hasil Skrining TBC
                        </span>
                    </a>
                </div>
                @endcan
                @can('view cek dahak')
                <div class="kt-menu-item {{ request()->routeIs('dahak') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('dahak') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-test-tubes text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Cek Dahak (TCM)
                        </span>
                    </a>
                </div>
                @endcan
                @can('view pemantauan obat')
                <div class="kt-menu-item {{ request()->routeIs('obat') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('obat') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-capsule text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Pemantauan Obat
                        </span>
                    </a>
                </div>
                @endcan

                @canany(['view admin dan faskes', 'view profile', 'view parameter skrining', 'view slider', 'view video', 'view kontak'])
                <div class="kt-menu-item pt-2.25 pb-px">
                    <span
                        class="kt-menu-heading uppercase text-xs font-medium text-muted-foreground ps-[10px] pe-[10px]">
                        Pengaturan
                        <i class="ki-filled ki-setting-4 text-xs"></i>
                    </span>
                </div>
                @endcanany
                @can('view admin dan faskes')
                <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('dashboard') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-badge text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Admin & Faskes
                        </span>
                    </a>
                </div>
                @endcan
                @can('view profile')
                <div class="kt-menu-item {{ request()->routeIs('profile') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('profile') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-profile-circle text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Profile Aplikasi
                        </span>
                    </a>
                </div>
                @endcan
                @can('view kontak')
                <div class="kt-menu-item {{ request()->routeIs('kontak') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('kontak') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-address-book text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Contact Person
                        </span>
                    </a>
                </div>
                @endcan
                @can('view parameter skrining')
                <div class="kt-menu-item {{ request()->routeIs('params') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('params') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-data text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Parameter Skrining
                        </span>
                    </a>
                </div>
                @endcan
                @can('view role permission')
                <div class="kt-menu-item" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('dashboard') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-key-square text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Role & Permission
                        </span>
                    </a>
                </div>
                @endcan
                @can('view slider')
                <div class="kt-menu-item {{ request()->routeIs('slider') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('slider') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-slider-horizontal-2 text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Slider
                        </span>
                    </a>
                </div>
                @endcan
                @can('view video')
                <div class="kt-menu-item {{ request()->routeIs('video') ? 'active' : '' }}" data-kt-menu-item-toggle="accordion" data-kt-menu-item-trigger="click">
                    <a href="{{ route('video') }}" class="kt-menu-link gap-[10px] ps-[10px] pe-[10px] py-[6px] border border-transparent kt-menu-item-active:bg-accent/60 dark:menu-item-active:border-border kt-menu-item-active:rounded-lg hover:bg-accent/60 hover:rounded-lg" tabindex="0">
                        <span class="kt-menu-icon items-start text-muted-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary w-[20px]">
                            <i class="ki-filled ki-youtube text-lg"></i>
                        </span>
                        <span class="kt-menu-title text-sm font-medium text-foreground kt-menu-item-active:text-primary kt-menu-link-hover:!text-primary">
                            Youtube
                        </span>
                    </a>
                </div>
                @endcan

            </div>
            <!-- End of Sidebar Menu -->
        </div>
    </div>
</div>


{{-- bottom navbar for mobile user --}}
@hasrole('user')
    <nav class="lg:hidden fixed bottom-0 left-0 w-full bg-background border-t border-t-border z-[99] pb-safe shadow-[0_-4px_6px_-1px_rgba(0,0,0,0.05)]">
        <div class="grid grid-cols-4 h-16">
            
            <a href="{{ route('dashboard') }}" class="flex flex-col items-center justify-center w-full h-full transition {{ request()->routeIs('dashboard') ? 'text-primary' : 'text-muted-foreground hover:text-primary' }}">
                <i class="ki-filled ki-element-11 text-2xl mb-1"></i>
                <span class="text-[10px] font-medium">Beranda</span>
            </a>

            @can('user skrining')
            <a href="{{ route('skrining.user') }}" class="flex flex-col items-center justify-center w-full h-full transition {{ request()->routeIs('skrining.user') ? 'text-primary' : 'text-muted-foreground hover:text-primary' }}">
                <i class="ki-filled ki-shield-tick text-2xl mb-1"></i>
                <span class="text-[10px] font-medium">Skrining TBC</span>
            </a>
            @endcan

            {{-- @can('view hasil skrining')
            <a href="{{ route('skrining') }}" class="flex flex-col items-center justify-center w-full h-full transition {{ request()->routeIs('skrining') ? 'text-primary' : 'text-muted-foreground hover:text-primary' }}">
                <i class="ki-filled ki-cheque text-2xl mb-1"></i>
                <span class="text-[10px] font-medium">Hasil Skrining</span>
            </a>
            @endcan --}}

            <a href="{{ route('profile.user') }}" class="flex flex-col items-center justify-center w-full h-full transition {{ request()->routeIs('profile.user') ? 'text-primary' : 'text-muted-foreground hover:text-primary' }}">
                <i class="ki-filled ki-profile-circle text-2xl mb-1"></i>
                <span class="text-[10px] font-medium">Profil</span>
            </a>

            <a href="javascript:void(0)" class="flex flex-col items-center justify-center w-full h-full transition" onclick="__logout()">
                <i class="ki-filled ki-exit-right text-2xl mb-1"></i>
                <span class="text-[10px] font-medium">Logout</span>
            </a>

        </div>
    </nav>
@endrole
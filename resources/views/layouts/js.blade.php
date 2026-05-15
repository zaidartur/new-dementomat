<script src="{{ asset('assets/vendors/ktui/ktui.min.js') }}"></script>
<script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
{{-- <script src="{{ asset('assets/js/widgets/general.js') }}"></script> --}}
<script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>

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

    function __logout() {
        Swal.fire({
            title: 'Logout!',
            text: 'Anda ingin mengakhiri sesi ini?',
            icon: 'question',
            showDenyButton: true,
            denyButtonText: 'Batalkan',
            confirmButtonText: 'Konfirmasi',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('_islogout').submit()
            }
        })
    }
</script>
<!-- End of Theme Mode -->
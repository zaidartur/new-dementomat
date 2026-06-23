<!DOCTYPE html>
<html class="h-full" data-kt-theme="true" data-kt-theme-mode="light" dir="ltr" lang="en">
    <head>
        <title>Registrasi Pengguna | Si Demen Tomat Terasi</title>
    
        <meta charset="utf-8"/>
        <meta content="follow, index" name="robots"/>
        <link href="https://127.0.0.1:8001/metronic-tailwind-html/demo1/authentication/classic/sign-in/index.html" rel="canonical"/>
        <meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
        <meta content="Si Demen Tomat Terasi" name="description"/>
        <meta content="summary_large_image" name="twitter:card"/>
        <meta content="Si Demen Tomat Terasi" name="twitter:title"/>
        <meta content="Sistem deteksi dini" name="twitter:description"/>
        <meta content="{{ asset('assets/media/app/og-image.png') }}" name="twitter:image"/>
        <meta content="en_US" property="og:locale"/>
        <meta content="website" property="og:type"/>
        <meta content="Si Demen Tomat Terasi" property="og:title"/>
        <meta content="Sistem deteksi dini" property="og:description"/>
        <meta content="{{ asset('assets/media/app/og-image.png') }}" property="og:image"/>

        {{-- <link href="{{ asset('assets/media/app/apple-touch-icon.png') }}" rel="apple-touch-icon" sizes="180x180"/>
        <link href="{{ asset('assets/media/app/favicon-32x32.png') }}" rel="icon" sizes="32x32" type="image/png"/>
        <link href="{{ asset('assets/media/app/favicon-16x16.png') }}" rel="icon" sizes="16x16" type="image/png"/>
        <link href="{{ asset('assets/media/app/favicon.ico') }}" rel="shortcut icon"/> --}}

        <link href="{{ asset('assets/images/logos.png') }}" rel="apple-touch-icon" sizes="180x180" />
        <link href="{{ asset('assets/images/logos.png') }}" rel="icon" sizes="32x32" type="image/png" />
        <link href="{{ asset('assets/images/logos.png') }}" rel="icon" sizes="16x16" type="image/png" />
        <link href="{{ asset('assets/images/logos.png') }}" rel="shortcut icon" />

        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet"/>
        <link href="{{ asset('assets/vendors/apexcharts/apexcharts.css') }}" rel="stylesheet"/>
        <link href="{{ asset('assets/vendors/keenicons/styles.bundle.css') }}" rel="stylesheet"/>
        {{-- <link href="{{ asset('assets/css/styles.css') }}" rel="stylesheet"/> --}}

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
    <body class="antialiased flex text-base text-foreground bg-background h-auto md:h-full">
        <div class="flex items-center justify-center grow bg-center bg-no-repeat page-bg">
            <div class="kt-card w-full md:w-[870px]">
                <form action="{{ route('register') }}" class="kt-card-content kt-form flex flex-col gap-5 p-4 md:p-10" id="sign_in_form" method="POST">
                    @csrf
                    <div class="text-center mb-2.5">
                        <h3 class="text-lg font-medium text-mono leading-none mb-2.5">Registrasi Skrining Pengguna</h3>
                        <div class="flex items-center justify-center font-medium">
                            <span class="text-sm text-secondary-foreground me-1.5">
                                Si Demen Tomat Terasi
                            </span>
                        </div>
                        <x-auth-session-status class="mb-4" :status="session('status')" />

                        <div class="kt-alert kt-alert-light kt-alert-warning mt-5" id="alert_5">
                            <div class="kt-alert-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 16v-4"></path>
                                    <path d="M12 8h.01"></path>
                                </svg>
                            </div>
                            <div class="kt-alert-title">
                                Pastikan <strong>NIK</strong> Anda belum terdaftar.
                            </div>
                        </div>
                    </div>
                    <div>
                        <div id="stepper-root" data-kt-stepper="true">
                            <div class="kt-card">
                                <div class="kt-card-header h-auto px-10 py-5">
                                    <div data-kt-stepper-item="#stepper_1" class="active flex gap-2.5 items-center">
                                        <div class="shrink-0 rounded-full size-8 flex items-center justify-center text-sm font-semibold bg-muted text-muted-foreground kt-stepper-item-active:bg-primary kt-stepper-item-active:text-primary-foreground kt-stepper-item-completed:bg-green-500 kt-stepper-item-completed:text-white">
                                            <span data-kt-stepper-number="true" class="kt-stepper-item-completed:hidden">1</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check size-4 hidden kt-stepper-item-completed:inline" aria-hidden="true">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col gap-0.5">
                                            <h4 class="text-sm font-medium text-mono kt-stepper-item-completed:opacity-70">Langkah 1</h4>
                                            <span class="text-sm text-muted-foreground kt-stepper-item-completed:opacity-70">Data Diri</span>
                                        </div>
                                    </div>
                                    <div data-kt-stepper-item="#stepper_2" class="flex gap-2.5 items-center">
                                        <div class="shrink-0 rounded-full size-8 flex items-center justify-center text-sm font-semibold bg-muted text-muted-foreground kt-stepper-item-active:bg-primary kt-stepper-item-active:text-primary-foreground kt-stepper-item-completed:bg-green-500 kt-stepper-item-completed:text-white">
                                            <span data-kt-stepper-number="true" class="kt-stepper-item-completed:hidden">2</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check size-4 hidden kt-stepper-item-completed:inline" aria-hidden="true">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col gap-0.5">
                                            <h4 class="text-sm font-medium text-mono kt-stepper-item-completed:opacity-70">Langkah 2</h4>
                                            <span class="text-sm text-muted-foreground kt-stepper-item-completed:opacity-70">Data Akun</span>
                                        </div>
                                    </div>
                                    <div data-kt-stepper-item="#stepper_3" class="flex gap-2.5 items-center">
                                        <div class="shrink-0 rounded-full size-8 flex items-center justify-center text-sm font-semibold bg-muted text-muted-foreground kt-stepper-item-active:bg-primary kt-stepper-item-active:text-primary-foreground kt-stepper-item-completed:bg-green-500 kt-stepper-item-completed:text-white">
                                            <span data-kt-stepper-number="true" class="kt-stepper-item-completed:hidden">3</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-check size-4 hidden kt-stepper-item-completed:inline" aria-hidden="true">
                                                <path d="M20 6 9 17l-5-5"></path>
                                            </svg>
                                        </div>
                                        <div class="flex flex-col gap-0.5">
                                            <h4 class="text-sm font-medium text-mono kt-stepper-item-completed:opacity-70">Langkah 3</h4>
                                            <span class="text-sm text-muted-foreground kt-stepper-item-completed:opacity-70">Persetujuan</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-card-content px-5 py-5">
                                    <div class="" id="stepper_1">
                                        <div class="flex items-start justify-center text-lg font-semibold text-mono">
                                            <div class="px-3 py-3 w-[95%]">
                                                <div class="flex md:flex-row flex-col gap-4">
                                                    <div class="flex flex-col gap-1 kt-form-item mb-2 w-full">
                                                        <label class="kt-form-label font-normal text-mono mb-1">Nama Lengkap*</label>
                                                        <input class="kt-input" @error('nama') aria-invalid="true" @enderror placeholder="Masukkan nama" name="nama" type="text" maxlength="50" value="{{ old('nama') }}" autofocus required>
                                                        @error('nama')
                                                            <div class="kt-form-message">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="flex flex-col gap-1 kt-form-item mb-2 w-full">
                                                        <label class="kt-form-label font-normal text-mono mb-1">Tanggal Lahir*</label>
                                                        <input class="kt-input" @error('bod') aria-invalid="true" @enderror placeholder="Tanggal lahir" name="bod" type="date" max="{{ date('Y-m-d') }}" value="{{ old('bod') }}" required>
                                                        @error('bod')
                                                            <div class="kt-form-message">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="flex flex-col gap-1 kt-form-item mb-2">
                                                    <label class="kt-form-label font-normal text-mono mb-1">Alamat*</label>
                                                    <textarea name="alamat" id="alamat" class="kt-textarea" @error('alamat') aria-invalid="true" @enderror cols="30" rows="3" required placeholder="Tulis alamat disini..">{{ old('alamat') }}</textarea>
                                                    @error('alamat')
                                                        <div class="kt-form-message">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="flex md:flex-row flex-col gap-4">
                                                    <div class="flex flex-col gap-1 kt-form-item mb-2 w-full">
                                                        <label class="kt-form-label font-normal text-mono mb-1">Kecamatan*</label>
                                                        <select class="kt-select" data-kt-select="true" id="kecamatan" name="kecamatan" @error('kecamatan') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih Kecamatan..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' onchange="_mykec(this.value)" value="{{ old('kecamatan') }}" required>
                                                            @foreach ($kecs as $item)
                                                                <option value="{{ $item->kec_id }}">{{ $item->kec_name }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('kecamatan')
                                                            <div class="kt-form-message">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="flex flex-col gap-1 kt-form-item mb-2 w-full">
                                                        <label class="kt-form-label font-normal text-mono mb-1">Desa*</label>
                                                        <select class="kt-select" data-kt-select="true" id="desa" name="desa" @error('desa') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih Desa..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' value="{{ old('desa') }}" required>
                                                            <option value="">Pilih Kecamatan</option>
                                                        </select>
                                                        @error('desa')
                                                            <div class="kt-form-message">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="flex md:flex-row flex-col gap-4">
                                                    <div class="flex flex-col gap-1 kt-form-item mb-2 w-full">
                                                        <label class="kt-form-label font-normal text-mono mb-1">Jenis Kelamin*</label>
                                                        <select class="kt-select" data-kt-select="true" id="jenkel" name="jenkel" @error('jenkel') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih Jenis Kelamin..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' value="{{ old('jenkel') }}" required>
                                                            <option value="L">Laki-Laki</option>
                                                            <option value="P">Perempuan</option>
                                                        </select>
                                                        @error('jenkel')
                                                            <div class="kt-form-message">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="flex flex-col gap-1 kt-form-item mb-2 w-full">
                                                        <label class="kt-form-label font-normal text-mono mb-1">Status Keluarga*</label>
                                                        {{-- <input class="kt-input" @error('status') aria-invalid="true" @enderror placeholder="Ayah/Ibu/Anak/dll" name="status" type="text" maxlength="50" value="{{ old('status') }}" required> --}}
                                                        <select class="kt-select" data-kt-select="true" id="status" name="status" @error('status') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih status keluarga..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' value="{{ old('status') }}" required>
                                                            @foreach ($status as $item)
                                                                <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('status')
                                                            <div class="kt-form-message">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="flex md:flex-row flex-col gap-4">
                                                    <div class="flex flex-col gap-1 kt-form-item mb-2 w-full">
                                                        <label class="kt-form-label font-normal text-mono mb-1">No. Telepon*</label>
                                                        <input class="kt-input" @error('telepon') aria-invalid="true" @enderror placeholder="628xxx" name="telepon" type="number" value="{{ old('telepon') }}" required>
                                                        @error('telepon')
                                                            <div class="kt-form-message">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                    <div class="flex flex-col gap-1 kt-form-item mb-2 w-full">
                                                        <label class="kt-form-label font-normal text-mono mb-1">Faskes*</label>
                                                        <select class="kt-select" data-kt-select="true" id="faskes" name="faskes" aria-invalid="true" @error('faskes') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih Faskes..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                                            @foreach ($faskes as $item)
                                                                <option value="{{ $item->faskes_id }}">{{ $item->nama_faskes }}</option>
                                                            @endforeach
                                                        </select>
                                                        @error('faskes')
                                                            <div class="kt-form-message">
                                                                <strong>{{ $message }}</strong>
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden" id="stepper_2">
                                        <div class="flex items-center justify-center text-lg font-semibold text-mono">
                                            <div class="px-3 py-3 w-[95%]">
                                                <div class="flex flex-col gap-1 kt-form-item mb-2">
                                                    <label class="kt-form-label font-normal text-mono mb-1">Nomor Induk Keluarga* <small>(16 digit)</small></label>
                                                    <input class="kt-input" @error('nik') aria-invalid="true" @enderror placeholder="Masukkan NIK" name="nik" type="number" value="{{ old('nik') }}" required>
                                                    @error('nik')
                                                        <div class="kt-form-message">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="flex flex-col gap-1 kt-form-item mb-2">
                                                    <label class="kt-form-label font-normal text-mono mb-1">Email <small>(opsional)</small></label>
                                                    <input class="kt-input" @error('email') aria-invalid="true" @enderror placeholder="email@email.com" name="email" type="email" value="{{ old('email') }}">
                                                    @error('email')
                                                        <div class="kt-form-message">
                                                            <strong>{{ $message }}</strong>
                                                        </div>
                                                    @enderror
                                                </div>
                                                <div class="flex flex-col gap-1 kt-form-item mb-2">
                                                    <div class="flex items-center justify-between gap-1">
                                                        <label class="kt-form-label font-normal text-mono">
                                                            Password*
                                                        </label>
                                                    </div>
                                                    <div class="kt-input" data-kt-toggle-password="true">
                                                        <input placeholder="Masukkan Password" type="password" name="password" value="" required>
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
                                                <div class="flex flex-col gap-1 kt-form-item mb-2">
                                                    <div class="flex items-center justify-between gap-1">
                                                        <label class="kt-form-label font-normal text-mono">
                                                            Konfirmasi Password*
                                                        </label>
                                                    </div>
                                                    <div class="kt-input" data-kt-toggle-password="true">
                                                        <input placeholder="Masukkan Konfirmasi Password" type="password" name="password_confirmation" value="" required>
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="hidden" id="stepper_3">
                                        <div class="flex items-center justify-center text-lg font-semibold text-mono">
                                            <div class="mt-10 mb-10">
                                                <div class="bg-slate-50 border border-slate-200 rounded-xl p-5 shadow-inner">
                                                    <div class="flex items-center gap-2 mb-3">
                                                        <i class="ki-filled ki-shield-tick text-lg"></i>
                                                        <h4 class="text-sm font-bold text-slate-800">Persetujuan Layanan & Privasi Data</h4>
                                                    </div>
                                                    
                                                    <div class="flex flex-col text-xs text-slate-600 space-y-2 h-48 overflow-y-auto pr-2 custom-scrollbar">
                                                        <div class="flex flex-row gap-2">
                                                            <div class="col-2">
                                                                <strong>1.</strong>
                                                            </div>
                                                            <div class="col-10">
                                                                <p>
                                                                    <strong>Diagnosis Pengganti Dokter:</strong> Sistem ini adalah alat bantu penapisan (skrining) awal risiko medis. Hasil dari aplikasi ini bukanlah diagnosis mutlak. Penegakan diagnosis hanya dapat dilakukan melalui pemeriksaan laboratorium di fasilitas kesehatan.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-row gap-3">
                                                            <div class="col-2">
                                                                <strong>2.</strong>
                                                            </div>
                                                            <div class="col-10">
                                                                <p>
                                                                    <strong>Kerahasiaan Data:</strong> Data kependudukan (NIK) dan riwayat gejala Anda dijamin kerahasiaannya dan hanya akan diakses oleh petugas kesehatan/Puskesmas resmi di wilayah kabupaten untuk keperluan tindak lanjut medis.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-row gap-3">
                                                            <div class="col-2">
                                                                <strong>3.</strong>
                                                            </div>
                                                            <div class="col-10">
                                                                <p>
                                                                    <strong>Kejujuran Informasi:</strong> Anda setuju untuk memberikan jawaban kuesioner dengan jujur dan sebenar-benarnya demi ketepatan identifikasi kesehatan bersama.
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="flex flex-row gap-3">
                                                            <div class="col-2">
                                                                <strong>4.</strong>
                                                            </div>
                                                            <div class="col-10">
                                                                <p>
                                                                    <strong>Tindakan Darurat:</strong> Jika Anda saat ini mengalami sesak napas akut atau batuk darah masif, mohon hentikan pengisian dan segera menuju IGD Rumah Sakit terdekat.
                                                                </p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <label class="flex items-start gap-3 mt-4 cursor-pointer group">
                                                    <div class="flex items-center h-5">
                                                        <input type="checkbox" name="syarat_ketentuan" required class="kt-checkbox cursor-pointer hover:border-blue-600 transition" id="syarat" value="accept" required>
                                                        <label for="syarat" class="kt-label cursor-pointer hover:text-blue-600" for="check"> &nbsp;
                                                            Saya telah membaca, memahami, dan menyetujui pernyataan kerahasiaan medis di atas.
                                                        </label>
                                                    </div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-card-footer justify-between p-5">
                                    <div>
                                        <button class="kt-btn kt-btn-secondary kt-stepper-first:hidden" data-kt-stepper-back="true">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-left" aria-hidden="true">
                                                <path d="m12 19-7-7 7-7"></path>
                                                <path d="M19 12H5"></path>
                                            </svg>
                                            Kembali
                                        </button>
                                    </div>
                                    <div>
                                        <button type="button" id="main-stepper-next" class="kt-btn kt-btn-secondary kt-stepper-last:hidden" data-kt-stepper-next="true">
                                            Selanjutnya
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-arrow-right" aria-hidden="true">
                                                <path d="M5 12h14"></path>
                                                <path d="m12 5 7 7-7 7"></path>
                                            </svg>
                                        </button>
                                        <button type="button" class="kt-btn hidden kt-stepper-last:inline-flex" id="btn-konfirmasi">
                                            <i class="ki-filled ki-check-circle text-lg"></i>
                                            Konfirmasi
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- End of Page -->
        <!-- Scripts -->
        {{-- <script src="{{ asset('assets/js/core.bundle.js') }}"></script> --}}
        <script src="{{ asset('assets/vendors/ktui/ktui.min.js') }}"></script>
        <script src="{{ asset('assets/vendors/apexcharts/apexcharts.min.js') }}"></script>
        <script src="https://code.jquery.com/jquery-4.0.0.min.js" integrity="sha256-OaVG6prZf4v69dPg6PhVattBXkcOWQB62pdZ3ORyrao=" crossorigin="anonymous"></script>
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

        <script>
            (function () {
                function init() {
                    var root = document.getElementById("stepper-root")
                    var form = document.getElementById("sign_in_form")
                    var checkboxSyarat = document.getElementById("syarat")
                    var btnNext = document.getElementById("main-stepper-next")
                    var btnKonfirmasi = document.getElementById("btn-konfirmasi")

                    if (!root || !KTStepper) return
                    if (root.getAttribute("data-stepper-init") === "1") return
                    root.setAttribute("data-stepper-init", "1")

                    var stepper = KTStepper.getOrCreateInstance(root)
                    var currentActiveIndex = 1;
                    form.addEventListener("keydown", function (e) {
                        // Jika yang ditekan adalah tombol Enter (keyCode 13) dan bukan di area TEXTAREA
                        if (e.key === "Enter" || e.keyCode === 13) {
                            if (e.target.nodeName !== "TEXTAREA") {
                                e.preventDefault()
                                return false
                            }
                        }
                    })

                    // stepper.on("kt.stepper.next", function (instance) {
                    //     // Get current active step index from Metronic instance
                    //     var currentIndex = stepper.getIndex()
                    //     console.log(instance)
                        
                    //     // Target the current active step container (#stepper_1, #stepper_2)
                    //     var currentStepId = "#stepper_" + currentIndex;
                    //     var currentStepEl = document.querySelector(currentStepId);
                        
                    //     if (currentStepEl) {
                    //         var inputs = currentStepEl.querySelectorAll("input[required], textarea[required], select[required]")
                    //         var stepIsValid = true
                    //         console.log(inputs)

                    //         inputs.forEach(function (input) {
                    //             if (!input.checkValidity()) {
                    //                 stepIsValid = false;
                    //                 input.reportValidity(); // Show native browser error popup
                    //             }
                    //         });

                    //         // If any input is invalid, freeze Metronic from changing steps!
                    //         if (!stepIsValid) {
                    //             stepper.preventDefault(); 
                    //             return false;
                    //         }
                    //     }
                    // })

                    if (btnNext) {
                        // Mousedown fires BEFORE the click event bubbles up to Metronic's engine
                        btnNext.addEventListener("mousedown", function () {
                            var currentStepId = "#stepper_" + currentActiveIndex;
                            var currentStepEl = document.querySelector(currentStepId);
                            
                            if (currentStepEl) {
                                var inputs = currentStepEl.querySelectorAll("input[required], textarea[required], select[required]");
                                var stepIsValid = true;

                                inputs.forEach(function (input) {
                                    var isHidden = input.offsetWidth === 0 && input.offsetHeight === 0;
                                    if (isHidden) {
                                        // Validasi Manual untuk <select> yang disembunyikan template
                                        if (!input.value || input.value.trim() === "") {
                                            stepIsValid = false;
                                            
                                            // Cari label terdekat untuk memberikan informasi konteks error ke pengguna
                                            var labelNode = input.closest('.kt-form-item')?.querySelector('label');
                                            var labelText = labelNode ? labelNode.innerText : "Kolom pilihan";
                                            console.log('label', labelNode)
                                            
                                            // Opsional: Beri border merah pada pembungkus komponen select biar estetik
                                            var selectWrapper = input.closest('.kt-form-item');
                                            if (selectWrapper) {
                                                selectWrapper.classList.add('border', 'border-destructive', 'rounded-lg', 'p-1');
                                            }

                                            _swal_alert('error', 'Mohon untuk mengisi kolom yang wajib diisi.')
                                        } else {
                                            // Bersihkan border merah jika sudah diisi
                                            var selectWrapper = input.closest('.kt-form-item');
                                            if (selectWrapper) {
                                                selectWrapper.classList.remove('border', 'border-destructive', 'rounded-lg', 'p-1');
                                            }
                                        }
                                    } else {
                                        if (!input.checkValidity()) {
                                            document.getElementsByName(input.name)[0].setAttribute('aria-invalid', 'true')
                                            stepIsValid = false;
                                            input.reportValidity() // Fire browser validation popover
                                        } else {
                                            document.getElementsByName(input.name)[0].removeAttribute('aria-invalid')
                                            // console.log('else', input.name)
                                        }
                                    }
                                });

                                if (!stepIsValid) {
                                    // Strip the attribute! Metronic will see a plain button and do nothing.
                                    btnNext.removeAttribute("data-kt-stepper-next");
                                } else {
                                    // Inputs are clean! Give the attribute back so Metronic processes the step change.
                                    btnNext.setAttribute("data-kt-stepper-next", "true");
                                }
                            }
                        });

                        // Update our manual index tracker when a successful step navigation happens
                        btnNext.addEventListener("click", function () {
                            // Only increment if the attribute was present (meaning it passed validation)
                            if (btnNext.hasAttribute("data-kt-stepper-next")) {
                                currentActiveIndex++;
                            } else {
                                _swal_alert('error', 'Mohon untuk mengisi kolom yang wajib diisi.')
                                stepper.go(currentActiveIndex)
                            }
                        });
                    }

                    // if (btnNext) {
                    //     // Buat variabel manual untuk mencatat langkah aktif (Metronic mulai dari langkah 1)
                    //     var currentActiveIndex = 1; 

                    //     btnNext.addEventListener("click", function (e) {
                    //         e.preventDefault()
                    //         e.stopPropagation()
                            
                    //         // Tentukan selector kontainer berdasarkan index langkah saat ini
                    //         var currentStepId = "#stepper_" + currentActiveIndex;
                    //         var currentStepEl = document.querySelector(currentStepId);
                            
                    //         if (currentStepEl) {
                    //             // Cari semua input wajib di langkah aktif saat ini
                    //             var inputs = currentStepEl.querySelectorAll("input[required], textarea[required], select[required]");
                    //             var stepIsValid = true;

                    //             inputs.forEach(function (input) {
                    //                 // console.log('inp', input, input.checkValidity())
                    //                 if (!input.checkValidity()) {
                    //                     console.log('is false')
                    //                     stepIsValid = false;
                    //                     // input.reportValidity() // Munculkan popover error bawaan browser
                    //                 }
                    //             });

                    //             // JIKA VALID, baru izinkan Metronic pindah ke langkah berikutnya
                    //             if (stepIsValid) {
                    //                 console.log('is valid')
                    //                 stepper.goNext();
                    //                 currentActiveIndex++; // Naikkan state langkah aktif
                    //             } else {
                    //                 console.log('is invalid')
                    //                 return false
                    //             }
                    //         }
                    //     });

                    //     // Pastikan jika user klik tombol kembali (Back), state manual kita juga berkurang
                    //     root.querySelectorAll("[data-kt-stepper-back='true']").forEach(function (button) {
                    //         button.addEventListener("click", function (e) {
                    //             e.preventDefault();
                    //             stepper.goBack();
                    //             if (currentActiveIndex > 1) {
                    //                 currentActiveIndex--; // Turunkan state langkah aktif
                    //             }
                    //         });
                    //     });
                    // }

                    if (checkboxSyarat && btnKonfirmasi) {
                        function toggleConfirmButton() {
                            if (checkboxSyarat.checked) {
                                btnKonfirmasi.removeAttribute("disabled")
                                btnKonfirmasi.classList.remove("opacity-50", "cursor-not-allowed")
                            } else {
                                btnKonfirmasi.setAttribute("disabled", "disabled")
                                btnKonfirmasi.classList.add("opacity-50", "cursor-not-allowed")
                            }
                        }

                        toggleConfirmButton()
                        checkboxSyarat.addEventListener("change", toggleConfirmButton)
                    }

                    if (btnKonfirmasi) {
                        btnKonfirmasi.addEventListener("click", function (e) {
                            e.preventDefault()

                            // Cek kembali validitas seluruh form (keamanan tambahan)
                            if (!form.checkValidity()) {
                                form.reportValidity()
                                return
                            }

                            // Nonaktifkan tombol agar tidak terjadi double-click / multiple request
                            btnKonfirmasi.setAttribute("disabled", "disabled")
                            btnKonfirmasi.innerHTML = '<i class="animate-spin ki-filled ki-loading text-lg"></i> Menyimpan...'

                            // Ambil data form dan URL action
                            var formData = $(form).serialize()
                            var formAction = $(form).attr("action")
                            form.submit()

                            // Kirim data via jQuery AJAX
                            // $.ajax({
                            //     url: formAction,
                            //     type: "POST",
                            //     data: formData,
                            //     dataType: "JSON",
                            //     success: function (response) {
                            //         // Handler jika sukses (Contoh: Menggunakan SweetAlert atau redirect)
                            //         alert("Registrasi Berhasil!")
                            //         if (response.redirect_url) {
                            //             location.href = response.redirect_url
                            //         } else {
                            //             location.reload()
                            //         }
                            //     },
                            //     error: function (xhr) {
                            //         // Handler jika terjadi error (validasi Laravel gagal, dsb)
                            //         btnKonfirmasi.removeAttribute("disabled")
                            //         btnKonfirmasi.innerHTML = '<i class="ki-filled ki-check-circle text-lg"></i> Konfirmasi'
                                    
                            //         if (xhr.status === 422) {
                            //             var errors = xhr.responseJSON.errors
                            //             alert("Validasi Gagal: " + Object.values(errors).map(e => e[0]).join("\n"))
                            //         } else {
                            //             alert("Terjadi kesalahan sistem. Silakan coba lagi.")
                            //         }
                            //     }
                            // })
                        })
                    }

                    // root.querySelectorAll("[data-stepper-go]").forEach(function (button) {
                    //     button.addEventListener("click", function () {
                    //         var step = button.getAttribute("data-stepper-go")
                    //         if (!step) return
                    //         stepper.go(parseInt(step, 10))
                    //     })
                    // })

                    root.querySelectorAll("[data-kt-stepper-back='true']").forEach(function (button) {
                        button.addEventListener("click", function (e) {
                            e.preventDefault()
                            stepper.goBack()
                        })
                    })
                }

                function schedule() {
                    if (document.readyState === "loading") {
                        document.addEventListener("DOMContentLoaded", init)
                    } else if (KTStepper) {
                        setTimeout(init, 0)
                    } else {
                        window.addEventListener("load", init)
                    }
                }

                schedule()
            })()

            function _swal_alert(icon, title) {
                Swal.mixin({
                    toast: true,
                    position: "top-end",
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.onmouseenter = Swal.stopTimer;
                        toast.onmouseleave = Swal.resumeTimer;
                    }
                }).fire({
                    icon: icon,
                    title: title
                })
            }

            function _mykec(id) {
                $.ajax({
                    url: 'data-desa-kecamatan/' + id,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(res) {
                        $('#desa').html('')
                        let opt = ''
                        res.data.forEach(dt => {
                            opt += `<option value="${dt.desakel_id}">${dt.desakel_name}</option>`
                        })
                        $('#desa').html(opt)
                        const selectElement = document.querySelector('#desa')
                        const instance = KTSelect.getInstance(selectElement) ?? KTSelect.getOrCreateInstance(selectElement)
                        instance.setSelectedOptions([])
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                        _swal_alert('error', xhr.responseJSON.message)
                    }
                })
            }

            @if (session('error'))
                setTimeout(() => {
                    _swal_alert('error', "{{ session('error') }}")
                }, 1000);
            @endif

            @if (session('success'))
                setTimeout(() => {
                    _swal_alert('success', "{{ session('success') }}")
                }, 1000);
            @endif
        </script>
    </body>
</html>
@extends('layouts.layout')

@section('title', 'Profile Saya')

@section('css')
    
@endsection



@section('content')
<div class="kt-container-fixed">
     <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
          <div class="flex flex-col justify-center gap-2">
               <h1 class="text-xl font-medium leading-none text-mono">
                    <i class="ki-filled ki-profile-circle text-lg"></i>
                    Profile
               </h1>
               <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Data profile <b>{{ Auth::user()->name }}</b>.
               </div>
          </div>
     </div>
</div>

<div class="kt-container-fixed">
    <form class="kt-form" id="form_profile" action="{{ route('profile.admin.save') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <input type="hidden" id="uid" name="uid" value="{{ $profile->uuid ?? '' }}">
        <div class="grid w-full space-y-5">
            <div class="kt-card">
                <div class="kt-card-header min-h-16">
                    <h1 class="font-medium text-lg">
                        Profile {{ $profile->level == 'faskes' ? 'Faskes' : 'Admin' }}
                    </h1>
                </div>
                <div class="kt-card-content">

                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Nama {{ $profile->level == 'faskes' ? 'Faskes' : 'Admin' }}* :</label>
                        <div class="kt-form-control">
                            <div class="kt-input" @error('nama') aria-invalid="true" @enderror>
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="text" class="kt-input" id="nama" name="nama" placeholder="Nama Lengkap" maxlength="50" value="{{ $profile->name }}" required autofocus />
                            </div>
                        </div>
                        <div class="kt-form-message">Mohon mengisi nama {{ $profile->level == 'faskes' ? 'faskes' : 'admin' }}.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Email {{ $profile->level == 'faskes' ? 'Faskes' : 'Admin' }} (opsional) :</label>
                        <div class="kt-form-control">
                            <div class="kt-input" @error('email') aria-invalid="true" @enderror>
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="email" class="kt-input" id="email" name="email" placeholder="mail@mail.com" maxlength="150" value="{{ $profile->email }}" />
                            </div>
                        </div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Gambar profile (opsional) :</label>
                        <div class="kt-image-input inline-flex flex-col size-32 gap-3 rounded-lg" data-kt-image-input="true">
                            <input type="file" accept=".png, .jpg, .jpeg" id="gambar" name="gambar" onchange="_verify_image(this.value)" />
                            <input type="hidden" name="cover_remove" />
                            <div class="relative size-32">
                                <button type="button" data-kt-tooltip="true" data-kt-tooltip-trigger="hover" data-kt-tooltip-placement="top" data-kt-image-input-remove="true" class="kt-image-input-remove">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true"><path d="M18 6 6 18"></path><path d="m6 6 12 12"></path></svg>
                                    <span data-kt-tooltip-content="true" class="kt-tooltip">Hapus atau kembalikan gambar</span>
                                </button>
                                <div data-kt-image-input-placeholder="true" class="kt-image-input-placeholder rounded-lg" style="background-image: url({{ asset('assets/media/avatars/blank.png') }})">
                                    <div data-kt-image-input-preview="true" class="kt-image-input-preview rounded-lg" {!! !empty($images) ? "style='background-image: url($images)'" : "" !!}></div>
                                    <div class="flex items-center justify-center cursor-pointer h-6 left-0 right-0 bottom-0 bg-black/30 absolute rounded-b-lg">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw size-3.5 text-white opacity-90" aria-hidden="true"><path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path><path d="M3 3v5h5"></path></svg>
                                    </div>
                                </div>
                            </div>
                            <div class="flex flex-wrap gap-2 text-xs">
                                <span class="inline-flex items-center gap-1 rounded-md border border-border px-2 py-1 kt-image-input-changed:hidden kt-image-input-empty:hidden">
                                    <span class="size-2 rounded-full bg-muted-foreground/40"></span>
                                        Gambar preview
                                    </span>
                                <span class="hidden items-center gap-1 rounded-md border border-border px-2 py-1 kt-image-input-changed:inline-flex">
                                    <span class="size-2 rounded-full bg-primary"></span>
                                    Gambar berubah
                                </span>
                                <span class="hidden items-center gap-1 rounded-md border border-border px-2 py-1 kt-image-input-empty:inline-flex">
                                    <span class="size-2 rounded-full bg-muted-foreground"></span>
                                    Kosong
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="rounded-[15px] border border-gray-500 bg-orange-500 px-5">
                        <div class="mb-5 mt-5">
                            <label class="kt-form-label">Isilah kolom dibawah apabila Anda ingin mengganti password login.</label>
                        </div>
                        
                        <div class="flex flex-row flex-wrap w-full gap-4 mb-5 justify-evenly">
                            <div class="flex flex-col gap-1 kt-form-item w-full md:w-[45%]">
                                <div class="flex items-center justify-between gap-1">
                                    <label class="kt-form-label">Password {{ $profile->level == 'faskes' ? 'Faskes' : 'Admin' }} :</label>
                                </div>
                                <div class="kt-input bg-orange-300 dark:bg-orange-200" data-kt-toggle-password="true">
                                    <input placeholder="Masukkan Password Baru" type="password" id="password" name="password" maxlength="50" class="dark:text-gray-800" value="">
                                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                                        <span class="kt-toggle-password-active:hidden">
                                            <i class="ki-filled ki-eye text-muted-foreground dark:text-gray-800"></i>
                                        </span>
                                        <span class="hidden kt-toggle-password-active:block">
                                            <i class="ki-filled ki-eye-slash text-muted-foreground dark:text-gray-800"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <div class="flex flex-col gap-1 kt-form-item w-full md:w-[45%]">
                                <div class="flex items-center justify-between gap-1">
                                    <label class="kt-form-label">Konfirmasi Password {{ $profile->level == 'faskes' ? 'Faskes' : 'Admin' }} :</label>
                                </div>
                                <div class="kt-input bg-orange-300 dark:bg-orange-200" data-kt-toggle-password="true">
                                    <input placeholder="Masukkan Konfirmasi Password Baru" type="password" id="password_confirmation" name="password_confirmation" maxlength="50" class="dark:text-gray-800" value="">
                                    <button class="kt-btn kt-btn-sm kt-btn-ghost kt-btn-icon bg-transparent! -me-1.5" data-kt-toggle-password-trigger="true" type="button">
                                        <span class="kt-toggle-password-active:hidden">
                                            <i class="ki-filled ki-eye text-muted-foreground dark:text-gray-800"></i>
                                        </span>
                                        <span class="hidden kt-toggle-password-active:block">
                                            <i class="ki-filled ki-eye-slash text-muted-foreground dark:text-gray-800"></i>
                                        </span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="w-full mt-10">
            <button type="submit" id="btn_save" class="kt-btn kt-btn-primary w-full md:w-[30%] rounded-full text-lg md:text-sm p-7 md:p-2">
                <i class="ki-filled ki-user-tick text-xl md:text-lg"></i>
                Simpan Profile
            </button>
        </div>
    </form>
</div>
@endsection


@section('js')
<script>
    $(document).ready(function() {
        $('#form_profile').on('submit', function (e) {
            e.preventDefault()
            
            const name = $('#nama').val()
            const mail = $('#email').val()
            const pass = $('#password').val()
            const cpass= $('#password_confirmation').val()

            if (!name) return

            let isValid = true
            if (isValid) {
                this.submit();
            }
        })
    })

    function _verify_image(val) {
        if (val) {
            $('#alert_image').addClass('hidden')
        } else {
            $('#alert_image').removeClass('hidden')
        }
    }
</script>
@endsection
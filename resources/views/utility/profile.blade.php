@extends('layouts.layout')

@section('title', 'Profile Aplikasi')


@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-profile-circle text-lg"></i>
                Profile Aplikasi
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                Ubah data profile
            </div>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="grid w-full space-y-5">
        <div class="rounded-lg w-full grow">
            <div class="p-2 flex justify-center">
                <div class="w-full max-h-[450vh] flex flex-col rounded-xl border border-slate-200 overflow-hidden transform scale-100 transition-all">
                    <div class="flex-1 overflow-y-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-1 border-b md:border-b-0 md:border-r border-slate-300 pb-6 md:pb-0 md:pr-6">
                            <h4 class="text-lg font-bold uppercase tracking-wider text-slate-400 mb-4">Profile Aplikasi</h4>            
                            <div class="space-y-4">
                                <div>
                                    <img src="{{ route('logo') }}" alt="Logo" class="max-h-[250px] text-center">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400">Nama Aplikasi</label>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $profile->nama }}</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400">Deskripsi</label>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $profile->deskripsi ?? '-' }}</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400">Alamat</label>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $profile->alamat ?? '-' }}</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400">No. Telepon</label>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $profile->telepon ?? '-' }}</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400">Email</label>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $profile->email ?? '-' }}</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400">Website Utama</label>
                                    <span class="block text-sm font-semibold text-slate-800 dark:text-slate-200 mt-0.5">{{ $profile->website ?? '-' }}</span>
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-slate-400">&nbsp;</label>
                                    <button class="kt-btn kt-btn-outline kt-btn-primary mt-0.5" onclick="_edit()">
                                        <i class="ki-filled ki-message-edit text-sm"></i>
                                        Edit Profile
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-span-2 space-y-5">
                            <div>
                                <h4 class="text-lg font-bold uppercase tracking-wider text-slate-400 mb-3">Riwayat Akses</h4>
                                <div class="flex flex-col overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-200 [&::-webkit-scrollbar-thumb]:rounded-full scroll-smooth max-h-[650px]">
                                    @foreach ($lists as $item)
                                    <div class="w-[100%] rounded-lg bg-slate-50 dark:bg-gray-800 p-4 border border-slate-100 flex items-start justify-between mb-5">
                                        <div>
                                            <span class="text-xs text-slate-400 dark:text-slate-200 block font-medium">
                                                {{ \Carbon\Carbon::createFromTimestamp($item->last_activity)->format('d-m-Y H:i:s') }}
                                            </span>
                                            <span class="text-sm font-bold mt-0.5 block">
                                                Login: {{ $item->name }} {{ !empty($item->email) ? ('(' . $item->email . ')') : '' }} &mdash; Role: {{ $item->level }}
                                                <br>
                                                <span class="text-xs font-medium mt-0.5 text-slate-500 dark:text-slate-200">
                                                    {{ $item->user_agent }} <br>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs text-slate-400 dark:text-slate-200 block font-medium">
                                                {{ $item->ip_address }}
                                            </span>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="kt-modal" data-kt-modal="true" id="modal_edit">
    <div class="kt-modal-content w-[500px] top-[5%]">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_edit">Edit Profile Aplikasi</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_three">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg w-full grow h-full">
                <div class="p-2">
                    <form method="POST" action="{{ route('profile.update') }}" id="form_edit" class="kt-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="uid" id="uid" value="{{ $profile->id }}">
                        <div class="kt-form-item">
                            <label class="kt-form-label">Nama Aplikasi* :</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-subtitle text-lg"></i>
                                    <input type="text" class="kt-input" id="nama" name="nama" placeholder="Nama Aplikasi" maxlength="100" value="{{ $profile->nama }}" required required data-kt-modal-input-focus="true" />
                                </div>
                            </div>
                        </div>
                        <div class="kt-form-item">
                            <label class="kt-form-label">Deskripsi Aplikasi* :</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-subtitle text-lg"></i>
                                    <input type="text" class="kt-input" id="deskripsi" name="deskripsi" placeholder="Deskripsi Aplikasi" maxlength="200" value="{{ $profile->deskripsi }}" required />
                                </div>
                            </div>
                        </div>
                        <div class="kt-form-item">
                            <label class="kt-form-label">Alamat Kantor* :</label>
                            <div class="kt-form-control">
                                {{-- <div class="kt-input">
                                    <i class="ki-filled ki-subtitle text-lg"></i>
                                    <input type="text" class="kt-input" id="alamat" name="alamat" placeholder="Alamat" maxlength="200" value="{{ $profile->alamat }}" required />
                                </div> --}}
                                <textarea name="alamat" id="alamat" class="kt-textarea" cols="30" rows="4">{{ $profile->alamat }}</textarea>
                            </div>
                        </div>
                        <div class="kt-form-item">
                            <label class="kt-form-label">No. Telepon :</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-phone text-lg"></i>
                                    <input type="number" class="kt-input" id="telepon" name="telepon" placeholder="628xxx" value="{{ $profile->telepon }}" />
                                </div>
                            </div>
                        </div>
                        <div class="kt-form-item">
                            <label class="kt-form-label">Email :</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-sms text-lg"></i>
                                    <input type="emil" class="kt-input" id="email" name="email" placeholder="mail@mail.com" maxlength="50" value="{{ $profile->email }}" />
                                </div>
                            </div>
                        </div>
                        <div class="kt-form-item">
                            <label class="kt-form-label">Website Utama :</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-fasten text-lg"></i>
                                    <input type="url" class="kt-input" id="website" name="website" placeholder="https://" maxlength="150" value="{{ $profile->website }}" />
                                </div>
                            </div>
                        </div>
                        <div class="kt-form-item mb-5">
                            <div class="w-full space-y-4">
                                <div class="space-y-1">
                                    <div class="text-sm font-medium text-mono">Gambar Logo*</div>
                                    <p class="text-xs text-muted-foreground">
                                        Format gambar yang diperbolehkan adalah <b>jpg, jpeg, png</b>, dan ukuran maksimum <b>2Mb</b>. <br>
                                        <span class="text-destructive">Gunakan rasio 1:1 agar logo tidak terpotong saat ditampilkan.</span>
                                    </p>
                                </div>
                                 <div class="kt-image-input inline-flex flex-col size-32 gap-3 rounded-lg" data-kt-image-input="true">
                                    <input type="file" accept=".png, .jpg, .jpeg" id="gambar" name="gambar" onchange="_verify_image(this.value)" />
                                    <input type="hidden" name="cover_remove" />
                                    <div class="relative size-32">
                                        <button type="button" data-kt-tooltip="true" data-kt-tooltip-trigger="hover" data-kt-tooltip-placement="top" data-kt-image-input-remove="true" class="kt-image-input-remove">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                                                <path d="M18 6 6 18"></path>
                                                <path d="m6 6 12 12"></path>
                                            </svg>
                                            <span data-kt-tooltip-content="true" class="kt-tooltip">Hapus atau kembalikan gambar</span>
                                        </button>
                                        <div data-kt-image-input-placeholder="true" class="kt-image-input-placeholder rounded-lg" style="background-image: url({{ asset('assets/media/avatars/blank.png') }})">
                                            <div data-kt-image-input-preview="true" class="kt-image-input-preview rounded-lg" {!! !empty($profile->logo) ? ('style="background-image: url(' .route('logo'). ')"') : '' !!}></div>
                                            <div class="flex items-center justify-center cursor-pointer h-6 left-0 right-0 bottom-0 bg-black/30 absolute rounded-b-lg">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-rotate-ccw size-3.5 text-white opacity-90" aria-hidden="true">
                                                    <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8"></path>
                                                    <path d="M3 3v5h5"></path>
                                                </svg>
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
                            <div class="kt-alert kt-alert-light kt-alert-destructive hidden" id="alert_image">
                                <div class="kt-alert-icon">
                                    <i class="ki-filled ki-shield-cross text-lg text-destructive"></i>
                                </div>
                                <div class="kt-alert-title">Mohon memilih gambar terlebih dahulu.</div>
                            </div>
                        </div>

                        <div class="w-full text-center gap-4 mt-10">
                            <button type="button" class="kt-btn kt-btn-outline w-[30%] mr-5" data-kt-modal-dismiss="#modal_edit">Batalkan</button>
                            <button type="submit" class="kt-btn w-[30%]">Simpan</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    function _edit() {
        new KTModal('#modal_edit').show()
    }
</script>
@endsection
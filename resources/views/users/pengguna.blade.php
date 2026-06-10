@extends('layouts.layout')

@section('title', 'Pengguna')

@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-people text-lg"></i>
                Data Pengguna
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                Data Pengguna Sidemen Tomat Terasi versi mobile dan web
            </div>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="grid w-full space-y-5">
        <div class="kt-card">
            <div class="kt-card-header min-h-16">
                <input type="text" placeholder="Pencarian Nama..." class="kt-input sm:w-50" data-kt-datatable-search="#kt_datatable_remote_filters" />

                <div class="flex items-center gap-2">
                    <input type="checkbox" class="kt-checkbox" id="check_nik" value="1" />
                    <label class="kt-label" for="check_nik">
                        Lihat NIK Pengguna
                    </label>
                </div>

                @hasanyrole(['admin', 'superadmin'])
                <label class="flex items-center gap-2 text-sm">
                    <span class="text-muted-foreground">Faskes</span>
                    <select id="kt_datatable_remote_filters_faskes" class="kt-select kt-select-sm w-40">
                        <option value="" selected="">Semua Faskes</option>
                        @foreach ($faskes as $fs)
                            <option value="{{ $fs->faskes_id }}">{{ $fs->nama_faskes }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="flex items-center gap-2 text-sm">
                    <span class="text-muted-foreground">Kec.</span>
                    <select id="kt_datatable_remote_filters_kecamatan" class="kt-select kt-select-sm w-40">
                        <option value="" selected="">Semua Kecamatan</option>
                        @foreach ($kec as $kc)
                            <option value="{{ $kc->kec_id }}">{{ $kc->kec_name }}</option>
                        @endforeach
                    </select>
                </label>
                @endhasanyrole

                <label class="flex items-center gap-2 text-sm">
                    <span class="text-muted-foreground">Usia</span>
                    <select id="kt_datatable_remote_filters_jenkel" class="kt-select kt-select-sm w-40">
                        <option value="" selected="">Semua</option>
                        <option value="dewasa">Dewasa</option>
                        <option value="anak">Anak-Anak</option>
                    </select>
                </label>

                <button type="button" id="kt_datatable_remote_filters_apply" class="kt-btn kt-btn-sm kt-btn-primary">
                    <i class="ki-filled ki-filter text-md"></i>
                    Apply filter
                </button>
            </div>
            <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-10" data-kt-datatable-column="nik">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">NIK</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="nama">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Nama Lengkap</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="username">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Username</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="faskes">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Faskes</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="keluarga">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Jml. Keluarga</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="desa">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Desa</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="opsi">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Opsi</span>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
                <template><!--begin:pagination--></template>
                <div class="kt-datatable-toolbar">
                    <div class="kt-datatable-length">
                        Show
                        <select class="kt-select kt-select-sm w-16" name="perpage" data-kt-datatable-size="true"></select>
                        per page
                    </div>
                    <div class="kt-datatable-info">
                        <span data-kt-datatable-info="true"></span>
                        <div class="kt-datatable-pagination" data-kt-datatable-pagination="true"></div>
                    </div>
                </div>
                <template><!--end:pagination--></template>
            </div>
        </div>
    </div>
</div>

<div class="kt-modal" data-kt-modal="true" id="modal_three">
    <div class="kt-modal-content w-full h-full">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_modal">Detail Pengguna</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_three">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg w-full grow">
                <div class="kt-container-fixed" id="contentContainer"></div>

                <div class="bg-center bg-cover bg-no-repeat hero-bg">
                    <!-- Container -->
                    <div class="kt-container-fixed">
                        <div class="flex flex-col items-center gap-2 lg:gap-3.5 py-4 lg:pt-5 lg:pb-10">
                            {{-- <img class="rounded-full border-3 border-green-500 size-[100px] shrink-0" src="{{ asset('assets/media/avatars/300-1.png') }}" /> --}}
                            <div class="flex justify-center items-center size-24 rounded-full ring-1 ring-input bg-accent/60">
                                <i class="ki-filled ki-user text-4xl text-muted-foreground"></i>
                            </div>
                            <div class="flex items-center gap-1.5">
                                <div class="text-lg leading-5 font-semibold text-mono" id="title_name">Jenny Klabber</div>
                                <svg class="text-primary" fill="none" height="16" viewbox="0 0 15 16" width="15" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.5425 6.89749L13.5 5.83999C13.4273 5.76877 13.3699 5.6835 13.3312 5.58937C13.2925 5.49525 13.2734 5.39424 13.275 5.29249V3.79249C13.274 3.58699 13.2324 3.38371 13.1527 3.19432C13.0729 3.00494 12.9565 2.83318 12.8101 2.68892C12.6638 2.54466 12.4904 2.43073 12.2998 2.35369C12.1093 2.27665 11.9055 2.23801 11.7 2.23999H10.2C10.0982 2.24159 9.99722 2.22247 9.9031 2.18378C9.80898 2.1451 9.72371 2.08767 9.65249 2.01499L8.60249 0.957487C8.30998 0.665289 7.91344 0.50116 7.49999 0.50116C7.08654 0.50116 6.68999 0.665289 6.39749 0.957487L5.33999 1.99999C5.26876 2.07267 5.1835 2.1301 5.08937 2.16879C4.99525 2.20747 4.89424 2.22659 4.79249 2.22499H3.29249C3.08699 2.22597 2.88371 2.26754 2.69432 2.34731C2.50494 2.42709 2.33318 2.54349 2.18892 2.68985C2.04466 2.8362 1.93073 3.00961 1.85369 3.20013C1.77665 3.39064 1.73801 3.5945 1.73999 3.79999V5.29999C1.74159 5.40174 1.72247 5.50275 1.68378 5.59687C1.6451 5.691 1.58767 5.77627 1.51499 5.84749L0.457487 6.89749C0.165289 7.19 0.00115967 7.58654 0.00115967 7.99999C0.00115967 8.41344 0.165289 8.80998 0.457487 9.10249L1.49999 10.16C1.57267 10.2312 1.6301 10.3165 1.66878 10.4106C1.70747 10.5047 1.72659 10.6057 1.72499 10.7075V12.2075C1.72597 12.413 1.76754 12.6163 1.84731 12.8056C1.92709 12.995 2.04349 13.1668 2.18985 13.3111C2.3362 13.4553 2.50961 13.5692 2.70013 13.6463C2.89064 13.7233 3.0945 13.762 3.29999 13.76H4.79999C4.90174 13.7584 5.00275 13.7775 5.09687 13.8162C5.191 13.8549 5.27627 13.9123 5.34749 13.985L6.40499 15.0425C6.69749 15.3347 7.09404 15.4988 7.50749 15.4988C7.92094 15.4988 8.31748 15.3347 8.60999 15.0425L9.65999 14C9.73121 13.9273 9.81647 13.8699 9.9106 13.8312C10.0047 13.7925 10.1057 13.7734 10.2075 13.775H11.7075C12.1212 13.775 12.518 13.6106 12.8106 13.3181C13.1031 13.0255 13.2675 12.6287 13.2675 12.215V10.715C13.2659 10.6132 13.285 10.5122 13.3237 10.4181C13.3624 10.324 13.4198 10.2387 13.4925 10.1675L14.55 9.10999C14.6953 8.96452 14.8104 8.79176 14.8887 8.60164C14.9671 8.41152 15.007 8.20779 15.0063 8.00218C15.0056 7.79656 14.9643 7.59311 14.8847 7.40353C14.8051 7.21394 14.6888 7.04197 14.5425 6.89749ZM10.635 6.64999L6.95249 10.25C6.90055 10.3026 6.83864 10.3443 6.77038 10.3726C6.70212 10.4009 6.62889 10.4153 6.55499 10.415C6.48062 10.4139 6.40719 10.3982 6.33896 10.3685C6.27073 10.3389 6.20905 10.2961 6.15749 10.2425L4.37999 8.44249C4.32532 8.39044 4.28169 8.32793 4.25169 8.25867C4.22169 8.18941 4.20593 8.11482 4.20536 8.03934C4.20479 7.96387 4.21941 7.88905 4.24836 7.81934C4.27731 7.74964 4.31999 7.68647 4.37387 7.63361C4.42774 7.58074 4.4917 7.53926 4.56194 7.51163C4.63218 7.484 4.70726 7.47079 4.78271 7.47278C4.85816 7.47478 4.93244 7.49194 5.00112 7.52324C5.0698 7.55454 5.13148 7.59935 5.18249 7.65499L6.56249 9.05749L9.84749 5.84749C9.95296 5.74215 10.0959 5.68298 10.245 5.68298C10.394 5.68298 10.537 5.74215 10.6425 5.84749C10.6953 5.90034 10.737 5.96318 10.7653 6.03234C10.7935 6.1015 10.8077 6.1756 10.807 6.25031C10.8063 6.32502 10.7908 6.39884 10.7612 6.46746C10.7317 6.53608 10.6888 6.59813 10.635 6.64999Z" fill="currentColor"></path>
                                </svg>
                            </div>
                            <div class="flex flex-wrap justify-center gap-1 lg:gap-4.5 text-sm">
                                <div class="flex gap-1.25 items-center">
                                    <i class="ki-filled ki-abstract-41 text-muted-foreground text-sm"></i>
                                    <span class="text-secondary-foreground font-medium" id="title_age">
                                        A
                                    </span>
                                </div>
                                <div class="flex gap-1.25 items-center">
                                    <i class="ki-filled ki-geolocation text-muted-foreground text-sm"></i>
                                    <span class="text-secondary-foreground font-medium" id="title_alamat">
                                        B
                                    </span>
                                </div>
                                <div class="flex gap-1.25 items-center">
                                    <i class="ki-filled ki-face-id text-muted-foreground text-sm"></i>
                                    <span class="text-secondary-foreground font-medium" id="title_jenkel">
                                        C
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- End of Container -->
                </div>
                <!-- Container -->

                <div class="kt-container-fixed">
                    <div class="flex flex-col md:flex-nowrap lg:items-center items-center justify-center border-b border-b-border gap-3 lg:gap-6 mb-5 lg:mb-10">
                        <div class="flex items-center gap-10 border-b border-neutral-200 dark:border-neutral-700 w-full justify-center" data-kt-tabs="true">
                            <button class="py-2 border-b-2 border-b-transparent text-neutral-700 dark:text-neutral-200 hover:text-blue-600 kt-tab-active:text-blue-600 kt-tab-active:border-b-blue-600 font-bold active" data-kt-tab-toggle="#profile">
                                <i class="ki-filled ki-profile-circle text-md"></i>
                                Profile
                            </button>
                            <button class="py-2 border-b-2 border-b-transparent text-neutral-700 dark:text-neutral-200 hover:text-blue-600 kt-tab-active:text-blue-600 kt-tab-active:border-b-blue-600 font-bold" data-kt-tab-toggle="#keluarga">
                                <i class="ki-filled ki-people text-md"></i>
                                Keluarga
                            </button>
                            <button class="py-2 border-b-2 border-b-transparent text-neutral-700 dark:text-neutral-200 hover:text-blue-600 kt-tab-active:text-blue-600 kt-tab-active:border-b-blue-600 font-bold" data-kt-tab-toggle="#skrining">
                                <i class="ki-filled ki-time text-md"></i>
                                Riwayat
                            </button>
                        </div>
                        <div class="">
                            <div class="transition-opacity duration-700 text-neutral-700 dark:text-neutral-200 w-full" id="profile">
                                {{-- <div class="w-full" id="content_profile"></div> --}}
                                <div class="grid grid-cols-1 xl:grid-cols-3 gap-5 lg:gap-7.5 mb-5">
                                    <div class="col-span-1">
                                        <div class="kt-card">
                                            <div class="kt-card-header">
                                                <h3 class="kt-card-title">
                                                    Data Autentikasi
                                                </h3>
                                            </div>
                                            <div class="kt-card-content pt-4 pb-3">
                                                <table class="kt-table-auto">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Nama Lengkap</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cnama"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Username</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cuser"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">NIK</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cnik"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Email</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cemail"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Telepon</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="ctelp"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Tgl Registrasi</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="creg"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-span-2">
                                        <div class="kt-card">
                                            <div class="kt-card-header">
                                                <h3 class="kt-card-title">
                                                    Data Diri
                                                </h3>
                                            </div>
                                            <div class="kt-card-content pt-4 pb-3">
                                                <table class="kt-table-auto">
                                                    <tbody>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Tanggal Lahir</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cbod"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Usia</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cusia"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Alamat Sekarang</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="calamat_now"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Desa, Kecamatan</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cdesa"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Jenis Kelamin</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cjenkel"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Faskes</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cfaskes"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-sm text-secondary-foreground pb-3.5 pe-3">Status TBC</td>
                                                            <td class="text-sm text-mono pb-3.5"><span id="cstatus"></span></td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="hidden transition-opacity duration-700 text-neutral-700 dark:text-neutral-200" id="keluarga">
                                <div class="w-full justify-center" id="content_keluarga"></div>
                            </div>
                            <div class="hidden transition-opacity duration-700 text-neutral-700 dark:text-neutral-200" id="skrining">
                                <div class="w-full" id="content_skrining"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<div class="kt-modal" data-kt-modal="true" id="modal_edit">
    <div class="kt-modal-content w-[500px] h-max-[650px]">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_edit">Edit Data Pengguna</h3>
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
                    <form method="POST" id="form_edit" class="kt-form">
                        @csrf
                        <div id="content_form"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    function ktResolveDocsDatatableApiUrl() {
        var path = "/user/tabel-pengguna"
        if (typeof window === 'undefined') {
            return path;
        }
        try {
            if (window.parent !== window && window.parent.location) {
                var po = String(window.parent.location.origin || '');
                if (po && po !== 'null') {
                    return po.replace(/\/$/, '') + path;
                }
            }
        } catch (ignore) {}
        var o = String(window.location.origin || '');
        if (o && o !== 'null') {
            return o.replace(/\/$/, '') + path;
        }
        return path;
    }

    var KTDatatableRemoteFilters = (function () {
        var isInitialized = false;
        var instance = null;
        var resolveDataTableClass = function () {
            if (typeof window === 'undefined') {
                return null;
            }
            if (window.KTDataTable) {
                return window.KTDataTable;
            }
            if (window.KTUI && window.KTUI.KTDataTable) {
                return window.KTUI.KTDataTable;
            }
            return null;
        };
        var mapResponse = function (response) {
            if (response && response.data) {
                return {
                    data: response.data,
                    totalCount: response.recordsTotal,
                    page: response.page || 1,
                    pageSize: response.pageSize || 10,
                    totalPages:
                        response.totalPages ||
                        Math.ceil(response.recordsTotal / (response.pageSize || 5)),
                };
            }
            return {
                data: [],
                totalCount: 0,
                page: 1,
                pageSize: 5,
                totalPages: 1,
            };
        };
        var mapRequest = function (params) {
            var raw = params.get('filters');
            var cek = document.getElementById('check_nik');
            if (raw) {
                try {
                    var arr = JSON.parse(raw)
                    var kc = null
                    var fs = null
                    for (var i = 0; i < arr.length; i++) {
                        if (arr[i] && arr[i].column === 'kecamatan') {
                            kc = arr[i];
                            break;
                        }
                    }
                    if (kc && kc.value) {
                        params.set('kecamatan', kc.value);
                    } else {
                        params.delete('kecamatan');
                    }

                    for (var i = 0; i < arr.length; i++) {
                        if (arr[i] && arr[i].column === 'faskes') {
                            fs = arr[i];
                            break;
                        }
                    }
                    if (fs && fs.value) {
                        params.set('faskes', fs.value);
                    } else {
                        params.delete('faskes');
                    }

                    if (cek.checked) {
                        params.set('nik', 'show')
                    } else {
                        params.set('nik', 'hide')
                    }
                } catch (e) {
                    /* ignore */
                }
                params.delete('filters');
            }
            return params;
        };
        var init = function () {
            var KTDataTable = resolveDataTableClass();
            if (!KTDataTable) {
                setTimeout(init, 100);
                return null;
            }
            if (isInitialized && instance) {
                return instance;
            }
            var datatableEl = document.getElementById('kt_datatable_remote_filters');
            if (!datatableEl) {
                return null;
            }
            if (datatableEl.hasAttribute('data-kt-datatable-initialized')) {
                if (
                    typeof KTDataTable !== 'undefined' &&
                    typeof KTDataTable.getInstance === 'function'
                ) {
                    var oldInstance = KTDataTable.getInstance(datatableEl);
                    if (oldInstance && typeof oldInstance.dispose === 'function') {
                        oldInstance.dispose();
                    }
                }
                datatableEl.removeAttribute('data-kt-datatable-initialized');
                if (datatableEl.instance) {
                    delete datatableEl.instance;
                }
            }
            var datatable = new KTDataTable(datatableEl, {
                apiEndpoint: ktResolveDocsDatatableApiUrl(),
                requestMethod: 'GET',
                requestHeaders: {
                    Accept: 'application/json',
                },
                mapResponse: mapResponse,
                mapRequest: mapRequest,
                stateSave: false,
                stateNamespace: 'kt-docs-datatable-remote-filters',
                pageSize: 5,
                columns: {
                    nik: { title: 'NIK' },
                    nama: { title: 'Nama Lengkap' },
                    username: { title: 'Username' },
                    faskes: { title: 'Faskes' },
                    keluarga: { title: 'Jml. Keluarga' },
                    // alamat: { title: 'Alamat' },
                    desa: { title: 'Desa' },
                    // kecamatan: { title: 'Kecamatan' },
                    opsi: {
                        render: function (_value, row) {
                            return row.opsi
                        },
                    },
                },
            });
            var selectFaskes = document.getElementById('kt_datatable_remote_filters_faskes');
            var selectKec = document.getElementById('kt_datatable_remote_filters_kecamatan');
            var applyBtn = document.getElementById('kt_datatable_remote_filters_apply');
            if (selectFaskes && selectKec && applyBtn && applyBtn.getAttribute('data-kt-demo-bound') !== '1') {
                applyBtn.setAttribute('data-kt-demo-bound', '1');
                applyBtn.addEventListener('click', function () {
                    var v = selectFaskes.value
                    var k = selectKec.value

                    if (v) {
                        if (k) {
                            datatable.setFilter({ column: 'faskes', type: 'text', value: v }).setFilter({ column: 'kecamatan', type: 'text', value: k }).reload()
                        } else {
                            datatable.setFilter({ column: 'faskes', type: 'text', value: v }).setFilter({ column: 'kecamatan', type: 'text', value: '' }).reload()
                        }
                    } else {
                        if (k) {
                            datatable.setFilter({ column: 'faskes', type: 'text', value: '' }).setFilter({ column: 'kecamatan', type: 'text', value: k }).reload()
                        } else {
                            datatable.setFilter({ column: 'faskes', type: 'text', value: '' }).setFilter({ column: 'kecamatan', type: 'text', value: '' }).reload()
                        }
                    }
                });
            }
            isInitialized = true;
            instance = datatable;
            return instance;
        };
        return { init: init };
    })();

    function safeInitialize() {
        var element = document.getElementById('kt_datatable_remote_filters');
        if (!element) {
            return;
        }
        KTDatatableRemoteFilters.init();
    }
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', safeInitialize, { once: true });
    } else {
        setTimeout(safeInitialize, 1);
    }
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    function _detail(id) {
        if (id) {
            $.ajax({
                url: '/user/detail-pengguna/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(res) {
                    console.log(res)
                    const data = res.data.user
                    const logs = res.data.logs.data
                    fetch_user(data)
                    fetch_keluarga(data.keluarga)
                    fetch_logs(logs)

                    $('#title_modal').html(`Detail ${data.name}`)
                    new KTModal('#modal_three').show()
                },
                error: function(res) {
                    Swal.fire('Error', res.message, 'error')
                }
            })
        }
    }

    function fetch_user(datas) {
        if (datas) {
            const detail = datas.detail

            $('#title_name').html(datas.name)
            $('#title_age').html(detail.tgl_lahir ? calculateAge(detail.tgl_lahir) : '')
            $('#title_alamat').html((detail.desa ? detail.desa.desakel_name : '') + ', ' + (detail.kecamatan ? detail.kecamatan.kec_name : ''))
            $('#title_jenkel').html(detail.jenkel === 'L' ? 'Laki-Laki' : 'Perempuan')

            $('#cnama').html(datas.name)
            $('#cuser').html(datas.username)
            $('#cnik').html(detail.nik)
            $('#cemail').html(datas.email ?? '')
            $('#ctelp').html(detail.telepon ?? '')
            $('#creg').html(new Date(datas.created_at).toLocaleDateString('en-GB'))

            $('#cbod').html(detail.tgl_lahir ?? '')
            $('#cusia').html(detail.tgl_lahir ? calculateAge(detail.tgl_lahir) : '')
            $('#calamat_now').html(detail.alamat ?? '')
            $('#cdesa').html((detail.desa ? detail.desa.desakel_name : '') + ', ' + (detail.kecamatan ? detail.kecamatan.kec_name : ''))
            $('#cfaskes').html(detail.faskes ? detail.faskes.nama_faskes : '')
            $('#cstatus').html(detail.status_tbc ?? '')
            $('#cjenkel').html(detail.jenkel === 'L' ? 'Laki-Laki' : 'Perempuan')
        }
    }

    function fetch_keluarga(datas) {
        let text = ''
        if (datas && datas.length > 0) {
            text = '<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-7.5 mb-5">'

                datas.forEach(dt => {
                    text += `
                            <div class="kt-card">
                                <div class="kt-card-content grid gap-7 py-7.5">
                                    <div class="grid place-items-center gap-4">
                                        <div class="flex justify-center items-center size-14 rounded-full ring-1 ring-input bg-accent/60">
                                            <i class="ki-filled ki-user-tick text-2xl text-muted-foreground"></i>
                                        </div>
                                        <div class="grid place-items-center">
                                            <a class="text-base font-medium text-mono hover:text-primary mb-px" href="javascript:void(0)">
                                                ${dt.nama_lengkap}
                                            </a>
                                            <span class="text-sm text-secondary-foreground text-center">
                                                ${dt.tgl_lahir ? calculateAge(dt.tgl_lahir) : ''}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="grid">
                                        <div class="flex items-center justify-between flex-wrap mb-3.5 gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                nik
                                            </span>
                                            <div class="flex flex-wrap gap-1.5">
                                                <span class="kt-badge kt-badge-outline">
                                                    ${dt.nik}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed"></div>
                                        <div class="flex items-center justify-between flex-wrap my-2.5 gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                tgl. lahir
                                            </span>
                                            <div class="kt-rating">
                                                ${dt.tgl_lahir ? new Date(dt.tgl_lahir).toLocaleDateString('en-GB') : ''}
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed mb-3.5"></div>
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                jenis kelamin
                                            </span>
                                            <div class="flex -space-x-2">
                                                ${dt.jenkel === 'L' ? 'Laki-Laki' : 'Perempuan'}
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed mb-3.5"></div>
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                telepon
                                            </span>
                                            <div class="flex -space-x-2">
                                                ${dt.telepon ?? ''}
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed mb-3.5"></div>
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                alamat
                                            </span>
                                            <div class="flex -space-x-2">
                                                ${dt.alamat ?? ''}
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed mb-3.5"></div>
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                faskes
                                            </span>
                                            <div class="flex -space-x-2">
                                                ${dt.faskes ? dt.faskes.nama_faskes : ''}
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed mb-3.5"></div>
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                status keluarga
                                            </span>
                                            <div class="flex -space-x-2">
                                                ${dt.status_keluarga ?? ''}
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed mb-3.5"></div>
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                status tbc
                                            </span>
                                            <div class="flex -space-x-2">
                                                ${dt.status_tbc ?? ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-card-footer justify-center">
                                    <a class="kt-btn kt-btn-outline kt-btn-primary" href="javascript:void(0)" onclick="_edit_fams('${dt.uid_keluarga}')">
                                        <i class="ki-filled ki-message-edit"></i>
                                        Ubah Data ${dt.nama_lengkap}
                                    </a>
                                </div>
                            </div>
                        `
                });

            text += '</div>'
        } else {
            text = '<h5 class="w-full text-center">Tidak ada data keluarga.</h5>'
        }

        $('#content_keluarga').html(text)
    }

    function fetch_logs(datas) {
        let text = ''
        if (datas && datas.length > 0) {
            text = '<div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-5 lg:gap-7.5 mb-5">'

                datas.forEach(dt => {
                    text += `
                            <div class="kt-card">
                                <div class="kt-card-content grid gap-7 py-7.5">
                                    <div class="grid place-items-center gap-4">
                                        <div class="flex justify-center items-center size-14 rounded-full ring-1 ring-input bg-accent/60">
                                            <i class="ki-filled ki-scroll text-2xl text-muted-foreground"></i>
                                        </div>
                                        <div class="grid place-items-center">
                                            <a class="text-base font-medium text-mono hover:text-primary mb-px" href="javascript:void(0)">
                                                ${dt.user.nama}
                                            </a>
                                            <span class="text-sm text-secondary-foreground text-center">
                                                ${dt.user.usia_saat_tes} tahun - ${dt.jenis_kelamin === 'L' ? 'Laki-Laki' : 'Perempuan'}
                                            </span>
                                        </div>
                                    </div>
                                    <div class="grid">
                                        <div class="flex items-center justify-between flex-wrap mb-3.5 gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                tgl. skrining
                                            </span>
                                            <div class="flex flex-wrap gap-1.5">
                                                <span class="kt-badge kt-badge-outline">
                                                    ${dt.tanggal}
                                                </span>
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed"></div>
                                        <div class="flex items-center justify-between flex-wrap my-2.5 gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                Kategori
                                            </span>
                                            <div class="kt-rating">
                                                ${dt.kategori}
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed mb-3.5"></div>
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                status tbc
                                            </span>
                                            <div class="flex -space-x-2">
                                                ${dt.user.status_tbc}
                                            </div>
                                        </div>
                                        <div class="border-t border-input border-dashed mb-3.5"></div>
                                        <div class="flex items-center justify-between flex-wrap gap-2">
                                            <span class="text-xs text-secondary-foreground uppercase">
                                                status keluarga
                                            </span>
                                            <div class="flex -space-x-2">
                                                ${dt.user.hubungan ?? ''}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="kt-card-footer justify-center">
                                    <a class="kt-btn kt-btn-outline ${dt.rekomendasi === '' || dt.rekomendasi === 'Aman' ? 'text-success' : 'text-destructive'}">
                                        <i class="ki-filled ki-check-circle"></i>
                                        ${dt.rekomendasi ?? ''}
                                    </a>
                                </div>
                            </div>
                        `
                });

            text += '</div>'
        } else {
            text = '<h5 class="w-full text-center">Tidak ada data riwayat skrining.</h5>'
        }

        $('#content_skrining').html(text)
    }

    // let desa = []
    function _edit(uid) {
        $('#content_form').html('')
        if (uid) {
            $.ajax({
                url: "{{ route('pengguna.edit') }}",
                type: 'POST',
                data: {uid: uid},
                dataType: 'JSON',
                success: async function(res) {
                    try {
                        const user = res.data.detail.detail
                        const data_faskes = res.data.faskes
                        const data_kec = res.data.kecamatan

                        let kec = null
                        data_kec.forEach(dk => {
                            kec += `<option value="${dk.kec_id}" ${user.kec_id ? (dk.kec_id === user.kec_id ? 'selected' : '') : ''}>${dk.kec_name}</option>`
                        })

                        const desa = user.kec_id ? await get_desa(user.kec_id, user.desakel_id) : ''
                        let list_desa = ''
                        if (desa && desa.data) {
                            desa.data.forEach(ds => {
                                list_desa += `<option value="${ds.desakel_id}" ${user.desakel_id ? (ds.desakel_id === user.desakel_id ? 'selected' : '') : ''}>${ds.desakel_name}</option>`
                            })
                        }

                        let faskes = ''
                        data_faskes.forEach(df => {
                            faskes += `<option value="${df.faskes_id}" ${(user.id_faskes ? (df.faskes_id === user.id_faskes ? 'selected' : '') : '')}>${df.nama_faskes}</option>`
                        })

                        let txt = `<input type="hidden" id="uid" name="uid" value="${res.data.detail.uuid}">`
                        txt += `
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Nama Lengkap:</label>
                                <div class="kt-form-control">
                                    <div class="kt-input">
                                        <i class="ki-filled ki-subtitle text-lg"></i>
                                        <input type="text" class="kt-input" id="nama" name="nama" placeholder="Nama Lengkap" maxlength="100" value="${user.nama_lengkap}" required autofocus />
                                    </div>
                                </div>
                                <div class="kt-form-message">Mohon mengisi nama.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Alamat Sekarang:</label>
                                <div class="kt-form-control">
                                    <textarea class="kt-textarea" name="alamat" id="alamat" placeholder="Alamat Anda" rows="4" required>${user.alamat}</textarea>
                                </div>
                                <div class="kt-form-message">Mohon mengisi alamat.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Kecamatan:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="kec" name="kec" data-kt-select-placeholder="Pilih kecamatan..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' onchange="_set_desa(this.value)" required>
                                        <option value="">Pilih Kecamatan</option>
                                        ${kec}
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih kecamatan.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Desa:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="desa" name="desa" data-kt-select-placeholder="Pilih desa..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                        <option value="">Pilih Desa</option>
                                        ${list_desa}
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih desa.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">No. Telepon:</label>
                                <div class="kt-form-control">
                                    <div class="kt-input">
                                        <i class="ki-filled ki-subtitle text-lg"></i>
                                        <input type="number" class="kt-input" id="telepon" name="telepon" placeholder="628xxx" value="${user.telepon}" required />
                                    </div>
                                </div>
                                <div class="kt-form-message">Mohon mengisi no. telepon.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Tanggal Lahir:</label>
                                <div class="kt-form-control">
                                    <div class="kt-input">
                                        <i class="ki-filled ki-subtitle text-lg"></i>
                                        <input type="date" class="kt-input" id="dob" name="dob" placeholder="Tanggal Lahir" value="${user.tgl_lahir}" required />
                                    </div>
                                </div>
                                <div class="kt-form-message">Mohon mengisi tanggal lahir.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Jenis Kelamin:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="jenkel" name="jenkel" data-kt-select-placeholder="Pilih jenis kelamin..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" ${user.jenkel === 'L' ? 'selected' : ''}>Laki-Laki</option>
                                        <option value="P" ${user.jenkel === 'P' ? 'selected' : ''}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih jenis kelamin.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Status Keluarga:</label>
                                <div class="kt-form-control">
                                    <div class="kt-input">
                                        <i class="ki-filled ki-subtitle text-lg"></i>
                                        <input type="text" class="kt-input" id="status" name="status" placeholder="Status di keluarga" maxlength="100" value="${user.status_keluarga}" required />
                                    </div>
                                </div>
                                <div class="kt-form-message">Mohon mengisi status keluarga.</div>
                            </div>
                            <div class="kt-form-item mb-5">
                                <label class="kt-form-label">Faskes:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="faskes" name="faskes" data-kt-select-placeholder="Pilih faskes..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                        <option value="">Pilih Faskes</option>
                                        ${faskes}
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih faskes.</div>
                            </div>
                            <div class="kt-form-actions w-full">
                                <button type="button" class="kt-btn kt-btn-outline" data-kt-modal-dismiss="#modal_kontak">Batalkan</button>
                                <button type="submit" class="kt-btn bg-green-500">Submit</button>
                            </div>
                            `

                        $('#title_edit').html(`Edit Pengguna: ${user.nama_lengkap}`)
                        $('#form_edit').attr('action', "{{ route('pengguna.update') }}")
                        setTimeout(() => {
                            $('#content_form').append(txt)
                        }, 1000);

                        new KTModal('#modal_edit').show()
                    } catch (err) {
                        console.log(err)
                        return false
                    }
                },
                error: function(xhr, status, error) {
                    console.log('err', error, xhr)
                    Swal.fire('Error', xhr.responseJSON.message, 'error')
                }
            })
        }
    }

    function _edit_fams(uid) {
        $('#content_form').html('')
        if (uid) {
            $.ajax({
                url: "{{ route('pengguna.keluarga.edit') }}",
                type: 'POST',
                data: {uid: uid},
                dataType: 'JSON',
                success: async function(res) {
                    try {
                        const user = res.data.detail
                        const data_faskes = res.data.faskes
                        const data_kec = res.data.kecamatan

                        let kec = null
                        data_kec.forEach(dk => {
                            kec += `<option value="${dk.kec_id}" ${user.kec_id ? (dk.kec_id === user.kec_id ? 'selected' : '') : ''}>${dk.kec_name}</option>`
                        })

                        const desa = user.kec_id ? await get_desa(user.kec_id, user.desakel_id) : ''
                        let list_desa = ''
                        if (desa && desa.data) {
                            desa.data.forEach(ds => {
                                list_desa += `<option value="${ds.desakel_id}" ${user.desakel_id ? (ds.desakel_id === user.desakel_id ? 'selected' : '') : ''}>${ds.desakel_name}</option>`
                            })
                        }

                        let faskes = ''
                        data_faskes.forEach(df => {
                            faskes += `<option value="${df.faskes_id}" ${(user.id_faskes ? (df.faskes_id === user.id_faskes ? 'selected' : '') : '')}>${df.nama_faskes}</option>`
                        })

                        let txt = `<input type="hidden" id="uid" name="uid" value="${user.uid_keluarga}">`
                        txt += `
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Nama Lengkap:</label>
                                <div class="kt-form-control">
                                    <div class="kt-input">
                                        <i class="ki-filled ki-subtitle text-lg"></i>
                                        <input type="text" class="kt-input" id="nama" name="nama" placeholder="Nama Lengkap" maxlength="100" value="${user.nama_lengkap}" required autofocus />
                                    </div>
                                </div>
                                <div class="kt-form-message">Mohon mengisi nama.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Alamat Sekarang:</label>
                                <div class="kt-form-control">
                                    <textarea class="kt-textarea" name="alamat" id="alamat" placeholder="Alamat Anda" rows="4" required>${user.alamat}</textarea>
                                </div>
                                <div class="kt-form-message">Mohon mengisi alamat.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Kecamatan:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="kec" name="kec" data-kt-select-placeholder="Pilih kecamatan..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' onchange="_set_desa(this.value)" required>
                                        <option value="">Pilih Kecamatan</option>
                                        ${kec}
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih kecamatan.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Desa:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="desa" name="desa" data-kt-select-placeholder="Pilih desa..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                        <option value="">Pilih Desa</option>
                                        ${list_desa}
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih desa.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">No. Telepon:</label>
                                <div class="kt-form-control">
                                    <div class="kt-input">
                                        <i class="ki-filled ki-subtitle text-lg"></i>
                                        <input type="number" class="kt-input" id="telepon" name="telepon" placeholder="628xxx" value="${user.telepon}" required />
                                    </div>
                                </div>
                                <div class="kt-form-message">Mohon mengisi no. telepon.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Tanggal Lahir:</label>
                                <div class="kt-form-control">
                                    <div class="kt-input">
                                        <i class="ki-filled ki-subtitle text-lg"></i>
                                        <input type="date" class="kt-input" id="dob" name="dob" placeholder="Tanggal Lahir" value="${user.tgl_lahir}" required />
                                    </div>
                                </div>
                                <div class="kt-form-message">Mohon mengisi tanggal lahir.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Jenis Kelamin:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="jenkel" name="jenkel" data-kt-select-placeholder="Pilih jenis kelamin..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L" ${user.jenkel === 'L' ? 'selected' : ''}>Laki-Laki</option>
                                        <option value="P" ${user.jenkel === 'P' ? 'selected' : ''}>Perempuan</option>
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih jenis kelamin.</div>
                            </div>
                            <div class="kt-form-item mb-3">
                                <label class="kt-form-label">Status Keluarga:</label>
                                <div class="kt-form-control">
                                    <div class="kt-input">
                                        <i class="ki-filled ki-subtitle text-lg"></i>
                                        <input type="text" class="kt-input" id="status" name="status" placeholder="Status di keluarga" maxlength="100" value="${user.status_keluarga}" required />
                                    </div>
                                </div>
                                <div class="kt-form-message">Mohon mengisi status keluarga.</div>
                            </div>
                            <div class="kt-form-item mb-5">
                                <label class="kt-form-label">Faskes:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="faskes" name="faskes" data-kt-select-placeholder="Pilih faskes..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                        <option value="">Pilih Faskes</option>
                                        ${faskes}
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih faskes.</div>
                            </div>
                            <div class="kt-form-actions w-full">
                                <button type="button" class="kt-btn kt-btn-outline" data-kt-modal-dismiss="#modal_kontak">Batalkan</button>
                                <button type="submit" class="kt-btn bg-green-500">Submit</button>
                            </div>
                            `

                        $('#title_edit').html(`Edit Keluarga: ${user.nama_lengkap}`)
                        $('#form_edit').attr('action', "{{ route('pengguna.keluarga.update') }}")
                        setTimeout(() => {
                            $('#content_form').append(txt)
                        }, 1000);

                        new KTModal('#modal_edit').show()
                    } catch (err) {
                        console.log(err)
                        return false
                    }
                },
                error: function(xhr, status, error) {
                    console.log('err', error, xhr)
                    Swal.fire('Error', xhr.responseJSON.message, 'error')
                }
            })
        }
    }

    async function _set_desa(id) {
        $('#desa').html('<option value="">Pilih Desa</option>')

        const desa = await get_desa(id)
        let list_desa = ''
        if (desa && desa.data) {
            desa.data.forEach(ds => {
                list_desa += `<option value="${ds.desakel_id}">${ds.desakel_name}</option>`
            })
        }

        $('#desa').append(list_desa)
    }

    function get_desa(id, desa_id = null) {
        if (id) {
            return $.ajax({
                url: "/utility/data-desa-kecamatan/" + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(res) {
                    return res.data
                },
                error: function(xhr, status, error) {
                    console.log('err', error, xhr)
                    return false
                }
            })
        } else {
            return false
        }
    }

    function _delete(uid) {
        if (uid) {
            Swal.fire({
                title: 'Deaktivasi Akun?',
                html: `Pengguna tidak akan bisa login via mobile maupun web.`,
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batalkan',
                confirmButtonText: 'Konfirmasi',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('pengguna.hapus') }}",
                        type: 'POST',
                        data: {uid: uid},
                        dataType: 'JSON',
                        success: function(res) {
                            Swal.fire('Sukses', res.message, 'success').then(function() { location.reload() })
                        },
                        error: function(xhr, status, error) {
                            console.log('err', error, xhr)
                            Swal.fire('Error', xhr.responseJSON.message, 'error')
                        }
                    })
                }
            })
        }
    }

</script>
@endsection
@extends('layouts.layout')

@section('title', 'Hasil Skrining')

@section('css')
<style>
    @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap');
</style>

<style>
    .ibm-plex-mono-thin {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 100;
        font-style: normal;
    }

    .ibm-plex-mono-extralight {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 200;
        font-style: normal;
    }

    .ibm-plex-mono-light {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 300;
        font-style: normal;
    }

    .ibm-plex-mono-regular {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 400;
        font-style: normal;
    }

    .ibm-plex-mono-medium {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 500;
        font-style: normal;
    }

    .ibm-plex-mono-semibold {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 600;
        font-style: normal;
    }

    .ibm-plex-mono-bold {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 700;
        font-style: normal;
    }

    .ibm-plex-mono-thin-italic {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 100;
        font-style: italic;
    }

    .ibm-plex-mono-extralight-italic {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 200;
        font-style: italic;
    }

    .ibm-plex-mono-light-italic {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 300;
        font-style: italic;
    }

    .ibm-plex-mono-regular-italic {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 400;
        font-style: italic;
    }

    .ibm-plex-mono-medium-italic {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 500;
        font-style: italic;
    }

    .ibm-plex-mono-semibold-italic {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 600;
        font-style: italic;
    }

    .ibm-plex-mono-bold-italic {
        font-family: "IBM Plex Mono", monospace;
        font-weight: 700;
        font-style: italic;
    }
</style>
@endsection


@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-cheque text-lg"></i>
                Data Hasil Skrining
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                Data hasil skrining terbaru
            </div>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="grid w-full space-y-5">
        <div class="kt-card">
            <div class="kt-card-header min-h-16">
                <input type="text" placeholder="Pencarian Nama..." class="kt-input sm:w-50 gap-2" data-kt-datatable-search="#kt_datatable_remote_filters" />

                <div class="flex items-center gap-1">
                    <input type="checkbox" class="kt-checkbox" id="check_nik" value="1" />
                    <label class="kt-label" for="check_nik">
                        Lihat NIK Pengguna
                    </label>
                </div>

                <label class="flex items-center gap-1 text-sm">
                    <span class="text-muted-foreground">Faskes</span>
                    <select id="kt_datatable_remote_filters_faskes" class="kt-select kt-select-sm w-40">
                        <option value="" selected="">Semua Faskes</option>
                        @foreach ($faskes as $fs)
                            <option value="{{ $fs->faskes_id }}">{{ $fs->nama_faskes }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="flex items-center gap-1 text-sm">
                    <span class="text-muted-foreground">Kec.</span>
                    <select id="kt_datatable_remote_filters_kecamatan" class="kt-select kt-select-sm w-40">
                        <option value="" selected="">Semua Kecamatan</option>
                        @foreach ($kecamatan as $kc)
                            <option value="{{ $kc->kec_id }}">{{ $kc->kec_name }}</option>
                        @endforeach
                    </select>
                </label>

                <button type="button" id="kt_datatable_remote_filters_apply" class="kt-btn kt-btn-sm kt-btn-primary gap-2">
                    <i class="ki-filled ki-filter text-md"></i>
                    Apply filter
                </button>

                <button type="button" id="kt_datatable_remote_download" class="kt-btn kt-btn-sm bg-green-500" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                    <i class="ki-filled ki-folder-down text-md"></i>
                    Export Data
                    <span data-kt-tooltip-content="true" class="kt-tooltip">
                        <span class="flex items-center gap-1.5">Unduh Semua Data Hasil Skrining</span>
                    </span>
                </button>

            </div>
            <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-20" data-kt-datatable-column="nik">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Nama & NIK</span>
                                        {{-- <span class="kt-table-col-sort"></span> --}}
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="desakec">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Desa, Kecamatan</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="faskes">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Faskes</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="tanggal">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Tanggal Skrining</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="skor">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Skor Gejala</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="hasil">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Hasil Skrining</span>
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

<div class="kt-modal" data-kt-modal="true" id="modal_detail">
    <div class="kt-modal-content w-min-[650px] h-auto">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_detail">Data Skrining</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_detail">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg w-full grow">
                <div class="p-2" id="content_div">
                    <div data-kt-accordion="true" class="kt-accordion">
                        <div data-kt-accordion-item="true" class="kt-accordion-item active">
                            <button id="accordion_toggle_0" data-kt-accordion-toggle="true" aria-controls="accordion_content_0" class="kt-accordion-toggle">
                                <span class="kt-accordion-title">Data Pribadi</span>
                                <span aria-hidden="true" class="kt-accordion-indicator">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus kt-accordion-indicator-on" aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus kt-accordion-indicator-off" aria-hidden="true"><path d="M5 12h14"></path></svg>
                                </span>
                            </button>
                            <div class="kt-accordion-content" aria-labelledby="accordion_toggle_0" id="accordion_content_0">
                                <div class="kt-accordion-wrapper" id="dt_user">
                                    Reui embraces flexible licensing options that empower you to choose the
                                    perfect fit for your project&#x27;s needs and budget.
                                </div>
                            </div>
                        </div>
                        <div data-kt-accordion-item="true" class="kt-accordion-item">
                            <button id="accordion_toggle_1" data-kt-accordion-toggle="true" aria-controls="accordion_content_1" class="kt-accordion-toggle">
                                <span class="kt-accordion-title">Detail Skrining</span>
                                <span aria-hidden="true" class="kt-accordion-indicator">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus kt-accordion-indicator-on" aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus kt-accordion-indicator-off" aria-hidden="true"><path d="M5 12h14"></path></svg>
                                </span>
                            </button>
                            <div class="kt-accordion-content hidden" aria-labelledby="accordion_toggle_1" id="accordion_content_1">
                                <div class="kt-accordion-wrapper flex flex-wrap w-full text-center justify-center" id="dt_skrining">
                                    Reui embraces flexible licensing options that empower you to choose the
                                    perfect fit for your project&#x27;s needs and budget.
                                </div>
                            </div>
                        </div>
                        <div data-kt-accordion-item="true" class="kt-accordion-item">
                            <button id="accordion_toggle_2" data-kt-accordion-toggle="true" aria-controls="accordion_content_2" class="kt-accordion-toggle">
                            <span class="kt-accordion-title">Data Cek Dahak</span>
                            <span aria-hidden="true" class="kt-accordion-indicator">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-plus kt-accordion-indicator-on" aria-hidden="true">
                                        <path d="M5 12h14"></path>
                                        <path d="M12 5v14"></path>
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-minus kt-accordion-indicator-off" aria-hidden="true"><path d="M5 12h14"></path></svg>
                                </span>
                            </button>
                            <div class="kt-accordion-content hidden" aria-labelledby="accordion_toggle_2" id="accordion_content_2">
                                <div class="kt-accordion-wrapper" id="dt_dahak">
                                    Reui embraces flexible licensing options that empower you to choose the
                                    perfect fit for your project&#x27;s needs and budget.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="kt-modal" data-kt-modal="true" id="modal_detail_user">
    <div class="kt-modal-content w-[900px] h-auto">
        <div class="kt-modal-header">
            <div class="kt-modal-title">
                <h3 class="kt-modal-title" id="title_user">Lembar Hasil Skrining</h3>
                <p class="text-xs text-slate-400 mt-0.5">ID Sesi: <span id="title_id">SS-20260521-0004</span></p>
            </div>
            
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_detail_user">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg w-full grow">
                <div class="p-2 flex justify-center" id="content_div">

                    <div class="w-full max-w-4xl max-h-[400vh] flex flex-col rounded-xl border border-slate-200 bg-white overflow-hidden transform scale-100 transition-all">
                        <div class="flex-1 overflow-y-auto p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div class="md:col-span-1 border-b md:border-b-0 md:border-r border-slate-300 pb-6 md:pb-0 md:pr-6">
                                <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-4">Biodata Warga</h4>            
                                <div class="space-y-4" id="bio_content">
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400">Nama Lengkap</label>
                                        <span class="block text-sm font-semibold text-slate-800 mt-0.5">Budi Utomo</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400">Nomor Induk Kependudukan (NIK)</label>
                                        <span class="block text-sm font-mono font-medium text-slate-700 mt-0.5">332110xxxxxx0003</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400">Umur & Jenis Kelamin</label>
                                        <span class="block text-sm text-slate-800 mt-0.5">42 Tahun / Laki-laki</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400">Alamat Rumah</label>
                                        <span class="block text-sm text-slate-800 mt-0.5 leading-relaxed">Rt 03 / Rw 02, Kec. Demak, Kabupaten Demak</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400">Nomor Telepon</label>
                                        <span class="block text-sm text-slate-800 mt-0.5">0812-3456-7890</span>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-medium text-slate-400">Faskes</label>
                                        <span class="block text-sm text-slate-800 mt-0.5">Puskesmas Karanganyar</span>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-span-2 space-y-5">
                                <div>
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Rekapitulasi Kuesioner Awal</h4>
                                    <div class="rounded-lg bg-slate-50 p-4 border border-slate-100 flex items-center justify-between" id="res_content">
                                        <div>
                                            <span class="text-xs text-slate-400 block font-medium">Kesimpulan Rekomendasi Sistem</span>
                                            <span class="text-sm font-bold text-red-600 mt-0.5 block">Suspek TBC (Rujuk Pemeriksaan Dahak TCM)</span>
                                        </div>
                                        <div class="text-right">
                                            <span class="text-xs text-slate-400 block font-medium">Akumulasi Skor</span>
                                            <span class="text-xl font-extrabold text-slate-800 block">5 <span class="text-xs text-slate-400 font-normal">/ 7 Gejala</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div id="list_content">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Detail Jawaban Indikasi</h4>
                                    <div class="divide-y divide-slate-100 border border-slate-100 rounded-lg overflow-hidden">
                                        <div class="flex items-center justify-between p-3 bg-white hover:bg-slate-50/50">
                                            <span class="text-sm text-slate-700 font-medium">1. Batuk berdahak secara terus menerus selama &ge; 2 Minggu?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white hover:bg-slate-50/50">
                                            <span class="text-sm text-slate-700 font-medium">2. Mengalami demam meriang sub-febris lebih dari satu bulan?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white hover:bg-slate-50/50">
                                            <span class="text-sm text-slate-700 font-medium">3. Terjadi penurunan berat badan drastis tanpa alasan jelas?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white hover:bg-slate-50/50">
                                            <span class="text-sm text-slate-700 font-medium">4. Mengeluarkan keringat berlebih di malam hari tanpa aktivitas?</span>
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Tidak</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="kt-modal-footer">
            <div></div>
            <div class="flex gap-4">
                <button class="kt-btn kt-btn-secondary" data-kt-modal-dismiss="#modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    function ktResolveDocsDatatableApiUrl() {
        var path = "/skrining/data-skrining"
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
                    page: response.page ?? 1,
                    pageSize: response.pageSize ?? 10,
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
                    // nik: { title: 'NIK' },
                    nik: {
                        render: function(_val, row) {
                            return `
                                <h5>${row.nama}</h5>
                                <small>
                                    <span class="kt-badge kt-badge-sm font-medium hover:bg-[#a4a5a6] transition-all cursor-pointer" style="color: ${row.color}" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start" onclick="_detail('${row.sesi}')">
                                        ${row.nik}
                                        <span data-kt-tooltip-content="true" class="kt-tooltip">
                                            <span class="flex items-center gap-1.5">Lihat Detail ${row.nama}</span>
                                        </span>
                                    </span>
                                </small>
                            `
                        }
                    },
                    desakec: { 
                        render: function(_val, row) {
                            return `
                                <small>${row.desa ?? ''}</small>, <br>
                                ${row.kec ?? ''}
                            `
                        }
                     },
                    faskes: { title: 'Kecamatan' },
                    tanggal: { title: 'Tanggal Skrining' },
                    skor : {
                        render: function(_val, row) {
                            return row.skor
                        }
                    },
                    // hasil: { title: 'Hasil Skrining' },
                    hasil: {
                        render: function(_val, row) {
                            if (row.hasil === 'Aman') {
                                // return `<span class="kt-badge kt-badge-success"><i class="ki-filled ki-check-circle text-lg"></i> Aman</span> `
                                return '<span class="text-primary"><i class="ki-filled ki-check-circle text-lg"></i> Aman</span>'
                            } else {
                                // return `<span class="kt-badge kt-badge-destructive"><i class="ki-filled ki-information-4 text-lg"></i> ${row.hasil}</span> `
                                return `<span class="text-destructive"><i class="ki-filled ki-information-4 text-lg"></i> ${row.hasil}</span>`
                            }
                        }
                    },
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

    function _detail(uid) {
        if (uid) {
            $.ajax({
                url: "{{ route('skrining.detail') }}",
                type: 'POST',
                data: {uid: uid},
                dataType: 'JSON',
                success: function(res) {

                    $('#title_id').html(res.data.uid_sesi)
                    user_fetch(res.data.keluarga, res.data.umur_saat_skrining)
                    recap_fetch((res.data.triggered_rule ? res.data.triggered_rule.rekomendasi : 'Aman'), res.data.data_response, (res.data.triggered_rule ? 'red' : 'green'))
                    indication_fetch(res.data.data_response, res.data.kategori.nama_kategori)

                    new KTModal('#modal_detail_user').show()
                },
                error: function(xhr, status, error) {
                    console.log(error)
                    // Swal.fire('Error', xhr.responseJSON.message, 'error')
                    _swal_alert('error', xhr.responseJSON.message)
                }
            })
        }
    }

    function _reset_status(uid) {
        Swal.fire({
            title: 'Reset Status TBC?',
            html: 'Data Status TBC Pengguna akan berganti menjadi <b>"Aman"</b> dan semua hasil skriningnya akan <span class="text-destructive"><b>dihapus</b></span>.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Konfirmasi'
        })
    }

    function _reset_hasil(uid) {
        Swal.fire({
            title: 'Batalkan Hasil Skrining',
            html: 'Tindakan ini akan membatalkan status <strong>validitas</strong> skrining ini. Sistem akan otomatis meninjau ulang <strong>status TBC</strong> pengguna berdasarkan riwayat valid terdahulu.',
            icon: 'warning',
            showCancelButton: true,
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Saya mengerti',
            allowEscapeKey: false,
            allowOutsideClick: false,
        }).then(function(res) {
            if (res.isConfirmed) {
                Swal.fire({
                    html: '<span class="font-bold text-2xl">Tulis alasan pembatalan</span> (min. 5 karakter)',
                    input: 'textarea',
                    inputAttributes: { autocapitalize: "off", placeholder: 'Tulis disini..' },
                    showCancelButton: true,
                    cancelButtonText: 'Batalkan',
                    confirmButtonText: "Konfirmasi",
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showLoaderOnConfirm: true,
                    inputValidator: (value) => {
                        if (!value || value.trim() === '') {
                            return 'Mohon untuk mengisi alasan pembatalan';
                        }
                    },
                    preConfirm: async (reason) => {
                        const cancelButton = Swal.getCancelButton()
                        if (cancelButton) {
                            cancelButton.style.display = 'none'
                        }

                        try {
                            if (!reason || reason.trim() === '') throw new Error("Mohon untuk mengisi alasan pembatalan")

                            const response = await $.ajax({
                                url: "{{ route('skrining.revisi') }}",
                                type: 'POST',
                                data: {uid: uid, alasan: reason},
                                dataType: 'JSON',
                            })

                            return response
                        } catch (error) {
                            // Swal.showValidationMessage(`Permintaan gagal: ${err}`);
                            const message = error.responseJSON?.message || error.responseJSON?.error
                            const fallbackMessage = `Error ${error.status}: ${error.statusText}`

                            if (cancelButton) {
                                cancelButton.style.display = 'inline-block'
                            }
                            Swal.showValidationMessage(message || fallbackMessage)
                            return false
                        }
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        console.log('res', result)
                        Swal.fire('Berhasil', result.value.message, 'success').then(function() { location.reload() })
                    }
                })
            }
        })
    }

    function fetch_user(data) {
        let user = ''
        if (data) {
            user = `<div class="flex flex-wrap gap-4 mb-5 justify-around rounded-lg border border-border bg-card p-5">
                        <div class="w-[45%]">
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Nama Lengkap</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="nama">${data.nama_lengkap}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">NIK</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="nik">${data.nik}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Telepon</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="telepon">${data.telepon}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Alamat Sekarang</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="alamat">${data.alamat}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Desa/Kelurahan</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="desa">${data.desa?.desakel_name}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Kecamatan</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="kecamatan">${data.kecamatan?.kec_name}</label>
                            </div>
                        </div>
                        <div class="w-[45%]">
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Faskes</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="faskes">${data.faskes?.nama_faskes}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Tanggal Lahir</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="tgl_lahir">${data.tgl_lahir ? (new Date(data.tgl_lahir).toLocaleString('en-GB')) : ''}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Jenis Kelamin</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="jenkel">${data.jenkel === 'L' ? 'Laki-Laki' : (data.jenkel === 'P' ? 'Perempuan' : '')}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Status di Keluarga</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="status">${data.status_keluarga}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Status TBC</label>
                                <label for="" class="w-auto kt-badge kt-badge-warning kt-badge-light ibm-plex-mono-medium" id="tbc">${data.status_tbc}</label>
                            </div>
                            <div class="w-full flex">
                                <label for="" class="w-[35%] ibm-plex-mono-regular">Tanggal Awal Obat</label>
                                <label for="" class="w-[55%] ibm-plex-mono-medium" id="tgl_awal">${data.tgl_awal_obat ?? ''}</label>
                            </div>
                        </div>
                    </div>`
        } else {
            user = '<h5 class="w-full text-center">Tidak ada data.</h5>'
        }

        $('#dt_user').html(user)
    }

    function fetch_skrining(data, cat, rekom) {
        let list = ''
        if (data) {
            list = `<div class="kt-card w-[50%]">
                        <div class="kt-card-header">
                            <div class="kt-card-heading">
                                <h2 class="kt-card-title">${cat.nama_kategori}</h2>
                            </div>
                            <div class="kt-card-toolbar"></div>
                        </div>
                        <div class="kt-card-content py-1">`

            data.forEach(dt => {
                list += `
                            <div class="flex items-center justify-between gap-2 py-2 border-b border-border border-dashed last:border-none">
                                <div class="flex items-center gap-3">
                                    <div>
                                        <a href="javascript:void(0)" class="text-sm font-medium text-foreground hover:text-primary">${dt.parameter.pertanyaan}</a>
                                    </div>
                                </div>
                                <span class="kt-badge kt-badge-outline kt-badge-${dt.is_yes === 1 ? 'destructive' : 'primary'}">${dt.is_yes === 1 ? 'Ya' : 'Tidak'}</span>
                            </div>`
            });
                            
            list += `   </div>
                        <div class="kt-card-footer justify-center">
                            <button class="kt-link kt-link-underlined underline-dashed">
                                ${rekom}
                            </button>
                        </div>
                    </div>`
        }

        $('#dt_skrining').html(list)
    }

    function fetch_dahak(data) {
        let tcm = ''
        if (data && data.jenis_tcm) {
            tcm = `<div class="kt-card w-[400px]">
                        <div class="kt-card-content space-y-4">
                            <div>
                                <h3 class="text-sm font-semibold text-foreground">${data.jenis_tcm === 'mandiri' ? 'Tes Mandiri' : ('Tes di Faskes ' + data.keluarga.faskes.nama_faskes)}</h3>
                                <p class="mt-1 text-sm text-muted-foreground">
                                    Hasil Tes <span class="kt-badge kt-badge-sm kt-badge-${data.hasil_tcm === 'positive' ? 'destructive' : 'success'} capitalize">${data.hasil_tcm}</span>
                                    <br><br>
                                    Lihat file <a class="kt-link kt-link-underlined underline-dashed" href="{{ asset('') }}storage/dokumen_tcm/${data.file_tcm}" target="_blank">di sini</a>
                                </p>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-muted-foreground">Tanggal Tes</span>
                                <span class="font-medium text-foreground">${data.tgl_tcm}</span>
                            </div>
                        </div>
                    </div>`
        }

        $('#dt_dahak').html(tcm)
    }

    function user_fetch(user, age) {
        let text = ''
        if (user) {
            text += `
                <div>
                    <label class="block text-xs font-medium text-slate-400">Nama Lengkap</label>
                    <span class="block text-sm font-semibold text-slate-800 mt-0.5">${user.nama_lengkap}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400">Nomor Induk Kependudukan (NIK)</label>
                    <span class="block text-sm font-mono font-medium text-slate-700 mt-0.5">${user.nik}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400">Umur (saat skrining) & Jenis Kelamin</label>
                    <span class="block text-sm text-slate-800 mt-0.5">${age} Tahun / ${user.jenkel ? (user.jenkel === 'L' ? 'Laki-Laki' : 'Perempuan') : '-'}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400">Alamat Rumah</label>
                    <span class="block text-sm text-slate-800 mt-0.5 leading-relaxed">${user.alamat}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400">Desa, Kecamatan</label>
                    <span class="block text-sm text-slate-800 mt-0.5 leading-relaxed">${user.desa?.desakel_name}, ${user.kecamatan?.kec_name}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400">Status Keluarga</label>
                    <span class="block text-sm text-slate-800 mt-0.5">${user.status_keluarga}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400">Nomor Telepon</label>
                    <span class="block text-sm text-slate-800 mt-0.5">${user.telepon}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400">Faskes</label>
                    <span class="block text-sm text-slate-800 mt-0.5">${user.faskes.nama_faskes}</span>
                </div>
                <div>
                    <label class="block text-xs font-medium text-slate-400">Status TBC</label>
                    <span class="block text-sm text-slate-800 mt-0.5">${user.status_tbc}</span>
                </div>
            `
        }

        $('#bio_content').html(text)
    }

    function recap_fetch(res, skor, color) {
        let text = ''
        if (res && Array.isArray(skor)) {
            const active = skor.filter(isyes => isyes.is_yes === 1).length ?? 0
            text += `
                <div>
                    <span class="text-xs text-slate-400 block font-medium">Kesimpulan Rekomendasi Sistem</span>
                    <span class="text-sm font-bold text-${color ?? 'slate'}-600 mt-0.5 block">${res}</span>
                </div>
                <div class="text-right">
                    <span class="text-xs text-slate-400 block font-medium">Akumulasi Skor</span>
                    <span class="text-xl font-extrabold text-slate-800 block">${active} <span class="text-xs text-slate-400 font-normal">/ ${skor.length ?? 0} Gejala</span></span>
                </div>
            `
        }

        $('#res_content').html(text)
    }

    function indication_fetch(lists, cat) {
        let text = ''
        if (Array.isArray(lists) && cat) {
            text += `
                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3">Detail Jawaban Indikasi <span class="text-slate-800">${cat}</span></h4>
                    <div class="divide-y divide-slate-100 border border-slate-100 rounded-lg overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-200 [&::-webkit-scrollbar-thumb]:rounded-full scroll-smooth h-max-[370px]">`

            lists.forEach(ls => {
                text += `
                        <div class="flex items-center justify-between p-3 bg-white hover:bg-slate-50/50">
                            <span class="text-sm text-slate-700 font-medium">${ls.parameter?.pertanyaan}</span>
                            <span class="inline-flex items-center rounded-full bg-${ls.is_yes === 1 ? 'red' : 'emerald'}-100 px-2.5 py-0.5 text-xs font-semibold text-${ls.is_yes === 1 ? 'red' : 'emerald'}-800">${ls.is_yes === 1 ? 'Ya' : 'Tidak'}</span>
                        </div>
                `
            })

            text += `</div>
            `
        }

        $('#list_content').html(text)
    }
</script>
@endsection
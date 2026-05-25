@extends('layouts.layout')

@section('title', 'Pemantauan Obat')

@section('css')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600;1,700&display=swap" rel="stylesheet">

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

<style>
    /* Paksa container legend ApexCharts agar berjejer horizontal */
    #chart_obat .apexcharts-legend {
        display: flex !important;
        flex-direction: row !important; /* Memaksa satu baris horizontal */
        justify-content: center !important; /* Menaruh di tengah */
        flex-wrap: wrap !important; /* Mengizinkan patah baris hanya jika layar terlalu sempit */
        gap: 20px !important; /* Memberikan jarak antar item */
    }

    /* Memperbaiki tata letak ikon kotak warna dan teksnya */
    #chart_obat .apexcharts-legend-series {
        display: flex !important;
        align-items: center !important;
        margin: 5px 0 !important;
    }
</style>

<style>
    .channel-stats-bg {
        background-image: url("{{ asset('assets/media/images/2600x1600/bg-3.png') }}");
    }
    .dark .channel-stats-bg {
        background-image: url("{{ ('assets/media/images/2600x1600/bg-3-dark.png') }}");
    }
</style>
@endsection

@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-capsule text-lg"></i>
                Data Pemantauan Obat
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                Data pemantauan obat pengguna positif TBC
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
                        @foreach ($kecamatan as $kc)
                            <option value="{{ $kc->kec_id }}">{{ $kc->kec_name }}</option>
                        @endforeach
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
                                <th scope="col" class="w-20" data-kt-datatable-column="nama">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Nama Lengkap</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="kec">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Kecamatan</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="tanggal">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Tanggal Skrining</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="mulai">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Tgl Mulai Obat</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="obat">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Log Terakhir</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="berat">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">BB Terakhir</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="faskes">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Faskes</span>
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
    <div class="kt-modal-content w-full ">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_modal">Detail Pemantauan Obat</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_three">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg bg-muted w-full grow h-auto p-5">
                <div class="flex flex-wrap gap-4 mb-5 rounded-lg border border-border bg-card p-5">
                    {{-- <h3 class="font-bold w-full">Biodata</h3> --}}
                    <div class="w-[47%] mb-3">
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Nama Lengkap</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="nama">Lorem ipsum</label>
                            {{-- <input type="text" class="kt-input w-[55%] ibm-plex-mono-semibold" value="Lorem ipsum" id="nama" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">NIK</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="nik"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="nik" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Telepon</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="telepon"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="telepon" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Alamat Sekarang</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="alamat"></label>
                            {{-- <textarea name="alamat" id="alamat" class="kt-textarea w-[55%]" cols="30" rows="4" readonly></textarea> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Desa/Kelurahan</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="desa"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="desa" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Kecamatan</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="kecamatan"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="kecamatan" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Faskes</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="faskes"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="faskes" readonly /> --}}
                        </div>
                    </div>
                    <div class="w-[47%]">
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Tanggal Lahir</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="tgl_lahir"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="tgl_lahir" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Jenis Kelamin</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="jenkel"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="jenkel" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Status di Keluarga</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="status"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="status" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Status TBC</label>
                            <label for="" class="w-auto kt-badge kt-badge-warning kt-badge-light ibm-plex-mono-medium" id="tbc"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="tbc" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Tanggal Awal Obat</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="tgl_awal"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="tgl_awal" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Hari ke</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="hari_ke"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="tgl_awal" readonly /> --}}
                        </div>
                        <div class="w-full flex">
                            <label for="" class="w-[35%] ibm-plex-mono-regular">Fase</label>
                            <label for="" class="w-[55%] ibm-plex-mono-medium" id="fase"></label>
                            {{-- <input type="text" class="kt-input w-[55%]" value="" id="tgl_awal" readonly /> --}}
                        </div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 mb-5 justify-around rounded-lg border border-border bg-card p-5">
                    <div class="w-[45%] h-[500px]" id="chart_weight"></div>
                    <div class="w-[45%]">
                        <div class="flex flex-wrap w-full text-center justify-center">
                            <div class="w-[25%]">
                                <select id="kt_bulan" class="kt-select kt-select-sm w-40 w-full" onchange="_isBulan(this.value)">
                                    @for ($i = 1; $i < 7; $i++)
                                        <option value="{{ $i }}">Bulan ke {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="w-full h-[500px]" id="chart_obat"></div>
                    </div>
                </div>

                <div class="flex flex-wrap gap-4 mb-5 justify-around rounded-lg border border-border bg-card p-5">
                    <div id="content_summary"></div>
                </div>

                <div class="flex flex-wrap gap-4 justify-around rounded-lg border border-border bg-card p-5">
                    <div id="content_logs"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('js')
<script>
    function ktResolveDocsDatatableApiUrl() {
        var path = "/penanganan/tabel-pemantauan"
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
                    nama: {
                        render: function(_val, row) {
                            return `
                                <h5>${row.nama}</h5>
                                <small><span class="kt-badge kt-badge-sm" style="color: ${row.color}">${row.nik}</span></small>
                            `
                        }
                    },
                    kec: { title: 'Kecamatan' },
                    tanggal: { title: 'Tanggal Skrining' },
                    mulai: { title: 'Tanggal Mulai' },
                    obat: { title: 'Pemantauan Obat' },
                    berat: { 
                        render: function (_val, row) {
                            return `${(row.berat === '-') ? '-' : (row.berat + ' Kg')}`
                        }
                     },
                    faskes: { title: 'Faskes' },
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
    function _detail(uid) {
        $.ajax({
            url: "{{ route('obat.detail') }}",
            type: 'POST',
            data: {uid: uid},
            dataType: 'JSON',
            success: function(res) {
                if (res.data) {
                    fetch_biodata(res.data.pengguna, res.data.durasi)
                    fetch_chart_weight(res.data.berat)
                    fetch_chart_heatmap(res.data.series)
                    fetch_summary(res.data.summary, res.data.durasi)
                }
            },
            error: function(xhr, status, error) {
                console.log(error)
                Swal.fire('Error', xhr.responseJSON.message, 'error')
            }
        })
        new KTModal('#modal_detail').show()
    }

    function fetch_biodata(datas, durasi) {
        if (datas) {
            $('#nama').html(datas.nama_lengkap ?? '')
            $('#nik').html(datas.nik ?? '')
            $('#alamat').html(datas.alamat ?? '')
            $('#desa').html(datas.desa ? datas.desa.desakel_name : '')
            $('#kecamatan').html(datas.kecamatan ? datas.kecamatan.kec_name : '')
            $('#faskes').html(datas.faskes ? datas.faskes.nama_faskes : '')
            $('#telepon').html(datas.telepon ?? '')
            $('#tgl_lahir').html(datas.tgl_lahir ?? '')
            $('#jenkel').html(datas.jenkel === 'P' ? 'Perempuan' : (datas.jenkel === 'L' ? 'Laki-Laki' : ''))
            $('#status').html(datas.status_keluarga ?? '')
            $('#tbc').html(datas.status_tbc ?? '')
            $('#tgl_awal').html(datas.tgl_mulai_obat ?? '')
            $('#hari_ke').html(durasi.hari_ke)
            $('#fase').html(durasi.fase)
        }
    }

    function fetch_chart_weight(datas) {
        var options = {
            chart: {
                height: 450,
                type: 'bar',
                toolbar: { show: false }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2, // Memberikan jarak grid antar kotak putih tipis
                colors: ['#fff']
            },
            plotOptions: {
                bar: {
                    borderRadius: 10,
                    dataLabels: {
                        position: top,
                    }
                },
            },
            series: [{
                name: 'Berat Badan',
                data: datas.data
            }],
            dataLabels: {
                enabled: true,
                formatter: function (val) {
                    return val + " Kg";
                },
                offsetY: 120,
                style: {
                    fontSize: '12px',
                    colors: ["#304758"]
                }
            },
            xaxis: {
                categories: datas.label,
                position: 'top',
                axisBorder: { show: false },
                axisTick: { show: false },
                offsetY: 12,
                crosshairs: {
                    fill: {
                        type: 'gradient',
                        gradient: {
                            colorFrom: '#D8E3F0',
                            colorTo: '#BED1E6',
                            stops: [0, 100],
                            opacityFrom: 0.4,
                            opacityTo: 0.5,
                        }
                    }
                },
                tooltip: { enabled: true }
            },
            yaxis: {
                axisBorder: {
                    show: false
                },
                axisTicks: {
                    show: false,
                },
                labels: {
                    show: false,
                    formatter: function (val) {
                        return val + " Kg";
                    }
                }
                
            },
            title: {
                text: 'Grafik Kondisi Berat Badan',
                floating: true,
                offsetY: -5,
                align: 'center',
                style: {
                    color: '#444',
                    fontWeight: 'medium',
                    fontSize: '16px'
                }
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart_weight"), options);
        chart.render();
    }

    function fetch_chart_heatmap(datas, bln = 1) {
        var options = {
            series: datas,
            chart: {
                height: 450,
                type: 'heatmap',
                toolbar: { show: false }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                width: 2, // Memberikan jarak grid antar kotak putih tipis
                colors: ['#fff']
            },
            plotOptions: {
                heatmap: {
                    radius: 4,
                    enableShades: false,
                    colorScale: {
                        ranges: [
                            {
                                from: -1,
                                to: -1,
                                name: 'Tidak Mengisi Log',
                                color: '#e2e8f0' // Abu-abu terang (Slate 200)
                            },
                            {
                                from: 0,
                                to: 0,
                                name: 'Aman (Tidak Ada Gejala)',
                                color: '#10b981' // Hijau cerah (Emerald 500)
                            },
                            {
                                from: 1,
                                to: 1,
                                name: 'Mengalami Gejala',
                                color: '#ef4444' // Merah menyala (Red 500)
                            }
                        ]
                    }
                }
            },
            xaxis: {
                type: 'category',
                position: 'top',
                labels: {
                    show: true,
                    style: { 
                        colors: '#64748b',
                        fontSize: '12px'
                    },
                    offsetY: 5,
                    rotate: 0,
                    rotateAlways: false,
                },
                axisBorder: { show: false },
                axisTicks: { show: false },
                title: {
                    text: `Rekap Pemantauan Obat Periodik (Bulan ke ${bln})`,
                    offsetY: -10,
                    style: {
                        fontWeight: 'medium',
                        fontSize: '16px'
                    }
                }
            },
            yaxis: {
                labels: {
                    style: {
                        fontWeight: 'bold',
                        colors: ['#1e293b']
                    }
                }
            },
            tooltip: {
                custom: function({ series, seriesIndex, dataPointIndex, w }) {
                    // Ambil objek data kustom yang kita kirim dari Controller tadi
                    var dataObj = w.globals.initialSeries[seriesIndex].data[dataPointIndex];
                    var namaGejala = w.globals.seriesNames[seriesIndex];
                    
                    var statusText = 'Tidak Mengisi Log';
                    var textColor = 'text-mute';
                    if (dataObj.y === 1) { statusText = 'Mengalami Gejala'; textColor = 'text-destructive'; }
                    if (dataObj.y === 0) { statusText = 'Aman / Sehat'; textColor = 'text-primary'; }

                    // Kembalikan struktur HTML kustom untuk kotak pop-up tooltip
                    return '<div class="p-2 bg-white border shadow-sm" style="font-family: inherit; font-size: 13px;">' +
                        '<div><b>Gejala:</b> ' + namaGejala + '</div>' +
                        '<div><b>Hari Ke:</b> ' + dataObj.x + ' (' + dataObj.date + ')</div>' +
                        '<div><b>Status:</b> <span class="' + textColor + '"><b>' + statusText + '</b></span></div>' +
                        '</div>';
                }
            },
            legend: {
                show: true,
                position: 'bottom',
                horizontalAlign: 'center',
                fontSize: '13px',
                fontFamily: 'inherit',
                itemMargin: {
                    horizontal: 15,
                    vertical: 10
                }
            }
        }

        var chart = new ApexCharts(document.querySelector("#chart_obat"), options);
        chart.render();
    }

    function fetch_summary(datas, days) {
        const mual = `<div class="kt-card flex flex-col justify-between gap-6 min-w-[200px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="w-7 mt-4 ms-5">&nbsp;</div>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-semibold text-mono">${datas.mual} kali</span>
                            <span class="text-sm font-normal text-secondary-foreground">Efek Mual</span>
                        </div>
                    </div>`
        const pipis = `<div class="kt-card flex flex-col justify-between gap-6 min-w-[200px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="w-7 mt-4 ms-5">&nbsp;</div>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-semibold text-mono">${datas.pipis} kali</span>
                            <span class="text-sm font-normal text-secondary-foreground">Efek Pipis Merah</span>
                        </div>
                    </div>`
        const pendengaran = `<div class="kt-card flex flex-col justify-between gap-6 min-w-[200px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="w-7 mt-4 ms-5">&nbsp;</div>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-semibold text-mono">${datas.pendengaran} kali</span>
                            <span class="text-sm font-normal text-secondary-foreground">Efek Pendengaran</span>
                        </div>
                    </div>`
        const penglihatan = `<div class="kt-card flex flex-col justify-between gap-6 min-w-[200px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="w-7 mt-4 ms-5">&nbsp;</div>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-semibold text-mono">${datas.penglihatan} kali</span>
                            <span class="text-sm font-normal text-secondary-foreground">Efek Penglihatan</span>
                        </div>
                    </div>`
        const pegal = `<div class="kt-card flex flex-col justify-between gap-6 min-w-[200px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="w-7 mt-4 ms-5">&nbsp;</div>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-semibold text-mono">${datas.pegal} kali</span>
                            <span class="text-sm font-normal text-secondary-foreground">Efek Pegal</span>
                        </div>
                    </div>`
        const batuk = `<div class="kt-card flex flex-col justify-between gap-6 min-w-[200px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="w-7 mt-4 ms-5">&nbsp;</div>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-semibold text-mono">${datas.batuk} kali</span>
                            <span class="text-sm font-normal text-secondary-foreground">Efek Batuk</span>
                        </div>
                    </div>`
        const demam = `<div class="kt-card flex flex-col justify-between gap-6 min-w-[200px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <div class="w-7 mt-4 ms-5">&nbsp;</div>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-semibold text-mono">${datas.demam} kali</span>
                            <span class="text-sm font-normal text-secondary-foreground">Efek Demam</span>
                        </div>
                    </div>`

        let text = `<div class="">
                        <h5 class="mb-3 font-bold w-full text-center text-lg">Efek Samping Obat (Hari ke-${days.hari_ke})</h5>
                        <div class="flex flex-row flex-wrap justify-center items-stretch gap-5 lg:gap-7.5 w-full">`
                                
            text += mual + pipis + pendengaran + penglihatan + pegal + batuk + demam

            text += '</div></div>'
        
        $('#content_summary').html(text)
    }

    function _isBulan(id) {
        Swal.fire('Notify', id, 'info')
    }
</script>
@endsection
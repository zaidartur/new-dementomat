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
    <div class="kt-modal-content w-full top-[10%]">
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
            <div class="rounded-lg bg-muted w-full grow h-[250px]"></div>
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
    function _detail(id) {
        $.ajax({
            url: '/user/detail-pengguna/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(res) {
                console.log(res)
                const data = res.data

                $('#title_modal').html(data.name)
                new KTModal('#modal_three').show()
            },
            error: function(res) {
                Swal.fire('Error', res.message, 'error')
            }
        })
    }
</script>
@endsection
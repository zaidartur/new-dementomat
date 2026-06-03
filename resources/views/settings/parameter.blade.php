@extends('layouts.layout')

@section('title', 'Master Parameter Skrining')


@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-data text-lg"></i>
                Parameter Skrining
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                Data master parameter skrining dewasa dan anak
            </div>
        </div>
    </div>
</div>

<div class="kt-container-fixed mb-10">
    <div class="grid w-full space-y-5">
        <div class="kt-card">
            <div class="kt-card-header min-h-16">
                <input type="text" placeholder="Pencarian Nama..." class="kt-input sm:w-50 gap-2" data-kt-datatable-search="#kt_datatable_remote_filters" />

                <div class="kt-toggle-group">
                    <label class="kt-btn">
                        Semua Jenis
                        <input type="radio" name="age_range" id="semua" value="" checked />
                    </label>
                    <label class="kt-btn">
                        Anak
                        <input type="radio" name="age_range" id="anak" value="anak" />
                    </label>
                    <label class="kt-btn">
                        Dewasa
                        <input type="radio" name="age_range" id="dewasa" value="dewasa" />
                    </label>
                </div>


                <button type="button" id="kt_datatable_add" class="kt-btn bg-green-500 hover:bg-emerald-600" onclick="new_param()">
                    <i class="ki-filled ki-plus-circle text-md"></i>
                    Tambah Parameter
                </button>
            </div>
            <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-50" data-kt-datatable-column="text">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Pertanyaan</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-30" data-kt-datatable-column="jenis">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Kategori</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="kode">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Kode</span>
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

<div class="kt-container-fixed mb-10">
    <div class="kt-card w-full">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">Kategori Skrining</h2>
            </div>
        </div>
        <div class="kt-card-content grid grid-cols-2 gap-3">
            @foreach ($categories as $item)
                <div class="rounded-lg border border-border bg-muted/30 px-4 py-3 cursor-pointer transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg hover:border-indigo-500" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start" onclick="_edit_cat('{{ base64_encode(json_encode($item)) }}')">
                    <p class="text-xs uppercase tracking-wide text-muted-foreground">
                        ID: {{ $item->id }}
                    </p>
                    <p class="mt-1 text-lg font-semibold text-foreground">{{ $item->nama_kategori }}</p>
                    <p class="mt-1 text-xs text-muted-foreground">
                        {{ $item->min_age }} Tahun - {{ $item->max_age }} Tahun
                    </p>
                    <span data-kt-tooltip-content="true" class="kt-tooltip">
                        <span class="flex items-center gap-1.5">Edit Kategori</span>
                    </span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="kt-card w-full h-[500px]">
        <div class="kt-card-header">
            <div class="kt-card-heading">
                <h2 class="kt-card-title">Rule Parameter Skrining</h2>
            </div>
        </div>
        <div class="kt-card-content grid grid-cols-2 gap-3">
        </div>
    </div>
</div>

<div class="kt-modal" data-kt-modal="true" id="modal_add">
    <div class="kt-modal-content max-w-[650px] top-[20%]">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_add">Tambah Parameter</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_add">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg w-full grow h-full">
                <div class="p-2">
                    <form method="POST" id="form_add" class="kt-form">
                        @csrf
                        <input type="hidden" id="uid" name="uid" value="">
                        <div class="kt-form-item">
                            <label class="kt-form-label">Pertanyaan* :</label>
                            <div class="kt-form-control">
                                <textarea name="judul" id="judul" class="kt-textarea" cols="30" rows="4" required data-kt-modal-input-focus="true" placeholder="Tulis pertanyaan disini.."></textarea>
                            </div>
                        </div>
                        <div class="kt-form-item">
                            <label class="kt-form-label">Kategori* : </label>
                            <div class="kt-form-control">
                                <select class="kt-select" data-kt-select="true" id="kategori" name="kategori" data-kt-select-placeholder="Pilih kategori..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                    <option value="">Pilih Kategori</option>
                                    @foreach ($categories as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="kt-form-item mb-10">
                            <label class="kt-form-label">Kode* :</label>
                            <div class="kt-input">
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="text" class="kt-input" id="kode" name="kode" placeholder="Kode Parameter" maxlength="5" required />
                            </div>
                        </div>
                        <div class="w-full text-center gap-4">
                            <button type="button" class="kt-btn kt-btn-outline w-[30%] mr-5" data-kt-modal-dismiss="#modal_kontak">Batalkan</button>
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
    function ktResolveDocsDatatableApiUrl() {
        var path = "/pengaturan/tabel-parameter"
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
            var raw = params.get('filters')
            if (raw) {
                try {
                    var arr = JSON.parse(raw)
                    var kc = null
                    for (var i = 0; i < arr.length; i++) {
                        if (arr[i] && arr[i].column === 'kategori') {
                            kc = arr[i];
                            break;
                        }
                    }
                    if (kc && kc.value) {
                        params.set('kategori', kc.value);
                    } else {
                        params.delete('kategori');
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
                    text: { title: 'Pertanyaan' },
                    jenis: { title: 'Kategori' },
                    kode: { title: 'Kode Paramater' },
                    opsi: {
                        render: function (_value, row) {
                            return row.opsi
                        },
                    },
                },
            });
            
            var semua  = document.getElementById('semua')
            var anak   = document.getElementById('anak')
            var dewasa = document.getElementById('dewasa')
            if (semua.checked || anak.checked || dewasa.checked) {
                document.querySelectorAll('input[name="age_range"]').forEach((radio) => {
                    radio.addEventListener('change', (event) => {
                        if (event.target.checked) {
                            console.log(`You selected: ${event.target.value}`);
                            datatable.setFilter({ column: 'kategori', type: 'text', value: event.target.value }).reload()
                        }
                    })
                })
                
                // applyBtn.addEventListener('click', function () {
                //     var v = selectFaskes.value
                //     var k = selectKec.value

                //     if (v) {
                //         if (k) {
                //             datatable.setFilter({ column: 'faskes', type: 'text', value: v }).setFilter({ column: 'kecamatan', type: 'text', value: k }).reload()
                //         } else {
                //             datatable.setFilter({ column: 'faskes', type: 'text', value: v }).setFilter({ column: 'kecamatan', type: 'text', value: '' }).reload()
                //         }
                //     } else {
                //         if (k) {
                //             datatable.setFilter({ column: 'faskes', type: 'text', value: '' }).setFilter({ column: 'kecamatan', type: 'text', value: k }).reload()
                //         } else {
                //             datatable.setFilter({ column: 'faskes', type: 'text', value: '' }).setFilter({ column: 'kecamatan', type: 'text', value: '' }).reload()
                //         }
                //     }
                // });
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
    let myType = null
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    })

    function new_param() {
        myType = 'save'
        $('#title_add').html('Tambah Parameter')
        $('#form_add')[0].reset()
        $('#form_add').attr('action', "{{ route('params.save') }}")
        new KTModal('#modal_add').show()
    }

    function _edit(datas) {
        const data = JSON.parse(atob(datas))
        if (data) {
            console.log(data)
            myType = 'update'
            $('#title_add').html('Edit Parameter')
            $('#form_add')[0].reset()
            $('#form_add').attr('action', "{{ route('params.update') }}")

            $('#uid').val(data.uid_parameter)
            $('#judul').val(data.pertanyaan)
            $('#kode').val(data.kode)
            const selectKat = document.querySelector('#kategori')
            selectKat.value = data.kategori_id
            const selectInstances = KTSelect.getInstance(selectKat)
            if (selectInstances) {
                selectInstances.update()
            }

            new KTModal('#modal_add').show()
        }
    }

    function _edit_cat(datas) {
        const data = JSON.parse(atob(datas))
        if (data) {
            console.log(data)
        }
    }

    function _drop(uid) {
        //
    }
</script>
@endsection
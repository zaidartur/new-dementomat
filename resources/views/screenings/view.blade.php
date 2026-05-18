@extends('layouts.layout')

@section('title', 'Hasil Skrining')


@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
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
                                <th scope="col" class="w-10" data-kt-datatable-column="kecamatan">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Kecamatan</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="skrining">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Tanggal Skrining</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="hasil">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Hasil Skrining</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="faskes">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Faskes</span>
                                        <span class="kt-table-col-sort"></span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="status">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Status Terakhir</span>
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
@endsection
@extends('layouts.layout')

@section('title', 'Data Video')


@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-youtube text-lg"></i>
                Data Video
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                Data video Tutorial maupun Informasi
            </div>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="grid w-full space-y-5">
        <div class="kt-card">
            <div class="kt-card-header min-h-16">
                <input type="text" placeholder="Pencarian Nama..." class="kt-input sm:w-50 gap-2" data-kt-datatable-search="#kt_datatable_remote_filters" />
            </div>
            <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-30" data-kt-datatable-column="judul">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Judul</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-50" data-kt-datatable-column="video">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Video</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="status">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Status</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="opsi">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Opsi</span>
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($list as $item)
                                <tr>
                                    <td>{{ $item->judul }}</td>
                                    <td>
                                        <iframe width="480" height="320" src="{{ str_replace('watch?v=', 'embed/',$item->embed_link) }}" title="{{ $item->judul }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
                                    </td>
                                    <td>{!! $item->status == 'active' ? '<span class="kt-badge kt-badge-success">Aktif</span>' : '' !!}</td>
                                    <td>
                                        <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-ghost" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                            <i class="ki-filled ki-message-edit text-lg"></i>
                                            <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                <span class="flex items-center gap-1.5">Edit Video</span>
                                            </span>
                                        </button>
                                        <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-destructive" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                            <i class="ki-filled ki-trash-square text-lg"></i>
                                            <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                <span class="flex items-center gap-1.5">Hapus Video</span>
                                            </span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@extends('layouts.layout')

@section('title', 'Data Slider')


@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-slider-horizontal-2 text-lg"></i>
                Data Slider
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
                <input type="text" placeholder="Pencarian Nama..." class="kt-input sm:w-50 gap-2" data-kt-datatable-search="#kt_datatable_remote_filters" />

                <button type="button" id="kt_datatable_add" class="kt-btn bg-green-500 hover:bg-emerald-600" onclick="_new_image()">
                    <i class="ki-filled ki-plus-circle text-md"></i>
                    Tambah Gambar
                </button>
            </div>
            <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-10" data-kt-datatable-column="judul">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">ID</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="judul">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Keterangan</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-50" data-kt-datatable-column="video">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Gambar</span>
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
                                    <td>{{ $item->slider_id }}</td>
                                    <td>{{ $item->keterangan ?? '-' }}</td>
                                    <td>
                                        <img src="/slider-image/{{ Crypt::encryptString($item->slider_id) }}" class="kt-img-thumbnail max-h-[100px] cursor-pointer" alt="Slider" title="Klik untuk melihat gambar asli" onclick="_show_img('{{ Crypt::encryptString($item->slider_id) }}')">
                                    </td>
                                    <td>{!! $item->status == 'active' ? '<span class="kt-badge kt-badge-success">Aktif</span>' : '<span class="kt-badge kt-badge-destructive">Nonaktif</span>' !!}</td>
                                    <td>
                                        <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-ghost" onclick="_edit_image('{{ base64_encode(json_encode($item)) }}', '{{ Crypt::encryptString($item->slider_id) }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                            <i class="ki-filled ki-message-edit text-lg"></i>
                                            <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                <span class="flex items-center gap-1.5">Edit Gambar</span>
                                            </span>
                                        </button>
                                        <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-destructive" onclick="_drop_image('{{ $item->slider_id }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                            <i class="ki-filled ki-trash-square text-lg"></i>
                                            <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                <span class="flex items-center gap-1.5">Hapus Gambar</span>
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

<div class="kt-modal" data-kt-modal="true" id="modal_add">
    <div class="kt-modal-content max-w-[650px] top-[20%]">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_add">Edit Data Pengguna</h3>
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
                    <form method="POST" id="form_add" class="kt-form" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="uid" name="uid" value="">
                        {{-- <div class="kt-form-item">
                            <label class="kt-form-label">
                                File Gambar* :
                                <span class="kt-badge kt-badge-info kt-badge-sm">
                                    <i class="ki-filled ki-information-2 text-xs"></i>
                                    (Format jpg, jpeg, png, ukuran maksimum 3Mb)
                                </span>
                            </label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-bucket-square text-lg"></i>
                                    <input type="file" id="gambar" name="gambar" class="kt-input w-full" accept=".jpg,.jpeg,.png" required />
                                </div>
                            </div>
                        </div> --}}
                        <div class="kt-form-item">
                            <div class="w-full space-y-4">
                                <div class="space-y-1">
                                    <div class="text-sm font-medium text-mono">File Gambar*</div>
                                    <p class="text-xs text-muted-foreground">
                                        Format gambar yang diperbolehkan adalah <b>jpg, jpeg, png</b>. Untuk ukuran, maksimum <b>3Mb</b>
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
                                            <div data-kt-image-input-preview="true" class="kt-image-input-preview rounded-lg"></div>
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
                        <div class="kt-form-item mb-10">
                            <label class="kt-form-label">Keterangan Gambar: <small>(opsional)</small></label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-subtitle text-lg"></i>
                                    <input type="text" class="kt-input" id="keterangan" name="keterangan" placeholder="Keterangan Gambar" maxlength="150" />
                                </div>
                            </div>
                        </div>
                        <div class="kt-form-item mb-10">
                            <label class="kt-form-label">Status Gambar* :</label>
                            <div class="kt-form-control">
                                <div class="flex items-center gap-2">
                                    <input class="kt-switch" type="checkbox" id="status" name="status" value="aktif" checked />
                                    <label class="kt-label" for="switch">
                                        Aktif <small>(gambar akan tampil di halaman)</small>
                                    </label>
                                </div>
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
    let myType = null
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
        }
    })

    $(document).ready(function() {
        $('#form_add').on('submit', function(e) {
            e.preventDefault()
            let gambar = document.getElementById('gambar')
            var formAction = $('#form_add').attr('action')
            const MAX_SIZE = 3 * 1024 * 1024; // 3MB

            const file = gambar.files[0]
            if (myType === 'save' && (!file || file === undefined)) {
                $('#alert_image').removeClass('hidden')
            }

            if (myType === 'save' && (file && file.size > MAX_SIZE)) {
                _swal_alert('error', 'Ukuran file terlalu bersar. Batas ukuran maksimum file adalah 2Mb.')
                // Swal.fire('Peringatan', 'Ukuran file terlalu bersar. Batas ukuran maksimum file adalah 2Mb.', 'warning')
                e.target.value = ''
                return
            }

            if ((myType === 'save' && gambar.value && formAction) || myType === 'update') {
                $('#alert_image').addClass('hidden')
                let form = document.getElementById('form_add')
                let formData = new FormData(form)
                $('#form_add button').attr('disabled', 'true')
                $.ajax({
                    url: formAction,
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    processData: false,
                    contentType: false,
                    success: function(res) {
                        $('#form_add button').removeAttr('disabled')
                        Swal.fire('Berhasil', res.message, 'success').then(function() { location.reload() })
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                        Swal.fire('Error', xhr.responseJSON.message, 'error')
                        $('#form_add button').removeAttr('disabled')
                    }
                })
            }
        })
    })

    function _new_image() {
        myType = 'save'
        $('#title_add').html('Tambah Gambar Baru')
        $('#form_add')[0].reset()
        $('#form_add').attr('action', "{{ route('slider.save') }}")
        $('.kt-image-input-preview').removeAttr('style')
        new KTModal('#modal_add').show()
    }

    function _edit_image(datas, id) {
        const data = JSON.parse(atob(datas))
        if (data) {
            myType = 'update'
            $('#form_add')[0].reset()
            $('#title_add').html('Edit Gambar Existing')
            $('#form_add').attr('action', "{{ route('slider.update') }}")

            $('.kt-image-input-preview').css('background-image', `url(/slider-image/${id})`)
            $('#uid').val(data.slider_id)
            $('#keterangan').val(data.keterangan)
            if (data.status === 'active') {
                $('#status').attr('checked', '')
            } else {
                $('#status').removeAttr('checked')
            }
            new KTModal('#modal_add').show()
        }
    }

    function _drop_image(id) {
        Swal.fire({
            title: 'Hapus Gambar?',
            html: 'Anda yakin ingin menghapus gambar tersebut?',
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Konfirmasi',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('slider.drop') }}",
                    type: 'POST',
                    data: {uid: id},
                    dataType: 'JSON',
                    success: function(res) {
                        Swal.fire('Sukes', res.message, 'success').then(function() { location.reload() })
                    },
                    error: function(xhr, status, error) {
                        console.log(error)
                        Swal.fire('Error', xhr.responseJSON.message, 'error')
                    }
                })
            }
        })
    }

    function _verify_image(val) {
        if (val && myType === 'save') {
            $('#alert_image').addClass('hidden')
        } else {
            $('#alert_image').removeClass('hidden')
        }
    }

    function _show_img(img) {
        window.open('/slider-image/' + img, '_blank')
    }
</script>
@endsection
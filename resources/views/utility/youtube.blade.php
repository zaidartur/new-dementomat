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

                <button type="button" id="kt_datatable_add" class="kt-btn kt-btn-destructive" onclick="_new_video()">
                    <i class="ki-filled ki-youtube text-md"></i>
                    Tambah Video
                </button>
            </div>
            <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-40" data-kt-datatable-column="judul">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Judul</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-30" data-kt-datatable-column="video">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Video</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="status">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Status</span>
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="opsi">
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
                                    <td>{!! $item->status == 'active' ? '<span class="kt-badge kt-badge-success">Aktif</span>' : '<span class="kt-badge kt-badge-destructive">Nonaktif</span>' !!}</td>
                                    <td>
                                        <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-ghost" onclick="_edit('{{ base64_encode(json_encode($item)) }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                            <i class="ki-filled ki-message-edit text-lg"></i>
                                            <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                <span class="flex items-center gap-1.5">Edit Video</span>
                                            </span>
                                        </button>
                                        <button class="kt-btn kt-btn-icon kt-btn-outline kt-btn-destructive" onclick="_delete('{{ $item->id }}', '{{ $item->judul }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
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
                    <form method="POST" id="form_add" class="kt-form">
                        @csrf
                        <input type="hidden" id="uid" name="uid" value="">
                        <div class="kt-form-item">
                            <label class="kt-form-label">Judul video* :</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-subtitle text-lg"></i>
                                    <input type="text" class="kt-input" id="judul" name="judul" placeholder="Judul Video" maxlength="150" required data-kt-modal-input-focus="true" />
                                </div>
                            </div>
                        </div>
                        <div class="kt-form-item mb-10">
                            <label class="kt-form-label">URL Youtube* : </label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-subtitle text-lg"></i>
                                    <input type="url" class="kt-input" id="video" name="video" placeholder="https://www.youtube.com/watch?v=Sv5_0xrkvQY" maxlength="150" onchange="_video(this.value)" required />
                                </div>
                                <div class="w-full" id="video_frame"></div>
                            </div>
                        </div>
                        <div class="kt-form-item mb-10">
                            <label class="kt-form-label">Status Video* :</label>
                            <div class="kt-form-control">
                                <div class="flex items-center gap-2">
                                    <input class="kt-switch" type="checkbox" id="status" name="status" value="aktif" checked />
                                    <label class="kt-label" for="switch">
                                        Aktif <small>(video akan tampil di halaman)</small>
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

            var formAction = $('#form_add').attr('action')
            $('#form_add button').attr('disabled', 'true')
            let form = document.getElementById('form_add')
            let formData = new FormData(form)

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
        })
    })

    function _new_video() {
        myType = 'save'
        $('#title_add').html('Tambah Video Baru')
        $('#form_add')[0].reset()
        $('#form_add').attr('action', "{{ route('video.save') }}")
        new KTModal('#modal_add').show()
    }

    function _edit(datas) {
        const data = JSON.parse(atob(datas))
        if (data) {
            myType = 'update'
            $('#title_add').html('Edit Video')
            $('#form_add')[0].reset()
            $('#form_add').attr('action', "{{ route('video.update') }}")

            $('#uid').val(data.id)
            $('#judul').val(data.judul)
            $('#video').val(data.embed_link)
            $('#video').trigger('change')
            if (data.status === 'active') {
                $('#status').attr('checked', '')
            } else {
                $('#status').removeAttr('checked')
            }
            new KTModal('#modal_add').show()
        }
    }

    function _delete(id, name) {
        Swal.fire({
            title: 'Hapus Video?',
            html: `Anda yakin ingin menghapus video <b>${name}</b>?`,
            icon: 'question',
            showCancelButton: true,
            cancelButtonText: 'Batalkan',
            confirmButtonText: 'Konfirmasi',
            allowOutsideClick: false,
            allowEscapeKey: false,
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ route('video.drop') }}",
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

    function _video(url) {
        console.log(url)
        $('#video_frame').html('')
        let vid = standardizeYoutubeUrl(url)
        if (vid) {
            console.log(vid)
            const text = `<iframe width="480" height="320" src="${vid.replace('watch?v=', 'embed/')}" title="" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>`
            $('#video_frame').append(text)
            $('#video').val(vid)
        } else {
            console.log('kosong')
            const text = `<div class="kt-alert kt-alert-light kt-alert-destructive">
                                <div class="kt-alert-icon">
                                    <i class="ki-filled ki-shield-cross text-lg text-destructive"></i>
                                </div>
                                <div class="kt-alert-title">URL Youtube tidak sesuai.</div>
                            </div>`
            $('#video_frame').append(text)
            $('#video').val('')
        }
    }

    function standardizeYoutubeUrl(url) {
        // 1. Reuse the RegEx to extract the 11-character Video ID
        const regExp = /^((?:https?:)?\/\/)?((?:www|m)\.)?((?:youtube(-nocookie)?\.com|youtu\.be))(\/(?:[\w\-]+\?v=|embed\/|live\/|shorts\/|v\/)?)([\w\-]{11})(\S+)?$/;
        const match = url.match(regExp);
        
        const videoId = (match && match[6].length === 11) ? match[6] : null;

        // 2. If a valid ID is found, return the standardized URL. Otherwise, return null.
        if (videoId) {
            return `https://www.youtube.com/watch?v=${videoId}`;
        }
        
        return null; // Or return original URL, or throw an error depending on your needs
    }
</script>
@endsection
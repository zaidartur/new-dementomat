@extends('layouts.layout')

@section('title', 'Contact Person')


@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-address-book text-lg"></i>
                Contact Person
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                @hasanyrole(['admin', 'superadmin'])
                Data kontak / nomor telepon PIC petugas faskes dan admin dinkes
                @endhasanyrole

                @role('faskes')
                Data kontak PIC untuk Faskes {{ Auth::user()->faskes->nama_faskes }}
                @endrole
            </div>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="grid w-full space-y-5">
        <div class="kt-card">
            <div class="kt-card-header min-h-16">
                {{-- <input type="text" placeholder="Pencarian Nama..." class="kt-input sm:w-50" data-kt-datatable-search="#kt_datatable_remote_filters" /> --}}

                <button type="button" id="kt_datatable_remote_filters_apply" class="kt-btn kt-btn-sm kt-btn-primary" onclick="_new_contact()">
                    <i class="ki-filled ki-plus-circle text-md"></i>
                    Tambah Kontak
                </button>
            </div>
            <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                <div class="kt-table-wrapper kt-scrollable">
                    <table class="kt-table" data-kt-datatable-table="true">
                        <thead>
                            <tr>
                                <th scope="col" class="w-25" data-kt-datatable-column="judul">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Judul Kontak</span>
                                        {{-- <span class="kt-table-col-sort"></span> --}}
                                    </span>
                                </th>
                                <th scope="col" class="w-25" data-kt-datatable-column="nama">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Nama Kontak</span>
                                        {{-- <span class="kt-table-col-sort"></span> --}}
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="telepon">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Telepon</span>
                                        {{-- <span class="kt-table-col-sort"></span> --}}
                                    </span>
                                </th>
                                <th scope="col" class="w-10" data-kt-datatable-column="level">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Level Kontak</span>
                                        {{-- <span class="kt-table-col-sort"></span> --}}
                                    </span>
                                </th>
                                <th scope="col" class="w-20" data-kt-datatable-column="faskes">
                                    <span class="kt-table-col">
                                        <span class="kt-table-col-label">Faskes</span>
                                        {{-- <span class="kt-table-col-sort"></span> --}}
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
                            @foreach ($lists as $item)
                                <tr>
                                    <td>{{ $item->judul_kontak }}</td>
                                    <td>{{ $item->nama_kontak }}</td>
                                    <td>{{ $item->nomor_wa }}</td>
                                    <td class="capitalize">{{ $item->jenis_kontak }}</td>
                                    <td>{{ $item->faskes ? $item->faskes->nama_faskes : '' }}</td>
                                    <td>
                                        <span class="inline-flex gap-2.5">
                                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_edit('{{ Crypt::encryptString($item->id) }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-pencil" aria-hidden="true">
                                                    <path d="M21.174 6.812a1 1 0 0 0-3.986-3.987L3.842 16.174a2 2 0 0 0-.5.83l-1.321 4.352a.5.5 0 0 0 .623.622l4.353-1.32a2 2 0 0 0 .83-.497z"></path>
                                                    <path d="m15 5 4 4"></path>
                                                </svg>
                                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                    <span class="flex items-center gap-1.5">Edit Pengguna</span>
                                                </span>
                                            </a>
                                            <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline kt-btn-destructive" onclick="_delete('{{ Crypt::encryptString($item->id) }}', '{{ $item->judul_kontak }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash" aria-hidden="true">
                                                    <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6"></path>
                                                    <path d="M3 6h18"></path>
                                                    <path d="M8 6V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                </svg>
                                                <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                    <span class="flex items-center gap-1.5">
                                                        Hapus Pengguna
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"class="lucide lucide-triangle-alert text-yellow-500 size-4" aria-hidden="true">
                                                            <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                                                            <path d="M12 9v4"></path>
                                                            <path d="M12 17h.01"></path>
                                                        </svg>
                                                    </span>
                                                </span>
                                            </a>
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{-- <template><!--begin:pagination--></template>
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
                <template><!--end:pagination--></template> --}}
            </div>
        </div>
    </div>
</div>

<div class="kt-modal" data-kt-modal="true" id="modal_kontak">
    <div class="kt-modal-content max-w-[50%] top-[10%]">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_modal">Detail Pengguna</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_kontak">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg w-full grow h-full">
                <div class="p-2">
                    <form class="kt-form" id="form_kontak">
                        @csrf
                        <input type="hidden" id="uid" name="uid" value="">
                        <div class="kt-form-item">
                            <label class="kt-form-label">Judul Kontak:</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-subtitle text-lg"></i>
                                    <input type="text" class="kt-input" id="judul" name="judul" placeholder="Judul Kontak" maxlength="100" required autofocus />
                                </div>
                            </div>
                            <div class="kt-form-message">Mohon mengisi judul kontak.</div>
                        </div>
                        <div class="kt-form-item">
                            <label class="kt-form-label">Nama Kontak:</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-address-book text-lg"></i>
                                    <input type="text" class="kt-input" id="nama" name="nama" placeholder="Nama Kontak" maxlength="100" required />
                                </div>
                            </div>
                            <div class="kt-form-message">Mohon mengisi nama kontak.</div>
                        </div>
                        <div class="kt-form-item">
                            <label class="kt-form-label">Nomor WhatsApp:</label>
                            <div class="kt-form-control">
                                <div class="kt-input">
                                    <i class="ki-filled ki-phone text-lg"></i>
                                    <input type="number" class="kt-input" id="phone" name="phone" placeholder="628xxx" required />
                                </div>
                            </div>
                            <div class="kt-form-message">Mohon mengisi nomor whatsapp.</div>
                        </div>
                        @if (Request()->user()->hasAnyRole(['superadmin', 'admin']))
                            <div class="kt-form-item">
                                <label class="kt-form-label">Jenis Kontak</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="jenis" name="jenis" data-kt-select-placeholder="Pilih jenis..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' onchange="_jenis(this.value)" required>
                                        <option value="">Pilih Jenis</option>
                                        <option value="admin">Kontak Admin</option>
                                        <option value="faskes">Kontak Faskes</option>
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih faskes.</div>
                            </div>
                            <div class="kt-form-item is-faskes hidden" id="is_faskes">
                                <label class="kt-form-label">Faskes:</label>
                                <div class="kt-form-control">
                                    <select class="kt-select" data-kt-select="true" id="faskes" name="faskes" data-kt-select-placeholder="Pilih faskes..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}'>
                                        <option value="">Pilih Faskes</option>
                                        @foreach ($faskes as $item)
                                            <option value="{{ $item->faskes_id }}">{{ $item->nama_faskes }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="kt-form-message">Mohon memilih faskes.</div>
                            </div>
                        @endif
                        <div class="kt-form-actions">
                            <button type="button" class="kt-btn kt-btn-outline" data-kt-modal-dismiss="#modal_kontak">Batalkan</button>
                            <button type="submit" class="kt-btn bg-green-500">Submit</button>
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
    let myMode = null
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })

    $(document).ready(function() {
        $('#form_kontak').on('submit', function(e) {
            e.preventDefault()

            let isValid = true;
        
            const judul = $('#judul').val().trim()
            const nama = $('#nama').val().trim()
            const phone = parseInt($('#phone').val().trim())
            const phoneRegex = /^628\d{6,11}$/;

            if (judul === "") {
                $('#judul').attr('aria-invalid', 'true')
                isValid = false;
            } else {
                $('#judul').attr('aria-invalid', 'false')
            }

            if (nama === "") {
                $('#nama').attr('aria-invalid', 'true')
                isValid = false;
            } else {
                $('#nama').attr('aria-invalid', 'false')
            }

            if (phone === "" || !phoneRegex.test(phone)) {
                $('#phone').attr('aria-invalid', 'true')
                isValid = false;
            } else {
                $('#phone').attr('aria-invalid', 'false')
            }

            if (isValid) {
                const formData = $(this).serialize()
                const url = (myMode === 'save' ? "{{ route('kontak.simpan') }}" : (myMode === 'update' ? "{{ route('kontak.update') }}" : null))
                if (!url) return

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(res) {
                        Swal.fire('Sukses', res.message, 'success').then(function() { location.reload() })
                    },
                    error: function(xhr, status, error) {
                        console.error(error)
                        Swal.fire('Error', xhr.responseJSON.message, 'error')
                    }
                })
            }
        })

    })

    function _new_contact() {
        $('#title_modal').html('Tambah Kontak')
        $('#form_kontak')[0].reset()
        myMode = 'save'

        new KTModal('#modal_kontak').show()
    }

    function _edit(id) {
        $.ajax({
            url: '/kontak/detail/' + id,
            type: 'GET',
            dataType: 'JSON',
            success: function(res) {
                $('#title_modal').html('Tambah Kontak')
                $('#form_kontak')[0].reset()
                fetch_edit(res.data)

                myMode = 'update'
                new KTModal('#modal_kontak').show()
            },
            error: function(xhr, status, error) {
                console.log('err', error, xhr)
                Swal.fire('Error', xhr.responseJSON.message, 'error')
            }
        })
    }

    function fetch_edit(data) {
        $('#uid').val(data.uid)
        $('#judul').val(data.judul_kontak)
        $('#nama').val(data.nama_kontak)
        $('#phone').val(data.nomor_wa)

        @if(Request()->user()->hasAnyRole(['superadmin', 'admin']))
            const selectJenis = document.querySelector('#jenis')
            selectJenis.value = data.jenis_kontak
            const selectInstances = KTSelect.getInstance(selectJenis)
            if (selectInstances) {
                selectInstances.update()
            }

            fs = document.querySelector('#is_faskes')
            if (data.jenis_kontak === 'admin') {
                const selectFaskes = document.querySelector('#faskes');
                selectFaskes.value = ''
                const selectInstance = KTSelect.getInstance(selectFaskes)
                if (selectInstance) {
                    selectInstance.update()
                }

                fs.classList.add('hidden')
                $('#faskes').removeAttr('required')
            } else {
                const selectFaskes = document.querySelector('#faskes');
                selectFaskes.value = data.id_faskes
                const selectInstance = KTSelect.getInstance(selectFaskes)
                if (selectInstance) {
                    selectInstance.update()
                }

                fs.classList.remove('hidden')
                $('#faskes').attr('required', 'true')
            }
        @endif
    }

    function _delete(uid, name) {
        if (uid) {
            Swal.fire({
                title: 'Hapus Kontak',
                html: `Anda yakin ingin menghapus data <b>${name}</b>?`,
                icon: 'question',
                showCancelButton: true,
                cancelButtonText: 'Batalkan',
                confirmButtonText: 'Konfirmasi',
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ route('kontak.hapus') }}",
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

    @if (Request()->user()->hasAnyRole(['superadmin', 'admin']))
    function _jenis(val) {
        console.log(val)
        fs = document.querySelector('#is_faskes')
        if (val === 'faskes') {
            fs.classList.remove('hidden')
            $('#faskes').attr('required', 'true')
        } else if (val === 'admin') {
            fs.classList.add('hidden')
            $('#faskes').removeAttr('required')
        } else {
            fs.classList.add('hidden')
            $('#faskes').removeAttr('required')
        }
    }
    @endif
</script>
@endsection
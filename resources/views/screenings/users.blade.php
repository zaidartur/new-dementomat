@extends('layouts.layout')

@section('title', 'Skrining TBC Dewasa')


@section('content')
<div class="kt-container-fixed">
    <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
        <div class="flex flex-col justify-center gap-2">
            <h1 class="text-xl font-medium leading-none text-mono">
                <i class="ki-filled ki-shield-tick text-lg"></i>
                Skrining TBC
            </h1>
            <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                Data hasil deteksi dini skrining TBC
                {{-- Hasil dari aplikasi ini bukanlah diagnosis mutlak. Penegakan diagnosis hanya dapat dilakukan melalui pemeriksaan laboratorium di fasilitas kesehatan. --}}
            </div>
        </div>
    </div>
</div>

<div class="kt-container-fixed">
    <div class="w-full mb-10">
        <button type="button" id="btn_add" class="kt-btn kt-btn-primary w-full md:w-[30%] rounded-full text-lg md:text-sm p-7 md:p-2" onclick="_new_skrining()">
            <i class="ki-filled ki-plus-circle text-xl md:text-lg"></i>
            Buat Skrining Baru
        </button>
    </div>
    <div class="grid w-full space-y-5">
        <div class="kt-card">
            <div class="kt-card-header min-h-16">
                <h1 class="font-medium text-lg">
                    5 Daftar Riwayat Skrining Terbaru<br>
                    <small class="font-normal text-gray-500 dark:text-gray-200">(Klik untuk melihat detail)</small>
                </h1>
            </div>
            <div class="kt-card-content">
                <div class="flex flex-col gap-4 md:grid md:grid-cols-2">
                    @if (count($logs) > 0)
                    @foreach ($logs as $item)
                    <div class="kt-card cursor-pointer transition-all duration-300 ease-in-out hover:-translate-y-1 hover:shadow-lg hover:border-indigo-500" onclick="_detail('{{ base64_encode(json_encode($item)) }}')">
                        <div class="kt-card-content space-y-4">
                            <div>
                                <div class="flex items-center justify-between text-sm">
                                    <h3 class="text-sm font-semibold text-foreground">{{ $item->kategori->nama_kategori }}</h3>
                                    <span class="text-muted-foreground text-foreground">Skor {{ $item->is_yes_count }} / {{ $item->is_yes_count + $item->is_no_count }}</span>
                                </div>
                                {{-- <h3 class="text-sm font-semibold text-foreground">{{ $item->kategori->nama_kategori }}</h3> --}}
                                <p class="mt-1 text-sm font-medium {{ empty($item->triggered_rule_id) ? 'text-emerald-700' : 'text-red-700' }} bg-sky-100 rounded-[10px] p-3 dark:bg-sky-800 {{ empty($item->triggered_rule_id) ? 'dark:text-emerald-300' : 'dark:text-red-200' }}">
                                    <i class="ki-filled ki-{{ empty($item->triggered_rule_id) ? 'verify' : 'cross-circle' }} text-sm md:text-lg"></i>
                                    {{ $item->triggeredRule?->rekomendasi }}
                                </p>
                                <small><i>Gunakan aplikasi versi mobile (Android) untuk kemudahan akses dan tinak lanjut.</i></small>
                            </div>
                            <div class="flex items-center justify-between text-sm">
                                <span class="text-muted-foreground">Status: {{ $item->status_skrining }}</span>
                                <span class="font-medium text-foreground">{{ \Carbon\Carbon::parse($item->created_at)->locale('id')->translatedFormat('d F Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @else
                    <h1 class="w-full text-center font-medium text-lg">Belum ada riwayat untuk saat ini</h1>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="kt-modal" data-kt-modal="true" id="modal_detail">
    <div class="kt-modal-content max-w-[650px] md:top-[5%] max-h-[93%] md:h-auto">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_add">Detail Riwayat Skrining</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_detail">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg w-full grow">
                <div class="p-2 flex justify-center" id="content_div">

                    <div class="w-full max-w-4xl max-h-[400vh] flex flex-col rounded-xl border border-slate-200 overflow-hidden transform scale-100 transition-all">
                        <div class="flex-1 overflow-y-auto p-6 grid grid-cols-1 md:grid-cols-1 gap-6">
                            <div class="md:col-span-2 space-y-5">
                                <div>
                                    <h4 class="text-xs text-center md:text-left font-bold uppercase tracking-wider text-slate-400 mb-3">Rekapitulasi Kuesioner Awal</h4>
                                    <div class="rounded-lg bg-slate-50 dark:bg-gray-800 p-4 border border-slate-100 flex flex-col md:flex-row md:items-center justify-between" id="res_header">
                                        <div>
                                            <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Kesimpulan Rekomendasi Sistem</span>
                                            <span class="text-sm font-bold text-red-600 mt-0.5 block text-center md:text-left" id="head_rekom">Suspek TBC (Rujuk Pemeriksaan Dahak TCM)</span>
                                        </div>
                                        <div class="mt-5 md:text-right">
                                            <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Akumulasi Skor</span>
                                            <span class="text-xl font-extrabold text-slate-800 dark:text-gray-100 block text-center md:text-left ">5 <span class="text-xs text-slate-400 font-normal">/ 7 Gejala</span></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="rounded-lg bg-slate-50 dark:bg-gray-800 p-4 border border-slate-100 flex flex-col md:flex-row md:items-center justify-between" id="res_subheader">
                                    <div>
                                        <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Usia Saat Skrining</span>
                                        <span class="text-sm font-bold mt-0.5 block text-center md:text-left ">20 Tahun 6 Bulan 2 Minggu 3 Hari</span>
                                    </div>
                                    <div class="mt-3">
                                        <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Tanggal TCM</span>
                                        <span class="text-sm font-bold mt-0.5 block text-center md:text-left ">20 Mei 2026 <br>(Puskesmas Karangpandan)</span>
                                    </div>
                                </div>
                                <div class="flex justify-center">
                                    <button class="kt-btn kt-btn-outline kt-btn-primary">
                                        <i class="ki-filled ki-file-down"></i>
                                        Unduh File
                                    </button>
                                </div>
                                <div id="list_content">
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 text-center md:text-left ">Detail Jawaban Indikasi</h4>
                                    <div class="divide-y divide-slate-100 border border-slate-100 rounded-lg overflow-hidden">
                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                                            <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">1. Batuk berdahak secara terus menerus selama &ge; 2 Minggu?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                                            <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">2. Mengalami demam meriang sub-febris lebih dari satu bulan?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                                            <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">3. Terjadi penurunan berat badan drastis tanpa alasan jelas?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                                            <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">4. Mengeluarkan keringat berlebih di malam hari tanpa aktivitas?</span>
                                            <span class="inline-flex items-center rounded-full bg-emerald-100 px-2.5 py-0.5 text-xs font-semibold text-emerald-800">Tidak</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                                            <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">1. Batuk berdahak secara terus menerus selama &ge; 2 Minggu?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                                            <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">2. Mengalami demam meriang sub-febris lebih dari satu bulan?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                                            <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">3. Terjadi penurunan berat badan drastis tanpa alasan jelas?</span>
                                            <span class="inline-flex items-center rounded-full bg-red-100 px-2.5 py-0.5 text-xs font-semibold text-red-800">Ya</span>
                                        </div>

                                        <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                                            <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">4. Mengeluarkan keringat berlebih di malam hari tanpa aktivitas?</span>
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
    </div>
</div>

<div class="kt-modal" data-kt-modal="true" id="modal_add">
    <div class="kt-modal-content max-w-[650px] md:top-[5%] max-h-[93%] md:h-auto">
        <div class="kt-modal-header">
            <h3 class="kt-modal-title" id="title_add">Buat Skrining</h3>
            <button type="button" class="kt-modal-close" aria-label="Close modal" data-kt-modal-dismiss="#modal_add">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-x" aria-hidden="true">
                    <path d="M18 6 6 18"></path>
                    <path d="m6 6 12 12"></path>
                </svg>
            </button>
        </div>
        <div class="kt-modal-body">
            <div class="rounded-lg w-full grow">
                <div class="p-2">
                    <form class="kt-form" id="form_add" action="{{ route('skrining.user.save') }}" method="POST">
                        @csrf
                        <h2 class="w-full text-center font-medium text-lg" id="cat">Title Categories</h2>

                        <div class="w-full max-w-4xl max-h-[400vh] flex flex-col rounded-xl border border-slate-200 overflow-hidden transform scale-100 transition-all">
                            <div class="flex-1 overflow-y-auto p-6 grid grid-cols-1 md:grid-cols-1 gap-6">
                                <div class="md:col-span-2 space-y-5">
                                    <div>
                                        {{-- <h4 class="text-xs text-center md:text-left font-bold uppercase tracking-wider text-slate-400 mb-3">Rekapitulasi Kuesioner Awal</h4> --}}
                                        <div class="rounded-lg bg-slate-50 dark:bg-gray-800 p-4 border border-slate-100 flex flex-col md:flex-row md:items-center justify-between" id="add_header">
                                            <div>
                                                <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Kesimpulan Rekomendasi Sistem</span>
                                                <span class="text-sm font-bold text-red-600 mt-0.5 block text-center md:text-left" id="head_rekom">Suspek TBC (Rujuk Pemeriksaan Dahak TCM)</span>
                                            </div>
                                            <div class="mt-5 md:text-right">
                                                <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Akumulasi Skor</span>
                                                <span class="text-xl font-extrabold text-slate-800 dark:text-gray-100 block text-center md:text-left ">5 <span class="text-xs text-slate-400 font-normal">/ 7 Gejala</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="kt-alert kt-alert-light kt-alert-warning">
                            <div class="kt-alert-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-info" aria-hidden="true">
                                    <circle cx="12" cy="12" r="10"></circle>
                                    <path d="M12 16v-4"></path>
                                    <path d="M12 8h.01"></path>
                                </svg>
                            </div>
                            <div class="kt-alert-title">Pilihlah parameter yang sesuai dengan gejala Anda.</div>
                        </div>

                        <div class="w-full max-w-4xl max-h-[400vh] flex flex-col rounded-xl border border-slate-200 overflow-hidden transform scale-100 transition-all">
                            <div class="flex-1 overflow-y-auto p-6 grid grid-cols-1 md:grid-cols-1 gap-6" id="list_param">
                                <div class="flex items-center gap-2">
                                    <input type="checkbox" class="kt-checkbox" id="check" value="1" />
                                    <label class="kt-label" for="check">Accept terms and conditions</label>
                                </div>
                            </div>
                        </div>


                        <div class="kt-form-actions">
                            <button type="button" class="kt-btn kt-btn-outline" data-kt-modal-dismiss="#modal_add">Batalkan</button>
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
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })


    function _new_skrining() {
        $.ajax({
            url: "{{ route('skrining.user.add') }}",
            type: 'POST',
            dataType: 'JSON',
            success: function(res) {
                const param = res.data.params
                const cat = res.data.kategori
                const bio = res.data.bio
                console.log(res.data)

                $('#cat').html(cat.nama_kategori)
                fetch_add_header(bio)
                fetch_add_content(param)

                new KTModal('#modal_add').show()
            },
            error: function(xhr, status, error) {
                console.log('err', error, xhr)
                Swal.fire('Error', xhr.responseJSON.message, 'error')
                // _swal_alert('error', xhr.responseJSON.message)
            }
        })
    }

    function fetch_add_header(data) {
        let text = `
                <div>
                    <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">${data.nama_lengkap}</span>
                    <span class="text-sm font-bold mt-0.5 block text-center md:text-left">${data.nik}</span>
                </div>
                <div class="mt-2 md:text-right">
                    <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">${data.jenkel === 'L' ? 'Laki-Laki' : 'Perempuan'}</span>
                    <span class="text-sm font-extrabold text-slate-800 dark:text-gray-100 block text-center md:text-left ">${data.umur_detail}</span>
                </div>
        `

        $('#add_header').html(text)
    }

    function fetch_add_content(data) {
        let text = ''
        if (data && Array.isArray(data)) {
            data.forEach((dt, i) => {
                text += `
                    <div class="flex items-start gap-2">
                        <input type="checkbox" class="kt-checkbox" id="check_${dt.kode}" name="parameter[${dt.uid_parameter}]" value="1" />
                        <label class="kt-label" for="check_${dt.kode}">${dt.pertanyaan}</label>
                    </div>
                `
            })
        }

        $('#list_param').html(text)
    }

    function _detail(datas) {
        const data = JSON.parse(atob(datas))
        fetch_modal_header(data)
        fetch_modal_content(data.data_response)

        new KTModal('#modal_detail').show()
    }

    function fetch_modal_header(data) {
        let text = ''
        let subs = ''
        text += `
            <div>
                <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Kesimpulan Rekomendasi Sistem</span>
                <span class="text-sm font-bold ${data.triggered_rule.rekomendasi.includes('Aman') ? 'text-emerald-600' : 'text-red-600'} mt-0.5 block text-center md:text-left">${data.triggered_rule.rekomendasi}</span>
            </div>
            <div class="mt-5 md:text-right">
                <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Akumulasi Skor</span>
                <span class="text-xl font-extrabold text-slate-800 dark:text-gray-100 block text-center md:text-left ">${data.is_yes_count} <span class="text-xs text-slate-400 font-normal">/ ${data.is_yes_count + data.is_no_count} Gejala</span></span>
            </div>
        `

        subs += `
            <div>
                <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Usia Saat Skrining</span>
                <span class="text-sm font-bold mt-0.5 block text-center md:text-left ">${data.umur_lengkap_saat_skrining}</span>
            </div>
            <div class="mt-3">
                <span class="text-xs text-slate-400 block font-medium text-center md:text-left ">Tanggal TCM</span>
                <span class="text-sm font-bold mt-0.5 block text-center md:text-left ">${data.tgl_lengkap_tcm ? data.tgl_lengkap_tcm : '-'} <br>(${data.jenis_tcm === 'faskes' ? data.keluarga?.faskes?.nama_faskes : (data.jenis_tcm === 'mandiri' ? 'Mandiri' : 'Belum Tes TCM')})</span>
            </div>
        `


        $('#res_header').html(text)
        $('#res_subheader').html(subs)
    }

    function fetch_modal_content(datas) {
        let text = `<h4 class="text-xs font-bold uppercase tracking-wider text-slate-400 mb-3 text-center md:text-left ">Detail Jawaban Indikasi</h4>
                    <div class="divide-y divide-slate-100 border border-slate-100 rounded-lg overflow-hidden">`
        if (datas && Array.isArray(datas)) {
            datas.forEach((dt, i) => {
                text += `
                    <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 hover:bg-slate-50/50 dark:hover:bg-gray-200">
                        <span class="text-sm text-slate-700 dark:text-gray-300 dark:hover:text-slate-700 font-medium">${i+1}. ${dt.parameter.pertanyaan}</span>
                        <span class="inline-flex items-center rounded-full ${dt.is_yes ? 'bg-red-100' : 'bg-emerald-100'} px-2.5 py-0.5 text-xs font-semibold ${dt.is_yes ? 'text-red-800' : 'text-emerald-800'}">${dt.is_yes ? 'Ya' : 'Tidak'}</span>
                    </div>
                `       
            });
        }

        text += `<div></div>`

        $('#list_content').html(text)
    }
</script>
@endsection
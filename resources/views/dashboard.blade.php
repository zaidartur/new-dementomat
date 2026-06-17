@extends('layouts.layout')

@section('title', 'Dashboard')

@section('css')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
<style>
     .channel-stats-bg {
          background-image: url('{{ asset("assets/media/images/2600x1600/bg-3.png") }}');
     }
     .dark .channel-stats-bg {
          background-image: url('{{ asset("assets/media/images/2600x1600/bg-3-dark.png") }}');
     }
</style>
@endsection


@section('content')

<div class="kt-container-fixed">
     <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
          <div class="flex flex-col justify-center gap-2">
               @if (Auth::user()->hasAnyRole(['admin', 'superadmin', 'faskes']))
               <h1 class="text-xl font-medium leading-none text-mono">
                    <i class="ki-filled ki-element-11 text-lg"></i>
                    Dashboard
               </h1>
               <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{-- Selamat datang, {{ Auth::user()->name }}.  --}}
                    Ringkasan pantauan wilayah Anda hari ini
               </div>
               
               @elseif (Auth::user()->hasAnyRole(['user']))

               <h1 class="text-xl font-medium leading-none text-mono">
                    <i class="ki-filled ki-element-11 text-lg"></i>
                    Dashboard
               </h1>
               <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Selamat datang, <b>{{ Auth::user()->name }}</b>. 
               </div>
               @endif
          </div>
     </div>
</div>

<!-- Container -->
<div class="kt-container-fixed">
     <div class="w-full">
          <div class="grid gap-5 lg:gap-7.5">
               <!-- begin: grid -->
               <div class="grid lg:grid-cols-3 gap-y-5 lg:gap-7.5 items-stretch">
                    
                    @hasrole('faskes')
                    <div class="kt-card flex flex-col justify-between border border-red-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <i class="ki-filled ki-virus text-4xl text-red-500 w-7 mt-4 ms-5"></i>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-bold text-mono text-red-500">{{ count($darurat) }} jiwa</span>
                            <span class="text-sm font-medium text-red-500">Tindakan Darurat (Warga Suspek Baru)</span>
                        </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-sky-600 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <i class="ki-filled ki-watch text-4xl text-sky-600 w-7 mt-4 ms-5"></i>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-bold text-mono text-sky-600">{{ $tcm }} jiwa</span>
                            <span class="text-sm font-medium text-sky-600">Menunggu Hasil TCM dari Petugas</span>
                        </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-orange-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <i class="ki-filled ki-information-1 text-4xl text-orange-500 w-7 mt-4 ms-5"></i>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-bold text-mono text-orange-500">{{ count($lists) ?? 0 }} jiwa</span>
                            <span class="text-sm font-medium text-orange-500">Resiko Putus Obat</span>
                        </div>
                    </div>
                    @endhasrole

                    @hasanyrole(['admin', 'superadmin'])
                    <div class="kt-card flex flex-col justify-between border border-orange-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <i class="ki-filled ki-syringe text-4xl text-orange-500 w-7 mt-4 ms-5"></i>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-bold text-mono text-orange-500">{{ $aktif }} jiwa</span>
                            <span class="text-sm font-medium text-orange-500">Total Pasien Aktif (Dalam Pengobatan)</span>
                        </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-emerald-600 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <i class="ki-filled ki-pulse text-4xl text-emerald-600 w-7 mt-4 ms-5"></i>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-bold text-emerald-600">{{ $rate }}%</span>
                            <span class="text-sm font-medium text-emerald-600">Angka Kesembuhan <i>(Cure Rate)</i> Tahun Ini<br>(Target Nasional <b>85%</b>) dari {{ $evaluasi }} pasien</span>
                        </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-red-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <i class="ki-filled ki-mask text-4xl text-red-500 w-7 mt-4 ms-5"></i>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-bold text-mono text-red-500">{{ $suspek }} jiwa</span>
                            <span class="text-sm font-medium text-red-500">Total Suspek Terjaring Bulan Ini ({{ $bulan }})</span>
                        </div>
                    </div>
                    @endhasanyrole

                    @hasrole('user')
                    <div class="kt-card flex flex-col justify-center border {{ $verify ? 'border-primary' : 'border-slate-500' }} gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                         <div class="text-center w-full md:text-left">
                              @if ($verify)
                                  <i class="ki-filled ki-verify text-4xl {{ $verify ? 'text-primary' : 'text-slate-500' }} w-7 mt-4 md:ms-5"></i>
                              @else
                                   <i class="ki-filled ki-question text-4xl {{ $verify ? 'text-primary' : 'text-slate-500' }} w-7 mt-4 md:ms-5"></i>
                              @endif
                         </div>
                         <div class="flex flex-col gap-1 pb-4 px-5 text-center md:text-left">
                            <span class="text-3xl font-bold text-mono {{ $verify ? 'text-primary' : 'text-slate-500' }}">{{ Auth::user()->name }}</span>
                            <span class="text-sm font-medium {{ $verify ? 'text-primary' : 'text-slate-500' }}">{{ $verify ? 'Akun Anda telah terverifikasi' : 'Akun Anda belum terverifikasi, silahkan lengkapi di profile Anda' }}</span>
                         </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-orange-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg cursor-pointer transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-gray-300 dark:hover:shadow-gray-700" onclick="{{ $verify ? ('location.href=`' .route('skrining.user'). '`') : '_error()' }}">
                         <div class="text-center w-full md:text-left">
                              <i class="ki-filled ki-questionnaire-tablet text-4xl text-orange-500 w-7 mt-4 md:ms-5"></i>
                         </div>
                         <div class="flex flex-col gap-1 pb-4 px-5 text-center md:text-left">
                            <span class="text-3xl font-bold text-mono text-orange-500">Skrining TBC</span>
                            <span class="text-sm font-medium text-orange-500">Cek gejala berkala (klik untuk memilih)</span>
                         </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-emerald-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg cursor-pointer transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-gray-300 dark:hover:shadow-gray-700" onclick="{{ $verify ? ('location.href=`' .route('profile'). '`') : '_error()' }}">
                         <div class="text-center w-full md:text-left">
                              <i class="ki-filled ki-questionnaire-tablet text-4xl text-emerald-500 w-7 mt-4 md:ms-5"></i>
                         </div>
                         <div class="flex flex-col gap-1 pb-4 px-5 text-center md:text-left">
                            <span class="text-3xl font-bold text-emerald-500">Edit Biodata</span>
                            <span class="text-sm font-medium text-emerald-500">Perbarui data diri (klik untuk memilih)</span>
                         </div>
                    </div>
                    @endhasrole

               </div>
          </div>
     </div>
</div>
<!-- End of Container -->

@hasrole('user')
<div class="kt-container-fixed mt-5 mb-5">
     <div class="w-full">
          <div class="grid gap-5 lg:gap-7.5">
               <h1 class="w-full font-medium text-gray-600 uppercase text-xl md:text-lg -mb-4 dark:text-gray-200">
                    Layanan Lanjutan 
                    <span class="capitalize italic">(Android Apps.)</span>
               </h1>
               <div class="grid lg:grid-cols-3 gap-y-5 lg:gap-7.5 items-stretch">
                    <div class="kt-card flex flex-col justify-between border border-gray-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                         <div class="text-center w-full md:text-left">
                              <i class="ki-filled ki-test-tubes text-4xl text-gray-500 w-7 mt-4 md:ms-5"></i>
                         </div>
                         <div class="flex flex-col gap-1 pb-4 px-5 text-center md:text-left">
                            <span class="text-3xl font-bold text-gray-500">Cek Dahak</span>
                            <span class="text-sm font-medium text-gray-500">Laporan pemeriksaan dahak mandiri/faskes</span>
                         </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-gray-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                         <div class="text-center w-full md:text-left">
                              <i class="ki-filled ki-people text-4xl text-gray-500 w-7 mt-4 md:ms-5"></i>
                         </div>
                         <div class="flex flex-col gap-1 pb-4 px-5 text-center md:text-left">
                            <span class="text-3xl font-bold text-gray-500">Input Keluarga</span>
                            <span class="text-sm font-medium text-gray-500">Tambahkan keluarga Anda untuk mendapatkan hasil dari skrining mereka</span>
                         </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-gray-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                         <div class="text-center w-full md:text-left">
                              <i class="ki-filled ki-capsule text-4xl text-gray-500 w-7 mt-4 md:ms-5"></i>
                         </div>
                         <div class="flex flex-col gap-1 pb-4 px-5 text-center md:text-left">
                            <span class="text-3xl font-bold text-gray-500">Pantauan Obat</span>
                            <span class="text-sm font-medium text-gray-500">Faskes dapat memantau perkembangan pengobatan Anda apabila hasil TCM Anda positif</span>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="kt-container-fixed mt-10 mb-5">
     <div class="w-full">
          <div class="grid gap-5 lg:gap-7.5">
               <div class="grid lg:grid-cols-3 gap-y-5 lg:gap-7.5 items-stretch">
                    <div class="kt-card flex flex-col justify-between border border-green-600 hover:bg-green-700 hover:border-gray-200 group gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg cursor-pointer transition-all duration-300 hover:-translate-y-2 hover:shadow-xl hover:shadow-gray-300 dark:hover:shadow-gray-700">
                         <div class="text-center w-full md:text-left">
                              <i class="ki-filled ki-google-play text-4xl text-green-600 group-hover:text-gray-100 w-7 mt-4 md:ms-5"></i>
                         </div>
                         <div class="flex flex-col gap-1 pb-4 px-5 text-center md:text-left">
                            <span class="text-3xl font-bold text-green-600 group-hover:text-gray-100">Unduh Aplikasi</span>
                            <span class="text-sm font-medium text-green-600 group-hover:text-gray-100">Unduh aplikasi Si Demen Tomat Terasi di Play Store</span>
                         </div>
                    </div>
               </div>
          </div>
     </div>
</div>
@endhasrole

@hasrole('faskes')
<div class="kt-container-fixed mt-10">
     <div class="grid w-full space-y-5">
          <div class="kt-card">
               <div class="kt-card-header min-h-16">
                    <h1 class="font-medium text-lg">
                         Tabel Radar Pantauan Cepat <i>(Quick Data Table)</i> <span class="kt-badge kt-badge-outline kt-badge-mono">5 Data Terbaru</span>
                    </h1>
               </div>
               <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                    <div class="kt-table-wrapper kt-scrollable">
                         <table class="kt-table" data-kt-datatable-table="true">
                         <thead>
                              <tr>
                                   <th scope="col" class="w-20" data-kt-datatable-column="nama">
                                        <span class="kt-table-col">
                                             <span class="kt-table-col-label">Nama & NIK</span>
                                        </span>
                                   </th>
                                   <th scope="col" class="w-30" data-kt-datatable-column="alamat">
                                        <span class="kt-table-col">
                                             <span class="kt-table-col-label">Alamat</span>
                                        </span>
                                   </th>
                                   <th scope="col" class="w-10" data-kt-datatable-column="faskes">
                                        <span class="kt-table-col">
                                             <span class="kt-table-col-label">Faskes</span>
                                        </span>
                                   </th>
                                   <th scope="col" class="w-10" data-kt-datatable-column="mulai">
                                        <span class="kt-table-col">
                                             <span class="kt-table-col-label">Tgl Mulai Obat</span>
                                        </span>
                                   </th>
                                   <th scope="col" class="w-10" data-kt-datatable-column="hari">
                                        <span class="kt-table-col">
                                             <span class="kt-table-col-label">Hari ke</span>
                                        </span>
                                   </th>
                                   <th scope="col" class="w-10" data-kt-datatable-column="persen">
                                        <span class="kt-table-col">
                                             <span class="kt-table-col-label">Tingkat Kepatuhan</span>
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
                              @if (count($lists) > 0)
                                  @foreach ($lists as $item)
                                   <tr>
                                        <td>
                                             <h5>{{ $item->keluarga->nama_lengkap }}</h5>
                                             <small>
                                                  <span class="kt-badge kt-badge-sm font-medium hover:bg-[#a4a5a6] dark:hover:bg-slate-700 bg-sky-200 dark:bg-sky-600 transition-all cursor-pointer" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start" onclick="_detail('${row.sesi}')">
                                                       {{ $item->keluarga->nik }}
                                                       <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                            <span class="flex items-center gap-1.5">Lihat Detail {{ $item->keluarga->nama_lengkap }}</span>
                                                       </span>
                                                  </span>
                                             </small>
                                        </td>
                                        <td>{{ $item->keluarga->alamat }}</td>
                                        <td>{{ $item->keluarga->faskes->nama_faskes }}</td>
                                        <td>{{ $item->keluarga->tgl_mulai }}</td>
                                        <td>{{ $item->hari_ke }}</td>
                                        <td>
                                             <span class="kt-badge kt-badge-destructive">
                                                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"class="lucide lucide-triangle-alert text-yellow-100 size-4" aria-hidden="true">
                                                       <path d="m21.73 18-8-14a2 2 0 0 0-3.48 0l-8 14A2 2 0 0 0 4 21h16a2 2 0 0 0 1.73-3"></path>
                                                       <path d="M12 9v4"></path>
                                                       <path d="M12 17h.01"></path>
                                                  </svg>
                                                  {{ $item->status_disiplin }} (Telat {{ $item->jml_hari_telat }} hari)
                                             </span>
                                        </td>
                                        <td>
                                             <span class="inline-flex gap-2.5">
                                                  <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_edit('{{ Crypt::encryptString($item->id) }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                                       <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                       <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                            <span class="flex items-center gap-1.5">Lihat Detail Gejala</span>
                                                       </span>
                                                  </a>
                                                  <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline bg-green-400 hover:bg-green-600 dark:bg-transparent" onclick="_delete('{{ Crypt::encryptString($item->id) }}', '{{ $item->judul_kontak }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                                       <i class="ki-filled ki-whatsapp text-lg text-gray-100 dark:text-gray-400 dark:hover:text-gray-200"></i>
                                                       <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                            <span class="flex items-center gap-1.5">
                                                                 Beritahu Kader
                                                            </span>
                                                       </span>
                                                  </a>
                                                  </span>
                                        </td>
                                   </tr>
                                  @endforeach
                              @else 
                                   <tr><td colspan="7" class="w-full"><h5 class="w-full text-center font-medium">Belum ada data saat ini</h5></td></tr>
                              @endif
                         </tbody>
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>

<div class="kt-container-fixed mt-10">
     <div class="grid w-full space-y-5">
          <div class="kt-card">
               <div class="kt-card-header min-h-16">
                    <h1 class="font-medium text-lg">
                         Antrian Penapisan Baru (Wajib Menghubungi Kader / Petugas Puskesmas) <span class="kt-badge kt-badge-outline kt-badge-mono">5 Data Terbaru</span>
                    </h1>
               </div>
               <div id="kt_datatable_remote_filters" class="kt-card-table relative" data-kt-datatable-page-size="10">
                    <div class="kt-table-wrapper kt-scrollable">
                         <table class="kt-table" data-kt-datatable-table="true">
                              <thead>
                                   <tr>
                                        <th scope="col" class="w-20" data-kt-datatable-column="nama">
                                             <span class="kt-table-col">
                                                  <span class="kt-table-col-label">Nama & NIK</span>
                                             </span>
                                        </th>
                                        <th scope="col" class="w-30" data-kt-datatable-column="alamat">
                                             <span class="kt-table-col">
                                                  <span class="kt-table-col-label">Alamat</span>
                                             </span>
                                        </th>
                                        <th scope="col" class="w-10" data-kt-datatable-column="faskes">
                                             <span class="kt-table-col">
                                                  <span class="kt-table-col-label">Faskes</span>
                                             </span>
                                        </th>
                                        <th scope="col" class="w-10" data-kt-datatable-column="tanggal">
                                             <span class="kt-table-col">
                                                  <span class="kt-table-col-label">Tanggal Skrining</span>
                                             </span>
                                        </th>
                                        <th scope="col" class="w-10" data-kt-datatable-column="hari">
                                             <span class="kt-table-col">
                                                  <span class="kt-table-col-label">Usia, Jenis Kelamin</span>
                                             </span>
                                        </th>
                                        <th scope="col" class="w-10" data-kt-datatable-column="persen">
                                             <span class="kt-table-col">
                                                  <span class="kt-table-col-label">Skor Gejala</span>
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
                                   @if (count($darurat) > 0)
                                   @foreach ($darurat as $item)
                                        <tr>
                                             <td>
                                                  <h5>{{ $item->nama_lengkap }}</h5>
                                                  <small>
                                                       <span class="kt-badge kt-badge-sm font-medium hover:bg-[#a4a5a6] dark:hover:bg-slate-700 bg-sky-200 dark:bg-sky-600 transition-all cursor-pointer" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start" onclick="_detail('${row.sesi}')">
                                                            {{ $item->nik }}
                                                            <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                                 <span class="flex items-center gap-1.5">Lihat Detail {{ $item->nama_lengkap }}</span>
                                                            </span>
                                                       </span>
                                                  </small>
                                             </td>
                                             <td>{{ $item->alamat }}</td>
                                             <td>{{ $item->faskes->nama_faskes }}</td>
                                             <td>{{ $item->sesiTerakhir->tgl_skrining }}</td>
                                             <td>
                                                  {{ $item->usia }} <br>
                                                  {{ $item->jenkel == 'L' ? 'Laki-Laki' : ($item->jenkel == 'P' ? 'Perempuan' : '-') }}
                                             </td>
                                             <td>
                                                  <span class="text-red-400">{{ count($item->sesiTerakhir->isYes) }}</span> / {{ $item->is_total }}
                                             </td>
                                             <td>
                                                  <span class="inline-flex gap-2.5">
                                                       <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline" onclick="_edit('{{ Crypt::encryptString($item->id) }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye h-4 w-4" aria-hidden="true"><path d="M2.062 12.348a1 1 0 0 1 0-.696 10.75 10.75 0 0 1 19.876 0 1 1 0 0 1 0 .696 10.75 10.75 0 0 1-19.876 0"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                                            <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                                 <span class="flex items-center gap-1.5">Lihat Detail Gejala</span>
                                                            </span>
                                                       </a>
                                                       <a href="javascript:void(0)" class="kt-btn kt-btn-sm kt-btn-icon kt-btn-outline bg-green-400 hover:bg-green-600 dark:bg-transparent" onclick="_delete('{{ Crypt::encryptString($item->id) }}', '{{ $item->judul_kontak }}')" data-kt-tooltip="true" data-kt-tooltip-placement="bottom-start">
                                                            <i class="ki-filled ki-whatsapp text-lg text-gray-100 dark:text-gray-400 dark:hover:text-gray-200"></i>
                                                            <span data-kt-tooltip-content="true" class="kt-tooltip">
                                                                 <span class="flex items-center gap-1.5">
                                                                      Beritahu Kader
                                                                 </span>
                                                            </span>
                                                       </a>
                                                       </span>
                                             </td>
                                        </tr>
                                   @endforeach
                                   @else 
                                        <tr><td colspan="7" class="w-full"><h5 class="w-full text-center font-medium">Belum ada data saat ini</h5></td></tr>
                                   @endif
                              </tbody>
                              {{-- {{ count($darurat[0]->sesiTerakhir->isYes) }} --}}
                         </table>
                    </div>
               </div>
          </div>
     </div>
</div>
@endhasrole

@hasanyrole(['admin', 'superadmin'])
<div class="kt-container-fixed mt-10">
     <div class="grid w-full space-y-5">
          <div class="kt-card">
               <div class="kt-card-header min-h-16">
                    <h1 class="font-medium text-lg">
                         Perbandingan Suspek vs Positif TBC tiap Faskes
                    </h1>
               </div>
               <div class="kt-card-content space-y-5">
                    <div id="faskes" class="h-100 w-full"></div>
               </div>
          </div>
     </div>
</div>

<div class="kt-container-fixed mt-10">
     <div class="grid w-full space-y-5">
          <div class="kt-card">
               <div class="kt-card-header min-h-16">
                    <h1 class="font-medium text-lg">
                         Peta Sebaran <i>(Heatmap)</i> di Desa/Kelurahan yang Terdampak
                    </h1>
               </div>
               <div class="kt-card-content space-y-5">
                    <div id="sebaran" class="h-124 w-full"></div>
               </div>
          </div>
     </div>
</div>
@endhasanyrole
@endsection


@section('js')
@hasanyrole(['admin', 'superadmin'])
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<script>
     document.addEventListener("DOMContentLoaded", function() {

          // ==========================================
          // 1. RENDER GRAFIK BATANG (APEXCHARTS)
          // ==========================================
          var chartOptions = {
               series: [{
                    name: 'Suspek Terjaring',
                    data: {!! json_encode($grafik['suspek']) !!} // Data dari Laravel
               }, {
                    name: 'Positif (Dalam Pengobatan)',
                    data: {!! json_encode($grafik['positif']) !!} // Data dari Laravel
               }],
               chart: {
                    type: 'bar',
                    height: 420,
                    toolbar: { show: false }, // Sembunyikan tombol download agar UI bersih
                    fontFamily: 'Inter, sans-serif'
               },
               plotOptions: {
                    bar: {
                         horizontal: false,
                         columnWidth: '50%',
                         borderRadius: 4
                    },
               },
               colors: ['#f97316', '#10b981'], // Orange (Suspek) dan Emerald (Positif)
               dataLabels: { enabled: false },
               stroke: { show: true, width: 2, colors: ['transparent'] },
               xaxis: {
                    categories: {!! json_encode($grafik['label']) !!}, // Nama Puskesmas
                    labels: { style: { colors: '#64748b', fontSize: '10px' } }
               },
               yaxis: {
                    title: { text: 'Jumlah Warga', style: { color: '#64748b', fontSize: '12px', fontWeight: 500 } }
               },
               fill: { opacity: 1 },
               tooltip: {
                    y: { formatter: function (val) { return val + " Warga" } }
               }
          };

          var barChart = new ApexCharts(document.querySelector("#faskes"), chartOptions);
          barChart.render();


          // ==========================================
          // 2. RENDER PETA SEBARAN (LEAFLET.JS)
          // ==========================================
          // Set view default ke koordinat tengah Kabupaten Anda (Contoh: area Karanganyar/Jateng)
          // Ubah latitude & longitude ini sesuai pusat pemerintahan kabupaten Anda.
          var map = L.map('sebaran').setView([-7.5959, 110.9525], 12); 

          // Menggunakan peta dasar OpenStreetMap yang gratis dan detail
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
               maxZoom: 14,
               attribution: '© OpenStreetMap'
          }).addTo(map);

          // Ambil data dari Controller Laravel
          var dataDesa = {!! json_encode($grafik['sebaran']) !!};

          // Melakukan perulangan (loop) untuk menggambar titik di setiap Desa
          dataDesa.forEach(function(desa) {
               // Warna juga bisa dinamis (merah gelap jika kasus > 10)
               var warnaLingkaran = desa.total_kasus > 10 ? '#ef4444' : '#f59e0b'; // Red / Amber

               var koordinatMentah = desa.areal

               var arrayPoligon = koordinatMentah.split('|').map(function(titik) {
                    var pecah = titik.split(',');
                    // Ekstrak angka dari format "lng:angka" dan "lat:angka"
                    var lng = parseFloat(pecah[0].split(':')[1]);
                    var lat = parseFloat(pecah[1].split(':')[1]);
                    return [lat, lng]; // Posisi dibalik karena format string Anda lng dulu baru lat
               });

               var areaDesa = L.polygon(arrayPoligon, {
                    color: '#9f2d00',      // Warna garis tepi (Merah)
                    weight: 2,             // Ketebalan garis
                    // fillColor: '#bb4d00',  // Warna isian dalam area (Heatmap color)
                    fillColor: warnaLingkaran,
                    fillOpacity: 0.5       // Tingkat transparansi isian
               }).addTo(map);

               areaDesa.bindPopup(`
                    <b>Zona Risiko TBC (${desa.desakel_name}) &middot; ${desa.total_kasus} Jiwa</b>
                    <br>
                    Terdapat beberapa kasus aktif terdeteksi di area ini.`
               )
               map.fitBounds(areaDesa.getBounds());
          });

    });
</script>
@endhasanyrole

@hasanyrole(['user'])
<script>
     function _error() {
          Swal.fire('Error', 'Mohon untuk melengkapi biodata Anda.', 'error')
     }
</script>
@endhasanyrole
@endsection
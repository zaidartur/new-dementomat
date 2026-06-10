@extends('layouts.layout')

@section('title', 'Dashboard')

@section('css')
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
               <h1 class="text-xl font-medium leading-none text-mono">
                    <i class="ki-filled ki-element-11 text-lg"></i>
                    Dashboard
               </h1>
               <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    {{-- Selamat datang, {{ Auth::user()->name }}.  --}}
                    Ringkasan pantauan wilayah Anda hari ini
               </div>
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
                            <span class="text-3xl font-bold text-mono text-red-500">{{ count($darurat) }} orang</span>
                            <span class="text-sm font-medium text-red-500">Tindakan Darurat (Warga Suspek Baru)</span>
                        </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-sky-600 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <i class="ki-filled ki-watch text-4xl text-sky-600 w-7 mt-4 ms-5"></i>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-bold text-mono text-sky-600">{{ $tcm }} orang</span>
                            <span class="text-sm font-medium text-sky-600">Menunggu Hasil TCM dari Petugas</span>
                        </div>
                    </div>
                    <div class="kt-card flex flex-col justify-between border border-orange-500 gap-6 min-w-[150px] bg-cover rtl:bg-[left_top_-1.7rem] bg-[right_top_-1.7rem] bg-no-repeat channel-stats-bg">
                        <i class="ki-filled ki-information-1 text-4xl text-orange-500 w-7 mt-4 ms-5"></i>
                        <div class="flex flex-col gap-1 pb-4 px-5">
                            <span class="text-3xl font-bold text-mono text-orange-500">{{ count($lists) ?? 0 }} orang</span>
                            <span class="text-sm font-medium text-orange-500">Resiko Putus Obat</span>
                        </div>
                    </div>
                    @endhasrole

               </div>
          </div>
     </div>
</div>
<!-- End of Container -->

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
@endsection
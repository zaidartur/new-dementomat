@extends('layouts.layout')

@section('title', 'Profile Saya')

@section('css')
    
@endsection



@section('content')
<div class="kt-container-fixed">
     <div class="flex flex-wrap items-center lg:items-end justify-between gap-5 pb-7.5">
          <div class="flex flex-col justify-center gap-2">
               <h1 class="text-xl font-medium leading-none text-mono">
                    <i class="ki-filled ki-profile-circle text-lg"></i>
                    Profile
               </h1>
               <div class="flex items-center gap-2 text-sm font-normal text-secondary-foreground">
                    Data diri <b>{{ Auth::user()->name }}</b>. 
               </div>
          </div>
     </div>
</div>

<div class="kt-container-fixed">
    <form class="kt-form" id="form_profile">
        @csrf
        <input type="hidden" id="uid" name="uid" value="{{ $profile->uid_keluarga ?? '' }}">
        <div class="grid w-full space-y-5">
            <div class="kt-card">
                <div class="kt-card-header min-h-16">
                    <h1 class="font-medium text-lg">
                        Biodata Saya
                    </h1>
                </div>
                <div class="kt-card-content">

                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Nama Lengkap:</label>
                        <div class="kt-form-control">
                            <div class="kt-input" @error('nama') aria-invalid="true" @enderror>
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="text" class="kt-input" id="nama" name="nama" placeholder="Nama Lengkap" maxlength="50" value="{{ $profile->nama_lengkap }}" required autofocus />
                            </div>
                        </div>
                        <div class="kt-form-message">Mohon mengisi nama lengkap Anda.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">NIK:</label>
                        <div class="kt-form-control">
                            <div class="kt-input">
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="number" class="kt-input font-medium text-gray-950 dark:text-gray-50" placeholder="NIK" value="{{ $profile->nik }}" required disabled />
                            </div>
                        </div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Alamat:</label>
                        <div class="kt-form-control">
                            <textarea class="kt-textarea" name="alamat" id="alamat" @error('alamat') aria-invalid="true" @enderror placeholder="Alamat Anda.." rows="4" required>{{ $profile->alamat }}</textarea>
                        </div>
                        <div class="kt-form-message">Mohon mengisi alamat Anda.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Kecamatan:</label>
                        <div class="kt-form-control">
                            <select class="kt-select" data-kt-select="true" id="kecamatan" name="kecamatan" @error('kecamatan') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih kecamatan..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' onchange="_mykec(this.value)" required>
                                @foreach ($kecamatan as $item)
                                    <option value="{{ $item->kec_id }}" {{ !empty($profile->kec_id) ? ($item->kec_id == $profile->kec_id ? 'selected' : '') : '' }}>{{ $item->kec_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="kt-form-message">Mohon mengisi kecamatan Anda.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Desa:</label>
                        <div class="kt-form-control">
                            <select class="kt-select" data-kt-select="true" id="desa" name="desa" @error('desa') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih desa..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                @if (!empty($desa))
                                    @foreach ($desa as $item)
                                        <option value="{{ $item->desakel_id }}" {{ !empty($profile->desakel_id) ? ($item->desakel_id == $profile->desakel_id ? 'selected' : '') : '' }}>{{ $item->desakel_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="kt-form-message">Mohon mengisi desa Anda.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">No. Telepon:</label>
                        <div class="kt-form-control">
                            <div class="kt-input" @error('telepon') aria-invalid="true" @enderror>
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="number" class="kt-input" id="telepon" name="telepon" placeholder="628xx" value="{{ $profile->telepon }}" required />
                            </div>
                        </div>
                        <div class="kt-form-message">Mohon mengisi no. telepon Anda.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Tanggal Lahir:</label>
                        <div class="kt-form-control">
                            <div class="kt-input" @error('bod') aria-invalid="true" @enderror>
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="date" class="kt-input" id="bod" name="bod" placeholder="Tanggal Lahir" value="{{ $profile->tgl_lahir }}" required />
                            </div>
                        </div>
                        <div class="kt-form-message">Mohon mengisi tanggal lahir Anda.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Jenis Kelamin:</label>
                        <div class="kt-form-control">
                            <select class="kt-select" data-kt-select="true" id="jenkel" name="jenkel" @error('jenkel') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih jenis kelamin..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                <option value="L" {{ $profile->jenkel == 'L' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="P" {{ $profile->jenkel == 'P' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="kt-form-message">Mohon mengisi jenis kelamin Anda.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Status Keluarga:</label>
                        <div class="kt-form-control">
                            {{-- <div class="kt-input" @error('status') aria-invalid="true" @enderror>
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="text" class="kt-input" id="status" name="status" placeholder="Status Anda di keluarga" maxlength="50" value="{{ $profile->status_keluarga }}" required />
                            </div> --}}
                            <select class="kt-select" data-kt-select="true" id="status" name="status" @error('status') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih status keluarga..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                @foreach ($status as $item)
                                    <option value="{{ $item->nama }}" {{ !empty($profile->status_keluarga) ? ($item->nama == $profile->status_keluarga ? 'selected' : '') : '' }}>{{ $item->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="kt-form-message">Mohon mengisi status Anda.</div>
                    </div>
                    <div class="kt-form-item mb-5">
                        <label class="kt-form-label">Faskes:</label>
                        <div class="kt-form-control">
                            <select class="kt-select" data-kt-select="true" id="faskes" name="faskes" @error('faskes') aria-invalid="true" @enderror data-kt-select-placeholder="Pilih faskes..." data-kt-select-config='{"optionsClass": "kt-scrollable overflow-auto max-h-[250px]"}' required>
                                <option value="">Pilih Faskes</option>
                                @foreach ($faskes as $item)
                                    <option value="{{ $item->faskes_id }}" {{ !empty($profile->id_faskes) ? ($item->faskes_id == $profile->id_faskes ? 'selected' : '') : '' }}>{{ $item->nama_faskes }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="kt-form-message">Mohon memilih faskes Anda.</div>
                    </div>
                    <div class="kt-form-item">
                        <label class="kt-form-label">Email (opsional):</label>
                        <div class="kt-form-control">
                            <div class="kt-input">
                                <i class="ki-filled ki-subtitle text-lg"></i>
                                <input type="email" class="kt-input" id="email" name="email" placeholder="Email Anda" maxlength="100" value="{{ $profile->user->email ?? '' }}" />
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="w-full mt-10">
            <button type="submit" id="btn_save" class="kt-btn kt-btn-primary w-full md:w-[30%] rounded-full text-lg md:text-sm p-7 md:p-2">
                <i class="ki-filled ki-user-tick text-xl md:text-lg"></i>
                Simpan Profile Saya
            </button>
        </div>
    </form>
</div>
@endsection


@section('js')
<script>
    const defKec  = '{{ $profile->kec_id ?? "" }}'
    const defDesa = '{{ $profile->desakel_id ?? "" }}'

    function _mykec(id) {
        if (id) {
            $.ajax({
                url: '/data-desa-kecamatan/' + id,
                type: 'GET',
                dataType: 'JSON',
                success: function(res) {
                    $('#desa').html('')
                    let opt = ''
                    res.data.forEach(dt => {
                        opt += `<option value="${dt.desakel_id}">${dt.desakel_name}</option>`
                    })
                    $('#desa').html(opt)
                    const selectElement = document.querySelector('#desa')
                    const instance = KTSelect.getInstance(selectElement) ?? KTSelect.getOrCreateInstance(selectElement)
                    let option = []
                    if (id === defKec && defDesa) {
                        option = selectElement.querySelector(`option[value="${defDesa}"]`)
                    }
                    instance.setSelectedOptions(option ? [option] : []);
                    // instance.setSelectedOptions([])
                },
                error: function(xhr, status, error) {
                    console.log(error)
                    _swal_alert('error', xhr.responseJSON.message)
                }
            })
        }
    }
</script>
@endsection
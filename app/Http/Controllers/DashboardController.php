<?php

namespace App\Http\Controllers;

use App\Models\DataKeluarga;
use App\Models\DataSesiSkrining;
use App\Models\Faskes;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function view()
    {
        if (Auth::user()->hasRole('faskes')) {
            $data = [
                'darurat'   => $this->darurat(),
                'tcm'       => $this->waiting_tcm(),
                'lists'     => $this->radar_pantauan(),
            ];
        } elseif (Auth::user()->hasAnyRole(['admin', 'superadmin'])) {
            $totalEvaluasiTahunIni  = DataKeluarga::whereNotNull('hasil_akhir_pengobatan')->whereYear('tgl_selesai_obat', now()->year)->count();
            $totalSembuhTahunIni    = DataKeluarga::where('hasil_akhir_pengobatan', 'Sembuh')->whereYear('tgl_selesai_obat', now()->year)->count();
            $cureRate = 0;
            if ($totalEvaluasiTahunIni > 0) {
                $cureRate = round(($totalSembuhTahunIni / $totalEvaluasiTahunIni) * 100);
            }
            $data = [
                'aktif'     => DataKeluarga::where('status_tbc', 'Dalam Pengobatan')->whereNull('deleted_at')->count() ?? 0,
                'evaluasi'  => $totalEvaluasiTahunIni ?? 0,
                'suspek'    => DataSesiSkrining::whereNotNull('triggered_rule_id')->whereNull('deleted_at')->whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count() ?? 0,
                'rate'      => $cureRate ?? 0,
                'bulan'     => Carbon::now()->locale('id')->translatedFormat('F Y') ?? '',
                'grafik'    => $this->grafik_perbandingan(),
            ];
        } elseif (Auth::user()->hasAnyRole(['user'])) {
            $user = DataKeluarga::where('uid_keluarga', Auth::user()->uuid)->where('is_auth', 1)->whereNull('deleted_at')->first();
            if (empty($user->alamat) || empty($user->tgl_lahir) || empty($user->telepon) || empty($user->jenkel) || empty($user->kec_id) || empty($user->desakel_id) || empty($user->id_faskes)) {
                $verif = false;
            } else {
                $verif = true;
            }
            $data = [
                'verify'    => $verif,
            ];
        } else {
            return abort(404);
        }
        return view('dashboard', $data);
    }

    private function radar_pantauan()
    {
        if (!Request()->user()->hasRole('faskes')) return [];
        $query = DataSesiSkrining::with(['keluarga:uid_keluarga,nik,nama_lengkap,alamat,status_keluarga,status_tbc,id_faskes,kec_id,desakel_id,tgl_mulai_obat', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak', 'keluarga.kecamatan', 'keluarga.desa', 'keluarga.obatTerakhir', 'keluarga.beratTerakhir'])
            ->withCount(['logHarian'])
            ->whereNotNull('jenis_tcm')
            ->whereHas('keluarga', function($q) {
                $q->whereIn('status_tbc', ['Dalam Pengobatan'])
                    ->whereNull('deleted_at')
                    ->where('id_faskes', Request()->user()->faskes_id);
            })
            ->whereNull('deleted_at')
            ->latest()->take(5)->get();

        $query->transform(function($sess) {
            $latestObat = $sess->keluarga->obatTerakhir;
            $hariTelat  = 0;
            $hariIni    = now()->startOfDay();

            $tgl_mulai_obat = Carbon::parse($sess->keluarga->tgl_mulai_obat);
            $today = Carbon::now()->startOfDay();
            $tgl_mulai = $tgl_mulai_obat->startOfDay();
            $hariKe = $tgl_mulai->diffInDays($today) + 1;

            if ($latestObat) {
                $dateLatestObat = Carbon::parse($latestObat->created_at)->startOfDay();
                $hariTelat  = $dateLatestObat->diffInDays($hariIni);
            } else {
                if ($sess->keluarga->tgl_mulai_obat) {
                    $tglMulai = Carbon::parse($sess->keluarga->tgl_mulai_obat)->startOfDay();
                    if ($hariIni->greaterThanOrEqualTo($tglMulai)) {
                        $hariTelat = $tglMulai->diffInDays($hariIni);
                    }
                }
            }

            $sess->keluarga->nik = substr($sess->keluarga->nik, 0, 4) . str_repeat("*", strlen($sess->keluarga->nik) - 4);
            $sess->keluarga->tgl_mulai = !empty($sess->keluarga->tgl_mulai_obat) ? Carbon::parse($sess->keluarga->tgl_mulai_obat)->locale('id')->translatedFormat('d F Y') : '-';
            $sess->hari_ke = $hariKe;

            $sess->jml_hari_telat = $hariTelat;
            if ($hariTelat >= 3) {
                $sess->status_disiplin = 'Kritis';          // Merah (> 3 Hari)
            } elseif ($hariTelat >= 1) {
                $sess->status_disiplin = 'Kurang Disiplin'; // Kuning (1-2 Hari)
            } else {
                $sess->status_disiplin = 'Disiplin';        // Hijau (0 Hari / Hari ini sudah isi)
            }

            return $sess;
        });

        $userRadar = $query->filter(function ($session) {
            return in_array($session->status_disiplin, ['Kritis', 'Kurang Disiplin']);
        })->sortByDesc('jml_hari_telat');

        return $userRadar;
    }

    private function data_quick_response()
    {
        $query  = DataSesiSkrining::with(['keluarga:uid_keluarga,nik,nama_lengkap,status_keluarga,status_tbc,id_faskes,kec_id,desakel_id,tgl_mulai_obat', 'kategori:id,nama_kategori', 'triggeredRule:uid_rule,nama_aturan,rekomendasi', 'keluarga.faskes.kontak', 'keluarga.kecamatan', 'keluarga.desa', 'keluarga.obatTerakhir', 'keluarga.beratTerakhir'])
                    ->withCount(['logHarian'])
                    ->whereNotNull('jenis_tcm')
                    ->whereHas('keluarga', function($q) {
                        $q->whereIn('status_tbc', ['Dalam Pengobatan'])
                        ->whereNull('deleted_at');
                    })
                    ->whereNull('deleted_at')
                    ->latest()->get()->unique('uid_keluarga');
        $result = collect($query)->map(function($record) {
            $user_uid = $record->uid_keluarga;
            $tgl_mulai_obat = Carbon::parse($record->keluarga->tgl_mulai_obat);
            $today = Carbon::now()->startOfDay();
            $tgl_mulai = $tgl_mulai_obat->startOfDay();
            $hariKe = $tgl_mulai->diffInDays($today) + 1;

            $bulan  = $tgl_mulai_obat->startOfMonth();
            $this_month = Carbon::now()->startOfMonth();
            $bulan_ke   = $bulan->diffInMonths($this_month) + 1;
            $persen = 0;

            if ($hariKe > 0) {
                $patuh  = round(($record->log_harian_count / $hariKe) * 100);
                $persen = $patuh > 100 ? 100 : $patuh;
            }

            $cleanHex = str_replace('-', '', $user_uid);
            $hexSegment = substr($cleanHex, 0, 6);
            $decValue = hexdec($hexSegment);
            $hue = $decValue % 360;
            $record->color      = hslToHex($hue, 80, 45);
            $record->jml_logs   = $record->log_harian_count;
            $record->total_hari = $hariKe;
            $record->bulan_ke   = $bulan_ke;
            $record->persen_kepatuhan = $persen;

            if ($persen >= 90) {
                $record->kepatuhan_color = 'success'; // Hijau: Sangat Baik
                $record->kepatuhan_text = 'Disiplin';
            } elseif ($persen >= 60) {
                $record->kepatuhan_color = 'warning'; // Kuning: Mulai Sering Bolos
                $record->kepatuhan_text = 'Kurang Disiplin';
            } else {
                $record->kepatuhan_color = 'destructive'; // Merah: Bahaya Putus Obat
                $record->kepatuhan_text = 'Risiko Drop Out';
            }

            return $record;
        });

        return collect($result)->filter(function($val, $key) {
            return $val->persen_kepatuhan < 60;
        });
    }

    private function darurat()
    {
        $lists = DataKeluarga::with(['faskes', 'kecamatan', 'desa', 'sesiTerakhir', 'sesiTerakhir.isYes', 'sesiTerakhir.isNo'])
                // ->withCount(['sesiTerakhir.isYes', 'sesiTerakhir.isNo'])
                ->where('status_tbc', 'Wajib Menghubungi Kader (Petugas) Puskesmas')
                ->whereNull('deleted_at')
                ->where('id_faskes', Auth::user()->faskes_id)
                ->get();
        collect($lists)->map(function($ls) {
            $usia  = !empty($ls->tgl_lahir) ? Carbon::parse($ls->tgl_lahir) : null;

            $ls->nik = substr($ls->nik, 0, 4) . str_repeat("*", strlen($ls->nik) - 4);
            $ls->sesiTerakhir->tgl_skrining = Carbon::parse($ls->sesiTerakhir->created_at)->locale('id')->translatedFormat('d F Y');
            $ls->usia = !empty($usia) ? CarbonInterval::instance($usia->diff(Carbon::now()))->locale('id')->forHumans(['parts' => 1, 'join' => ' ']) : null;
            $ls->is_total = $ls->sesiTerakhir->isYes->count() + $ls->sesiTerakhir->isNo->count();
        });

        return $lists;
    }

    private function waiting_tcm()
    {
        return DataSesiSkrining::with('keluarga')->whereNotNull('tgl_tcm')->whereNotNull('jenis_tcm')->whereNull('hasil_tcm')->whereNull('deleted_at')
                ->whereHas('keluarga', function($data) {
                    $data->where('id_faskes', Auth::user()->faskes_id);
                })->count();
    }

    private function grafik_perbandingan()
    {
        $bulan = now()->month;
        $tahun = now()->year;

        $grafikFaskes = Faskes::withCount([
            'sesi_skrining AS suspek_count' => function ($query) use ($bulan, $tahun) {
                $query->whereNotNull('data_sesi_skrinings.triggered_rule_id')
                    ->whereMonth('data_sesi_skrinings.created_at', $bulan)
                    ->whereYear('data_sesi_skrinings.created_at', $tahun);
            },
            'keluarga AS positif_count' => function ($query) {
                $query->where('data_keluargas.status_tbc', 'Dalam Pengobatan');
            }
        ])->get();

        $chartLabels = $grafikFaskes->pluck('nama_faskes'); 
        $chartSuspek = $grafikFaskes->pluck('suspek_count');
        $chartPositif = $grafikFaskes->pluck('positif_count');

        $petaSebaran = DB::table('data_keluargas AS dk')->leftJoin('desas AS d', 'd.desakel_id', '=', 'dk.desakel_id')
                    ->select('d.desakel_name', 'd.areal', DB::raw('COUNT(dk.id) AS total_kasus'))
                    ->where('dk.status_tbc', 'Dalam Pengobatan')
                    ->groupBy('d.desakel_id', 'd.desakel_name', 'd.areal')
                    ->get();
        
        return [
            'label'     => $chartLabels,
            'suspek'    => $chartSuspek,
            'positif'   => $chartPositif,
            'sebaran'   => $petaSebaran
        ];
    }
}

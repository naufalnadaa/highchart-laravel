<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Exception;

class HighchartController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('dashboard');
    }

    public function pieChart()
    {
        $totalData = DB::table('m_dasawisma')
            ->where('record_status', '=', '0')
            ->count();

        $data = DB::table('m_dasawisma')
            ->leftJoin('m_rt', 'm_dasawisma.rt_id', '=', 'm_rt.rt_id')
            ->leftJoin('m_rw', 'm_rt.rw_id', '=', 'm_rw.rw_id')
            ->leftJoin('m_kelurahan', 'm_rw.kelurahan_id', '=', 'm_kelurahan.kelurahan_id')
            ->leftJoin('m_kecamatan', 'm_kelurahan.kecamatan_id', '=', 'm_kecamatan.kecamatan_id')
            ->leftJoin('m_kota', 'm_kecamatan.kota_id', '=', 'm_kota.kota_id')
            ->selectRaw('m_kota.kota_id, m_kota.nama_kota, COUNT(m_dasawisma.dasawisma_id) as total')
            ->where('m_dasawisma.record_status', '=', '0')
            ->groupBy('m_kota.kota_id', 'm_kota.nama_kota')
            ->orderBy('m_kota.nama_kota', 'asc')
            ->get();

        return response()->json([
            'total_data' => $totalData,
            'filtered_data' => $data,
        ]);
    }

    public function barChart(Request $request)
    {
        $kotaId = $request->get('kota_id');

        $data = DB::table('m_dasawisma')
            ->leftJoin('m_rt', 'm_dasawisma.rt_id', '=', 'm_rt.rt_id')
            ->leftJoin('m_rw', 'm_rt.rw_id', '=', 'm_rw.rw_id')
            ->leftJoin('m_kelurahan', 'm_rw.kelurahan_id', '=', 'm_kelurahan.kelurahan_id')
            ->leftJoin('m_kecamatan', 'm_kelurahan.kecamatan_id', '=', 'm_kecamatan.kecamatan_id')
            ->leftJoin('m_kota', 'm_kecamatan.kota_id', '=', 'm_kota.kota_id')
            ->selectRaw('m_kota.nama_kota, m_kecamatan.nama_kecamatan, COUNT(m_dasawisma.dasawisma_id) as total')
            ->where('m_dasawisma.record_status', '=', '0')
            ->where('m_kota.kota_id', '=', $kotaId)
            ->groupBy('m_kota.nama_kota', 'm_kecamatan.nama_kecamatan')
            ->orderBy('m_kecamatan.nama_kecamatan', 'asc')
            ->get();

        $nama_kota = $data->isNotEmpty() ? $data->first()->nama_kota : 'Unknown';

        return response()->json([
            'filtered_data' => $data,
            'total_data' => $data->sum('total'),
            'nama_kota' => $nama_kota,
        ]);
    } 
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\IOFactory;

class HighchartController extends Controller
{
    public function dashboard(Request $request)
    {
        return view('dashboard');
    }

    public function dataPelanggan(Request $request)
    {
        // $fileExcel = public_path('/file/data_KAS_barat.xlsx');
        
        // $spreadsheet = IOFactory::load($fileExcel);
        // $sheet = $spreadsheet->getActiveSheet();

        // $rows = $sheet->toArray();

        // $header = $rows[0];
        // $data = array_slice($rows, 1);

        return view('data-pelanggan');
    }

    public function searchDataPelanggan(Request $request)
    {
        $customer_id = $request->input('customer_id');
        $fileExcel = public_path('/file/data_KAS_barat.xlsx');
        
        $reader = IOFactory::createReader('Xlsx');
        $spreadsheet = $reader->load($fileExcel);
        $sheet = $spreadsheet->getActiveSheet();
        
        $found = null;
        foreach ($sheet->getRowIterator() as $rowIndex => $row) {
            $cellIterator = $row->getCellIterator();
            $cellIterator->setIterateOnlyExistingCells(true);
            $rowData = [];
            foreach ($cellIterator as $cell) {
                $rowData[] = $cell->getValue();
            }

            if ($rowIndex > 1 && $rowData[0] === $customer_id) {
                $found = [
                    'customer_name' => $rowData[1] ?? '',
                    'address' => $rowData[2] ?? '',
                    'postal_code' => $rowData[3] ?? '',
                    'tarif_cd' => $rowData[4] ?? '',
                ];
                break;
            }
        }

        if ($found) {
            return response()->json(['status' => 'success', 'data' => $found]);
        }

        return response()->json(['status' => 'not_found']);
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

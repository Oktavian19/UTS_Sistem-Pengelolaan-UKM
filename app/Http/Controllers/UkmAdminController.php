<?php

namespace App\Http\Controllers;

use App\Models\UkmAdminModel;
use App\Models\UkmModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UkmAdminController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Pengurus UKM',
            'list' => ['Beranda', 'UKM', 'Pengurus']
        ];

        $page = (object) [
            'title' => 'Daftar Pengurus UKM yang terdaftar pada sistem'
        ];

        $ukm = UkmModel::all();

        return view('ukm_admin.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'ukm' => $ukm]);
    }

    public function list(Request $request){
        $ukmAdmin = UkmAdminModel::select('nim', 'name', 'phone', 'email', 'ukm_id', 'photo', 'is_active')
                    ->with('ukm');

        // Filter data user berdasarkan ukm_id
        if ($request->ukm_id) {
            $ukmAdmin->where('ukm_id', $request->ukm_id);
        }

        return DataTables::of($ukmAdmin)
            // Menambahkan kolom index/no urut (default nama kolo: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($ukmAdmin) {  // menambahkan kolom aksi 
                $btn  = '<button onclick="modalAction(\''.url('/admin/ukm/' . $ukmAdmin->id).'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/admin/ukm/' . $ukmAdmin->id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/admin/ukm/' . $ukmAdmin->id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }
}

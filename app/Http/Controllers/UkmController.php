<?php

namespace App\Http\Controllers;

use App\Models\AdminsModel;
use App\Models\UkmModel;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class UkmController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar UKM',
            'list' => ['Beranda', 'UKM']
        ];

        $page = (object) [
            'title' => 'Daftar UKM yang terdaftar pada sistem'
        ];

        $admins = AdminsModel::all();

        return view('ukm.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admins' => $admins]);
    }

    public function list(Request $request){
        $ukm = UkmModel::select('id', 'name', 'description', 'category', 'email', 'phone', 'website', 'logo_path', 'is_active', 'created_by')
                    ->with('category')
                    ->with('admins');

        // Filter data user berdasarkan level_id
        if ($request->category) {
            $ukm->where('category', $request->category);
        }

        return DataTables::of($ukm)
            // Menambahkan kolom index/no urut (default nama kolo: DT_RowIndex)
            ->addIndexColumn()
            ->addColumn('aksi', function ($ukm) {  // menambahkan kolom aksi 
                // $btn  = '<a href="'.url('/ukm/' . $ukm->ukm_id).'" class="btn btn-info btn-sm">Detail</a> '; 
                // $btn .= '<a href="'.url('/ukm/' . $ukm->ukm_id . '/edit').'" class="btn btn-warning btn-sm">Edit</a> '; 
                // $btn .= '<form class="d-inline-block" method="POST" action="'.url('/ukm/'.$ukm->ukm_id).'">' . csrf_field() . method_field('DELETE') . '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakit menghapus data ini?\');">Hapus</button></form>';
                $btn  = '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id . '/show_ajax').'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id . '/edit_ajax').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id . '/delete_ajax').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function create() {
        $admins = AdminsModel::select('id', 'name')->get();

        return view('ukm.create')
                    ->with('admins', $admins);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\AdminsModel;
use App\Models\CategoryModel;
use App\Models\UkmAdminModel;
use App\Models\UkmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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

        $category = CategoryModel::all();
        $admins = AdminsModel::all();

        return view('ukm.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'admins' => $admins, 'category' => $category]);
    }

    public function list(Request $request){
        $ukm = UkmModel::select('id', 'name', 'description', 'category_id', 'email', 'phone', 'website', 'logo_path', 'is_active', 'created_by')
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
                $btn  = '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id).'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/ukm/' . $ukm->id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function create() {
        $admins = AdminsModel::select('id', 'name')->get();
        $category = CategoryModel::select('id', 'name')->get();

        return view('ukm.create')
                    ->with('admins', $admins)
                    ->with('category', $category);
    }

    public function store(Request $request) {
        // cek apakah request berupa ajax
        $request->validate([
            'name'          => 'required|string|max:150',
            'description'   => 'required|string|min:50',
            'category_id'   => 'required|exists:category,id',
            'email'         => 'required|email|max:100',
            'phone'         => 'required|max:20',
            'website'       => 'nullable|url',
            'logo_ukm'      => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('logo_ukm')) {
             // Simpan ke folder storage/app/logos
            $path = $request->file('logo_ukm')->store('logos', 'public');
        }
        UkmModel::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_id' => $request->category_id,
            'email' => $request->email,
            'phone' => $request->phone,
            'website' => $request->website,
            'logo_path' => $path,
            'created_by' => '1', // atau ID admin yang sesuai
            'is_active' => true,
        ]);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Data user berhasil disimpan'
        ]);

        redirect('/');
    }

    public function show($id) {
        $ukm = UkmModel::with('category')->find($id);
        $ukmAdmin = UkmAdminModel::where('ukm_id', $id)->get();

        return view('ukm.show', ['ukm' => $ukm, 'ukmAdmin' => $ukmAdmin]);
    }

    public function edit(string $id) {
        $ukm = UkmModel::find($id);
        $category = CategoryModel::select('id', 'name')->get();

        return view('ukm.edit', ['ukm' => $ukm, 'category' => $category]);
    }

    public function update(Request $request, $id) {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name'          => 'required|string|max:150',
                'description'   => 'required|string|min:50',
                'category_id'   => 'required|exists:category,id',
                'email'         => 'required|email|max:100',
                'phone'         => 'required|max:20',
                'website'       => 'nullable|url',
                'logo_ukm'      => 'nullable|file|mimes:jpg,jpeg,png|max:2048',
            ];
            // use Illuminate\Support\Facades\Validator; 
            $validator = Validator::make($request->all(), $rules); 
    
            if ($validator->fails()) { 
                return response()->json([ 
                    'status'   => false,    // respon json, true: berhasil, false: gagal 
                    'message'  => 'Validasi gagal.', 
                    'msgField' => $validator->errors()  // menunjukkan field mana yang error 
                ]); 
            }
    
            $check = UkmModel::find($id); 
            if ($check) { 
                $check->update($request->all()); 
                return response()->json([ 
                    'status'  => true, 
                    'message' => 'Data berhasil diupdate' 
                ]); 
            } else{ 
                return response()->json([ 
                    'status'  => false, 
                    'message' => 'Data tidak ditemukan' 
                ]); 
            } 
        } 
        return redirect('/'); 
    }
}

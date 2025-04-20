<?php

namespace App\Http\Controllers;

use App\Models\UkmAdminModel;
use App\Models\UkmModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
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
                $btn  = '<button onclick="modalAction(\''.url('/ukm/admin/' . $ukmAdmin->nim).'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/ukm/admin/' . $ukmAdmin->nim . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/ukm/admin/' . $ukmAdmin->nim . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function create() {
        $ukm = UkmModel::select('id', 'name')->get();

        return view('ukm_admin.create')
                    ->with('ukm', $ukm);
    }

    public function store(Request $request) {
        // cek apakah request berupa ajax
        $request->validate([
            'nim'           => 'required|numeric|unique:ukm_admin,nim',
            'name'          => 'required|string|max:100',
            'password'      => 'required|string|min:8',
            'phone'         => 'required|string|max:20',
            'email'         => 'required|email|max:100|unique:ukm_admin,email',
            'ukm_id'        => 'required|exists:ukm,id',
            'photo_input'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $path = null;

        if ($request->hasFile('photo_input')) {
             // Simpan ke folder storage/app/logos
            $path = $request->file('photo_input')->store('photos', 'public');
        }
        UkmAdminModel::create([
            'nim' => $request->nim,
            'name' => $request->name,
            'password_hash' => bcrypt($request->password),
            'phone' => $request->phone,
            'email' => $request->email,
            'ukm_id' => $request->ukm_id,
            'photo' => $path,
            'is_active' => true,
        ]);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Data user berhasil disimpan'
        ]);

        redirect('/');
    }

    public function show($id) {
        $ukmAdmin = UkmAdminModel::with('ukm')->where('nim', $id)->firstOrFail();

        return view('ukm_admin.show', ['ukmAdmin' => $ukmAdmin]);
    }

    public function edit(string $nim) {
        $ukmAdmin = UkmAdminModel::findOrFail($nim);
        $ukm = UkmModel::select('id', 'name')->get();

        return view('ukm_admin.edit', ['ukmAdmin' => $ukmAdmin,'ukm' => $ukm]);
    }

    public function update(Request $request, $id) {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'nim'           => 'required|numeric|unique:ukm_admin,nim,'.$id.',nim',
                'name'          => 'required|string|max:100',
                'password'      => 'nullable|string|min:8',
                'phone'         => 'required|string|max:20',
                'email'         => 'required|email|max:100|unique:ukm_admin,email,' . $id . ',nim',
                'ukm_id'        => 'required|exists:ukm,id',
                'photo_input'   => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
    
            $path = null;

            if ($request->hasFile('photo_input')) {
                // Simpan ke folder storage/app/logos
                $path = $request->file('photo_input')->store('photos', 'public');
            }

            $check = UkmAdminModel::findOrFail($id); 
            if ($check) { 
                $check->update([
                    'nim'           => $request->nim,
                    'name'          => $request->name,
                    'password_hash' => $request->password ? bcrypt($request->password) : UkmAdminModel::find($id)->password_hash,
                    'phone'         => $request->phone,
                    'email'         => $request->email,
                    'ukm_id'        => $request->ukm_id,
                    'photo'         => $path ? $path : UkmAdminModel::find($id)->photo,
                    'is_active'     => true,
                ]);

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

    public function confirm(string $nim) {
        $ukmAdmin = UkmAdminModel::with('ukm')->where('nim', $nim)->firstOrFail();

        return view('ukm_admin.confirm', ['ukmAdmin' => $ukmAdmin]);
    }

    public function delete(Request $request, $nim) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $ukmAdmin = UkmAdminModel::with('ukm')->where('nim', $nim)->firstOrFail();

            if ($ukmAdmin) {
                $ukmAdmin->delete();
                return response()->json([
                    'status'    =>  true,
                    'message'   =>  'Data berhasil dihapus'
                ]);
            } else {
                return response()->json([
                    'status'    =>  false,
                    'message'   =>  'Data tidak ditemukan'
                ]);
            }
        }
        return redirect('/');
    }
}

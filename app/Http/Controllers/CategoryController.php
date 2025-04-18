<?php

namespace App\Http\Controllers;

use App\Models\CategoryModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    public function index() {
        $breadcrumb = (object) [
            'title' => 'Daftar Kategori UKM',
            'list' => ['Beranda', 'UKM']
        ];

        $page = (object) [
            'title' => 'Daftar Kategori yang terdaftar pada sistem'
        ];

        return view('category.index', ['breadcrumb' => $breadcrumb, 'page' => $page]);
    }

    public function list(){
        $category = CategoryModel::select('id', 'name', 'description');

        return DataTables::of($category)
            ->addIndexColumn()
            ->addColumn('aksi', function ($category) { 
                $btn  = '<button onclick="modalAction(\''.url('/category/' . $category->id).'\')" class="btn btn-info btn-sm">Detail</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/category/' . $category->id . '/edit').'\')" class="btn btn-warning btn-sm">Edit</button> '; 
                $btn .= '<button onclick="modalAction(\''.url('/category/' . $category->id . '/delete').'\')"  class="btn btn-danger btn-sm">Hapus</button> '; 
                return $btn; 
            }) 
            ->rawColumns(['aksi']) // memberitahu bahwa kolom aksi adalah html 
            ->make(true); 
    }

    public function create() {
        return view('category.create');
    }

    public function store(Request $request) {
        // cek apakah request berupa ajax
        $request->validate([
            'name'          => 'required|string',
            'description'   => 'required|string'
        ]);

        CategoryModel::create([
            'name' => $request->name,
            'description' => $request->description
        ]);

        return response()->json([
            'status'    =>  true,
            'message'   =>  'Data Kategori berhasil disimpan'
        ]);

        redirect('/');
    }

    public function show($id) {
        $category = CategoryModel::find($id);

        return view('category.show', ['category' => $category]);
    }

    public function edit(string $id) {
        $category = CategoryModel::find($id);

        return view('category.edit', ['category' => $category, 'category' => $category]);
    }

    public function update(Request $request, $id) {
        //cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'name'          => 'required|string',
                'description'   => 'required|string',
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
    
            $check = CategoryModel::find($id); 
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

    public function confirm(string $id) {
        $category = CategoryModel::find($id);

        return view('category.confirm', ['category' => $category]);
    }

    public function delete(Request $request, $id) {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            $category = CategoryModel::find($id);

            if ($category) {
                $category->delete();
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

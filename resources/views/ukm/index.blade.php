@extends('layouts.template') 
 
@section('content') 
    <div class="card card-outline card-primary"> 
        <div class="card-header"> 
            <h3 class="card-title">{{ $page->title }}</h3> 
            <div class="card-tools"> 
                <a onclick="modalAction('{{ url('ukm/create') }}')" class="btn btn-block btn-info">
                    <i class="fas fa-plus"></i>
                </a>
            </div> 
        </div> 
        <div class="card-body"> 
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group row">
                        <label for="" class="col-1 control-label col-form-label">Filter:</label>
                        <div class="col-3">
                            <select id="category_id" class="form-control" name="category_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($category as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">Kategori</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_ukm"> 
            <thead> 
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Kategori</th>
                    <th>Email</th>
                    <th>Kontak</th>
                    <th>Aksi</th>
                </tr> 
            </thead> 
        </table> 
        </div> 
    </div>
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true"></div> 
@endsection 
 
@push('css') 
@endpush 
 
@push('js') 
    <script> 
        function modalAction(url = ''){ 
            $('#myModal').load(url,function(){ 
                $('#myModal').modal('show'); 
            }); 
        }

        var dataUkm;
        $(document).ready(function() { 
            dataUkm = $('#table_ukm').DataTable({ 
                // serverSide: true, jika ingin menggunakan server side processing 
                serverSide: true,      
                ajax: { 
                    "url": "{{ url('ukm/list') }}", 
                    "dataType": "json", 
                    "type": "POST" ,
                    "data": function (d) {
                        d.category_id = $('#category_id').val();
                    }
                }, 
                columns: [ 
                    { 
                    data: "DT_RowIndex",             
                    className: "text-center", 
                    orderable: false, 
                    searchable: false     
                    },{ 
                    data: "name",                
                    className: "", 
                    // orderable: true, jika ingin kolom ini bisa diurutkan  
                    orderable: true,     
                    // searchable: true, jika ingin kolom ini bisa dicari 
                    searchable: true     
                    },{ 
                    data: "category.name",                
                    className: "", 
                    orderable: true,     
                    searchable: true     
                    },{ 
                    // mengambil data level hasil dari ORM berelasi 
                    data: "email",                
                    className: "", 
                    orderable: false,     
                    searchable: false     
                    },{ 
                    data: "phone",                
                    className: "", 
                    orderable: false,     
                    searchable: false     
                    },{ 
                    data: "aksi",                
                    className: "", 
                    orderable: false,     
                    searchable: false     
                    } 
                ] 
            });
            
            $('#category_id').on('change', function () {
                dataUkm.ajax.reload();
            });
        }); 
    </script> 
@endpush  
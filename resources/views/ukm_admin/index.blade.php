@extends('layouts.template') 
 
@section('content') 
    <div class="card card-outline card-primary"> 
        <div class="card-header"> 
            <h3 class="card-title">{{ $page->title }}</h3> 
            <div class="card-tools"> 
                <a onclick="modalAction('{{ url('ukm/admin/create') }}')" class="btn btn-block btn-info">
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
                            <select id="ukm_id" class="form-control" name="ukm_id" required>
                                <option value="">- Semua -</option>
                                @foreach ($ukm as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">UKM</small>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-bordered table-striped table-hover table-sm" id="table_ukmAdmin"> 
            <thead> 
                <tr>
                    <th>No</th>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Nomor Telepon</th>
                    <th>Email</th>
                    <th>Pengurus UKM</th>
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

        var dataUkmAdmin;
        $(document).ready(function() { 
            dataUkmAdmin = $('#table_ukmAdmin').DataTable({ 
                // serverSide: true, jika ingin menggunakan server side processing 
                serverSide: true,      
                ajax: { 
                    "url": "{{ url('ukm/admin/list') }}", 
                    "dataType": "json", 
                    "type": "POST" ,
                    "data": function (d) {
                        d.ukm_id = $('#ukm_id').val();
                    }
                }, 
                columns: [ 
                    { 
                    data: "DT_RowIndex",             
                    className: "text-center", 
                    orderable: false, 
                    searchable: false     
                    },{ 
                    data: "nim",                
                    className: "",  
                    orderable: true,     
                    searchable: true     
                    },{ 
                    data: "name",                
                    className: "", 
                    orderable: true,     
                    searchable: true     
                    },{ 
                    data: "phone",                
                    className: "", 
                    orderable: false,     
                    searchable: false     
                    },{ 
                    data: "email",                
                    className: "", 
                    orderable: false,     
                    searchable: true     
                    },{ 
                    data: "ukm.name",                
                    className: "", 
                    orderable: true,     
                    searchable: true     
                    },{ 
                    data: "aksi",                
                    className: "", 
                    orderable: false,     
                    searchable: false     
                    } 
                ] 
            });
            
            $('#ukm_id').on('change', function () {
                dataUkmAdmin.ajax.reload();
            });
        }); 
    </script> 
@endpush  
@extends('layouts.template') 
 
@section('content') 
    <div class="card card-outline card-primary"> 
        <div class="card-header"> 
            <h3 class="card-title">{{ $page->title }}</h3> 
            <div class="card-tools"> 
                <a onclick="modalAction('{{ url('category/create') }}')" class="btn btn-block btn-info">
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
            <table class="table table-bordered table-striped table-hover table-sm" id="table_category"> 
            <thead> 
                <tr>
                    <th>No</th>
                    <th>Nama Kategori</th>
                    <th>Deskripsi</th>
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

        var dataCategory;
        $(document).ready(function() { 
            dataCategory = $('#table_category').DataTable({ 
                // serverSide: true, jika ingin menggunakan server side processing 
                serverSide: true,      
                ajax: { 
                    "url": "{{ url('category/list') }}", 
                    "dataType": "json", 
                    "type": "POST", 
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
                    orderable: true,     
                    searchable: true     
                    },{ 
                    data: "description",                
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
        }); 
    </script> 
@endpush  
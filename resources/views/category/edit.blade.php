@empty($category)
    <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h5 class="modal-title" id="exampleModalLabel">Kesalahan</h5> 
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
            </div> 
            <div class="modal-body"> 
                <div class="alert alert-danger"> 
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!!!</h5> 
                    Data yang anda cari tidak ditemukan
                </div> 
                <a href="{{ url('/category') }}" class="btn btn-warning">Kembali</a> 
            </div> 
        </div> 
    </div> 
@else 
    <form action="{{ url('/category/' . $category->id) }}" method="POST" id="form-edit"> 
        @csrf 
        @method('PUT') 
        <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kategori</h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                </div> 
                <div class="modal-body"> 
                    <div class="form-group">
                        <label for="name">Nama Kategori</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $category->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi Kategori</label>
                        <textarea id="description" name="description" class="form-control" rows="4" minlength="50" required>{{ $category->description }}</textarea>
                    </div>
                </div> 
                <div class="modal-footer"> 
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button> 
                    <button type="submit" class="btn btn-primary">Simpan</button> 
                </div> 
            </div>
        </div> 
    </form> 
<script>
    $(document).ready(function() { 
        $("#form-edit").validate({ 
            rules: {
                name: {required: true}, 
                description: {required: true},
            },
            submitHandler: function(form) { 
                let formData = new FormData(form);
                $.ajax({ 
                    url: form.action, 
                    type: form.method, 
                    data: $(form).serialize(),
                    success: function(response) { 
                        if(response.status){ 
                            $('#myModal').modal('hide'); 
                            Swal.fire({ 
                                icon: 'success', 
                                title: 'Berhasil', 
                                text: response.message 
                            }); 
                            dataCategory.ajax.reload(); 
                        }else{ 
                            $('.error-text').text(''); 
                            $.each(response.msgField, function(prefix, val) { 
                                $('#error-'+prefix).text(val[0]); 
                            }); 
                            Swal.fire({ 
                                icon: 'error', 
                                title: 'Terjadi Kesalahan', 
                                text: response.message 
                            }); 
                        } 
                    }             
                }); 
                return false; 
            }, 
            errorElement: 'span', 
            errorPlacement: function (error, element) { 
                error.addClass('invalid-feedback'); 
                element.closest('.form-group').append(error); 
            }, 
            highlight: function (element, errorClass, validClass) { 
                $(element).addClass('is-invalid'); 
            }, 
            unhighlight: function (element, errorClass, validClass) { 
                $(element).removeClass('is-invalid'); 
            } 
        }); 
    });
</script> 
@endempty 
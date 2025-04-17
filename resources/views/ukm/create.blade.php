<form action="{{ url('/ukm/ajax') }}" method="POST" id="form-tambah"> 
    @csrf 
    <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
        <div class="modal-content"> 
            <div class="modal-header"> 
                <h3 class="card-title">Tambah UKM</h3>
  
        <div class="card-tools">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
            </div> 
            <div class="modal-body"> 
                <div class="form-group">
                    <label for="name">Nama UKM</label>
                    <input type="text" id="name" class="form-control">
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi UKM</label>
                    <textarea id="description" class="form-control" rows="4"></textarea>
                </div>
                <select name="category" id="category" class="form-control" required> 
                    <option value="">- Pilih Kategori -</option> 
                    @foreach($category as $c) 
                        <option value="{{ $c->id }}">{{ $c->name }}</option> 
                    @endforeach 
                </select>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputStatus">Status</label>
                    <select id="inputStatus" class="form-control custom-select">
                        <option selected disabled>Select one</option>
                        <option>On Hold</option>
                        <option>Canceled</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputClientCompany">Client Company</label>
                    <input type="text" id="inputClientCompany" class="form-control">
                </div>
                <div class="form-group">
                    <label for="inputProjectLeader">Project Leader</label>
                    <input type="text" id="inputProjectLeader" class="form-control">
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
        $("#form-tambah").validate({ 
            rules: { 
                level_id: {required: true, number: true}, 
                username: {required: true, minlength: 3, maxlength: 20}, 
                nama: {required: true, minlength: 3, maxlength: 100}, 
                password: {required: true, minlength: 6, maxlength: 20} 
            }, 
            submitHandler: function(form) { 
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
                            dataUser.ajax.reload(); 
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
@empty($ukm)
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
                <a href="{{ url('/ukm') }}" class="btn btn-warning">Kembali</a> 
            </div> 
        </div> 
    </div> 
@else 
    <form action="{{ url('/ukm/' . $ukm->id) }}" method="POST" id="form-edit"> 
        @csrf 
        @method('PUT') 
        <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h5 class="modal-title" id="exampleModalLabel">Edit Ukm</h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                </div> 
                <div class="modal-body"> 
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $ukm->logo_path) }}" alt="Logo UKM" style="height: 200px; width: 200px;">
                    </div>
                    <div class="form-group">
                        <label for="name">Nama UKM</label>
                        <input type="text" id="name" name="name" class="form-control" value="{{ $ukm->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Deskripsi UKM</label>
                        <textarea id="description" name="description" class="form-control" rows="4" minlength="50" required>{{ $ukm->description }}</textarea>
                    </div>
                    <div class="form-group">
                        <label>Kategori</label> 
                        <select name="category_id" id="category_id" class="form-control" required> 
                            <option value="">- Pilih Kategori -</option> 
                            @foreach($category as $c) 
                                <option {{ ($c->id == $ukm->category_id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option> 
                            @endforeach 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" maxlength="50" value="{{ $ukm->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label> 
                        <div class="input-group">
                            <input type="text" class="form-control" id="display_phone" value="{{ $ukm->phone }}" required oninput="formatNumber(this, 'phone')">
                            <input type="hidden" name="phone" id="phone" value="{{ $ukm->phone }}"> 
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="website">Website</label>
                        <input type="text" name="website" id="website" class="form-control" minlength="5" maxlength="50" value="{{ $ukm->website }}">
                    </div>
                    <div class="form-group">
                        <label for="logo_ukm">Logo UKM</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="logo_ukm" name="logo_ukm" accept="image/*">
                            <label class="custom-file-label" for="logo_ukm">Pilih File</label>
                          </div>
                        </div>
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
    function formatNumber(input, hiddenInputId) {
        // Hapus semua karakter non-digit
        let value = input.value.replace(/\D/g, '');

        // Simpan nilai integer asli ke hidden input
        document.getElementById(hiddenInputId).value = value;

        // Format angka dengan spasi setiap 3 digit dari kanan untuk tampilan
        input.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ' ');
    }
    
    $(document).ready(function() { 
        $("#form-edit").validate({ 
            rules: {
                name: {required: true, maxlength: 150}, 
                description: {required: true, minlength: 50}, 
                category_id: {required: true}, 
                email: {required: true, maxlength: 100},
                phone: {required: true, maxlength: 20},
            },
            submitHandler: function(form) { 
                let formData = new FormData(form);
                $.ajax({ 
                    url: form.action, 
                    type: form.method, 
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) { 
                        if(response.status){ 
                            $('#myModal').modal('hide'); 
                            Swal.fire({ 
                                icon: 'success', 
                                title: 'Berhasil', 
                                text: response.message 
                            }); 
                            dataUkm.ajax.reload(); 
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

    function formatNumber(input, hiddenInputId) {
        // Hapus semua karakter non-digit
        let value = input.value.replace(/\D/g, '');

        input.value = value;
        // Simpan nilai integer asli ke hidden input
        document.getElementById(hiddenInputId).value = value;
    }
</script> 
@endempty 
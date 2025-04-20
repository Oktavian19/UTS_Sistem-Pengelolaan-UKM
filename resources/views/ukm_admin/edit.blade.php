@empty($ukmAdmin)
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
                <a href="{{ url('/ukm/admin') }}" class="btn btn-warning">Kembali</a> 
            </div> 
        </div> 
    </div> 
@else 
    <form action="{{ url('/ukm/admin/' . $ukmAdmin->nim) }}" method="POST" id="form-edit"> 
        @csrf 
        @method('PUT') 
        <div id="modal-master" class="modal-dialog modal-lg" role="document"> 
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h5 class="modal-title" id="exampleModalLabel">Edit Pengurus Ukm</h5> 
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button> 
                </div> 
                <div class="modal-body"> 
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $ukmAdmin->photo) }}" alt="Logo UKM" style="height: 200px; width: 200px;">
                    </div>
                    <div class="form-group">
                        <label>NIM</label> 
                        <div class="input-group">
                            <input type="text" class="form-control" id="display_nim" value="{{ $ukmAdmin->nim }}" maxlength="20" required oninput="formatNumber(this, 'nim')">
                            <input type="hidden" name="nim" id="nim" value="{{ $ukmAdmin->nim }}"> 
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="name">Nama Pengurus</label>
                        <input type="text" id="name" name="name" class="form-control" minlength="3" maxlength="100" value="{{ $ukmAdmin->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input value="" type="password" id="password" name="password" class="form-control">
                        <small class="form-text text-muted">Abaikan jika tidak ingin ubah password</small> 
                    </div>
                    <div class="form-group">
                        <label>Pengurus UKM</label> 
                        <select name="ukm_id" id="ukm_id" class="form-control" required> 
                            <option value="">- Pilih Kategori -</option> 
                            @foreach($ukm as $u) 
                                <option {{ ($u->id == $ukmAdmin->ukm_id) ? 'selected' : '' }} value="{{ $u->id }}">{{ $u->name }}</option> 
                            @endforeach 
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" minlength="3" maxlength="100" value="{{ $ukmAdmin->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor Telepon</label> 
                        <div class="input-group">
                            <input type="text" class="form-control" id="display_phone" value="{{ $ukmAdmin->phone }}" minlength="5" maxlength="20" required oninput="formatNumber(this, 'phone')">
                            <input type="hidden" name="phone" id="phone" value="{{ $ukmAdmin->phone }}"> 
                        </div> 
                    </div>
                    <div class="form-group">
                        <label for="photo_input">Foto Profil</label>
                        <div class="input-group">
                          <div class="custom-file">
                            <input type="file" class="custom-file-input" id="photo_input" name="photo_input" accept="image/*">
                            <label class="custom-file-label" for="photo_input">Pilih File</label>
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
    $(document).ready(function() { 
        $("#form-edit").validate({ 
            rules: {
                nim: {required: true}, 
                name: {required: true, maxlength: 50}, 
                password: {},
                phone: {required: true, maxlength: 20},
                email: {required: true, maxlength: 100},
                ukm_id: {required: true}, 
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
                            dataUkmAdmin.ajax.reload(); 
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

    document.getElementById('photo_input').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const maxSize = 2 * 1024 * 1024; // 2 MB dalam byte
        const errorText = document.getElementById('logoUkmError');

        if (file && file.size > maxSize) {
            errorText.classList.remove('d-none');
            e.target.value = ''; // Reset input jika file terlalu besar
        } else {
            errorText.classList.add('d-none');
        }
    });
</script> 
@endempty 
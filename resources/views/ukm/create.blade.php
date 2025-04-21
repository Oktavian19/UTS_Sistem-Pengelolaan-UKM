<form action="{{ url('/ukm') }}" method="POST" id="form-tambah"> 
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
                    <input type="text" id="name" name="name" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="description">Deskripsi UKM</label>
                    <textarea id="description" name="description" class="form-control" rows="4" minlength="50" required></textarea>
                </div>
                <div class="form-group">
                    <label>Kategori</label> 
                    <select name="category_id" id="category_id" class="form-control" required> 
                        <option value="">- Pilih Kategori -</option> 
                        @foreach($category as $c) 
                            <option value="{{ $c->id }}">{{ $c->name }}</option> 
                        @endforeach 
                    </select>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" maxlength="50" required>
                </div>
                <div class="form-group">
                    <label>Nomor Telepon</label> 
                    <div class="input-group">
                        <input type="text" class="form-control" id="display_phone" value="{{ old('phone') }}" required oninput="formatNumber(this, 'phone')">
                        <input type="hidden" name="phone" id="phone" value="{{ old('phone') }}"> 
                    </div> 
                </div>
                <div class="form-group">
                    <label for="website">Website</label>
                    <input type="url" name="website" id="website" class="form-control" minlength="5" maxlength="50">
                    <span></span>
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
                <small id="logoUkmError" class="text-danger d-none">Ukuran file melebihi 2MB</small>
            </div> 
            <div class="modal-footer"> 
                <button type="button" data-dismiss="modal" class="btn btn-warning">Batal</button> 
                <button type="submit" class="btn btn-primary">Simpan</button> 
            </div> 
        </div> 
    </div> 
</form> 
<script> 
    document.getElementById('logo_ukm').addEventListener('change', function(e) {
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

    $(document).ready(function() { 
        $("#form-tambah").validate({ 
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

        $('#logo_ukm').on('change', function () {
            // Ambil nama file yang dipilih
            var fileName = $(this).val().split('\\').pop();
            // Update label-nya
            $(this).next('.custom-file-label').html(fileName);
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
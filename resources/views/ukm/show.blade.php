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
                    Data yang anda cari tidak ditemukan</div> 
                <a href="{{ url('/ukm') }}" class="btn btn-warning">Kembali</a> 
            </div> 
        </div> 
    </div> 
@else
    <form action="{{ url('/ukm/' . $ukm->id) }}" method="POST" id="form-show"> 
    @csrf 
    @method('POST')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content"> 
                <div class="modal-header"> 
                    <h5 class="modal-title" id="exampleModalLabel">Detail UKM</h5> 
                    {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>  --}}
                </div> 
                <div class="modal-body">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle" src="{{ asset('storage/' . $ukm->logo_path) }}" alt="Logo UKM" style="height: 200px; width: 200px;">
                    </div>
                    <h3 class="text-primary">{{ $ukm->name }}</h3>
                    <p class="text-muted">{{ $ukm->description }}</p>
                    <br>
                    <div class="text-muted">
                        <p class="text-sm">Kategori
                            <b class="d-block">{{ $ukm->category->name }}</b>
                        </p>  
                        <p class="text-sm">Email
                            <b class="d-block">{{ $ukm->email }}</b>
                        </p>
                        <p class="text-sm">Nomor Telepon
                            <b class="d-block">{{ $ukm->phone }}</b>
                        </p>
                        <p class="text-sm">Website
                            <b class="d-block">{{ $ukm->website }}</b>
                        </p>
                    </div>

                    <h5 class="mt-5 text-muted">Pengurus UKM</h5>
                    <ul class="list-unstyled">
                        @foreach($ukmAdmin as $u) 
                            <li>
                                <p>{{ $u->name }} ( {{ $u->nim }} )</p>
                            </li>
                        @endforeach 
                    </ul>
                    <div class="modal-footer"> 
                        <button type="button" data-dismiss="modal" class="btn btn-primary">Kembali</button> 
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script> 
        $(document).ready(function() { 
            $("#form-show").validate({ 
                rules: {}, 
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
    </script> 
@endempty 
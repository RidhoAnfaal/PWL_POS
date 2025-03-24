@empty($barang)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="fa fa-ban icon"></i> Error!!</h5>
                    Data barang tidak ditemukan
                </div>
                <a href="{{ url('/barang') }}" class="btn btn-warning">Kembali</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/barang/' . $barang->barang_id . '/update_ajax') }}" method="POST" id="form-edit-barang">
        @csrf
        @method('PUT')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kategori_id">Kategori</label>
                        <select name="kategori_id" id="kategori_id" class="form-control" required>
                            <option value="">- Pilih Kategori -</option>
                            @foreach($kategori as $item)
                                <option value="{{ $item->kategori_id }}" {{ $barang->kategori_id == $item->kategori_id ? 'selected' : '' }}>
                                    {{ $item->kategori_nama }}
                                </option>
                            @endforeach
                        </select>
                        <small id="error-kategori_id" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="barang_kode">Kode Barang</label>
                        <input type="text" name="barang_kode" id="barang_kode" class="form-control" 
                               value="{{ $barang->barang_kode }}" required>
                        <small id="error-barang_kode" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="barang_nama">Nama Barang</label>
                        <input type="text" name="barang_nama" id="barang_nama" class="form-control" 
                               value="{{ $barang->barang_nama }}" required>
                        <small id="error-barang_nama" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="harga_beli">Harga Beli</label>
                        <input type="number" name="harga_beli" id="harga_beli" class="form-control" 
                               value="{{ $barang->harga_beli }}" required>
                        <small id="error-harga_beli" class="error-text form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="harga_jual">Harga Jual</label>
                        <input type="number" name="harga_jual" id="harga_jual" class="form-control" 
                               value="{{ $barang->harga_jual }}" required>
                        <small id="error-harga_jual" class="error-text form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </div>
        </div>
    </form>
    <script>
        $(document).ready(function() {
            $("#form-edit-barang").validate({
                rules: {
                    kategori_id: { required: true },
                    barang_kode: { 
                        required: true, 
                        minlength: 2, 
                        maxlength: 10 
                    },
                    barang_nama: { 
                        required: true, 
                        minlength: 3, 
                        maxlength: 100 
                    },
                    harga_beli: { 
                        required: true,
                        min: 1
                    },
                    harga_jual: { 
                        required: true,
                        min: 1
                    }
                },
                messages: {
                    kategori_id: {
                        required: "Kategori harus dipilih"
                    },
                    barang_kode: {
                        required: "Kode barang harus diisi",
                        minlength: "Kode barang minimal 2 karakter",
                        maxlength: "Kode barang maksimal 10 karakter"
                    },
                    barang_nama: {
                        required: "Nama barang harus diisi",
                        minlength: "Nama barang minimal 3 karakter",
                        maxlength: "Nama barang maksimal 100 karakter"
                    },
                    harga_beli: {
                        required: "Harga beli harus diisi",
                        min: "Harga beli minimal 1"
                    },
                    harga_jual: {
                        required: "Harga jual harus diisi",
                        min: "Harga jual minimal 1"
                    }
                },
                submitHandler: function(form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function(response) {
                            if (response.status) {
                                $('#barangModal').modal('hide');
                                Swal.fire({ 
                                    icon: 'success', 
                                    title: 'Sukses', 
                                    text: response.message 
                                });
                                $('#table_barang').DataTable().ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.errors, function(prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({ 
                                    icon: 'error', 
                                    title: 'Gagal', 
                                    text: response.message 
                                });
                            }
                        },
                        error: function(xhr) {
                            Swal.fire({ 
                                icon: 'error', 
                                title: 'Error', 
                                text: 'Terjadi kesalahan. Silakan coba lagi.' 
                            });
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty
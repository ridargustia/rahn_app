<div class="card mb-4">
    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
        <h5 class="m-0 font-weight-bold text-primary">Tambah Pinjaman Untuk Anggota Lama</h5>
    </div>
</div>

<?php if (is_grandadmin()) { ?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Instansi <span style="color: red">*</span></label>
                        <?php echo form_dropdown('', $get_all_combobox_instansi, '', $instansi_id) ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Cabang <span style="color: red">*</span></label>
                        <?php echo form_dropdown('', array('' => '- Pilih Instansi Dulu -'), '', $cabang_id) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Pilih Anggota <span style="color: red">*</span></label>
                        <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $user_id) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif (is_masteradmin()) { ?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Cabang <span style="color: red">*</span></label>
                        <?php echo form_dropdown('', $get_all_combobox_cabang, '', $cabang_id) ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Pilih Anggota <span style="color: red">*</span></label>
                        <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $user_id) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } elseif (is_superadmin()) { ?>
    <div class="card mb-4">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label>Pilih Anggota <span style="color: red">*</span></label>
                        <?php echo form_dropdown('', $get_all_combobox_user, '', $user_id) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>

<div class="card mb-4">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Nama</label>
                    <?php echo form_input($name) ?>
                    <small id="emailHelp" class="form-text text-muted">Isikan nama lengkap.</small>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>NIK</label>
                    <?php echo form_input($nik) ?>
                    <small id="emailHelp" class="form-text text-muted">Isikan nomor induk kependudukan sesuai KTP.</small>
                </div>
            </div>
        </div>
        <div class="form-group">
            <label>Alamat</label>
            <?php echo form_input($address) ?>
            <small id="emailHelp" class="form-text text-muted">Isikan alamat lengkap sesuai KTP.</small>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Email</label>
                    <?php echo form_input($email) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>No HP/Telephone/WhatsApp</label>
                    <?php echo form_input($phone) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Jumlah Pinjaman <span style="color: red">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">RP</span>
                        </div>
                        <?php echo form_input($jml_pinjaman) ?>
                        <div class="input-group-append">
                            <span class="input-group-text">,00</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="touchSpin">Jangka Waktu Pinjaman <span style="color: red">*</span></label>
                    <?php echo form_input($jangka_waktu_pinjam) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label for="dateRangePicker">Jangka Waktu Gadai</label>
                    <div class="input-daterange input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                        </div>
                        <?php echo form_input($waktu_gadai) ?>
                        <div class="input-group-prepend">
                            <span class="input-group-text">-</span>
                        </div>
                        <?php echo form_input($jatuh_tempo_gadai) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Jenis Barang Yang Digadaikan <span style="color: red">*</span></label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <?php echo form_dropdown('', $jenis_barang_value, '', $jenis_barang) ?>
                        </div>
                        <?php echo form_input($jenis_barang_gadai) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <div id="form-jenis-barang"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Sewa Tempat Perbulan</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <?php echo form_input($sewa_tempat_perbulan) ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Total Biaya Sewa</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text">Rp</span>
                        </div>
                        <?php echo form_input($total_biaya_sewa) ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Sistem Pembayaran Sewa <span style="color: red">*</span></label>
                    <?php echo form_dropdown('', $sistem_pembayaran_sewa_value, '', $sistem_pembayaran_sewa) ?>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label for="exampleFormControlSelect1">Sumber Dana <span style="color: red">*</span></label>
                    <?php echo form_dropdown('', $sumber_dana_value, '', $sumber_dana) ?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-5">
                <div class="form-group">
                    <label for="dateRangePicker">Foto Barang Yang Digadaikan <span style="color: red">*</span></label>
                    <img id="preview" width="100%"/>
                </div>
                <div class="form-group">
                    <div class="custom-file">
                        <input type="file" name="photo" onchange="photoPreview(this,'preview')" class="custom-file-input" id="customFile" required>
                        <label class="custom-file-label" for="customFile">Upload Foto Disini</label>
                    </div>
                    <small class="form-text text-muted">Maximum file size 2Mb</small>
                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="card-footer">
        <button type="reset" class="btn btn-warning"><?php echo $btn_reset ?></button>
        <button type="submit" class="btn btn-primary">Berikutnya</button>
    </div>
</div>

<!-- Select2 -->
<script src="<?php echo base_url('assets/select2/dist/js/select2.min.js') ?>"></script>
<!-- Select2 -->

<script>
    $(document).ready(function() {
        $('#jml_pinjaman').maskMoney({
            thousands: '.',
            decimal: ',',
            precision: 0
        });

        $('#jangka_waktu_pinjam').TouchSpin({
            min: 0,
            max: 100,
            postfix: 'Bulan',
            // initval: 0,
            boostat: 5,
            maxboostedstep: 10
        });

        // Select2 Single  with Placeholder
        $('.select2-single-placeholder').select2({
            placeholder: "- Silahkan Pilih Anggota -",
            allowClear: false
        });

    });

    function photoPreview(customFile,idpreview) {
        var gb = customFile.files;
        for (var i = 0; i < gb.length; i++) {
            var gbPreview = gb[i];
            var imageType = /image.*/;
            var preview=document.getElementById(idpreview);
            var reader = new FileReader();
            if (gbPreview.type.match(imageType)) {
                //jika tipe data sesuai
                preview.file = gbPreview;
                reader.onload = (function(element) {
                    return function(e) {
                        element.src = e.target.result;
                    };
                })(preview);
                //membaca data URL gambar
                reader.readAsDataURL(gbPreview);
            } else {
                //jika tipe data tidak sesuai
                alert("Tipe file tidak sesuai. Gambar harus bertipe .png, .gif atau .jpg.");
            }
        }
    }

    function tampilCabang() {
        instansi_id = document.getElementById("instansi_id").value;
        $.ajax({
            url: "<?php echo base_url(); ?>admin/cabang/pilih_cabang/" + instansi_id + "",
            success: function(response) {
                $("#cabang_id").html(response);
            },
            dataType: "html"
        });
        return false;
    }

    function tampilUser() {
        cabang_id = document.getElementById("cabang_id").value;
        $.ajax({
            url: "<?php echo base_url(); ?>admin/auth/pilih_anggota/" + cabang_id + "",
            success: function(response) {
                $("#user_id").html(response);
            },
            dataType: "html"
        });
        return false;
    }

    function tampilDetailUser() {
        user_id = document.getElementById("user_id").value;
        $.ajax({
            url: "<?php echo base_url(); ?>admin/auth/pilih_detail_anggota/" + user_id + "",
            success: function(response) {
                var myObj = JSON.parse(response);

                $('#name').val(myObj.name);
                $('#nik').val(myObj.nik);
                $('#address').val(myObj.address);
                $('#email').val(myObj.email);
                $('#phone').val(myObj.phone);
            },
        });
        return false;
    }

    $('#jangka_waktu_pinjam').on('change', function() {

        jangka_waktu_pinjam = document.getElementById("jangka_waktu_pinjam").value;

        $.ajax({
            url: "<?php echo base_url('admin/pembiayaan/konversi_jangka_waktu_gadai/') ?>" + jangka_waktu_pinjam,
            success: function(response) {
                var myObj = JSON.parse(response);

                $('#waktu_gadai').val(myObj.today);
                $('#jatuh_tempo_gadai').val(myObj.hasil_konversi);
            }
        });
    });

    $('#jenis_barang').on('change', function() {

        jenis_barang = document.getElementById("jenis_barang").value;

        $.ajax({
            url: "<?php echo base_url('admin/pembiayaan/ubah_satuan/') ?>" + jenis_barang,
            beforeSend: function() {
                $("#form-jenis-barang").html('<center class="pt-4"><h1><i class="fa fa-spin fa-spinner" /></h1></center>');
            },
            success: function(response) {
                $("#form-jenis-barang").html(response);
            }
        });
    });

</script>
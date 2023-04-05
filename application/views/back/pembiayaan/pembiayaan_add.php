<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

<!-- Bootstrap DatePicker -->
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<!-- Bootstrap DatePicker -->
<!-- Bootstrap Touchspin -->
<link href="<?php echo base_url('assets/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css') ?>" rel="stylesheet">
<!-- Bootstrap Touchspin -->
</head>
<!-- Meta -->

<body id="page-top">
    <div id="wrapper">
        <!-- Sidebar -->
        <?php $this->load->view('back/template/sidebar'); ?>
        <!-- Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <!-- TopBar -->
                <?php $this->load->view('back/template/navbar'); ?>
                <!-- Topbar -->

                <!-- Container Fluid-->
                <div class="container-fluid" id="container-wrapper">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"><?php echo $page_title ?></h1>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url('admin/dashboard') ?>">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page"><?php echo $page_title ?></li>
                        </ol>
                    </div>

                    <!--Row-->
                    <div class="row">
                        <div class="col-md-12">
                            <?php if ($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            } ?>
                            <?php echo validation_errors() ?>
                            <!-- Content -->
                            <?php echo form_open_multipart($action) ?>
                            <?php if (is_grandadmin()) { ?>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Instansi</label>
                                                    <?php echo form_dropdown('', $get_all_combobox_instansi, '', $instansi_id) ?>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Cabang</label>
                                                    <?php echo form_dropdown('', array('' => '- Pilih Instansi Dulu -'), '', $cabang_id) ?>
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
                                                    <label>Cabang</label>
                                                    <?php echo form_dropdown('', $get_all_combobox_cabang, '', $cabang_id) ?>
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
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Email</label>
                                                <?php echo form_input($email) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>No HP/Telephone/WhatsApp</label>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">+62</span>
                                                    </div>
                                                    <?php echo form_input($phone) ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Jumlah Pinjaman</label>
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
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label for="touchSpin">Jangka Waktu Pinjaman</label>
                                                <?php echo form_input($jangka_waktu_pinjam) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Jenis Barang Yang Digadaikan</label>
                                                <?php echo form_input($jenis_barang_gadai) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>Berat/Nilai Barang Yang Digadaikan</label>
                                                <div class="input-group mb-3">
                                                    <?php echo form_input($berat_barang_gadai) ?>
                                                    <div class="input-group-append">
                                                        <span class="input-group-text">Gram</span>
                                                    </div>
                                                </div>
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
                                                <label for="exampleFormControlSelect1">Sistem Pembayaran Sewa</label>
                                                <?php echo form_dropdown('', $sistem_pembayaran_sewa_value, '', $sistem_pembayaran_sewa) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="exampleFormControlSelect1">Sumber Dana</label>
                                                <?php echo form_dropdown('', $sumber_dana_value, '', $sumber_dana) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label for="dateRangePicker">Foto Barang Yang Digadaikan</label>
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
                                <?php echo form_close() ?>
                            </div>
                            <!-- Content -->
                        </div>
                    </div>
                    <!--Row-->

                    <!-- Modal Logout -->
                    <?php $this->load->view('back/template/modal_logout'); ?>
                    <!-- Modal Logout -->
                </div>
                <!--Container Fluid-->
            </div>
            <!-- Footer - Copyright -->
            <?php $this->load->view('back/template/footer_copyright'); ?>
            <!-- Footer - Copyright -->
        </div>
    </div>

    <!-- Scroll to top -->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>
    <!-- Scroll to top -->

    <!-- Footer -->
    <?php $this->load->view('back/template/footer'); ?>
    <!-- Footer -->
    <!-- Bootstrap Datepicker -->
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Bootstrap Datepicker -->
    <!-- maskMoney -->
    <script src="<?php echo base_url('assets/') ?>maskMoney/jquery.maskMoney.min.js"></script>
    <!-- maskMoney -->
    <!-- Bootstrap Touchspin -->
    <script src="<?php echo base_url('assets/') ?>bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
    <!-- Bootstrap Touchspin -->

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
    </script>
</body>

</html>
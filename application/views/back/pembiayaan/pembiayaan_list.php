<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

<!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
<!-- DataTables -->
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

                            <div class="alert alert-info" role="alert">
                                <b>INFORMASI KESELURUHAN PEMBIAYAAN</b>
                                <hr>
                                Total Pembiayaan : <b>Rp <?php echo number_format($get_total_pinjaman[0]->total_pinjaman, 0, ',', '.') ?></b><br>
                                Total Biaya Sewa : <b>Rp <?php echo number_format($get_biaya_sewa[0]->biaya_sewa, 0, ',', '.') ?></b>
                            </div>

                            <!-- Content -->
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <a href="<?php echo $add_action ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $btn_add ?></a>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>No Anggota</th>
                                                <th>Nama</th>
                                                <th>Dibuat Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($get_all as $data) {
                                                // Action
                                                $delete = '<a href="' . base_url('admin/pembiayaan/delete_by_user/' . $data->id_users) . '" id="delete-button" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                                                $detail = '<a href="' . base_url('admin/pembiayaan/detail/' . $data->id_users) . '" class="btn btn-sm btn-info" title="Detail Data"><i class="fas fa-info-circle"></i></a>';
                                            ?>
                                                <tr>
                                                    <td><?php echo $data->no_anggota ?></td>
                                                    <td><?php echo $data->name ?></td>
                                                    <td><?php echo $data->created_by ?></td>
                                                    <td><?php echo $detail ?> <?php echo $delete ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Content -->
                        </div>
                    </div>
                    <!--Row-->

                    <!-- Modal Logout -->
                    <?php $this->load->view('back/template/modal_logout'); ?>
                    <!-- Modal Logout -->

                    <!-- Modal Edit -->
                    <?php $this->load->view('back/pembiayaan/modal_edit');
                    ?>
                    <!-- Modal Edit -->

                    <!-- Modal detail -->
                    <?php $this->load->view('back/pembiayaan/modal_detail'); ?>
                    <!-- Modal detail -->
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
    <!-- Datatables -->
    <script src="<?php echo base_url('assets/datatables/jquery.dataTables.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/datatables/dataTables.bootstrap4.min.js') ?>"></script>
    <!-- Datatables -->
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
                initval: 0,
                boostat: 5,
                maxboostedstep: 10
            });

            $('#waktu_gadai').datepicker({
                startView: 2,
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true,
                todayBtn: 'linked',
            });

            $('#jatuh_tempo_gadai').datepicker({
                startView: 2,
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true,
                todayBtn: 'linked',
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                searching: false,
                paging: false
            }); // ID From dataTable
            $('#dataTableHover').DataTable({
                ordering: false,
            }); // ID From dataTable with Hover
        });

        $(document).ready(function() {
            $(document).on('click', '#editPembiayaan', function() {
                const id_pembiayaan = $(this).data('id_pembiayaan');
                const name = $(this).data('name');
                const nik = $(this).data('nik');
                const address = $(this).data('address');
                const email = $(this).data('email');
                const phone = $(this).data('phone');
                const jml_pinjaman = $(this).data('jml_pinjaman');
                const jangka_waktu_pinjam = $(this).data('jangka_waktu_pinjam');
                const jenis_barang_gadai = $(this).data('jenis_barang_gadai');
                const berat_barang_gadai = $(this).data('berat_barang_gadai');
                const waktu_gadai = $(this).data('waktu_gadai');
                const jatuh_tempo_gadai = $(this).data('jatuh_tempo_gadai');
                const sistem_pembayaran_sewa = $(this).data('sistem_pembayaran_sewa');
                const sumber_dana = $(this).data('sumber_dana');
                const image = $(this).data('image');
                $('#id_pembiayaan').val(id_pembiayaan);
                $('#name').val(name);
                $('#nik').val(nik);
                $('#address').val(address);
                $('#email').val(email);
                $('#phone').val(phone);
                $('#jml_pinjaman').val(jml_pinjaman);
                $('#jangka_waktu_pinjam').val(jangka_waktu_pinjam);
                $('#jenis_barang_gadai').val(jenis_barang_gadai);
                $('#berat_barang_gadai').val(berat_barang_gadai);
                $('#waktu_gadai').val(waktu_gadai);
                $('#jatuh_tempo_gadai').val(jatuh_tempo_gadai);
                $('#sistem_pembayaran_sewa').val(sistem_pembayaran_sewa);
                $('#sumber_dana').val(sumber_dana);

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembiayaan/current_image_for_edit_pembiayaan/') ?>" + image,
                    success: function(data) {
                        $("#currentImage").html(data);
                    },
                });

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembiayaan/get_sumber_dana/') ?>" + id_pembiayaan,
                    success: function(data) {
                        $("#showDeposanForUpdate").html(data);
                    },
                });

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembiayaan/button_component/') ?>" + id_pembiayaan,
                    success: function(data) {
                        $("#buttonComponent").html(data);
                    },
                });

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembiayaan/component_dropdown/') ?>" + id_pembiayaan,
                    success: function(data) {
                        $("#showComponent").html(data);
                    },
                });
            });

            $(document).on('click', '#detailPembiayaan', function() {
                const id_pembiayaan = $(this).data('id_pembiayaan');
                const no_pinjaman = $(this).data('no_pinjaman');
                const name = $(this).data('name');
                const nik = $(this).data('nik');
                const address = $(this).data('address');
                const email = $(this).data('email');
                const phone = $(this).data('phone');
                const jml_pinjaman = $(this).data('jml_pinjaman');
                const jangka_waktu_pinjam = $(this).data('jangka_waktu_pinjam');
                const jenis_barang_gadai = $(this).data('jenis_barang_gadai');
                const berat_barang_gadai = $(this).data('berat_barang_gadai');
                const waktu_gadai = $(this).data('waktu_gadai');
                const jatuh_tempo_gadai = $(this).data('jatuh_tempo_gadai');
                const jangka_waktu_gadai = $(this).data('jangka_waktu_gadai');
                const sewa_tempat_perbulan = $(this).data('sewa_tempat_perbulan');
                const total_biaya_sewa = $(this).data('total_biaya_sewa');
                const sistem_pembayaran_sewa = $(this).data('sistem_pembayaran_sewa');
                const sumber_dana = $(this).data('sumber_dana');
                const image = $(this).data('image');
                const instansi_name = $(this).data('instansi_name');
                const cabang_name = $(this).data('cabang_name');
                $('#showDaftar').val(id_pembiayaan);
                $('#showImage').val(image);
                $('.no_pinjaman').text(no_pinjaman);
                $('.name').text(name);
                $('.nik').text(nik);
                $('.address').text(address);
                $('.email').text(email);
                $('.phone').text(phone);
                $('.jml_pinjaman').text(jml_pinjaman);
                $('.jangka_waktu_pinjam').text(jangka_waktu_pinjam);
                $('.jenis_barang_gadai').text(jenis_barang_gadai);
                $('.berat_barang_gadai').text(berat_barang_gadai);
                $('.waktu_gadai').text(waktu_gadai);
                $('.jatuh_tempo_gadai').text(jatuh_tempo_gadai);
                $('.jangka_waktu_gadai').text(jangka_waktu_gadai);
                $('.sewa_tempat_perbulan').text(sewa_tempat_perbulan);
                $('.total_biaya_sewa').text(total_biaya_sewa);
                $('.sistem_pembayaran_sewa').text(sistem_pembayaran_sewa);
                $('.sumber_dana').text(sumber_dana);
                $('.instansi_name').text(instansi_name);
                $('.cabang_name').text(cabang_name);

            });

            $(document).on('click', '#showDaftar', function() {
                const id_pembiayaan = $(this).val();

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembiayaan/get_sumber_dana/') ?>" + id_pembiayaan,
                    beforeSend: function(data) {
                        $("#showDeposan").html('<center><h1><i class="fa fa-spin fa-spinner" /></h1></center>');
                    },
                    success: function(data) {
                        $("#showDeposan").html(data);
                    },
                });
            });

            $(document).on('click', '#showImage', function() {
                const image = $(this).val();

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembiayaan/get_image/') ?>" + image,
                    beforeSend: function(data) {
                        $("#showBarangGadai").html('<center><h1><i class="fa fa-spin fa-spinner" /></h1></center>');
                    },
                    success: function(data) {
                        $("#showBarangGadai").html(data);
                    },
                });
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
                    $("#currentImage").hide();
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
    </script>
</body>

</html>
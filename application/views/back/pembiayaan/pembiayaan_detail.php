<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

<!-- Bootstrap DatePicker -->
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<!-- Bootstrap DatePicker -->
<!-- Bootstrap Touchspin -->
<link href="<?php echo base_url('assets/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css') ?>" rel="stylesheet">
<!-- Bootstrap Touchspin -->
<style>
    .width-modal {
        max-width: 80%;
    }

    @media only screen and (max-width: 600px) {
        .width-modal {
            max-width: 100%;
        }
    }
</style>
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
                            <div class="row">
                                <div class="col-xl-7 col-lg-7">
                                    <div class="card mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h4 class="m-0 font-weight-bold text-primary">Daftar Pinjaman</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No Pinjaman</th>
                                                        <th>Nominal</th>
                                                        <th>Status</th>
                                                        <th style="width: 100px">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach ($pembiayaan as $data) {
                                                            if ($data->sistem_pembayaran_sewa == 1) {
                                                                $sistem_pembayaran_sewa = 'Bulanan';
                                                            } elseif ($data->sistem_pembayaran_sewa == 2) {
                                                                $sistem_pembayaran_sewa = 'Jatuh Tempo';
                                                            }

                                                            if ($data->sumber_dana == 1) {
                                                                $sumber_dana = 'Tabungan';
                                                            } elseif ($data->sumber_dana == 2) {
                                                                $sumber_dana = 'Deposito';
                                                            } elseif ($data->sumber_dana == 3) {
                                                                $sumber_dana = 'Tabungan dan Deposito';
                                                            }

                                                            // Action
                                                            $detail = '<a href="#" id="detailPembiayaan" class="btn btn-sm btn-info" title="Detail Data" data-toggle="modal" data-target="#detailPembiayaanModal" data-id_pembiayaan="' . $data->id_pembiayaan . '" data-no_pinjaman="' . $data->no_pinjaman . '" data-name="' . $data->name . '" data-nik="' . $data->nik . '" data-address="' . $data->address . '" data-email="' . $data->email . '" data-phone="' . $data->phone . '" data-jml_pinjaman="' . number_format($data->jml_pinjaman, 0, ',', '.') . '" data-jangka_waktu_pinjam="' . $data->jangka_waktu_pinjam . '" data-jenis_barang_gadai="' . $data->jenis_barang_gadai . '" data-berat_barang_gadai="' . $data->berat_barang_gadai . '" data-waktu_gadai="' . date_indonesian_only($data->waktu_gadai) . '" data-jatuh_tempo_gadai="' . date_indonesian_only($data->jatuh_tempo_gadai) . '" data-jangka_waktu_gadai="' . $data->jangka_waktu_gadai . '" data-sewa_tempat_perbulan="' . number_format($data->sewa_tempat_perbulan, 0, ',', '.') . '" data-total_biaya_sewa="' . number_format($data->total_biaya_sewa, 0, ',', '.') . '" data-sistem_pembayaran_sewa="' . $sistem_pembayaran_sewa . '" data-sumber_dana="' . $sumber_dana . '" data-image="' . $data->image . '" data-instansi_name="' . $data->instansi_name . '" data-cabang_name="' . $data->cabang_name . '" data-created_by="' . $data->created_by . '" data-created_at="' . date_indonesian_only($data->created_at) . ' | ' . time_only2($data->created_at) . '"><i class="fas fa-info-circle"></i></a>';
                                                            $edit = '<a href="#" id="editPembiayaan" class="btn btn-sm btn-warning" title="Edit Data" data-toggle="modal" data-target="#editPembiayaanModal" data-id_pembiayaan="' . $data->id_pembiayaan . '" data-name="' . $data->name . '" data-nik="' . $data->nik . '" data-address="' . $data->address . '" data-email="' . $data->email . '" data-phone="' . $data->phone . '" data-jml_pinjaman="' . $data->jml_pinjaman . '" data-jangka_waktu_pinjam="' . $data->jangka_waktu_pinjam . '" data-jenis_barang_gadai="' . $data->jenis_barang_gadai . '" data-berat_barang_gadai="' . $data->berat_barang_gadai . '" data-waktu_gadai="' . $data->waktu_gadai . '" data-jatuh_tempo_gadai="' . $data->jatuh_tempo_gadai . '" data-sistem_pembayaran_sewa="' . $data->sistem_pembayaran_sewa . '" data-sumber_dana="' . $data->sumber_dana . '" data-image="' . $data->image . '"><i class="fas fa-pen"></i></a>';
                                                            $delete = '<a href="' . base_url('admin/pembiayaan/delete_permanent/' . $data->id_pembiayaan) . '" id="delete-button-permanent" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                                                    ?>
                                                    <tr>
                                                        <td class="text-primary"><?php echo $data->no_pinjaman ?></td>
                                                        <td>Rp. <?php echo number_format($data->jml_pinjaman, 0, ',', '.') ?></td>
                                                        <td>
                                                            <?php if ($data->status_pembayaran == 0) { ?>
                                                                <span class="badge badge-danger">BELUM LUNAS</span>
                                                            <?php } elseif ($data->status_pembayaran == 1) { ?>
                                                                <span class="badge badge-success">LUNAS</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo $detail ?> <?php echo $delete ?></td>
                                                    </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer"></div>
                                    </div>
                                </div>
                                <div class="col-xl-5 col-lg-5">
                                    <div class="card mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h4 class="m-0 font-weight-bold text-primary">Data Anggota</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">No Anggota</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px" class="text-primary"><b><?php echo $anggota->no_anggota ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Nama</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->name ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">NIK</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->nik ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Email</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->email ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Alamat</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->address ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">No Telepon</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>+<?php echo $anggota->phone ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Username</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->username ?></b></td>
                                                    </tr>
                                                    <?php if (is_grandadmin()) { ?>
                                                        <tr>
                                                            <td style="width: 120px; padding-right: 5px">Cabang</td>
                                                            <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                            <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->cabang_name ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 120px; padding-right: 5px">Instansi</td>
                                                            <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                            <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->instansi_name ?></b></td>
                                                        </tr>
                                                    <?php } elseif (is_masteradmin()) { ?>
                                                        <tr>
                                                            <td style="width: 120px; padding-right: 5px">Cabang</td>
                                                            <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                            <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->cabang_name ?></b></td>
                                                        </tr>
                                                    <?php } ?>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer"></div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h4 class="m-0 font-weight-bold text-primary">Data Total Pinjaman</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Total Pinjaman</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($total_pinjaman[0]->jml_pinjaman, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Total Biaya Sewa</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($biaya_sewa[0]->biaya_sewa, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Tanggungan</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($tanggungan, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Total Terbayar</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($terbayar[0]->jml_terbayar, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Kekurangan Bayar</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($kekurangan_bayar, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Content -->
                        </div>
                    </div>
                    <!--Row-->

                    <!-- Modal Logout -->
                    <?php $this->load->view('back/template/modal_logout'); ?>
                    <!-- Modal Logout -->

                    <!-- Modal detail -->
                    <?php $this->load->view('back/pembiayaan/modal_detail'); ?>
                    <!-- Modal detail -->

                    <!-- Modal Edit -->
                    <?php $this->load->view('back/pembiayaan/modal_edit');
                    ?>
                    <!-- Modal Edit -->

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
    <!-- maskMoney -->
    <script src="<?php echo base_url('assets/') ?>maskMoney/jquery.maskMoney.min.js"></script>
    <!-- maskMoney -->
    <!-- Bootstrap Touchspin -->
    <script src="<?php echo base_url('assets/') ?>bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
    <!-- Bootstrap Touchspin -->
    <!-- Bootstrap Datepicker -->
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Bootstrap Datepicker -->

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
                const created_by = $(this).data('created_by');
                const created_at = $(this).data('created_at');
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
                $('.created_by').text(created_by);
                $('.created_at').text(created_at);
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
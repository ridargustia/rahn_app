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

                            <!-- Notifikasi Ketersediaan Saldo Tabungan -->
                            <?php if ($saldo_tabungan < 0) { ?>
                                <div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Saldo Tabungan Tidak Cukup!</b></h6></div>
                            <?php } ?>
                            <!-- Notifikasi Ketersediaan Saldo Tabungan -->

                            <!-- Content -->
                            <div class="card mb-4">
                                <?php if ($status_sumber_dana == 1) { ?>
                                    <div class="alert alert-info" role="alert">
                                        Nama Anggota : <b><?php echo $this->session->nama_anggota ?></b><br>
                                        Jumlah Pinjaman Anggota : <b>Rp <?php echo number_format($this->session->jml_pinjaman, 0, ',', '.') ?></b> <?php if ($saldo_tabungan < 0) { ?><a href="#" id="changePinjaman" class="btn btn-sm btn-warning" data-toggle="modal" data-target="#modalChangePinjaman">Ubah Jumlah Pinjaman</a> <?php } ?><br>
                                        <hr>
                                        Saldo Tabungan Saat Ini : <b>Rp <?php echo number_format($instansi->saldo_tabungan, 0, ',', '.') ?></b><br>
                                        Dana Yang Digunakan : <b>Rp <?php echo number_format($this->session->jml_pinjaman, 0, ',', '.') ?> (100%)</b>
                                    </div>
                                <?php } elseif ($status_sumber_dana == 2) { ?>
                                    <div class="alert alert-info" role="alert">
                                        Nama Anggota : <b><?php echo $this->session->nama_anggota ?></b><br>
                                        Jumlah Pinjaman Anggota : <b>Rp <?php echo number_format($this->session->jml_pinjaman, 0, ',', '.') ?></b><br>
                                        Sisa Pembagian Deposito : <b>Rp <?php echo number_format($this->session->total_pinjaman, 0, ',', '.') ?></b><br>
                                        <hr>
                                        Deposan Terpilih : <b>
                                            <?php
                                            if (!empty($this->session->id_deposito)) {
                                                for ($i = 0; $i < count($this->session->id_deposito); $i++) {
                                                    echo $this->session->nama_deposan[$i] . ' (' . $this->session->persentase_deposito[$i] . '%). ';
                                                }
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </b>
                                    </div>
                                <?php } elseif ($status_sumber_dana == 3) { ?>
                                    <div class="alert alert-info" role="alert">
                                        <b>PENGGUNAAN DANA DEPOSITO</b><br>
                                        <hr>
                                        Nama Anggota : <b><?php echo $this->session->nama_anggota ?></b><br>
                                        Jumlah Pinjaman Anggota : <b>Rp <?php echo number_format($this->session->jml_pinjaman, 0, ',', '.') ?></b><br>
                                        Sisa Pembagian Deposito : <b>Rp <?php echo number_format($this->session->total_pinjaman, 0, ',', '.') ?></b><br>
                                        Deposan Terpilih : <b>
                                            <?php
                                            if (!empty($this->session->id_deposito)) {
                                                for ($i = 0; $i < count($this->session->id_deposito); $i++) {
                                                    echo $this->session->nama_deposan[$i] . ' (' . $this->session->persentase_deposito[$i] . '%). ';
                                                }
                                            } else {
                                                echo '-';
                                            }
                                            ?>
                                        </b>
                                    </div>
                                <?php } ?>

                                <?php echo form_open($action) ?>
                                <?php if ($status_sumber_dana == 2) { ?>
                                    <?php $this->load->view('back/pembiayaan/sumber_dana_deposito'); ?>
                                <?php } elseif ($status_sumber_dana == 3) { ?>
                                    <?php $this->load->view('back/pembiayaan/sumber_dana_tabungan_deposito'); ?>
                                <?php } ?>
                                <hr>
                                <?php echo form_input($id_pembiayaan, $this->session->id_anggota) ?>
                                <?php echo form_input($sumber_dana, $status_sumber_dana) ?>
                                <?php echo form_input($instansi_id, $this->session->instansi) ?>
                                <?php echo form_input($cabang_id, $this->session->cabang) ?>
                                <div class="card-footer">
                                    <button type="reset" class="btn btn-warning"><?php echo $btn_reset ?></button>
                                    <button type="submit" class="btn btn-primary"><?php echo $btn_submit ?></button>
                                </div>
                                <?php echo form_close() ?>
                            </div>
                            <!-- Content -->
                        </div>
                    </div>
                    <!--Row-->

                    <!-- Modal Persentase -->
                    <?php $this->load->view('back/pembiayaan/modal_persentase'); ?>
                    <!-- Modal Persentase -->

                    <!-- Modal Ubah Pinjaman -->
                    <?php $this->load->view('back/pembiayaan/modal_change_pinjaman'); ?>
                    <!-- Modal Ubah Pinjaman -->

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
            $('#dataTable').DataTable(); // ID From dataTable
            $('#dataTableHover').DataTable({
                ordering: false,
            }); // ID From dataTable with Hover

            $('#jml_pinjaman').maskMoney({
                thousands: '.',
                decimal: ',',
                precision: 0
            });

            $(document).on('click', '#persentaseDeposito', function() {
                const id_deposito = $(this).data('id_deposito');
                $('#id_deposito').val(id_deposito);
            });
        });

        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.toString().replace(/[^,\d]/g, ''),
                split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
        }

        $('#persentase_deposito').on('keyup', function() {
            persentase_deposito = document.getElementById("persentase_deposito").value;

            $.ajax({
                url: "<?php echo base_url('admin/pembiayaan/konversi_nominal/') ?>" + persentase_deposito,
                success: function(response) {
                    var myObj = JSON.parse(response);

                    $('#konversi_nominal').val(formatRupiah(myObj.hasil_konversi));
                }
            });
        });
    </script>
</body>

</html>
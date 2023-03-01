<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

<!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
<!-- DataTables -->
<!-- Bootstrap DatePicker -->
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<!-- Bootstrap DatePicker -->
<style>
    .display {
        display: inline;
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

                            <div class="alert alert-info" role="alert">
                                <b>INFORMASI KESELURUHAN DEPOSITO</b>
                                <hr>
                                Total Deposito : <b>Rp <?php echo number_format($get_total_deposito[0]->total_deposito, 0, ',', '.') ?></b><br>
                                Serapan Deposito : <b>Rp <?php echo number_format($get_serapan_deposito[0]->resapan_deposito, 0, ',', '.') ?></b><br>
                                Saldo Deposito : <b>Rp <?php echo number_format($get_saldo_deposito[0]->saldo_deposito, 0, ',', '.') ?></b>
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
                                                <th>Nama Deposan</th>
                                                <th>NIK</th>
                                                <th>Jumlah Deposito</th>
                                                <th>Dibuat Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($get_all as $data) {
                                                // Action
                                                $edit = '<a href="#" id="editDeposito" class="btn btn-sm btn-warning" title="Edit Data" data-toggle="modal" data-target="#exampleModal" data-id_deposito="' . $data->id_deposito . '" data-name="' . $data->name . '" data-nik="' . $data->nik . '" data-address="' . $data->address . '" data-email="' . $data->email . '" data-phone="' . $data->phone . '" data-total_deposito="' . $data->total_deposito . '" data-waktu_deposito="' . $data->waktu_deposito . '" data-jatuh_tempo="' . $data->jatuh_tempo . '"><i class="fas fa-pen"></i></a>';
                                                $delete = '<a href="' . base_url('admin/deposito/delete/' . $data->id_deposito) . '" id="delete-button" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                                                $detail = '<a href="#" id="detailDeposito" class="btn btn-sm btn-info" title="Detail Data" data-toggle="modal" data-target="#detailModal" data-id_deposito="' . $data->id_deposito . '" data-name="' . $data->name . '" data-nik="' . $data->nik . '" data-address="' . $data->address . '" data-email="' . $data->email . '" data-phone="' . $data->phone . '" data-total_deposito="' . number_format($data->total_deposito, 0, ',', '.') . '" data-resapan_deposito="' . number_format($data->resapan_deposito, 0, ',', '.') . '" data-saldo_deposito="' . number_format($data->saldo_deposito, 0, ',', '.') . '" data-jangka_waktu="' . $data->jangka_waktu . '" data-waktu_deposito="' . date_indonesian_only($data->waktu_deposito) . '" data-jatuh_tempo="' . date_indonesian_only($data->jatuh_tempo) . '" data-bagi_hasil="' . $data->bagi_hasil . '" data-instansi_name="' . $data->instansi_name . '" data-cabang_name="' . $data->cabang_name . '"><i class="fas fa-info-circle"></i></a>';
                                            ?>
                                                <tr>
                                                    <td><?php echo $data->name ?></td>
                                                    <td><?php echo $data->nik ?></td>
                                                    <td>Rp. <?php echo number_format($data->total_deposito, 0, ',', '.') ?></td>
                                                    <td><?php echo $data->created_by ?></td>
                                                    <td><?php echo $detail ?> <?php echo $edit ?> <?php echo $delete ?></td>
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
                    <?php $this->load->view('back/deposito/modal_edit'); ?>
                    <!-- Modal Edit -->

                    <!-- Modal detail -->
                    <?php $this->load->view('back/deposito/modal_detail'); ?>
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

    <script>
        $(document).ready(function() {
            $('#total_deposito').maskMoney({
                thousands: '.',
                decimal: ',',
                precision: 0
            });
        });

        $(document).ready(function() {
            $('#waktu_deposito').datepicker({
                startView: 2,
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true,
                todayBtn: 'linked',
            });

            $('#jatuh_tempo').datepicker({
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
            $('#dataTable').DataTable(); // ID From dataTable
            $('#dataTableHover').DataTable({
                ordering: false
            }); // ID From dataTable with Hover
        });

        $(document).ready(function() {
            $(document).on('click', '#editDeposito', function() {
                const id_deposito = $(this).data('id_deposito');
                const name = $(this).data('name');
                const nik = $(this).data('nik');
                const address = $(this).data('address');
                const email = $(this).data('email');
                const phone = $(this).data('phone');
                const total_deposito = $(this).data('total_deposito');
                const waktu_deposito = $(this).data('waktu_deposito');
                const jatuh_tempo = $(this).data('jatuh_tempo');
                $('#id_deposito').val(id_deposito);
                $('#name').val(name);
                $('#nik').val(nik);
                $('#address').val(address);
                $('#email').val(email);
                $('#phone').val(phone);
                $('#total_deposito').val(total_deposito);
                $('#waktu_deposito').val(waktu_deposito);
                $('#jatuh_tempo').val(jatuh_tempo);

                jQuery.ajax({
                    url: "<?php echo base_url('admin/deposito/component_dropdown/') ?>" + id_deposito,
                    success: function(data) {
                        $("#showComponent").html(data);
                    },
                });
            });

            $(document).on('click', '#detailDeposito', function() {
                const id_deposito = $(this).data('id_deposito');
                const name = $(this).data('name');
                const nik = $(this).data('nik');
                const address = $(this).data('address');
                const email = $(this).data('email');
                const phone = $(this).data('phone');
                const total_deposito = $(this).data('total_deposito');
                const resapan_deposito = $(this).data('resapan_deposito');
                const saldo_deposito = $(this).data('saldo_deposito');
                const jangka_waktu = $(this).data('jangka_waktu');
                const waktu_deposito = $(this).data('waktu_deposito');
                const jatuh_tempo = $(this).data('jatuh_tempo');
                const bagi_hasil = $(this).data('bagi_hasil');
                const cabang_name = $(this).data('cabang_name');
                const instansi_name = $(this).data('instansi_name');
                $('#showDaftar').val(id_deposito);
                $('.name').text(name);
                $('.nik').text(nik);
                $('.address').text(address);
                $('.email').text(email);
                $('.phone').text(phone);
                $('.total_deposito').text(total_deposito);
                $('.resapan_deposito').text(resapan_deposito);
                $('.saldo_deposito').text(saldo_deposito);
                $('.jangka_waktu').text(jangka_waktu);
                $('.waktu_deposito').text(waktu_deposito);
                $('.jatuh_tempo').text(jatuh_tempo);
                $('.bagi_hasil').text(bagi_hasil);
                $('.cabang_name').text(cabang_name);
                $('.instansi_name').text(instansi_name);

                jQuery.ajax({
                    url: "<?php echo base_url('admin/deposito/count_basil_berjalan_by_deposan/') ?>" + id_deposito,
                    success: function(data) {
                        $("#showBasil").html(data);
                    },
                });
            });

            $(document).on('click', '#showDaftar', function() {
                const id_deposito = $(this).val();

                jQuery.ajax({
                    url: "<?php echo base_url('admin/deposito/get_pengguna_dana_by_deposan/') ?>" + id_deposito,
                    beforeSend: function(data) {
                        $("#showPenggunaDana").html('<center><h1><i class="fa fa-spin fa-spinner" /></h1></center>');
                    },
                    success: function(data) {
                        $("#showPenggunaDana").html(data);
                    },
                });
            });
        });

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
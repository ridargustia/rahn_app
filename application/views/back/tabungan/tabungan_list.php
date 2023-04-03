<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

<!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
<!-- DataTables -->
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
                                <b>INFORMASI KESELURUHAN TABUNGAN</b>
                                <hr>
                                Total Tabungan : <b>Rp <?php echo number_format($get_total_tabungan, 0, ',', '.') ?></b><br>
                                <?php if (is_superadmin()) { ?>
                                    Serapan Tabungan : <b>Rp <?php echo number_format($get_tabungan->resapan_tabungan, 0, ',', '.') ?></b><br>
                                    Saldo Tabungan : <b>Rp <?php echo number_format($get_tabungan->saldo_tabungan, 0, ',', '.') ?></b><br>
                                <?php } else { ?>
                                    Serapan Tabungan : <b>Rp <?php echo number_format($get_serapan_tabungan[0]->resapan_tabungan, 0, ',', '.') ?></b><br>
                                    Saldo Tabungan : <b>Rp <?php echo number_format($get_saldo_tabungan[0]->saldo_tabungan, 0, ',', '.') ?></b><br>
                                <?php } ?>
                                Basil Tabungan Berjalan : <b>Rp <?php echo number_format($get_basil_berjalan, 0, ',', '.') ?></b>
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
                                                <th>Nama Peminjam</th>
                                                <th>Persentase</th>
                                                <th>Nominal</th>
                                                <th>Dibuat Oleh</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($get_all as $data) {
                                                // Action
                                                $detail = '<a href="#" id="detailTabungan" class="btn btn-sm btn-info" title="Detail Data" data-toggle="modal" data-target="#detailModal" data-id_sumber_dana="' . $data->id_sumber_dana . '" data-no_pinjaman="' . $data->no_pinjaman . '" data-name="' . $data->name . '" data-nik="' . $data->nik . '" data-address="' . $data->address . '" data-email="' . $data->email . '" data-phone="' . $data->phone . '" data-jml_pinjaman="' . number_format($data->jml_pinjaman, 0, ',', '.') . '" data-jangka_waktu_pinjam="' . $data->jangka_waktu_pinjam . '" data-persentase="' . $data->persentase . '" data-nominal="' . number_format($data->nominal, 0, ',', '.') . '" data-instansi_name="' . $data->instansi_name . '" data-cabang_name="' . $data->cabang_name . '" data-created_by="' . $data->created_by . '"><i class="fas fa-info-circle"></i></a>';
                                            ?>
                                                <tr>
                                                    <td><?php echo $data->no_pinjaman ?></td>
                                                    <td><?php echo $data->name ?></td>
                                                    <td><?php echo $data->persentase ?>%</td>
                                                    <td>Rp. <?php echo number_format($data->nominal, 0, ',', '.') ?></td>
                                                    <td><?php echo $data->created_by ?></td>
                                                    <td><?php echo $detail ?></td>
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

                    <!-- Modal detail -->
                    <?php $this->load->view('back/tabungan/modal_detail'); ?>
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

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(); // ID From dataTable
            $('#dataTableHover').DataTable({
                ordering: false
            }); // ID From dataTable with Hover
        });

        $(document).ready(function() {
            $(document).on('click', '#detailTabungan', function() {
                const id_sumber_dana = $(this).data('id_sumber_dana');
                const no_pinjaman = $(this).data('no_pinjaman');
                const name = $(this).data('name');
                const nik = $(this).data('nik');
                const address = $(this).data('address');
                const email = $(this).data('email');
                const phone = $(this).data('phone');
                const jml_pinjaman = $(this).data('jml_pinjaman');
                const jangka_waktu_pinjam = $(this).data('jangka_waktu_pinjam');
                const persentase = $(this).data('persentase');
                const nominal = $(this).data('nominal');
                const created_by = $(this).data('created_by');
                const instansi_name = $(this).data('instansi_name');
                const cabang_name = $(this).data('cabang_name');
                $('.no_pinjaman').text(no_pinjaman);
                $('.name').text(name);
                $('.nik').text(nik);
                $('.address').text(address);
                $('.email').text(email);
                $('.phone').text(phone);
                $('.jml_pinjaman').text(jml_pinjaman);
                $('.jangka_waktu_pinjam').text(jangka_waktu_pinjam);
                $('.persentase').text(persentase);
                $('.nominal').text(nominal);
                $('.created_by').text(created_by);
                $('.instansi_name').text(instansi_name);
                $('.cabang_name').text(cabang_name);
            });
        });
    </script>
</body>

</html>
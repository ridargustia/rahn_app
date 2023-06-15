<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

<!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
<!-- DataTables -->
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
                                Total Pembiayaan Saat Ini&nbsp;&emsp;:&emsp; <b>Rp <?php echo number_format($get_total_pinjaman[0]->total_pinjaman, 0, ',', '.') ?></b><br>
                                Total Biaya Sewa&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp; <b>Rp <?php echo number_format($get_biaya_sewa[0]->biaya_sewa, 0, ',', '.') ?></b>
                            </div>

                            <div class="alert alert-success d-flex flex-row align-items-center justify-content-between" role="alert">
                                <div>
                                    Biaya Sewa Berjalan&ensp;&emsp;&emsp;&emsp;:&emsp; <b>Rp <?php echo number_format($get_biaya_sewa_berjalan, 0, ',', '.') ?></b>
                                </div>
                                <a href="#" class="btn btn-sm btn-primary" onclick="location.reload()"><i class="fas fa-retweet"></i> Refresh</a>
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
            $('#dataTable').DataTable({
                searching: false,
                paging: false
            }); // ID From dataTable
            $('#dataTableHover').DataTable({
                ordering: false,
            }); // ID From dataTable with Hover
        });

    </script>
</body>

</html>
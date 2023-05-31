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
                        <div class="col-md-9">
                            <?php if ($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            } ?>
                            <!-- Content -->
                            <div class="card mb-4">
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th width="25%">No Anggota</th>
                                                <th>Nama</th>
                                                <?php if (is_grandadmin()) { ?>
                                                    <th>Cabang</th>
                                                    <th>Instansi</th>
                                                <?php } elseif (is_masteradmin()) { ?>
                                                    <th>Cabang</th>
                                                <?php } ?>
                                                <th style="width: 70px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($bayar_online as $data) {
                                                // Action
                                                $cek_pembayaran = '<a href="' . base_url('admin/pembayaran/detail_pembayaran_online/' . $data->id_users) . '" class="btn btn-sm btn-success" title="Cek Pembayaran"><i class="fas fa-check"></i></a>';
                                                $delete = '<a href="' . base_url('admin/pembayaran/delete_by_user/' . $data->id_users) . '" id="delete-button-permanent" class="btn btn-sm btn-danger" title="Hapus Permanen"><i class="fas fa-trash"></i></a>';
                                            ?>
                                                <tr>
                                                    <td class="text-primary"><?php echo $data->no_anggota ?></td>
                                                    <td><?php echo $data->name ?></td>
                                                    <?php if (is_grandadmin()) { ?>
                                                        <td><?php echo $data->cabang_name ?></td>
                                                        <td><?php echo $data->instansi_name ?></td>
                                                    <?php } elseif (is_masteradmin()) { ?>
                                                        <td><?php echo $data->cabang_name ?></td>
                                                    <?php } ?>
                                                    <td><?php echo $cek_pembayaran ?> <?php echo $delete ?></td>
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
            $('#dataTableHover').DataTable({
                ordering: false
            }); // ID From dataTable
        });

    </script>
</body>

</html>
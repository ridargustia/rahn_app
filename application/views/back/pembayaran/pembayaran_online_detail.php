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
                            <!-- Content -->
                            <div class="row">
                                <div class="col-xl-7 col-lg-7">
                                    <div class="card mb-4">
                                        <div class="table-responsive p-3">
                                            <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No Pinjaman</th>
                                                        <th>No Invoice</th>
                                                        <th>Status</th>
                                                        <th style="width: 70px">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach ($get_all as $data) {
                                                            // Action
                                                            $cek_foto = '<a href="#" id="checkImage" class="btn btn-sm btn-success" title="Cek Pembayaran" data-toggle="modal" data-target="#checkImageModal" data-bukti_tf="' . $data->bukti_tf . '" data-id_riwayat_pembayaran="' . $data->id_riwayat_pembayaran . '" data-id_pembiayaan="' . $data->id_pembiayaan . '" data-id_instansi="' . $data->instansi_id . '" data-id_cabang="' . $data->cabang_id . '" data-is_paid="' . $data->is_paid . '"><i class="fas fa-file-image"></i></a>';
                                                            $delete = '<a href="' . base_url('admin/pembayaran/delete_permanent/' . $data->id_riwayat_pembayaran) . '" id="delete-button-permanent" class="btn btn-sm btn-danger" title="Hapus Permanen"><i class="fas fa-trash"></i></a>';
                                                    ?>
                                                    <tr>
                                                        <td class="text-primary"><?php echo $data->no_pinjaman ?></td>
                                                        <td class="text-primary">#<?php echo $data->no_invoice ?></td>
                                                        <td>
                                                            <?php if ($data->is_paid == 0) { ?>
                                                                <span class="badge badge-danger">UNVERIFIED</span>
                                                            <?php } elseif ($data->is_paid == 1) { ?>
                                                                <span class="badge badge-success">VERIFIED</span>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php echo $cek_foto ?> <?php echo $delete ?></td>
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
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $anggota->no_anggota ?></b></td>
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
                    <?php $this->load->view('back/pembayaran/modal_show_bukti_tf'); ?>
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
    <!-- maskMoney -->
    <script src="<?php echo base_url('assets/') ?>maskMoney/jquery.maskMoney.min.js"></script>
    <!-- maskMoney -->

    <script>
        $(document).ready(function() {
            $('#dataTableHover').DataTable({
                ordering: false,
            }); // ID From dataTable

        });

        $(document).ready(function() {
            $(document).on('click', '#checkImage', function() {
                const bukti_tf = $(this).data('bukti_tf');
                const id_riwayat_pembayaran = $(this).data('id_riwayat_pembayaran');
                const id_pembiayaan = $(this).data('id_pembiayaan');
                const id_cabang = $(this).data('id_cabang');
                const id_instansi = $(this).data('id_instansi');
                const is_paid = $(this).data('is_paid');
                $('#id_riwayat_pembayaran').val(id_riwayat_pembayaran);
                $('#id_pembiayaan').val(id_pembiayaan);
                $('#id_cabang').val(id_cabang);
                $('#id_instansi').val(id_instansi);

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembayaran/get_bukti_tf/') ?>" + bukti_tf + "/" + is_paid,
                    success: function(data) {
                        $("#showBuktiTf").html(data);
                    },
                });
            });
        });

    </script>
</body>

</html>
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
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h4 class="m-0 font-weight-bold text-primary">Invoice</h4>
                                        </div>
                                        <div class="table-responsive p-3">
                                            <table class="table align-items-center table-flush" id="dataTable">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th width="20px">No Invoice</th>
                                                        <th>Nominal</th>
                                                        <th width="30px">Status</th>
                                                        <th width="30px">Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach ($get_all as $data) {
                                                        // Status
                                                        if ($data->is_paid == 0) {
                                                            $is_paid = '<span class="badge badge-danger">UNVERIFIED</span>';
                                                        } elseif ($data->is_paid == 1) {
                                                            $is_paid = '<span class="badge badge-success">VERIFIED</span>';
                                                        }

                                                        if ($data->nominal != 0) {
                                                            $nominal = 'Rp. ' . number_format($data->nominal, 0, ',', '.');
                                                        } else {
                                                            $nominal = 'Menunggu verifikasi...';
                                                        }

                                                        if ($data->verificated_by) {
                                                            $verificated_by = $data->verificated_by;
                                                        } else {
                                                            $verificated_by = 'Menunggu verifikasi...';
                                                        }

                                                        if ($data->verificated_at) {
                                                            $verificated_at = date_indonesian_only($data->verificated_at) . ' | ' . time_only2($data->verificated_at) . ' WIB';
                                                        } else {
                                                            $verificated_at = 'Menunggu verifikasi...';
                                                        }

                                                        //Action
                                                        $detail = '<a href="#" id="detailPembayaran" class="btn btn-sm btn-info" title="Detail" data-toggle="modal" data-target="#detailModal" data-no_invoice="' . $data->no_invoice . '" data-nominal="' . $nominal . '" data-verificated_by="' . $verificated_by . '" data-verificated_at="' . $verificated_at . '" data-created_by="' . $data->created_by . '" data-created_at="' . date_indonesian_only($data->created_at) . ' | ' . time_only2($data->created_at) . ' WIB" data-image="' . $data->bukti_tf . '"><i class="fas fa-info-circle"></i></a>';
                                                    ?>
                                                    <tr>
                                                        <td class="text-primary">#<?php echo $data->no_invoice ?></td>
                                                        <td><?php
                                                            if ($data->nominal != 0) {
                                                                echo 'Rp. ' . number_format($data->nominal, 0, ',', '.');
                                                            } else {
                                                                echo '<i>Menunggu verifikasi...</i>';
                                                            }
                                                        ?></td>
                                                        <td><?php echo $is_paid ?></td>
                                                        <td><?php echo $detail ?></td>
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
                                            <h4 class="m-0 font-weight-bold text-primary">Data Pinjaman</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">No Pinjaman</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px" class="text-primary"><b><?php echo $pembiayaan->no_pinjaman ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Status</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px">
                                                            <?php if ($pembiayaan->status_pembayaran == 0) { ?>
                                                                <span class="badge badge-danger">BELUM LUNAS</span>
                                                            <?php } elseif ($pembiayaan->status_pembayaran == 1) { ?>
                                                                <span class="badge badge-success">LUNAS</span>
                                                            <?php } ?>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Jumlah Pinjaman</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($pembiayaan->jml_pinjaman, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Biaya Sewa</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($pembiayaan->total_biaya_sewa, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Tanggungan</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($tanggungan, 0, ',', '.') ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Terbayar</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>Rp <?php echo number_format($pembiayaan->jml_terbayar, 0, ',', '.') ?></b></td>
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
                    <?php $this->load->view('back/pembayaran/modal_detail'); ?>
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
            $('#dataTable').DataTable({
                ordering: false
            }); // ID From dataTable
        });

        $(document).ready(function() {
            $(document).on('click', '#detailPembayaran', function() {
                const no_invoice = $(this).data('no_invoice');
                const nominal = $(this).data('nominal');
                const verificated_by = $(this).data('verificated_by');
                const verificated_at = $(this).data('verificated_at');
                const created_by = $(this).data('created_by');
                const created_at = $(this).data('created_at');
                const image = $(this).data('image');
                $('.no_invoice').text(no_invoice);
                $('.nominal').text(nominal);
                $('.verificated_by').text(verificated_by);
                $('.verificated_at').text(verificated_at);
                $('.created_by').text(created_by);
                $('.created_at').text(created_at);

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembayaran/get_image/') ?>" + image,
                    success: function(data) {
                        $("#showImage").html(data);
                    },
                });
            });
        });
    </script>
</body>

</html>
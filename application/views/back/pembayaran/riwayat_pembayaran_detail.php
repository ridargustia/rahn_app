<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

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
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <thead class="thead-light">
                                                    <tr>
                                                        <th>No Invoice</th>
                                                        <th>Tanggal</th>
                                                        <th>Nominal</th>
                                                        <th>Aksi</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        foreach ($riwayat_pembayaran as $data) {
                                                        //Action
                                                        $cetak = '<a href="' . base_url('admin/pembayaran/cetak_resi/' . $data->id_riwayat_pembayaran) . '" target="_blank" class="btn btn-sm btn-info" title="Cetak Invoice"><i class="fas fa-print"></i></a>';
                                                    ?>
                                                    <tr>
                                                        <td class="text-primary">#<?php echo $data->no_invoice ?></td>
                                                        <td><?php echo datetime_indo4($data->created_at) ?></td>
                                                        <td>Rp. <?php echo number_format($data->nominal, 0, ',', '.') ?></td>
                                                        <td><?php echo $cetak ?></td>
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
                                            <h4 class="m-0 font-weight-bold text-primary">Peminjam</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <tbody>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">No Anggota</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->no_pinjaman ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Nama</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->name ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">NIK</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->nik ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Email</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->email ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Alamat</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->address ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">No Telepon</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b>+<?php echo $pembiayaan->phone ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Username</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->username ?></b></td>
                                                    </tr>
                                                    <?php if (is_grandadmin()) { ?>
                                                        <tr>
                                                            <td style="width: 120px; padding-right: 5px">Cabang</td>
                                                            <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                            <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->cabang_name ?></b></td>
                                                        </tr>
                                                        <tr>
                                                            <td style="width: 120px; padding-right: 5px">Instansi</td>
                                                            <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                            <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->instansi_name ?></b></td>
                                                        </tr>
                                                    <?php } elseif (is_masteradmin()) { ?>
                                                        <tr>
                                                            <td style="width: 120px; padding-right: 5px">Cabang</td>
                                                            <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                            <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->cabang_name ?></b></td>
                                                        </tr>
                                                    <?php } ?>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Waktu Gadai</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo date_indonesian_only($pembiayaan->waktu_gadai) ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Jatuh Tempo</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo date_indonesian_only($pembiayaan->jatuh_tempo_gadai) ?></b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Jangka Waktu</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px"><b><?php echo $pembiayaan->jangka_waktu_gadai ?> Bulan</b></td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Sistem Pembayaran</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px">
                                                            <b>
                                                                <?php
                                                                    if ($pembiayaan->sistem_pembayaran_sewa == 1) {
                                                                        echo "Bulanan";
                                                                    } elseif ($pembiayaan->sistem_pembayaran_sewa == 2) {
                                                                        echo "Jatuh Tempo";
                                                                    }
                                                                ?>
                                                            </b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="width: 120px; padding-right: 5px">Sumber Dana</td>
                                                        <td style="padding-right: 7px; padding-left: 7px" class="text-center">:</td>
                                                        <td style="padding-right: 5px; padding-left: 5px">
                                                            <b>
                                                                <?php
                                                                    if ($pembiayaan->sumber_dana == 1) {
                                                                        echo "Tabungan";
                                                                    } elseif ($pembiayaan->sumber_dana == 2) {
                                                                        echo "Deposito";
                                                                    } elseif ($pembiayaan->sumber_dana == 3) {
                                                                        echo "Tabungan dan Deposito";
                                                                    }
                                                                ?>
                                                            </b>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="card-footer"></div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h4 class="m-0 font-weight-bold text-primary">Data Pinjaman</h4>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table align-items-center table-flush">
                                                <tbody>
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

</body>

</html>
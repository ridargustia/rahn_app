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

                    <?php if (is_admin()) { ?>
                        <div class="row mb-2">
                            <!-- Card Total Deposito -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Deposito</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_deposito->total_deposito, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-check fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Serapan Deposito -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Serapan Deposito</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_deposito->resapan_deposito, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-handshake fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Saldo Deposito -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Saldo Deposito</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_deposito->saldo_deposito, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-wallet fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Saldo Bagi Hasil -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Saldo Bagi Hasil</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_basil->basil_for_deposan, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-wallet fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (is_pegawai()) { ?>
                        <div class="row mb-2">
                            <!-- Card Total Pinjaman -->
                            <div class="col-xl-6 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Pinjaman</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_pembiayaan->jml_pinjaman, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-check fa-2x text-primary"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Tanggungan Yang Dibayar -->
                            <div class="col-xl-6 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Tanggungan Yang Dibayar</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_tanggungan, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-wallet fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Jumlah Terbayar -->
                            <div class="col-xl-6 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Terbayar</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_pembiayaan->jml_terbayar, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-wallet fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Kekurangan Bayar -->
                            <div class="col-xl-6 col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Kekurangan Bayar</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($kekurangan_bayar, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-wallet fa-2x text-danger"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if (!is_admin() and !is_pegawai()) { ?>
                        <div class="row mb-2">
                            <!-- Card Total Deposito -->
                            <div class="col-xl-4 col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Deposito</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_total_deposito[0]->total_deposito, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-check fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Serapan Deposito -->
                            <div class="col-xl-4 col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Serapan Deposito</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_serapan_deposito[0]->resapan_deposito, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-handshake fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Saldo Deposito -->
                            <div class="col-xl-4 col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Saldo Deposito</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_saldo_deposito[0]->saldo_deposito, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-wallet fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <!-- Card Total Tabungan -->
                            <div class="col-xl-4 col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Tabungan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_total_tabungan, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-check fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Serapan Tabungan -->
                            <div class="col-xl-4 col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Serapan Tabungan</div>
                                                <?php if (is_superadmin()) { ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_tabungan->resapan_tabungan, 0, ',', '.') ?></div>
                                                <?php } else { ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_serapan_tabungan[0]->resapan_tabungan, 0, ',', '.') ?></div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-handshake fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Saldo Tabungan -->
                            <div class="col-xl-4 col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Saldo Tabungan</div>
                                                <?php if (is_superadmin()) { ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_tabungan->saldo_tabungan, 0, ',', '.') ?></div>
                                                <?php } else { ?>
                                                    <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_saldo_tabungan[0]->saldo_tabungan, 0, ',', '.') ?></div>
                                                <?php } ?>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-wallet fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-2">
                            <!-- Card Total Pinjaman -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pinjaman</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_total_pinjaman[0]->total_pinjaman, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-check fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Total Biaya Sewa Pembiayaan -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Biaya Sewa</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($get_biaya_sewa[0]->biaya_sewa, 0, ',', '.') ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-money-check fa-2x text-info"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <!-- Card Total Deposan -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Deposan</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $get_total_deposan ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-success"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Card Total Anggota -->
                            <div class="col-xl-6 col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="row no-gutters align-items-center">
                                            <div class="col mr-2">
                                                <div class="text-xs font-weight-bold text-uppercase mb-1">Total Anggota</div>
                                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $get_total_anggota ?></div>
                                            </div>
                                            <div class="col-auto">
                                                <i class="fas fa-users fa-2x text-warning"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    <!--Row-->

                    <!-- Modal Logout -->
                    <?php $this->load->view('back/template/modal_logout'); ?>
                    <!-- Modal Logout -->
                </div>
                <!--Container Fluid-->
            </div>
            <!-- Footer Copyright -->
            <?php $this->load->view('back/template/footer_copyright'); ?>
            <!-- Footer Copyright -->
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
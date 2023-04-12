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
                                                            $detail = '<a href="#" id="detailPembiayaan" class="btn btn-sm btn-info" title="Detail Data" data-toggle="modal" data-target="#detailPembiayaanModal" data-id_pembiayaan="' . $data->id_pembiayaan . '" data-no_pinjaman="' . $data->no_pinjaman . '" data-name="' . $data->name . '" data-nik="' . $data->nik . '" data-address="' . $data->address . '" data-email="' . $data->email . '" data-phone="' . $data->phone . '" data-jml_pinjaman="' . number_format($data->jml_pinjaman, 0, ',', '.') . '" data-jangka_waktu_pinjam="' . $data->jangka_waktu_pinjam . '" data-jenis_barang_gadai="' . $data->jenis_barang_gadai . '" data-berat_barang_gadai="' . $data->berat_barang_gadai . '" data-waktu_gadai="' . date_indonesian_only($data->waktu_gadai) . '" data-jatuh_tempo_gadai="' . date_indonesian_only($data->jatuh_tempo_gadai) . '" data-jangka_waktu_gadai="' . $data->jangka_waktu_gadai . '" data-sewa_tempat_perbulan="' . number_format($data->sewa_tempat_perbulan, 0, ',', '.') . '" data-total_biaya_sewa="' . number_format($data->total_biaya_sewa, 0, ',', '.') . '" data-sistem_pembayaran_sewa="' . $sistem_pembayaran_sewa . '" data-sumber_dana="' . $sumber_dana . '" data-image="' . $data->image . '" data-instansi_name="' . $data->instansi_name . '" data-cabang_name="' . $data->cabang_name . '"><i class="fas fa-info-circle"></i></a>';
                                                            $edit = '<a href="#" id="editPembiayaan" class="btn btn-sm btn-warning" title="Edit Data" data-toggle="modal" data-target="#editPembiayaanModal" data-id_pembiayaan="' . $data->id_pembiayaan . '" data-name="' . $data->name . '" data-nik="' . $data->nik . '" data-address="' . $data->address . '" data-email="' . $data->email . '" data-phone="' . $data->phone . '" data-jml_pinjaman="' . $data->jml_pinjaman . '" data-jangka_waktu_pinjam="' . $data->jangka_waktu_pinjam . '" data-jenis_barang_gadai="' . $data->jenis_barang_gadai . '" data-berat_barang_gadai="' . $data->berat_barang_gadai . '" data-waktu_gadai="' . $data->waktu_gadai . '" data-jatuh_tempo_gadai="' . $data->jatuh_tempo_gadai . '" data-sistem_pembayaran_sewa="' . $data->sistem_pembayaran_sewa . '" data-sumber_dana="' . $data->sumber_dana . '" data-image="' . $data->image . '"><i class="fas fa-pen"></i></a>';
                                                            $delete = '<a href="' . base_url('admin/pembiayaan/delete/' . $data->id_pembiayaan) . '" id="delete-button" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fas fa-trash"></i></a>';
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
                                                        <td><?php echo $detail ?> <?php echo $edit ?> <?php echo $delete ?></td>
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
                                    <div class="card mb-4">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                            <h4 class="m-0 font-weight-bold text-primary">Data Pinjaman</h4>
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
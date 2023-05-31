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
                            <!-- Content -->
                            <?php
                                foreach ($pinjaman as $data) {
                                    if ($data->status_pembayaran) {
                                        $status = '<span class="badge badge-success">LUNAS</span>';
                                    } else {
                                        $status = '<span class="badge badge-danger">BELUM LUNAS</span>';
                                    }
                            ?>
                            <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">#<?php echo $data->no_pinjaman ?></h6><?php echo $status ?>
                                </div>
                                <div class="card-body">
                                    <div class="row mb-2">
                                        <!-- Card Total Deposito -->
                                        <div class="col-xl-4 col-md-12 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Pinjaman</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->jml_pinjaman, 0, ',', '.') ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Serapan Deposito -->
                                        <div class="col-xl-4 col-md-12 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Biaya Sewa</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->total_biaya_sewa, 0, ',', '.') ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Card Saldo Deposito -->
                                        <div class="col-xl-4 col-md-12 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="row no-gutters align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Total Tanggungan</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->jml_pinjaman+$data->total_biaya_sewa, 0, ',', '.') ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mb-2">
                                        <!-- Card Jumlah Terbayar -->
                                        <div class="col-xl-6 col-md-12 mb-4">
                                            <div class="card h-100">
                                                <div class="card-body">
                                                    <div class="row align-items-center">
                                                        <div class="col mr-2">
                                                            <div class="text-xs font-weight-bold text-uppercase mb-1">Jumlah Terbayar</div>
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->jml_terbayar, 0, ',', '.') ?></div>
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
                                                            <div class="h5 mb-0 font-weight-bold text-gray-800">RP <?php echo number_format($data->jml_pinjaman+$data->total_biaya_sewa-$data->jml_terbayar, 0, ',', '.') ?></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xl-12 col-md-12">
                                            <a href="#" class="btn btn-success btn-block" data-id_pembiayaan="<?php echo $data->id_pembiayaan ?>" data-id_cabang="<?php echo $data->cabang_id ?>" data-id_instansi="<?php echo $data->instansi_id ?>" data-no_pinjaman="<?php echo $data->no_pinjaman ?>" <?php echo ($data->status_pembayaran) ? 'style="cursor: not-allowed; opacity: .5;"' : 'id="cicilanPembayaran" data-toggle="modal" data-target="#buktiTfModal"' ?> >Bayar</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- Content -->
                        </div>
                    </div>
                    <!--Row-->

                    <!-- Modal Logout -->
                    <?php $this->load->view('back/template/modal_logout'); ?>
                    <!-- Modal Logout -->

                    <!-- Modal Cicilan Pembayaran -->
                    <?php $this->load->view('back/pembayaran/modal_bukti_tf'); ?>
                    <!-- Modal Cicilan Pembayaran -->
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
    <!-- maskMoney -->
    <script src="<?php echo base_url('assets/') ?>maskMoney/jquery.maskMoney.min.js"></script>
    <!-- maskMoney -->

    <script>
        $(document).ready(function() {
            $(document).on('click', '#cicilanPembayaran', function() {
                const id_pembiayaan = $(this).data('id_pembiayaan');
                const id_cabang = $(this).data('id_cabang');
                const id_instansi = $(this).data('id_instansi');
                const no_pinjaman = $(this).data('no_pinjaman');
                $('#id_pembiayaan').val(id_pembiayaan);
                $('#id_cabang').val(id_cabang);
                $('#id_instansi').val(id_instansi);
                $('#no_pinjaman').val(no_pinjaman);
            });

            $('#nominal').maskMoney({
                thousands: '.',
                decimal: ',',
                precision: 0
            });
        });

        function photoPreview(customFile,idpreview) {
            var gb = customFile.files;
            for (var i = 0; i < gb.length; i++) {
                var gbPreview = gb[i];
                var imageType = /image.*/;
                var preview=document.getElementById(idpreview);
                var reader = new FileReader();
                if (gbPreview.type.match(imageType)) {
                    //jika tipe data sesuai
                    preview.file = gbPreview;
                    reader.onload = (function(element) {
                        return function(e) {
                            element.src = e.target.result;
                        };
                    })(preview);
                    //membaca data URL gambar
                    reader.readAsDataURL(gbPreview);
                } else {
                    //jika tipe data tidak sesuai
                    alert("Tipe file tidak sesuai. Gambar harus bertipe .png, .gif atau .jpg.");
                }
            }
        }
    </script>
</body>

</html>
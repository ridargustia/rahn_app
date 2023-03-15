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
                            <?php echo form_open() ?>
                                <?php if (is_grandadmin()) { ?>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Instansi</label>
                                                        <?php echo form_dropdown('', $get_all_combobox_instansi, '', $instansi_id) ?>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Cabang</label>
                                                        <?php echo form_dropdown('', array('' => '- Pilih Instansi Dulu -'), '', $cabang_id) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Pilih Anggota</label>
                                                        <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $user_id) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="showPinjaman"></div>
                                    </div>
                                <?php } elseif (is_masteradmin()) { ?>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Cabang</label>
                                                        <?php echo form_dropdown('', $get_all_combobox_cabang, '', $cabang_id) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Pilih Anggota</label>
                                                        <?php echo form_dropdown('', array('' => '- Pilih Cabang Dulu -'), '', $user_id) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="showPinjaman"></div>
                                    </div>
                                <?php } elseif (is_superadmin()) { ?>
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label>Pilih Anggota</label>
                                                        <?php echo form_dropdown('', $get_all_combobox_anggota, '', $user_id) ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="showPinjaman"></div>
                                    </div>
                                <?php } ?>
                            <?php echo form_close() ?>
                            <!-- Content -->
                        </div>
                    </div>
                    <!--Row-->

                    <!-- Modal Logout -->
                    <?php $this->load->view('back/template/modal_logout'); ?>
                    <!-- Modal Logout -->

                    <!-- Modal Cicilan Pembayaran -->
                    <?php $this->load->view('back/pembayaran/modal_cicilan'); ?>
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
                $('#id_pembiayaan').val(id_pembiayaan);
            });

            $('#nominal').maskMoney({
                thousands: '.',
                decimal: ',',
                precision: 0
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

        function tampilUser() {
            cabang_id = document.getElementById("cabang_id").value;
            $.ajax({
                url: "<?php echo base_url(); ?>admin/auth/pilih_anggota/" + cabang_id + "",
                success: function(response) {
                    $("#user_id").html(response);
                },
                dataType: "html"
            });
            return false;
        }

        function tampilPinjaman() {
            user_id = document.getElementById("user_id").value;
            $.ajax({
                url: "<?php echo base_url(); ?>admin/pembiayaan/pilih_pinjaman/" + user_id + "",
                beforeSend: function() {
                    $("#showPinjaman").html('<center><h1><i class="fa fa-spin fa-spinner" /></h1></center>');
                },
                success: function(response) {
                    $("#showPinjaman").html(response);
                },
                dataType: "html"
            });
            return false;
        }
    </script>
</body>

</html>
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
                            <?php echo form_open($action) ?>
                            <?php if (is_grandadmin()) { ?>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="m-0 font-weight-bold text-primary">Pilih Lokasi Tabungan</h5>
                                        <hr>
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
                            <?php } elseif (is_masteradmin()) { ?>
                                <div class="card mb-4">
                                    <div class="card-body">
                                        <h5 class="m-0 font-weight-bold text-primary">Pilih Lokasi Tabungan</h5>
                                        <hr>
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
                            <?php } elseif (is_superadmin()) { ?>
                                <div class="alert alert-info" role="alert">
                                    <b>INFORMASI SALDO</b><hr>
                                    Saldo Tabungan di Cabang Saat Ini : <b>Rp <?php echo number_format($cabang->saldo_tabungan, 0, ',', '.') ?></b>
                                </div>

                                <div class="card mb-4">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Nominal yang ditambahkan</label>
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text">RP</span>
                                                </div>
                                                <?php echo form_input($nominal_tabungan) ?>
                                                <div class="input-group-append">
                                                    <span class="input-group-text">,00</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="card-footer">
                                        <button type="reset" class="btn btn-warning"><?php echo $btn_reset ?></button>
                                        <button type="submit" class="btn btn-primary"><?php echo $btn_submit ?></button>
                                    </div>
                                </div>
                            <?php } ?>

                            <div id="formComponent"></div>
                            <?php echo form_close() ?>
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

    <!-- maskMoney -->
    <script src="<?php echo base_url('assets/') ?>maskMoney/jquery.maskMoney.min.js"></script>
    <!-- maskMoney -->

    <script>
        $(document).ready(function() {
            $('#nominal_tabungan').maskMoney({
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

        function tampilForm() {
            cabang_id = document.getElementById("cabang_id").value;

            jQuery.ajax({
                url: "<?php echo base_url('admin/tabungan/form_component/') ?>" + cabang_id,
                beforeSend: function() {
                    $("#formComponent").html('<center><h1><i class="fa fa-spin fa-spinner" /></h1></center>');
                },
                success: function(data) {
                    $("#formComponent").html(data);
                },
            });
        }
    </script>
</body>

</html>
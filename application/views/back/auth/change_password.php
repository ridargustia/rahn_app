<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>
<!-- Select2 -->
<link href="<?php echo base_url('assets/select2/dist/css/select2.min.css') ?>" rel="stylesheet" type="text/css">
<!-- Select2 -->

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
                            <div class="card mb-4">
                                <?php echo form_open($action) ?>
                                <div class="card-body">
                                    <?php if (is_grandadmin() or is_masteradmin()) { ?>
                                        <div class="form-group">
                                            <label>Pilih User</label>
                                            <?php echo form_dropdown('', $get_all_users, '', $user_id) ?>
                                        </div>
                                    <?php } ?>
                                    <div class="form-group">
                                        <label>Password Baru</label>
                                        <?php echo form_password($new_password) ?>
                                    </div>
                                    <div class="form-group">
                                        <label>Konfirmasi Password Baru</label>
                                        <?php echo form_password($confirm_new_password) ?>
                                    </div>
                                </div>
                                <hr>
                                <div class="card-footer">
                                    <button type="reset" class="btn btn-warning"><?php echo $btn_reset ?></button>
                                    <button type="submit" class="btn btn-primary"><?php echo $btn_submit ?></button>
                                </div>
                                <?php echo form_close() ?>
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

    <!-- Select2 -->
    <script src="<?php echo base_url('assets/select2/dist/js/select2.min.js') ?>"></script>
    <!-- Select2 -->

    <script>
        $(document).ready(function() {
            // Select2 Single  with Placeholder
            $('.select2-single-placeholder').select2({
                placeholder: "- Silahkan Pilih User -",
                allowClear: true
            });
        });
    </script>
</body>

</html>
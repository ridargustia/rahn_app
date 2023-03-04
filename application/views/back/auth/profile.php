<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

<!-- Bootstrap DatePicker -->
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<!-- Bootstrap DatePicker -->
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
                            <!-- Content -->
                            <div class="card mb-4">
                                <div class="card-body">
                                    <div class="row mb-4">
                                        <div class="col-md-12" style="text-align: center">
                                            <?php if ($this->session->photo_thumb == NULL) { ?>
                                                <img class="img-profile rounded-circle" src="<?php echo base_url('assets/images/user/noimage.jpg') ?>" style="max-width: 150px">
                                            <?php } else { ?>
                                                <img class="img-profile rounded-circle" src="<?php echo base_url('assets/images/user/'.$this->session->photo_thumb) ?>" style="max-width: 150px">
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        <table class="table align-items-center table-flush">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="230px">Nama</td>
                                                                    <td width="2px">:</td>
                                                                    <td><b><?php echo $this->session->name ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Username</td>
                                                                    <td>:</td>
                                                                    <td><b><?php echo $this->session->username ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Email</td>
                                                                    <td>:</td>
                                                                    <td><b><?php echo $this->session->email ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Jenis Kelamin</td>
                                                                    <td>:</td>
                                                                    <td><b><?php echo ($user->gender == 1) ? 'Laki-laki' : 'Perempuan' ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Tempat/Tanggal Lahir </td>
                                                                    <td>:</td>
                                                                    <td><b>
                                                                        <?php
                                                                        if ($user->birthplace and $user->birthdate) {
                                                                            echo $user->birthplace . ', ' . date_indonesian_only($user->birthdate);
                                                                        } elseif (empty($user->birthplace) and $user->birthdate) {
                                                                            echo date_indonesian_only($user->birthdate);
                                                                        } elseif ($user->birthplace and empty($user->birthdate)) {
                                                                            echo $user->birthplace;
                                                                        }
                                                                        ?>
                                                                    </b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Alamat</td>
                                                                    <td>:</td>
                                                                    <td><b><?php echo $user->address ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>No. HP/Telephone</td>
                                                                    <td>:</td>
                                                                    <td><b><?php echo $user->phone ?></b></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Usertype</td>
                                                                    <td>:</td>
                                                                    <td><span class="badge badge-info"><?php echo $this->session->usertype_name ?></span></td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Status</td>
                                                                    <td>:</td>
                                                                    <td>
                                                                        <?php if ($user->is_active == 1) { ?>
                                                                            <span class="badge badge-success">Aktif</span>
                                                                        <?php } else { ?>
                                                                            <span class="badge badge-danger">Nonaktif</span>
                                                                        <?php } ?>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>Cabang</td>
                                                                    <td>:</td>
                                                                    <td><b><?php echo $this->session->cabang_name ?></b></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
    <!-- Bootstrap Datepicker -->
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Bootstrap Datepicker -->

    <script></script>
</body>

</html>
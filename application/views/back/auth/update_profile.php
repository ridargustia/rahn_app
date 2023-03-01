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
                            <?php if ($this->session->flashdata('message')) {
                                echo $this->session->flashdata('message');
                            } ?>
                            <?php echo validation_errors() ?>
                            <!-- Content -->
                            <?php echo form_open_multipart($action, array('id' => 'add_form')) ?>
                              <div class="card mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                  <h5 class="m-0 font-weight-bold text-primary">Data Personal</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Nama Lengkap <span style="color: red">*</span></label>
                                                <?php echo form_input($name, $user->name) ?>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>Jenis Kelamin <span style="color: red">*</span></label>
                                                <?php echo form_dropdown('', $gender_value, $user->gender, $gender) ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                      <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Tempat Lahir</label>
                                            <?php echo form_input($birthplace, $user->birthplace) ?>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>Tanggal Lahir</label>
                                          <div class="input-group date">
                                            <div class="input-group-prepend">
                                              <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                                            </div>
                                            <?php echo form_input($birthdate, $user->birthdate) ?>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-md-4">
                                        <div class="form-group">
                                          <label>No HP/Telephone/WhatsApp <span style="color: red">*</span></label>
                                          <?php echo form_input($phone, $user->phone) ?>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Lengkap</label>
                                        <?php echo form_input($address, $user->address) ?>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="form-group">
                                                <label>Foto Profil</label>
                                                <img src="<?php echo base_url('assets/images/user/' . $user->photo) ?>" id="preview" width="100%"/>
                                            </div>
                                            <div class="form-group">
                                              <div class="custom-file">
                                                  <input type="file" name="photo" onchange="photoPreview(this,'preview')" class="custom-file-input" id="photoProfil">
                                                  <label class="custom-file-label" for="photoProfil">Ubah Foto</label>
                                              </div>
                                              <small class="form-text text-muted">Maximum file size 2Mb</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                              </div>

                                <div class="card mb-4">
                                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h5 class="m-0 font-weight-bold text-primary">Data Authentikasi</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Username <span style="color: red">*</span></label>
                                                    <?php echo form_input($username, $user->username) ?>
                                                    <div class="valid-feedback">Username tersedia</div>
                                                    <div class="invalid-feedback">Username telah ada, silahkan ganti yang lain</div>
                                                    <img src="<?php echo base_url('assets/images/loading.gif') ?>" id="loaderIcon" style="display:none" />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Email <span style="color: red">*</span></label>
                                                    <?php echo form_input($email, $user->email) ?>
                                                    <div class="valid-feedback">Email tersedia</div>
                                                    <div class="invalid-feedback">Email telah ada, silahkan ganti yang lain</div>
                                                    <img src="<?php echo base_url('assets/images/loading.gif') ?>" id="loaderIconEmail" style="display:none" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>Data Access <span style="color: red">*</span></label>
                                                    <p>
                                                    <?php
                                                        if($get_all_data_access_old == NULL) {
                                                            echo '<span class="badge badge-danger">No Data</span>';
                                                        } else {
                                                            foreach($get_all_data_access_old as $data_access) {
                                                                $string = chunk_split($data_access->data_access_name, 9, "</span> ");
                                                                echo '<span class="badge badge-success">'.$string;
                                                            }
                                                        }
                                                    ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr>
                                    <?php echo form_input($id_users, $user->id_users) ?>
                                    <div class="card-footer">
                                        <button type="reset" class="btn btn-warning"><?php echo $btn_reset ?></button>
                                        <button type="submit" class="btn btn-primary"><?php echo $btn_submit ?></button>
                                    </div>
                                </div>
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
    <!-- Bootstrap Datepicker -->
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Bootstrap Datepicker -->

    <script>
        $(document).ready(function() {
            $('#birthdate').datepicker({
                startView: 2,
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true,
                todayBtn: 'linked',
            });
        });

        function photoPreview(photoProfil,idpreview) {
            var gb = photoProfil.files;
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

        function checkUsername() {
          $("#username").removeClass("is-valid");
          $("#username").removeClass("is-invalid");
          $("#loaderIcon").show();
          jQuery.ajax({
            url: "<?php echo base_url('admin/auth/check_username_for_update_profile') ?>",
            data: 'username=' + $("#username").val(),
            type: "POST",
            success: function(response) {
              $("#loaderIcon").hide();
              if (response) {
                $("#username").addClass("is-invalid");
              } else {
                $("#username").addClass("is-valid");
              }
            },
            error: function() {}
          });
        }

        function checkEmail() {
          $("#email").removeClass("is-valid");
          $("#email").removeClass("is-invalid");
          $("#loaderIconEmail").show();
          jQuery.ajax({
            url: "<?php echo base_url('admin/auth/check_email_for_update_profile') ?>",
            data: 'email=' + $("#email").val(),
            type: "POST",
            success: function(response) {
              $("#loaderIconEmail").hide();
              if (response) {
                $("#email").addClass("is-invalid");
              } else {
                $("#email").addClass("is-valid");
              }
            },
            error: function() {}
          });
        }

    </script>
</body>

</html>
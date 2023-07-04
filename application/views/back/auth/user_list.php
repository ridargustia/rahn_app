<!-- Meta -->
<?php $this->load->view('back/template/meta'); ?>

<!-- DataTables -->
<link href="<?php echo base_url('assets/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">
<!-- DataTables -->
<!-- Bootstrap DatePicker -->
<link href="<?php echo base_url('assets/bootstrap-datepicker/css/bootstrap-datepicker.min.css') ?>" rel="stylesheet">
<!-- Bootstrap DatePicker -->
<!-- Bootstrap Touchspin -->
<link href="<?php echo base_url('assets/bootstrap-touchspin/css/jquery.bootstrap-touchspin.css') ?>" rel="stylesheet">
<!-- Bootstrap Touchspin -->
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
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <a href="<?php echo $add_action ?>" class="btn btn-primary"><i class="fa fa-plus"></i> <?php echo $btn_add ?></a>
                                </div>
                                <div class="table-responsive p-3">
                                    <table class="table align-items-center table-flush table-hover" id="dataTableHover">
                                        <thead class="thead-light">
                                            <tr>
                                                <th>ID</th>
                                                <th>Nama</th>
                                                <th>Username</th>
                                                <th>Status</th>
                                                <th>Usertype</th>
                                                <th width="25px">Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($get_all as $data) {
                                                // status active
                                                if ($data->is_active == '1') {
                                                    $is_active = '<a href="' . base_url('admin/auth/deactivate/' . $data->id_users) . '" class="badge badge-success">ACTIVE</a>';
                                                } else {
                                                    $is_active = '<a href="' . base_url('admin/auth/activate/' . $data->id_users) . '" class="badge badge-danger">INACTIVE</a>';
                                                }

                                                // status gender
                                                if ($data->gender == '1') {
                                                    $gender = 'Laki-laki';
                                                } elseif ($data->gender == '2') {
                                                    $gender = 'Perempuan';
                                                }

                                                //handle ketersediaan tanggal lahir
                                                if ($data->birthdate != NULL) {
                                                    $birthdate = date_indonesian_only($data->birthdate);
                                                } else {
                                                    $birthdate = '';
                                                }

                                                // Action
                                                $edit = '<a href="#" id="editUser" class="btn btn-sm btn-warning" title="Edit Data" data-toggle="modal" data-target="#modalEditUser" data-id_users="' . $data->id_users . '" data-name="' . $data->name . '" data-birthplace="' . $data->birthplace . '" data-birthdate="' . $data->birthdate . '" data-gender="' . $data->gender . '" data-address="' . $data->address . '" data-phone="' . $data->phone . '" data-email="' . $data->email . '" data-username="' . $data->username . '" data-usertype_id="' . $data->usertype_id . '" data-image="' . $data->photo . '"><i class="fas fa-pen"></i></a>';
                                                $delete = '<a href="' . base_url('admin/auth/delete/' . $data->id_users) . '" id="delete-button" class="btn btn-sm btn-danger" title="Hapus Data"><i class="fas fa-trash"></i></a>';
                                                $detail = '<a href="#" id="detailUser" class="btn btn-sm btn-info" title="Detail Data" data-toggle="modal" data-target="#modalDetailUser" data-no_anggota="' . $data->no_anggota . '" data-name="' . $data->name . '" data-birthplace="' . $data->birthplace . '" data-birthdate="' . $birthdate . '" data-gender="' . $gender . '" data-address="' . $data->address . '" data-phone="' . $data->phone . '" data-email="' . $data->email . '" data-username="' . $data->username . '" data-usertype="' . $data->usertype_name . '" data-created_by="' . $data->created_by . '" data-image="' . $data->photo . '" data-instansi_name="' . $data->instansi_name . '" data-cabang_name="' . $data->cabang_name . '"><i class="fas fa-info-circle"></i></a>';
                                            ?>
                                                <tr>
                                                    <td class="text-primary"><?php echo $data->no_anggota ?></td>
                                                    <td><?php echo $data->name ?></td>
                                                    <td><?php echo $data->username ?></td>
                                                    <td><?php echo $is_active ?></td>
                                                    <td><?php echo $data->usertype_name ?></td>
                                                    <td><?php echo $detail ?> <?php echo $edit ?> <?php echo $delete ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- Content -->
                        </div>
                    </div>
                    <!--Row-->

                    <!-- Modal Logout -->
                    <?php $this->load->view('back/template/modal_logout'); ?>
                    <!-- Modal Logout -->

                    <!-- Modal Edit -->
                    <?php $this->load->view('back/auth/modal_edit'); ?>
                    <!-- Modal Edit -->

                    <!-- Modal detail -->
                    <?php $this->load->view('back/auth/modal_detail'); ?>
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
    <!-- Bootstrap Datepicker -->
    <script src="<?php echo base_url('assets/bootstrap-datepicker/js/bootstrap-datepicker.min.js') ?>"></script>
    <!-- Bootstrap Datepicker -->
    <!-- maskMoney -->
    <script src="<?php echo base_url('assets/') ?>maskMoney/jquery.maskMoney.min.js"></script>
    <!-- maskMoney -->
    <!-- Bootstrap Touchspin -->
    <script src="<?php echo base_url('assets/') ?>bootstrap-touchspin/js/jquery.bootstrap-touchspin.js"></script>
    <!-- Bootstrap Touchspin -->

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable(); // ID From dataTable
            $('#dataTableHover').DataTable({
                ordering: false
            }); // ID From dataTable with Hover

            $('#birthdate').datepicker({
                startView: 2,
                format: 'yyyy/mm/dd',
                autoclose: true,
                todayHighlight: true,
                todayBtn: 'linked',
            });

            $(document).on('click', '#detailUser', function() {
                const no_anggota = $(this).data('no_anggota');
                const name = $(this).data('name');
                const birthplace = $(this).data('birthplace');
                const birthdate = $(this).data('birthdate');
                const gender = $(this).data('gender');
                const address = $(this).data('address');
                const phone = $(this).data('phone');
                const email = $(this).data('email');
                const username = $(this).data('username');
                const usertype = $(this).data('usertype');
                const created_by = $(this).data('created_by');
                const image = $(this).data('image');
                const cabang_name = $(this).data('cabang_name');
                const instansi_name = $(this).data('instansi_name');
                $('.no_anggota').text(no_anggota);
                $('.name').text(name);
                $('.birthplace').text(birthplace);
                $('.birthdate').text(birthdate);
                $('.gender').text(gender);
                $('.address').text(address);
                $('.phone').text(phone);
                $('.email').text(email);
                $('.username').text(username);
                $('.usertype').text(usertype);
                $('.created_by').text(created_by);
                $('.cabang_name').text(cabang_name);
                $('.instansi_name').text(instansi_name);

                jQuery.ajax({
                    url: "<?php echo base_url('admin/auth/get_image/') ?>" + image,
                    success: function(data) {
                        $("#showImage").html(data);
                    },
                });
            });

            $(document).on('click', '#editUser', function() {
                const id_users = $(this).data('id_users');
                const name = $(this).data('name');
                const birthplace = $(this).data('birthplace');
                const birthdate = $(this).data('birthdate');
                const gender = $(this).data('gender');
                const address = $(this).data('address');
                const phone = $(this).data('phone');
                const email = $(this).data('email');
                const username = $(this).data('username');
                const usertype_id = $(this).data('usertype_id');
                const image = $(this).data('image');
                $('#id_users').val(id_users);
                $('#name').val(name);
                $('#birthplace').val(birthplace);
                $('#birthdate').val(birthdate);
                $('#gender').val(gender);
                $('#address').val(address);
                $('#phone').val(phone);
                $('#email').val(email);
                $('#username').val(username);
                $('#usertype_id').val(usertype_id);

                jQuery.ajax({
                    url: "<?php echo base_url('admin/auth/current_image_for_edit_user/') ?>" + image,
                    success: function(data) {
                        $("#currentImage").html(data);
                    },
                });

                jQuery.ajax({
                    url: "<?php echo base_url('admin/auth/current_access_data/') ?>" + id_users,
                    success: function(data) {
                        $("#currentAccessData").html(data);
                    },
                });

                jQuery.ajax({
                    url: "<?php echo base_url('admin/auth/component_dropdown/') ?>" + id_users,
                    success: function(data) {
                        $("#showComponent").html(data);
                    },
                });
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
                    $("#currentImage").hide();
                } else {
                    //jika tipe data tidak sesuai
                    alert("Tipe file tidak sesuai. Gambar harus bertipe .png, .gif atau .jpg.");
                }
            }
        }
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '#showImage', function() {
                const image = $(this).val();

                jQuery.ajax({
                    url: "<?php echo base_url('admin/pembiayaan/get_image/') ?>" + image,
                    beforeSend: function(data) {
                        $("#showBarangGadai").html('<center><h1><i class="fa fa-spin fa-spinner" /></h1></center>');
                    },
                    success: function(data) {
                        $("#showBarangGadai").html(data);
                    },
                });
            });
        });


    </script>
</body>

</html>
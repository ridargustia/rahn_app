<nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top">
    <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">
        <?php if (!is_admin() and !is_pegawai()) { ?>
        <li class="nav-item dropdown no-arrow mx-1">
            <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
            aria-haspopup="true" aria-expanded="false">
                <i class="fas fa-bell fa-fw"></i>
                <?php echo ($notifikasi_counter > 0) ? '<span class="badge badge-danger badge-counter">' . $notifikasi_counter . '</span>' : '' ?>
            </a>
            <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
            aria-labelledby="alertsDropdown">
                <h6 class="dropdown-header">
                    Notifikasi
                </h6>
                <?php if ($notifikasi_counter > 0) { ?>
                    <?php foreach ($notifikasi as $data) { ?>
                        <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('admin/pembayaran/detail_pembayaran_online/' . $data->user_id); ?>">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                    <i class="fas fa-donate text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500"><?php echo date_indonesian_only($data->created_at) . ', ' . time_only2($data->created_at) ?></div>
                                <span class="font-weight-bold"><?php echo $data->name ?></span> telah melakukan pembayaran via transfer.
                            </div>
                        </a>
                    <?php } ?>
                <?php } else { ?>
                    <div class="row text-center p-4">
                        <div class="col-md-12 mb-2">
                            <img src="<?php echo base_url() ?>assets/images/empty_data.svg" style="max-height: 70px; opacity:.5;">
                        </div>
                        <div class="col-md-12">
                            <div class="text-gray-500">Empty Notification</div>
                        </div>
                    </div>
                <?php } ?>
                <?php echo ($notifikasi_counter > 0) ? '<a class="dropdown-item text-center small text-gray-500" href="' . base_url("admin/pembayaran/pembayaran_online") . '">Show All Notification</a>' : '' ?>
            </div>
        </li>
        <?php } elseif (is_pegawai()) { ?>
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <?php echo ($notifikasi_counter_for_anggota > 0) ? '<span class="badge badge-danger badge-counter">' . $notifikasi_counter_for_anggota . '</span>' : '' ?>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Notifikasi
                    </h6>
                    <?php if ($notifikasi_for_anggota) { ?>
                        <?php foreach ($notifikasi_for_anggota as $data) { ?>
                            <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('admin/pembayaran/detail_riwayat/' . $data->pembiayaan_id . '/' . $data->id_riwayat_pembayaran); ?>">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-check text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500"><?php echo date_indonesian_only($data->created_at) . ', ' . time_only2($data->created_at) ?></div>
                                    <?php if($data->bukti_tf != NULL) { ?>
                                        <span class="<?php echo ($data->is_read_anggota == 0) ? 'font-weight-bold' : '' ?>">Pembayaran INVOICE #<?php echo $data->no_invoice ?> telah berhasil diverifikasi.</span>
                                    <?php } elseif ($data->bukti_tf == NULL) { ?>
                                        <span class="<?php echo ($data->is_read_anggota == 0) ? 'font-weight-bold' : '' ?>">Pembayaran INVOICE #<?php echo $data->no_invoice ?> telah berhasil.</span>
                                    <?php } ?>
                                </div>
                            </a>
                        <?php } ?>
                    <?php } else { ?>
                        <div class="row text-center p-4">
                            <div class="col-md-12 mb-2">
                                <img src="<?php echo base_url() ?>assets/images/empty_data.svg" style="max-height: 70px; opacity:.5;">
                            </div>
                            <div class="col-md-12">
                                <div class="text-gray-500">Empty Notification</div>
                            </div>
                        </div>
                    <?php } ?>
                    <a class="dropdown-item text-center small text-gray-500" href="<?php echo base_url("admin/pembayaran/riwayat_pembayaran_anggota") ?>">Show All Notification</a>
                </div>
            </li>
        <?php } elseif (is_admin()) { ?>
            <li class="nav-item dropdown no-arrow mx-1">
                <a class="nav-link dropdown-toggle" href="#" id="alertsDropdown" role="button" data-toggle="dropdown"
                aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-bell fa-fw"></i>
                    <?php echo (check_masa_aktif_deposito()) ? '<span class="badge badge-danger badge-counter">1</span>' : '' ?>
                </a>
                <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in"
                aria-labelledby="alertsDropdown">
                    <h6 class="dropdown-header">
                        Notifikasi
                    </h6>
                    <?php if (check_masa_aktif_deposito()) { ?>
                        <a class="dropdown-item d-flex align-items-center" href="#">
                            <?php if (check_masa_aktif_deposito()->is_active == 0) { ?>
                                <div class="mr-3">
                                    <div class="icon-circle bg-danger">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500"><?php echo date_indonesian_only(date('Y-m-d', strtotime('-1 month', strtotime(check_masa_aktif_deposito()->jatuh_tempo)))) ?></div>
                                    <span class="font-weight-bold">Masa Aktif Deposito anda telah habis pada tanggal <?php echo date_indonesian_only(check_masa_aktif_deposito()->jatuh_tempo) ?></span>, silahkan lakukan perpanjangan.
                                </div>
                            <?php } else { ?>
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500"><?php echo date_indonesian_only(date('Y-m-d', strtotime('-1 month', strtotime(check_masa_aktif_deposito()->jatuh_tempo)))) ?></div>
                                    <span class="font-weight-bold">Masa Aktif Deposito anda akan habis pada tanggal <?php echo date_indonesian_only(check_masa_aktif_deposito()->jatuh_tempo) ?></span>, silahkan lakukan perpanjangan.
                                </div>
                            <?php } ?>
                        </a>
                    <?php } else { ?>
                        <div class="row text-center p-4">
                            <div class="col-md-12 mb-2">
                                <img src="<?php echo base_url() ?>assets/images/empty_data.svg" style="max-height: 70px; opacity:.5;">
                            </div>
                            <div class="col-md-12">
                                <div class="text-gray-500">Empty Notification</div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </li>
        <?php } ?>
        <div class="topbar-divider d-none d-sm-block"></div>
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?php if ($this->session->photo_thumb == NULL) { ?>
                    <img class="img-profile rounded-circle" src="<?php echo base_url('assets/images/user/noimage.jpg') ?>" style="max-width: 60px">
                <?php } else { ?>
                    <img class="img-profile rounded-circle" src="<?php echo base_url('assets/images/user/'.$this->session->photo_thumb) ?>" style="max-width: 60px">
                <?php } ?>
                <span class="ml-2 d-none d-lg-inline text-white small"><?php echo $this->session->name ?></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                <a class="dropdown-item" href="<?php echo base_url('admin/auth/profile') ?>">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <!-- <a class="dropdown-item" href="#">
                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                    Settings
                </a> -->
                <a class="dropdown-item" href="<?php echo base_url('admin/auth/change_password') ?>">
                    <i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>
                    Ubah Password
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
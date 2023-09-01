<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?php echo base_url('admin/dashboard') ?>">
        <div class="sidebar-brand-icon">
            <img src="<?php echo base_url('assets/images/instansi/' . $instansi->instansi_img) ?>" class="rounded-circle">
        </div>
        <div class="sidebar-brand-text mx-3">Rahn App</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="<?php if(current_url() == base_url('admin/dashboard')){echo "nav-item active";} else {echo "nav-item";} ?>">
        <a class="nav-link" href="<?php echo base_url('admin/dashboard') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <?php if (!is_admin()) { ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Menu Transaksi
        </div>
    <?php } ?>
    <?php
    $this->db->join('menu_access', 'menu.id_menu = menu_access.menu_id');
    $this->db->where('menu_access.usertype_id', $this->session->usertype_id);
    $this->db->where('menu.is_active', '1');
    $this->db->group_by('menu.id_menu');
    $this->db->order_by('menu.order_no');
    $menu = $this->db->get('menu')->result();
    ?>

    <?php
    foreach ($menu as $m) {
        //TODO Jika menu tidak memiliki submenu
        if ($m->submenu_id === NULL) {
            if (current_url() == base_url('admin/') . $m->menu_controller . '/' . $m->menu_function) {
                $active = 'class="nav-item active"';
            } else {
                $active = 'class="nav-item"';
            }
    ?>
            <li <?php echo $active ?>>
                <a class="nav-link" href="<?php echo base_url('admin/' . $m->menu_controller . '/' . $m->menu_function) ?>">
                    <i class="<?php echo $m->menu_icon ?>"></i>
                    <span><?php echo $m->menu_name ?></span>
                </a>
            </li>
        <?php } else {
            // $this->db->join('menu', 'submenu.menu_id = menu.id_menu', 'LEFT');
            $this->db->join('menu_access', 'submenu.id_submenu = menu_access.submenu_id');
            $this->db->where('submenu.menu_id', $m->id_menu);
            $this->db->where('menu_access.usertype_id', $this->session->usertype_id);
            $this->db->order_by('submenu.order_no');
            $submenu = $this->db->get('submenu')->result();

            if ($this->uri->segment(2) == $m->menu_controller) {
                $actives = 'class="nav-item active"';
                $active_collapse = 'class="collapse show"';
                $icon_collapsed = 'class="nav-link"';
            } else {
                $actives = 'class="nav-item"';
                $active_collapse = 'class="collapse"';
                $icon_collapsed = 'class="nav-link collapsed"';
            }
        ?>

            <li <?php echo $actives ?>>
                <a <?php echo $icon_collapsed ?> href="#" data-toggle="collapse" data-target="#<?php echo $m->data_target ?>" aria-expanded="true" aria-controls="collapseBootstrap">
                    <i class="<?php echo $m->menu_icon ?>"></i>
                    <span><?php echo $m->menu_name ?></span>
                </a>
                <div id="<?php echo $m->data_target ?>" <?php echo $active_collapse ?> aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                    <div class="bg-white py-2 collapse-inner rounded">
                        <h6 class="collapse-header"><?php echo $m->menu_name ?></h6>
                        <?php foreach ($submenu as $sm) { ?>
                            <?php if (current_url() == base_url('admin/') . $m->menu_controller . '/' . $sm->submenu_function) {
                                $active = 'class="collapse-item active"';
                            } else {
                                $active = 'class="collapse-item"';
                            } ?>
                            <a <?php echo $active ?> href="<?php echo base_url('admin/') . $m->menu_controller . '/' . $sm->submenu_function ?>"><?php echo $sm->submenu_name ?></a>
                        <?php } ?>
                    </div>
                </div>
            </li>
    <?php
        }
    }
    ?>

    <?php if (is_grandadmin()) { ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Struktur
        </div>
        <li class="<?php if($this->uri->segment(2) == 'instansi'){echo "nav-item active";} else {echo "nav-item";} ?>">
            <a class="nav-link <?php if($this->uri->segment(2) == 'instansi'){echo "";} else {echo "collapsed";} ?>" href="#" data-toggle="collapse" data-target="#collapseInstansi" aria-expanded="true"
                aria-controls="collapsePage">
                <i class="fas fa-fw fa-network-wired"></i>
                <span>Instansi</span>
            </a>
            <div id="collapseInstansi" class="collapse <?php if($this->uri->segment(2) == 'instansi'){echo "show";} ?>" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Instansi</h6>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/instansi/create')) {echo "active";} ?>" href="<?php echo base_url('admin/instansi/create') ?>">Tambah Instansi</a>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/instansi/index')) {echo "active";} ?>" href="<?php echo base_url('admin/instansi/index') ?>">Data Instansi</a>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/instansi/deleted_list')) {echo "active";} ?>" href="<?php echo base_url('admin/instansi/deleted_list') ?>">Recycle Bin</a>
                </div>
            </div>
        </li>
        <li class="<?php if($this->uri->segment(2) == 'cabang'){echo "nav-item active";} else {echo "nav-item";} ?>">
            <a class="nav-link <?php if($this->uri->segment(2) == 'cabang'){echo "";} else {echo "collapsed";} ?>" href="#" data-toggle="collapse" data-target="#collapseCabang" aria-expanded="true"
                aria-controls="collapsePage">
                <i class="fas fa-fw fa-network-wired"></i>
                <span>Cabang</span>
            </a>
            <div id="collapseCabang" class="collapse <?php if($this->uri->segment(2) == 'cabang'){echo "show";} ?>" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Cabang</h6>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/cabang/create')) {echo "active";} ?>" href="<?php echo base_url('admin/cabang/create') ?>">Tambah Cabang</a>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/cabang/index')) {echo "active";} ?>" href="<?php echo base_url('admin/cabang/index') ?>">Data Cabang</a>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/cabang/deleted_list')) {echo "active";} ?>" href="<?php echo base_url('admin/cabang/deleted_list') ?>">Recycle Bin</a>
                </div>
            </div>
        </li>
    <?php } elseif (is_masteradmin()) { ?>
        <hr class="sidebar-divider">
        <div class="sidebar-heading">
            Struktur
        </div>
        <li class="<?php if($this->uri->segment(2) == 'cabang'){echo "nav-item active";} else {echo "nav-item";} ?>">
            <a class="nav-link <?php if($this->uri->segment(2) == 'cabang'){echo "";} else {echo "collapsed";} ?>" href="#" data-toggle="collapse" data-target="#collapseCabang" aria-expanded="true"
                aria-controls="collapsePage">
                <i class="fas fa-fw fa-network-wired"></i>
                <span>Cabang</span>
            </a>
            <div id="collapseCabang" class="collapse <?php if($this->uri->segment(2) == 'cabang'){echo "show";} ?>" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Cabang</h6>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/cabang/create')) {echo "active";} ?>" href="<?php echo base_url('admin/cabang/create') ?>">Tambah Cabang</a>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/cabang/index')) {echo "active";} ?>" href="<?php echo base_url('admin/cabang/index') ?>">Data Cabang</a>
                    <a class="collapse-item <?php if (current_url() == base_url('admin/cabang/deleted_list')) {echo "active";} ?>" href="<?php echo base_url('admin/cabang/deleted_list') ?>">Recycle Bin</a>
                </div>
            </div>
        </li>
    <?php } ?>

    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Settings
    </div>
    <?php if (is_grandadmin() or is_masteradmin()) { ?>
    <li class="<?php if(current_url() == base_url('admin/auth/create') or current_url() == base_url('admin/auth/index') or current_url() == base_url('admin/auth/deleted_list')){echo "nav-item active";} else {echo "nav-item";} ?>">
        <a class="nav-link <?php if(current_url() == base_url('admin/auth/create') or current_url() == base_url('admin/auth/index') or current_url() == base_url('admin/auth/deleted_list')){echo "";} else {echo "collapsed";} ?>" href="#" data-toggle="collapse" data-target="#collapseUser" aria-expanded="true"
            aria-controls="collapsePage">
            <i class="fas fa-fw fa-users"></i>
            <span>User Management</span>
        </a>
        <div id="collapseUser" class="collapse <?php if(current_url() == base_url('admin/auth/create') or current_url() == base_url('admin/auth/index') or current_url() == base_url('admin/auth/deleted_list')){echo "show";} ?>" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">User Management</h6>
                <a class="collapse-item <?php if (current_url() == base_url('admin/auth/create')) {echo "active";} ?>" href="<?php echo base_url('admin/auth/create') ?>">Add User</a>
                <a class="collapse-item <?php if (current_url() == base_url('admin/auth/index')) {echo "active";} ?>" href="<?php echo base_url('admin/auth/index') ?>">User List</a>
                <a class="collapse-item <?php if (current_url() == base_url('admin/auth/deleted_list')) {echo "active";} ?>" href="<?php echo base_url('admin/auth/deleted_list') ?>">Recycle Bin</a>
            </div>
        </div>
    </li>
    <li class="<?php if($this->uri->segment(3) == 'setting_transaksi'){echo "nav-item active";} else {echo "nav-item";} ?>">
        <a class="nav-link" href="<?php echo base_url('admin/instansi/setting_transaksi/'.$this->session->instansi_id) ?>">
            <i class="fas fa-fw fa-sliders-h"></i>
            <span>Transaction Guide</span>
        </a>
    </li>
    <?php } ?>
    <?php if (is_grandadmin()) { ?>
    <li class="nav-item">
        <a class="nav-link" href="charts.html">
            <i class="fas fa-fw fa-database"></i>
            <span>Backup DB</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsertype" aria-expanded="true"
            aria-controls="collapsePage">
            <i class="fas fa-fw fa-gavel"></i>
            <span>Usertype Management</span>
        </a>
        <div id="collapseUsertype" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Usertype Management</h6>
                <a class="collapse-item" href="login.html">Add Usertype</a>
                <a class="collapse-item" href="register.html">Usertype List</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenu" aria-expanded="true"
            aria-controls="collapsePage">
            <i class="fas fa-fw fa-bars"></i>
            <span>Menu Management</span>
        </a>
        <div id="collapseMenu" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Menu Management</h6>
                <a class="collapse-item" href="login.html">Add Menu</a>
                <a class="collapse-item" href="register.html">Menu List</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSubmenu" aria-expanded="true"
            aria-controls="collapsePage">
            <i class="fas fa-fw fa-bars"></i>
            <span>SubMenu Management</span>
        </a>
        <div id="collapseSubmenu" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">SubMenu Management</h6>
                <a class="collapse-item" href="login.html">Add SubMenu</a>
                <a class="collapse-item" href="register.html">SubMenu List</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseMenuAccess" aria-expanded="true"
            aria-controls="collapsePage">
            <i class="fas fa-fw fa-users"></i>
            <span>Access Management</span>
        </a>
        <div id="collapseMenuAccess" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Access Management</h6>
                <a class="collapse-item" href="login.html">Add Menu Access</a>
                <a class="collapse-item" href="register.html">Menu Access List</a>
            </div>
        </div>
    </li>
    <?php } ?>
    <li class="<?php if($this->uri->segment(3) == 'update_profile'){echo "nav-item active";} else {echo "nav-item";} ?>">
        <a class="nav-link" href="<?php echo base_url('admin/auth/update_profile/'.$this->session->id_users) ?>">
            <i class="fas fa-fw fa-user"></i>
            <span>Edit Profile</span>
        </a>
    </li>
    <li class="<?php if($this->uri->segment(3) == 'change_password'){echo "nav-item active";} else {echo "nav-item";} ?>">
        <a class="nav-link" href="<?php echo base_url('admin/auth/change_password') ?>">
            <i class="fas fa-fw fa-lock"></i>
            <span>Ubah Password</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>
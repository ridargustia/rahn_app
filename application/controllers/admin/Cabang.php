<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cabang extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Cabang';

    $this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);
    $this->data['notifikasi'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->result();
    $this->data['notifikasi_counter'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->num_rows();

    $this->data['btn_submit'] = 'Save';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/cabang/create');

    is_login();

    if (is_superadmin() and is_admin() and is_pegawai()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak memiliki akses</div>');
      redirect('admin/dashboard');
    }
  }

  function index()
  {
    is_read();

    $this->data['page_title'] = 'Data ' . $this->data['module'];
    $this->data['action']     = 'admin/cabang/update_action';

    if (is_grandadmin()) {
      $this->data['get_all'] = $this->Cabang_model->get_all();
    } elseif (is_masteradmin()) {
      $this->data['get_all'] = $this->Cabang_model->get_all_by_instansi();
    }

    $this->data['get_all_combobox_instansi']  = $this->Instansi_model->get_all_combobox();

    $this->data['id_cabang'] = [
      'name'          => 'id_cabang',
      'id'            => 'id_cabang',
      'type'          => 'hidden',
    ];
    $this->data['cabang_name'] = [
      'name'          => 'cabang_name',
      'id'            => 'cabang_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('cabang_name'),
    ];
    $this->data['instansi_id'] = [
      'name'          => 'instansi_id',
      'id'            => 'instansi_id',
      'class'         => 'form-control',
      'required'      => '',
    ];

    $this->load->view('back/cabang/cabang_list', $this->data);
  }

  function create()
  {
    is_create();

    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/cabang/create_action';

    $this->data['get_all_combobox_instansi']  = $this->Instansi_model->get_all_combobox();

    $this->data['cabang_name'] = [
      'name'          => 'cabang_name',
      'id'            => 'cabang_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('cabang_name'),
    ];
    $this->data['instansi_id'] = [
      'name'          => 'instansi_id',
      'id'            => 'instansi_id',
      'class'         => 'form-control',
      'required'      => '',
    ];

    $this->load->view('back/cabang/cabang_add', $this->data);
  }

  function create_action()
  {
    $this->form_validation->set_rules('cabang_name', 'Nama Cabang', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if (is_grandadmin()) {
      $instansi_id = $this->input->post('instansi_id');
      $this->data['check_by_name_and_instansi']  = $this->Cabang_model->check_by_name_and_instansi($this->input->post('cabang_name'), $instansi_id);
    } elseif (is_masteradmin()) {
      $instansi_id = $this->session->userdata('instansi_id');
      $this->data['check_by_name_and_instansi']  = $this->Cabang_model->check_by_name_and_instansi($this->input->post('cabang_name'), $instansi_id);
    }

    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } elseif ($this->input->post('cabang_name') === $this->data['check_by_name_and_instansi']->cabang_name) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Nama ' . $this->data['module'] . ' telah ada, silahkan ganti yang lain</b></h6></div>');

      $this->create();
    } else {
      $data = array(
        'cabang_name'     => $this->input->post('cabang_name'),
        'instansi_id'     => $instansi_id,
        'created_by'      => $this->session->username,
      );

      $this->Cabang_model->insert($data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
      redirect('admin/cabang');
    }
  }

  function update($id)
  {
    is_update();

    $this->data['cabang']     = $this->Cabang_model->get_by_id($id);

    if (is_masteradmin() && $this->data['cabang']->instansi_id != $this->session->instansi_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/cabang');
    }

    if ($this->data['cabang']) {
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/cabang/update_action';

      $this->data['get_all_combobox_instansi']  = $this->Instansi_model->get_all_combobox();

      $this->data['id_cabang'] = [
        'name'          => 'id_cabang',
        'type'          => 'hidden',
      ];
      $this->data['cabang_name'] = [
        'name'          => 'cabang_name',
        'id'            => 'cabang_name',
        'class'         => 'form-control',
        // 'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['instansi_id'] = [
        'name'          => 'instansi_id',
        'id'            => 'instansi_id',
        'class'         => 'form-control',
        'required'      => '',
      ];

      $this->load->view('back/cabang/cabang_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/cabang');
    }
  }

  function update_action()
  {
    $this->form_validation->set_rules('cabang_name', 'Nama Cabang', 'trim|required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if (is_grandadmin()) {
      $instansi_id = $this->input->post('instansi_id');
    } elseif (is_masteradmin()) {
      $instansi_id = $this->session->userdata('instansi_id');
    }

    if ($this->form_validation->run() === FALSE) {
      $this->index();
    } else {
      $data = array(
        'cabang_name'     => $this->input->post('cabang_name'),
        'instansi_id'     => $instansi_id,
        'modified_by'     => $this->session->username,
      );

      $this->Cabang_model->update($this->input->post('id_cabang'), $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
      redirect('admin/cabang');
    }
  }

  function delete($id)
  {
    is_delete();

    $delete = $this->Cabang_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete_cabang'   => '1',
        'deleted_by'        => $this->session->username,
        'deleted_at'        => date('Y-m-d H:i:a'),
      );

      $this->Cabang_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus!</b></h6></div>');
      redirect('admin/cabang');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
      redirect('admin/cabang');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    $delete = $this->Cabang_model->get_by_id($id);

    if ($delete) {
      $this->Cabang_model->delete($id);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus Secara Permanen!</b></h6></div>');
      redirect('admin/cabang/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
      redirect('admin/cabang');
    }
  }

  function deleted_list()
  {
    is_restore();

    $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

    if (is_grandadmin()) {
      $this->data['get_all_deleted'] = $this->Cabang_model->get_all_deleted();
    } elseif (is_masteradmin()) {
      $this->data['get_all_deleted'] = $this->Cabang_model->get_all_deleted_by_instansi();
    }

    $this->load->view('back/cabang/cabang_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_restore();

    $row = $this->Cabang_model->get_by_id($id);

    if ($row) {
      $data = array(
        'is_delete_cabang'   => '0',
        'deleted_by'        => NULL,
        'deleted_at'        => NULL,
      );

      $this->Cabang_model->update($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dikembalikan!</b></h6></div>');
      redirect('admin/cabang/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
      redirect('admin/cabang');
    }
  }

  function pilih_cabang()
  {
    $this->data['cabang'] = $this->Cabang_model->get_cabang_by_instansi_combobox($this->uri->segment(4));
    $this->load->view('back/cabang/v_cabang', $this->data);
  }
}
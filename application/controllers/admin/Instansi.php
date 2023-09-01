<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Instansi extends CI_Controller
{

  public function __construct()
  {
    parent::__construct();

    $this->data['module'] = 'Instansi';

    $this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);
    $this->data['notifikasi'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->result();
    $this->data['notifikasi_counter'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->num_rows();

    $this->data['btn_submit'] = 'Simpan';
    $this->data['btn_reset']  = 'Reset';
    $this->data['btn_add']    = 'Tambah Data';
    $this->data['add_action'] = base_url('admin/instansi/create');

    is_login();
  }

  function index()
  {
    is_read();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak memiliki akses</div>');
      redirect('admin/dashboard');
    }

    $this->data['page_title'] = 'Data ' . $this->data['module'];

    $this->data['get_all'] = $this->Instansi_model->get_all();

    $this->data['action']     = 'admin/instansi/update_action';

    $this->data['id_instansi'] = [
      'name'          => 'id_instansi',
      'id'            => 'id_instansi',
      'type'          => 'hidden',
    ];
    $this->data['instansi_name'] = [
      'name'          => 'instansi_name',
      'id'            => 'instansi_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_name'),
    ];
    $this->data['instansi_address'] = [
      'name'          => 'instansi_address',
      'id'            => 'instansi_address',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_address'),
    ];
    $this->data['instansi_phone'] = [
      'name'          => 'instansi_phone',
      'id'            => 'instansi_phone',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'placeholder'   => '8xxxxxxxxxx',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_phone'),
      'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
    ];
    $this->data['active_date'] = [
      'name'          => 'active_date',
      'id'            => 'active_date',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('active_date'),
    ];

    $this->load->view('back/instansi/instansi_list', $this->data);
  }

  function create()
  {
    is_create();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak memiliki akses</div>');
      redirect('admin/dashboard');
    }

    $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
    $this->data['action']     = 'admin/instansi/create_action';

    $this->data['instansi_name'] = [
      'name'          => 'instansi_name',
      'id'            => 'instansi_name',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_name'),
    ];
    $this->data['instansi_address'] = [
      'name'          => 'instansi_address',
      'id'            => 'instansi_address',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_address'),
    ];
    $this->data['instansi_phone'] = [
      'name'          => 'instansi_phone',
      'id'            => 'instansi_phone',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'placeholder'   => '8xxxxxxxxxx',
      'required'      => '',
      'value'         => $this->form_validation->set_value('instansi_phone'),
      'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
    ];
    $this->data['active_date'] = [
      'name'          => 'active_date',
      'id'            => 'active_date',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
      'value'         => $this->form_validation->set_value('active_date'),
    ];

    $this->load->view('back/instansi/instansi_add', $this->data);
  }

  function create_action()
  {
    $this->form_validation->set_rules('instansi_name', 'Nama Instansi', 'trim|required');
    $this->form_validation->set_rules('instansi_phone', 'No. HP / Telpon', 'required|is_numeric');
    $this->form_validation->set_rules('instansi_address', 'Alamat', 'trim|required');
    $this->form_validation->set_rules('active_date', 'Aktif Sampai', 'required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('is_numeric', '{field} harus angka');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if ($this->form_validation->run() === FALSE) {
      $this->create();
    } else {
      // Format no telephone
      $phone = '62' . $this->input->post('instansi_phone');

      $active_date = new DateTime($this->input->post('active_date'));
      $today = new DateTime(date('Y-m-d'));
      if ($active_date > $today) {
        $is_active = 1;
      } else {
        $is_active = 0;
      }

      if ($_FILES['photo']['error'] <> 4) {
        $nmfile = strtolower(url_title($this->input->post('instansi_name'))) . date('YmdHis');

        $config['upload_path']      = './assets/images/instansi/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

          $this->create();
        } else {
          $photo = $this->upload->data();

          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/instansi/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          $this->load->library('image_lib', $config);
          $this->image_lib->resize();

          $data = array(
            'instansi_name'       => $this->input->post('instansi_name'),
            'instansi_address'    => $this->input->post('instansi_address'),
            'instansi_phone'      => $phone,
            'active_date'         => $this->input->post('active_date'),
            'instansi_img'        => $this->upload->data('file_name'),
            'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
            'is_active'           => $is_active,
            'created_by'          => $this->session->username,
          );

          $this->Instansi_model->insert($data);

          write_log();

          $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
          redirect('admin/instansi');
        }
      } else {
        $data = array(
          'instansi_name'       => $this->input->post('instansi_name'),
          'instansi_address'    => $this->input->post('instansi_address'),
          'instansi_phone'      => $phone,
          'active_date'         => $this->input->post('active_date'),
          'is_active'           => $is_active,
          'created_by'          => $this->session->username,
        );

        $this->Instansi_model->insert($data);

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
        redirect('admin/instansi');
      }
    }
  }

  function update($id)
  {
    is_update();

    $this->data['instansi']     = $this->Instansi_model->get_by_id($id);

    if (is_superadmin() or is_masteradmin() && $this->data['instansi']->id_instansi != $this->session->instansi_id) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/dashboard');
    }

    if ($this->data['instansi']) {
      $this->data['page_title'] = 'Update Data ' . $this->data['module'];
      $this->data['action']     = 'admin/instansi/update_action';

      $this->data['id_instansi'] = [
        'name'          => 'id_instansi',
        'type'          => 'hidden',
      ];

      if (is_grandadmin()) {
        $this->data['instansi_name'] = [
          'name'          => 'instansi_name',
          'id'            => 'instansi_name',
          'class'         => 'form-control',
          'autocomplete'  => 'off',
          'required'      => '',
        ];
      }
      $this->data['instansi_phone'] = [
        'name'          => 'instansi_phone',
        'id'            => 'instansi_phone',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['instansi_address'] = [
        'name'          => 'instansi_address',
        'id'            => 'instansi_address',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];
      $this->data['active_date'] = [
        'name'          => 'active_date',
        'id'            => 'active_date',
        'class'         => 'form-control',
        'autocomplete'  => 'off',
        'required'      => '',
      ];

      $this->load->view('back/instansi/instansi_edit', $this->data);
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Data tidak ditemukan</div>');
      redirect('admin/instansi');
    }
  }

  function update_action()
  {
    if (is_grandadmin()) {
      $this->form_validation->set_rules('instansi_name', 'Nama Instansi', 'trim|required');
    }
    $this->form_validation->set_rules('instansi_address', 'Alamat', 'trim|required');
    $this->form_validation->set_rules('instansi_phone', 'No. HP / Telpon', 'is_numeric|required');
    $this->form_validation->set_rules('active_date', 'Status Aktif', 'required');

    $this->form_validation->set_message('required', '{field} wajib diisi');
    $this->form_validation->set_message('is_numeric', '{field} harus angka');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    if ($this->form_validation->run() === FALSE) {
      $this->index();
    } else {
      $active_date = new DateTime($this->input->post('active_date'));
      $today = new DateTime(date('Y-m-d'));
      if ($active_date >= $today) {
        $is_active = 1;
      } else {
        $is_active = 0;
      }

      if ($_FILES['photo']['error'] <> 4) {
        $nmfile = strtolower(url_title($this->input->post('instansi_name'))) . date('YmdHis');

        $config['upload_path']      = './assets/images/instansi/';
        $config['allowed_types']    = 'jpg|jpeg|png';
        $config['max_size']         = 2048; // 2Mb
        $config['file_name']        = $nmfile;

        $this->load->library('upload', $config);

        $delete = $this->Instansi_model->get_by_id($this->input->post('id_instansi'));

        $dir        = "./assets/images/instansi/" . $delete->instansi_img;
        $dir_thumb  = "./assets/images/instansi/" . $delete->instansi_img_thumb;

        if (is_file($dir)) {
          unlink($dir);
          unlink($dir_thumb);
        }

        if (!$this->upload->do_upload('photo')) {
          $error = array('error' => $this->upload->display_errors());
          $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

          $this->update($this->input->post('id_instansi'));
        } else {
          $photo = $this->upload->data();

          $config['image_library']    = 'gd2';
          $config['source_image']     = './assets/images/instansi/' . $photo['file_name'] . '';
          $config['create_thumb']     = TRUE;
          $config['maintain_ratio']   = TRUE;
          $config['width']            = 250;
          $config['height']           = 250;

          $this->load->library('image_lib', $config);
          $this->image_lib->resize();

          if (is_grandadmin()) {
            $data = array(
              'instansi_name'       => $this->input->post('instansi_name'),
              'instansi_address'    => $this->input->post('instansi_address'),
              'instansi_phone'      => $this->input->post('instansi_phone'),
              'active_date'         => $this->input->post('active_date'),
              'is_active'           => $is_active,
              'instansi_img'        => $this->upload->data('file_name'),
              'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
              'modified_by'         => $this->session->username,
            );
          } elseif (is_masteradmin()) {
            $data = array(
              'instansi_address'    => $this->input->post('instansi_address'),
              'instansi_phone'      => $this->input->post('instansi_phone'),
              'active_date'         => $this->input->post('active_date'),
              'is_active'           => $is_active,
              'instansi_img'        => $this->upload->data('file_name'),
              'instansi_img_thumb'  => $nmfile . '_thumb' . $this->upload->data('file_ext'),
              'modified_by'         => $this->session->username,
            );
          }

          $this->Instansi_model->update($this->input->post('id_instansi'), $data);

          write_log();

          $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');

          if (is_grandadmin()) {
            redirect('admin/instansi');
          } elseif (is_masteradmin()) {
            redirect('admin/instansi/update/' . $this->session->instansi_id);
          }
        }
      } else {
        if (is_grandadmin()) {
          $data = array(
            'instansi_name'       => $this->input->post('instansi_name'),
            'instansi_address'    => $this->input->post('instansi_address'),
            'instansi_phone'      => $this->input->post('instansi_phone'),
            'active_date'         => $this->input->post('active_date'),
            'is_active'           => $is_active,
            'modified_by'         => $this->session->username,
          );
        } elseif (is_masteradmin()) {
          $data = array(
            'instansi_address'    => $this->input->post('instansi_address'),
            'instansi_phone'      => $this->input->post('instansi_phone'),
            'active_date'         => $this->input->post('active_date'),
            'is_active'           => $is_active,
            'modified_by'         => $this->session->username,
          );
        }

        $this->Instansi_model->update($this->input->post('id_instansi'), $data);

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');

        if (is_grandadmin()) {
          redirect('admin/instansi');
        } elseif (is_masteradmin()) {
          redirect('admin/instansi/update/' . $this->session->instansi_id);
        }
      }
    }
  }

  function delete($id)
  {
    is_delete();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak memiliki akses</div>');
      redirect('admin/dashboard');
    }

    $delete = $this->Instansi_model->get_by_id($id);

    if ($delete) {
      $data = array(
        'is_delete_instansi'    => '1',
        'deleted_by'            => $this->session->username,
        'deleted_at'            => date('Y-m-d H:i:a'),
        'is_active'             => '0',
      );

      $this->Instansi_model->soft_delete($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus!</b></h6></div>');
      redirect('admin/instansi');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
      redirect('admin/instansi');
    }
  }

  function delete_permanent($id)
  {
    is_delete();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak memiliki akses</div>');
      redirect('admin/dashboard');
    }

    $delete = $this->Instansi_model->get_by_id($id);

    if ($delete) {
      $dir        = "./assets/images/instansi/" . $delete->instansi_img;
      $dir_thumb  = "./assets/images/instansi/" . $delete->instansi_img_thumb;

      if (is_file($dir)) {
        unlink($dir);
        unlink($dir_thumb);
      }

      $this->Instansi_model->delete($id);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus Secara Permanen!</b></h6></div>');
      redirect('admin/instansi/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
      redirect('admin/instansi');
    }
  }

  function deleted_list()
  {
    is_restore();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak memiliki akses</div>');
      redirect('admin/dashboard');
    }

    $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

    $this->data['get_all_deleted'] = $this->Instansi_model->get_all_deleted();

    $this->load->view('back/instansi/instansi_deleted_list', $this->data);
  }

  function restore($id)
  {
    is_restore();

    if (!is_grandadmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak memiliki akses</div>');
      redirect('admin/dashboard');
    }

    $row = $this->Instansi_model->get_by_id($id);

    if ($row) {
      $active_date = new DateTime($row->active_date);
      $today = new DateTime(date('Y-m-d'));
      if ($active_date >= $today) {
        $is_active = 1;
      } else {
        $is_active = 0;
      }

      $data = array(
        'is_delete_instansi'    => '0',
        'deleted_by'            => NULL,
        'deleted_at'            => NULL,
        'is_active'             => $is_active,
      );

      $this->Instansi_model->update($id, $data);

      write_log();

      $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dikembalikan!</b></h6></div>');
      redirect('admin/instansi/deleted_list');
    } else {
      $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
      redirect('admin/instansi');
    }
  }

  function current_image($instansi_img)
  {
    $this->data['current_image'] = $instansi_img;

    $this->load->view('back/instansi/v_current_image', $this->data);
  }

  function setting_transaksi()
  {
    if (!is_grandadmin() && !is_masteradmin()) {
      $this->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak berhak mengubah data orang lain</div>');
      redirect('admin/dashboard');
    }

    $this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);

    $this->data['page_title'] = 'Edit Transaction Guide';
    $this->data['action'] = 'admin/instansi/setting_transaksi_action';

    $this->data['biaya_satuan_sewa_tempat'] = [
      'name'          => 'biaya_satuan_sewa_tempat',
      'id'            => 'biaya_satuan_sewa_tempat',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
    ];
    $this->data['acuan_konversi_gram'] = [
      'name'          => 'acuan_konversi_gram',
      'id'            => 'acuan_konversi_gram',
      'class'         => 'form-control',
      'autocomplete'  => 'off',
      'required'      => '',
    ];

    $this->load->view('back/instansi/transaksi_edit', $this->data);
  }

  function setting_transaksi_action()
  {
    $this->form_validation->set_rules('biaya_satuan_sewa_tempat', 'Biaya Satuan Sewa Tempat', 'required');
    $this->form_validation->set_rules('acuan_konversi_gram', 'Acuan Konversi Gram', 'required');

    $this->form_validation->set_message('required', '{field} wajib diisi');

    $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

    $biaya_satuan_sewa_tempat = preg_replace("/[^0-9]/", "", $this->input->post('biaya_satuan_sewa_tempat'));
    $acuan_konversi_gram = preg_replace("/[^0-9]/", "", $this->input->post('acuan_konversi_gram'));

    $data = array(
      'biaya_satuan_sewa_tempat'  => $biaya_satuan_sewa_tempat,
      'acuan_konversi_gram'       => $acuan_konversi_gram,
    );

    $this->Instansi_model->update($this->session->instansi_id, $data);

    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Disimpan!</b></h6></div>');
    redirect('admin/instansi/setting_transaksi');
  }
}

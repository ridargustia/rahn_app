<?php
defined('BASEPATH') or exit('No direct script access allowed');

require('vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class Deposito extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Deposito';

        $this->load->library('Pdf');

        $this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);
        $this->data['notifikasi'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->result();
        $this->data['notifikasi_counter'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->num_rows();

        $this->data['btn_submit'] = 'Save';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['btn_export']    = 'Export to Excel';
        $this->data['add_action'] = base_url('admin/deposito/create');
        $this->data['export_action'] = base_url('admin/deposito/export');

        is_login();

        if ($this->uri->segment(2) != NULL) {
            menuaccess_check();
        } elseif ($this->uri->segment(3) != NULL) {
            submenuaccess_check();
        }
    }

    function index()
    {
        is_read();

        $this->data['page_title'] = 'Data ' . $this->data['module'];

        if (is_grandadmin()) {
            $this->data['get_all'] = $this->Deposito_model->get_all();
            $this->data['get_total_deposito'] = $this->Deposito_model->total_deposito();
            $this->data['get_serapan_deposito'] = $this->Deposito_model->serapan_deposito();
            $this->data['get_saldo_deposito'] = $this->Deposito_model->saldo_deposito();
        } elseif (is_masteradmin()) {
            $this->data['get_all'] = $this->Deposito_model->get_all_by_instansi();
            $this->data['get_total_deposito'] = $this->Deposito_model->total_deposito_by_instansi();
            $this->data['get_serapan_deposito'] = $this->Deposito_model->serapan_deposito_by_instansi();
            $this->data['get_saldo_deposito'] = $this->Deposito_model->saldo_deposito_by_instansi();
        } elseif (is_superadmin()) {
            $this->data['get_all'] = $this->Deposito_model->get_all_by_cabang();
            $this->data['get_total_deposito'] = $this->Deposito_model->total_deposito_by_cabang();
            $this->data['get_serapan_deposito'] = $this->Deposito_model->serapan_deposito_by_cabang();
            $this->data['get_saldo_deposito'] = $this->Deposito_model->saldo_deposito_by_cabang();
        }

        $this->data['action']                   = 'admin/deposito/update_action';
        $this->data['action_jangka_waktu']      = 'admin/deposito/renew_jangka_waktu_action';
        $this->data['action_tarik_basil']       = 'admin/deposito/tarik_basil';

        $this->data['id_deposito'] = [
            'name'          => 'id_deposito',
            'id'            => 'id_deposito',
            'type'          => 'hidden',
        ];
        $this->data['name'] = [
            'name'          => 'name',
            'id'            => 'name',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('name'),
        ];
        $this->data['nik'] = [
            'name'          => 'nik',
            'id'            => 'nik',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nik'),
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['address'] = [
            'name'          => 'address',
            'id'            => 'address',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('address'),
        ];
        $this->data['email'] = [
            'name'          => 'email',
            'id'            => 'email',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('email'),
        ];
        $this->data['phone'] = [
            'name'          => 'phone',
            'id'            => 'phone',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'placeholder'   => '8xxxxxxxxxx',
            'value'         => $this->form_validation->set_value('phone'),
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['total_deposito'] = [
            'name'          => 'total_deposito',
            'id'            => 'total_deposito',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('total_deposito'),
        ];
        $this->data['waktu_deposito'] = [
            'name'          => 'waktu_deposito',
            'id'            => 'waktu_deposito',
            'class'         => 'input-sm form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('waktu_deposito'),
        ];
        $this->data['jatuh_tempo'] = [
            'name'          => 'jatuh_tempo',
            'id'            => 'jatuh_tempo',
            'class'         => 'input-sm form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('jatuh_tempo'),
        ];

        // Perpanjang Masa Aktif
        $this->data['masa_aktif'] = [
            'name'          => 'masa_aktif',
            'id'            => 'masa_aktif',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nik'),
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['perpanjang_waktu_deposito'] = [
            'name'          => 'perpanjang_waktu_deposito',
            'id'            => 'perpanjang_waktu_deposito',
            'class'         => 'input-sm form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('waktu_deposito'),
            'readonly'      => '',
        ];
        $this->data['perpanjang_jatuh_tempo'] = [
            'name'          => 'perpanjang_jatuh_tempo',
            'id'            => 'perpanjang_jatuh_tempo',
            'class'         => 'input-sm form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('jatuh_tempo'),
            'readonly'      => '',
        ];
        $this->data['data_waktu_deposito'] = [
            'name'          => 'data_waktu_deposito',
            'id'            => 'data_waktu_deposito',
            'type'          => 'hidden',
        ];
        $this->data['data_jatuh_tempo'] = [
            'name'          => 'data_jatuh_tempo',
            'id'            => 'data_jatuh_tempo',
            'type'          => 'hidden',
        ];
        // Perpanjang Masa Aktif

        $this->data['deposito_id'] = [
            'name'          => 'deposito_id',
            'id'            => 'deposito_id',
            'type'          => 'hidden',
        ];

        // Tarik Basil Modal
        $this->data['nominal'] = [
            'name'          => 'nominal',
            'id'            => 'nominal',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nominal'),
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        // Tarik Basil Modal

        $this->load->view('back/deposito/deposito_list', $this->data);
    }

    function create()
    {
        is_create();

        $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
        $this->data['action']     = 'admin/deposito/create_action';

        if (is_grandadmin()) {
            $this->data['get_all_combobox_instansi']     = $this->Instansi_model->get_all_combobox();
        } elseif (is_masteradmin()) {
            $this->data['get_all_combobox_cabang']       = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
        }

        $this->data['instansi_id'] = [
            'name'          => 'instansi_id',
            'id'            => 'instansi_id',
            'class'         => 'form-control',
            'required'      => '',
            'onChange'      => 'tampilCabang()',
            'value'         => $this->form_validation->set_value('instansi_id'),
        ];
        $this->data['cabang_id'] = [
            'name'          => 'cabang_id',
            'id'            => 'cabang_id',
            'class'         => 'form-control',
            'required'      => '',
            'value'         => $this->form_validation->set_value('cabang_id'),
        ];
        $this->data['name'] = [
            'name'          => 'name',
            'id'            => 'name',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('name'),
        ];
        $this->data['nik'] = [
            'name'          => 'nik',
            'id'            => 'nik',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nik'),
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['address'] = [
            'name'          => 'address',
            'id'            => 'address',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('address'),
        ];
        $this->data['email'] = [
            'name'          => 'email',
            'id'            => 'email',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('email'),
        ];
        $this->data['phone'] = [
            'name'          => 'phone',
            'id'            => 'phone',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'placeholder'   => '8xxxxxxxxxx',
            'value'         => $this->form_validation->set_value('phone'),
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['total_deposito'] = [
            'name'          => 'total_deposito',
            'id'            => 'total_deposito',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('total_deposito'),
        ];
        $this->data['waktu_deposito'] = [
            'name'          => 'waktu_deposito',
            'id'            => 'waktu_deposito',
            'class'         => 'input-sm form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('waktu_deposito'),
        ];
        $this->data['jatuh_tempo'] = [
            'name'          => 'jatuh_tempo',
            'id'            => 'jatuh_tempo',
            'class'         => 'input-sm form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('jatuh_tempo'),
        ];

        $this->load->view('back/deposito/deposito_add', $this->data);
    }

    function create_action()
    {
        if (is_grandadmin()) {
            $this->form_validation->set_rules('instansi_id', 'Instansi', 'required');
            $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');
        } elseif (is_masteradmin()) {
            $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');
        }
        $this->form_validation->set_rules('name', 'Nama Deposan', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'is_numeric|required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|required');
        $this->form_validation->set_rules('phone', 'No. HP/Telephone', 'is_numeric|required');
        $this->form_validation->set_rules('total_deposito', 'Jumlah Deposito', 'required');
        $this->form_validation->set_rules('waktu_deposito', 'Waktu Deposito', 'required');
        $this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('is_numeric', '{field} harus angka');
        $this->form_validation->set_message('valid_email', '{field} format email tidak benar');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            //Generate kode/no anggota
            $kode_huruf = 'DPS';
            $get_last_id = (int) $this->db->query('SELECT max(id_users) as last_id FROM users')->row()->last_id;
            $get_last_id++;
            $random = mt_rand(10, 99);
            $no_anggota = $kode_huruf . $random . sprintf("%04s", $get_last_id);

            //Ubah tipe data total deposito
            $string = $this->input->post('total_deposito');
            $total_deposito = preg_replace("/[^0-9]/", "", $string);

            //Format no telephone
            $phone = '62' . $this->input->post('phone');

            //Menentukan jangka waktu
            $waktu_deposito = date("Y", strtotime($this->input->post('waktu_deposito')));
            $jatuh_tempo = date("Y", strtotime($this->input->post('jatuh_tempo')));
            $jangka_waktu_deposito = $jatuh_tempo - $waktu_deposito;

            if (is_grandadmin()) {
                $instansi = $this->input->post('instansi_id');
                $cabang = $this->input->post('cabang_id');
            } elseif (is_masteradmin()) {
                $instansi = $this->session->instansi_id;
                $cabang = $this->input->post('cabang_id');
            } elseif (is_superadmin()) {
                $instansi = $this->session->instansi_id;
                $cabang = $this->session->cabang_id;
            }

            //Tambah User
            //Format penulisan username
            $username = str_replace(' ', '', strtolower($this->input->post('name')));

            $password = password_hash('12345678', PASSWORD_BCRYPT);

            $data = array(
                'no_anggota'        => $no_anggota,
                'name'              => $this->input->post('name'),
                'gender'            => 1,
                'birthdate'         => '',
                'birthplace'        => '',
                'address'           => $this->input->post('address'),
                'phone'             => $phone,
                'email'             => $this->input->post('email'),
                'username'          => $username,
                'password'          => $password,
                'instansi_id'       => $instansi,
                'cabang_id'         => $cabang,
                'usertype_id'       => 3,
                'created_by'        => $this->session->username,
                'ip_add_reg'        => $this->input->ip_address(),
                'photo'             => 'noimage.jpg',
            );

            $this->Auth_model->insert($data);

            $user_id = $this->db->insert_id();

            //Tambah Deposito
            $data = array(
                'name'              => $this->input->post('name'),
                'nik'               => $this->input->post('nik'),
                'address'           => $this->input->post('address'),
                'email'             => $this->input->post('email'),
                'phone'             => $phone,
                'user_id'           => $user_id,
                'instansi_id'       => $instansi,
                'cabang_id'         => $cabang,
                'total_deposito'    => (int) $total_deposito,
                'saldo_deposito'    => (int) $total_deposito,
                'jangka_waktu'      => $jangka_waktu_deposito,
                'waktu_deposito'    => $this->input->post('waktu_deposito'),
                'jatuh_tempo'       => $this->input->post('jatuh_tempo'),
                'created_by'        => $this->session->username,
            );

            $this->Deposito_model->insert($data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
            redirect('admin/deposito');
        }
    }

    function update_action()
    {
        if (is_grandadmin()) {
            $this->form_validation->set_rules('instansi_id', 'Instansi', 'required');
            $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');
        } elseif (is_masteradmin()) {
            $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');
        }
        $this->form_validation->set_rules('name', 'Nama Deposan', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'is_numeric|required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|required');
        $this->form_validation->set_rules('phone', 'No. HP/Telephone', 'is_numeric|required');
        $this->form_validation->set_rules('total_deposito', 'Jumlah Deposito', 'required');
        $this->form_validation->set_rules('waktu_deposito', 'Waktu Deposito', 'required');
        $this->form_validation->set_rules('jatuh_tempo', 'Jatuh Tempo', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('is_numeric', '{field} harus angka');
        $this->form_validation->set_message('valid_email', '{field} format email tidak benar');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            //Ubah tipe data total deposito
            $string = $this->input->post('total_deposito');
            $total_deposito = preg_replace("/[^0-9]/", "", $string);

            //Menentukan jangka waktu
            $waktu_deposito = date("Y", strtotime($this->input->post('waktu_deposito')));
            $jatuh_tempo = date("Y", strtotime($this->input->post('jatuh_tempo')));
            $jangka_waktu_deposito = $jatuh_tempo - $waktu_deposito;

            if (is_grandadmin()) {
                $instansi = $this->input->post('instansi_id');
                $cabang = $this->input->post('cabang_id');
            } elseif (is_masteradmin()) {
                $instansi = $this->session->instansi_id;
                $cabang = $this->input->post('cabang_id');
            } elseif (is_superadmin()) {
                $instansi = $this->session->instansi_id;
                $cabang = $this->session->cabang_id;
            }

            $data = array(
                'name'              => $this->input->post('name'),
                'nik'               => $this->input->post('nik'),
                'address'           => $this->input->post('address'),
                'email'             => $this->input->post('email'),
                'phone'             => $this->input->post('phone'),
                'instansi_id'       => $instansi,
                'cabang_id'         => $cabang,
                'total_deposito'    => (int) $total_deposito,
                'resapan_deposito'  => 0,
                'saldo_deposito'    => (int) $total_deposito,
                'jangka_waktu'      => $jangka_waktu_deposito,
                'waktu_deposito'    => $this->input->post('waktu_deposito'),
                'jatuh_tempo'       => $this->input->post('jatuh_tempo'),
                'modified_by'       => $this->session->username,
            );

            $this->Deposito_model->update($this->input->post('id_deposito'), $data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
            redirect('admin/deposito');
        }
    }

    function delete($id)
    {
        is_delete();

        $delete = $this->Deposito_model->get_by_id($id);

        if ($delete) {
            $data = array(
                'is_delete_deposito'   => '1',
                'deleted_by'           => $this->session->username,
                'deleted_at'           => date('Y-m-d H:i:a'),
            );

            $this->Deposito_model->soft_delete($id, $data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus!</b></h6></div>');
            redirect('admin/deposito');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/deposito');
        }
    }

    function deleted_list()
    {
        is_restore();

        $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

        if (is_grandadmin()) {
            $this->data['get_all_deleted'] = $this->Deposito_model->get_all_deleted();
        } elseif (is_masteradmin()) {
            $this->data['get_all_deleted'] = $this->Deposito_model->get_all_deleted_by_instansi();
        } elseif (is_superadmin()) {
            $this->data['get_all_deleted'] = $this->Deposito_model->get_all_deleted_by_cabang();
        }

        $this->load->view('back/deposito/deposito_deleted_list', $this->data);
    }

    function restore($id)
    {
        is_restore();

        $row = $this->Deposito_model->get_by_id($id);

        if ($row) {
            $data = array(
                'is_delete_deposito'   => '0',
                'deleted_by'           => NULL,
                'deleted_at'           => NULL,
            );

            $this->Deposito_model->update($id, $data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dikembalikan!</b></h6></div>');
            redirect('admin/deposito/deleted_list');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/deposito');
        }
    }

    function delete_permanent($id)
    {
        is_delete();

        $delete = $this->Deposito_model->get_by_id($id);

        if ($delete) {
            $this->Deposito_model->delete($id);
            $this->Auth_model->delete($delete->user_id);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus Secara Permanen!</b></h6></div>');
            redirect('admin/deposito/deleted_list');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/deposito');
        }
    }

    function count_basil_berjalan_by_deposan($id_deposito)
    {
        $this->data['data_deposito'] = $this->Deposito_model->get_by_id($id_deposito);

        $basil_berjalan = $this->Sumberdana_model->count_basil_berjalan_by_deposan($id_deposito);
        $this->data['riwayat_basil_berjalan'] = $basil_berjalan[0]->basil_for_deposan;

        $this->data['basil_berjalan'] = $basil_berjalan[0]->basil_for_deposan;

        $this->data['basil_deposan_berjalan'] = $this->Sumberdana_model->get_basil_for_deposan_berjalan($id_deposito);

        $this->load->view('back/deposito/v_basil_berjalan', $this->data);
    }

    function get_pengguna_dana_by_deposan($id_deposito)
    {
        $this->data['pengguna_dana'] = $this->Sumberdana_model->get_pengguna_dana_by_deposan($id_deposito);

        $this->load->view('back/deposito/v_pengguna_dana_by_deposan_list', $this->data);
    }

    function component_dropdown($id_deposito)
    {
        $this->data['deposito'] = $this->Deposito_model->get_by_id($id_deposito);

        if (is_grandadmin()) {
            $this->data['get_all_combobox_instansi'] = $this->Instansi_model->get_all_combobox();
            $this->data['get_all_combobox_cabang'] = $this->Cabang_model->get_all_combobox_by_instansi($this->data['deposito']->instansi_id);
        } elseif (is_masteradmin()) {
            $this->data['get_all_combobox_cabang'] = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
        }

        $this->data['instansi_id'] = [
            'name'          => 'instansi_id',
            'id'            => 'instansi_id',
            'class'         => 'form-control',
            'required'      => '',
            'onChange'      => 'tampilCabang()',
            'value'         => $this->form_validation->set_value('instansi_id'),
        ];
        $this->data['cabang_id'] = [
            'name'          => 'cabang_id',
            'id'            => 'cabang_id',
            'class'         => 'form-control',
            'required'      => '',
            'value'         => $this->form_validation->set_value('cabang_id'),
        ];

        $this->load->view('back/deposito/v_component_dropdown', $this->data);
    }

    function tarik_deposito($id_deposito)
    {
        // Get deposito by id
        $deposito = $this->Deposito_model->get_deposito_by_id($id_deposito);

        // Cek deposito aktif
        if ($deposito->is_active == 1) {
            // Edit is_active deposito menjadi nonaktif
            $this->Deposito_model->update($id_deposito, array('is_active' => 0, 'is_withdrawal' => 1));

            // Get all data sumberdana by deposito id
            $data_sumber_dana = $this->Sumberdana_model->get_all_by_deposito($id_deposito);
            $data_sumber_dana_non_ischange = $this->Sumberdana_model->get_all_by_deposito_non_ischange($id_deposito);

            // Deklarasi Variabel
            $resapan_tabungan_instansi = $deposito->instansi_resapan_tabungan;
            $saldo_tabungan_instansi = $deposito->instansi_saldo_tabungan;
            $resapan_tabungan_cabang = $deposito->cabang_resapan_tabungan;
            $saldo_tabungan_cabang = $deposito->cabang_saldo_tabungan;
            $saldo_deposito = $deposito->saldo_deposito;
            $resapan_deposito = $deposito->resapan_deposito;

            foreach ($data_sumber_dana as $sumber_dana) {
                //MANIPULASI DATA INSTANSI
                $resapan_tabungan_instansi = $resapan_tabungan_instansi + $sumber_dana->nominal;
                $saldo_tabungan_instansi = $saldo_tabungan_instansi - $sumber_dana->nominal;

                //MANIPULASI DATA CABANG
                $resapan_tabungan_cabang = $resapan_tabungan_cabang + $sumber_dana->nominal;
                $saldo_tabungan_cabang = $saldo_tabungan_cabang - $sumber_dana->nominal;

                // MANIPULASI DATA DEPOSITO
                $saldo_deposito = $saldo_deposito + $sumber_dana->nominal;
                $resapan_deposito = $resapan_deposito - $sumber_dana->nominal;
            }

            // UPDATE DATA INSTANSI
            $data_instansi_baru = array(
                'saldo_tabungan'    => $saldo_tabungan_instansi,
                'resapan_tabungan'  => $resapan_tabungan_instansi,
            );

            $this->Instansi_model->update($deposito->instansi_id, $data_instansi_baru);

            // UPDATE DATA CABANG
            $data_cabang_baru = array(
                'saldo_tabungan'    => $saldo_tabungan_cabang,
                'resapan_tabungan'  => $resapan_tabungan_cabang,
            );

            $this->Cabang_model->update($deposito->cabang_id, $data_cabang_baru);

            // UPDATE DATA DEPOSITO
            $data_deposito_baru = array(
                'saldo_deposito'    => $saldo_deposito,
                'resapan_deposito'  => $resapan_deposito,
            );

            $this->Deposito_model->update($deposito->id_deposito, $data_deposito_baru);

            // MANIPULASI TABEL SUMBER DANA
            foreach ($data_sumber_dana as $sumber_dana) {

                // Hitung selisih bulan
                $waktu_gadai = strtotime($sumber_dana->waktu_gadai);
                $today = strtotime(date('Y-m-d'));

                $different_time = (date("Y", $today) - date("Y", $waktu_gadai)) * 12;
                $different_time += date("m", $today) - date("m", $waktu_gadai);

                if ($different_time > 0) {
                    // BASIL FOR DEPOSAN BERJALAN
                    $biaya_sewa_for_deposan_perbulan = $sumber_dana->basil_for_deposan / $sumber_dana->jangka_waktu_pinjam;
                    $basil_for_deposan_bulan_berjalan = $biaya_sewa_for_deposan_perbulan * $different_time;

                    // BASIL FOR LEMBAGA BERJALAN
                    $biaya_sewa_for_lembaga_perbulan = $sumber_dana->basil_for_lembaga / $sumber_dana->jangka_waktu_pinjam;
                    $basil_for_lembaga_bulan_berjalan = $biaya_sewa_for_lembaga_perbulan * $different_time;

                    // UPDATE TOTAL BASIL, BASIL FOR DEPOSAN, BASIL FOR LEMBAGA
                    $basil_perbulan = $sumber_dana->total_basil / $sumber_dana->jangka_waktu_pinjam;
                    $total_basil_bulan_berjalan = $basil_perbulan * $different_time;

                    // UPDATE DATA SUMBER DANA BY ID
                    $new_sumber_dana_deposito = array(
                        'total_basil'                   => $total_basil_bulan_berjalan,
                        'basil_for_deposan'             => $basil_for_deposan_bulan_berjalan,
                        'basil_for_lembaga'             => $basil_for_lembaga_bulan_berjalan,
                        'basil_for_deposan_berjalan'    => $basil_for_deposan_bulan_berjalan,
                        'basil_for_lembaga_berjalan'    => $basil_for_lembaga_bulan_berjalan,
                        'status_pembayaran'             => 1,
                        'is_change'                     => 1,
                        // 'is_withdrawal'                 => 1,
                    );

                    $this->Sumberdana_model->update($sumber_dana->id_sumber_dana, $new_sumber_dana_deposito);

                } elseif ($different_time == 0) {
                    // BASIL FOR DEPOSAN BERJALAN
                    $basil_for_deposan_bulan_berjalan = $sumber_dana->basil_for_deposan / $sumber_dana->jangka_waktu_pinjam;

                    // BASIL FOR LEMBAGA BERJALAN
                    $basil_for_lembaga_bulan_berjalan = $sumber_dana->basil_for_lembaga / $sumber_dana->jangka_waktu_pinjam;

                    // UPDATE TOTAL BASIL, BASIL FOR DEPOSAN, BASIL FOR LEMBAGA
                    $total_basil_bulan_berjalan = $sumber_dana->total_basil / $sumber_dana->jangka_waktu_pinjam;

                    // UPDATE DATA SUMBER DANA BY ID
                    $new_sumber_dana_deposito = array(
                        'total_basil'                   => $total_basil_bulan_berjalan,
                        'basil_for_deposan'             => $basil_for_deposan_bulan_berjalan,
                        'basil_for_lembaga'             => $basil_for_lembaga_bulan_berjalan,
                        'basil_for_deposan_berjalan'    => $basil_for_deposan_bulan_berjalan,
                        'basil_for_lembaga_berjalan'    => $basil_for_lembaga_bulan_berjalan,
                        'status_pembayaran'             => 1,
                        'is_change'                     => 1,
                        // 'is_withdrawal'                 => 1,
                    );

                    $this->Sumberdana_model->update($sumber_dana->id_sumber_dana, $new_sumber_dana_deposito);
                }

                // Jika nominal basil berjalan lebih kecil daripada target basil
                if ($sumber_dana->basil_for_deposan_berjalan < $sumber_dana->basil_for_deposan && $sumber_dana->basil_for_lembaga_berjalan < $sumber_dana->basil_for_lembaga) {

                    // Get all sumberdana by id pembiayaan
                    $sumber_dana_by_pembiayaan = $this->Sumberdana_model->get_all_sumberdana_by_pembiayaan($sumber_dana->pembiayaan_id);

                    // Get pembiayaan by id
                    $pembiayaan = $this->Pembiayaan_model->get_by_id($sumber_dana->pembiayaan_id);

                    // Deklarasi variabel
                    $total_basil_berjalan_by_pembiayaan = 0;

                    foreach ($sumber_dana_by_pembiayaan as $data) {
                        // Jumlahkan semua basil berjalan berdasarkan id pembiayaan
                        $total_basil_berjalan_by_pembiayaan = $total_basil_berjalan_by_pembiayaan + ($data->basil_for_deposan_berjalan + $data->basil_for_lembaga_berjalan);
                    }

                    // Hitung selisih pembagian basil dengan jumlah terbayar
                    $selisih_basil_berjalan = $total_basil_berjalan_by_pembiayaan - $pembiayaan->jml_terbayar;

                    // Kondisi selisih lebih dari 0
                    if ($selisih_basil_berjalan > 0) {
                        // Maka selisih basil dibagi untuk deposan (30%) dan lembaga (70%)
                        $basil_for_lembaga_berjalan = $selisih_basil_berjalan*70/100;
                        $basil_for_deposan_berjalan = $selisih_basil_berjalan*30/100;

                        // Mengurangi basil berjalan dengan selisih basil
                        $result_basil_for_lembaga_berjalan = $basil_for_lembaga_bulan_berjalan - $basil_for_lembaga_berjalan;
                        $result_basil_for_deposan_berjalan = $basil_for_deposan_bulan_berjalan - $basil_for_deposan_berjalan;

                        $total_basil_bulan_berjalan = $total_basil_bulan_berjalan - $selisih_basil_berjalan;

                        // UPDATE DATA SUMBER DANA BY ID
                        $new_sumber_dana_deposito = array(
                            'total_basil'                   => $total_basil_bulan_berjalan,
                            'basil_for_deposan'             => $result_basil_for_deposan_berjalan,
                            'basil_for_lembaga'             => $result_basil_for_lembaga_berjalan,
                            'basil_for_deposan_berjalan'    => $result_basil_for_deposan_berjalan,
                            'basil_for_lembaga_berjalan'    => $result_basil_for_lembaga_berjalan,
                        );

                        $this->Sumberdana_model->update($sumber_dana->id_sumber_dana, $new_sumber_dana_deposito);

                    } elseif ($selisih_basil_berjalan < 0) {
                        // Kondisi selisih minus

                        // Get all sumber dana by pembiayaan yang tidak dilakukan perubahan
                        $sumber_dana_by_pembiayaan = $this->Sumberdana_model->get_all_by_pembiayaan_non_onchange($sumber_dana->pembiayaan_id)->result();

                        // Hitung jumlah data sumber dana by pembiayaan yang tidak dilakukan perubahan
                        $count_sumber_dana_by_pembiayaan = $this->Sumberdana_model->get_all_by_pembiayaan_non_onchange($sumber_dana->pembiayaan_id)->num_rows();

                        // Jika data sumber dana lebih dari 0
                        if ($count_sumber_dana_by_pembiayaan > 0) {
                            // Selisih basil berjalan dibagi rata sesuai jumlah sumber dana
                            $pembagian_basil = $selisih_basil_berjalan / (-$count_sumber_dana_by_pembiayaan);

                            foreach ($sumber_dana_by_pembiayaan as $data) {
                                $pembagian_basil_for_lembaga =  $data->basil_for_lembaga_berjalan + ($pembagian_basil*70/100);
                                $pembagian_basil_for_deposan = $data->basil_for_deposan_berjalan + ($pembagian_basil*30/100);

                                //Nominal cicilan lebih besar dari basil for lembaga
                                if ($pembagian_basil_for_lembaga > $data->basil_for_lembaga) {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                                } else {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $pembagian_basil_for_lembaga));
                                }

                                //Nominal cicilan lebih besar dari basil for deposan
                                if ($pembagian_basil_for_deposan > $data->basil_for_deposan) {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_deposan_berjalan' => $data->basil_for_deposan));
                                } else {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_deposan_berjalan' => $pembagian_basil_for_deposan));
                                }

                            }

                        }
                    }
                }

                // TAMBAH DATA SUMBER DANA DARI TABUNGAN
                $check_ketersediaan_sumberdana = $this->Sumberdana_model->get_by_pembiayaan_and_deposito_null($sumber_dana->pembiayaan_id);

                $total_basil_sisa = $sumber_dana->total_basil - $total_basil_bulan_berjalan;

                if ($check_ketersediaan_sumberdana) {
                    // UPDATE SUMBER DANA TABUNGAN YANG SUDAH ADA
                    $persentase = $check_ketersediaan_sumberdana->persentase + $sumber_dana->persentase;
                    $nominal = $check_ketersediaan_sumberdana->nominal + $sumber_dana->nominal;
                    $total_basil = $check_ketersediaan_sumberdana->total_basil + $total_basil_sisa;

                    $update_data = array(
                        'persentase'        => $persentase,
                        'nominal'           => $nominal,
                        'total_basil'       => $total_basil,
                        'basil_for_lembaga' => $total_basil,
                        'modified_by'       => $this->session->username,
                    );

                    $this->Sumberdana_model->update($check_ketersediaan_sumberdana->id_sumber_dana, $update_data);
                } else {
                    // TAMBAH SUMBER DANA TABUNGAN BARU
                    $new_sumber_dana_tabungan = array(
                        'pembiayaan_id'     => $sumber_dana->pembiayaan_id,
                        'deposito_id'       => NULL,
                        'persentase'        => $sumber_dana->persentase,
                        'nominal'           => $sumber_dana->nominal,
                        'total_basil'       => $total_basil_sisa,
                        'basil_for_lembaga' => $total_basil_sisa,
                        'created_by'        => $this->session->username,
                    );

                    $this->Sumberdana_model->insert($new_sumber_dana_tabungan);
                }

                // EDIT SUMBER DANA DI TABEL PEMBIAYAAN
                $temp_array = array();
                // Get all sumber dana by id pembiayaan
                $sumber_dana_pembiayaan = $this->Sumberdana_model->get_all_by_pembiayaan($sumber_dana->pembiayaan_id);

                foreach ($sumber_dana_pembiayaan as $data_sumber_dana_pembiayaan) {
                    // Isikan deposito id (Termasuk yg bernilai NULL) ke array
                    array_push($temp_array, $data_sumber_dana_pembiayaan->deposito_id);
                }

                // Variabel untuk menyimpan status sumber dana
                $is_sumber_dana_tabungan = false;
                $is_sumber_dana_deposito = false;

                // Pengecekan sumber dana pada data pembiayaan
                for ($i=0; $i<count($temp_array); $i++) {
                    if ($temp_array[$i] == NULL) {
                        $is_sumber_dana_tabungan = true;
                    }

                    if ($temp_array[$i] != NULL) {
                        $is_sumber_dana_deposito = true;
                    }
                }

                // Update data pembiayaan
                if ($is_sumber_dana_tabungan && $is_sumber_dana_deposito) {
                    $this->Pembiayaan_model->update($sumber_dana->pembiayaan_id, array('sumber_dana' => 3));
                } elseif ($is_sumber_dana_tabungan && !$is_sumber_dana_deposito) {
                    $this->Pembiayaan_model->update($sumber_dana->pembiayaan_id, array('sumber_dana' => 1));
                } elseif (!$is_sumber_dana_tabungan && $is_sumber_dana_deposito) {
                    $this->Pembiayaan_model->update($sumber_dana->pembiayaan_id, array('sumber_dana' => 2));
                }


            }

            // Get total basil for deposan berjalan by id deposito
            $get_basil_for_deposan_berjalan = $this->Sumberdana_model->get_basil_for_deposan_berjalan($id_deposito)->basil_for_deposan_berjalan;

            // Update kolom riwayat bagi hasil pada tabel deposito
            $riwayat_bagi_hasil = $deposito->riwayat_bagi_hasil + $get_basil_for_deposan_berjalan;

            $this->Deposito_model->update($id_deposito, array('riwayat_bagi_hasil' => $riwayat_bagi_hasil));

            foreach ($data_sumber_dana_non_ischange as $sumber_dana) {
                $this->Sumberdana_model->update($sumber_dana->id_sumber_dana, array('is_withdrawal' => 1));
            }

            // Tambah riwayat penarikan di database tabel penarikan
            // Membandingkan tanggal hari ini dengan tgl jatuh tempo
            if (strtotime(date('Y-m-d')) > strtotime($deposito->jatuh_tempo)) {
                $status = 0;
            } elseif (strtotime(date('Y-m-d')) < strtotime($deposito->jatuh_tempo)) {
                $status = 1;
            }

            //Generate kode/no penarikan
            $get_last_id = (int) $this->db->query('SELECT max(id_penarikan) as last_id FROM penarikan')->row()->last_id;
            $get_last_id++;
            $random = mt_rand(10, 99);
            $no_penarikan = $random . sprintf("%04s", $get_last_id);

            // Tambahkan pada variabel array
            $data_penarikan = array(
                'no_penarikan'  => $no_penarikan,
                'deposito_id'   => $id_deposito,
                'jml_penarikan' => $get_basil_for_deposan_berjalan,
                'status'        => $status,
                'jatuh_tempo'   => $deposito->jatuh_tempo,
                'created_by'    => $this->session->username,
            );

            // Simpan ke database
            $this->Penarikan_model->insert($data_penarikan);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Tarik Tunai Deposito.</b></h6></div>');
            redirect('admin/deposito/index');
        } else {
            $data_sumber_dana = $this->Sumberdana_model->get_all_sumberdana_by_deposito($id_deposito);

            $this->Deposito_model->update($id_deposito, array('is_withdrawal' => 1));

            // Get total basil for deposan berjalan by id deposito
            $get_basil_for_deposan_berjalan = $this->Sumberdana_model->get_basil_for_deposan_berjalan($id_deposito)->basil_for_deposan_berjalan;

            // Update kolom riwayat bagi hasil pada tabel deposito
            $riwayat_bagi_hasil = $deposito->riwayat_bagi_hasil + $get_basil_for_deposan_berjalan;

            $this->Deposito_model->update($id_deposito, array('riwayat_bagi_hasil' => $riwayat_bagi_hasil));

            foreach ($data_sumber_dana as $sumber_dana) {
                $this->Sumberdana_model->update($sumber_dana->id_sumber_dana, array('is_withdrawal' => 1));
            }

            // Tambah riwayat penarikan di database tabel penarikan
            // Membandingkan tanggal hari ini dengan tgl jatuh tempo
            if (strtotime(date('Y-m-d')) > strtotime($deposito->jatuh_tempo)) {
                $status = 0;
            } elseif (strtotime(date('Y-m-d')) < strtotime($deposito->jatuh_tempo)) {
                $status = 1;
            }

            //Generate kode/no penarikan
            $get_last_id = (int) $this->db->query('SELECT max(id_penarikan) as last_id FROM penarikan')->row()->last_id;
            $get_last_id++;
            $random = mt_rand(10, 99);
            $no_penarikan = $random . sprintf("%04s", $get_last_id);

            // Tambahkan pada variabel array
            $data_penarikan = array(
                'no_penarikan'  => $no_penarikan,
                'deposito_id'   => $id_deposito,
                'jml_penarikan' => $get_basil_for_deposan_berjalan,
                'status'        => $status,
                'jatuh_tempo'   => $deposito->jatuh_tempo,
                'created_by'    => $this->session->username,
            );

            // Simpan ke database
            $this->Penarikan_model->insert($data_penarikan);

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Tarik Tunai Deposito.</b></h6></div>');
            redirect('admin/deposito/index');
        }

    }

    function get_riwayat_penarikan_basil_by_deposan($id_deposito)
    {
        $this->data['riwayat_penarikan_basil'] = $this->Penarikanbasil_model->get_riwayat_penarikan_basil_by_deposan($id_deposito);

        $this->load->view('back/deposito/v_riwayat_penarikan_basil_by_deposan_list', $this->data);
    }

    function get_riwayat_penarikan_by_deposan($id_deposito)
    {
        $this->data['riwayat_penarikan'] = $this->Penarikan_model->get_riwayat_penarikan_by_deposan($id_deposito);

        $this->load->view('back/deposito/v_riwayat_penarikan_by_deposan_list', $this->data);
    }

    function konversi_jangka_waktu_deposito()
    {
        $today             = date("Y/m/d");
        $tahun             = $this->uri->segment(4);
        $konversi          = mktime(0,0,0,date("n"),date("j"),date("Y")+$tahun);
        $tahun_depan       = date("Y/m/d", $konversi);

        $output['hasil_konversi'] = $tahun_depan;
        $output['today'] = $today;
        $output['review_hasil_konversi'] = date_indonesian_only($tahun_depan);
        $output['review_today'] = date_indonesian_only($today);

        echo json_encode($output);
    }

    function renew_jangka_waktu_action()
    {
        $this->form_validation->set_rules('masa_aktif', 'Jangka Waktu', 'is_numeric|required');

        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('is_numeric', '{field} harus angka');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            $data = array(
                'jangka_waktu'      => $this->input->post('masa_aktif'),
                'waktu_deposito'    => $this->input->post('data_waktu_deposito'),
                'jatuh_tempo'       => $this->input->post('data_jatuh_tempo'),
                'is_active'         => 1,
                'is_withdrawal'     => 0,
            );

            $this->Deposito_model->update($this->input->post('deposito_id'), $data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
            redirect('admin/deposito/index');
        }
    }

    function validasi_nominal_tarik_basil($nominal="", $deposito_id="")
    {
        // Get total basil for deposan berjalan by id deposito
        $get_basil_for_deposan_berjalan = $this->Sumberdana_model->get_basil_for_deposan_berjalan($deposito_id)->basil_for_deposan_berjalan;

        $nominal_penarikan = preg_replace("/[^0-9]/", "", $nominal);

        if ($nominal_penarikan > $get_basil_for_deposan_berjalan) {
            $is_valid = 0;
        } else {
            $is_valid = 1;
        }

        $output['is_valid'] = $is_valid;

        echo json_encode($output);
    }

    function tarik_basil()
    {
        $nominal_penarikan = preg_replace("/[^0-9]/", "", $this->input->post('nominal'));

        //Generate kode/no penarikan
        $get_last_id = (int) $this->db->query('SELECT max(id_penarikan_basil) as last_id FROM penarikan_basil')->row()->last_id;
        $get_last_id++;
        $random = mt_rand(10, 99);
        $no_penarikan = $random . sprintf("%04s", $get_last_id);

        $data = array(
            'no_penarikan'  => $no_penarikan,
            'deposito_id'   => $this->input->post('deposito_id'),
            'jml_penarikan' => $nominal_penarikan,
            'created_by'    => $this->session->username,
        );

        $this->Penarikanbasil_model->insert($data);

        $sumber_dana = $this->Sumberdana_model->get_all_sumberdana_by_deposito_non_iswithdrawal($this->input->post('deposito_id'));

        foreach ($sumber_dana as $data) {
            // Hitung selisih bulan
            $waktu_gadai = strtotime($data->waktu_gadai);
            $today = strtotime(date('Y-m-d'));

            $different_time = (date("Y", $today) - date("Y", $waktu_gadai)) * 12;
            $different_time += date("m", $today) - date("m", $waktu_gadai);

            if ($different_time > 0) {
                $basil_for_deposan_bulan_berjalan = $data->basil_for_deposan / $data->jangka_waktu_pinjam * $different_time;

            } elseif ($different_time == 0) {
                $basil_for_deposan_bulan_berjalan = $data->basil_for_deposan / $data->jangka_waktu_pinjam;

            }

            if ($data->status_pembayaran == 0) {
                if ($basil_for_deposan_bulan_berjalan <= $data->basil_for_deposan_berjalan) {
                    $result_basil_for_deposan_berjalan = $basil_for_deposan_bulan_berjalan - $nominal_penarikan;
                    $update_basil_for_deposan_berjalan = $data->basil_for_deposan_berjalan - $nominal_penarikan;
                } else {
                    $result_basil_for_deposan_berjalan = $data->basil_for_deposan_berjalan - $nominal_penarikan;
                    $update_basil_for_deposan_berjalan = $result_basil_for_deposan_berjalan;
                }

            } elseif ($data->status_pembayaran == 1) {
                $result_basil_for_deposan_berjalan = $data->basil_for_deposan_berjalan - $nominal_penarikan;
                $update_basil_for_deposan_berjalan = $result_basil_for_deposan_berjalan;
                $update_basil_for_deposan = $data->basil_for_deposan - $data->basil_for_deposan_berjalan;
                $new_basil_for_deposan_berjalan = 0;
                // var_dump($data->id_sumber_dana); die();
            }

            if ($result_basil_for_deposan_berjalan >= 0) {
                $result_basil_for_deposan = $data->basil_for_deposan - $nominal_penarikan;

                $data_update = array(
                    'basil_for_deposan'             => $result_basil_for_deposan,
                    'basil_for_deposan_berjalan'    => $update_basil_for_deposan_berjalan,
                    // 'is_withdrawal'                 => 1,
                );

                $this->Sumberdana_model->update($data->id_sumber_dana, $data_update);
                break;
            } else {
                if ($data->status_pembayaran == 0) {
                    if ($basil_for_deposan_bulan_berjalan <= $data->basil_for_deposan_berjalan) {
                        $update_basil_for_deposan = $data->basil_for_deposan - $basil_for_deposan_bulan_berjalan;
                        $new_basil_for_deposan_berjalan = $data->basil_for_deposan_berjalan - $basil_for_deposan_bulan_berjalan;
                    } else {
                        $update_basil_for_deposan = $data->basil_for_deposan - $data->basil_for_deposan_berjalan;
                        $new_basil_for_deposan_berjalan = 0;
                    }
                }

                $data_update = array(
                    'basil_for_deposan'             => $update_basil_for_deposan,
                    'basil_for_deposan_berjalan'    => $new_basil_for_deposan_berjalan,
                    // 'is_withdrawal'                 => 1,
                );

                $this->Sumberdana_model->update($data->id_sumber_dana, $data_update);

                $nominal_penarikan = - ($result_basil_for_deposan_berjalan);
            }
        }

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Penarikan Basil Sukses!</b></h6></div>');
        redirect('admin/deposito/index');
    }

    function export()
    {
        if (is_grandadmin()) {
            $get_all = $this->Deposito_model->get_all_laporan();
        } elseif (is_masteradmin()) {
            $get_all = $this->Deposito_model->get_all_by_instansi_laporan();
        } elseif (is_superadmin()) {
            $get_all = $this->Deposito_model->get_all_by_cabang_laporan();
        }

        // Create new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Set document properties
        $spreadsheet->getProperties()
            ->setCreator($this->session->username . '-' . $this->session->instansi_name)
            ->setLastModifiedBy($this->session->username . '-' . $this->session->instansi_name)
            ->setTitle('Laporan Data Deposito Keseluruhan - ' . $this->session->instansi_name)
            ->setSubject('Laporan Data Deposito Keseluruhan - ' . $this->session->instansi_name)
            ->setCompany($this->session->instansi_name)
            ->setDescription('Dokumen ini dicetak dari sistem Rahn. Copyright by EDUARSIP. DEVELOPER: Ridar Gustia Priatama (089697641301)')
            ->setKeywords('office 2007 openxml php')
            ->setCategory('laporan deposito');

        if (is_grandadmin()) {
            // merge cells
            $spreadsheet->getActiveSheet()->mergeCells('A1:P1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:P2');
            // set warna font
            // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
            $spreadsheet->getActiveSheet()->getStyle('A1')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A1')
                ->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A2')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A2')
                ->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A4:I4')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // styling dalam array
            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => '92D050',
                    ],
                ],
            ];

            $spreadsheet->getActiveSheet()->getStyle('A4:P4')->applyFromArray($styleArray);

            // autowidth column
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);

            // Add some data
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'LAPORAN DEPOSITO KESELURUHAN')
                ->setCellValue('A2', $this->session->instansi_name)
                ->setCellValue('A4', 'NO')
                ->setCellValue('B4', 'NO. ANGGOTA')
                ->setCellValue('C4', 'NAMA')
                ->setCellValue('D4', 'NIK')
                ->setCellValue('E4', 'ALAMAT LENGKAP')
                ->setCellValue('F4', 'EMAIL')
                ->setCellValue('G4', 'NO. TELEPON/HP')
                ->setCellValue('H4', 'CABANG')
                ->setCellValue('I4', 'INSTANSI')
                ->setCellValue('J4', 'TOTAL DEPOSITO')
                ->setCellValue('K4', 'SERAPAN DEPOSITO')
                ->setCellValue('L4', 'SALDO DEPOSITO')
                ->setCellValue('M4', 'JANGKA WAKTU (TAHUN)')
                ->setCellValue('N4', 'WAKTU DEPOSITO')
                ->setCellValue('O4', 'JATUH TEMPO')
                ->setCellValue('P4', 'STATUS');

            $i = 5;
            $no = '1';
            foreach ($get_all as $data) {

                if ($data->is_active == '1') {
                    $status = 'Aktif';
                } else {
                    $status = 'NonAktif';
                }

                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $styleArrayLeft = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('#');
                $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('#');
                $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('O' . $i)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('P' . $i)->applyFromArray($styleArray);

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $no++)
                    ->setCellValue('B' . $i, $data->no_anggota)
                    ->setCellValue('C' . $i, $data->name)
                    ->setCellValue('D' . $i, substr($data->nik, 0, 12) . 'xxxx')
                    ->setCellValue('E' . $i, $data->address)
                    ->setCellValue('F' . $i, $data->email)
                    ->setCellValue('G' . $i, $data->phone)
                    ->setCellValue('H' . $i, $data->cabang_name)
                    ->setCellValue('I' . $i, $data->instansi_name)
                    ->setCellValue('J' . $i, $data->total_deposito)
                    ->setCellValue('K' . $i, $data->resapan_deposito)
                    ->setCellValue('L' . $i, $data->saldo_deposito)
                    ->setCellValue('M' . $i, $data->jangka_waktu)
                    ->setCellValue('N' . $i, date_indonesian_only($data->waktu_deposito))
                    ->setCellValue('O' . $i, date_indonesian_only($data->jatuh_tempo))
                    ->setCellValue('P' . $i, $status);
                $i++;
            }
        }
        // jika masteradmin atau superadmin
        elseif (is_masteradmin() OR is_superadmin()) {
            // merge cells
            $spreadsheet->getActiveSheet()->mergeCells('A1:O1');
            $spreadsheet->getActiveSheet()->mergeCells('A2:O2');
            // set warna font
            // $spreadsheet->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB('FFFF0000');
            $spreadsheet->getActiveSheet()->getStyle('A1')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A1')
                ->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A2')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $spreadsheet->getActiveSheet()->getStyle('A2')
                ->getFont()->setBold(true);
            $spreadsheet->getActiveSheet()->getStyle('A4:I4')
                ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

            // styling dalam array
            $styleArray = [
                'font' => [
                    'bold' => true,
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ],
                'borders' => [
                    'allBorders' => [
                        'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    ],
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => [
                        'argb' => '92D050',
                    ],
                ],
            ];

            $spreadsheet->getActiveSheet()->getStyle('A4:O4')->applyFromArray($styleArray);

            // autowidth column
            $spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
            $spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);

            // Add some data
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A1', 'LAPORAN DEPOSITO KESELURUHAN')
                ->setCellValue('A2', $this->session->instansi_name)
                ->setCellValue('A4', 'NO')
                ->setCellValue('B4', 'NO. ANGGOTA')
                ->setCellValue('C4', 'NAMA')
                ->setCellValue('D4', 'NIK')
                ->setCellValue('E4', 'ALAMAT LENGKAP')
                ->setCellValue('F4', 'EMAIL')
                ->setCellValue('G4', 'NO. TELEPON/HP')
                ->setCellValue('H4', 'CABANG')
                ->setCellValue('I4', 'TOTAL DEPOSITO')
                ->setCellValue('J4', 'SERAPAN DEPOSITO')
                ->setCellValue('K4', 'SALDO DEPOSITO')
                ->setCellValue('L4', 'JANGKA WAKTU (TAHUN)')
                ->setCellValue('M4', 'WAKTU DEPOSITO')
                ->setCellValue('N4', 'JATUH TEMPO')
                ->setCellValue('O4', 'STATUS');

            $i = 5;
            $no = '1';
            foreach ($get_all as $data) {

                if ($data->is_active == '1') {
                    $status = 'Aktif';
                } else {
                    $status = 'NonAktif';
                }

                $styleArray = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $styleArrayLeft = [
                    'alignment' => [
                        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
                    ],
                    'borders' => [
                        'outline' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                        ],
                    ],
                ];

                $spreadsheet->getActiveSheet()->getStyle('A' . $i)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('B' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('C' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('D' . $i)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('#');
                $spreadsheet->getActiveSheet()->getStyle('E' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('F' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('G' . $i)->applyFromArray($styleArray)->getNumberFormat()->setFormatCode('#');
                $spreadsheet->getActiveSheet()->getStyle('H' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('I' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('J' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('K' . $i)->applyFromArray($styleArrayLeft);
                $spreadsheet->getActiveSheet()->getStyle('L' . $i)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('M' . $i)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('N' . $i)->applyFromArray($styleArray);
                $spreadsheet->getActiveSheet()->getStyle('O' . $i)->applyFromArray($styleArray);

                $spreadsheet->setActiveSheetIndex(0)
                    ->setCellValue('A' . $i, $no++)
                    ->setCellValue('B' . $i, $data->no_anggota)
                    ->setCellValue('C' . $i, $data->name)
                    ->setCellValue('D' . $i, substr($data->nik, 0, 12) . 'xxxx')
                    ->setCellValue('E' . $i, $data->address)
                    ->setCellValue('F' . $i, $data->email)
                    ->setCellValue('G' . $i, $data->phone)
                    ->setCellValue('H' . $i, $data->cabang_name)
                    ->setCellValue('I' . $i, $data->total_deposito)
                    ->setCellValue('J' . $i, $data->resapan_deposito)
                    ->setCellValue('K' . $i, $data->saldo_deposito)
                    ->setCellValue('L' . $i, $data->jangka_waktu)
                    ->setCellValue('M' . $i, date_indonesian_only($data->waktu_deposito))
                    ->setCellValue('N' . $i, date_indonesian_only($data->jatuh_tempo))
                    ->setCellValue('O' . $i, $status);
                $i++;
            }
        }

        // Rename worksheet
        $spreadsheet->getActiveSheet()->setTitle('Laporan Deposito Keseluruhan');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $spreadsheet->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Xlsx)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="Laporan Deposito Keseluruhan.xlsx"');
        header('Cache-Control: max-age=0');
        // If you're serving to IE 9, then the following may be needed
        header('Cache-Control: max-age=1');

        // If you're serving to IE over SSL, then the following may be needed
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
        header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
        header('Pragma: public'); // HTTP/1.0

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
        exit;
    }
}

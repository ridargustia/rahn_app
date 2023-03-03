<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Tabungan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Tabungan';

        $this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);

        $this->data['btn_submit'] = 'Save';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/tabungan/create');

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
            $this->data['get_all'] = $this->Sumberdana_model->get_all();
            $this->data['get_total_tabungan'] = $this->Instansi_model->total_tabungan();
            $this->data['get_serapan_tabungan'] = $this->Instansi_model->serapan_tabungan();
            $this->data['get_saldo_tabungan'] = $this->Instansi_model->saldo_tabungan();
        } elseif (is_masteradmin()) {
            $this->data['get_all'] = $this->Sumberdana_model->get_all_by_instansi();
            $this->data['get_total_tabungan'] = $this->Instansi_model->total_tabungan_by_instansi();
            $this->data['get_serapan_tabungan'] = $this->Instansi_model->serapan_tabungan_by_instansi();
            $this->data['get_saldo_tabungan'] = $this->Instansi_model->saldo_tabungan_by_instansi();
        } elseif (is_superadmin()) {
            $this->data['get_all'] = $this->Sumberdana_model->get_all_by_cabang();
            $this->data['get_tabungan'] = $this->Cabang_model->get_by_id($this->session->cabang_id);
			$this->data['get_total_tabungan'] = $this->data['get_tabungan']->saldo_tabungan + $this->data['get_tabungan']->resapan_tabungan;
        }

        $this->load->view('back/tabungan/tabungan_list', $this->data);
    }

    function create()
    {
        is_create();

        $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
        $this->data['action']     = 'admin/tabungan/create_action';

        if (is_grandadmin()) {
            $this->data['get_all_combobox_instansi']     = $this->Instansi_model->get_all_combobox();
        } elseif (is_masteradmin()) {
            $this->data['get_all_combobox_cabang']       = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
        } elseif (is_superadmin()) {
            $this->data['cabang'] = $this->Cabang_model->get_by_id($this->session->cabang_id);
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
            'onChange'      => 'tampilForm()',
            'value'         => $this->form_validation->set_value('cabang_id'),
        ];
        $this->data['nominal_tabungan'] = [
            'name'          => 'nominal_tabungan',
            'id'            => 'nominal_tabungan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nominal_tabungan'),
        ];

        $this->load->view('back/tabungan/tabungan_add', $this->data);
    }

    function create_action()
    {
        if (is_grandadmin()) {
            $this->form_validation->set_rules('instansi_id', 'Instansi', 'required');
            $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');
        } elseif (is_masteradmin()) {
            $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');
        }
        $this->form_validation->set_rules('nominal_tabungan', 'Nominal Tabungan', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            //Ubah tipe data nominal tabungan
            $string = $this->input->post('nominal_tabungan');
            $nominal_tabungan = preg_replace("/[^0-9]/", "", $string);

            if (is_grandadmin()) {
                $instansi_id = $this->input->post('instansi_id');
                $cabang_id = $this->input->post('cabang_id');
            } elseif (is_masteradmin()) {
                $instansi_id = $this->session->instansi_id;
                $cabang_id = $this->input->post('cabang_id');
            } elseif (is_superadmin()) {
                $instansi_id = $this->session->instansi_id;
                $cabang_id = $this->session->cabang_id;
            }

            $instansi = $this->Instansi_model->get_by_id($instansi_id);
            $cabang = $this->Cabang_model->get_by_id($cabang_id);

            $saldo_tabungan_instansi = $instansi->saldo_tabungan + $nominal_tabungan;
            $saldo_tabungan_cabang = $cabang->saldo_tabungan + $nominal_tabungan;

            $this->Instansi_model->update($instansi_id, array('saldo_tabungan' => $saldo_tabungan_instansi));
            $this->Cabang_model->update($cabang_id, array('saldo_tabungan' => $saldo_tabungan_cabang));

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Menambahkan Saldo Tabungan!</b></h6></div>');
            redirect('admin/tabungan');
        }
    }

    function form_component($cabang_id)
    {
        if (is_grandadmin()) {
            $this->data['cabang'] = $this->Cabang_model->get_by_id($cabang_id);
            $this->data['instansi'] = $this->Instansi_model->get_by_id($this->data['cabang']->instansi_id);
        } elseif (is_masteradmin()) {
            $this->data['cabang'] = $this->Cabang_model->get_by_id($cabang_id);
            $this->data['instansi'] = $this->Instansi_model->get_by_id($this->data['cabang']->instansi_id);
        }

        $this->data['nominal_tabungan'] = [
            'name'          => 'nominal_tabungan',
            'id'            => 'nominal_tabungan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nominal_tabungan'),
        ];

        $this->load->view('back/tabungan/v_form_component', $this->data);
    }
}
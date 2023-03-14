<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Pembayaran';

        $this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);

        $this->data['btn_submit'] = 'Save';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/pembayaran/create');

        is_login();

        if ($this->uri->segment(2) != NULL) {
            menuaccess_check();
        } elseif ($this->uri->segment(3) != NULL) {
            submenuaccess_check();
        }
    }

    function index()
    {

    }

    function create()
    {
        is_create();

        $this->data['page_title']   = 'Tambah ' . $this->data['module'];
        $this->data['modal_action'] = 'admin/pembayaran/create_cicilan_action';

        if (is_grandadmin()) {
            $this->data['get_all_combobox_instansi']     = $this->Instansi_model->get_all_combobox();
        } elseif (is_masteradmin()) {
            $this->data['get_all_combobox_cabang']       = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
        } elseif (is_superadmin()) {
            $this->data['get_all_combobox_anggota']       = $this->Auth_model->get_all_combobox_anggota_by_cabang($this->session->cabang_id);
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
            'onChange'      => 'tampilUser()',
            'value'         => $this->form_validation->set_value('cabang_id'),
        ];
        $this->data['user_id'] = [
            'name'          => 'user_id',
            'id'            => 'user_id',
            'class'         => 'form-control',
            'required'      => '',
            'onChange'      => 'tampilPinjaman()',
            'value'         => $this->form_validation->set_value('user_id'),
        ];
        $this->data['nominal'] = [
            'name'          => 'nominal',
            'id'            => 'nominal',
            'class'         => 'form-control',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nominal'),
        ];
        $this->data['id_pembiayaan'] = [
            'name'          => 'id_pembiayaan',
            'id'            => 'id_pembiayaan',
            'type'          => 'hidden',
        ];

        $this->load->view('back/pembayaran/pembayaran_add', $this->data);
    }

    function create_cicilan_action()
    {
        $this->form_validation->set_rules('nominal', 'Nominal Cicilan', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            //Ubah tipe data total deposito
            $string = $this->input->post('nominal');
            $nominal_cicilan = preg_replace("/[^0-9]/", "", $string);

            //Get data pembiayaan by id_pembiayaan pada kolom jml_terbayar
            $pembiayaan = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'));

            //Menghitung jumlah tanggungan
            $jml_tanggungan = $pembiayaan->jml_pinjaman + $pembiayaan->total_biaya_sewa;

            //Jika jml terbayar dan jml tanggungan sama nilainya
            if ($pembiayaan->jml_terbayar != $jml_tanggungan and $jml_tanggungan > $pembiayaan->jml_terbayar) {
                //Jumlahkan jml_terbayar (dari database) dengan inputan nominal
                $result = $pembiayaan->jml_terbayar + $nominal_cicilan;

                //Jika nominal pembayaran lebih besar dari kekurangan bayar
                if ($result > $jml_tanggungan) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Proses Gagal. Karena Nominal lebih besar dari jumlah kekurangan bayar!</b></h6></div>');
                    redirect('admin/pembayaran');
                } else {
                    //Update data jml terbayar pada tabel pembiayaan by id
                    $this->Pembiayaan_model->update($this->input->post('id_pembiayaan'), array('jml_terbayar' => $result));

                    //Kondisi menyesuaikan sumber dana
                    if ($pembiayaan->sumber_dana == 1) {
                        //Get data sumber dana by pembiayaan id
                        $sumber_dana = $this->Sumberdana_model->cek_available_data($this->input->post('id_pembiayaan'));

                        //Lakukan perulangan data sumberdana by pembiayaan id
                        foreach($sumber_dana as $data) {
                            //Jika basil_for_lembaga_berjalan tidak sama dengan basil for lembaga
                            if ($data->basil_for_lembaga_berjalan != $data->basil_for_lembaga and $data->basil_for_lembaga > $data->basil_for_lembaga_berjalan) {
                                //Tambahkan basil for lembaga berjalan dengan nominal inputan form
                                $edit_sumberdana = $data->basil_for_lembaga_berjalan + $nominal_cicilan;

                                //Nominal cicilan lebih besar dari basil for lembaga
                                if ($edit_sumberdana > $data->basil_for_lembaga) {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                                } else {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $edit_sumberdana));
                                }
                            }
                        }
                    } elseif ($pembiayaan->sumber_dana == 2) {
                        //Get data sumber dana by pembiayaan id
                        $sumber_dana = $this->Sumberdana_model->cek_available_data($this->input->post('id_pembiayaan'));

                        //Lakukan perulangan data sumberdana by pembiayaan id
                        foreach($sumber_dana as $data) {
                            $nominal_per_deposan = $nominal_cicilan * $data->persentase/100;
                            //Jika basil_for_lembaga_berjalan tidak sama dengan basil for lembaga
                            if ($data->basil_for_lembaga_berjalan != $data->basil_for_lembaga and $data->basil_for_lembaga > $data->basil_for_lembaga_berjalan) {

                                //Tambahkan basil for lembaga berjalan dengan nominal inputan form
                                $basil_lembaga = $data->basil_for_lembaga_berjalan + ($nominal_per_deposan*70/100);

                                //Nominal cicilan lebih besar dari basil for lembaga
                                if ($basil_lembaga > $data->basil_for_lembaga) {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                                } else {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $basil_lembaga));
                                }

                            }

                            //Jika basil_for_deposan_berjalan tidak sama dengan basil for deposan
                            if ($data->basil_for_deposan_berjalan != $data->basil_for_deposan and $data->basil_for_deposan > $data->basil_for_deposan_berjalan) {

                                //Tambahkan basil for deposan berjalan dengan nominal inputan form
                                $basil_deposan = $data->basil_for_deposan_berjalan + ($nominal_per_deposan*30/100);

                                //Nominal cicilan lebih besar dari basil for lembaga
                                if ($basil_deposan > $data->basil_for_deposan) {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_deposan_berjalan' => $data->basil_for_deposan));
                                } else {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_deposan_berjalan' => $basil_deposan));
                                }
                            }
                        }
                    } elseif ($pembiayaan->sumber_dana == 3) {

                    }

                    write_log();

                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
                    redirect('admin/pembayaran');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Proses Gagal. Pinjaman telah lunas!</b></h6></div>');
                redirect('admin/pembayaran');
            }
        }
    }

    function create_lunas_action($id_pembiayaan)
    {
        //Get data pembiayaan by id_pembiayaan
        $pembiayaan = $this->Pembiayaan_model->get_by_id($id_pembiayaan);

        $tanggungan = $pembiayaan->jml_pinjaman + $pembiayaan->total_biaya_sewa;

        $kekurangan_bayar = $tanggungan - $pembiayaan->jml_terbayar;

        $jml_pelunasan = $pembiayaan->jml_terbayar + $kekurangan_bayar;

        //Update data jml terbayar pada tabel pembiayaan by id
        $this->Pembiayaan_model->update($id_pembiayaan, array('jml_terbayar' => $jml_pelunasan));

        write_log();

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
        redirect('admin/pembayaran');
    }
}
<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembayaran extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Pembayaran';

        $this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);
        $this->data['notifikasi'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->result();
        $this->data['notifikasi_counter'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->num_rows();

        $this->data['notifikasi_for_anggota'] = $this->Riwayatpembayaran_model->get_all_non_is_read_anggota();
		$this->data['notifikasi_counter_for_anggota'] = $this->Riwayatpembayaran_model->counter_non_is_read_anggota();

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
        is_read();

        $this->data['page_title'] = 'Riwayat ' . $this->data['module'];

        if (is_grandadmin()) {
            $this->data['get_all'] = $this->Riwayatpembayaran_model->get_all_pembiayaan_from_riwayat_pembayaran();
        } elseif (is_masteradmin()) {
            $this->data['get_all'] = $this->Riwayatpembayaran_model->get_all_pembiayaan_from_riwayat_pembayaran_by_instansi();
        } elseif (is_superadmin()) {
            $this->data['get_all'] = $this->Riwayatpembayaran_model->get_all_pembiayaan_from_riwayat_pembayaran_by_cabang();
        }

        $this->load->view('back/pembayaran/riwayat_pembayaran_list', $this->data);
    }

    function detail($id_pembiayaan)
    {
        $this->data['page_title'] = 'Detail Riwayat ' . $this->data['module'];

        $this->data['pembiayaan'] = $this->Pembiayaan_model->get_detail_by_id($id_pembiayaan);

        $this->data['riwayat_pembayaran'] = $this->Riwayatpembayaran_model->get_all_riwayat_pembayaran_by_pembiayaan($id_pembiayaan);

        $this->data['tanggungan'] = $this->data['pembiayaan']->jml_pinjaman + $this->data['pembiayaan']->total_biaya_sewa;

        $this->data['kekurangan_bayar'] = $this->data['tanggungan'] - $this->data['pembiayaan']->jml_terbayar;

        $this->load->view('back/pembayaran/riwayat_pembayaran_detail', $this->data);
    }

    function detail_pembayaran_online($id_user)
    {
        $this->data['page_title'] = 'Verifikasi ' . $this->data['module'];
        $this->data['action'] = 'admin/pembayaran/verifikasi_action';

        $this->data['get_all'] = $this->Riwayatpembayaran_model->get_all_pembayaran_online_by_anggota($id_user);
        $this->data['anggota'] = $this->Auth_model->get_anggota_by_id($id_user);

        $this->data['id_riwayat_pembayaran'] = [
            'name'          => 'id_riwayat_pembayaran',
            'id'            => 'id_riwayat_pembayaran',
            'type'          => 'hidden',
        ];
        $this->data['id_pembiayaan'] = [
            'name'          => 'id_pembiayaan',
            'id'            => 'id_pembiayaan',
            'type'          => 'hidden',
        ];
        $this->data['id_instansi'] = [
            'name'          => 'id_instansi',
            'id'            => 'id_instansi',
            'type'          => 'hidden',
        ];
        $this->data['id_cabang'] = [
            'name'          => 'id_cabang',
            'id'            => 'id_cabang',
            'type'          => 'hidden',
        ];

        $this->load->view('back/pembayaran/pembayaran_online_detail', $this->data);
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
        $this->data['id_instansi'] = [
            'name'          => 'id_instansi',
            'id'            => 'id_instansi',
            'type'          => 'hidden',
        ];
        $this->data['id_cabang'] = [
            'name'          => 'id_cabang',
            'id'            => 'id_cabang',
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
            //Ubah tipe data nominal cicilan
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

                    //Ubah status pembayaran menjadi lunas jika jml_tanggungan sama dengan jml_terbayar
                    $jml_terbayar_now = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'))->jml_terbayar;

                    // Pengkondisian jika pinjaman telah lunas
                    if ($jml_tanggungan == $jml_terbayar_now) {
                        //Update data status pembayaran pada tabel pembiayaan by id
                        $this->Pembiayaan_model->update($this->input->post('id_pembiayaan'), array('status_pembayaran' => 1));

                        if ($pembiayaan->sumber_dana == 1) {
                            // MANIPULASI DATA INSTANSI
                            // Update data instansi untuk dikembalikan nominal yg dipinjam
                            $data_instansi = $this->Instansi_model->get_by_id($pembiayaan->instansi_id);

                            // Menghitung jml resapan terbaru setelah dikembalikan
                            $resapan_tabungan = $data_instansi->resapan_tabungan - $pembiayaan->jml_pinjaman;

                            // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                            $saldo_tabungan = $data_instansi->saldo_tabungan + $pembiayaan->jml_pinjaman;

                            $data = array(
                                'saldo_tabungan'    => $saldo_tabungan,
                                'resapan_tabungan'  => $resapan_tabungan,
                            );

                            $this->Instansi_model->update($pembiayaan->instansi_id, $data);

                            // MANIPULASI DATA CABANG
                            // Update data cabang untuk dikembalikan nominal yg dipinjam
                            $data_cabang = $this->Cabang_model->get_by_id($pembiayaan->cabang_id);

                            // Menghitung jml resapan terbaru setelah dikembalikan
                            $resapan_tabungan = $data_cabang->resapan_tabungan - $pembiayaan->jml_pinjaman;

                            // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                            $saldo_tabungan = $data_cabang->saldo_tabungan + $pembiayaan->jml_pinjaman;

                            $data = array(
                                'saldo_tabungan'    => $saldo_tabungan,
                                'resapan_tabungan'  => $resapan_tabungan,
                            );

                            $this->Cabang_model->update($pembiayaan->cabang_id, $data);

                        } elseif ($pembiayaan->sumber_dana == 2) {
                            // MANIPULASI DATA DEPOSITO
                            // Update data deposito untuk dikembalikan nominal yg dipinjam
                            $sumber_dana_deposito = $this->Sumberdana_model->get_deposan_by_pembiayaan($pembiayaan->id_pembiayaan);

                            // Karena deposito dalam satu pinjaman bisa lebih dari satu maka lakukan perulangan
                            foreach ($sumber_dana_deposito as $data) {
                                $data_deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                                // Menghitung jml resapan terbaru setelah dikembalikan
                                $resapan_deposito = $data_deposito->resapan_deposito - $data->nominal;

                                // Menghitung jml saldo depostio terbaru setelah dikembalikan
                                $saldo_deposito = $data_deposito->saldo_deposito + $data->nominal;

                                $change_data = array(
                                    'saldo_deposito'    => $saldo_deposito,
                                    'resapan_deposito'  => $resapan_deposito,
                                );

                                $this->Deposito_model->update($data->deposito_id, $change_data);
                            }
                        } elseif ($pembiayaan->sumber_dana == 3) {
                            $sumber_dana_tabungan = $this->Sumberdana_model->get_tabungan_by_pembiayaan($pembiayaan->id_pembiayaan);

                            foreach ($sumber_dana_tabungan as $data) {
                                // MANIPULASI DATA INSTANSI
                                // Update data instansi untuk dikembalikan nominal yg dipinjam
                                $data_instansi = $this->Instansi_model->get_by_id($pembiayaan->instansi_id);

                                // Menghitung jml resapan terbaru setelah dikembalikan
                                $resapan_tabungan = $data_instansi->resapan_tabungan - $data->nominal;

                                // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                                $saldo_tabungan = $data_instansi->saldo_tabungan + $data->nominal;

                                $change_data = array(
                                    'saldo_tabungan'    => $saldo_tabungan,
                                    'resapan_tabungan'  => $resapan_tabungan,
                                );

                                $this->Instansi_model->update($pembiayaan->instansi_id, $change_data);

                                // MANIPULASI DATA CABANG
                                // Update data cabang untuk dikembalikan nominal yg dipinjam
                                $data_cabang = $this->Cabang_model->get_by_id($pembiayaan->cabang_id);

                                // Menghitung jml resapan terbaru setelah dikembalikan
                                $resapan_tabungan = $data_cabang->resapan_tabungan - $data->nominal;

                                // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                                $saldo_tabungan = $data_cabang->saldo_tabungan + $data->nominal;

                                $change_data = array(
                                    'saldo_tabungan'    => $saldo_tabungan,
                                    'resapan_tabungan'  => $resapan_tabungan,
                                );

                                $this->Cabang_model->update($pembiayaan->cabang_id, $change_data);
                            }

                            // MANIPULASI DATA DEPOSITO
                            // Update data deposito untuk dikembalikan nominal yg dipinjam
                            $sumber_dana_deposito = $this->Sumberdana_model->get_deposan_by_pembiayaan($pembiayaan->id_pembiayaan);

                            // Karena deposito dalam satu pinjaman bisa lebih dari satu maka lakukan perulangan
                            foreach ($sumber_dana_deposito as $data) {
                                $data_deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                                // Menghitung jml resapan terbaru setelah dikembalikan
                                $resapan_deposito = $data_deposito->resapan_deposito - $data->nominal;

                                // Menghitung jml saldo depostio terbaru setelah dikembalikan
                                $saldo_deposito = $data_deposito->saldo_deposito + $data->nominal;

                                $change_data = array(
                                    'saldo_deposito'    => $saldo_deposito,
                                    'resapan_deposito'  => $resapan_deposito,
                                );

                                $this->Deposito_model->update($data->deposito_id, $change_data);
                            }
                        }
                    }

                    //Tambah Riwayat Pembayaran Baru
                    //Generate kode/no invoice
                    $get_last_id = (int) $this->db->query('SELECT max(id_riwayat_pembayaran) as last_id FROM riwayat_pembayaran')->row()->last_id;
                    $get_last_id++;
                    $random = mt_rand(10, 99);
                    $no_invoice = $random . sprintf("%04s", $get_last_id);

                    if (is_grandadmin()) {
                        $instansi = $this->input->post('id_instansi');
                        $cabang = $this->input->post('id_cabang');
                    } elseif (is_masteradmin()) {
                        $instansi = $this->session->instansi_id;
                        $cabang = $this->input->post('id_cabang');
                    } elseif (is_superadmin()) {
                        $instansi = $this->session->instansi_id;
                        $cabang = $this->session->cabang_id;
                    }

                    $kekurangan = $jml_tanggungan - $jml_terbayar_now;

                    $data = array(
                        'no_invoice'        => $no_invoice,
                        'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                        'instansi_id'       => $instansi,
                        'cabang_id'         => $cabang,
                        'nominal'           => $nominal_cicilan,
                        'terbayar'          => $jml_terbayar_now,
                        'kekurangan_bayar'  => $kekurangan,
                        'created_by'        => $this->session->username,
                    );

                    $this->Riwayatpembayaran_model->insert($data);

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
                        //Get data sumber dana by pembiayaan id
                        $sumber_dana = $this->Sumberdana_model->cek_available_data($this->input->post('id_pembiayaan'));

                        //Lakukan perulangan data sumberdana by pembiayaan id
                        foreach($sumber_dana as $data) {
                            $nominal_per_deposan = $nominal_cicilan * $data->persentase/100;
                            //Jika basil_for_lembaga_berjalan tidak sama dengan basil for lembaga
                            if ($data->basil_for_lembaga_berjalan != $data->basil_for_lembaga and $data->basil_for_lembaga > $data->basil_for_lembaga_berjalan) {

                                //Tambahkan basil for lembaga berjalan dengan nominal inputan form
                                if ($data->deposito_id != NULL) {
                                    $basil_lembaga = $data->basil_for_lembaga_berjalan + ($nominal_per_deposan*70/100);
                                } else {
                                    $basil_lembaga = $data->basil_for_lembaga_berjalan + $nominal_per_deposan;
                                }

                                //Nominal cicilan lebih besar dari basil for lembaga
                                if ($basil_lembaga > $data->basil_for_lembaga) {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                                } else {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $basil_lembaga));
                                }

                            }

                            if ($data->deposito_id != NULL) {
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
                        }
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

        //Menghitung jumlah tanggungan
        $tanggungan = $pembiayaan->jml_pinjaman + $pembiayaan->total_biaya_sewa;

        //Jika jml terbayar dan jml tanggungan sama nilainya
        if ($pembiayaan->jml_terbayar != $tanggungan and $tanggungan > $pembiayaan->jml_terbayar) {

            //Menghitung kekurangan bayar
            $kekurangan_bayar = $tanggungan - $pembiayaan->jml_terbayar;

            //Tambahkan jml terbayar dengan kekurangan bayar
            $jml_pelunasan = $pembiayaan->jml_terbayar + $kekurangan_bayar;

            //Update data jml terbayar pada tabel pembiayaan by id
            $this->Pembiayaan_model->update($id_pembiayaan, array('jml_terbayar' => $jml_pelunasan));

            //Ubah status pembayaran menjadi lunas jika jml_tanggungan sama dengan jml_terbayar
            $jml_terbayar_now = $this->Pembiayaan_model->get_by_id($id_pembiayaan)->jml_terbayar;

            // Pengkondisian jika pinjaman telah lunas
            if ($tanggungan == $jml_terbayar_now) {
                //Update data status pembayaran pada tabel pembiayaan by id
                $this->Pembiayaan_model->update($id_pembiayaan, array('status_pembayaran' => 1));

                if ($pembiayaan->sumber_dana == 1) {
                    // MANIPULASI DATA INSTANSI
                    // Update data instansi untuk dikembalikan nominal yg dipinjam
                    $data_instansi = $this->Instansi_model->get_by_id($pembiayaan->instansi_id);

                    // Menghitung jml resapan terbaru setelah dikembalikan
                    $resapan_tabungan = $data_instansi->resapan_tabungan - $pembiayaan->jml_pinjaman;

                    // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                    $saldo_tabungan = $data_instansi->saldo_tabungan + $pembiayaan->jml_pinjaman;

                    $data = array(
                        'saldo_tabungan'    => $saldo_tabungan,
                        'resapan_tabungan'  => $resapan_tabungan,
                    );

                    $this->Instansi_model->update($pembiayaan->instansi_id, $data);

                    // MANIPULASI DATA CABANG
                    // Update data cabang untuk dikembalikan nominal yg dipinjam
                    $data_cabang = $this->Cabang_model->get_by_id($pembiayaan->cabang_id);

                    // Menghitung jml resapan terbaru setelah dikembalikan
                    $resapan_tabungan = $data_cabang->resapan_tabungan - $pembiayaan->jml_pinjaman;

                    // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                    $saldo_tabungan = $data_cabang->saldo_tabungan + $pembiayaan->jml_pinjaman;

                    $data = array(
                        'saldo_tabungan'    => $saldo_tabungan,
                        'resapan_tabungan'  => $resapan_tabungan,
                    );

                    $this->Cabang_model->update($pembiayaan->cabang_id, $data);
                } elseif ($pembiayaan->sumber_dana == 2) {
                    // MANIPULASI DATA DEPOSITO
                    // Update data deposito untuk dikembalikan nominal yg dipinjam
                    $sumber_dana_deposito = $this->Sumberdana_model->get_deposan_by_pembiayaan($pembiayaan->id_pembiayaan);

                    // Karena deposito dalam satu pinjaman bisa lebih dari satu maka lakukan perulangan
                    foreach ($sumber_dana_deposito as $data) {
                        $data_deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                        // Menghitung jml resapan terbaru setelah dikembalikan
                        $resapan_deposito = $data_deposito->resapan_deposito - $data->nominal;

                        // Menghitung jml saldo depostio terbaru setelah dikembalikan
                        $saldo_deposito = $data_deposito->saldo_deposito + $data->nominal;

                        $change_data = array(
                            'saldo_deposito'    => $saldo_deposito,
                            'resapan_deposito'  => $resapan_deposito,
                        );

                        $this->Deposito_model->update($data->deposito_id, $change_data);
                    }
                } elseif ($pembiayaan->sumber_dana == 3) {
                    $sumber_dana_tabungan = $this->Sumberdana_model->get_tabungan_by_pembiayaan($pembiayaan->id_pembiayaan);

                    foreach ($sumber_dana_tabungan as $data) {
                        // MANIPULASI DATA INSTANSI
                        // Update data instansi untuk dikembalikan nominal yg dipinjam
                        $data_instansi = $this->Instansi_model->get_by_id($pembiayaan->instansi_id);

                        // Menghitung jml resapan terbaru setelah dikembalikan
                        $resapan_tabungan = $data_instansi->resapan_tabungan - $data->nominal;

                        // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                        $saldo_tabungan = $data_instansi->saldo_tabungan + $data->nominal;

                        $change_data = array(
                            'saldo_tabungan'    => $saldo_tabungan,
                            'resapan_tabungan'  => $resapan_tabungan,
                        );

                        $this->Instansi_model->update($pembiayaan->instansi_id, $change_data);

                        // MANIPULASI DATA CABANG
                        // Update data cabang untuk dikembalikan nominal yg dipinjam
                        $data_cabang = $this->Cabang_model->get_by_id($pembiayaan->cabang_id);

                        // Menghitung jml resapan terbaru setelah dikembalikan
                        $resapan_tabungan = $data_cabang->resapan_tabungan - $data->nominal;

                        // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                        $saldo_tabungan = $data_cabang->saldo_tabungan + $data->nominal;

                        $change_data = array(
                            'saldo_tabungan'    => $saldo_tabungan,
                            'resapan_tabungan'  => $resapan_tabungan,
                        );

                        $this->Cabang_model->update($pembiayaan->cabang_id, $change_data);
                    }

                    // MANIPULASI DATA DEPOSITO
                    // Update data deposito untuk dikembalikan nominal yg dipinjam
                    $sumber_dana_deposito = $this->Sumberdana_model->get_deposan_by_pembiayaan($pembiayaan->id_pembiayaan);

                    // Karena deposito dalam satu pinjaman bisa lebih dari satu maka lakukan perulangan
                    foreach ($sumber_dana_deposito as $data) {
                        $data_deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                        // Menghitung jml resapan terbaru setelah dikembalikan
                        $resapan_deposito = $data_deposito->resapan_deposito - $data->nominal;

                        // Menghitung jml saldo depostio terbaru setelah dikembalikan
                        $saldo_deposito = $data_deposito->saldo_deposito + $data->nominal;

                        $change_data = array(
                            'saldo_deposito'    => $saldo_deposito,
                            'resapan_deposito'  => $resapan_deposito,
                        );

                        $this->Deposito_model->update($data->deposito_id, $change_data);
                    }
                }
            }

            //Tambah Riwayat Pembayaran Baru
            //Generate kode/no invoice
            $get_last_id = (int) $this->db->query('SELECT max(id_riwayat_pembayaran) as last_id FROM riwayat_pembayaran')->row()->last_id;
            $get_last_id++;
            $random = mt_rand(10, 99);
            $no_invoice = $random . sprintf("%04s", $get_last_id);

            if (is_grandadmin()) {
                $instansi = $pembiayaan->instansi_id;
                $cabang = $pembiayaan->cabang_id;
            } elseif (is_masteradmin()) {
                $instansi = $this->session->instansi_id;
                $cabang = $pembiayaan->cabang_id;
            } elseif (is_superadmin()) {
                $instansi = $this->session->instansi_id;
                $cabang = $this->session->cabang_id;
            }

            $data = array(
                'no_invoice'        => $no_invoice,
                'pembiayaan_id'     => $id_pembiayaan,
                'instansi_id'       => $instansi,
                'cabang_id'         => $cabang,
                'nominal'           => $kekurangan_bayar,
                'terbayar'          => $jml_terbayar_now,
                'kekurangan_bayar'  => 0,
                'created_by'        => $this->session->username,
            );

            $this->Riwayatpembayaran_model->insert($data);

            //Kondisi menyesuaikan sumber dana
            if ($pembiayaan->sumber_dana == 1) {
                //Get data sumber dana by pembiayaan id
                $sumber_dana = $this->Sumberdana_model->cek_available_data($id_pembiayaan);

                //Lakukan perulangan data sumberdana by pembiayaan id
                foreach($sumber_dana as $data) {
                    //Jika basil_for_lembaga_berjalan tidak sama dengan basil for lembaga
                    if ($data->basil_for_lembaga_berjalan != $data->basil_for_lembaga and $data->basil_for_lembaga > $data->basil_for_lembaga_berjalan) {
                        //Update ke database by id sumber dana
                        $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                    }
                }
            } elseif ($pembiayaan->sumber_dana == 2) {
                //Get data sumber dana by pembiayaan id
                $sumber_dana = $this->Sumberdana_model->cek_available_data($id_pembiayaan);

                //Lakukan perulangan data sumberdana by pembiayaan id
                foreach($sumber_dana as $data) {
                    //Jika basil_for_lembaga_berjalan tidak sama dengan basil for lembaga
                    if ($data->basil_for_lembaga_berjalan != $data->basil_for_lembaga and $data->basil_for_lembaga > $data->basil_for_lembaga_berjalan) {

                        //Update ke database by id sumber dana
                        $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                    }

                    //Jika basil_for_deposan_berjalan tidak sama dengan basil for deposan
                    if ($data->basil_for_deposan_berjalan != $data->basil_for_deposan and $data->basil_for_deposan > $data->basil_for_deposan_berjalan) {

                        //Update ke database by id sumber dana
                        $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_deposan_berjalan' => $data->basil_for_deposan));
                    }
                }
            } elseif ($pembiayaan->sumber_dana == 3) {
                //Get data sumber dana by pembiayaan id
                $sumber_dana = $this->Sumberdana_model->cek_available_data($id_pembiayaan);

                //Lakukan perulangan data sumberdana by pembiayaan id
                foreach($sumber_dana as $data) {
                    //Jika basil_for_lembaga_berjalan tidak sama dengan basil for lembaga
                    if ($data->basil_for_lembaga_berjalan != $data->basil_for_lembaga and $data->basil_for_lembaga > $data->basil_for_lembaga_berjalan) {

                        //Update ke database by id sumber dana
                        $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                    }

                    if ($data->deposito_id != NULL) {
                        //Jika basil_for_deposan_berjalan tidak sama dengan basil for deposan
                        if ($data->basil_for_deposan_berjalan != $data->basil_for_deposan and $data->basil_for_deposan > $data->basil_for_deposan_berjalan) {

                            //Update ke database by id sumber dana
                            $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_deposan_berjalan' => $data->basil_for_deposan));
                        }
                    }
                }
            }

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
            redirect('admin/pembayaran');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Proses Gagal. Pinjaman telah lunas!</b></h6></div>');
            redirect('admin/pembayaran');
        }

    }

    function cetak_resi($id_riwayat_pembayaran)
    {
        // Get Data
        $riwayat_pembayaran = $this->Riwayatpembayaran_model->get_by_id($id_riwayat_pembayaran);
        $tanggungan = $riwayat_pembayaran->jml_pinjaman + $riwayat_pembayaran->total_biaya_sewa;

        // Import library FPDF
        require FCPATH . '/vendor/autoload.php';
        require FCPATH . '/vendor/setasign/fpdf/fpdf.php';

        // Rancang template struk pembayaran dengan ekstensi PDF
        $pdf = new FPDF('P', 'mm', array(75, 100));
        $pdf->SetTitle('Struk Transaksi Pembayaran Tunai - ' . $riwayat_pembayaran->no_invoice);
        $pdf->SetTopMargin(5);
        $pdf->SetLeftMargin(5);
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 8);
        $pdf->Cell(65, 3, strtoupper($riwayat_pembayaran->instansi_name), 0, 1, 'C');

        $pdf->SetFont('Arial', '', 7);

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(65, 4, '', 0, 1); //end of line

        $pdf->Cell(65, 3, 'STRUK TRANSAKSI', 0, 1, 'C');
        $pdf->Cell(65, 3, 'PEMBAYARAN TUNAI', 0, 1, 'C');

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(65, 5, '', 0, 1); //end of line

        $pdf->Cell(32.5, 3, 'KANTOR CABANG ' . strtoupper($riwayat_pembayaran->cabang_name), 0, 1, 'L');

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(65, 3, '', 0, 1); //end of line

        $pdf->Cell(22, 3, 'TANGGAL', 0, 0, 'L');
        $pdf->Cell(18, 3, 'WAKTU', 0, 0, 'L');
        $pdf->Cell(22, 3, 'PETUGAS', 0, 1, 'L');
        $pdf->Cell(22, 3, date_only2($riwayat_pembayaran->created_at), 0, 0, 'L');
        $pdf->Cell(18, 3, time_only($riwayat_pembayaran->created_at), 0, 0, 'L');
        $pdf->Cell(22, 3, $riwayat_pembayaran->created_by, 0, 1, 'L');

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(65, 5, '', 0, 1); //end of line

        $pdf->Cell(22, 3.5, 'NO INVOICE', 0, 0, 'L');
        $pdf->Cell(3, 3.5, ':', 0, 0, 'C');
        $pdf->Cell(40, 3.5, $riwayat_pembayaran->no_invoice, 0, 1, 'L');
        $pdf->Cell(22, 3.5, 'NO ANGGOTA', 0, 0, 'L');
        $pdf->Cell(3, 3.5, ':', 0, 0, 'C');
        $pdf->Cell(40, 3.5, $riwayat_pembayaran->no_pinjaman, 0, 1, 'L');
        $pdf->Cell(22, 3.5, 'BAYAR TUNAI', 0, 0, 'L');
        $pdf->Cell(3, 3.5, ':', 0, 0, 'C');
        $pdf->Cell(40, 3.5, 'RP. ' . number_format($riwayat_pembayaran->nominal, 0, ',', '.'), 0, 1, 'L');

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(65, 4, '', 0, 1); //end of line

        $pdf->Cell(22, 3.5, 'TANGGUNGAN', 0, 0, 'L');
        $pdf->Cell(3, 3.5, ':', 0, 0, 'C');
        $pdf->Cell(40, 3.5, 'RP. ' . number_format($tanggungan, 0, ',', '.'), 0, 1, 'L');
        $pdf->Cell(22, 3.5, 'TOTAL TERBAYAR', 0, 0, 'L');
        $pdf->Cell(3, 3.5, ':', 0, 0, 'C');
        $pdf->Cell(40, 3.5, 'RP. ' . number_format($riwayat_pembayaran->terbayar, 0, ',', '.'), 0, 1, 'L');
        $pdf->Cell(22, 3.5, 'KEKURANGAN', 0, 0, 'L');
        $pdf->Cell(3, 3.5, ':', 0, 0, 'C');
        $pdf->Cell(40, 3.5, 'RP. ' . number_format($riwayat_pembayaran->kekurangan_bayar, 0, ',', '.'), 0, 1, 'L');

        //make a dummy empty cell as a vertical spacer
        $pdf->Cell(65, 7, '', 0, 1); //end of line

        $pdf->Cell(65, 3, '--Resi ini adalah bukti transaksi yang sah--', 0, 1, 'C');
        $pdf->Cell(65, 3, '--Terima kasih--', 0, 1, 'C');

        $pdf->Output('I', 'Struk Transaksi Pembayaran Tunai - ' . $riwayat_pembayaran->no_invoice . '.pdf');
    }

    function pembayaran_anggota()
    {
        $this->data['page_title']       = 'Daftar Pinjaman Anda';
        $this->data['modal_action']     = 'admin/pembayaran/kirim_bukti_tf';

        $this->data['pinjaman'] = $this->Pembiayaan_model->get_all_pembiayaan_by_user($this->session->id_users);

        $this->data['id_pembiayaan'] = [
            'name'          => 'id_pembiayaan',
            'id'            => 'id_pembiayaan',
            'type'          => 'hidden',
        ];
        $this->data['id_instansi'] = [
            'name'          => 'id_instansi',
            'id'            => 'id_instansi',
            'type'          => 'hidden',
        ];
        $this->data['id_cabang'] = [
            'name'          => 'id_cabang',
            'id'            => 'id_cabang',
            'type'          => 'hidden',
        ];
        $this->data['no_pinjaman'] = [
            'name'          => 'no_pinjaman',
            'id'            => 'no_pinjaman',
            'type'          => 'hidden',
        ];

        $this->load->view('back/pembayaran/pembayaran_add_anggota', $this->data);
    }

    function riwayat_pembayaran_anggota()
    {
        $this->data['page_title']       = 'Riwayat Pembiayaan Anda';

        $this->data['get_all']          = $this->Pembiayaan_model->get_all_pembiayaan_by_anggota();

        $this->load->view('back/pembayaran/riwayat_pembayaran_anggota', $this->data);
    }

    function detail_riwayat($id_pembiayaan, $id_riwayat_pembayaran='')
    {
        $this->data['page_title']       = 'Riwayat Pembayaran Anda';

        if ($id_riwayat_pembayaran) {
            $this->Riwayatpembayaran_model->update($id_riwayat_pembayaran, array('is_read_anggota' => 1));
        }

        $this->data['pembiayaan']       = $this->Pembiayaan_model->get_by_id($id_pembiayaan);
        $this->data['get_all']          = $this->Riwayatpembayaran_model->get_all_riwayat_pembayaran_anggota_by_pembiayaan($id_pembiayaan);
        $this->data['tanggungan']       = $this->data['pembiayaan']->jml_pinjaman + $this->data['pembiayaan']->total_biaya_sewa;
        $this->data['kekurangan_bayar'] = $this->data['tanggungan'] - $this->data['pembiayaan']->jml_terbayar;

        $this->load->view('back/pembayaran/detail_riwayat_pembayaran_anggota', $this->data);
    }

    function get_image($image)
    {
        $this->data['image'] = $image;

        $this->load->view('back/pembayaran/v_image_by_riwayat_pembayaran', $this->data);
    }

    function kirim_bukti_tf()
    {
        if ($_FILES['photo']['error'] <> 4) {
            $nmfile = strtolower(url_title($this->input->post('no_pinjaman'))) . '-' . date('YmdHis');

            $config['upload_path']      = './assets/images/bukti_tf/';
            $config['allowed_types']    = 'jpg|jpeg|png';
            $config['max_size']         = 2048; // 2Mb
            $config['file_name']        = $nmfile;

            $this->load->library('upload', $config);

            if (!$this->upload->do_upload('photo')) {
                $error = array('error' => $this->upload->display_errors());
                $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

                $this->pembayaran_anggota();
            } else {
                $photo = $this->upload->data();

                //Generate kode/no invoice
                $get_last_id = (int) $this->db->query('SELECT max(id_riwayat_pembayaran) as last_id FROM riwayat_pembayaran')->row()->last_id;
                $get_last_id++;
                $random = mt_rand(10, 99);
                $no_invoice = $random . sprintf("%04s", $get_last_id);

                $data = array(
                    'no_invoice'        => $no_invoice,
                    'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                    'instansi_id'       => $this->session->instansi_id,
                    'cabang_id'         => $this->session->cabang_id,
                    'nominal'           => 0,
                    'terbayar'          => 0,
                    'kekurangan_bayar'  => 0,
                    'bukti_tf'          => $this->upload->data('file_name'),
                    'is_paid'           => 0,
                    'created_by'        => $this->session->username,
                );

                $this->Riwayatpembayaran_model->insert($data);

                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Konfirmasi pembayaran berhasil dikirim. Mohon menunggu proses Verifikasi oleh Admin.</b></h6></div>');
                redirect('admin/pembayaran/pembayaran_anggota');
            }
        }
    }

    function pembayaran_online()
    {
        $this->data['page_title'] = 'Verifikasi Pembayaran Online';

        $this->data['bayar_online'] = $this->Riwayatpembayaran_model->get_all_anggota_from_pembiayaan();

        $this->load->view('back/pembayaran/pembayaran_online_list', $this->data);
    }

    function get_bukti_tf($bukti_tf, $is_paid)
    {
        $this->data['image_bukti_tf'] = $bukti_tf;
        $this->data['is_paid'] = $is_paid;

        $this->data['nominal'] = [
            'name'          => 'nominal',
            'id'            => 'nominal',
            'class'         => 'form-control',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nominal'),
        ];

        $this->load->view('back/pembayaran/v_image_bukti_tf', $this->data);
    }

    function verifikasi_action()
    {
        $this->form_validation->set_rules('nominal', 'Nominal Pembayaran', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->pembayaran_online();
        } else {
            //Ubah tipe data nominal cicilan
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
                    redirect('admin/pembayaran/pembayaran_online');
                } else {
                    //Update data jml terbayar pada tabel pembiayaan by id
                    $this->Pembiayaan_model->update($this->input->post('id_pembiayaan'), array('jml_terbayar' => $result));

                    //Ubah status pembayaran menjadi lunas jika jml_tanggungan sama dengan jml_terbayar
                    $jml_terbayar_now = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'))->jml_terbayar;

                    // Pengkondisian jika pinjaman telah lunas
                    if ($jml_tanggungan == $jml_terbayar_now) {
                        //Update data status pembayaran pada tabel pembiayaan by id
                        $this->Pembiayaan_model->update($this->input->post('id_pembiayaan'), array('status_pembayaran' => 1));

                        if ($pembiayaan->sumber_dana == 1) {
                            // MANIPULASI DATA INSTANSI
                            // Update data instansi untuk dikembalikan nominal yg dipinjam
                            $data_instansi = $this->Instansi_model->get_by_id($pembiayaan->instansi_id);

                            // Menghitung jml resapan terbaru setelah dikembalikan
                            $resapan_tabungan = $data_instansi->resapan_tabungan - $pembiayaan->jml_pinjaman;

                            // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                            $saldo_tabungan = $data_instansi->saldo_tabungan + $pembiayaan->jml_pinjaman;

                            $data = array(
                                'saldo_tabungan'    => $saldo_tabungan,
                                'resapan_tabungan'  => $resapan_tabungan,
                            );

                            $this->Instansi_model->update($pembiayaan->instansi_id, $data);

                            // MANIPULASI DATA CABANG
                            // Update data cabang untuk dikembalikan nominal yg dipinjam
                            $data_cabang = $this->Cabang_model->get_by_id($pembiayaan->cabang_id);

                            // Menghitung jml resapan terbaru setelah dikembalikan
                            $resapan_tabungan = $data_cabang->resapan_tabungan - $pembiayaan->jml_pinjaman;

                            // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                            $saldo_tabungan = $data_cabang->saldo_tabungan + $pembiayaan->jml_pinjaman;

                            $data = array(
                                'saldo_tabungan'    => $saldo_tabungan,
                                'resapan_tabungan'  => $resapan_tabungan,
                            );

                            $this->Cabang_model->update($pembiayaan->cabang_id, $data);

                        } elseif ($pembiayaan->sumber_dana == 2) {
                            // MANIPULASI DATA DEPOSITO
                            // Update data deposito untuk dikembalikan nominal yg dipinjam
                            $sumber_dana_deposito = $this->Sumberdana_model->get_deposan_by_pembiayaan($pembiayaan->id_pembiayaan);

                            // Karena deposito dalam satu pinjaman bisa lebih dari satu maka lakukan perulangan
                            foreach ($sumber_dana_deposito as $data) {
                                $data_deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                                // Menghitung jml resapan terbaru setelah dikembalikan
                                $resapan_deposito = $data_deposito->resapan_deposito - $data->nominal;

                                // Menghitung jml saldo depostio terbaru setelah dikembalikan
                                $saldo_deposito = $data_deposito->saldo_deposito + $data->nominal;

                                $change_data = array(
                                    'saldo_deposito'    => $saldo_deposito,
                                    'resapan_deposito'  => $resapan_deposito,
                                );

                                $this->Deposito_model->update($data->deposito_id, $change_data);
                            }
                        } elseif ($pembiayaan->sumber_dana == 3) {
                            $sumber_dana_tabungan = $this->Sumberdana_model->get_tabungan_by_pembiayaan($pembiayaan->id_pembiayaan);

                            foreach ($sumber_dana_tabungan as $data) {
                                // MANIPULASI DATA INSTANSI
                                // Update data instansi untuk dikembalikan nominal yg dipinjam
                                $data_instansi = $this->Instansi_model->get_by_id($pembiayaan->instansi_id);

                                // Menghitung jml resapan terbaru setelah dikembalikan
                                $resapan_tabungan = $data_instansi->resapan_tabungan - $data->nominal;

                                // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                                $saldo_tabungan = $data_instansi->saldo_tabungan + $data->nominal;

                                $change_data = array(
                                    'saldo_tabungan'    => $saldo_tabungan,
                                    'resapan_tabungan'  => $resapan_tabungan,
                                );

                                $this->Instansi_model->update($pembiayaan->instansi_id, $change_data);

                                // MANIPULASI DATA CABANG
                                // Update data cabang untuk dikembalikan nominal yg dipinjam
                                $data_cabang = $this->Cabang_model->get_by_id($pembiayaan->cabang_id);

                                // Menghitung jml resapan terbaru setelah dikembalikan
                                $resapan_tabungan = $data_cabang->resapan_tabungan - $data->nominal;

                                // Menghitung jml saldo tabungan terbaru setelah dikembalikan
                                $saldo_tabungan = $data_cabang->saldo_tabungan + $data->nominal;

                                $change_data = array(
                                    'saldo_tabungan'    => $saldo_tabungan,
                                    'resapan_tabungan'  => $resapan_tabungan,
                                );

                                $this->Cabang_model->update($pembiayaan->cabang_id, $change_data);
                            }

                            // MANIPULASI DATA DEPOSITO
                            // Update data deposito untuk dikembalikan nominal yg dipinjam
                            $sumber_dana_deposito = $this->Sumberdana_model->get_deposan_by_pembiayaan($pembiayaan->id_pembiayaan);

                            // Karena deposito dalam satu pinjaman bisa lebih dari satu maka lakukan perulangan
                            foreach ($sumber_dana_deposito as $data) {
                                $data_deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                                // Menghitung jml resapan terbaru setelah dikembalikan
                                $resapan_deposito = $data_deposito->resapan_deposito - $data->nominal;

                                // Menghitung jml saldo depostio terbaru setelah dikembalikan
                                $saldo_deposito = $data_deposito->saldo_deposito + $data->nominal;

                                $change_data = array(
                                    'saldo_deposito'    => $saldo_deposito,
                                    'resapan_deposito'  => $resapan_deposito,
                                );

                                $this->Deposito_model->update($data->deposito_id, $change_data);
                            }
                        }
                    }

                    //Tambah Riwayat Pembayaran Baru
                    //Generate kode/no invoice
                    $get_last_id = (int) $this->db->query('SELECT max(id_riwayat_pembayaran) as last_id FROM riwayat_pembayaran')->row()->last_id;
                    $get_last_id++;
                    $random = mt_rand(10, 99);
                    $no_invoice = $random . sprintf("%04s", $get_last_id);

                    if (is_grandadmin()) {
                        $instansi = $this->input->post('id_instansi');
                        $cabang = $this->input->post('id_cabang');
                    } elseif (is_masteradmin()) {
                        $instansi = $this->session->instansi_id;
                        $cabang = $this->input->post('id_cabang');
                    } elseif (is_superadmin()) {
                        $instansi = $this->session->instansi_id;
                        $cabang = $this->session->cabang_id;
                    }

                    $kekurangan = $jml_tanggungan - $jml_terbayar_now;

                    $data = array(
                        'nominal'           => $nominal_cicilan,
                        'terbayar'          => $jml_terbayar_now,
                        'kekurangan_bayar'  => $kekurangan,
                        'is_paid'           => 1,
                        'verificated_by'    => $this->session->username,
                        'verificated_at'    => date('Y-m-d H:i:a'),
                    );

                    $this->Riwayatpembayaran_model->update($this->input->post('id_riwayat_pembayaran'), $data);

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
                        //Get data sumber dana by pembiayaan id
                        $sumber_dana = $this->Sumberdana_model->cek_available_data($this->input->post('id_pembiayaan'));

                        //Lakukan perulangan data sumberdana by pembiayaan id
                        foreach($sumber_dana as $data) {
                            $nominal_per_deposan = $nominal_cicilan * $data->persentase/100;
                            //Jika basil_for_lembaga_berjalan tidak sama dengan basil for lembaga
                            if ($data->basil_for_lembaga_berjalan != $data->basil_for_lembaga and $data->basil_for_lembaga > $data->basil_for_lembaga_berjalan) {

                                //Tambahkan basil for lembaga berjalan dengan nominal inputan form
                                if ($data->deposito_id != NULL) {
                                    $basil_lembaga = $data->basil_for_lembaga_berjalan + ($nominal_per_deposan*70/100);
                                } else {
                                    $basil_lembaga = $data->basil_for_lembaga_berjalan + $nominal_per_deposan;
                                }

                                //Nominal cicilan lebih besar dari basil for lembaga
                                if ($basil_lembaga > $data->basil_for_lembaga) {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                                } else {
                                    //Update ke database by id sumber dana
                                    $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $basil_lembaga));
                                }

                            }

                            if ($data->deposito_id != NULL) {
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
                        }
                    }

                    write_log();

                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Pembayaran Berhasil Diverifikasi!</b></h6></div>');
                    redirect('admin/pembayaran/pembayaran_online');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Proses Gagal. Pinjaman telah lunas!</b></h6></div>');
                redirect('admin/pembayaran/pembayaran_online');
            }
        }
    }

    function delete_by_user($id_user)
    {
        is_delete();

        $delete = $this->Riwayatpembayaran_model->get_all_pembayaran_online_by_anggota($id_user);

        if ($delete) {
            foreach ($delete as $data) {
                $this->Riwayatpembayaran_model->delete($data->id_riwayat_pembayaran);
            }

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus Secara Permanen!</b></h6></div>');

            redirect('admin/pembayaran/pembayaran_online');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');

            redirect('admin/pembayaran/pembayaran_online');
        }
    }

    function delete_permanent($id)
    {
        is_delete();

        $delete = $this->Riwayatpembayaran_model->get_by_id($id);

        if ($delete) {
            $this->Riwayatpembayaran_model->delete($id);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus Secara Permanen!</b></h6></div>');
            redirect('admin/pembayaran/detail_pembayaran_online/' . $delete->user_id);
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/pembayaran/detail_pembayaran_online/' . $delete->user_id);
        }
    }
}
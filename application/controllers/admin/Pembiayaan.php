<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembiayaan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        $this->data['module'] = 'Pinjaman';

        $this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);

        $this->data['btn_submit'] = 'Save';
        $this->data['btn_reset']  = 'Reset';
        $this->data['btn_add']    = 'Tambah Data';
        $this->data['add_action'] = base_url('admin/pembiayaan/create');

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
            $this->data['get_all'] = $this->Pembiayaan_model->get_all_anggota_from_pembiayaan();
            $this->data['get_total_pinjaman'] = $this->Pembiayaan_model->total_pinjaman();
			$this->data['get_biaya_sewa'] = $this->Pembiayaan_model->biaya_sewa();
        } elseif (is_masteradmin()) {
            $this->data['get_all'] = $this->Pembiayaan_model->get_all_anggota_from_pembiayaan_by_instansi();
            $this->data['get_total_pinjaman'] = $this->Pembiayaan_model->total_pinjaman_by_instansi();
			$this->data['get_biaya_sewa'] = $this->Pembiayaan_model->biaya_sewa_by_instansi();
        } elseif (is_superadmin()) {
            $this->data['get_all'] = $this->Pembiayaan_model->get_all_anggota_from_pembiayaan_by_cabang();
            $this->data['get_total_pinjaman'] = $this->Pembiayaan_model->total_pinjaman_by_cabang();
			$this->data['get_biaya_sewa'] = $this->Pembiayaan_model->biaya_sewa_by_cabang();
        }

        $this->load->view('back/pembiayaan/pembiayaan_list', $this->data);
    }

    function detail($id_user)
    {
        $this->data['page_title'] = 'Detail ' . $this->data['module'];

        $this->data['pembiayaan'] = $this->Pembiayaan_model->get_all_pembiayaan_by_user($id_user);

        $this->data['anggota'] = $this->Auth_model->get_anggota_by_id($id_user);

        $this->data['total_pinjaman'] = $this->Pembiayaan_model->total_pinjaman_by_user($id_user);

        $this->data['biaya_sewa'] = $this->Pembiayaan_model->biaya_sewa_by_user($id_user);

        $this->data['tanggungan'] = $this->data['biaya_sewa'][0]->biaya_sewa + $this->data['total_pinjaman'][0]->jml_pinjaman;

        $this->data['terbayar'] = $this->Pembiayaan_model->total_terbayar_by_user($id_user);

        $this->data['kekurangan_bayar'] = $this->data['tanggungan'] - $this->data['terbayar'][0]->jml_terbayar;

        $this->data['action']     = 'admin/pembiayaan/update_action';

        $this->data['id_pembiayaan'] = [
            'name'          => 'id_pembiayaan',
            'id'            => 'id_pembiayaan',
            'type'          => 'hidden',
        ];
        $this->data['jml_pinjaman'] = [
            'name'          => 'jml_pinjaman',
            'id'            => 'jml_pinjaman',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('jml_pinjaman'),
        ];
        $this->data['jangka_waktu_pinjam'] = [
            'name'          => 'jangka_waktu_pinjam',
            'id'            => 'jangka_waktu_pinjam',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('jangka_waktu_pinjam'),
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['jenis_barang_gadai'] = [
            'name'          => 'jenis_barang_gadai',
            'id'            => 'jenis_barang_gadai',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('jenis_barang_gadai'),
        ];
        $this->data['berat_barang_gadai'] = [
            'name'          => 'berat_barang_gadai',
            'id'            => 'berat_barang_gadai',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('berat_barang_gadai'),
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['waktu_gadai'] = [
            'name'          => 'waktu_gadai',
            'id'            => 'waktu_gadai',
            'class'         => 'input-sm form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('waktu_gadai'),
            'readonly'      => '',
        ];
        $this->data['jatuh_tempo_gadai'] = [
            'name'          => 'jatuh_tempo_gadai',
            'id'            => 'jatuh_tempo_gadai',
            'class'         => 'input-sm form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('jatuh_tempo_gadai'),
            'readonly'      => '',
        ];
        $this->data['sistem_pembayaran_sewa'] = [
            'name'          => 'sistem_pembayaran_sewa',
            'id'            => 'sistem_pembayaran_sewa',
            'class'         => 'form-control',
            'required'      => '',
            'value'         => $this->form_validation->set_value('sistem_pembayaran_sewa'),
        ];
        $this->data['sistem_pembayaran_sewa_value'] = [
            ''              => '- Pilih Sistem Pembayaran -',
            '1'             => 'Bulanan',
            '2'             => 'Jatuh Tempo',
        ];

        $this->load->view('back/pembiayaan/pembiayaan_detail', $this->data);
    }

    function create()
    {
        is_create();

        $this->data['page_title'] = 'Tambah Data ' . $this->data['module'];
        $this->data['action']     = 'admin/pembiayaan/create_forward';

        $this->data['pilih_pinjaman'] = [
            'name'          => 'pilih_pinjaman',
            'id'            => 'pilih_pinjaman',
            'class'         => 'form-control',
            'required'      => '',
            'onChange'      => 'tampilForm()',
        ];
        $this->data['pilih_pinjaman_value'] = [
            ''              => '- Buat Pinjaman -',
            '1'             => 'Anggota Baru',
            '2'             => 'Anggota Lama',
        ];

        $this->load->view('back/pembiayaan/pembiayaan_add', $this->data);
    }

    function create_forward()
    {
        if (is_grandadmin()) {
            $this->form_validation->set_rules('instansi_id', 'Instansi', 'required');
            $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');
        } elseif (is_masteradmin()) {
            $this->form_validation->set_rules('cabang_id', 'Cabang', 'required');
        }
        $this->form_validation->set_rules('name', 'Nama', 'trim|required');
        $this->form_validation->set_rules('nik', 'NIK', 'is_numeric|required');
        $this->form_validation->set_rules('address', 'Alamat', 'required');
        $this->form_validation->set_rules('email', 'Email', 'valid_email|required');
        $this->form_validation->set_rules('phone', 'No. HP/Telephone', 'is_numeric|required');
        $this->form_validation->set_rules('jml_pinjaman', 'Jumlah Pinjaman', 'required');
        $this->form_validation->set_rules('jangka_waktu_pinjam', 'Jangka Waktu Pinjaman', 'is_numeric|required');
        $this->form_validation->set_rules('jenis_barang_gadai', 'Jenis Barang Yang Digadai', 'required');
        $this->form_validation->set_rules('berat_barang_gadai', 'Berat/Nilai Barang Yang Digadai', 'is_numeric|required');
        $this->form_validation->set_rules('waktu_gadai', 'Waktu Gadai', 'required');
        $this->form_validation->set_rules('jatuh_tempo_gadai', 'Jatuh Tempo Gadai', 'required');
        $this->form_validation->set_rules('sistem_pembayaran_sewa', 'Sistem Pembayaran Sewa', 'required');
        $this->form_validation->set_rules('sumber_dana', 'Sumber Dana', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('is_numeric', '{field} harus angka');
        $this->form_validation->set_message('valid_email', '{field} format email tidak benar');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->create();
        } else {
            if ($_FILES['photo']['error'] <> 4) {
                $nmfile = strtolower(url_title($this->input->post('name'))) . date('YmdHis');

                $config['upload_path']      = './assets/images/barang_gadai/';
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

                    //SIMPAN DATA ANGGOTA PEMINJAM
                    //Generate kode/no pinjaman
                    $kode_huruf = 'P';
                    $get_no_urut = $this->db->query('SELECT max(no_pinjaman) as kodeTerbesar FROM pembiayaan')->result();
                    $urutan = (int) substr($get_no_urut[0]->kodeTerbesar, 1, 5);
                    $urutan++;
                    $no_pinjaman = $kode_huruf . sprintf("%05s", $urutan);

                    // Ubah format tanggal
                    $waktu_gadai = date("Y-m-d", strtotime($this->input->post('waktu_gadai')));
                    $jatuh_tempo_gadai = date("Y-m-d", strtotime($this->input->post('jatuh_tempo_gadai')));
                    // //Menentukan jangka waktu gadai
                    // $waktu_gadai = strtotime($this->input->post('waktu_gadai'));
                    // $jatuh_tempo_gadai = strtotime($this->input->post('jatuh_tempo_gadai'));
                    // // Hitung semua bulan pada tahun sebelumnya
                    // $jangka_waktu_gadai = (date("Y", $jatuh_tempo_gadai) - date("Y", $waktu_gadai)) * 12;
                    // // menghitung selisih bulan
                    // $jangka_waktu_gadai += date("m", $jatuh_tempo_gadai) - date("m", $waktu_gadai);

                    //Menentukan sewa tempat perbulan
                    $sewa_tempat_perbulan = 10000 * $this->input->post('berat_barang_gadai');

                    //Menentukan total biaya sewa
                    $total_biaya_sewa = $sewa_tempat_perbulan * $this->input->post('jangka_waktu_pinjam');

                    //Ubah tipe data jml pinjaman
                    $string = $this->input->post('jml_pinjaman');
                    $jml_pinjaman = preg_replace("/[^0-9]/", "", $string);

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

                    if ($this->input->post('pilih_pinjaman') == 1) {
                        //Generate kode/no anggota
                        $kode_huruf = 'A';
                        $get_no_urut = $this->db->query('SELECT max(no_anggota) as kodeTerbesar FROM users')->result();
                        $urutan = (int) substr($get_no_urut[0]->kodeTerbesar, 1, 5);
                        $urutan++;
                        $no_anggota = $kode_huruf . sprintf("%05s", $urutan);

                        //Format no telephone
                        $phone = '62' . $this->input->post('phone');

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
                            'usertype_id'       => 4,
                            'created_by'        => $this->session->username,
                            'ip_add_reg'        => $this->input->ip_address(),
                            'photo'             => 'noimage.jpg',
                        );

                        $this->Auth_model->insert($data);

                        $user_id = $this->db->insert_id();

                        //Tambah Pembiayaan
                        $data = array(
                            'no_pinjaman'               => $no_pinjaman,
                            'name'                      => $this->input->post('name'),
                            'nik'                       => $this->input->post('nik'),
                            'address'                   => $this->input->post('address'),
                            'email'                     => $this->input->post('email'),
                            'phone'                     => $phone,
                            'user_id'                   => $user_id,
                            'instansi_id'               => $instansi,
                            'cabang_id'                 => $cabang,
                            'jml_pinjaman'              => (int) $jml_pinjaman,
                            'jangka_waktu_pinjam'       => $this->input->post('jangka_waktu_pinjam'),
                            'jenis_barang_gadai'        => $this->input->post('jenis_barang_gadai'),
                            'berat_barang_gadai'        => $this->input->post('berat_barang_gadai'),
                            'waktu_gadai'               => $waktu_gadai,
                            'jatuh_tempo_gadai'         => $jatuh_tempo_gadai,
                            'jangka_waktu_gadai'        => $this->input->post('jangka_waktu_pinjam'),
                            'sewa_tempat_perbulan'      => $sewa_tempat_perbulan,
                            'total_biaya_sewa'          => $total_biaya_sewa,
                            'sistem_pembayaran_sewa'    => $this->input->post('sistem_pembayaran_sewa'),
                            'sumber_dana'               => $this->input->post('sumber_dana'),
                            'image'                     => $this->upload->data('file_name'),
                            'created_by'                => $this->session->username,
                        );

                        $this->Pembiayaan_model->insert($data);

                        $id_anggota = $this->db->insert_id();
                    } elseif ($this->input->post('pilih_pinjaman') == 2) {
                        //Format no telephone
                        $phone = $this->input->post('phone');

                        //Tambah Pembiayaan
                        $data = array(
                            'no_pinjaman'               => $no_pinjaman,
                            'name'                      => $this->input->post('name'),
                            'nik'                       => $this->input->post('nik'),
                            'address'                   => $this->input->post('address'),
                            'email'                     => $this->input->post('email'),
                            'phone'                     => $phone,
                            'user_id'                   => $this->input->post('user_id'),
                            'instansi_id'               => $instansi,
                            'cabang_id'                 => $cabang,
                            'jml_pinjaman'              => (int) $jml_pinjaman,
                            'jangka_waktu_pinjam'       => $this->input->post('jangka_waktu_pinjam'),
                            'jenis_barang_gadai'        => $this->input->post('jenis_barang_gadai'),
                            'berat_barang_gadai'        => $this->input->post('berat_barang_gadai'),
                            'waktu_gadai'               => $waktu_gadai,
                            'jatuh_tempo_gadai'         => $jatuh_tempo_gadai,
                            'jangka_waktu_gadai'        => $this->input->post('jangka_waktu_pinjam'),
                            'sewa_tempat_perbulan'      => $sewa_tempat_perbulan,
                            'total_biaya_sewa'          => $total_biaya_sewa,
                            'sistem_pembayaran_sewa'    => $this->input->post('sistem_pembayaran_sewa'),
                            'sumber_dana'               => $this->input->post('sumber_dana'),
                            'image'                     => $this->upload->data('file_name'),
                            'created_by'                => $this->session->username,
                        );

                        $this->Pembiayaan_model->insert($data);

                        $id_anggota = $this->db->insert_id();
                    }

                    write_log();

                    if ($this->input->post('sumber_dana') == 1) {
                        $array_session = array(
                            'id_anggota'            => $id_anggota,
                            'nama_anggota'          => $this->input->post('name'),
                            'jml_pinjaman'          => $jml_pinjaman,
                            'instansi'              => $instansi,
                            'cabang'                => $cabang,
                        );

                        $this->session->set_userdata($array_session);

                        redirect('admin/pembiayaan/sumber_dana_tabungan');
                    } elseif ($this->input->post('sumber_dana') == 2) {
                        $array_session = array(
                            'id_anggota'            => $id_anggota,
                            'nama_anggota'          => $this->input->post('name'),
                            'jml_pinjaman'          => $jml_pinjaman,
                            'total_pinjaman'        => $jml_pinjaman,
                            'status_sumber_dana'    => $this->input->post('sumber_dana'),
                            'instansi'              => $instansi,
                            'cabang'                => $cabang,
                            'id_deposito'           => array(),
                            'persentase_deposito'   => array(),
                            'nama_deposan'          => array(),
                            'nominal_deposito'      => array(),
                        );

                        $this->session->set_userdata($array_session);

                        redirect('admin/pembiayaan/sumber_dana_deposito');
                    } elseif ($this->input->post('sumber_dana') == 3) {
                        $array_session = array(
                            'id_anggota'            => $id_anggota,
                            'nama_anggota'          => $this->input->post('name'),
                            'jml_pinjaman'          => $jml_pinjaman,
                            'total_pinjaman'        => $jml_pinjaman,
                            'status_sumber_dana'    => $this->input->post('sumber_dana'),
                            'instansi'              => $instansi,
                            'cabang'                => $cabang,
                            'persentase_tabungan'   => 100,
                            'id_deposito'           => array(),
                            'persentase_deposito'   => array(),
                            'nama_deposan'          => array(),
                            'nominal_deposito'      => array(),
                        );

                        $this->session->set_userdata($array_session);

                        redirect('admin/pembiayaan/sumber_dana_tabungan_deposito');
                    }
                }
            }
        }
    }

    function create_action()
    {
        $instansi = $this->Instansi_model->get_by_id($this->input->post('instansi_id'));
        $cabang = $this->Cabang_model->get_by_id($this->input->post('cabang_id'));

        if ($this->input->post('sumber_dana') == 1) {
            $pembiayaan = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'));

            //Cek ketersediaan saldo tabungan
            $saldo_tabungan = $cabang->saldo_tabungan - $this->session->jml_pinjaman;

            if ($saldo_tabungan >= 0) {
                $data_sumber_dana = array(
                    'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                    'deposito_id'       => NULL,
                    'persentase'        => 100,
                    'nominal'           => $this->session->jml_pinjaman,
                    'total_basil'       => $pembiayaan->total_biaya_sewa,
                    'basil_for_lembaga' => $pembiayaan->total_biaya_sewa,
                    'created_by'        => $this->session->username,
                );

                $this->db->insert('sumber_dana', $data_sumber_dana);

                write_log();

                //MANIPULASI DATA INSTANSI
                $resapan_tabungan_instansi = $instansi->resapan_tabungan + $this->session->jml_pinjaman;
                $saldo_tabungan_instansi = $instansi->saldo_tabungan - $this->session->jml_pinjaman;

                $data = array(
                    'saldo_tabungan'    => $saldo_tabungan_instansi,
                    'resapan_tabungan'  => $resapan_tabungan_instansi,
                );

                $this->Instansi_model->update($this->input->post('instansi_id'), $data);

                //MANIPULASI DATA CABANG
                $resapan_tabungan_cabang = $cabang->resapan_tabungan + $this->session->jml_pinjaman;
                $saldo_tabungan_cabang = $cabang->saldo_tabungan - $this->session->jml_pinjaman;

                $data = array(
                    'saldo_tabungan'    => $saldo_tabungan_cabang,
                    'resapan_tabungan'  => $resapan_tabungan_cabang,
                );

                $this->Cabang_model->update($this->input->post('cabang_id'), $data);

                $this->session->unset_userdata('id_anggota');
                $this->session->unset_userdata('nama_anggota');
                $this->session->unset_userdata('jml_pinjaman');
                $this->session->unset_userdata('instansi');
                $this->session->unset_userdata('cabang');
            } else {
                //Hapus file di direktori images
                $dir        = "./assets/images/barang_gadai/" . $pembiayaan->image;

                if (is_file($dir)) {
                    unlink($dir);
                }

                $this->Pembiayaan_model->delete($this->input->post('id_pembiayaan'));

                $this->Auth_model->delete($pembiayaan->user_id);

                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Proses Gagal. Saldo Tabungan Tidak Cukup!</b></h6></div>');
                redirect('admin/pembiayaan');
            }

        } elseif ($this->input->post('sumber_dana') == 2) {
            //Jalankan fitur add atau update
            //Dengan mengecek apakah di database sumber dana sudah ada datanya, jika sudah ada data berdasarkan pembiayaan id lakukan update dan jika tidak ada data lakukan add
            $sumber_dana = $this->Sumberdana_model->cek_available_data($this->input->post('id_pembiayaan'));

            if ($sumber_dana) {
                //Jalankan fitur update
                //Ambil nominal pada pembiayaan_id yang bersangkutan dan deposito_id dengan value NULL
                $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
                $this->db->where('deposito_id', NULL);
                $sumber_dana_tabungan = $this->db->get('sumber_dana')->row();

                if ($sumber_dana_tabungan) {
                    //MANIPULASI DATA INSTANSI
                    $saldo_tabungan_instansi = $instansi->saldo_tabungan + $sumber_dana_tabungan->nominal;
                    $resapan_tabungan_instansi = $instansi->resapan_tabungan - $sumber_dana_tabungan->nominal;

                    $data = array(
                        'saldo_tabungan'    => $saldo_tabungan_instansi,
                        'resapan_tabungan'  => $resapan_tabungan_instansi,
                    );

                    $this->Instansi_model->update($this->input->post('instansi_id'), $data);

                    //MANIPULASI DATA CABANG
                    $saldo_tabungan_cabang = $cabang->saldo_tabungan + $sumber_dana_tabungan->nominal;
                    $resapan_tabungan_cabang = $cabang->resapan_tabungan - $sumber_dana_tabungan->nominal;

                    $data = array(
                        'saldo_tabungan'    => $saldo_tabungan_cabang,
                        'resapan_tabungan'  => $resapan_tabungan_cabang,
                    );

                    $this->Cabang_model->update($this->input->post('cabang_id'), $data);
                }

                //Ambil nominal pada pembiayaan_id yang bersangkutan dan deposito_id dengan value not null
                $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
                $this->db->where('deposito_id !=', NULL);
                $sumber_dana_deposito = $this->db->get('sumber_dana')->result();

                if ($sumber_dana_deposito) {
                    //Perulangan masing2 id_deposito untuk manipulasi saldo dan resapan deposito
                    for ($i = 0; $i < count($sumber_dana_deposito); $i++) {
                        //Manipulasi saldo dan resapan deposito
                        //Ambil data deposito by id
                        $deposito = $this->Deposito_model->get_by_id($sumber_dana_deposito[$i]->deposito_id);

                        $saldo_deposito = (int) $deposito->saldo_deposito + (int) $sumber_dana_deposito[$i]->nominal;
                        $resapan_deposito = $deposito->resapan_deposito - $sumber_dana_deposito[$i]->nominal;

                        $data_deposito[$i] = array(
                            'saldo_deposito'    => $saldo_deposito,
                            'resapan_deposito'  => $resapan_deposito,
                        );

                        $this->Deposito_model->update($sumber_dana_deposito[$i]->deposito_id, $data_deposito[$i]);
                    }
                }

                //Hapus current data sumber dana by pembiayaan_id
                $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
                $this->db->delete('sumber_dana');

                if (!empty($this->session->id_deposito)) {
                    //Simpan sumber dana deposito baru
                    $count_deposito_id = count($this->session->id_deposito);

                    $pembiayaan = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'));

                    for ($i = 0; $i < $count_deposito_id; $i++) {
                        $total_basil = $this->session->persentase_deposito[$i] * $pembiayaan->total_biaya_sewa / 100;

                        $basil_for_lembaga = 70 * $total_basil / 100;
                        $basil_for_deposan = 30 * $total_basil / 100;

                        $data[$i] = array(
                            'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                            'deposito_id'       => $this->session->id_deposito[$i],
                            'persentase'        => $this->session->persentase_deposito[$i],
                            'nominal'           => $this->session->nominal_deposito[$i],
                            'total_basil'       => $total_basil,
                            'basil_for_lembaga' => $basil_for_lembaga,
                            'basil_for_deposan' => $basil_for_deposan,
                            'created_by'        => $this->session->username,
                        );

                        $this->db->insert('sumber_dana', $data[$i]);

                        write_log();

                        //Manipulasi data deposito
                        $deposito = $this->Deposito_model->get_by_id($this->session->id_deposito[$i]);

                        $saldo_deposito = (int) $deposito->saldo_deposito - (int) $this->session->nominal_deposito[$i];
                        $resapan_deposito = $deposito->resapan_deposito + $this->session->nominal_deposito[$i];

                        $data_deposito = array(
                            'saldo_deposito'    => $saldo_deposito,
                            'resapan_deposito'  => $resapan_deposito,
                        );

                        $this->Deposito_model->update($this->session->id_deposito[$i], $data_deposito);
                    }
                }

                //Ubah kolom sumber dana pada data pembiayaan by id pembiayaan
                $this->Pembiayaan_model->update($this->input->post('id_pembiayaan'), array('sumber_dana' => 2));

            } else {
                //Jalankan fitur add
                if (!empty($this->session->id_deposito)) {
                    $count_deposito_id = count($this->session->id_deposito);

                    $pembiayaan = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'));

                    for ($i = 0; $i < $count_deposito_id; $i++) {
                        $total_basil = $this->session->persentase_deposito[$i] * $pembiayaan->total_biaya_sewa / 100;

                        $basil_for_lembaga = 70 * $total_basil / 100;
                        $basil_for_deposan = 30 * $total_basil / 100;

                        $data[$i] = array(
                            'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                            'deposito_id'       => $this->session->id_deposito[$i],
                            'persentase'        => $this->session->persentase_deposito[$i],
                            'nominal'           => $this->session->nominal_deposito[$i],
                            'total_basil'       => $total_basil,
                            'basil_for_lembaga' => $basil_for_lembaga,
                            'basil_for_deposan' => $basil_for_deposan,
                            'created_by'        => $this->session->username,
                        );

                        $this->db->insert('sumber_dana', $data[$i]);

                        write_log();

                        //Manipulasi total deposito
                        $deposito = $this->Deposito_model->get_by_id($this->session->id_deposito[$i]);
                        $saldo_deposito = (int) $deposito->saldo_deposito - (int) $this->session->nominal_deposito[$i];
                        $resapan_deposito = $deposito->resapan_deposito + $this->session->nominal_deposito[$i];

                        $data_deposito = array(
                            'saldo_deposito'    => $saldo_deposito,
                            'resapan_deposito'  => $resapan_deposito,
                        );

                        $this->Deposito_model->update($this->session->id_deposito[$i], $data_deposito);
                    }
                }
            }

            $this->session->unset_userdata('id_anggota');
            $this->session->unset_userdata('nama_anggota');
            $this->session->unset_userdata('jml_pinjaman');
            $this->session->unset_userdata('total_pinjaman');
            $this->session->unset_userdata('status_sumber_dana');
            $this->session->unset_userdata('id_deposito');
            $this->session->unset_userdata('persentase_deposito');
            $this->session->unset_userdata('nama_deposan');
            $this->session->unset_userdata('nominal_deposito');
            $this->session->unset_userdata('instansi');
            $this->session->unset_userdata('cabang');
        } elseif ($this->input->post('sumber_dana') == 3) {
            //Jalankan fitur add atau update
            //Dengan mengecek apakah di database sumber dana sudah ada datanya, jika sudah ada data berdasarkan pembiayaan id lakukan update dan jika tidak ada data lakukan add
            $sumber_dana = $this->Sumberdana_model->cek_available_data($this->input->post('id_pembiayaan'));
            $pembiayaan = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'));

            if ($sumber_dana) {
                //Jalankan fitur update
                //Manipulasi data lama
                //Ambil nominal pada pembiayaan_id yang bersangkutan dan deposito_id dengan value NULL
                $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
                $this->db->where('deposito_id', NULL);
                $sumber_dana_tabungan = $this->db->get('sumber_dana')->row();

                if ($sumber_dana_tabungan) {
                    //MANIPULASI DATA INSTANSI
                    $saldo_tabungan_instansi = $instansi->saldo_tabungan + $sumber_dana_tabungan->nominal;
                    $resapan_tabungan_instansi = $instansi->resapan_tabungan - $sumber_dana_tabungan->nominal;

                    $data = array(
                        'saldo_tabungan'    => $saldo_tabungan_instansi,
                        'resapan_tabungan'  => $resapan_tabungan_instansi,
                    );

                    $this->Instansi_model->update($this->input->post('instansi_id'), $data);

                    //MANIPULASI DATA CABANG
                    $saldo_tabungan_cabang = $cabang->saldo_tabungan + $sumber_dana_tabungan->nominal;
                    $resapan_tabungan_cabang = $cabang->resapan_tabungan - $sumber_dana_tabungan->nominal;

                    $data = array(
                        'saldo_tabungan'    => $saldo_tabungan_cabang,
                        'resapan_tabungan'  => $resapan_tabungan_cabang,
                    );

                    $this->Cabang_model->update($this->input->post('cabang_id'), $data);
                }

                //Ambil nominal pada pembiayaan_id yang bersangkutan dan deposito_id dengan value not null
                $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
                $this->db->where('deposito_id !=', NULL);
                $sumber_dana_deposito = $this->db->get('sumber_dana')->result();

                if ($sumber_dana_deposito) {
                    //Perulangan masing2 id_deposito untuk manipulasi saldo dan resapan deposito (data lama)
                    for ($i = 0; $i < count($sumber_dana_deposito); $i++) {
                        //Manipulasi saldo dan resapan deposito
                        //Ambil data deposito by id
                        $deposito = $this->Deposito_model->get_by_id($sumber_dana_deposito[$i]->deposito_id);

                        $saldo_deposito = (int) $deposito->saldo_deposito + (int) $sumber_dana_deposito[$i]->nominal;
                        $resapan_deposito = $deposito->resapan_deposito - $sumber_dana_deposito[$i]->nominal;

                        $data_deposito[$i] = array(
                            'saldo_deposito'    => $saldo_deposito,
                            'resapan_deposito'  => $resapan_deposito,
                        );

                        $this->Deposito_model->update($sumber_dana_deposito[$i]->deposito_id, $data_deposito[$i]);
                    }
                }

                //Hapus current data sumber dana by pembiayaan_id
                $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
                $this->db->delete('sumber_dana');

                //Simpan data baru deposito dan tabungan
                //SUMBER DANA DARI DEPOSITO
                if (!empty($this->session->id_deposito)) {
                    $count_deposito_id = count($this->session->id_deposito);

                    for ($i = 0; $i < $count_deposito_id; $i++) {
                        $total_basil = $this->session->persentase_deposito[$i] * $pembiayaan->total_biaya_sewa / 100;

                        $basil_for_lembaga = 70 * $total_basil / 100;
                        $basil_for_deposan = 30 * $total_basil / 100;

                        $data[$i] = array(
                            'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                            'deposito_id'       => $this->session->id_deposito[$i],
                            'persentase'        => $this->session->persentase_deposito[$i],
                            'nominal'           => $this->session->nominal_deposito[$i],
                            'total_basil'       => $total_basil,
                            'basil_for_lembaga' => $basil_for_lembaga,
                            'basil_for_deposan' => $basil_for_deposan,
                            'created_by'        => $this->session->username,
                        );

                        $this->db->insert('sumber_dana', $data[$i]);

                        write_log();

                        //Manipulasi total deposito
                        $deposito = $this->Deposito_model->get_by_id($this->session->id_deposito[$i]);

                        $saldo_deposito = (int) $deposito->saldo_deposito - (int) $this->session->nominal_deposito[$i];
                        $resapan_deposito = $deposito->resapan_deposito + $this->session->nominal_deposito[$i];

                        $data_deposito = array(
                            'saldo_deposito'    => $saldo_deposito,
                            'resapan_deposito'  => $resapan_deposito,
                        );

                        $this->Deposito_model->update($this->session->id_deposito[$i], $data_deposito);
                    }
                }

                //SUMBER DANA DARI TABUNGAN
                $total_basil_tabungan = $this->session->persentase_tabungan * $pembiayaan->total_biaya_sewa / 100;

                $data_sumber_dana = array(
                    'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                    'deposito_id'       => NULL,
                    'persentase'        => $this->session->persentase_tabungan,
                    'nominal'           => $this->session->total_pinjaman,
                    'total_basil'       => $total_basil_tabungan,
                    'basil_for_lembaga' => $total_basil_tabungan,
                    'created_by'        => $this->session->username,
                );

                $this->db->insert('sumber_dana', $data_sumber_dana);

                write_log();

                //MANIPULASI DATA INSTANSI
                $saldo_tabungan_instansi = $instansi->saldo_tabungan - $this->session->total_pinjaman;
                $resapan_tabungan_instansi = $instansi->resapan_tabungan + $this->session->total_pinjaman;

                $data = array(
                    'saldo_tabungan'    => $saldo_tabungan_instansi,
                    'resapan_tabungan'  => $resapan_tabungan_instansi,
                );

                $this->Instansi_model->update($this->input->post('instansi_id'), $data);

                //MANIPULASI DATA CABANG
                $saldo_tabungan_cabang = $cabang->saldo_tabungan - $this->session->total_pinjaman;
                $resapan_tabungan_cabang = $cabang->resapan_tabungan + $this->session->total_pinjaman;

                $data = array(
                    'saldo_tabungan'    => $saldo_tabungan_cabang,
                    'resapan_tabungan'  => $resapan_tabungan_cabang,
                );

                $this->Cabang_model->update($this->input->post('cabang_id'), $data);

                //Ubah kolom sumber dana pada data pembiayaan by id pembiayaan
                $this->Pembiayaan_model->update($this->input->post('id_pembiayaan'), array('sumber_dana' => 3));

            } else {
                //Jalankan fitur add
                //SUMBER DANA DARI DEPOSITO
                if (!empty($this->session->id_deposito)) {
                    $count_deposito_id = count($this->session->id_deposito);

                    for ($i = 0; $i < $count_deposito_id; $i++) {
                        $total_basil = $this->session->persentase_deposito[$i] * $pembiayaan->total_biaya_sewa / 100;

                        $basil_for_lembaga = 70 * $total_basil / 100;
                        $basil_for_deposan = 30 * $total_basil / 100;

                        $data[$i] = array(
                            'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                            'deposito_id'       => $this->session->id_deposito[$i],
                            'persentase'        => $this->session->persentase_deposito[$i],
                            'nominal'           => $this->session->nominal_deposito[$i],
                            'total_basil'       => $total_basil,
                            'basil_for_lembaga' => $basil_for_lembaga,
                            'basil_for_deposan' => $basil_for_deposan,
                            'created_by'        => $this->session->username,
                        );

                        $this->db->insert('sumber_dana', $data[$i]);

                        write_log();

                        //Manipulasi total deposito
                        $deposito = $this->Deposito_model->get_by_id($this->session->id_deposito[$i]);
                        $saldo_deposito = (int) $deposito->saldo_deposito - (int) $this->session->nominal_deposito[$i];
                        $resapan_deposito = $deposito->resapan_deposito + $this->session->nominal_deposito[$i];

                        $data_deposito = array(
                            'saldo_deposito'    => $saldo_deposito,
                            'resapan_deposito'  => $resapan_deposito,
                        );

                        $this->Deposito_model->update($this->session->id_deposito[$i], $data_deposito);
                    }
                }

                //SUMBER DANA DARI TABUNGAN
                $total_basil_tabungan = $this->session->persentase_tabungan * $pembiayaan->total_biaya_sewa / 100;

                $data_sumber_dana = array(
                    'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
                    'deposito_id'       => NULL,
                    'persentase'        => $this->session->persentase_tabungan,
                    'nominal'           => $this->session->total_pinjaman,
                    'total_basil'       => $total_basil_tabungan,
                    'basil_for_lembaga' => $total_basil_tabungan,
                    'created_by'        => $this->session->username,
                );

                $this->db->insert('sumber_dana', $data_sumber_dana);

                write_log();

                //MANIPULASI DATA INSTANSI
                $saldo_tabungan_instansi = $instansi->saldo_tabungan - $this->session->total_pinjaman;
                $resapan_tabungan_instansi = $instansi->resapan_tabungan + $this->session->total_pinjaman;

                $data = array(
                    'saldo_tabungan'    => $saldo_tabungan_instansi,
                    'resapan_tabungan'  => $resapan_tabungan_instansi,
                );

                $this->Instansi_model->update($this->input->post('instansi_id'), $data);

                //MANIPULASI DATA CABANG
                $saldo_tabungan_cabang = $cabang->saldo_tabungan - $this->session->total_pinjaman;
                $resapan_tabungan_cabang = $cabang->resapan_tabungan + $this->session->total_pinjaman;

                $data = array(
                    'saldo_tabungan'    => $saldo_tabungan_cabang,
                    'resapan_tabungan'  => $resapan_tabungan_cabang,
                );

                $this->Cabang_model->update($this->input->post('cabang_id'), $data);
            }

            $this->session->unset_userdata('id_anggota');
            $this->session->unset_userdata('nama_anggota');
            $this->session->unset_userdata('jml_pinjaman');
            $this->session->unset_userdata('total_pinjaman');
            $this->session->unset_userdata('status_sumber_dana');
            $this->session->unset_userdata('persentase_tabungan');
            $this->session->unset_userdata('id_deposito');
            $this->session->unset_userdata('persentase_deposito');
            $this->session->unset_userdata('nama_deposan');
            $this->session->unset_userdata('nominal_deposito');
            $this->session->unset_userdata('instansi');
            $this->session->unset_userdata('cabang');
        }

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
        redirect('admin/pembiayaan');
    }

    function sumber_dana_deposito()
    {
        if (empty($this->session->nama_anggota)) {
            $this->session->set_flashdata('message', '<div class="alert alert-warning alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-exclamation-triangle"></i><b> Isi data pembiayaan berikut terlebih dahulu!</b></h6></div>');
            redirect('admin/pembiayaan/create');
        } else {
            //PILIH PEMBAGIAN DEPOSITO
            $this->data['action']       = 'admin/pembiayaan/create_action';
            $this->data['modal_action'] = 'admin/pembiayaan/persentase_action';

            $this->data['page_title'] = 'Pilih Sumber Dana Dari Deposan';

            $this->data['status_sumber_dana'] = 2;

            if (is_grandadmin() or is_masteradmin()) {
                $this->data['get_all'] = $this->Deposito_model->get_all_by_cabang_for_grandadmin_masteradmin($this->session->cabang);
            } elseif (is_superadmin()) {
                $this->data['get_all'] = $this->Deposito_model->get_all_by_cabang();
            }

            $this->data['persentase_deposito'] = [
                'name'          => 'persentase_deposito',
                'id'            => 'persentase_deposito',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
            ];
            $this->data['konversi_nominal'] = [
                'name'          => 'konversi_nominal',
                'id'            => 'konversi_nominal',
                'class'         => 'form-control',
                'readonly'      => '',
            ];
            $this->data['id_deposito'] = [
                'name'          => 'id_deposito',
                'id'            => 'id_deposito',
                'type'          => 'hidden',
            ];
            $this->data['id_pembiayaan'] = [
                'name'          => 'id_pembiayaan',
                'id'            => 'id_pembiayaan',
                'type'          => 'hidden',
            ];
            $this->data['sumber_dana'] = [
                'name'          => 'sumber_dana',
                'id'            => 'sumber_dana',
                'type'          => 'hidden',
            ];
            $this->data['instansi_id'] = [
                'name'          => 'instansi_id',
                'id'            => 'instansi_id',
                'type'          => 'hidden',
            ];
            $this->data['cabang_id'] = [
                'name'          => 'cabang_id',
                'id'            => 'cabang_id',
                'type'          => 'hidden',
            ];

            $this->load->view('back/pembiayaan/pembiayaan_add_forward', $this->data);
        }
    }

    function sumber_dana_tabungan()
    {
        $this->data['action'] = 'admin/pembiayaan/create_action';

        $this->data['page_title'] = 'Sumber Dana Dari Tabungan';

        $this->data['modal_action'] = 'admin/pembiayaan/change_pinjaman_action';

        $this->data['status_sumber_dana'] = 1;

        $this->data['saldo_tabungan'] = (int) $this->data['instansi']->saldo_tabungan - (int) $this->session->jml_pinjaman;

        if (is_grandadmin() or is_masteradmin()) {
            $this->data['cabang'] = $this->Cabang_model->get_by_id($this->session->cabang);
        } elseif (is_superadmin()) {
            $this->data['cabang'] = $this->Cabang_model->get_by_id($this->session->cabang_id);
        }

        $this->data['jml_pinjaman'] = [
            'name'          => 'jml_pinjaman',
            'id'            => 'jml_pinjaman',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
        ];
        $this->data['id_pembiayaan'] = [
            'name'          => 'id_pembiayaan',
            'id'            => 'id_pembiayaan',
            'type'          => 'hidden',
        ];
        $this->data['sumber_dana'] = [
            'name'          => 'sumber_dana',
            'id'            => 'sumber_dana',
            'type'          => 'hidden',
        ];
        $this->data['instansi_id'] = [
            'name'          => 'instansi_id',
            'id'            => 'instansi_id',
            'type'          => 'hidden',
        ];
        $this->data['cabang_id'] = [
            'name'          => 'cabang_id',
            'id'            => 'cabang_id',
            'type'          => 'hidden',
        ];

        $this->load->view('back/pembiayaan/pembiayaan_add_forward', $this->data);
    }

    function sumber_dana_tabungan_deposito()
    {
        $this->data['action'] = 'admin/pembiayaan/create_action';
        $this->data['modal_action'] = 'admin/pembiayaan/persentase_action';

        $this->data['page_title'] = 'Sumber Dana Dari Tabungan Dan Deposito';

        $this->data['status_sumber_dana'] = 3;

        if (is_grandadmin() or is_masteradmin()) {
            $this->data['deposito'] = $this->Deposito_model->get_all_by_cabang_for_grandadmin_masteradmin($this->session->cabang);
            $this->data['cabang'] = $this->Cabang_model->get_by_id($this->session->cabang);
        } elseif (is_superadmin()) {
            $this->data['deposito'] = $this->Deposito_model->get_all_by_cabang();
            $this->data['cabang'] = $this->Cabang_model->get_by_id($this->session->cabang_id);
        }

        $this->data['cek_tabungan'] = (int) $this->data['instansi']->saldo_tabungan - (int) $this->session->total_pinjaman;

        $this->data['nominal_sumber_dana_tabungan'] = [
            'name'          => 'nominal_sumber_dana_tabungan',
            'id'            => 'nominal_sumber_dana_tabungan',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'value'         => $this->form_validation->set_value('nominal_sumber_dana_tabungan'),
        ];
        $this->data['persentase_deposito'] = [
            'name'          => 'persentase_deposito',
            'id'            => 'persentase_deposito',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['konversi_nominal'] = [
            'name'          => 'konversi_nominal',
            'id'            => 'konversi_nominal',
            'class'         => 'form-control',
            'readonly'      => '',
        ];
        $this->data['id_deposito'] = [
            'name'          => 'id_deposito',
            'id'            => 'id_deposito',
            'type'          => 'hidden',
        ];
        $this->data['id_pembiayaan'] = [
            'name'          => 'id_pembiayaan',
            'id'            => 'id_pembiayaan',
            'type'          => 'hidden',
        ];
        $this->data['sumber_dana'] = [
            'name'          => 'sumber_dana',
            'id'            => 'sumber_dana',
            'type'          => 'hidden',
        ];
        $this->data['instansi_id'] = [
            'name'          => 'instansi_id',
            'id'            => 'instansi_id',
            'type'          => 'hidden',
        ];
        $this->data['cabang_id'] = [
            'name'          => 'cabang_id',
            'id'            => 'cabang_id',
            'type'          => 'hidden',
        ];

        $this->load->view('back/pembiayaan/pembiayaan_add_forward', $this->data);
    }

    function persentase_action()
    {
        //Ubah tipe data konversi nominal
        $string = $this->input->post('konversi_nominal');
        $konversi_nominal = preg_replace("/[^0-9]/", "", $string);

        //Get by id data deposan
        $deposan = $this->Deposito_model->get_by_id($this->input->post('id_deposito'));

        //Menghitung apakah saldo deposito oleh deposan @ cukup
        $cek_saldo = $deposan->saldo_deposito - $konversi_nominal;

        if ($cek_saldo >= 0) {
            $result = $this->session->total_pinjaman - (int) $konversi_nominal;

            $persentase = (int) $konversi_nominal / $this->session->jml_pinjaman * 100;

            $new_array_deposito = $this->session->id_deposito;
            $new_array_persentase = $this->session->persentase_deposito;
            $new_array_deposan = $this->session->nama_deposan;
            $new_array_nominal = $this->session->nominal_deposito;
            array_push($new_array_deposito, $this->input->post('id_deposito'));
            array_push($new_array_persentase, $persentase);
            array_push($new_array_deposan, $deposan->name);
            array_push($new_array_nominal, (int) $konversi_nominal);
            $this->session->set_userdata('id_deposito', $new_array_deposito);
            $this->session->set_userdata('persentase_deposito', $new_array_persentase);
            $this->session->set_userdata('nama_deposan', $new_array_deposan);
            $this->session->set_userdata('nominal_deposito', $new_array_nominal);

            if ($this->session->status_sumber_dana == 2) {
                if ($result > 0) {
                    $this->session->set_userdata('total_pinjaman', $result);

                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Dari pembagian deposito tersisa Rp. ' . number_format($result, 0, ',', '.') . ' setelah berkurang sebesar ' . $this->session->persentase_deposito[count($this->session->persentase_deposito) - 1] . '% dengan nominal Rp. ' . $this->input->post('konversi_nominal') . '</b></h6></div>');
                    redirect('admin/pembiayaan/sumber_dana_deposito');
                } elseif ($result == 0) {
                    $this->session->set_userdata('total_pinjaman', $result);

                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Pembagian deposito selesai. Silahkan simpan</b></h6></div>');
                    redirect('admin/pembiayaan/sumber_dana_deposito');
                } else {
                    redirect('admin/pembiayaan/sumber_dana_deposito');
                }
            } elseif ($this->session->status_sumber_dana == 3) {
                if (!empty($this->session->persentase_deposito)) {
                    $persentase_deposan = 0;
                    for ($i = 0; $i < count($this->session->persentase_deposito); $i++) {
                        $persentase_deposan += $this->session->persentase_deposito[$i];
                    }
                    $persentase_tabungan = 100 - $persentase_deposan;
                }

                if ($persentase_tabungan > 0) {
                    $this->session->set_userdata('persentase_tabungan', $persentase_tabungan);

                    $this->session->set_userdata('total_pinjaman', $result);

                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Dari pembagian deposito tersisa Rp. ' . number_format($result, 0, ',', '.') . ' setelah berkurang sebesar ' . $this->session->persentase_deposito[count($this->session->persentase_deposito) - 1] . '% dengan nominal Rp. ' . $this->input->post('konversi_nominal') . '</b></h6></div>');

                    redirect('admin/pembiayaan/sumber_dana_tabungan_deposito');
                } else {
                    $new_array_deposito = $this->session->id_deposito;
                    $new_array_persentase = $this->session->persentase_deposito;
                    $new_array_deposan = $this->session->nama_deposan;
                    $new_array_nominal = $this->session->nominal_deposito;
                    unset($new_array_deposito[count($new_array_deposito) - 1]);
                    unset($new_array_persentase[count($new_array_persentase) - 1]);
                    unset($new_array_deposan[count($new_array_deposan) - 1]);
                    unset($new_array_nominal[count($new_array_nominal) - 1]);
                    $this->session->set_userdata('id_deposito', $new_array_deposito);
                    $this->session->set_userdata('persentase_deposito', $new_array_persentase);
                    $this->session->set_userdata('nama_deposan', $new_array_deposan);
                    $this->session->set_userdata('nominal_deposito', $new_array_nominal);

                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Persentase Tabungan Tidak Boleh Kosong</b></h6></div>');

                    redirect('admin/pembiayaan/sumber_dana_tabungan_deposito');
                }

            }
        } else {
            if ($this->session->status_sumber_dana == 2) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Saldo Deposito Tidak Cukup</b></h6></div>');

                    redirect('admin/pembiayaan/sumber_dana_deposito');

            } elseif ($this->session->status_sumber_dana == 3) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Saldo Deposito Tidak Cukup</b></h6></div>');

                redirect('admin/pembiayaan/sumber_dana_tabungan_deposito');
            }
        }
    }

    function update_action()
    {
        $this->form_validation->set_rules('jml_pinjaman', 'Jumlah Pinjaman', 'required');
        $this->form_validation->set_rules('jangka_waktu_pinjam', 'Jangka Waktu Pinjaman', 'is_numeric|required');
        $this->form_validation->set_rules('jenis_barang_gadai', 'Jenis Barang Yang Digadaikan', 'required');
        $this->form_validation->set_rules('berat_barang_gadai', 'Berat/Nilai Barang Yang Digadaikan', 'is_numeric|required');
        $this->form_validation->set_rules('waktu_gadai', 'Waktu Gadai', 'required');
        $this->form_validation->set_rules('jatuh_tempo_gadai', 'Jatuh Tempo Gadai', 'required');
        $this->form_validation->set_rules('sistem_pembayaran_sewa', 'Sistem Pembayaran Sewa', 'required');

        $this->form_validation->set_message('required', '{field} wajib diisi');
        $this->form_validation->set_message('is_numeric', '{field} harus angka');

        $this->form_validation->set_error_delimiters('<div class="alert alert-danger">', '</div>');

        if ($this->form_validation->run() === FALSE) {
            $this->index();
        } else {
            // Get current data pembiayaan
            $pembiayaan = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'));

            // Ubah format tanggal
            $waktu_gadai = date("Y-m-d", strtotime($this->input->post('waktu_gadai')));
            $jatuh_tempo_gadai = date("Y-m-d", strtotime($this->input->post('jatuh_tempo_gadai')));

            //Menentukan sewa tempat perbulan
            $sewa_tempat_perbulan = 10000 * $this->input->post('berat_barang_gadai');

            //Menentukan total biaya sewa
            $total_biaya_sewa = $sewa_tempat_perbulan * $this->input->post('jangka_waktu_pinjam');

            //Ubah tipe data jml pinjaman
            $string = $this->input->post('jml_pinjaman');
            $jml_pinjaman = preg_replace("/[^0-9]/", "", $string);

            if ($_FILES['photo']['error'] <> 4) {
                $nmfile = strtolower(url_title($pembiayaan->name)) . date('YmdHis');

                $config['upload_path']      = './assets/images/barang_gadai/';
                $config['allowed_types']    = 'jpg|jpeg|png';
                $config['max_size']         = 2048; // 2Mb
                $config['file_name']        = $nmfile;

                $this->load->library('upload', $config);

                //Hapus file di direktori images
                $dir        = "./assets/images/barang_gadai/" . $pembiayaan->image;

                if (is_file($dir)) {
                    unlink($dir);
                }

                if (!$this->upload->do_upload('photo')) {
                    $error = array('error' => $this->upload->display_errors());
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error['error'] . '</div>');

                    $this->index();
                } else {
                    $photo = $this->upload->data();

                    $data = array(
                        'jml_pinjaman'              => (int) $jml_pinjaman,
                        'jangka_waktu_pinjam'       => $this->input->post('jangka_waktu_pinjam'),
                        'jenis_barang_gadai'        => $this->input->post('jenis_barang_gadai'),
                        'berat_barang_gadai'        => $this->input->post('berat_barang_gadai'),
                        'waktu_gadai'               => $waktu_gadai,
                        'jatuh_tempo_gadai'         => $jatuh_tempo_gadai,
                        'jangka_waktu_gadai'        => $this->input->post('jangka_waktu_pinjam'),
                        'sewa_tempat_perbulan'      => $sewa_tempat_perbulan,
                        'total_biaya_sewa'          => $total_biaya_sewa,
                        'sistem_pembayaran_sewa'    => $this->input->post('sistem_pembayaran_sewa'),
                        'image'                     => $this->upload->data('file_name'),
                        'modified_by'               => $this->session->username,
                    );
                }

            } else {
                $data = array(
                    'jml_pinjaman'              => (int) $jml_pinjaman,
                    'jangka_waktu_pinjam'       => $this->input->post('jangka_waktu_pinjam'),
                    'jenis_barang_gadai'        => $this->input->post('jenis_barang_gadai'),
                    'berat_barang_gadai'        => $this->input->post('berat_barang_gadai'),
                    'waktu_gadai'               => $waktu_gadai,
                    'jatuh_tempo_gadai'         => $jatuh_tempo_gadai,
                    'jangka_waktu_gadai'        => $this->input->post('jangka_waktu_pinjam'),
                    'sewa_tempat_perbulan'      => $sewa_tempat_perbulan,
                    'total_biaya_sewa'          => $total_biaya_sewa,
                    'sistem_pembayaran_sewa'    => $this->input->post('sistem_pembayaran_sewa'),
                    'modified_by'               => $this->session->username,
                );
            }

            $this->Pembiayaan_model->update($this->input->post('id_pembiayaan'), $data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
            redirect('admin/pembiayaan');
        }
    }

    function delete($id)
    {
        is_delete();

        $delete = $this->Pembiayaan_model->get_by_id($id);

        if ($delete) {
            $data = array(
                'is_delete_pembiayaan' => '1',
                'deleted_by'           => $this->session->username,
                'deleted_at'           => date('Y-m-d H:i:a'),
            );

            $this->Pembiayaan_model->soft_delete($id, $data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus!</b></h6></div>');
            redirect('admin/pembiayaan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/pembiayaan');
        }
    }

    function delete_by_user($id_user)
    {
        is_delete();

        $delete = $this->Pembiayaan_model->get_all_pembiayaan_by_user($id_user);

        if ($delete) {
            foreach ($delete as $data) {
                $changeData = array(
                    'is_delete_pembiayaan' => '1',
                    'deleted_by'           => $this->session->username,
                    'deleted_at'           => date('Y-m-d H:i:a'),
                );

                $this->Pembiayaan_model->soft_delete($data->id_pembiayaan, $changeData);

                write_log();
            }

            $data = array(
                'is_delete'            => '1',
                'deleted_by'           => $this->session->username,
                'deleted_at'           => date('Y-m-d H:i:a'),
            );

            $this->Auth_model->soft_delete($id_user, $data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus!</b></h6></div>');
            redirect('admin/pembiayaan');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/pembiayaan');
        }
    }

    function deleted_list()
    {
        is_restore();

        $this->data['page_title'] = 'Recycle Bin ' . $this->data['module'];

        if (is_grandadmin()) {
            $this->data['get_all_deleted'] = $this->Pembiayaan_model->get_all_deleted();
        } elseif (is_masteradmin()) {
            $this->data['get_all_deleted'] = $this->Pembiayaan_model->get_all_deleted_by_instansi();
        } elseif (is_superadmin()) {
            $this->data['get_all_deleted'] = $this->Pembiayaan_model->get_all_deleted_by_cabang();
        }

        $this->load->view('back/pembiayaan/pembiayaan_deleted_list', $this->data);
    }

    function restore($id_user)
    {
        is_restore();

        $row = $this->Pembiayaan_model->get_all_deleted_pembiayaan_by_user($id_user);

        if ($row) {
            foreach ($row as $data) {
                $changeData = array(
                    'is_delete_pembiayaan' => '0',
                    'deleted_by'           => NULL,
                    'deleted_at'           => NULL,
                );

                $this->Pembiayaan_model->soft_delete($data->id_pembiayaan, $changeData);

                write_log();
            }

            $data = array(
                'is_delete'            => '0',
                'deleted_by'           => NULL,
                'deleted_at'           => NULL,
            );

            $this->Auth_model->soft_delete($id_user, $data);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dikembalikan!</b></h6></div>');
            redirect('admin/pembiayaan/deleted_list');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/pembiayaan');
        }
    }

    function delete_permanent($id)
    {
        is_delete();

        $delete = $this->Pembiayaan_model->get_by_id($id);

        if ($delete) {
            //Hapus file di direktori images
            $dir        = "./assets/images/barang_gadai/" . $delete->image;

            if (is_file($dir)) {
                unlink($dir);
            }

            if ($delete->status_pembayaran == 0) {
                // UPDATE MASING-MASING SUMBER DANA
                if ($delete->sumber_dana == 1) {
                    // MANIPULASI DATA CABANG
                    $cabang = $this->Cabang_model->get_by_id($delete->cabang_id);

                    $resapan_tabungan = $cabang->resapan_tabungan - $delete->jml_pinjaman;
                    $saldo_tabungan = $cabang->saldo_tabungan + $delete->jml_pinjaman;

                    $change_data = array(
                        'resapan_tabungan'  => $resapan_tabungan,
                        'saldo_tabungan'    => $saldo_tabungan,
                    );

                    $this->Cabang_model->update($delete->cabang_id, $change_data);

                    // MANIPULASI DATA INSTANSI
                    $instansi = $this->Instansi_model->get_by_id($delete->instansi_id);

                    $resapan_tabungan = $instansi->resapan_tabungan - $delete->jml_pinjaman;
                    $saldo_tabungan = $instansi->saldo_tabungan + $delete->jml_pinjaman;

                    $change_data = array(
                        'resapan_tabungan'  => $resapan_tabungan,
                        'saldo_tabungan'    => $saldo_tabungan,
                    );

                    $this->Instansi_model->update($delete->instansi_id, $change_data);

                } elseif ($delete->sumber_dana == 2) {
                    // MANIPULASI DATA DEPOSITO
                    $sumber_dana = $this->Sumberdana_model->get_deposan_by_pembiayaan($id);

                    foreach ($sumber_dana as $data) {
                        $deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                        $resapan_deposito = $deposito->resapan_deposito - $data->nominal;
                        $saldo_deposito = $deposito->saldo_deposito + $data->nominal;

                        $change_data = array(
                            'resapan_deposito'  => $resapan_deposito,
                            'saldo_deposito'    => $saldo_deposito,
                        );

                        $this->Deposito_model->update($data->deposito_id, $change_data);
                    }
                } elseif ($delete->sumber_dana == 3) {
                    // MANIPULASI DATA TABUNGAN
                    $sumber_dana_tabungan = $this->Sumberdana_model->get_tabungan_by_pembiayaan($id);

                    foreach ($sumber_dana_tabungan as $data) {
                        // MANIPULASI DATA INSTANSI
                        $instansi = $this->Instansi_model->get_by_id($delete->instansi_id);

                        $resapan_tabungan = $instansi->resapan_tabungan - $data->nominal;
                        $saldo_tabungan = $instansi->saldo_tabungan + $data->nominal;

                        $change_data = array(
                            'saldo_tabungan'    => $saldo_tabungan,
                            'resapan_tabungan'  => $resapan_tabungan,
                        );

                        $this->Instansi_model->update($delete->instansi_id, $change_data);

                        // MANIPULASI DATA CABANG
                        $cabang = $this->Cabang_model->get_by_id($delete->cabang_id);

                        $resapan_tabungan = $cabang->resapan_tabungan - $data->nominal;
                        $saldo_tabungan = $cabang->saldo_tabungan + $data->nominal;

                        $change_data = array(
                            'saldo_tabungan'    => $saldo_tabungan,
                            'resapan_tabungan'  => $resapan_tabungan,
                        );

                        $this->Cabang_model->update($delete->cabang_id, $change_data);
                    }

                    // MANIPULASI DATA DEPOSITO
                    $sumber_dana_deposito = $this->Sumberdana_model->get_deposan_by_pembiayaan($id);

                    foreach ($sumber_dana_deposito as $data) {
                        $deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                        $resapan_deposito = $deposito->resapan_deposito - $data->nominal;
                        $saldo_deposito = $deposito->saldo_deposito + $data->nominal;

                        $change_data = array(
                            'resapan_deposito'  => $resapan_deposito,
                            'saldo_deposito'    => $saldo_deposito,
                        );

                        $this->Deposito_model->update($data->deposito_id, $change_data);
                    }
                }
            }

            $this->Pembiayaan_model->delete($id);
            $this->Auth_model->delete($delete->user_id);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus Secara Permanen!</b></h6></div>');
            redirect('admin/pembiayaan/deleted_list');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/pembiayaan');
        }
    }

    function delete_permanent_by_user($id_user)
    {
        is_delete();

        $delete = $this->Pembiayaan_model->get_all_deleted_pembiayaan_by_user($id_user);

        if ($delete) {
            foreach ($delete as $pembiayaan) {
                //Hapus file di direktori images
                $dir        = "./assets/images/barang_gadai/" . $pembiayaan->image;

                if (is_file($dir)) {
                    unlink($dir);
                }

                if ($pembiayaan->status_pembayaran == 0) {
                    // UPDATE MASING-MASING SUMBER DANA
                    if ($pembiayaan->sumber_dana == 1) {
                        // MANIPULASI DATA CABANG
                        $cabang = $this->Cabang_model->get_by_id($pembiayaan->cabang_id);

                        $resapan_tabungan = $cabang->resapan_tabungan - $pembiayaan->jml_pinjaman;
                        $saldo_tabungan = $cabang->saldo_tabungan + $pembiayaan->jml_pinjaman;

                        $change_data = array(
                            'resapan_tabungan'  => $resapan_tabungan,
                            'saldo_tabungan'    => $saldo_tabungan,
                        );

                        $this->Cabang_model->update($pembiayaan->cabang_id, $change_data);

                        // MANIPULASI DATA INSTANSI
                        $instansi = $this->Instansi_model->get_by_id($pembiayaan->instansi_id);

                        $resapan_tabungan = $instansi->resapan_tabungan - $pembiayaan->jml_pinjaman;
                        $saldo_tabungan = $instansi->saldo_tabungan + $pembiayaan->jml_pinjaman;

                        $change_data = array(
                            'resapan_tabungan'  => $resapan_tabungan,
                            'saldo_tabungan'    => $saldo_tabungan,
                        );

                        $this->Instansi_model->update($pembiayaan->instansi_id, $change_data);

                    } elseif ($pembiayaan->sumber_dana == 2) {
                        // MANIPULASI DATA DEPOSITO
                        $sumber_dana = $this->Sumberdana_model->get_deposan_by_pembiayaan($pembiayaan->id_pembiayaan);

                        foreach ($sumber_dana as $data) {
                            $deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                            $resapan_deposito = $deposito->resapan_deposito - $data->nominal;
                            $saldo_deposito = $deposito->saldo_deposito + $data->nominal;

                            $change_data = array(
                                'resapan_deposito'  => $resapan_deposito,
                                'saldo_deposito'    => $saldo_deposito,
                            );

                            $this->Deposito_model->update($data->deposito_id, $change_data);
                        }
                    } elseif ($pembiayaan->sumber_dana == 3) {
                        // MANIPULASI DATA TABUNGAN
                        $sumber_dana_tabungan = $this->Sumberdana_model->get_tabungan_by_pembiayaan($pembiayaan->id_pembiayaan);

                        foreach ($sumber_dana_tabungan as $data) {
                            // MANIPULASI DATA INSTANSI
                            $instansi = $this->Instansi_model->get_by_id($pembiayaan->instansi_id);

                            $resapan_tabungan = $instansi->resapan_tabungan - $data->nominal;
                            $saldo_tabungan = $instansi->saldo_tabungan + $data->nominal;

                            $change_data = array(
                                'saldo_tabungan'    => $saldo_tabungan,
                                'resapan_tabungan'  => $resapan_tabungan,
                            );

                            $this->Instansi_model->update($pembiayaan->instansi_id, $change_data);

                            // MANIPULASI DATA CABANG
                            $cabang = $this->Cabang_model->get_by_id($pembiayaan->cabang_id);

                            $resapan_tabungan = $cabang->resapan_tabungan - $data->nominal;
                            $saldo_tabungan = $cabang->saldo_tabungan + $data->nominal;

                            $change_data = array(
                                'saldo_tabungan'    => $saldo_tabungan,
                                'resapan_tabungan'  => $resapan_tabungan,
                            );

                            $this->Cabang_model->update($pembiayaan->cabang_id, $change_data);
                        }

                        // MANIPULASI DATA DEPOSITO
                        $sumber_dana_deposito = $this->Sumberdana_model->get_deposan_by_pembiayaan($pembiayaan->id_pembiayaan);

                        foreach ($sumber_dana_deposito as $data) {
                            $deposito = $this->Deposito_model->get_by_id($data->deposito_id);

                            $resapan_deposito = $deposito->resapan_deposito - $data->nominal;
                            $saldo_deposito = $deposito->saldo_deposito + $data->nominal;

                            $change_data = array(
                                'resapan_deposito'  => $resapan_deposito,
                                'saldo_deposito'    => $saldo_deposito,
                            );

                            $this->Deposito_model->update($data->deposito_id, $change_data);
                        }
                    }
                }

                $this->Pembiayaan_model->delete($pembiayaan->id_pembiayaan);
            }

            $this->Auth_model->delete($id_user);

            write_log();

            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Berhasil Dihapus Secara Permanen!</b></h6></div>');
            redirect('admin/pembiayaan/deleted_list');
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Data Tidak Ditemukan!</b></h6></div>');
            redirect('admin/pembiayaan');
        }
    }

    function konversi_nominal($persentase = '')
    {
        $jml_pinjaman = $this->session->jml_pinjaman;

        $hasil_konversi = $persentase * $jml_pinjaman / 100;

        if (!empty($persentase)) {
            if ($hasil_konversi > $this->session->total_pinjaman) {
                $is_valid = 0;
            } elseif ($hasil_konversi <= $this->session->total_pinjaman) {
                $is_valid = 1;
            }
        }

        $output['hasil_konversi']    = $hasil_konversi;
        $output['is_valid']    = $is_valid;

        echo json_encode($output);
    }

    function get_sumber_dana($id_pembiayaan)
    {
        $pembiayaan = $this->Pembiayaan_model->get_by_id($id_pembiayaan);
        $this->data['id_pembiayaan'] = $id_pembiayaan;

        if ($pembiayaan->sumber_dana == 1) {
            $this->data['tabungan'] = $this->Sumberdana_model->get_tabungan_by_pembiayaan($id_pembiayaan);

            $this->load->view('back/pembiayaan/v_tabungan_by_pembiayaan_list', $this->data);
        } elseif ($pembiayaan->sumber_dana == 2) {
            $this->data['deposan'] = $this->Sumberdana_model->get_deposan_by_pembiayaan($id_pembiayaan);

            $this->load->view('back/pembiayaan/v_deposan_by_pembiayaan_list', $this->data);
        } elseif ($pembiayaan->sumber_dana == 3) {
            $this->data['deposan'] = $this->Sumberdana_model->get_deposan_by_pembiayaan($id_pembiayaan);

            $this->data['tabungan'] = $this->Sumberdana_model->get_tabungan_by_pembiayaan($id_pembiayaan);

            $this->load->view('back/pembiayaan/v_tabungan_deposan_by_pembiayaan_list', $this->data);
        }
    }

    function edit_sumber_dana($id_pembiayaan)
    {
        $this->data['page_title'] = 'Edit Sumber Dana ' . $this->data['module'];
        $this->data['action'] = 'admin/pembiayaan/update_sumber_dana_tabungan';
        $this->data['modal_action'] = 'admin/pembiayaan/persentase_action';

        $this->data['pembiayaan'] = $this->Pembiayaan_model->get_by_id($id_pembiayaan);

        $this->data['status_sumber_dana'] = [
            'name'          => 'status_sumber_dana',
            'id'            => 'status_sumber_dana',
            'class'         => 'form-control',
            'onChange'      => 'tampilFormSumberDana()',
            'required'      => '',
            'value'         => $this->form_validation->set_value('status_sumber_dana'),
        ];
        $this->data['sumber_dana_value'] = [
            ''              => '- Pilih Sumber Dana -',
            '1'             => 'Tabungan',
            '2'             => 'Deposito',
            '3'             => 'Tabungan dan Deposito',
        ];
        $this->data['persentase_deposito'] = [
            'name'          => 'persentase_deposito',
            'id'            => 'persentase_deposito',
            'class'         => 'form-control',
            'autocomplete'  => 'off',
            'required'      => '',
            'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
        ];
        $this->data['konversi_nominal'] = [
            'name'          => 'konversi_nominal',
            'id'            => 'konversi_nominal',
            'class'         => 'form-control',
            'readonly'      => '',
        ];
        $this->data['id_deposito'] = [
            'name'          => 'id_deposito',
            'id'            => 'id_deposito',
            'type'          => 'hidden',
        ];

        $this->load->view('back/pembiayaan/edit_sumber_dana', $this->data);
    }

    function tampil_form_sumber_dana($sumber_dana, $id_pembiayaan)
    {
        $this->data['sumber_dana_id'] = $sumber_dana;
        $this->data['pembiayaan'] = $this->Pembiayaan_model->get_by_id($id_pembiayaan);
        $this->data['data_instansi'] = $this->Instansi_model->get_by_id($this->data['pembiayaan']->instansi_id);
        $this->data['data_cabang'] = $this->Cabang_model->get_by_id($this->data['pembiayaan']->cabang_id);

        $this->data['id_pembiayaan'] = [
            'name'          => 'id_pembiayaan',
            'id'            => 'id_pembiayaan',
            'type'          => 'hidden',
        ];
        $this->data['sumber_dana'] = [
            'name'          => 'sumber_dana',
            'id'            => 'sumber_dana',
            'type'          => 'hidden',
        ];
        $this->data['instansi_id'] = [
            'name'          => 'instansi_id',
            'id'            => 'instansi_id',
            'type'          => 'hidden',
        ];
        $this->data['cabang_id'] = [
            'name'          => 'cabang_id',
            'id'            => 'cabang_id',
            'type'          => 'hidden',
        ];

        if ($sumber_dana == 1) {
            $array_session = array(
                'id_anggota'            => $id_pembiayaan,
                'nama_anggota'          => $this->data['pembiayaan']->name,
                'jml_pinjaman'          => $this->data['pembiayaan']->jml_pinjaman,
                'instansi'              => $this->data['pembiayaan']->instansi_id,
                'cabang'                => $this->data['pembiayaan']->cabang_id,
            );

            $this->session->set_userdata($array_session);
        } elseif ($sumber_dana == 2) {
            $this->data['get_all'] = $this->Deposito_model->get_all();

            $array_session = array(
                'id_anggota'            => $id_pembiayaan,
                'nama_anggota'          => $this->data['pembiayaan']->name,
                'jml_pinjaman'          => $this->data['pembiayaan']->jml_pinjaman,
                'total_pinjaman'        => $this->data['pembiayaan']->jml_pinjaman,
                'instansi'              => $this->data['pembiayaan']->instansi_id,
                'cabang'                => $this->data['pembiayaan']->cabang_id,
                'status_sumber_dana'    => 2,
                'id_deposito'           => array(),
                'persentase_deposito'   => array(),
                'nama_deposan'          => array(),
                'nominal_deposito'      => array(),
            );

            $this->session->set_userdata($array_session);
        } elseif ($sumber_dana == 3) {
            $this->data['deposito'] = $this->Deposito_model->get_all();

            $array_session = array(
                'id_anggota'            => $id_pembiayaan,
                'nama_anggota'          => $this->data['pembiayaan']->name,
                'jml_pinjaman'          => $this->data['pembiayaan']->jml_pinjaman,
                'total_pinjaman'        => $this->data['pembiayaan']->jml_pinjaman,
                'instansi'              => $this->data['pembiayaan']->instansi_id,
                'cabang'                => $this->data['pembiayaan']->cabang_id,
                'status_sumber_dana'    => 3,
                'persentase_tabungan'   => 100,
                'id_deposito'           => array(),
                'persentase_deposito'   => array(),
                'nama_deposan'          => array(),
                'nominal_deposito'      => array(),
            );

            $this->session->set_userdata($array_session);
        }

        $this->load->view('back/pembiayaan/v_sumber_dana', $this->data);
    }

    function button_component($id_pembiayaan)
    {
        $this->data['id_pembiayaan'] = $id_pembiayaan;

        $this->load->view('back/pembiayaan/v_button_component', $this->data);
    }

    function update_sumber_dana_tabungan()
    {
        $pembiayaan = $this->Pembiayaan_model->get_by_id($this->input->post('id_pembiayaan'));
        $instansi = $this->Instansi_model->get_by_id($this->input->post('instansi_id'));
        $cabang = $this->Cabang_model->get_by_id($this->input->post('cabang_id'));

        //Ambil nominal pada pembiayaan_id yang bersangkutan dan deposito_id dengan value NULL
        $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
        $this->db->where('deposito_id', NULL);
        $sumber_dana_tabungan = $this->db->get('sumber_dana')->row();

        if ($sumber_dana_tabungan) {
            //MANIPULASI DATA INSTANSI
            $saldo_tabungan_instansi = $instansi->saldo_tabungan + $sumber_dana_tabungan->nominal;
            $resapan_tabungan_instansi = $instansi->resapan_tabungan - $sumber_dana_tabungan->nominal;

            $data = array(
                'saldo_tabungan'    => $saldo_tabungan_instansi,
                'resapan_tabungan'  => $resapan_tabungan_instansi,
            );

            $this->Instansi_model->update($this->input->post('instansi_id'), $data);

            //MANIPULASI DATA CABANG
            $saldo_tabungan_cabang = $cabang->saldo_tabungan + $sumber_dana_tabungan->nominal;
            $resapan_tabungan_cabang = $cabang->resapan_tabungan - $sumber_dana_tabungan->nominal;

            $data = array(
                'saldo_tabungan'    => $saldo_tabungan_cabang,
                'resapan_tabungan'  => $resapan_tabungan_cabang,
            );

            $this->Cabang_model->update($this->input->post('cabang_id'), $data);
        }

        //Ambil nominal pada pembiayaan_id yang bersangkutan dan deposito_id dengan value not null
        $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
        $this->db->where('deposito_id !=', NULL);
        $sumber_dana_deposito = $this->db->get('sumber_dana')->result();

        if ($sumber_dana_deposito) {
            //Perulangan masing2 id_deposito untuk manipulasi saldo dan resapan deposito (data lama)
            for ($i = 0; $i < count($sumber_dana_deposito); $i++) {
                //Manipulasi saldo dan resapan deposito
                //Ambil data deposito by id
                $deposito = $this->Deposito_model->get_by_id($sumber_dana_deposito[$i]->deposito_id);

                $saldo_deposito = (int) $deposito->saldo_deposito + (int) $sumber_dana_deposito[$i]->nominal;
                $resapan_deposito = $deposito->resapan_deposito - $sumber_dana_deposito[$i]->nominal;

                $data_deposito[$i] = array(
                    'saldo_deposito'    => $saldo_deposito,
                    'resapan_deposito'  => $resapan_deposito,
                );

                $this->Deposito_model->update($sumber_dana_deposito[$i]->deposito_id, $data_deposito[$i]);
            }
        }

        //Hapus current data by pembiayaan id
        $this->db->where('pembiayaan_id', $this->input->post('id_pembiayaan'));
        $this->db->delete('sumber_dana');

        //Tambahkan data baru
        $data_sumber_dana = array(
            'pembiayaan_id'     => $this->input->post('id_pembiayaan'),
            'deposito_id'       => NULL,
            'persentase'        => 100,
            'nominal'           => $this->session->jml_pinjaman,
            'total_basil'       => $pembiayaan->total_biaya_sewa,
            'basil_for_lembaga' => $pembiayaan->total_biaya_sewa,
            'created_by'        => $this->session->username,
        );

        $this->db->insert('sumber_dana', $data_sumber_dana);

        write_log();

        //MANIPULASI DATA INSTANSI
        $saldo_tabungan_instansi = $instansi->saldo_tabungan - $this->session->jml_pinjaman;
        $resapan_tabungan_instansi = $instansi->resapan_tabungan + $this->session->jml_pinjaman;

        $data = array(
            'saldo_tabungan'    => $saldo_tabungan_instansi,
            'resapan_tabungan'  => $resapan_tabungan_instansi,
        );

        $this->Instansi_model->update($this->input->post('instansi_id'), $data);

        //MANIPULASI DATA CABANG
        $saldo_tabungan_cabang = $cabang->saldo_tabungan - $this->session->jml_pinjaman;
        $resapan_tabungan_cabang = $cabang->resapan_tabungan + $this->session->jml_pinjaman;

        $data = array(
            'saldo_tabungan'    => $saldo_tabungan_cabang,
            'resapan_tabungan'  => $resapan_tabungan_cabang,
        );

        $this->Cabang_model->update($this->input->post('cabang_id'), $data);

        //Ubah kolom sumber dana pada data pembiayaan by id pembiayaan
        $this->Pembiayaan_model->update($this->input->post('id_pembiayaan'), array('sumber_dana' => 1));

        //Hapus session
        $this->session->unset_userdata('id_anggota');
        $this->session->unset_userdata('nama_anggota');
        $this->session->unset_userdata('jml_pinjaman');
        $this->session->unset_userdata('instansi');
        $this->session->unset_userdata('cabang');

        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-check"></i><b> Data Berhasil Disimpan!</b></h6></div>');
        redirect('admin/pembiayaan');
    }

    function get_image($image)
    {
        $this->data['image_barang_gadai'] = $image;

        $this->load->view('back/pembiayaan/v_image_by_pembiayaan', $this->data);
    }

    function current_image_for_edit_pembiayaan($image)
    {
        $this->data['current_image'] = $image;

        $this->load->view('back/pembiayaan/v_current_image_by_pembiayaan', $this->data);
    }

    function change_pinjaman_action()
    {
        //Ubah tipe data jml pinjaman
        $string = $this->input->post('jml_pinjaman');
        $jml_pinjaman = preg_replace("/[^0-9]/", "", $string);

        $this->session->set_userdata('jml_pinjaman', $jml_pinjaman);

        $data = array(
            'jml_pinjaman'  => $jml_pinjaman
        );

        $this->Pembiayaan_model->update($this->session->id_anggota, $data);

        redirect('admin/pembiayaan/sumber_dana_tabungan');
    }

    function component_dropdown($id_pembiayaan)
    {
        $this->data['pembiayaan'] = $this->Pembiayaan_model->get_by_id($id_pembiayaan);

        if (is_grandadmin()) {
            $this->data['get_all_combobox_instansi'] = $this->Instansi_model->get_all_combobox();
            $this->data['get_all_combobox_cabang'] = $this->Cabang_model->get_all_combobox_by_instansi($this->data['pembiayaan']->instansi_id);
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

        $this->load->view('back/pembiayaan/v_component_dropdown', $this->data);
    }

    function pilih_pinjaman()
    {
        $this->data['pinjaman'] = $this->Pembiayaan_model->get_pinjaman_by_user($this->uri->segment(4));

        $this->data['tanggungan'] = $this->data['pinjaman']->jml_pinjaman + $this->data['pinjaman']->total_biaya_sewa;

        $this->data['kekurangan_bayar'] = $this->data['tanggungan'] - $this->data['pinjaman']->jml_terbayar;

        $this->load->view('back/pembayaran/v_pinjaman', $this->data);
    }

    function konversi_jangka_waktu_gadai()
    {
        $today             = date("Y/m/d");
        $bulan             = $this->uri->segment(4);
        $konversi          = mktime(0,0,0,date("n")+$bulan,date("j"),date("Y"));
        $bulan_depan       = date("Y/m/d", $konversi);

        $output['hasil_konversi'] = $bulan_depan;
        $output['today'] = $today;

        echo json_encode($output);
    }

    function form_component()
    {
        if ($this->uri->segment(4) == 1) {
            // Anggota Baru
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
                'placeholder'   => '8XXXXXXXXXX',
                'value'         => $this->form_validation->set_value('phone'),
                'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
            ];
            $this->data['jml_pinjaman'] = [
                'name'          => 'jml_pinjaman',
                'id'            => 'jml_pinjaman',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('jml_pinjaman'),
            ];
            $this->data['jangka_waktu_pinjam'] = [
                'name'          => 'jangka_waktu_pinjam',
                'id'            => 'jangka_waktu_pinjam',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('jangka_waktu_pinjam'),
                'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
            ];
            $this->data['jenis_barang_gadai'] = [
                'name'          => 'jenis_barang_gadai',
                'id'            => 'jenis_barang_gadai',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('jenis_barang_gadai'),
            ];
            $this->data['berat_barang_gadai'] = [
                'name'          => 'berat_barang_gadai',
                'id'            => 'berat_barang_gadai',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('berat_barang_gadai'),
                'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
            ];
            $this->data['waktu_gadai'] = [
                'name'          => 'waktu_gadai',
                'id'            => 'waktu_gadai',
                'class'         => 'input-sm form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('waktu_gadai'),
                'readonly'      => '',
            ];
            $this->data['jatuh_tempo_gadai'] = [
                'name'          => 'jatuh_tempo_gadai',
                'id'            => 'jatuh_tempo_gadai',
                'class'         => 'input-sm form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('jatuh_tempo_gadai'),
                'readonly'      => '',
            ];
            $this->data['sistem_pembayaran_sewa'] = [
                'name'          => 'sistem_pembayaran_sewa',
                'id'            => 'sistem_pembayaran_sewa',
                'class'         => 'form-control',
                'required'      => '',
                'value'         => $this->form_validation->set_value('sistem_pembayaran_sewa'),
            ];
            $this->data['sistem_pembayaran_sewa_value'] = [
                ''              => '- Pilih Sistem Pembayaran -',
                '1'             => 'Bulanan',
                '2'             => 'Jatuh Tempo',
            ];
            $this->data['sumber_dana'] = [
                'name'          => 'sumber_dana',
                'id'            => 'sumber_dana',
                'class'         => 'form-control',
                'required'      => '',
                'value'         => $this->form_validation->set_value('sumber_dana'),
            ];
            $this->data['sumber_dana_value'] = [
                ''              => '- Pilih Sumber Dana -',
                '1'             => 'Tabungan',
                '2'             => 'Deposito',
                '3'             => 'Tabungan dan Deposito',
            ];

            $this->load->view('back/pembiayaan/v_pembiayaan_anggota_baru', $this->data);
        } elseif ($this->uri->segment(4) == 2) {
            // Anggota Lama
            if (is_grandadmin()) {
                $this->data['get_all_combobox_instansi']     = $this->Instansi_model->get_all_combobox();
            } elseif (is_masteradmin()) {
                $this->data['get_all_combobox_cabang']       = $this->Cabang_model->get_all_combobox_by_instansi($this->session->instansi_id);
            } elseif (is_superadmin()) {
                $this->data['get_all_combobox_user']         = $this->Auth_model->get_all_combobox_anggota_by_cabang($this->session->cabang_id);
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
                'onChange'      => 'tampilDetailUser()',
                'value'         => $this->form_validation->set_value('user_id'),
            ];
            $this->data['name'] = [
                'name'          => 'name',
                'id'            => 'name',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('name'),
                'readonly'      => '',
            ];
            $this->data['nik'] = [
                'name'          => 'nik',
                'id'            => 'nik',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('nik'),
                'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57',
                'readonly'      => '',
            ];
            $this->data['address'] = [
                'name'          => 'address',
                'id'            => 'address',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('address'),
                'readonly'      => '',
            ];
            $this->data['email'] = [
                'name'          => 'email',
                'id'            => 'email',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('email'),
                'readonly'      => '',
            ];
            $this->data['phone'] = [
                'name'          => 'phone',
                'id'            => 'phone',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('phone'),
                'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57',
                'readonly'      => '',
            ];
            $this->data['jml_pinjaman'] = [
                'name'          => 'jml_pinjaman',
                'id'            => 'jml_pinjaman',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('jml_pinjaman'),
            ];
            $this->data['jangka_waktu_pinjam'] = [
                'name'          => 'jangka_waktu_pinjam',
                'id'            => 'jangka_waktu_pinjam',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('jangka_waktu_pinjam'),
                'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
            ];
            $this->data['jenis_barang_gadai'] = [
                'name'          => 'jenis_barang_gadai',
                'id'            => 'jenis_barang_gadai',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('jenis_barang_gadai'),
            ];
            $this->data['berat_barang_gadai'] = [
                'name'          => 'berat_barang_gadai',
                'id'            => 'berat_barang_gadai',
                'class'         => 'form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('berat_barang_gadai'),
                'onkeypress'    => 'return event.charCode >= 48 && event.charCode <=57'
            ];
            $this->data['waktu_gadai'] = [
                'name'          => 'waktu_gadai',
                'id'            => 'waktu_gadai',
                'class'         => 'input-sm form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('waktu_gadai'),
                'readonly'      => '',
            ];
            $this->data['jatuh_tempo_gadai'] = [
                'name'          => 'jatuh_tempo_gadai',
                'id'            => 'jatuh_tempo_gadai',
                'class'         => 'input-sm form-control',
                'autocomplete'  => 'off',
                'required'      => '',
                'value'         => $this->form_validation->set_value('jatuh_tempo_gadai'),
                'readonly'      => '',
            ];
            $this->data['sistem_pembayaran_sewa'] = [
                'name'          => 'sistem_pembayaran_sewa',
                'id'            => 'sistem_pembayaran_sewa',
                'class'         => 'form-control',
                'required'      => '',
                'value'         => $this->form_validation->set_value('sistem_pembayaran_sewa'),
            ];
            $this->data['sistem_pembayaran_sewa_value'] = [
                ''              => '- Pilih Sistem Pembayaran -',
                '1'             => 'Bulanan',
                '2'             => 'Jatuh Tempo',
            ];
            $this->data['sumber_dana'] = [
                'name'          => 'sumber_dana',
                'id'            => 'sumber_dana',
                'class'         => 'form-control',
                'required'      => '',
                'value'         => $this->form_validation->set_value('sumber_dana'),
            ];
            $this->data['sumber_dana_value'] = [
                ''              => '- Pilih Sumber Dana -',
                '1'             => 'Tabungan',
                '2'             => 'Deposito',
                '3'             => 'Tabungan dan Deposito',
            ];

            $this->load->view('back/pembiayaan/v_pembiayaan_anggota_lama', $this->data);
        }
    }
}

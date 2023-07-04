<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->data['module'] = 'Dashboard';

		$this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);
		$this->data['notifikasi'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->result();
        $this->data['notifikasi_counter'] = $this->Riwayatpembayaran_model->get_all_non_is_paid()->num_rows();

		$this->data['notifikasi_for_anggota'] = $this->Riwayatpembayaran_model->get_all_non_is_read_anggota();
		$this->data['notifikasi_counter_for_anggota'] = $this->Riwayatpembayaran_model->counter_non_is_read_anggota();

		is_login();
	}

	public function index()
	{
		$this->data['page_title'] = $this->data['module'];

		if (is_grandadmin()) {
			$this->data['get_total_deposito'] = $this->Deposito_model->total_deposito();
            $this->data['get_serapan_deposito'] = $this->Deposito_model->serapan_deposito();
            $this->data['get_saldo_deposito'] = $this->Deposito_model->saldo_deposito();
			$this->data['get_total_tabungan'] = $this->Instansi_model->total_tabungan();
            $this->data['get_serapan_tabungan'] = $this->Instansi_model->serapan_tabungan();
            $this->data['get_saldo_tabungan'] = $this->Instansi_model->saldo_tabungan();
			$this->data['get_total_pinjaman'] = $this->Pembiayaan_model->total_pinjaman();
			$this->data['get_biaya_sewa'] = $this->Pembiayaan_model->biaya_sewa();
			$this->data['get_total_deposan'] = $this->Auth_model->get_total_deposan();
			$this->data['get_total_anggota'] = $this->Auth_model->get_total_anggota();
			$this->data['get_total_tabungan_deposito'] = $this->data['get_total_tabungan'] + $this->data['get_total_deposito'][0]->total_deposito;
			$this->data['get_total_serapan'] = $this->data['get_serapan_tabungan'][0]->resapan_tabungan + $this->data['get_serapan_deposito'][0]->resapan_deposito;
			$this->data['get_total_saldo'] = $this->data['get_saldo_tabungan'][0]->saldo_tabungan + $this->data['get_saldo_deposito'][0]->saldo_deposito;
		} elseif (is_masteradmin()) {
			$this->data['get_total_deposito'] = $this->Deposito_model->total_deposito_by_instansi();
            $this->data['get_serapan_deposito'] = $this->Deposito_model->serapan_deposito_by_instansi();
            $this->data['get_saldo_deposito'] = $this->Deposito_model->saldo_deposito_by_instansi();
			$this->data['get_total_tabungan'] = $this->Instansi_model->total_tabungan_by_instansi();
            $this->data['get_serapan_tabungan'] = $this->Instansi_model->serapan_tabungan_by_instansi();
            $this->data['get_saldo_tabungan'] = $this->Instansi_model->saldo_tabungan_by_instansi();
			$this->data['get_total_pinjaman'] = $this->Pembiayaan_model->total_pinjaman_by_instansi();
			$this->data['get_biaya_sewa'] = $this->Pembiayaan_model->biaya_sewa_by_instansi();
			$this->data['get_total_deposan'] = $this->Auth_model->get_total_deposan_by_instansi();
			$this->data['get_total_anggota'] = $this->Auth_model->get_total_anggota_by_instansi();
			$this->data['get_total_tabungan_deposito'] = $this->data['get_total_tabungan'] + $this->data['get_total_deposito'][0]->total_deposito;
			$this->data['get_total_serapan'] = $this->data['get_serapan_tabungan'][0]->resapan_tabungan + $this->data['get_serapan_deposito'][0]->resapan_deposito;
			$this->data['get_total_saldo'] = $this->data['get_saldo_tabungan'][0]->saldo_tabungan + $this->data['get_saldo_deposito'][0]->saldo_deposito;
		} elseif (is_superadmin()) {
			$this->data['get_total_deposito'] = $this->Deposito_model->total_deposito_by_cabang();
            $this->data['get_serapan_deposito'] = $this->Deposito_model->serapan_deposito_by_cabang();
            $this->data['get_saldo_deposito'] = $this->Deposito_model->saldo_deposito_by_cabang();
            $this->data['get_tabungan'] = $this->Cabang_model->get_by_id($this->session->cabang_id);
			$this->data['get_total_tabungan'] = $this->data['get_tabungan']->saldo_tabungan + $this->data['get_tabungan']->resapan_tabungan;
			$this->data['get_total_pinjaman'] = $this->Pembiayaan_model->total_pinjaman_by_cabang();
			$this->data['get_biaya_sewa'] = $this->Pembiayaan_model->biaya_sewa_by_cabang();
			$this->data['get_total_deposan'] = $this->Auth_model->get_total_deposan_by_cabang();
			$this->data['get_total_anggota'] = $this->Auth_model->get_total_anggota_by_cabang();
			$this->data['get_total_tabungan_deposito'] = $this->data['get_total_tabungan'] + $this->data['get_total_deposito'][0]->total_deposito;
			$this->data['get_total_serapan'] = $this->data['get_tabungan']->resapan_tabungan + $this->data['get_serapan_deposito'][0]->resapan_deposito;
			$this->data['get_total_saldo'] = $this->data['get_tabungan']->saldo_tabungan + $this->data['get_saldo_deposito'][0]->saldo_deposito;
		} elseif (is_admin()) {
			$this->data['deposito'] = $this->Deposito_model->get_by_user($this->session->id_users);
			$this->data['get_deposito'] = $this->Deposito_model->get_deposito_by_deposan();
			$this->data['get_basil'] = $this->Sumberdana_model->get_basil_for_deposan($this->data['get_deposito']->id_deposito);
			$this->data['get_basil_berjalan'] = $this->Sumberdana_model->get_basil_for_deposan_berjalan($this->data['get_deposito']->id_deposito);
		} elseif (is_pegawai()) {
			$this->data['total_pinjaman'] = $this->Pembiayaan_model->total_pinjaman_by_user($this->session->id_users);
			$biaya_sewa = $this->Pembiayaan_model->biaya_sewa_by_user($this->session->id_users);
			$this->data['get_tanggungan'] = $this->data['total_pinjaman'][0]->jml_pinjaman + $biaya_sewa[0]->biaya_sewa;
			$this->data['terbayar'] = $this->Pembiayaan_model->total_terbayar_by_user($this->session->id_users);
			$this->data['kekurangan_bayar'] = $this->data['get_tanggungan'] - $this->data['terbayar'][0]->jml_terbayar;
		}

		$this->load->view('back/dashboard/body', $this->data);
	}
}

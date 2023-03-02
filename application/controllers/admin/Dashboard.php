<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();

		$this->data['module'] = 'Dashboard';

		$this->data['instansi'] = $this->Instansi_model->get_by_id($this->session->instansi_id);

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
		} elseif (is_admin()) {
			$this->data['get_deposito'] = $this->Deposito_model->get_deposito_by_deposan();
			$this->data['get_basil'] = $this->Sumberdana_model->get_basil_for_deposan($this->data['get_deposito']->id_deposito);
		} elseif (is_pegawai()) {
			$this->data['get_pembiayaan'] = $this->Pembiayaan_model->get_pembiayaan_by_anggota();
			$this->data['get_tanggungan'] = $this->data['get_pembiayaan']->jml_pinjaman + $this->data['get_pembiayaan']->total_biaya_sewa;
			$this->data['kekurangan_bayar'] = $this->data['get_tanggungan'] - $this->data['get_pembiayaan']->jml_terbayar;
		}

		$this->load->view('back/dashboard/body', $this->data);
	}
}

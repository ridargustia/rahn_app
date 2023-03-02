<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Sumberdana_model extends CI_Model
{
    public $table = 'sumber_dana';
    public $id    = 'id_sumber_dana';
    public $order = 'DESC';

    function get_all()
    {
        $this->db->select('sumber_dana.id_sumber_dana, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, sumber_dana.persentase, sumber_dana.nominal, pembiayaan.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('pembiayaan', 'sumber_dana.pembiayaan_id = pembiayaan.id_pembiayaan');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.is_delete_pembiayaan', '0');
        $this->db->where('sumber_dana.deposito_id', NULL);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_instansi()
    {
        $this->db->select('sumber_dana.id_sumber_dana, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, sumber_dana.persentase, sumber_dana.nominal, pembiayaan.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('pembiayaan', 'sumber_dana.pembiayaan_id = pembiayaan.id_pembiayaan');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.is_delete_pembiayaan', '0');
        $this->db->where('sumber_dana.deposito_id', NULL);
        $this->db->where('pembiayaan.instansi_id', $this->session->instansi_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_cabang()
    {
        $this->db->select('sumber_dana.id_sumber_dana, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, sumber_dana.persentase, sumber_dana.nominal, pembiayaan.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('pembiayaan', 'sumber_dana.pembiayaan_id = pembiayaan.id_pembiayaan');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.is_delete_pembiayaan', '0');
        $this->db->where('sumber_dana.deposito_id', NULL);
        $this->db->where('pembiayaan.cabang_id', $this->session->cabang_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_deposan_by_pembiayaan($id_pembiayaan)
    {
        $this->db->select('sumber_dana.id_sumber_dana, sumber_dana.persentase, sumber_dana.nominal, sumber_dana.total_basil, sumber_dana.basil_for_deposan, sumber_dana.basil_for_lembaga, deposito.name');

        $this->db->join('deposito', 'sumber_dana.deposito_id = deposito.id_deposito', 'left');

        $this->db->where('pembiayaan_id', $id_pembiayaan);
        $this->db->where('deposito_id !=', NULL);
        $this->db->where('is_delete_sumber_dana', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_tabungan_by_pembiayaan($id_pembiayaan)
    {
        $this->db->select('sumber_dana.nominal, sumber_dana.total_basil, sumber_dana.persentase');

        $this->db->where('pembiayaan_id', $id_pembiayaan);
        $this->db->where('deposito_id', NULL);
        $this->db->where('is_delete_sumber_dana', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function count_basil_berjalan_by_deposan($id_deposito)
    {
        return $this->db->query('SELECT sum(basil_for_deposan) AS basil_for_deposan from sumber_dana where deposito_id = ' . $id_deposito)->result();
    }

    function get_pengguna_dana_by_deposan($id_deposito)
    {
        $this->db->select('sumber_dana.id_sumber_dana, pembiayaan.name, sumber_dana.nominal, sumber_dana.total_basil, sumber_dana.basil_for_deposan');

        $this->db->join('pembiayaan', 'sumber_dana.pembiayaan_id = pembiayaan.id_pembiayaan', 'left');

        $this->db->where('deposito_id', $id_deposito);
        $this->db->where('is_delete_sumber_dana', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function cek_available_data($id_pembiayaan)
    {
        $this->db->where('pembiayaan_id', $id_pembiayaan);

        return $this->db->get($this->table)->result();
    }

    function get_basil_for_deposan($id_deposito)
    {
        return $this->db->query('SELECT sum(basil_for_deposan) AS basil_for_deposan from sumber_dana where deposito_id = ' . $id_deposito)->row();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembiayaan_model extends CI_Model
{

    public $table = 'pembiayaan';
    public $id    = 'id_pembiayaan';
    public $order = 'DESC';

    function get_all()
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.jangka_waktu_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.image, pembiayaan.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_pembiayaan', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_instansi()
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.jangka_waktu_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.image, pembiayaan.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_pembiayaan', '0');
        $this->db->where('pembiayaan.instansi_id', $this->session->instansi_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_cabang()
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.jangka_waktu_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.image, pembiayaan.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_pembiayaan', '0');
        $this->db->where('pembiayaan.cabang_id', $this->session->cabang_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted()
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.name, pembiayaan.nik, pembiayaan.jml_pinjaman, pembiayaan.created_by');

        $this->db->where('is_delete_pembiayaan', '1');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_by_instansi()
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.name, pembiayaan.nik, pembiayaan.jml_pinjaman, pembiayaan.created_by');

        $this->db->where('is_delete_pembiayaan', '1');
        $this->db->where('pembiayaan.instansi_id', $this->session->instansi_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_by_cabang()
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.name, pembiayaan.nik, pembiayaan.jml_pinjaman, pembiayaan.created_by');

        $this->db->where('is_delete_pembiayaan', '1');
        $this->db->where('pembiayaan.cabang_id', $this->session->cabang_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows()
    {
        $this->db->where('is_delete_pembiayaan', '0');
        return $this->db->get($this->table)->num_rows();
    }

    function total_pinjaman()
    {
        return $this->db->query('SELECT sum(jml_pinjaman) AS total_pinjaman from pembiayaan where is_delete_pembiayaan = 0')->result();
    }

    function total_pinjaman_by_instansi()
    {
        return $this->db->query('SELECT sum(jml_pinjaman) AS total_pinjaman from pembiayaan where is_delete_pembiayaan = 0 AND instansi_id = ' . $this->session->instansi_id)->result();
    }

    function total_pinjaman_by_cabang()
    {
        return $this->db->query('SELECT sum(jml_pinjaman) AS total_pinjaman from pembiayaan where is_delete_pembiayaan = 0 AND cabang_id = ' . $this->session->cabang_id)->result();
    }

    function biaya_sewa()
    {
        return $this->db->query('SELECT sum(total_biaya_sewa) AS biaya_sewa from pembiayaan where is_delete_pembiayaan = 0')->result();
    }

    function biaya_sewa_by_instansi()
    {
        return $this->db->query('SELECT sum(total_biaya_sewa) AS biaya_sewa from pembiayaan where is_delete_pembiayaan = 0 AND instansi_id = ' . $this->session->instansi_id)->result();
    }

    function biaya_sewa_by_cabang()
    {
        return $this->db->query('SELECT sum(total_biaya_sewa) AS biaya_sewa from pembiayaan where is_delete_pembiayaan = 0 AND cabang_id = ' . $this->session->cabang_id)->result();
    }

    function total_pembiayaan()
    {
        return $this->db->query('SELECT sum(jml_pinjaman) AS jml_pinjaman from pembiayaan where is_delete_pembiayaan = 0')->result();
    }

    function get_detail_by_id($id)
    {
        $this->db->join('users', 'pembiayaan.user_id = users.id_users', 'left');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang', 'left');

        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_pembiayaan_by_anggota()
    {
        $this->db->where('user_id', $this->session->id_users);
        return $this->db->get($this->table)->row();
    }

    function get_pinjaman_by_user($id_user)
    {
        $this->db->where('user_id', $id_user);
        return $this->db->get($this->table)->row();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function soft_delete($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }
}

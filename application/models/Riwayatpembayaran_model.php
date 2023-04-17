<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayatpembayaran_model extends CI_Model
{
    public $table = 'riwayat_pembayaran';
    public $id    = 'id_riwayat_pembayaran';
    public $order = 'DESC';

    function get_all_riwayat_pembayaran_by_pembiayaan($id_pembiayaan)
    {
        $this->db->select('riwayat_pembayaran.id_riwayat_pembayaran, riwayat_pembayaran.no_invoice, riwayat_pembayaran.nominal, riwayat_pembayaran.created_by, riwayat_pembayaran.created_at');

        $this->db->where('pembiayaan_id', $id_pembiayaan);
        $this->db->where('is_delete_riwayat_pembayaran', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_pembiayaan_from_riwayat_pembayaran()
    {
        $this->db->select('riwayat_pembayaran.pembiayaan_id');

        $this->db->where('is_delete_riwayat_pembayaran', '0');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_pembiayaan = array();
            $result_id_pembiayaan = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->pembiayaan_id, $id_pembiayaan, true)){
                    array_push($id_pembiayaan, $row->pembiayaan_id);
                }
            }

            for ($i = 0; $i < count($id_pembiayaan); $i++) {
                $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, instansi.instansi_name, cabang.cabang_name, users.no_anggota');

                $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
                $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');
                $this->db->join('users', 'pembiayaan.user_id = users.id_users');

                $this->db->where('id_pembiayaan', $id_pembiayaan[$i]);
                $this->db->where('is_delete_pembiayaan', '0');

                $data_pembiayaan = $this->db->get('pembiayaan')->row();

                array_push($result_id_pembiayaan, $data_pembiayaan);
            }

            return (object) $result_id_pembiayaan;
        }
    }

    function get_all_pembiayaan_from_riwayat_pembayaran_by_instansi()
    {
        $this->db->select('riwayat_pembayaran.pembiayaan_id');

        $this->db->where('instansi_id', $this->session->instansi_id);
        $this->db->where('is_delete_riwayat_pembayaran', '0');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_pembiayaan = array();
            $result_id_pembiayaan = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->pembiayaan_id, $id_pembiayaan, true)){
                    array_push($id_pembiayaan, $row->pembiayaan_id);
                }
            }

            for ($i = 0; $i < count($id_pembiayaan); $i++) {
                $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, cabang.cabang_name, users.no_anggota');

                $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');
                $this->db->join('users', 'pembiayaan.user_id = users.id_users');

                $this->db->where('id_pembiayaan', $id_pembiayaan[$i]);
                $this->db->where('is_delete_pembiayaan', '0');

                $data_pembiayaan = $this->db->get('pembiayaan')->row();

                array_push($result_id_pembiayaan, $data_pembiayaan);
            }

            return (object) $result_id_pembiayaan;
        }
    }

    function get_all_pembiayaan_from_riwayat_pembayaran_by_cabang()
    {
        $this->db->select('riwayat_pembayaran.pembiayaan_id');

        $this->db->where('cabang_id', $this->session->cabang_id);
        $this->db->where('is_delete_riwayat_pembayaran', '0');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_pembiayaan = array();
            $result_id_pembiayaan = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->pembiayaan_id, $id_pembiayaan, true)){
                    array_push($id_pembiayaan, $row->pembiayaan_id);
                }
            }

            for ($i = 0; $i < count($id_pembiayaan); $i++) {
                $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, users.no_anggota');

                $this->db->join('users', 'pembiayaan.user_id = users.id_users');

                $this->db->where('id_pembiayaan', $id_pembiayaan[$i]);
                $this->db->where('is_delete_pembiayaan', '0');

                $data_pembiayaan = $this->db->get('pembiayaan')->row();

                array_push($result_id_pembiayaan, $data_pembiayaan);
            }

            return (object) $result_id_pembiayaan;
        }
    }

    function get_by_id($id)
    {
        $this->db->select('riwayat_pembayaran.id_riwayat_pembayaran, riwayat_pembayaran.no_invoice, riwayat_pembayaran.nominal, riwayat_pembayaran.terbayar, riwayat_pembayaran.kekurangan_bayar, riwayat_pembayaran.created_by, riwayat_pembayaran.created_at, instansi.instansi_name, cabang.cabang_name, pembiayaan.no_pinjaman, pembiayaan.jml_pinjaman, pembiayaan.total_biaya_sewa');

        $this->db->join('instansi', 'riwayat_pembayaran.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'riwayat_pembayaran.cabang_id = cabang.id_cabang');
        $this->db->join('pembiayaan', 'riwayat_pembayaran.pembiayaan_id = pembiayaan.id_pembiayaan');

        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }
}
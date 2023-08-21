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
        $this->db->select('pembiayaan.user_id');

        $this->db->where('is_delete_pembiayaan', '1');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_user = array();
            $result_id_user = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->user_id, $id_user, true)){
                    array_push($id_user, $row->user_id);
                }
            }

            for ($i = 0; $i < count($id_user); $i++) {
                $this->db->select('users.id_users, users.no_anggota, users.name, users.created_by');

                $this->db->where('id_users', $id_user[$i]);
                $this->db->where('is_delete', '1');

                $data_user = $this->db->get('users')->row();

                array_push($result_id_user, $data_user);
            }

            return (object) $result_id_user;
        }

    }

    function get_all_deleted_by_instansi()
    {
        $this->db->select('pembiayaan.user_id');

        $this->db->where('pembiayaan.instansi_id', $this->session->instansi_id);
        $this->db->where('is_delete_pembiayaan', '1');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_user = array();
            $result_id_user = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->user_id, $id_user, true)){
                    array_push($id_user, $row->user_id);
                }
            }

            for ($i = 0; $i < count($id_user); $i++) {
                $this->db->select('users.id_users, users.no_anggota, users.name, users.created_by');

                $this->db->where('id_users', $id_user[$i]);
                $this->db->where('is_delete', '1');

                $data_user = $this->db->get('users')->row();

                array_push($result_id_user, $data_user);
            }

            return (object) $result_id_user;
        }
    }

    function get_all_deleted_by_cabang()
    {
        $this->db->select('pembiayaan.user_id');

        $this->db->where('pembiayaan.cabang_id', $this->session->cabang_id);
        $this->db->where('is_delete_pembiayaan', '1');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_user = array();
            $result_id_user = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->user_id, $id_user, true)){
                    array_push($id_user, $row->user_id);
                }
            }

            for ($i = 0; $i < count($id_user); $i++) {
                $this->db->select('users.id_users, users.no_anggota, users.name, users.created_by');

                $this->db->where('id_users', $id_user[$i]);
                $this->db->where('is_delete', '1');

                $data_user = $this->db->get('users')->row();

                array_push($result_id_user, $data_user);
            }

            return (object) $result_id_user;
        }
    }

    function get_all_anggota_from_pembiayaan()
    {
        $this->db->select('pembiayaan.user_id');

        $this->db->where('is_delete_pembiayaan', '0');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_user = array();
            $result_id_user = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->user_id, $id_user, true)){
                    array_push($id_user, $row->user_id);
                }
            }

            for ($i = 0; $i < count($id_user); $i++) {
                $this->db->select('users.id_users, users.no_anggota, users.name, users.created_by');

                $this->db->where('id_users', $id_user[$i]);
                $this->db->where('is_delete', '0');

                $data_user = $this->db->get('users')->row();

                array_push($result_id_user, $data_user);
            }

            return (object) $result_id_user;
        }
    }

    function get_all_anggota_from_pembiayaan_by_instansi()
    {
        $this->db->select('pembiayaan.user_id');

        $this->db->where('instansi_id', $this->session->instansi_id);
        $this->db->where('is_delete_pembiayaan', '0');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_user = array();
            $result_id_user = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->user_id, $id_user, true)){
                    array_push($id_user, $row->user_id);
                }
            }

            for ($i = 0; $i < count($id_user); $i++) {
                $this->db->select('users.id_users, users.no_anggota, users.name, users.created_by');

                $this->db->where('id_users', $id_user[$i]);
                $this->db->where('is_delete', '0');

                $data_user = $this->db->get('users')->row();

                array_push($result_id_user, $data_user);
            }

            return (object) $result_id_user;
        }
    }

    function get_all_anggota_from_pembiayaan_by_cabang()
    {
        $this->db->select('pembiayaan.user_id');

        $this->db->where('cabang_id', $this->session->cabang_id);
        $this->db->where('is_delete_pembiayaan', '0');

        $this->db->order_by($this->id, $this->order);

        $data = $this->db->get($this->table);

        if ($data->num_rows() > 0) {
            $id_user = array();
            $result_id_user = array();

            foreach ($data->result() as $row) {
                if(!in_array($row->user_id, $id_user, true)){
                    array_push($id_user, $row->user_id);
                }
            }

            for ($i = 0; $i < count($id_user); $i++) {
                $this->db->select('users.id_users, users.no_anggota, users.name, users.created_by');

                $this->db->where('id_users', $id_user[$i]);
                $this->db->where('is_delete', '0');

                $data_user = $this->db->get('users')->row();

                array_push($result_id_user, $data_user);
            }

            return (object) $result_id_user;
        }
    }

    function get_all_pembiayaan_by_user($id_user)
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.jangka_waktu_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.jml_terbayar, pembiayaan.status_pembayaran, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.image, pembiayaan.created_by, pembiayaan.created_at, pembiayaan.instansi_id, pembiayaan.cabang_id, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.user_id', $id_user);
        $this->db->where('is_delete_pembiayaan', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_pembiayaan_by_user($id_user)
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.jangka_waktu_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.jml_terbayar, pembiayaan.status_pembayaran, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.image, pembiayaan.created_by, pembiayaan.created_at, pembiayaan.instansi_id, pembiayaan.cabang_id, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.user_id', $id_user);
        $this->db->where('is_delete_pembiayaan', '1');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_pembiayaan_by_anggota()
    {
        $this->db->select('pembiayaan.id_pembiayaan, pembiayaan.no_pinjaman, pembiayaan.jml_pinjaman, pembiayaan.created_at');

        $this->db->where('pembiayaan.user_id', $this->session->id_users);
        $this->db->where('pembiayaan.is_delete_pembiayaan', 0);

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

    function total_pinjaman_by_user($id_user)
    {
        return $this->db->query('SELECT sum(jml_pinjaman) AS jml_pinjaman from pembiayaan where is_delete_pembiayaan = 0 AND user_id = ' . $id_user)->result();
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

    function biaya_sewa_by_user($id_user)
    {
        return $this->db->query('SELECT sum(total_biaya_sewa) AS biaya_sewa from pembiayaan where is_delete_pembiayaan = 0 AND user_id = ' . $id_user)->result();
    }

    function biaya_sewa_berjalan()
    {
        $basil_for_deposan_berjalan = $this->db->query('SELECT sum(basil_for_deposan_berjalan) AS basil_for_deposan_berjalan from sumber_dana where is_delete_sumber_dana = 0')->result();

        $basil_for_lembaga_berjalan = $this->db->query('SELECT sum(basil_for_lembaga_berjalan) AS basil_for_lembaga_berjalan from sumber_dana where is_delete_sumber_dana = 0')->result();

        return $basil_for_deposan_berjalan[0]->basil_for_deposan_berjalan + $basil_for_lembaga_berjalan[0]->basil_for_lembaga_berjalan;
    }

    function biaya_sewa_berjalan_by_instansi()
    {
        $basil_for_deposan_berjalan = $this->db->query('SELECT sum(basil_for_deposan_berjalan) AS basil_for_deposan_berjalan from sumber_dana INNER JOIN pembiayaan ON sumber_dana.pembiayaan_id = pembiayaan.id_pembiayaan where is_delete_sumber_dana = 0 AND instansi_id = ' . $this->session->instansi_id)->result();

        $basil_for_lembaga_berjalan = $this->db->query('SELECT sum(basil_for_lembaga_berjalan) AS basil_for_lembaga_berjalan from sumber_dana INNER JOIN pembiayaan ON sumber_dana.pembiayaan_id = pembiayaan.id_pembiayaan where is_delete_sumber_dana = 0 AND instansi_id = ' . $this->session->instansi_id)->result();

        return $basil_for_deposan_berjalan[0]->basil_for_deposan_berjalan + $basil_for_lembaga_berjalan[0]->basil_for_lembaga_berjalan;
    }

    function biaya_sewa_berjalan_by_cabang()
    {
        $basil_for_deposan_berjalan = $this->db->query('SELECT sum(basil_for_deposan_berjalan) AS basil_for_deposan_berjalan from sumber_dana where is_delete_sumber_dana = 0')->result();

        $basil_for_lembaga_berjalan = $this->db->query('SELECT sum(basil_for_lembaga_berjalan) AS basil_for_lembaga_berjalan from sumber_dana where is_delete_sumber_dana = 0')->result();

        return $basil_for_deposan_berjalan[0]->basil_for_deposan_berjalan + $basil_for_lembaga_berjalan[0]->basil_for_lembaga_berjalan;
    }

    function total_pembiayaan()
    {
        return $this->db->query('SELECT sum(jml_pinjaman) AS jml_pinjaman from pembiayaan where is_delete_pembiayaan = 0')->result();
    }

    function total_terbayar_by_user($id_user)
    {
        return $this->db->query('SELECT sum(jml_terbayar) AS jml_terbayar from pembiayaan where is_delete_pembiayaan = 0 AND user_id = ' . $id_user)->result();
    }

    function get_detail_by_id($id)
    {
        $this->db->join('users', 'pembiayaan.user_id = users.id_users', 'left');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang', 'left');

        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }

    function get_all_laporan()
    {
        $this->db->select('users.no_anggota, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, instansi.instansi_name, cabang.cabang_name, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.jml_terbayar, pembiayaan.status_pembayaran, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.created_by, pembiayaan.created_at');

        $this->db->join('users', 'pembiayaan.user_id = users.id_users');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.is_delete_pembiayaan', 0);

        $this->db->order_by('pembiayaan.id_pembiayaan', 'ASC');

        return $this->db->get($this->table)->result();
    }

    function get_all_by_instansi_laporan()
    {
        $this->db->select('users.no_anggota, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, instansi.instansi_name, cabang.cabang_name, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.jml_terbayar, pembiayaan.status_pembayaran, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.created_by, pembiayaan.created_at');

        $this->db->join('users', 'pembiayaan.user_id = users.id_users');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.instansi_id', $this->session->instansi_id);
        $this->db->where('pembiayaan.is_delete_pembiayaan', 0);

        $this->db->order_by('pembiayaan.id_pembiayaan', 'ASC');

        return $this->db->get($this->table)->result();
    }

    function get_all_by_cabang_laporan()
    {
        $this->db->select('users.no_anggota, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, instansi.instansi_name, cabang.cabang_name, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.jml_terbayar, pembiayaan.status_pembayaran, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.created_by, pembiayaan.created_at');

        $this->db->join('users', 'pembiayaan.user_id = users.id_users');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.instansi_id', $this->session->instansi_id);
        $this->db->where('pembiayaan.cabang_id', $this->session->cabang_id);
        $this->db->where('pembiayaan.is_delete_pembiayaan', 0);

        $this->db->order_by('pembiayaan.id_pembiayaan', 'ASC');

        return $this->db->get($this->table)->result();
    }

    function get_all_periode($tgl_mulai, $tgl_akhir)
    {
        $this->db->select('users.no_anggota, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, instansi.instansi_name, cabang.cabang_name, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.jml_terbayar, pembiayaan.status_pembayaran, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.created_by, pembiayaan.created_at');

        $this->db->join('users', 'pembiayaan.user_id = users.id_users');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.is_delete_pembiayaan', 0);
        $this->db->where('pembiayaan.created_at >=', $tgl_mulai);
        $this->db->where('pembiayaan.created_at <=', $tgl_akhir);

        $this->db->order_by('pembiayaan.id_pembiayaan', 'ASC');

        return $this->db->get($this->table)->result();
    }

    function get_all_periode_by_instansi($tgl_mulai, $tgl_akhir)
    {
        $this->db->select('users.no_anggota, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, instansi.instansi_name, cabang.cabang_name, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.jml_terbayar, pembiayaan.status_pembayaran, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.created_by, pembiayaan.created_at');

        $this->db->join('users', 'pembiayaan.user_id = users.id_users');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.instansi_id', $this->session->instansi_id);
        $this->db->where('pembiayaan.is_delete_pembiayaan', 0);
        $this->db->where('pembiayaan.created_at >=', $tgl_mulai);
        $this->db->where('pembiayaan.created_at <=', $tgl_akhir);

        $this->db->order_by('pembiayaan.id_pembiayaan', 'ASC');

        return $this->db->get($this->table)->result();
    }

    function get_all_periode_by_cabang($tgl_mulai, $tgl_akhir)
    {
        $this->db->select('users.no_anggota, pembiayaan.no_pinjaman, pembiayaan.name, pembiayaan.nik, pembiayaan.address, pembiayaan.email, pembiayaan.phone, instansi.instansi_name, cabang.cabang_name, pembiayaan.jml_pinjaman, pembiayaan.jangka_waktu_pinjam, pembiayaan.jenis_barang_gadai, pembiayaan.berat_barang_gadai, pembiayaan.waktu_gadai, pembiayaan.jatuh_tempo_gadai, pembiayaan.sewa_tempat_perbulan, pembiayaan.total_biaya_sewa, pembiayaan.jml_terbayar, pembiayaan.status_pembayaran, pembiayaan.sistem_pembayaran_sewa, pembiayaan.sumber_dana, pembiayaan.created_by, pembiayaan.created_at');

        $this->db->join('users', 'pembiayaan.user_id = users.id_users');
        $this->db->join('instansi', 'pembiayaan.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'pembiayaan.cabang_id = cabang.id_cabang');

        $this->db->where('pembiayaan.instansi_id', $this->session->instansi_id);
        $this->db->where('pembiayaan.cabang_id', $this->session->cabang_id);
        $this->db->where('pembiayaan.is_delete_pembiayaan', 0);
        $this->db->where('pembiayaan.created_at >=', $tgl_mulai);
        $this->db->where('pembiayaan.created_at <=', $tgl_akhir);

        $this->db->order_by('pembiayaan.id_pembiayaan', 'ASC');

        return $this->db->get($this->table)->result();
    }

    function get_by_user_id($user_id)
    {
        $this->db->where('user_id', $user_id);
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

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposito_model extends CI_Model
{

    public $table = 'deposito';
    public $id    = 'id_deposito';
    public $order = 'DESC';

    function get_all()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.resapan_deposito, deposito.saldo_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_deposito', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_instansi()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.resapan_deposito, deposito.saldo_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_deposito', '0');
        $this->db->where('deposito.instansi_id', $this->session->instansi_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_cabang()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.resapan_deposito, deposito.saldo_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_deposito', '0');
        $this->db->where('deposito.cabang_id', $this->session->cabang_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_cabang_for_grandadmin_masteradmin($id_cabang)
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.resapan_deposito, deposito.saldo_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_deposito', '0');
        $this->db->where('deposito.cabang_id', $id_cabang);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by');

        $this->db->where('is_delete_deposito', '1');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_by_instansi()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by');

        $this->db->where('is_delete_deposito', '1');
        $this->db->where('deposito.instansi_id', $this->session->instansi_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_deleted_by_cabang()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by');

        $this->db->where('is_delete_deposito', '1');
        $this->db->where('deposito.cabang_id', $this->session->cabang_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function total_rows()
    {
        $this->db->where('is_delete_deposito', '0');
        return $this->db->get($this->table)->num_rows();
    }

    function total_deposito()
    {
        return $this->db->query('SELECT sum(total_deposito) AS total_deposito from deposito where is_delete_deposito = 0')->result();
    }

    function total_deposito_by_instansi()
    {
        return $this->db->query('SELECT sum(total_deposito) AS total_deposito from deposito where is_delete_deposito = 0 AND instansi_id = ' . $this->session->instansi_id)->result();
    }

    function total_deposito_by_cabang()
    {
        return $this->db->query('SELECT sum(total_deposito) AS total_deposito from deposito where is_delete_deposito = 0 AND cabang_id = ' . $this->session->cabang_id)->result();
    }

    function serapan_deposito()
    {
        return $this->db->query('SELECT sum(resapan_deposito) AS resapan_deposito from deposito where is_delete_deposito = 0')->result();
    }

    function serapan_deposito_by_instansi()
    {
        return $this->db->query('SELECT sum(resapan_deposito) AS resapan_deposito from deposito where is_delete_deposito = 0 AND instansi_id = ' . $this->session->instansi_id)->result();
    }

    function serapan_deposito_by_cabang()
    {
        return $this->db->query('SELECT sum(resapan_deposito) AS resapan_deposito from deposito where is_delete_deposito = 0 AND cabang_id = ' . $this->session->cabang_id)->result();
    }

    function saldo_deposito()
    {
        return $this->db->query('SELECT sum(saldo_deposito) AS saldo_deposito from deposito where is_delete_deposito = 0')->result();
    }

    function saldo_deposito_by_instansi()
    {
        return $this->db->query('SELECT sum(saldo_deposito) AS saldo_deposito from deposito where is_delete_deposito = 0 AND instansi_id = ' . $this->session->instansi_id)->result();
    }

    function saldo_deposito_by_cabang()
    {
        return $this->db->query('SELECT sum(saldo_deposito) AS saldo_deposito from deposito where is_delete_deposito = 0 AND cabang_id = ' . $this->session->cabang_id)->result();
    }

    function get_deposito_by_deposan()
    {
        $this->db->where('user_id', $this->session->id_users);

        return $this->db->get($this->table)->row();
    }

    function check_activated()
    {
        $this->db->select('deposito.id_deposito, deposito.jatuh_tempo, deposito.is_active');

        $this->db->where('is_delete_deposito', 0);

        $result = $this->db->get($this->table)->result();

        foreach ($result as $data) {
            if ($data->is_active == 1) {
                if (date('Y-m-d', strtotime($data->jatuh_tempo)) < date('Y-m-d')) {
                    $this->Deposito_model->update($data->id_deposito, array('is_active' => 0));

                    $data_sumber_dana = $this->Sumberdana_model->get_all_by_deposito($data->id_deposito);

                    foreach ($data_sumber_dana as $sumber_dana) {
                        $waktu_gadai = new DateTime($sumber_dana->waktu_gadai);
                        $today = new DateTime(date('Y-m-d'));

                        $different_time = $today->diff($waktu_gadai);

                        if ($different_time->m > 0) {
                            // BASIL FOR DEPOSAN BERJALAN
                            $biaya_sewa_for_deposan_perbulan = $sumber_dana->basil_for_deposan / $sumber_dana->jangka_waktu_pinjam;
                            $basil_for_deposan_bulan_berjalan = $biaya_sewa_for_deposan_perbulan * $different_time->m;

                            // BASIL FOR LEMBAGA BERJALAN
                            $biaya_sewa_for_lembaga_perbulan = $sumber_dana->basil_for_lembaga / $sumber_dana->jangka_waktu_pinjam;
                            $basil_for_lembaga_bulan_berjalan = $biaya_sewa_for_lembaga_perbulan * $different_time->m;

                            // UPDATE TOTAL BASIL, BASIL FOR DEPOSAN, BASIL FOR LEMBAGA
                            $basil_perbulan = $sumber_dana->total_basil / $sumber_dana->jangka_waktu_pinjam;
                            $total_basil_bulan_berjalan = $basil_perbulan * $different_time->m;

                            $new_sumber_dana_deposito = array(
                                'total_basil'                   => $total_basil_bulan_berjalan,
                                'basil_for_deposan'             => $basil_for_deposan_bulan_berjalan,
                                'basil_for_lembaga'             => $basil_for_lembaga_bulan_berjalan,
                                'basil_for_deposan_berjalan'    => $basil_for_deposan_bulan_berjalan,
                                'basil_for_lembaga_berjalan'    => $basil_for_lembaga_bulan_berjalan,
                                'status_pembayaran'             => 1,
                            );

                            // UPDATE DATA SUMBER DANA BY ID
                            $this->Sumberdana_model->update($sumber_dana->id_sumber_dana, $new_sumber_dana_deposito);
                        }

                        // TAMBAH DATA SUMBER DANA DARI TABUNGAN
                        $total_basil_sisa = $sumber_dana->total_basil - $total_basil_bulan_berjalan;

                        $new_sumber_dana_tabungan = array(
                            'pembiayaan_id'     => $sumber_dana->pembiayaan_id,
                            'deposito_id'       => NULL,
                            'persentase'        => $sumber_dana->persentase,
                            'nominal'           => $sumber_dana->nominal,
                            'total_basil'       => $total_basil_sisa,
                            'basil_for_lembaga' => $total_basil_sisa,
                            'created_by'        => $this->session->username,
                        );

                        $this->Sumberdana_model->insert($new_sumber_dana_tabungan);
                    }

                } elseif (date('Y-m-d', strtotime($data->jatuh_tempo)) >= date('Y-m-d')) {
                    $this->Deposito_model->update($data->id_deposito, array('is_active' => 1));
                }
            }
        }
    }

    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
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

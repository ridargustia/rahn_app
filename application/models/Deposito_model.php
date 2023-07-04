<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Deposito_model extends CI_Model
{

    public $table = 'deposito';
    public $id    = 'id_deposito';
    public $order = 'DESC';

    function get_all()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.resapan_deposito, deposito.saldo_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by, instansi.instansi_name, cabang.cabang_name, deposito.is_active');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_deposito', '0');

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_instansi()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.resapan_deposito, deposito.saldo_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by, instansi.instansi_name, cabang.cabang_name, deposito.is_active');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_deposito', '0');
        $this->db->where('deposito.instansi_id', $this->session->instansi_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_cabang()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.resapan_deposito, deposito.saldo_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by, instansi.instansi_name, cabang.cabang_name, deposito.is_active');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_deposito', '0');
        $this->db->where('deposito.cabang_id', $this->session->cabang_id);

        $this->db->order_by($this->id, $this->order);

        return $this->db->get($this->table)->result();
    }

    function get_all_by_cabang_for_superadmin()
    {
        $this->db->select('deposito.id_deposito, deposito.name, deposito.nik, deposito.address, deposito.email, deposito.phone, deposito.total_deposito, deposito.resapan_deposito, deposito.saldo_deposito, deposito.jangka_waktu, deposito.waktu_deposito, deposito.jatuh_tempo, deposito.bagi_hasil, deposito.created_by, instansi.instansi_name, cabang.cabang_name');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi', 'left');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang', 'left');

        $this->db->where('is_delete_deposito', '0');
        $this->db->where('deposito.cabang_id', $this->session->cabang_id);
        $this->db->where('deposito.is_active', 1);

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
        $this->db->where('deposito.is_active', 1);

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
        $this->db->select('deposito.id_deposito, deposito.instansi_id, deposito.cabang_id, deposito.jatuh_tempo, deposito.is_active, deposito.saldo_deposito, deposito.resapan_deposito, instansi.resapan_tabungan as instansi_resapan_tabungan, instansi.saldo_tabungan as instansi_saldo_tabungan, cabang.resapan_tabungan as cabang_resapan_tabungan, cabang.saldo_tabungan as cabang_saldo_tabungan');

        $this->db->join('instansi', 'deposito.instansi_id = instansi.id_instansi');
        $this->db->join('cabang', 'deposito.cabang_id = cabang.id_cabang');

        $this->db->where('is_delete_deposito', 0);

        $result = $this->db->get($this->table)->result();

        foreach ($result as $data) {
            if ($data->is_active == 1) {
                if (date('Y-m-d', strtotime($data->jatuh_tempo)) < date('Y-m-d')) {
                    $this->Deposito_model->update($data->id_deposito, array('is_active' => 0));

                    $data_sumber_dana = $this->Sumberdana_model->get_all_by_deposito($data->id_deposito);

                    // Deklarasi Variabel
                    $resapan_tabungan_instansi = $data->instansi_resapan_tabungan;
                    $saldo_tabungan_instansi = $data->instansi_saldo_tabungan;
                    $resapan_tabungan_cabang = $data->cabang_resapan_tabungan;
                    $saldo_tabungan_cabang = $data->cabang_saldo_tabungan;
                    $saldo_deposito = $data->saldo_deposito;
                    $resapan_deposito = $data->resapan_deposito;

                    foreach ($data_sumber_dana as $sumber_dana) {
                        //MANIPULASI DATA INSTANSI
                        $resapan_tabungan_instansi = $resapan_tabungan_instansi + $sumber_dana->nominal;
                        $saldo_tabungan_instansi = $saldo_tabungan_instansi - $sumber_dana->nominal;

                        //MANIPULASI DATA CABANG
                        $resapan_tabungan_cabang = $resapan_tabungan_cabang + $sumber_dana->nominal;
                        $saldo_tabungan_cabang = $saldo_tabungan_cabang - $sumber_dana->nominal;

                        // MANIPULASI DATA DEPOSITO
                        $saldo_deposito = $saldo_deposito + $sumber_dana->nominal;
                        $resapan_deposito = $resapan_deposito - $sumber_dana->nominal;

                    }

                    // UPDATE DATA INSTANSI
                    $data_instansi_baru = array(
                        'saldo_tabungan'    => $saldo_tabungan_instansi,
                        'resapan_tabungan'  => $resapan_tabungan_instansi,
                    );

                    $this->Instansi_model->update($data->instansi_id, $data_instansi_baru);

                    // UPDATE DATA CABANG
                    $data_cabang_baru = array(
                        'saldo_tabungan'    => $saldo_tabungan_cabang,
                        'resapan_tabungan'  => $resapan_tabungan_cabang,
                    );

                    $this->Cabang_model->update($data->cabang_id, $data_cabang_baru);

                    // UPDATE DATA DEPOSITO
                    $data_deposito_baru = array(
                        'saldo_deposito'    => $saldo_deposito,
                        'resapan_deposito'  => $resapan_deposito,
                    );

                    $this->Deposito_model->update($data->id_deposito, $data_deposito_baru);


                    // MANIPULASI TABEL SUMBER DANA
                    foreach ($data_sumber_dana as $sumber_dana) {

                        $waktu_gadai = strtotime($sumber_dana->waktu_gadai);
                        $today = strtotime(date('Y-m-d'));

                        $different_time = (date("Y", $today) - date("Y", $waktu_gadai)) * 12;
                        $different_time += date("m", $today) - date("m", $waktu_gadai);

                        if ($different_time > 0) {
                            // BASIL FOR DEPOSAN BERJALAN
                            $biaya_sewa_for_deposan_perbulan = $sumber_dana->basil_for_deposan / $sumber_dana->jangka_waktu_pinjam;
                            $basil_for_deposan_bulan_berjalan = $biaya_sewa_for_deposan_perbulan * $different_time;

                            // BASIL FOR LEMBAGA BERJALAN
                            $biaya_sewa_for_lembaga_perbulan = $sumber_dana->basil_for_lembaga / $sumber_dana->jangka_waktu_pinjam;
                            $basil_for_lembaga_bulan_berjalan = $biaya_sewa_for_lembaga_perbulan * $different_time;

                            // UPDATE TOTAL BASIL, BASIL FOR DEPOSAN, BASIL FOR LEMBAGA
                            $basil_perbulan = $sumber_dana->total_basil / $sumber_dana->jangka_waktu_pinjam;
                            $total_basil_bulan_berjalan = $basil_perbulan * $different_time;

                            // UPDATE DATA SUMBER DANA BY ID
                            $new_sumber_dana_deposito = array(
                                'total_basil'                   => $total_basil_bulan_berjalan,
                                'basil_for_deposan'             => $basil_for_deposan_bulan_berjalan,
                                'basil_for_lembaga'             => $basil_for_lembaga_bulan_berjalan,
                                'basil_for_deposan_berjalan'    => $basil_for_deposan_bulan_berjalan,
                                'basil_for_lembaga_berjalan'    => $basil_for_lembaga_bulan_berjalan,
                                'status_pembayaran'             => 1,
                                'is_change'                     => 1,
                            );

                            $this->Sumberdana_model->update($sumber_dana->id_sumber_dana, $new_sumber_dana_deposito);

                            if ($sumber_dana->basil_for_deposan_berjalan < $sumber_dana->basil_for_deposan && $sumber_dana->basil_for_lembaga_berjalan < $sumber_dana->basil_for_lembaga) {
                                // Planning: Jumlah terbayar dikurangi basil_for_deposan_berjalan dan basil_for_lembaga_berjalan
                                $sumber_dana_by_pembiayaan = $this->Sumberdana_model->get_all_sumberdana_by_pembiayaan($sumber_dana->pembiayaan_id);
                                $pembiayaan = $this->Pembiayaan_model->get_by_id($sumber_dana->pembiayaan_id);

                                $total_basil_berjalan_by_pembiayaan = 0;

                                foreach ($sumber_dana_by_pembiayaan as $data) {
                                    $total_basil_berjalan_by_pembiayaan = $total_basil_berjalan_by_pembiayaan + ($data->basil_for_deposan_berjalan + $data->basil_for_lembaga_berjalan);
                                }

                                $selisih_basil_berjalan = $total_basil_berjalan_by_pembiayaan - $pembiayaan->jml_terbayar; // Sisa -700.000

                                if ($selisih_basil_berjalan > 0) {
                                    $basil_for_lembaga_berjalan = $selisih_basil_berjalan*70/100;   // 455.000
                                    $basil_for_deposan_berjalan = $selisih_basil_berjalan*30/100;   // 195.000

                                    $result_basil_for_lembaga_berjalan = $basil_for_lembaga_bulan_berjalan - $basil_for_lembaga_berjalan; // 1.155.000 - 455.000 = 700.000
                                    $result_basil_for_deposan_berjalan = $basil_for_deposan_bulan_berjalan - $basil_for_deposan_berjalan; // 495.000 - 195.000 = 300.000

                                    $total_basil_bulan_berjalan = $total_basil_bulan_berjalan - $selisih_basil_berjalan; //     1.650.000 - 650.000 = 1.000.000

                                    // UPDATE DATA SUMBER DANA BY ID
                                    $new_sumber_dana_deposito = array(
                                        'total_basil'                   => $total_basil_bulan_berjalan,
                                        'basil_for_deposan'             => $result_basil_for_deposan_berjalan,
                                        'basil_for_lembaga'             => $result_basil_for_lembaga_berjalan,
                                        'basil_for_deposan_berjalan'    => $result_basil_for_deposan_berjalan,
                                        'basil_for_lembaga_berjalan'    => $result_basil_for_lembaga_berjalan,
                                        'status_pembayaran'             => 1,
                                        'is_change'                     => 1,
                                    );

                                    $this->Sumberdana_model->update($sumber_dana->id_sumber_dana, $new_sumber_dana_deposito);

                                } elseif ($selisih_basil_berjalan < 0) {
                                    $sumber_dana_by_pembiayaan = $this->Sumberdana_model->get_all_by_pembiayaan_non_onchange($sumber_dana->pembiayaan_id)->result();
                                    $count_sumber_dana_by_pembiayaan = $this->Sumberdana_model->get_all_by_pembiayaan_non_onchange($sumber_dana->pembiayaan_id)->num_rows();

                                    if ($count_sumber_dana_by_pembiayaan > 0) {
                                        $pembagian_basil = $selisih_basil_berjalan / (-$count_sumber_dana_by_pembiayaan);   // -700.000 / -1 = 700.000

                                        foreach ($sumber_dana_by_pembiayaan as $data) {
                                            $pembagian_basil_for_lembaga =  $data->basil_for_lembaga_berjalan + ($pembagian_basil*70/100);  // 700.000 + 490.000 = 1.190.000
                                            $pembagian_basil_for_deposan = $data->basil_for_deposan_berjalan + ($pembagian_basil*30/100);   // 300.000 + 210.000 = 510.000

                                            //Nominal cicilan lebih besar dari basil for lembaga
                                            if ($pembagian_basil_for_lembaga > $data->basil_for_lembaga) {
                                                //Update ke database by id sumber dana
                                                $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $data->basil_for_lembaga));
                                            } else {
                                                //Update ke database by id sumber dana
                                                $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_lembaga_berjalan' => $pembagian_basil_for_lembaga));
                                            }

                                            //Nominal cicilan lebih besar dari basil for deposan
                                            if ($pembagian_basil_for_deposan > $data->basil_for_deposan) {
                                                //Update ke database by id sumber dana
                                                $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_deposan_berjalan' => $data->basil_for_deposan));
                                            } else {
                                                //Update ke database by id sumber dana
                                                $this->Sumberdana_model->update($data->id_sumber_dana, array('basil_for_deposan_berjalan' => $pembagian_basil_for_deposan));
                                            }

                                        }

                                    }
                                }
                            }
                        }

                        // TAMBAH DATA SUMBER DANA DARI TABUNGAN
                        $check_ketersediaan_sumberdana = $this->Sumberdana_model->get_by_pembiayaan_and_deposito_null($sumber_dana->pembiayaan_id);

                        $total_basil_sisa = $sumber_dana->total_basil - $total_basil_bulan_berjalan;

                        if ($check_ketersediaan_sumberdana) {
                            // UPDATE SUMBER DANA TABUNGAN YANG SUDAH ADA
                            $persentase = $check_ketersediaan_sumberdana->persentase + $sumber_dana->persentase;
                            $nominal = $check_ketersediaan_sumberdana->nominal + $sumber_dana->nominal;
                            $total_basil = $check_ketersediaan_sumberdana->total_basil + $total_basil_sisa;

                            $update_data = array(
                                'persentase'        => $persentase,
                                'nominal'           => $nominal,
                                'total_basil'       => $total_basil,
                                'basil_for_lembaga' => $total_basil,
                                'modified_by'       => $this->session->username,
                            );

                            $this->Sumberdana_model->update($check_ketersediaan_sumberdana->id_sumber_dana, $update_data);
                        } else {
                            // TAMBAH SUMBER DANA TABUNGAN BARU
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

                        // EDIT SUMBER DANA DI TABEL PEMBIAYAAN
                        $temp_array = array();
                        $sumber_dana_pembiayaan = $this->Sumberdana_model->get_all_by_pembiayaan($sumber_dana->pembiayaan_id);

                        foreach ($sumber_dana_pembiayaan as $data_sumber_dana_pembiayaan) {
                            array_push($temp_array, $data_sumber_dana_pembiayaan->deposito_id);
                        }

                        $is_sumber_dana_tabungan = false;
                        $is_sumber_dana_deposito = false;

                        for ($i=0; $i<count($temp_array); $i++) {
                            if ($temp_array[$i] == NULL) {
                                $is_sumber_dana_tabungan = true;
                            }

                            if ($temp_array[$i] != NULL) {
                                $is_sumber_dana_deposito = true;
                            }
                        }

                        if ($is_sumber_dana_tabungan && $is_sumber_dana_deposito) {
                            $this->Pembiayaan_model->update($sumber_dana->pembiayaan_id, array('sumber_dana' => 3));
                        } elseif ($is_sumber_dana_tabungan && !$is_sumber_dana_deposito) {
                            $this->Pembiayaan_model->update($sumber_dana->pembiayaan_id, array('sumber_dana' => 1));
                        } elseif (!$is_sumber_dana_tabungan && $is_sumber_dana_deposito) {
                            $this->Pembiayaan_model->update($sumber_dana->pembiayaan_id, array('sumber_dana' => 2));
                        }

                    }

                } elseif (date('Y-m-d', strtotime($data->jatuh_tempo)) >= date('Y-m-d')) {
                    $this->Deposito_model->update($data->id_deposito, array('is_active' => 1));
                }
            }
        }
    }

    function get_by_user($id)
    {
        $this->db->where('user_id', $id);
        return $this->db->get($this->table)->row();
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Instansi_model extends CI_Model{

  public $table = 'instansi';
  public $id    = 'id_instansi';
  public $order = 'DESC';

  function get_all()
  {
    $this->db->order_by($this->id, $this->order);

    $this->db->where('is_delete_instansi', '0');

    return $this->db->get($this->table)->result();
  }

  function get_all_active()
  {
    $this->db->order_by($this->id, $this->order);

    $this->db->where('is_active', '1');
    $this->db->where('is_delete_instansi', '0');

    return $this->db->get($this->table)->result();
  }

  function get_all_front()
  {
    $this->db->order_by('instansi_name', 'ASC');

    $this->db->where('is_delete_instansi', '0');

    return $this->db->get($this->table)->result();
  }

  function get_all_combobox()
  {
    $this->db->where('is_delete_instansi', '0');

    $this->db->order_by('instansi_name');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Instansi -';
        $result[$row['id_instansi']] = $row['instansi_name'];
      }
      return $result;
    }
  }

  function get_all_combobox_by_instansi()
  {
    $this->db->where('id_instansi', $this->session->id_instansi);

    $this->db->order_by('instansi_name');

    $data = $this->db->get($this->table);

    if($data->num_rows() > 0)
    {
      foreach($data->result_array() as $row)
      {
        $result[''] = '- Silahkan Pilih Instansi -';
        $result[$row['id_instansi']] = $row['instansi_name'];
      }
      return $result;
    }
  }

  function get_all_deleted()
  {
    $this->db->where('is_delete_instansi', '1');

    $this->db->order_by($this->id, $this->order);

    return $this->db->get($this->table)->result();
  }

  function get_by_id($id)
  {
    $this->db->where($this->id, $id);
    return $this->db->get($this->table)->row();
  }

  function total_rows()
  {
    return $this->db->get($this->table)->num_rows();
  }

  function total_tabungan()
  {
    $serapan_tabungan = $this->db->query('SELECT sum(resapan_tabungan) AS resapan_tabungan from instansi where is_delete_instansi = 0')->result();

    $saldo_tabungan = $this->db->query('SELECT sum(saldo_tabungan) AS saldo_tabungan from instansi where is_delete_instansi = 0')->result();

    return $serapan_tabungan[0]->resapan_tabungan + $saldo_tabungan[0]->saldo_tabungan;
  }

  function serapan_tabungan()
  {
    return $this->db->query('SELECT sum(resapan_tabungan) AS resapan_tabungan from instansi where is_delete_instansi = 0')->result();
  }

  function saldo_tabungan()
  {
    return $this->db->query('SELECT sum(saldo_tabungan) AS saldo_tabungan from instansi where is_delete_instansi = 0')->result();
  }

  function total_tabungan_by_instansi()
  {
    $serapan_tabungan = $this->db->query('SELECT sum(resapan_tabungan) AS resapan_tabungan from instansi where is_delete_instansi = 0 AND id_instansi = ' . $this->session->instansi_id)->result();

    $saldo_tabungan = $this->db->query('SELECT sum(saldo_tabungan) AS saldo_tabungan from instansi where is_delete_instansi = 0 AND id_instansi = ' . $this->session->instansi_id)->result();

    return $serapan_tabungan[0]->resapan_tabungan + $saldo_tabungan[0]->saldo_tabungan;
  }

  function serapan_tabungan_by_instansi()
  {
    return $this->db->query('SELECT sum(resapan_tabungan) AS resapan_tabungan from instansi where is_delete_instansi = 0 AND id_instansi = ' . $this->session->instansi_id)->result();
  }

  function saldo_tabungan_by_instansi()
  {
    return $this->db->query('SELECT sum(saldo_tabungan) AS saldo_tabungan from instansi where is_delete_instansi = 0 AND id_instansi = ' . $this->session->instansi_id)->result();
  }

  function insert($data)
  {
    $this->db->insert($this->table, $data);
  }

  function update($id,$data)
  {
    $this->db->where($this->id, $id);
    $this->db->update($this->table, $data);
  }

  function soft_delete($id,$data)
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

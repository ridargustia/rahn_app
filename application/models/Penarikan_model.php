<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penarikan_model extends CI_Model{

  public $table = 'penarikan';
  public $id    = 'id_penarikan';
  public $order = 'DESC';

  function get_riwayat_penarikan_by_deposan($id_deposito)
  {
    $this->db->select('penarikan.id_penarikan, penarikan.no_penarikan, penarikan.jml_penarikan, penarikan.status, penarikan.jatuh_tempo, penarikan.created_at, penarikan.created_by');

    $this->db->where('penarikan.deposito_id', $id_deposito);

    return $this->db->get($this->table)->result();
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
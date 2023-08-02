<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Penarikanbasil_model extends CI_Model{

  public $table = 'penarikan_basil';
  public $id    = 'id_penarikan_basil';
  public $order = 'DESC';

  function get_riwayat_penarikan_basil_by_deposan($id_deposito)
  {
    $this->db->select('penarikan_basil.id_penarikan_basil, penarikan_basil.no_penarikan, penarikan_basil.jml_penarikan, penarikan_basil.created_at, penarikan_basil.created_by');

    $this->db->where('penarikan_basil.deposito_id', $id_deposito);

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
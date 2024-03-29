<?php
defined('BASEPATH') or exit('No direct script access allowed');

function is_login()
{
  $CI = &get_instance();

  $username = $CI->session->username;

  if ($username == NULL) {
    $CI->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Anda harus login dulu</b></h6></div>');

    redirect('auth/login');
  }
}

function is_login_front()
{
  $CI = &get_instance();

  $username = $CI->session->username;

  if ($username == NULL) {
    $CI->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissible" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button><h6 style="margin-top: 3px; margin-bottom: 3px;"><i class="fas fa-ban"></i><b> Anda harus login dulu</b></h6></div>');

    redirect('auth/login');
  }
}

function is_grandadmin()
{
  $CI = &get_instance();

  $usertype = $CI->session->usertype_id;

  if ($usertype == '5') {
    return $usertype;
  }

  return null;
}

function is_masteradmin()
{
  $CI = &get_instance();

  $usertype = $CI->session->usertype_id;

  if ($usertype == '1') {
    return $usertype;
  }

  return null;
}

function is_superadmin()
{
  $CI = &get_instance();

  $usertype = $CI->session->usertype_id;

  if ($usertype == '2') {
    return $usertype;
  }

  return null;
}

function is_admin()
{
  $CI = &get_instance();

  $usertype = $CI->session->usertype_id;

  if ($usertype == '3') {
    return $usertype;
  }

  return null;
}

function is_pegawai()
{
  $CI = &get_instance();

  $usertype = $CI->session->usertype_id;

  if ($usertype == '4') {
    return $usertype;
  }

  return null;
}

function is_read()
{
  $CI = &get_instance();

  if ($CI->Auth_model->get_access_read() == NULL) {
    $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak punya akses untuk read data</div>');

    redirect('admin/dashboard');
  }
}

function is_create()
{
  $CI = &get_instance();

  if ($CI->Auth_model->get_access_create() == NULL) {
    $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak punya akses untuk membuat data</div>');

    redirect('admin/dashboard');
  }
}

function is_update()
{
  $CI = &get_instance();

  if ($CI->Auth_model->get_access_update() == NULL) {
    $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak punya akses untuk mengubah data</div>');

    redirect('admin/dashboard');
  }
}

function is_delete()
{
  $CI = &get_instance();

  if ($CI->Auth_model->get_access_delete() == NULL) {
    $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak punya akses untuk menghapus data</div>');

    redirect('admin/dashboard');
  }
}

function is_restore()
{
  $CI = &get_instance();

  if ($CI->Auth_model->get_access_restore() == NULL) {
    $CI->session->set_flashdata('message', '<div class="alert alert-danger">Anda tidak punya akses untuk mengembalikan data</div>');

    redirect('admin/dashboard');
  }
}

function check_active_deposan()
{
  $CI = &get_instance();

  $CI->Deposito_model->check_activated();

}

function check_masa_aktif_deposito()
{
  $CI = &get_instance();

  $deposito = $CI->Deposito_model->get_by_user($CI->session->id_users);

  if ($deposito) {
    // Status Jatuh Tempo
    $jatuh_tempo = strtotime($deposito->jatuh_tempo);
    $today = strtotime(date('Y-m-d'));

    $different_time = (date("Y", $jatuh_tempo) - date("Y", $today)) * 12;
    $different_time += date("m", $jatuh_tempo) - date("m", $today);

    if ($different_time <= 1) {
      return $deposito;
    }
  }

  return false;
}

<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
function datetime_indo($string)
{
  setlocale(LC_ALL, 'id_ID');
  $string = strftime("%A %d %B %Y | %X", strtotime($string));

  return $string;

  // output FROM: 2019-02-17 09:50:36 TO Hari Tanggal Bulan Tahun 09:50:36
}

function datetime_indo2($string)
{
  $datetime = $string;
  $dt       = strtotime($datetime); //make timestamp with datetime string
  $string   = date("d-m-Y G:i", $dt); //echo the year of the datestamp just created

  return $string;

  // output FROM: 2019-02-17 09:50:36 TO 17-02-2019 09:50:36
}

function date_only($string)
{
  $string = date("j F Y", strtotime($string));
  return $string;
}

function datetime_indo3($string)
{
  $datetime = $string;
  $dt       = strtotime($datetime);
  $string   = date("d/m/Y", $dt);

  return $string;

  //TODO output: 17/02/2019
}

function date_indonesian_only($string)
{
  $tgl = date("d-m-Y", strtotime($string));

  $bulan = array(
    1 =>   'Januari',
    'Februari',
    'Maret',
    'April',
    'Mei',
    'Juni',
    'Juli',
    'Agustus',
    'September',
    'Oktober',
    'November',
    'Desember'
  );

  $pecahkan = explode('-', $tgl);

  return $pecahkan[0] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[2];
}

function datetime_indo4($string)
{
  $datetime = $string;
  $dt       = strtotime($datetime); //make timestamp with datetime string
  $string   = date("d/m/Y | G:i", $dt); //echo the year of the datestamp just created

  return $string;
}

function date_only2($string)
{
  $datetime = $string;
  $dt       = strtotime($datetime); //make timestamp with datetime string
  $string   = date("d/m/Y", $dt); //echo the year of the datestamp just created

  return $string;
}

function time_only($string)
{
  $datetime = $string;
  $dt       = strtotime($datetime); //make timestamp with datetime string
  $string   = date("H:i:s", $dt); //echo the year of the datestamp just created

  return $string;
}

function time_only2($string)
{
  $datetime = $string;
  $dt       = strtotime($datetime); //make timestamp with datetime string
  $string   = date("G:i", $dt); //echo the year of the datestamp just created

  return $string;
}

<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

function pilihan_list($db, $text, $value, $default) {
    foreach ($db as $data) {
        if ($data[$value] == $default) {
            $par_sel = 'selected';
        } else {
            $par_sel = '';
        }
        $option[] = '<option value="' . $data[$value] . '" ' . $par_sel . '>' . $data[$text] . '</option>';
    }
    return implode(' ', $option);
}

function bulan($bln) {
    $bulan = array(
        '1' => 'JANUARI',
        '2' => 'FEBRUARI',
        '3' => 'MARET',
        '4' => 'APRIL',
        '5' => 'MEI',
        '6' => 'JUNI',
        '7' => 'JULI',
        '8' => 'AGUSTUS',
        '9' => 'SEPTEMBER',
        '10' => 'OKTOBER',
        '11' => 'NOVEMBER',
        '12' => 'DESEMBER',
    );
    return $bulan[$bln];
}

function ket_nilai($nilai) {
    if ($nilai <= 50) {
        return "Buruk-0-50";
    } elseif ($nilai <= 60) {
        return "Kurang-51-60";
    } elseif ($nilai <= 75) {
        return "Cukup-61-75";
    } elseif ($nilai <= 90) {
        return "Baik-76-90";
    } else {
        return "Sangat Baik-91-100";
    }
}

function ket_range($nilai) {
    switch ($nilai) {
        case "Buruk":
            return "50 Kebawah";
            break;
        case "Kurang":
            return "51 - 60";
            break;
        case "Cukup":
            return "61 - 75";
            break;
        case "Baik":
            return "76 - 90";
            break;
        default:
            return "91 - 100";
            break;
    }
}

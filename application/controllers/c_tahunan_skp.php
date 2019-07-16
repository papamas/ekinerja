<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_tahunan_skp extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_tahunan_skp', 'skp');
        $this->load->model('M_tahunan_skp_bawahan', 'skp_bawahan');
    }

    public function index() {
        $this->load->helper('url');
        $this->load->view('tahunan_skp/v_table_skp');
    }

    public function target($id) {
        $data['id'] = $id;
        $id_user = $this->session->userdata('id_user');
        $data['spesimen'] = $this->db->query('SELECT * FROM dd_spesimen')->result_array();
        $data['dt_skp_tahunan_atasan'] = $this->db->query("select b.* from opmt_tahunan_skp a
INNER JOIN opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND a.id_dd_user=(select atasan_langsung from dd_user where id_dd_user={$id_user})")->result_array();
        $this->load->view('tahunan_skp/v_table_target_skp', $data);
    }

    public function bawahan() {
        $this->load->helper('url');
        $this->load->view('tahunan_skp/v_table_skp_bawahan');
    }

    public function ajax_list() {
        $status = $this->input->post('status');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->skp->get_datatables($status);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_tahunan_skp(' . $dt->id_opmt_tahunan_skp . ')">
<i class="fa fa-pencil text-success"/></a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_tahunan_skp(' . $dt->id_opmt_tahunan_skp . ')">
<i class="fa fa-trash text-danger"/></a>';
            $link_target_skp = '<a href="javascript:void(0)" onclick="target_tahunan_skp(' . $dt->id_opmt_tahunan_skp . ')">
<i class="fa fa-file text-info"/></a>';
            $link_realisasi = '<a href="javascript:void(0)" onclick="realisasi_tahunan_skp(' . $dt->id_opmt_tahunan_skp . ')">
<i class="fa fa-dashboard text-primary"/></a>';
            $row = array();
            $row[] = $no;
            $row[] = date('d M Y', strtotime($dt->awal_periode_skp)) . " - " . date('d M Y', strtotime($dt->akhir_periode_skp));
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $row[] = $link_target_skp;
            $row[] = $link_realisasi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->skp->count_all($status),
            "recordsFiltered" => $this->skp->count_filtered($status),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_target() {
        $this->load->model('M_tahunan_target_skp', 'skp_target');
        $nama = $this->input->post('nama');
        $status = $this->input->post('status');
        $id = $this->input->post('id');
        $list = $this->skp_target->get_datatables($id, $status);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_target_tahunan_skp(' . $dt->id_opmt_target_skp . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_target_tahunan_skp(' . $dt->id_opmt_target_skp . ')">
<i class="fa fa-trash text-danger"/></a>';

            $row = array();
            $row[] = $no;
            $row[] = $dt->tahun;
            $row[] = $dt->kegiatan_tahunan;
            $row[] = $dt->target_kuantitas . " " . $dt->satuan_kuantitas;
            $row[] = 100;
            $row[] = $dt->target_waktu . " bulan";
            $row[] = number_format($dt->biaya);
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->skp_target->count_all($id, $status),
            "recordsFiltered" => $this->skp_target->count_filtered($id, $status),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_bawahan() {
        $status = $this->input->post('status');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->skp_bawahan->get_datatables($status);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_realisasi = '<a href="javascript:void(0)" onclick="realisasi_bawahan(' . $dt->id_opmt_tahunan_skp . ')">
<i class="fa fa-pencil text-danger"/></a>';
            $row = array();
            $row[] = $no;
            $row[] = $link_realisasi;
            $row[] = $dt->nama;
            $row[] = date('d M Y', strtotime($dt->awal_periode_skp)) . " - " . date('d M Y', strtotime($dt->akhir_periode_skp));
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->skp_bawahan->count_all($status),
            "recordsFiltered" => $this->skp_bawahan->count_filtered($status),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}

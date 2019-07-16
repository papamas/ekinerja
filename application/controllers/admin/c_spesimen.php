<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_spesimen extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('spesimen/v_table_skp');
    }

    public function ajax_list() {
        $this->load->model('M_spesimen', 'spesimen');
        $list = $this->spesimen->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_spesimen(' . $dt->id_dd_spesimen . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_spesimen(' . $dt->id_dd_spesimen . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->lokasi_spesimen;
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->spesimen->count_all(),
            "recordsFiltered" => $this->spesimen->count_filtered(),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $this->load->view("spesimen/v_tambah");
    }

    public function ubah($id) {
        $x['dt_spesimen'] = $this->db->query("SELECT *     
FROM dd_spesimen a WHERE a.id_dd_spesimen={$id}")->result_array();
        $this->load->view("spesimen/v_ubah", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->tambah_data('dd_spesimen', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Lokasi Spesimen berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 1;
            $a['ket'] = 'Lokasi Spesimen berhasil ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('dd_spesimen', 'id_dd_spesimen', $p->id_dd_spesimen, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Lokasi Spesimen berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Lokasi Spesimen gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_spesimen() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_spesimen', 'id_dd_spesimen', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Admin Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function j($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}

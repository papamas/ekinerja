<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_uker extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('uker/v_table_skp');
    }

    public function ajax_list() {
        $this->load->model('M_uker', 'uker');
        $uker = $this->input->post('uker');
//'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->uker->get_datatables($uker);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_uker(' . $dt->kodeunit . ')">
<i class="fa fa-pencil text-success"/>
</a>';

            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_uker(' . $dt->kodeunit . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->unitkerja;
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->uker->count_all($uker),
            "recordsFiltered" => $this->uker->count_filtered($uker),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $this->load->view("uker/v_tambah");
    }

    public function ubah($id) {
        $x['dt_uker'] = $this->db->query("SELECT * FROM tblstruktural WHERE kodeunit={$id}")->result_array();
        $this->load->view("uker/v_ubah", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->tambah_data('tblstruktural', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Jabatan berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 1;
            $a['ket'] = 'Jabatan berhasil ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('tblstruktural', 'kodeunit', $p->kodeunit, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Unit Kerja berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Unit Kerja gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_uker() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('tblstruktural', 'kodeunit', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function j($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}

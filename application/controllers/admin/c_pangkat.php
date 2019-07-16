<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_pangkat extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('pangkat/v_table_skp');
    }

    public function ajax_list() {
        $this->load->model('M_pangkat', 'pangkat');
        $gol = $this->input->post('golongan');
        $pangkat = $this->input->post('pangkat');
//'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->pangkat->get_datatables($gol, $pangkat);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_pangkat(' . $dt->KodeGol . ')">
<i class="fa fa-pencil text-success"/>
</a>';

            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_pangkat(' . $dt->KodeGol . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->Golongan;
            $row[] = $dt->Pangkat;
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pangkat->count_all($gol,$pangkat),
            "recordsFiltered" => $this->pangkat->count_filtered($gol,$pangkat),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $this->load->view("pangkat/v_tambah");
    }

    public function ubah($id) {
        $x['dt_pangkat'] = $this->db->query("SELECT * FROM tblgolongan WHERE KodeGol={$id}")->result_array();
        $this->load->view("pangkat/v_ubah", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->tambah_data('tblgolongan', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Golongan / Pangkat berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 1;
            $a['ket'] = 'Golongan / Pangkat berhasil ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('tblgolongan', 'KodeGol', $p->KodeGol, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Golongan / Pangkat berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Golongan / Pangkat gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_pangkat() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('tblgolongan', 'KodeGol', $id);
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

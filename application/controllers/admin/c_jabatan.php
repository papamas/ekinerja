<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_jabatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('jabatan/v_table_skp');
    }

    public function ajax_list() {
        $this->load->model('M_jabatan', 'jabatan');
        $jabatan = $this->input->post('jabatan');
//'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->jabatan->get_datatables($jabatan);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_jabatan(' . $dt->kodejab . ')">
<i class="fa fa-pencil text-success"/>
</a>';

            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_jabatan(' . $dt->kodejab . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->jabatan;
            $row[] = $link_edit;

            $row[] = $link_hapus;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->jabatan->count_all($jabatan),
            "recordsFiltered" => $this->jabatan->count_filtered($jabatan),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $this->load->view("jabatan/v_tambah");
    }

    public function ubah($id) {
        $x['dt_jabatan'] = $this->db->query("SELECT * FROM tbljabatan WHERE kodejab={$id}")->result_array();
        $this->load->view("jabatan/v_ubah", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->tambah_data('tbljabatan', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Jabatan berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Jabatan gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('tbljabatan', 'kodejab', $p->kodejab, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Jabatan berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Jabatan gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_jabatan() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('tbljabatan', 'kodejab', $id);
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

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_kuantitas extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('kuantitas/v_table_skp');
    }

    public function ajax_list() {
        $this->load->model('M_kuantitas', 'kuantitas');
        $kuantitas = $this->input->post('kuantitas');
//'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->kuantitas->get_datatables($kuantitas);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_kuantitas(' . $dt->id_dd_kuantitas . ')">
<i class="fa fa-pencil text-success"/>
</a>';

            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_kuantitas(' . $dt->id_dd_kuantitas . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->satuan_kuantitas;
            $row[] = $link_edit;
            $row[] = $link_hapus;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kuantitas->count_all($kuantitas),
            "recordsFiltered" => $this->kuantitas->count_filtered($kuantitas),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $this->load->view("kuantitas/v_tambah");
    }

    public function ubah($id) {
        $x['dt_kuantitas'] = $this->db->query("SELECT * FROM dd_kuantitas WHERE id_dd_kuantitas={$id}")->result_array();
        $this->load->view("kuantitas/v_ubah", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->tambah_data('dd_kuantitas', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Kuantitas berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Kuantitas gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('dd_kuantitas', 'id_dd_kuantitas', $p->id_dd_kuantitas, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Kuantitas berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Kuantitas gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_kuantitas() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_kuantitas', 'id_dd_kuantitas', $id);
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

<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_produktivitas extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $x['tahun'] = $this->db->query("SELECT DISTINCT YEAR(tanggal) tahun FROM opmt_produktivitas_skp")->result_array();
        $this->load->view('produktivitas/v_table_skp', $x);
    }

    public function bawahan() {
        $id_user = $this->session->userdata('id_user');
        $x['dt_user'] = $this->db->query("SELECT * FROM dd_user WHERE (atasan_langsung={$id_user} OR atasan_2={$id_user} OR atasan_3={$id_user})")->result_array();
        $x['tahun'] = $this->db->query("SELECT distinct year(tanggal) tahun FROM opmt_produktivitas_skp")->result_array();
        $this->load->view('produktivitas/v_table_skp_bawahan', $x);
    }

    public function ajax_list() {
        $this->load->model('M_produktivitas', 'produktivitas');
        $tanggal = $this->input->post('tanggal');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->produktivitas->get_datatables($tanggal, $bulan, $tahun);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_produktivitas(' . $dt->id_opmt_produktivitas_skp . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_produktivitas(' . $dt->id_opmt_produktivitas_skp . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = date('d M Y', strtotime($dt->tanggal));
            $row[] = $dt->produktivitas;
            $row[] = $dt->target_kuantitas . ' ' . $dt->satuan_kuantitas;
            $row[] = $link_edit;
            $row[] = $link_hapus;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->produktivitas->count_all($tanggal, $bulan, $tahun),
            "recordsFiltered" => $this->produktivitas->count_filtered($tanggal, $bulan, $tahun),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_bawahan() {
        $this->load->model('M_produktivitas_bawahan', 'produktivitas_bawahan');
        $nama = $this->input->post('nama');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->produktivitas_bawahan->get_datatables($nama, $bulan, $tahun);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;

            $row = array();
            $row[] = $no;
            $row[] = date('d M Y',strtotime($dt->tanggal));
            $row[] = $dt->nama;
            $row[] = $dt->nip;
            $row[] = $dt->produktivitas;
            $row[] = $dt->target_kuantitas . ' ' . $dt->satuan_kuantitas;
            $row[] = $dt->jam_mulai;
            $row[] = $dt->jam_selesai;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->produktivitas_bawahan->count_all($nama, $bulan, $tahun),
            "recordsFiltered" => $this->produktivitas_bawahan->count_filtered($nama, $bulan, $tahun),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $this->load->view("produktivitas/v_tambah", $x);
    }

    public function ubah($id) {
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $x['dt_produktivitas'] = $this->db->where('id_opmt_produktivitas_skp', $id)->get('opmt_produktivitas_skp')->result_array();
        $this->load->view("produktivitas/v_ubah", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $p->id_dd_user = $this->session->userdata('id_user');
        $cek = $this->M_database->tambah_data('opmt_produktivitas_skp', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Produktivitas berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Produktivitas gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $p->id_dd_user = $this->session->userdata('id_user');
        $cek = $this->M_database->ubah_data('opmt_produktivitas_skp', 'id_opmt_produktivitas_skp', $p->id_opmt_produktivitas_skp, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Produktivitas berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Produktivitas gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_produktivitas() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_produktivitas_skp', 'id_opmt_produktivitas_skp', $id);
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

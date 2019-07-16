<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_rkt extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('rkt/v_table_skp');
    }

    public function detail($id) {
        $x['id'] = $id;
        $this->load->view('rkt/v_table_skp_detail', $x);
    }

    public function detail_ik($id) {
        $x['id'] = $id;
        $this->load->view('rkt/v_table_skp_detail_ik', $x);
    }

    public function ajax_list() {
        $this->load->model('M_rkt', 'rkt');
        $unit = $this->input->post('unit');
        $tahun = $this->input->post('tahun');
        $list = $this->rkt->get_datatables($unit, $tahun);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_rkt(' . $dt->id_opmt_rkt . ')">
<i class="fa fa-trash text-danger"/></a>';
            $link_daftar = '<a href="javascript:void(0)" onclick="menu(&#39;admin/c_rkt/detail/' . $dt->id_opmt_rkt . '&#39;)">
<i class="fa fa-pencil text-primary"/></a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->tahun;
            $row[] = $dt->kodeunit;
            $row[] = $dt->unitkerja;
            $row[] = $link_hapus;
            $row[] = $link_daftar;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rkt->count_all($unit, $tahun),
            "recordsFiltered" => $this->rkt->count_filtered($unit, $tahun),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function ajax_list_detail() {
        $this->load->model('M_rkt_detail', 'rkt');
        $id = $this->input->post('id');
        $list = $this->rkt->get_datatables($id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_sasaran(' . $dt->id_opmt_sasaran_strategis . ')">
<i class="fa fa-pencil text-success"/></a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_sasaran(' . $dt->id_opmt_sasaran_strategis . ')">
<i class="fa fa-trash text-danger"/></a>';
            $link_ik = '<a href="javascript:void(0)" onclick="menu(&#39;admin/c_rkt/detail_ik/' . $dt->id_opmt_sasaran_strategis . '&#39;)">
<i class="fa fa-pencil text-info"/></a>';

            $row = array();
            $row[] = $no;
            $row[] = $dt->sasaran_strategis;
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $row[] = $link_ik;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rkt->count_all($id),
            "recordsFiltered" => $this->rkt->count_filtered($id),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function ajax_list_ik() {
        $this->load->model('M_rkt_ik', 'rkt');
        $id = $this->input->post('id');
        $flag = $this->input->post('flag');
        $list = $this->rkt->get_datatables($id, $flag);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="edit_ik(' . $dt->id_opmt_ik . ',' . $dt->flag_utama . ')">
<i class="fa fa-copy text-success"/></a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_ik(' . $dt->id_opmt_ik . ',' . $dt->flag_utama . ')">
<i class="fa fa-trash text-danger"/></a>';

            $row = array();
            $row[] = $no;
            $row[] = $dt->indikator_kinerja;
            $row[] = $dt->target;
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->rkt->count_all($id, $flag),
            "recordsFiltered" => $this->rkt->count_filtered($id, $flag),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function tambah() {
        $data['unit'] = $this->db->where('substring(kodeunit,4,2)', '00')->get('tblstruktural')->result_array();
        $this->load->view("rkt/v_tambah", $data);
    }

    public function tambah_sasaran($id) {
        $x['id'] = $id;
        $this->load->view("rkt/v_tambah_sasaran", $x);
    }

    public function tambah_ik($id, $flag) {
        $x['id'] = $id;
        $x['flag'] = $flag;
        $this->load->view("rkt/v_tambah_ik", $x);
    }

    public function ubah_ik($id, $flag) {
        $x['id'] = $id;
        $x['flag'] = $flag;
        $x['indikator'] = $this->db->from('opmt_ik')->where('id_opmt_ik', $id)->get()->row_array();
        $this->load->view("rkt/v_ubah_ik", $x);
    }

    public function ubah_sasaran($id) {
        $x['sasaran'] = $this->db->from("opmt_sasaran_strategis")->where("id_opmt_sasaran_strategis", $id)->get()->row_array();
        $this->load->view("rkt/v_ubah_sasaran", $x);
    }

    public function ubah($id) {
        $x['jabatan'] = $this->db->where('jenis', 'jft')->get('tbljabatan')->result_array();
        $x['dt_rkt'] = $this->db->query("SELECT *     
FROM opmt_rkt a WHERE a.id_opmt_rkt={$id}")->result_array();
        $this->load->view("rkt/v_ubah", $x);
    }

    public function ubah_detail($id) {
        $x['dt_rkt'] = $this->db->query("SELECT *     
FROM opmt_detail_rkt a LEFT JOIN dd_kuantitas b on b.id_dd_kuantitas=a.satuan_hasil WHERE a.id_opmt_detail_rkt={$id}")->result_array();
        $this->load->view("rkt/v_ubah_detail", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->tambah_data('opmt_rkt', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Rencana Kerja Tahunan berhasil ditambah';
            $this->j($a);
        }
    }

    public function aksi_tambah_sasaran() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->tambah_data('opmt_sasaran_strategis', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Sasaran Strategis berhasil ditambah';
            $this->j($a);
        }
    }

    public function aksi_tambah_ik() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->tambah_data('opmt_ik', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Indikator Kinerja berhasil ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah_ik() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('opmt_ik', 'id_opmt_ik', $p->id_opmt_ik, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Indikator Kinerja berhasil dirubah';
            $this->j($a);
        }
    }

    public function aksi_ubah_sasaran() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('opmt_sasaran_strategis', 'id_opmt_sasaran_strategis', $p->id_opmt_sasaran_strategis, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Sasaran Strategis berhasil dirubah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('opmt_rkt', 'id_opmt_rkt', $p->id_opmt_rkt, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Kegiatan Jabatan berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Kegiatan Jabatan gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_ubah_detail() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $x = array('satuan_kuantitas' => $p->satuan_hasil);
        $ubah_status = $this->M_database->ubah_data('dd_kuantitas', 'id_dd_kuantitas', $p->id_satuan_hasil, $x);
        unset($p->satuan_hasil);
        unset($p->id_satuan_hasil);
        $cek = $this->M_database->ubah_data('opmt_detail_rkt', 'id_opmt_detail_rkt', $p->id_opmt_detail_rkt, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Kegiatan Jabatan berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Kegiatan Jabatan gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_rkt() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_rkt', 'id_opmt_rkt', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Kegiatan Jabatan Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_sasaran() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_sasaran_strategis', 'id_opmt_sasaran_strategis', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Sasaran Strategis Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_ik() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_ik', 'id_opmt_ik', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Indikator Kinerja Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function get_detail() {
        $id = $this->input->post('id');
        $data = $this->db->where('id_opmt_detail_rkt', $id)->from('opmt_detail_rkt')->get()->result();
        echo json_encode($data);
    }

    public function j($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}

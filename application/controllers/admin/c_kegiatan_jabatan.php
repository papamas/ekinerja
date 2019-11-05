<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_kegiatan_jabatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('kegiatan_jabatan/v_table_skp');
    }

    public function detail($id) {
        $data['id'] = $id;
        $data['jabatan'] = $this->db->where('id_opmt_kegiatan_jabatan', $id)->from('opmt_kegiatan_jabatan a')->join('tbljabatan b', 'a.kodejab=b.kodejab', 'LEFT')->get()->row_array();
        $this->load->view('kegiatan_jabatan/v_table_skp_detail', $data);
    }

    public function detail2() {
        $jabatan = $this->session->userdata('kodejab');
        $data['jabatan'] = $this->db->where('kodejab', $jabatan)->from('tbljabatan a')->get()->row_array();
        $this->load->view('kegiatan_jabatan/v_table_skp_detail2', $data);
    }

    public function ajax_list() {
        $this->load->model('M_kegiatan_jabatan', 'kegiatan_jabatan');
        $nama = $this->input->post('nama');
        $list = $this->kegiatan_jabatan->get_datatables($nama);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_kegiatan_jabatan(' . $dt->id_opmt_kegiatan_jabatan . ')">
<i class="fa fa-pencil text-success"/></a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_kegiatan_jabatan(' . $dt->id_opmt_kegiatan_jabatan . ')">
<i class="fa fa-trash text-danger"/></a>';
            $link_daftar = '<a href="javascript:void(0)" onclick="menu(&#39;admin/c_kegiatan_jabatan/detail/' . $dt->id_opmt_kegiatan_jabatan . '&#39;)">
<i class="fa fa-pencil text-primary"/></a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->kodejab;
            $row[] = $dt->jabatan;
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $row[] = $link_daftar;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kegiatan_jabatan->count_all($nama),
            "recordsFiltered" => $this->kegiatan_jabatan->count_filtered($nama),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function ajax_list_detail() {
        $this->load->model('M_detail_kegiatan_jabatan', 'kegiatan_jabatan');
        $nama = $this->input->post('nama');
		$id   = $this->input->post('id');
        $list = $this->kegiatan_jabatan->get_datatables($nama,$id);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_kegiatan(' . $dt->id_opmt_detail_kegiatan_jabatan . ')">
<i class="fa fa-pencil text-success"/></a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_kegiatan(' . $dt->id_opmt_detail_kegiatan_jabatan . ')">
<i class="fa fa-trash text-danger"/></a>';

            $row = array();
            $row[] = $no;
            $row[] = $dt->kegiatan_jabatan;
            $row[] = $dt->satuan_kuantitas;
            $row[] = $dt->angka_kredit;
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kegiatan_jabatan->count_all($nama, $id),
            "recordsFiltered" => $this->kegiatan_jabatan->count_filtered($nama, $id),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function ajax_list_detail2() {
        $this->load->model('M_detail_kegiatan_jabatan2', 'kegiatan_jabatan');
        $nama = $this->input->post('jabatan');
        $list = $this->kegiatan_jabatan->get_datatables($nama);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_copy = '<a href="javascript:void(0)" onclick="copy_kegiatan(' . $dt->id_opmt_detail_kegiatan_jabatan . ')">
<i class="fa fa-copy text-success"/></a>';

            $row = array();
            $row[] = $no;
            $row[] = $dt->kegiatan_jabatan;
            $row[] = $dt->satuan_kuantitas;
            $row[] = $dt->angka_kredit;
            $row[] = $link_copy;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->kegiatan_jabatan->count_all($nama),
            "recordsFiltered" => $this->kegiatan_jabatan->count_filtered($nama),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $data['jabatan'] = $this->db->where('jenis', 'jft')->get('tbljabatan')->result_array();
        $this->load->view("kegiatan_jabatan/v_tambah", $data);
    }

    public function tambah_detail($id) {
        $x['id'] = $id;
		$x['satuan_hasil'] = $this->db->query("SELECT * FROM dd_kuantitas")->result_array();
        $this->load->view("kegiatan_jabatan/v_tambah_detail", $x);
    }

    public function ubah($id) {
        $x['jabatan'] = $this->db->where('jenis', 'jft')->get('tbljabatan')->result_array();
        $x['dt_kegiatan_jabatan'] = $this->db->query("SELECT *     
FROM opmt_kegiatan_jabatan a WHERE a.id_opmt_kegiatan_jabatan={$id}")->result_array();
        $this->load->view("kegiatan_jabatan/v_ubah", $x);
    }

    public function ubah_detail($id) {
        $x['dt'] = $this->db->query("SELECT a.*     
FROM opmt_detail_kegiatan_jabatan a 
LEFT JOIN dd_kuantitas b on b.id_dd_kuantitas=a.satuan_hasil 
WHERE a.id_opmt_detail_kegiatan_jabatan={$id}")->row_array();
		$x['satuan_hasil'] = $this->db->query("SELECT * FROM dd_kuantitas")->result_array();
        $this->load->view("kegiatan_jabatan/v_ubah_detail", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $ttl = $this->db->where('kodejab', $p->kodejab)->from('opmt_kegiatan_jabatan')->count_all_results();
        if ($ttl > 0) {
            $a['status'] = 0;
            $a['ket'] = 'Kegiatan Jabatan Sudah Ada';
            $this->j($a);
        } else {
            $cek = $this->M_database->tambah_data('opmt_kegiatan_jabatan', $p);
            if ($cek) {
                $a['status'] = 1;
                $a['ket'] = 'Kegiatan Jabatan berhasil ditambah';
                $this->j($a);
            } else {
                $a['status'] = 1;
                $a['ket'] = 'Kegiatan Jabatan berhasil ditambah';
                $this->j($a);
            }
        }
    }

    public function aksi_tambah_detail() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
	/*
	$cek=$this->db->where('satuan_kuantitas',$p->satuan_hasil)->from('dd_kuantitas')->get()->row();
	if(count($cek)>0){
		$p->satuan_hasil=$cek->id_dd_kuantitas;
	}else{
        	$data = array('satuan_kuantitas' => $p->satuan_hasil);
        	$p->satuan_hasil = $this->M_database->tambah_data('dd_kuantitas', $data);
	}*/
	
        $cek = $this->M_database->tambah_data('opmt_detail_kegiatan_jabatan', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Kegiatan Jabatan berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 1;
            $a['ket'] = 'Kegiatan Jabatan berhasil ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $cek = $this->M_database->ubah_data('opmt_kegiatan_jabatan', 'id_opmt_kegiatan_jabatan', $p->id_opmt_kegiatan_jabatan, $p);
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
        //$x = array('satuan_kuantitas' => $p->satuan_hasil);
        //$ubah_status = $this->M_database->ubah_data('dd_kuantitas', 'id_dd_kuantitas', $p->id_satuan_hasil, $x);
        //unset($p->satuan_hasil);
        //unset($p->id_satuan_hasil);
        $cek = $this->M_database->ubah_data('opmt_detail_kegiatan_jabatan', 'id_opmt_detail_kegiatan_jabatan', $p->id_opmt_detail_kegiatan_jabatan, $p);
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

    public function hapus_kegiatan_jabatan() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_kegiatan_jabatan', 'id_opmt_kegiatan_jabatan', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Kegiatan Jabatan Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_kegiatan_jabatan_detail() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_detail_kegiatan_jabatan', 'id_opmt_detail_kegiatan_jabatan', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Kegiatan Jabatan Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function get_detail() {
        $id = $this->input->post('id');
        $data = $this->db->where('id_opmt_detail_kegiatan_jabatan', $id)->from('opmt_detail_kegiatan_jabatan')->get()->result();
        echo json_encode($data);
    }

    public function j($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}

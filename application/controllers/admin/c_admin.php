<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_admin extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('admin/v_table_skp');
    }

    public function ajax_list() {
        $this->load->model('M_admin', 'admin');
        $list = $this->admin->get_datatables();
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_admin(' . $dt->id_dd_user . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_admin(' . $dt->id_dd_user . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->username;
            $row[] = base64_decode($dt->password);

            $row[] = $link_edit;
            $row[] = $link_hapus;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->admin->count_all(),
            "recordsFiltered" => $this->admin->count_filtered(),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
		$this->db->from('tbljabatan');
		$this->db->where('jenis', 'ADM');
		$data['result'] = $this->db->get()->row_array();
        $this->load->view("admin/v_tambah",$data);
    }
	
	public function get_jabatan() {
        $nama = $this->input->post('q');
        $q = "SELECT kodejab as id, jabatan as label, jabatan as value FROM 
		tbljabatan WHERE jenis='ADM'";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }

    public function ubah($id) {
        $x['dt_admin'] = $this->db->query("SELECT *     
FROM dd_user a WHERE a.id_dd_user={$id}")->result_array();
        $this->load->view("admin/v_ubah", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $p->password = base64_encode($p->password);
        //$p->jabatan = 701089;
        $p->nama = $p->username;
        $p->nip = 9999;
        $cek = $this->M_database->tambah_data('dd_user', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Admin berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 1;
            $a['ket'] = 'Admin berhasil ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $p->password = base64_encode($p->password);
        $cek = $this->M_database->ubah_data('dd_user', 'id_dd_user', $p->id_dd_user, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Admin berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Admin gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_admin() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_user', 'id_dd_user', $id);
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

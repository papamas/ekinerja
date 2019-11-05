<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_user extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->load->view('user/v_table_skp');
    }

    public function ajax_list() {
        $this->load->model('M_user', 'user');
        $nip = $this->input->post('nip');
        $nama = $this->input->post('nama');
//'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->user->get_datatables($nip, $nama);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_user(' . $dt->id_dd_user . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_detail = '<a href="javascript:void(0)" onclick="detail_user(' . $dt->id_dd_user . ')">
<i class="fa fa-search text-success"/>
</a>';

            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_user(' . $dt->id_dd_user . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->nip;
            $row[] = $dt->nama;
            $row[] = $dt->nama_jabatan;
            $row[] = $dt->username;
            $row[] = base64_decode($dt->password);
            $row[] = $link_detail;
            $row[] = $link_edit;
            $row[] = $link_hapus;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->user->count_all($nip, $nama),
            "recordsFiltered" => $this->user->count_filtered($nip, $nama),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $this->load->view("user/v_tambah");
    }

    public function ubah($id) {
        $x['dt_user'] = $this->db->query("SELECT a.id_dd_user,a.nama,a.nip,a.username,a.password,
		b.id_dd_ruang_pangkat,concat(b.golongan_ruang,'-',b.pangkat)nama_golongan,
c.kodeunit,c.unitkerja,d.kodejab,d.jabatan            
FROM dd_user a 
LEFT JOIN dd_ruang_pangkat b ON a.gol_ruang=b.id_dd_ruang_pangkat
LEFT JOIN tblstruktural c ON a.unit_kerja=c.kodeunit
LEFT JOIN tbljabatan d on a.jabatan=d.kodejab WHERE id_dd_user={$id}")->result_array();
        $this->load->view("user/v_ubah", $x);
    }
    
    public function detail($id) {
        $x['dt_user'] = $this->db->query("SELECT a.id_dd_user,a.nama,a.nip,a.username,a.password,
		b.id_dd_ruang_pangkat,concat(b.golongan_ruang,'-',b.pangkat)nama_golongan,
c.kodeunit,c.unitkerja,d.kodejab,d.jabatan,e.nama atasan_langsung,f.nama atasan_2,g.nama atasan_3            
FROM dd_user a 
LEFT JOIN dd_ruang_pangkat b ON a.gol_ruang=b.id_dd_ruang_pangkat
LEFT JOIN tblstruktural c ON a.unit_kerja=c.kodeunit
LEFT JOIN tbljabatan d on a.jabatan=d.kodejab 
LEFT JOIN dd_user e on a.atasan_langsung=e.id_dd_user
LEFT JOIN dd_user f on a.atasan_2=f.id_dd_user
LEFT JOIN dd_user g on a.atasan_3=g.id_dd_user

WHERE a.id_dd_user={$id}")->result_array();
        $this->load->view("user/v_detail", $x);
    }

    public function aksi_tambah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $p->password = base64_encode($p->password);
        $cek = $this->M_database->tambah_data('dd_user', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'User berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 1;
            $a['ket'] = 'User berhasil ditambah';
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
            $a['ket'] = 'User berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'User gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_user() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('dd_user', 'id_dd_user', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function uker_json() {
        $nama = $this->input->post('q');
        $q = "SELECT kodeunit as id, concat(kodeunit, '-', unitkerja) as label, rtrim(unitkerja) as value FROM tblstruktural WHERE unitkerja LIKE '%" . $nama . "%'  ORDER BY value ASC";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }

    public function gol_ruang_json() {
        $nama = $this->input->post('q');
        $q = "SELECT id_dd_ruang_pangkat as id, concat(golongan_ruang, '-', pangkat) as label, 
		concat(golongan_ruang, '-', pangkat) as value 
		FROM dd_ruang_pangkat WHERE (golongan_ruang LIKE '%" . $nama . "%' 
		OR pangkat LIKE '%" . $nama . "%')  ORDER BY value ASC";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }

    public function jabatan_json() {
        $nama = $this->input->post('q');
        $q = "SELECT kodejab as id, jabatan as label, jabatan as value 
		FROM tbljabatan WHERE jabatan LIKE '" . $nama . "%' ";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }

    public function j($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}

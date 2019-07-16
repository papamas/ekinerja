<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_disposisi extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function ket_status($id) {
        switch ($id) {
            case "0":
                return "Tidak Dilaksanakan";
                break;
            case "1":
                return "Selesai Dilaksanakan";
                break;
            case "2":
                return "Dilaksanakan Melewati Deadline";
                break;
            default :
                return "";
                break;
        }
    }

    public function ket_status_bawahan($id) {
        switch ($id) {
            case "0":
                return "Dalam Pengerjaan";
                break;
            case "1":
                return "Selesai Dilaksanakan";
                break;
            default :
                return "";
                break;
        }
    }

    public function ket_status_waktu($id) {
        if ($id == 0) {
            return "Deadline Hari ini";
        } elseif ($id < 0) {
            return "Melewati Deadline";
        } elseif ($id > 0) {
            return (int) $id . " Hari Sebelum Deadline";
        }
    }

    public function index() {
        $id_user = $this->session->userdata('id_user');
        $x["tahun"] = $this->db->query("SELECT DISTINCT YEAR(tanggal_disposisi) tahun FROM opmt_disposisi WHERE id_dd_atasan={$id_user}")->result_array();
        $this->load->view('disposisi/v_table_skp', $x);
    }

    public function bawahan() {
        $this->load->view('disposisi/v_table_skp_bawahan');
    }

    public function ajax_list() {
        $this->load->model('M_disposisi', 'disposisi');
        $tahun = $this->input->post('tahun');
//'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->disposisi->get_datatables($tahun);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $date1 = date_create(date('Y-m-d'));
            $date2 = date_create($dt->target_selesai);
            $diff = date_diff($date1, $date2);
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_disposisi(' . $dt->id_opmt_disposisi . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_edit2 = '<a href="javascript:void(0)" onclick="ubah_status(' . $dt->id_opmt_disposisi . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_disposisi(' . $dt->id_opmt_disposisi . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = $dt->nama;
            $row[] = $dt->nip;
            $row[] = date('d M Y', strtotime($dt->tanggal_disposisi));
            $row[] = $dt->kegiatan;
            $row[] = $dt->waktu_pengerjaan . ' Hari';
            $row[] = $this->ket_status_waktu($diff->format("%R%a"));
            $row[] = $this->ket_status_bawahan($dt->status_disposisi_bawahan);
            $row[] = $this->ket_status($dt->status_disposisi_atasan);
            $row[] = $link_edit;
            $row[] = $link_edit2;
            $row[] = $link_hapus;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->disposisi->count_all($tahun),
            "recordsFiltered" => $this->disposisi->count_filtered($tahun),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function ajax_list_bawahan() {
        $this->load->model('M_disposisi_bawahan', 'disposisi');
        $tahun = $this->input->post('tahun');
//'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->disposisi->get_datatables($tahun);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $date1 = date_create(date('Y-m-d'));
            $date2 = date_create($dt->target_selesai);
            $diff = date_diff($date1, $date2);

            $link_edit2 = '<a href="javascript:void(0)" onclick="ubah_status_bawahan(' . $dt->id_opmt_disposisi . ')">
<i class="fa fa-pencil text-success"/>
</a>';

            $row = array();
            $row[] = $no;

            $row[] = date('d M Y', strtotime($dt->tanggal_disposisi));
            $row[] = $dt->kegiatan;
            $row[] = $dt->waktu_pengerjaan . ' Hari';
            $row[] = $this->ket_status_waktu($diff->format("%R%a"));
            $row[] = $this->ket_status_bawahan($dt->status_disposisi_bawahan);
            $row[] = $this->ket_status($dt->status_disposisi_atasan);
            $row[] = $link_edit2;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->disposisi->count_all($tahun),
            "recordsFiltered" => $this->disposisi->count_filtered($tahun),
            "data" => $data,
        );
//output to json format
        echo json_encode($output);
    }

    public function tambah() {
        $id_user = $this->session->userdata('id_user');
        $x['dt_user'] = $this->db->query("SELECT * FROM dd_user WHERE (atasan_langsung={$id_user} OR atasan_2={$id_user} OR atasan_3={$id_user})")->result_array();
        $this->load->view("disposisi/v_tambah", $x);
    }

    public function ubah($id) {
        $id_user = $this->session->userdata('id_user');
        $x['dt_user'] = $this->db->query("SELECT * FROM dd_user WHERE (atasan_langsung={$id_user} OR atasan_2={$id_user} OR atasan_3={$id_user})")->result_array();
        $x['dt_disposisi'] = $this->db->query("SELECT * FROM opmt_disposisi WHERE id_opmt_disposisi={$id}")->result_array();
        $this->load->view("disposisi/v_ubah", $x);
    }

    public function ubah_status($id) {
        $x['dt_disposisi'] = $this->db->query("SELECT * FROM opmt_disposisi a LEFT JOIN dd_user b ON a.id_dd_user=b.id_dd_user WHERE id_opmt_disposisi={$id}")->result_array();
        $this->load->view("disposisi/v_ubah_status", $x);
    }

    public function ubah_status_bawahan($id) {
        $x['dt_disposisi'] = $this->db->query("SELECT * FROM opmt_disposisi a LEFT JOIN dd_user b ON a.id_dd_user=b.id_dd_user WHERE id_opmt_disposisi={$id}")->result_array();
        $this->load->view("disposisi/v_ubah_status_bawahan", $x);
    }

    public function aksi_tambah() {

        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $p->id_dd_atasan = $this->session->userdata('id_user');
        $lama = $p->waktu_pengerjaan;
        $p->target_selesai = date("Y-m-d", strtotime($p->tanggal_disposisi . " + {$lama} days"));
        $cek = $this->M_database->tambah_data('opmt_disposisi', $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Disposisi berhasil ditambah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Disposisi gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_ubah() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $p->id_dd_atasan = $this->session->userdata('id_user');
        $lama = $p->waktu_pengerjaan;
        $p->target_selesai = date("Y-m-d", strtotime($p->tanggal_disposisi . " + {$lama} days"));
        $cek = $this->M_database->ubah_data('opmt_disposisi', 'id_opmt_disposisi', $p->id_opmt_disposisi, $p);
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

    public function aksi_ubah_status() {
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));
        $this->load->model("M_database");
        $p = json_decode(file_get_contents('php://input'));

        $cek = $this->M_database->ubah_data('opmt_disposisi', 'id_opmt_disposisi', $p->id_opmt_disposisi, $p);
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Disposisi berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Disposisi gagal diubah';
            $this->j($a);
        }
    }

    public function hapus_disposisi() {
        $this->load->model("M_database");
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_disposisi', 'id_opmt_disposisi', $id);
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

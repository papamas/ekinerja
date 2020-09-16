<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class C_harian_skp extends CI_Controller {

    public function __construct() {
        parent::__construct();

//        $this->load->model('M_harian_skp_bawahan', 'skp_bawahan');
    }

    public function index() {
        $this->load->helper('url');
        //$x['tahun'] = $this->db->query("SELECT DISTINCT YEAR(tanggal) tahun FROM opmt_realisasi_harian_skp")->result_array();
        $x['tahun']		= $this->_get_two_year_before();
		$this->load->view('harian_skp/v_table_skp', $x);
    }
	
	function _get_two_year_before()
	{
	    $year = date("Y");
		$yearDoubleBack = date("Y", strtotime($year . " - 1 year"));
		$years = range($yearDoubleBack,$year);
		return  $years;
	}	

    public function bawahan() {
        $x['tahun'] = $this->db->query("SELECT distinct year(tanggal) tahun FROM opmt_realisasi_harian_skp")->result_array();
        $this->load->view('harian_skp/v_table_skp_bawahan', $x);
    }

    public function ajax() {
        $id_user = $this->session->userdata("id_user");
        $tanggal = $this->input->post("tanggal");
        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");
        $this->db->where('id_dd_user', $id_user);
        if (!empty($tanggal)) {
            $this->db->where('day(tanggal)', $tanggal);
        }
        if ($bulan != "all") {
            $this->db->where('month(tanggal)', $bulan);
        }
        if ($tahun != "all") {
            $this->db->where('year(tanggal)', $tahun);
        }
        $this->db->from("opmt_realisasi_harian_skp a");
        $this->db->join("(
                SELECT a.id_opmt_target_bulanan_skp as id,b.kegiatan_tahunan as kegiatan_bulanan,0 as ket FROM opmt_target_bulanan_skp a
                INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND (a.id_dd_user={$id_user} OR a.id_dd_user_bawahan={$id_user})

                UNION ALL
                SELECT id_opmt_turunan_skp as id,kegiatan_turunan,1 as ket FROM opmt_turunan_skp d
                INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
                INNER JOIN opmt_target_skp f on e.id_opmt_target_skp=f.id_opmt_target_skp
                INNER JOIN opmt_tahunan_skp g on g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp AND (d.id_dd_user={$id_user} OR d.id_dd_user_bawahan={$id_user}) 
                ) b", 'a.turunan=b.ket AND b.id=a.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_kuantitas c', 'c.id_dd_kuantitas=a.satuan_kuantitas', 'LEFT');
        $this->db->order_by('a.tanggal', 'ASC');
        $data['dt_harian'] = $this->db->get()->result_array();
        $this->load->view('harian_skp/v_table_harian', $data);
    }

    public function ajax_bawahan() {
        $id_user = $this->session->userdata("id_user");
        $nama = $this->input->post("nama");
        $tanggal = $this->input->post("tanggal");
        $bulan = $this->input->post("bulan");
        $tahun = $this->input->post("tahun");
        if (!empty($tanggal)) {
            $this->db->where('day(tanggal)', $tanggal);
        }
        if ($bulan != "all") {
            $this->db->where('month(tanggal)', $bulan);
        }
        if ($tahun != "all") {
            $this->db->where('year(tanggal)', $tahun);
        }
        if ($nama !== "") {
            $this->db->like("nama", $nama);
        }
        $this->db->from("opmt_realisasi_harian_skp a");
        $this->db->join('opmt_target_bulanan_skp b', 'a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_user c', "a.id_dd_user=c.id_dd_user AND (c.atasan_langsung={$id_user} OR c.atasan_2={$id_user} OR c.atasan_3={$id_user})", 'INNER');
        $this->db->join("(
                SELECT a.id_opmt_target_bulanan_skp as id,b.kegiatan_tahunan as kegiatan_bulanan,0 as ket FROM opmt_target_bulanan_skp a
                INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp

                UNION ALL
                SELECT id_opmt_turunan_skp as id,kegiatan_turunan,1 as ket FROM opmt_turunan_skp d
                INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
                INNER JOIN opmt_target_skp f on e.id_opmt_target_skp=f.id_opmt_target_skp
                INNER JOIN opmt_tahunan_skp g on g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp
                ) d", 'a.turunan=d.ket AND d.id=a.id_opmt_target_bulanan_skp', 'LEFT');
        $this->db->join('dd_kuantitas e', 'e.id_dd_kuantitas=a.satuan_kuantitas', 'LEFT');
        $this->db->order_by('a.tanggal', 'ASC');
        $data['dt_harian'] = $this->db->get()->result_array();
        $this->load->view('harian_skp/v_table_harian_bawahan', $data);
    }

    public function ajax_list() {
        $this->load->model('M_harian_skp', 'skp');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->skp->get_datatables($bulan, $tahun);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_harian(' . $dt->id_opmt_realisasi_harian_skp . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_harian(' . $dt->id_opmt_realisasi_harian_skp . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $row = array();
            $row[] = $no;
            $row[] = date('d M Y', strtotime($dt->tanggal));
            $row[] = $dt->kegiatan_harian_skp;
            $row[] = $dt->kegiatan_bulanan;
            $row[] = $dt->kuantitas . ' ' . $dt->kuantitas;
            $row[] = $link_edit;
            $row[] = $link_hapus;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->skp->count_all($bulan, $tahun),
            "recordsFiltered" => $this->skp->count_filtered($bulan, $tahun),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list_bawahan() {
        $this->load->model('M_harian_skp_bawahan', 'skp_bawahan');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $nama = $this->input->post('nama');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->skp_bawahan->get_datatables($bulan, $tahun, $nama);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $no++;
            $link_detail = '<a href="javascript:void(0)" onclick="lihat_harian(' . $dt->id_opmt_realisasi_harian_skp . ')">
<i class="fa fa-pencil text-danger"/></a>';
            $row = array();
            $row[] = $no;
            $row[] = date('d M Y', strtotime($dt->tanggal));
            $row[] = $dt->nama;
            $row[] = $dt->kegiatan_harian_skp;
            $row[] = $dt->kegiatan_turunan;
            $row[] = $dt->kuantitas . ' ' . $dt->satuan_kuantitas;
            $row[] = $link_detail;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->skp_bawahan->count_all($bulan, $tahun, $nama),
            "recordsFiltered" => $this->skp_bawahan->count_filtered($bulan, $tahun, $nama),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function update_sesuai() {
        $id = $this->input->post('id');
        $sesuai = $this->input->post('cek') == "true" ? 1 : 0;
        $data = array('sesuai' => $sesuai);
        $this->db->where('id_opmt_realisasi_harian_skp', $id);
        $update = $this->db->update('opmt_realisasi_harian_skp ', $data);
        if ($update) {
            echo 'ok';
        }
    }

    public function detail($id) {
        $id_user = $this->session->userdata('id_user');
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $x['skp_tahunan'] = $this->db->query("SELECT * FROM opmt_target_skp a 
INNER JOIN opmt_tahunan_skp b oN a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND b.id_dd_user={$id_user}")->result_array();
        $x['skp_bulanan'] = $this->db->query("SELECT * FROM(
SELECT a.id_opmt_target_bulanan_skp id,a.id_opmt_target_bulanan_skp,b.id_opmt_bulanan_skp,a.id_opmt_target_skp,b.tahun,d.kegiatan_tahunan kegiatan,a.turunan,a.target_kuantitas,c.satuan_kuantitas,a.realisasi_kualitas,a.target_waktu,a.biaya,'utama' ket
FROM (`opmt_target_bulanan_skp` a) 
INNER JOIN `opmt_bulanan_skp` b ON `b`.`id_opmt_bulanan_skp`=`a`.`id_opmt_bulanan_skp` AND b.id_dd_user={$id_user}
INNER JOIN `opmt_target_skp` d ON `d`.`id_opmt_target_skp`=`a`.`id_opmt_target_skp` 
LEFT JOIN `dd_kuantitas` c ON `c`.`id_dd_kuantitas`=`a`.`satuan_kuantitas` 
WHERE a.turunan=0
 UNION ALL
 SELECT d.id_opmt_turunan_skp,e.id_opmt_target_bulanan_skp,f.id_opmt_bulanan_skp,e.id_opmt_target_skp,f.tahun,d.kegiatan_turunan,' ',d.target_kuantitas,g.satuan_kuantitas,d.kualitas,d.target_waktu,d.biaya,'turunan' ket
 FROM opmt_turunan_skp d
 INNER JOIN opmt_target_bulanan_skp e on e.id_opmt_target_bulanan_skp =d.id_opmt_target_bulanan_skp
 INNER JOIN opmt_bulanan_skp f on f.id_opmt_bulanan_skp=e.id_opmt_bulanan_skp AND f.id_dd_user={$id_user}
 INNER JOIN `dd_kuantitas` g ON `g`.`id_dd_kuantitas`=`d`.`satuan_kuantitas` 
 ) a order by a.id_opmt_target_bulanan_skp")->result_array();
        $x['realisasi_skp'] = $this->db->query("SELECT * FROM opmt_realisasi_skp WHERE id_opmt_target_skp=" . $id_user)->row_array();
        $x['harian_skp'] = $this->db->query("SELECT * FROM opmt_realisasi_harian_skp WHERE id_opmt_realisasi_harian_skp=" . $id)->row_array();
        $this->load->view('harian_skp/v_detail_harian_skp', $x);
    }

}

<?php

class C_detail_skp_tahunan extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $dt['tahun'] = $this->db->query("SELECT DISTINCT year(awal_periode_skp)tahun FROM opmt_tahunan_skp")->result_array();
        $this->load->view('detail_skp_tahunan/v_detail', $dt);
    }

    public function user() {
        $dt['tahun'] = $this->db->query("SELECT DISTINCT year(awal_periode_skp)tahun FROM opmt_tahunan_skp")->result_array();
        $this->load->view("detail_skp_tahunan/v_detail_user", $dt);
    }

    public function bawahan() {
        $tahun = $this->input->post('tahun');
        $id_user = $this->session->userdata('id_user');
        $data['tahun'] = $tahun;
        $data['detail'] = $this->db->query("select b.id_opmt_target_skp,b.kegiatan_tahunan,d.id_opmt_target_skp_atasan,d.kegiatan_bawahan,d.nama,b.target_kuantitas,e.satuan_kuantitas from opmt_tahunan_skp a
inner join opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp
LEFT JOIN(
select b.id_opmt_target_skp_atasan,c.nama,b.kegiatan_tahunan kegiatan_bawahan from opmt_tahunan_skp a
inner join opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND b.id_opmt_target_skp_atasan>0
inner join dd_user c on a.id_dd_user=c.id_dd_user)d on d.id_opmt_target_skp_atasan=b.id_opmt_target_skp
LEFT JOIN dd_kuantitas e on e.id_dd_kuantitas=b.satuan_kuantitas
where a.id_dd_user={$id_user} AND year(a.awal_periode_skp)={$tahun}")->result_array();
        $this->load->view('detail_skp_tahunan/v_table', $data);
    }

    public function detail_user() {
        $tahun = $this->input->post('tahun');
        $id_user = $this->session->userdata('id_user');
        $data['tahun'] = $tahun;
        $data['detail'] = $this->db->query("select b.id_opmt_target_skp,b.kegiatan_tahunan,d.id_opmt_target_skp_atasan,d.kegiatan_bawahan,d.nama,b.target_kuantitas,e.satuan_kuantitas from opmt_tahunan_skp a
inner join opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp
LEFT JOIN(
select b.id_opmt_target_skp_atasan,c.nama,b.kegiatan_tahunan kegiatan_bawahan from opmt_tahunan_skp a
inner join opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND b.id_opmt_target_skp_atasan>0
inner join dd_user c on a.id_dd_user=c.id_dd_user)d on d.id_opmt_target_skp_atasan=b.id_opmt_target_skp
LEFT JOIN dd_kuantitas e on e.id_dd_kuantitas=b.satuan_kuantitas
where a.id_dd_user={$id_user} AND year(a.awal_periode_skp)={$tahun}")->result_array();
        $this->load->view('detail_skp_tahunan/v_table_user', $data);
    }

}

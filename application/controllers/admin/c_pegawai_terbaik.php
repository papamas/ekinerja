<?php

class C_pegawai_terbaik extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('M_pegawai_terbaik', 'pegawai');
    }

    public function index() {
        $x['dt_tahun'] = $this->db->query('SELECT DISTINCT tahun FROM opmt_bulanan_skp')->result_array();
        $this->load->view('pegawai_terbaik/v_table_skp', $x);
    }

    public function ajax_list() {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->pegawai->get_datatables($bulan, $tahun);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $dt) {
            $par = $dt->pegawai_terbaik == 1 ? 'checked' : '';
            $link_pilih = '<input type="checkbox" class="form-control" onclick="update(' . $dt->id_opmt_bulanan_skp . ',' . $tahun . ',' . $bulan . ')" ' . $par . '>';
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->nama;
            $row[] = $dt->nip;
            $row[] = number_format($dt->nilai_skp, 2);
            $row[] = $dt->ttl;
            $row[] = $dt->ttl_tambahan;
            $row[] = $dt->ttl_prod;
            $row[] = $dt->ttl_disposisi;
            $row[] = $link_pilih;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->pegawai->count_all($bulan, $tahun),
            "recordsFiltered" => $this->pegawai->count_filtered($bulan, $tahun),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function update() {
        $id = $this->input->post('id');
        $tahun = $this->input->post('tahun');
        $bulan = $this->input->post('bulan');
        $this->db->query("UPDATE opmt_bulanan_skp SET pegawai_terbaik=0 WHERE tahun={$tahun} AND bulan={$bulan}");
        $data = array("pegawai_terbaik" => 1);
        $this->db->where('id_opmt_bulanan_skp ', $id);
        $update = $this->db->update('opmt_bulanan_skp ', $data);
        if ($update) {
            echo 'ok';
        }
    }

}

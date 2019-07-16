<?php

class c_fitur extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['tahun'] = $this->db->query("SELECT distinct year(awal_periode_skp)tahun from opmt_tahunan_skp")->result_array();
        $this->load->view('rekap/v_index', $data);
    }

    public function lihat_laporan() {
         $data['bulan'] = $this->input->post('bulan');
        $data['tahun'] = $this->input->post('tahun');
        $jenis = $this->input->post('jenis');
        switch ($jenis) {
            case 1:
                $this->load->view('rekap/v_table1', $data);
                break;
            case 2:
                $this->load->view('rekap/v_table2', $data);
                break;
            case 3:
                $this->load->view('rekap/v_table3', $data);
                break;
        }
    }

    public function ajax_list1() {
        $this->load->model('M_pegawai_terbaik', 'pegawai');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->pegawai->get_datatables($bulan, $tahun);
        $data = array();
         $no = $_POST['start'];
        $no_awal = $no;
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
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
			 "mulai" => $no_awal,
            "sampai" => $no,
            "recordsTotal" => $this->pegawai->count_all($bulan, $tahun),
            "recordsFiltered" => $this->pegawai->count_filtered($bulan, $tahun),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list2() {
        $this->load->model('M_pegawai2', 'pegawai2');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->pegawai2->get_datatables($bulan, $tahun);
        $data = array();
        $no = $_POST['start'];
        $no_awal = $no;
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->nama;
            $row[] = $dt->nip;
            $row[] = $dt->unitkerja;
            $row[] = "Belum ada SKP Bulanan";
            $row[] = $dt->Lokasi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "mulai" => $no_awal,
            "sampai" => $no,
            "recordsTotal" => $this->pegawai2->count_all($bulan, $tahun),
            "recordsFiltered" => $this->pegawai2->count_filtered($bulan, $tahun),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function ajax_list3() {
        $this->load->model('M_pegawai3', 'pegawai3');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        //'kode_bank','nomor_rekening','nomor_akad','tgl_akad','nama','nik','nomor_sp','tgl_terbit_sp','nilai_dijamin','waktu_kirim','log_message'
        $list = $this->pegawai3->get_datatables($bulan, $tahun);
        $data = array();
        $no = $_POST['start'];
        $no_awal = $no;
        foreach ($list as $dt) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $dt->nama;
            $row[] = $dt->nip;
            $row[] = $dt->unitkerja;
            $row[] = "Belum Disetujui";
            $row[] = $dt->Lokasi;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "mulai" => $no_awal,
            "sampai" => $no,
            "recordsTotal" => $this->pegawai3->count_all($bulan, $tahun),
            "recordsFiltered" => $this->pegawai3->count_filtered($bulan, $tahun),
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

}

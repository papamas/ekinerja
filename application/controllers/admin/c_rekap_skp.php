<?php

class C_rekap_skp extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $data['tahun'] = $this->db->query("SELECT distinct year(awal_periode_skp)tahun from opmt_tahunan_skp")->result_array();
        $data['unitkerja'] = $this->db->query("SELECT *  from tblstruktural")->result_array();
        $this->load->view('rekap/v_index2', $data);
    }

    public function get_uker() {
        $nama = $this->input->post('q');
        $q = "SELECT kodeunit as id, concat(kodeunit, '-', unitkerja) as label, rtrim(unitkerja) as value FROM tblstruktural WHERE (unitkerja LIKE '%" . $nama . "%' OR kodeunit LIKE '%" . $nama . "%' ) AND  substring(kodeunit,4,2)='00'  ORDER BY value ASC";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }

    public function lihat_laporan() {
        $status = $this->input->post('status');
        $bulan = $this->input->post('bulan');
        $data['bulan'] = $bulan;
        $tahun = $this->input->post('tahun');
        $data['tahun'] = $tahun;
        $jenis = $this->input->post('jenis');
        $par_status = "";
//        if ($dt['nilai_skp'] > 0) {
//                    $status = "Disetujui";
//                } elseif ($dt['nilai_skp'] == "" && $dt['id_opmt_bulanan_skp'] > 0) {
//                    $status = "Belum Disetujui / Belum Approve";
//                } else {
//                    $status = "Belum Membuat SKP Bulanan";
//                }
        if ($status == 1) {
            $par_status = " AND nilai_skp>0";
        } elseif ($status == 2) {
            $par_status = " AND( nilai_skp is null AND id_opmt_bulanan_skp>0)";
        } else {
            $par_status = " AND id_opmt_bulanan_skp is null";
        }
        $par_unit = "";
        $par_jenis = substr($jenis, 0, 3);
        if (!empty($jenis)) {
            $par_unit = " AND substring(unit_kerja,1,3)='{$par_jenis}'";
        }
        $q = "select a.nip,a.nama,c.jabatan,d.unitkerja,f.Lokasi,b.nilai_skp,b.id_opmt_bulanan_skp
                FROM dd_user a
               LEFT JOIN opmt_bulanan_skp b on a.id_dd_user=b.id_dd_user AND bulan={$bulan} AND tahun={$tahun}
               INNER JOIN tbljabatan c on c.kodejab=a.jabatan
               INNER JOIN tblstruktural d on d.kodeunit=a.unit_kerja
               INNER JOIN tblrekaptk e on e.nip=a.nip
               INNER JOIN tbllokasikerja f on f.KodeLokasi=e.kodelokasi
               where 1=1 {$par_unit} {$par_status}";
        $data['rekap_skp'] = $this->db->query($q)->result_array();
        $this->load->view('rekap/v_table4', $data);
    }

    public function ajax_list1() {
        $this->load->model('M_pegawai_terbaik', 'pegawai');
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

}

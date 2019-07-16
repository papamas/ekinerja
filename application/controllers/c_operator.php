<?php

class C_operator extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("M_database");
    }

    public function absensi() {
        $x['unit'] = $this->db->get('dd_uker')->result_array();
        $this->load->view("operator/v_absensi", $x);
    }

    public function tambah_absensi() {
        $this->load->view('operator/v_tambah_absensi');
    }

    public function tambah_pengurang() {
        $this->load->view('operator/v_tambah_pengurang');
    }

    public function ubah_absensi($id) {
        $x['absensi'] = $this->db->query("SELECT * FROM opmt_absensi a LEFT JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE a.id_opmt_absensi={$id}")->row_array();
        $this->load->view('operator/v_tambah_absensi', $x);
    }

    public function ubah_pengurang($id) {
        $x['pengurang'] = $this->db->query("SELECT * FROM opmt_persentase_pengurang a LEFT JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE a.id_opmt_persentase_pengurang={$id}")->row_array();
        $this->load->view('operator/v_tambah_pengurang', $x);
    }

    public function lihat_absensi() {
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $unit = $this->input->post('unit');
        $x['absensi'] = $this->db->query("SELECT * FROM opmt_absensi a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE "
                        . "tahun={$thn} AND bulan={$bln} AND b.unit_kerja={$unit}")->result_array();
        $this->load->view('operator/v_hasil_absensi', $x);
    }

    public function lihat_pengurang() {
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $unit = $this->input->post('unit');
        $x['pengurang'] = $this->db->query("SELECT * FROM opmt_persentase_pengurang a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE "
                        . "tahun={$thn} AND bulan={$bln} AND b.unit_kerja={$unit}")->result_array();
        $this->load->view('operator/v_hasil_pengurang', $x);
    }

    public function get_nip() {
        $nip = $this->input->post('q');
        $data = $this->M_database->get_nip($nip);
        echo json_encode($data);
    }

    public function faktor_pengurang() {
        $x['unit'] = $this->db->get('dd_uker')->result_array();
        $this->load->view("operator/v_faktor_pengurang", $x);
    }

    public function aksi_absensi() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->id_opmt_absensi == '') {
            unset($p->id_opmt_absensi);
            $cek = $this->M_database->tambah_data('opmt_absensi', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $cek = $this->M_database->ubah_data('opmt_absensi', 'id_opmt_absensi', $p->id_opmt_absensi, $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diubah';
        }
        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function aksi_pengurang() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->id_opmt_persentase_pengurang == '') {
            unset($p->id_opmt_persentase_pengurang);
            $cek = $this->M_database->tambah_data('opmt_persentase_pengurang', $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil ditambah';
        } else {
            $cek = $this->M_database->ubah_data('opmt_persentase_pengurang', 'id_opmt_persentase_pengurang', $p->id_opmt_persentase_pengurang, $p);
            $a['status'] = 1;
            $a['ket'] = 'Data berhasil diubah';
        }
        if ($cek) {

            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Data gagal ditambah';
            $this->j($a);
        }
    }

    public function hapus_absensi() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_absensi', 'id_opmt_absensi', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_pengurang() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_persentase_pengurang', 'id_opmt_persentase_pengurang', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function dt_absensi() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $unit = $this->input->get('unit');
        $absensi = $this->db->query("SELECT * FROM opmt_absensi a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE "
                       . "tahun={$thn} AND bulan={$bln} AND b.unit_kerja={$unit} LIMIT {$offset},{$limit}")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM opmt_absensi a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE "
                       . "tahun={$thn} AND bulan={$bln} AND b.unit_kerja={$unit} ")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($absensi as $hsl) {
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_absensi(' . $hsl['id_opmt_absensi'] . ')">
<i class="fa fa-trash text-danger"/></a>';
            $link_edit= '<a href="javascript:void(0)" onclick="ubah_absensi(' . $hsl['id_opmt_absensi'] . ')">
<i class="fa fa-pencil text-success"/></a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'bulan' => $hsl['bulan'],
                'tahun' => $hsl['tahun'],
                'nip' => $hsl['nip'],
                'nama' => $hsl['nama'],
                'nilai_absensi' => $hsl['nilai_absensi']
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }
    public function dt_pengurang() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $unit = $this->input->get('unit');
        $absensi = $this->db->query("SELECT * FROM opmt_persentase_pengurang a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE "
                       . "tahun={$thn} AND bulan={$bln} AND b.unit_kerja={$unit} LIMIT {$offset},{$limit}")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM opmt_persentase_pengurang a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE "
                       . "tahun={$thn} AND bulan={$bln} AND b.unit_kerja={$unit} ")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($absensi as $hsl) {
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_pengurang(' . $hsl['id_opmt_persentase_pengurang'] . ')">
<i class="fa fa-trash text-danger"/></a>';
            $link_edit= '<a href="javascript:void(0)" onclick="ubah_pengurang(' . $hsl['id_opmt_persentase_pengurang'] . ')">
<i class="fa fa-pencil text-success"/></a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'bulan' => $hsl['bulan'],
                'tahun' => $hsl['tahun'],
                'nip' => $hsl['nip'],
                'nama' => $hsl['nama'],
                'persentase_pengurang' => $hsl['persentase_pengurang']. ' %'
            );

            $no++;
        }

        if (empty($cek)) {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => 0, 'rows' => array(), 'lama' => $lama);
        } else {
            $this->benchmark->mark('b');
            $lama = $this->benchmark->elapsed_time('a', 'b');
            $output = array('total' => $ttl, 'lama' => $lama, 'rows' => $cek);
        }
        echo json_encode($output);
    }

    public function j($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
    }

}

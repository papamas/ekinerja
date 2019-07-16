<?php

class C_pdf extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function cetak_target_tahunan_skp($id, $lokasi) {
        $id_user = $this->session->userdata('id_user');
        $cek = $this->db->query("SELECT * FROM dd_user WHERE id_dd_user={$id_user}")->row_array();
        if ($cek['atasan_langsung'] == "") {
            echo "User belum memiliki Atasan";
        } else {
            $params = array('type' => 'L', 'width' => 'M', 'height' => 'M');
            $this->load->library('html2pdf_lib', $params);
            $content = file_get_contents(base_url() . 'c_pdf/pdf_cetak_target_skp_tahunan/' . $id . '/' . $lokasi);
            $filename = 'Target SKP Tahunan.pdf';
            $this->html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
            $save_to = $this->config->item('upload_root');
            if ($this->html2pdf_lib->converHtml2pdf($content, $filename, $save_to)) {
                echo $save_to . '/' . $filename;
            } else {
                echo 'failed';
            }
        }
    }

    public function pdf_cetak_target_skp_tahunan($id, $lokasi) {
        $id_user = $this->session->userdata('id_user');
        $user = $this->db->query("SELECT id_dd_user FROM opmt_tahunan_skp WHERE id_opmt_tahunan_skp='" . $id . "'")->row_array();
        $q = "SELECT a.nip,a.nama,a.atasan_langsung,d.unitkerja nama_uker,b.jabatan nama_jabatan,concat(c.Golongan,'-',c.Pangkat) pangkat 
		FROM dd_user a
				LEFT JOIN tbljabatan b on b.kodejab=a.jabatan
				LEFT JOIN tblgolongan c on a.gol_ruang=c.KodeGol
				LEFT JOIN tblstruktural  d on a.unit_kerja=d.kodeUnit
				WHERE id_dd_user='" . $user['id_dd_user'] . "'";
        $data_user = $this->db->query($q)->row_array();
        $atasan_langsung = $data_user['atasan_langsung'];
        $data_atasan = $this->db->query("SELECT a.nip,a.nama,a.atasan_langsung,d.unitkerja nama_uker,b.jabatan nama_jabatan,concat(c.Golongan,'-',c.Pangkat) pangkat FROM dd_user a
LEFT JOIN tbljabatan b on b.kodejab=a.jabatan
				LEFT JOIN tblgolongan c on a.gol_ruang=c.KodeGol
				LEFT JOIN tblstruktural  d on a.unit_kerja=d.kodeUnit
WHERE id_dd_user='" . $atasan_langsung . "'")->row_array();
        $data_target = $this->db->query("SELECT a.*,b.satuan_kuantitas kuantitas,100 as kualitas FROM opmt_target_skp a LEFT JOIN dd_kuantitas b ON a.satuan_kuantitas=b.id_dd_kuantitas WHERE id_opmt_tahunan_skp='" . $id . "'")->result_array();
        $x['user'] = $data_user;
        $x['atasan'] = $data_atasan;
        $x['target'] = $data_target;
        $x['judul1'] = "FORMULIR SASARAN KINERJA";
        $x['judul2'] = "PEGAWAI NEGERI SIPIL";
        $x['lokasi'] = $this->db->query("select lokasi_spesimen from dd_spesimen WHERE id_dd_spesimen={$lokasi}")->row_array();
        $this->load->view('pdf/v_cetak_target_skp_tahunan', $x);
    }

    public function cetak_target_bulanan_skp($id, $lokasi) {
        $params = array('type' => 'L', 'width' => 'M', 'height' => 'M');
        $this->load->library('html2pdf_lib', $params);
        $content = file_get_contents(base_url() . 'c_pdf/pdf_cetak_target_skp_bulanan/' . $id . '/' . $lokasi);
        $filename = 'Target SKP Bulanan.pdf';
        $this->html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $save_to = $this->config->item('upload_root');
        if ($this->html2pdf_lib->converHtml2pdf($content, $filename, $save_to)) {
            echo $save_to . '/' . $filename;
        } else {
            echo 'failed';
        }
    }

    public function pdf_cetak_target_skp_bulanan($id, $lokasi) {
        $id_user = $this->session->userdata('id_user');
        $user = $this->db->query("SELECT id_dd_user,bulan,tahun FROM opmt_bulanan_skp WHERE id_opmt_bulanan_skp='" . $id . "'")->row_array();
        $id_user = $user['id_dd_user'];
        $bulan = $this->db->query("SELECT * FROM opmt_bulanan_skp WHERE id_opmt_bulanan_skp={$id}")->row_array();

        $q = "SELECT a.nip,a.nama,a.atasan_langsung,d.unitkerja nama_uker,b.jabatan nama_jabatan,concat(c.Golongan,'-',c.Pangkat) pangkat 
		FROM dd_user a
				LEFT JOIN tbljabatan b on b.kodejab=a.jabatan
				LEFT JOIN tblgolongan c on a.gol_ruang=c.KodeGol
				LEFT JOIN tblstruktural  d on a.unit_kerja=d.kodeUnit
				WHERE id_dd_user='{$id_user}'";

        $data_user = $this->db->query($q)->row_array();
        $atasan_langsung = $data_user['atasan_langsung'];
        $data_atasan = $this->db->query("SELECT a.nip,a.nama,a.atasan_langsung,d.unitkerja nama_uker,b.jabatan nama_jabatan,concat(c.Golongan,'-',c.Pangkat) pangkat  FROM dd_user a
                                LEFT JOIN tbljabatan b on b.kodejab=a.jabatan
				LEFT JOIN tblgolongan c on a.gol_ruang=c.KodeGol
				LEFT JOIN tblstruktural  d on a.unit_kerja=d.kodeUnit
WHERE id_dd_user='" . $atasan_langsung . "'")->row_array();
        $data_target = $this->db->query("SELECT * FROM(
SELECT a.id_dd_user,a.id_dd_user_bawahan,a.id_opmt_target_bulanan_skp id,a.id_opmt_target_bulanan_skp,b.id_opmt_bulanan_skp,a.id_opmt_target_skp,b.tahun,d.kegiatan_tahunan kegiatan,a.turunan,a.target_kuantitas,c.satuan_kuantitas,100 AS kualitas,a.target_waktu,a.biaya,'utama' ket
FROM (`opmt_target_bulanan_skp` a) 
INNER JOIN `opmt_bulanan_skp` b ON `b`.`id_opmt_bulanan_skp`=`a`.`id_opmt_bulanan_skp` AND b.bulan={$bulan['bulan']} AND b.tahun={$bulan['tahun']}
LEFT JOIN `opmt_target_skp` d ON `d`.`id_opmt_target_skp`=`a`.`id_opmt_target_skp` 
LEFT JOIN `dd_kuantitas` c ON `c`.`id_dd_kuantitas`=`a`.`satuan_kuantitas` 
WHERE ( a.id_dd_user={$id_user} OR a.id_dd_user_bawahan={$id_user})
 UNION ALL
 SELECT d.id_dd_user,d.id_dd_user_bawahan,d.id_opmt_turunan_skp,e.id_opmt_target_bulanan_skp,f.id_opmt_bulanan_skp,e.id_opmt_target_skp,f.tahun,d.kegiatan_turunan,' ',d.target_kuantitas,g.satuan_kuantitas,d.kualitas,d.target_waktu,d.biaya,'turunan' ket
FROM opmt_turunan_skp d
 LEFT JOIN opmt_target_bulanan_skp e on e.id_opmt_target_bulanan_skp =d.id_opmt_target_bulanan_skp
 INNER JOIN opmt_bulanan_skp f on f.id_opmt_bulanan_skp=e.id_opmt_bulanan_skp AND f.bulan={$bulan['bulan']} AND f.tahun={$bulan['tahun']}
 LEFT JOIN `dd_kuantitas` g ON `g`.`id_dd_kuantitas`=`d`.`satuan_kuantitas`
WHERE ( d.id_dd_user={$id_user} OR d.id_dd_user_bawahan={$id_user}) 
 ) a order by a.id_opmt_target_bulanan_skp")->result_array();
$x['id']=$id;
        $x['user'] = $data_user;
        $x['atasan'] = $data_atasan;
        $x['target'] = $data_target;
        $x['judul1'] = "FORMULIR SASARAN KINERJA";
        $x['judul2'] = "PEGAWAI NEGERI SIPIL";
        $x['judul3'] = "BULAN " . bulan($user['bulan']) . " TAHUN " . $user['tahun'];
        $x['lokasi'] = $this->db->query("select lokasi_spesimen from dd_spesimen WHERE id_dd_spesimen={$lokasi}")->row_array();
        $this->load->view('pdf/v_cetak_target_skp_bulanan', $x);
    }

    public function cetak_tunjangan($thn, $bln, $uker, $nip = 'none') {
        $params = array('type' => 'L', 'width' => '390', 'height' => '200');
        $this->load->library('html2pdf_lib', $params);
        $content = file_get_contents(base_url() . 'c_pdf/pdf_cetak_tunjangan/' . $thn . '/' . $bln . '/' . $uker . '/' . $nip);
        $filename = 'Tunjangan SKP.pdf';
        $this->html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $save_to = $this->config->item('upload_root');
        if ($this->html2pdf_lib->converHtml2pdf($content, $filename, $save_to)) {
            echo $save_to . '/' . $filename;
        } else {
            echo 'failed';
        }
    }

    public function pdf_cetak_tunjangan($thn, $bln, $uker, $nip) {

        $x['tahun'] = $thn;
        $x['bulan'] = $bln;
        $x['uker'] = $this->db->query("SELECT * FROM dd_uker where id_dd_uker={$uker}")->row_array();

        if ($nip !== "none") {
            $par_sql = " AND b.nip LIKE '%{$nip}%";
        } else {
            $par_sql = "";
        }
        $q = "SELECT * FROM opmt_absensi a
INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.unit_kerja={$uker}
INNER JOIN dd_jabatan c on b.jabatan=c.id_dd_jabatan
LEFT JOIN opmt_persentase_pengurang  d on d.id_dd_user=a.id_dd_user AND d.tahun=a.tahun AND d.bulan=a.bulan
LEFT JOIN opmt_bulanan_skp e on e.tahun =a.tahun AND e.bulan=a.bulan AND e.id_dd_user=a.id_dd_user
WHERE a.tahun={$thn} AND a.bulan={$bln} {$par_sql}";
        $x['tunjangan'] = $this->db->query($q)->result_array();
        $this->load->view('pdf/v_cetak_tunjangan', $x);
    }

    public function cetak_realisasi_tahunan_skp($id) {
        $id_user = $this->session->userdata('id_user');
        $params = array('type' => 'L', 'width' => 'M', 'height' => 'M');
        $this->load->library('html2pdf_lib', $params);
        $content = file_get_contents(base_url() . 'c_pdf/pdf_realisasi_tahunan_skp/' . $id . '/' . $id_user);
        $filename = 'Tunjangan SKP.pdf';
        $this->html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $save_to = $this->config->item('upload_root');
        if ($this->html2pdf_lib->converHtml2pdf($content, $filename, $save_to)) {
            echo $save_to . '/' . $filename;
        } else {
            echo 'failed';
        }
    }

    public function pdf_realisasi_tahunan_skp($id, $id_user) {
        $x['id'] = $id;

        $x['real'] = $this->db->query("SELECT a.*,b.satuan_kuantitas,sum(case when d.proses=0 then d.kuantitas else 0 end)realisasi_kuantitas,c.biaya biaya_realisasi,c.waktu waktu_realisasi,c.kualitas realisasi_kualitas
		FROM opmt_target_skp a 
			LEFT JOIN dd_kuantitas b ON a.satuan_kuantitas=b.id_dd_kuantitas 
			LEFT JOIN opmt_realisasi_skp c ON c.id_opmt_target_skp=a.id_opmt_target_skp
                        LEFT JOIN opmt_realisasi_harian_skp d ON d.id_opmt_target_skp=a.id_opmt_target_skp AND d.proses=''
			WHERE a.id_opmt_tahunan_skp='" . $id . "' GROUP BY a.id_opmt_target_skp")->result_array();
        $periode = $this->db->query("SELECT * FROM opmt_tahunan_skp WHERE id_opmt_tahunan_skp='" . $id . "'")->row_array();
        $x['periode'] = $periode;
        $x['user'] = $this->db->query("SELECT * FROM dd_user WHERE id_dd_user={$id_user}")->row_array();
        $x['tugas_tambahan'] = $this->db->query("SELECT * FROM opmt_tugas_tambahan WHERE year(tanggal)='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->result_array();
        $x['kreatifitas'] = $this->db->query("SELECT * FROM opmt_kreatifitas_skp WHERE year(tanggal)='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->result_array();
        $x['nilai_kreatifitas2'] = $this->db->query("SELECT * FROM opmt_kreatifitas_atasan WHERE tahun='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->row_array();
        $this->load->view('pdf/v_realisasi_tahunan_skp', $x);
    }

    public function cetak_rekap($bulan, $tahun, $uker = '',$status) {
        $params = array('type' => 'L', 'width' => '400', 'height' => '300');
        $this->load->library('html2pdf_lib', $params);
        $content = file_get_contents(base_url() . 'c_pdf/pdf_cetak_rekap/' . $bulan . '/' . $tahun . '/' . $uker. '/' . $status);
        $filename = 'Rekap.pdf';
        $this->html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $save_to = $this->config->item('upload_root');
        if ($this->html2pdf_lib->converHtml2pdf($content, $filename, $save_to)) {
            echo $save_to . '/' . $filename;
        } else {
            echo 'failed';
        }
    }

    public function pdf_cetak_rekap($bulan, $tahun, $uker,$status) {
        $data['bulan'] = $bulan;
        $data['tahun'] = $tahun;

        $par_unit = "";
        if ($uker >0) {
            $par_uker = substr($uker, 0, 3);
            $par_unit = " AND substring(unit_kerja,1,3)='{$par_uker}'";
        }
if ($status == 1) {
            $par_status = " AND nilai_skp>0";
        } elseif ($status == 2) {
            $par_status = " AND( nilai_skp is null AND id_opmt_bulanan_skp>0)";
        } else {
            $par_status = " AND id_opmt_bulanan_skp is null";
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
        $this->load->view('pdf/v_cetak_rekap', $data);
    }

    public function cetak_rekap_kinerja($tahun) {
        $id_user = $this->session->userdata('id_user');
        $params = array('type' => 'L', 'width' => 'M', 'height' => '300');
        $this->load->library('html2pdf_lib', $params);
        $content = file_get_contents(base_url() . 'c_pdf/pdf_cetak_rekap_kinerja/' . $tahun . '/' . $id_user);
        $filename = 'Rekap.pdf';
        $this->html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $save_to = $this->config->item('upload_root');

        if ($this->html2pdf_lib->converHtml2pdf($content, $filename, $save_to)) {
            echo $save_to . '/' . $filename;
        } else {
            echo 'failed';
        }
    }

    public function pdf_cetak_rekap_kinerja($tahun, $id_user) {
        $data['tahun'] = $tahun;
        $q = "SELECT * FROM (
SELECT a.id_opmt_target_skp,b.id_opmt_target_bulanan_skp,c.bulan,a.kegiatan_tahunan,a.kegiatan_tahunan as kegiatan_bulanan,coalesce(b.realisasi_kualitas,0)realisasi_kualitas
FROM opmt_target_skp a
INNER JOIN opmt_target_bulanan_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND b.turunan=0
LEFT JOIN opmt_bulanan_skp c on b.id_opmt_bulanan_skp=c.id_opmt_bulanan_skp AND tahun={$tahun}
WHERE a.id_dd_user={$id_user}
UNION ALL
SELECT a.id_opmt_target_skp,b.id_opmt_target_bulanan_skp,d.bulan,a.kegiatan_tahunan,c.kegiatan_turunan as kegiatan_bulanan,coalesce(c.realisasi_kualitas,0)realisasi_kualitas
FROM opmt_target_skp a
INNER JOIN opmt_target_bulanan_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND b.turunan=1
INNER JOIN opmt_turunan_skp c ON c.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp
LEFT JOIN opmt_bulanan_skp d on b.id_opmt_bulanan_skp=d.id_opmt_bulanan_skp AND tahun={$tahun}
WHERE a.id_dd_user={$id_user}
) x order by id_opmt_target_skp,bulan asc";
        $data_rekap = $this->db->query($q)->result_array();
        $parid = "";
        $par_bln = "";
        $parbln = "";
        $no = 1;

        foreach ($data_rekap as $dt) {
            if ($parbln != $dt['bulan']||$parid!==$dt['id_opmt_target_skp']) {
                $par[] = $dt['bulan'] . "_" . $dt['id_opmt_target_skp'];
                $par_bln[] = $dt['bulan'];
                $no = 1;
            }
            if ($parid != $dt['id_opmt_target_skp']) {
                $par_rata[] = $dt['id_opmt_target_skp'];
            }
            ${"arrKegiatanBulanan_" . $dt['bulan'] . "_" . $dt['id_opmt_target_skp']}[] = '<tr><td align="center">' . $no . '</td><td>' . $dt['kegiatan_bulanan'] . '</td><td align="right">' . ${"kualitas_" . $dt['id_opmt_target_skp']}[] = $dt['realisasi_kualitas'] . '</td></tr>';
            $parid = $dt['id_opmt_target_skp'];
            $parbln = $dt['bulan'];
            $no++;
        }
        for ($i = 0; $i < count($par); $i++) {
            $data['bulanan_' . $par[$i]] = ${"arrKegiatanBulanan_" . $par[$i]};

        }


        for ($i = 0; $i < count($par_rata); $i++) {
            $listValues = ${"kualitas_" . $par_rata[$i]};
//            var_dump($listValues) . '<br>';
            foreach (array_keys($listValues, 0) as $key) {
                unset($listValues[$key]);
            }
            $data['rata_' . $par_rata[$i]] = count($listValues) == 0 ? 0 : (array_sum($listValues) / count($listValues));
        }
        $data['par'] = $par;
        $data['rekap_skp'] = $this->db->query($q)->result_array();
        $this->load->view('pdf/v_cetak_rekap_kinerja', $data);
    }

    public function cetak_catatan($tahun, $bawahan) {
        $params = array('type' => 'L', 'width' => 'M', 'height' => '300');
        $this->load->library('html2pdf_lib', $params);
        $content = file_get_contents(base_url() . 'c_pdf/pdf_cetak_catatan/' . $tahun . '/' . $bawahan);
        $filename = 'Rekap.pdf';
        $this->html2pdf = new HTML2PDF('L', 'A4', 'en', true, 'UTF-8', array(0, 0, 0, 0));
        $save_to = $this->config->item('upload_root');

        if ($this->html2pdf_lib->converHtml2pdf($content, $filename, $save_to)) {
            echo $save_to . '/' . $filename;
        } else {
            echo 'failed';
        }
    }

    public function pdf_cetak_catatan($tahun, $bawahan) {
        $data['tahun'] = $tahun;
        $dt_user = $this->db->query("SELECT nama FROM dd_user where id_dd_user={$bawahan}")->row_array();
        $data['nama'] = $dt_user["nama"];
        $q = "SELECT bulan,catatan FROM opmt_bulanan_skp a WHERE id_dd_user={$bawahan} AND tahun={$tahun}";
        $data_rekap = $this->db->query($q)->result_array();

        foreach ($data_rekap as $dt) {
            ${"cat_" . $dt['bulan']}[] = $dt['catatan'];
            $par[] = $dt['bulan'];
        }
        for ($i = 0; $i < count($par); $i++) {
            $data['cat_' . $par[$i]] = ${"cat_" . $par[$i]};
        }
        $this->load->view('pdf/v_cetak_catatan', $data);
    }

}

?>
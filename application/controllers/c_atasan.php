<?php

class C_atasan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("M_database");
    }

// Bagian Pimpinan
    public function staff_bawahan() {
        $id_user = $this->session->userdata('id_user');
        $x['staff_bawahan'] = $this->db->query("SELECT * FROM dd_user a LEFT JOIN dd_jabatan b on a.jabatan=b.id_dd_jabatan WHERE atasan_langsung={$id_user}")->result_array();
        $this->load->view('atasan/v_staff_bawahan', $x);
    }

    public function drop_staff_bawahan() {
        $id = $this->input->post('id');
        $data = array("atasan_langsung" => "");
        $this->db->where('id_dd_user', $id);
        $drop = $this->db->update('dd_user', $data);
        if ($drop) {
            $a ['status'] = 1;
            $a['ket'] = "Staff Bawahan berhasil di drop";
        }
        $this->j($a);
    }

    public function skp_tahunan_bawahan() {
        $this->load->view('atasan/v_tahunan_bawahan');
    }

    public function skp_bulanan_bawahan() {
        $this->load->view("atasan/v_bulanan_bawahan");
    }

    public function lihat_bulanan() {
        $nama = $this->input->post('nama');
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $par_sql = "WHERE a.tahun={$tahun} AND a.bulan={$bulan}";
        if ($nama !== "") {
            $par_sql = " AND b.nama LIKE '%" . $nama . "%'";
        }
        $id_user = $this->session->userdata('id_user');
        $x['bulanan'] = $this->db->query("SELECT * FROM opmt_bulanan_skp a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.atasan_langsung={$id_user} {$par_sql}")->result_array();
        $this->load->view('atasan/v_tbl_bulanan', $x);
    }

    public function realisasi_bulanan_bawahan($id) {
        $data["id"] = $id;
        $data['parameter'] = $this->db->get('dc_parameter_bulan')->row_array();
        $periode = $this->db->query("SELECT * FROM opmt_bulanan_skp a LEFT JOIN dd_user b on a.id_dd_user=b.id_dd_user WHERE id_opmt_bulanan_skp={$id}")->row_array();
        $data['periode'] = $periode;
	    $data['par_user']= $periode['id_dd_user'];
        $data['disposisi'] = $this->db->query("SELECT * FROM opmt_disposisi WHERE month(tanggal_disposisi)={$periode['bulan']} AND id_dd_user={$periode['id_dd_user']}")->result_array();
        
		//var_dump($periode);exit;
		$q = "SELECT a.*,b.kuantitas realisasi_kuantitas
FROM(
SELECT a.id_dd_user,a.id_dd_user_bawahan,a.id_opmt_target_bulanan_skp id,a.realisasi_waktu,a.realisasi_kualitas,a.realisasi_biaya,a.id_opmt_target_bulanan_skp,b.id_opmt_bulanan_skp,a.id_opmt_target_skp,b.tahun,d.kegiatan_tahunan kegiatan,a.turunan,a.target_kuantitas,c.satuan_kuantitas,100 AS kualitas,a.target_waktu,a.biaya,'utama' ket,'0' ket2
FROM (`opmt_target_bulanan_skp` a) 
INNER JOIN `opmt_bulanan_skp` b ON `b`.`id_opmt_bulanan_skp`=`a`.`id_opmt_bulanan_skp` AND b.bulan={$periode['bulan']} AND b.tahun={$periode['tahun']}
LEFT JOIN `opmt_target_skp` d ON `d`.`id_opmt_target_skp`=`a`.`id_opmt_target_skp` 
LEFT JOIN `dd_kuantitas` c ON `c`.`id_dd_kuantitas`=`a`.`satuan_kuantitas` 
WHERE ( a.id_dd_user={$periode['id_dd_user']} OR a.id_dd_user_bawahan={$periode['id_dd_user']})
 UNION ALL
 SELECT d.id_dd_user,d.id_dd_user_bawahan,d.id_opmt_turunan_skp,d.realisasi_waktu,d.realisasi_kualitas,d.realisasi_biaya,e.id_opmt_target_bulanan_skp,f.id_opmt_bulanan_skp,e.id_opmt_target_skp,f.tahun,d.kegiatan_turunan,' ',d.target_kuantitas,g.satuan_kuantitas,d.kualitas,d.target_waktu,d.biaya,'turunan' ket,'1' ket2
FROM opmt_turunan_skp d
 LEFT JOIN opmt_target_bulanan_skp e on e.id_opmt_target_bulanan_skp =d.id_opmt_target_bulanan_skp
 INNER JOIN opmt_bulanan_skp f on f.id_opmt_bulanan_skp=e.id_opmt_bulanan_skp AND f.bulan={$periode['bulan']} AND f.tahun={$periode['tahun']}
 LEFT JOIN `dd_kuantitas` g ON `g`.`id_dd_kuantitas`=`d`.`satuan_kuantitas`
WHERE ( d.id_dd_user={$periode['id_dd_user']} OR d.id_dd_user_bawahan={$periode['id_dd_user']}) 
) a LEFT JOIN(
SELECT id_opmt_target_bulanan_skp,turunan,sum(kuantitas) kuantitas
FROM opmt_realisasi_harian_skp
	WHERE year(tanggal)={$periode['tahun']} AND month(tanggal)={$periode['bulan']} GROUP BY id_opmt_target_bulanan_skp,turunan
)b on a.id=b.id_opmt_target_bulanan_skp AND a.ket2=b.turunan
ORDER BY a.id_opmt_target_bulanan_skp";

        // var_dump($q);exit;
        $data['realisasi'] = $this->db->query($q)->result_array();
        $this->load->view("atasan/v_realisasi_bulanan", $data);
    }

    public function input_kualitas_bulanan_skp($id, $ket, $id_opmt_bulanan_skp) {
        $x['id'] = $id;
        $x['id2'] = $id_opmt_bulanan_skp;
        $x['keterangan'] = $ket;
        $data_1 = $this->db->where('id_opmt_bulanan_skp', $id_opmt_bulanan_skp)->from('opmt_bulanan_skp a')->join('dd_user b', 'a.id_dd_user=b.id_dd_user', 'LEFT')->get()->row_array();
        $id_user = $data_1['id_dd_user'];
        $bulan = $data_1['bulan'];
        $tahun = $data_1['tahun'];
        $x['data_periode'] = $data_1;
        if ($ket == 'turunan') {
            $data_id = $this->db->query("SELECT * FROM opmt_turunan_skp where id_opmt_turunan_skp={$id}")->row_array();
            $id2 = $data_id['id_opmt_target_bulanan_skp'];
            if ($data_id['id_dd_user_bawahan'] > 0) {
                $dt_user = $this->db->query("select * from dd_user where id_dd_user={$data_id['id_dd_user_bawahan']}")->row_array();
                $x['nama'] = $dt_user['nama'];
                $id_user_bawahan = $dt_user['id_dd_user'];
            } else {
                $x['nama'] = $data_1['nama'];
                $id_user_bawahan=$id_user;
    //                $dt_user = $this->db->query("select * from dd_user where id_dd_user={$data_id['id_dd_user_bawahan']}")->row_array();
    //                $id_user_bawahan = $dt_user['id_dd_user'];
            }
        } else {
            $id2 = $id;
            $x['nama'] = $data_1['nama'];
             $id_user_bawahan=$id_user;
        }
        if ($ket == 'turunan') {
            $param = "c.id_dd_user = {$id_user}";
        } else {
            $param = "a.id_dd_user={$id_user}";
        }
        $x['harian'] = $this->db->query("select 
COUNT(*) ttl_all,
count(case when a.sesuai=1 then a.id_opmt_realisasi_harian_skp else null end)ttl_sesuai,
count(case when a.id_opmt_target_bulanan_skp={$id} then a.id_opmt_realisasi_harian_skp else null end)kegiatan,
count(case when a.sesuai=1 AND a.id_opmt_target_bulanan_skp={$id} then a.id_opmt_realisasi_harian_skp else null end)kegiatan_sesuai
from (select a.id_opmt_realisasi_harian_skp,b.id_opmt_target_bulanan_skp,a.sesuai FROM opmt_realisasi_harian_skp a
INNER JOIN opmt_target_bulanan_skp b on a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp AND (b.id_dd_user={$id_user_bawahan} OR b.id_dd_user_bawahan={$id_user_bawahan}) AND a.turunan=0
 where month(tanggal)={$bulan} AND YEAR(tanggal)={$tahun}  AND a.id_dd_user={$id_user_bawahan}
 UNION ALL
 select a.id_opmt_realisasi_harian_skp,b.id_opmt_turunan_skp,a.sesuai FROM opmt_realisasi_harian_skp a
INNER JOIN opmt_turunan_skp b on a.id_opmt_target_bulanan_skp=b.id_opmt_turunan_skp AND (b.id_dd_user={$id_user_bawahan} OR b.id_dd_user_bawahan={$id_user_bawahan}) AND a.turunan=1
 where month(tanggal)={$bulan} AND year(tanggal)={$tahun} AND a.id_dd_user={$id_user_bawahan})  a")->row_array();
        $x['prod'] = $this->db->query("SELECT COUNT(*) ttl FROM opmt_produktivitas_skp a WHERE month(tanggal)={$bulan} and year(tanggal)={$tahun} AND a.id_dd_user={$id_user}")->row_array();
        if ($ket == 'turunan') {
            $x['bulanan'] = $this->db->query("SELECT kegiatan_turunan kegiatan,realisasi_kualitas,catatan FROM opmt_turunan_skp WHERE id_opmt_turunan_skp={$id}")->row_array();
        } else {
            $x['bulanan'] = $this->db->query("SELECT b.kegiatan_tahunan kegiatan,realisasi_kualitas,catatan FROM opmt_target_bulanan_skp a LEFT JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp WHERE id_opmt_target_bulanan_skp={$id}")->row_array();
        }
        $this->load->view('atasan/v_tambah_kualitas_bulanan_skp', $x);
    }

    public function lihat_bawahan() {
        $par_sql = "";
        $nama = $this->input->post('nama');
        if ($nama !== "") {
            $par_sql .= " AND b.nama LIKE '%" . $nama . "%'";
        }
        $tahun = $this->input->post('tahun');
        if ($tahun !== "") {
            $par_sql .= " AND YEAR(a.awal_periode_skp)='" . $tahun . "'";
        }
        $id_user = $this->session->userdata('id_user');
        $x['bawahan'] = $this->db->query("SELECT * FROM opmt_tahunan_skp a
INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.atasan_langsung='" . $id_user . "' {$par_sql}")->result_array();
        $this->load->view('atasan/v_tbl_bawahan', $x);
    }

    public function realisasi_bawahan($id) {
        $x['id'] = $id;
        $x['real'] = $this->db->query("SELECT a.*,b.satuan_kuantitas,
            f.biaya biaya_realisasi,f.waktu waktu_realisasi,f.kualitas,
			sum(case when c.proses=0 then c.kuantitas else 0 end)kuantitas_realisasi,f.waktu
			FROM opmt_target_skp a 
			LEFT JOIN dd_kuantitas b ON a.satuan_kuantitas=b.id_dd_kuantitas 
			LEFT JOIN opmt_realisasi_harian_skp c ON c.id_opmt_target_skp=a.id_opmt_target_skp AND c.proses=''
            LEFT JOIN opmt_target_bulanan_skp d on d.id_opmt_target_bulanan_skp=c.id_opmt_target_bulanan_skp AND c.id_dd_user=d.id_dd_user	
			LEFT JOIN opmt_realisasi_skp f ON f.id_opmt_target_skp=a.id_opmt_target_skp
            LEFT JOIN opmt_turunan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp AND d.id_dd_user=e.id_dd_user AND d.turunan=1
WHERE a.id_opmt_tahunan_skp='" . $id . "' GROUP BY a.id_opmt_target_skp")->result_array();
        $periode = $this->db->query("SELECT * FROM opmt_tahunan_skp a LEFT JOIN dd_user b ON a.id_dd_user=b.id_dd_user WHERE id_opmt_tahunan_skp='" . $id . "'")->row_array();
        $x['periode'] = $periode;
        $x['nama'] = $periode['nama'];
        $x['dari'] = date('d M Y', strtotime($periode['awal_periode_skp']));
        $x['sampai'] = date('d M Y', strtotime($periode['akhir_periode_skp']));
        $x['tahun'] = date('Y', strtotime($periode['akhir_periode_skp']));
        $id_user = $periode['id_dd_user'];

        $x['id_user'] = $periode['id_dd_user'];
        $x['tugas_tambahan'] = $this->db->query("SELECT * FROM opmt_tugas_tambahan WHERE year(tanggal)='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->result_array();
        $x['kreatifitas'] = $this->db->query("SELECT * FROM opmt_kreatifitas_skp WHERE year(tanggal)='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->result_array();
        $x['nilai_kreatifitas'] = $this->db->query("SELECT * FROM opmt_kreatifitas_skp WHERE year(tanggal)='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->result_array();
        $x['nilai_kreatifitas2'] = $this->db->query("SELECT * FROM opmt_kreatifitas_atasan WHERE tahun='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->row_array();
        $this->load->view('atasan/v_realisasi_bawahan', $x);
    }

    public function tambah_kreatifitas($id, $id_user, $tahun) {
        $x['id'] = $id;
        $x['id_user'] = $id_user;
        $x['tahun'] = $tahun;
        $x['dt_kreatifitas'] = $this->db->query("SELECT * FROM opmt_kreatifitas_atasan WHERE id_dd_user={$id_user} AND tahun={$tahun}")->row_array();
        $this->load->view('atasan/v_tambah_kreatifitas', $x);
    }

    public function tambah_kualitas($id) {
        $x['id'] = $id;
        $x['dt_kualitas'] = $this->db->query("SELECT a.*,b.id_opmt_realisasi_skp,b.biaya realisasi_biaya,b.waktu real_waktu,b.kualitas, SUM(c.kuantitas) real_kuantitas,d.satuan_kuantitas satuan 
		FROM opmt_target_skp a
LEFT JOIN opmt_realisasi_skp b on a.id_opmt_target_skp=b.id_opmt_target_skp
LEFT JOIN opmt_realisasi_harian_skp c on c.id_opmt_target_skp=a.id_opmt_target_skp AND c.proses=0
LEFT JOIN dd_kuantitas d ON c.satuan_kuantitas=d.id_dd_kuantitas
	WHERE a.id_opmt_target_skp={$id}
group by a.id_opmt_target_skp ")->row_array();

        $this->load->view('atasan/v_tambah_kualitas', $x);
    }

    public function aksi_kreatifitas() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->id_opmt_kreatifitas_atasan == '') {
            unset($p->id_opmt_kreatifitas_atasan);
            $cek = $this->M_database->tambah_data('opmt_kreatifitas_atasan', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_kreatifitas_atasan', 'id_opmt_kreatifitas_atasan', $p->id_opmt_kreatifitas_atasan, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Nilai Kreatifitas berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Nilai Kreatifitas gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_perilaku() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->id_opmt_perilaku == '') {
            unset($p->id_opmt_perilaku);
            $cek = $this->M_database->tambah_data('opmt_perilaku', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_perilaku', 'id_opmt_perilaku', $p->id_opmt_perilaku, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Nilai Perilaku berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Nilai Perilaku gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_kualitas() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->id_opmt_realisasi_skp == '') {
            unset($p->id_opmt_realisasi_skp);
            $cek = $this->M_database->tambah_data('opmt_realisasi_skp', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_realisasi_skp', 'id_opmt_realisasi_skp', $p->id_opmt_realisasi_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Kualitas berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Kualitas gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_kualitas_bulanan() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->keterangan == 'turunan') {
            $p->id_opmt_turunan_skp = $p->id;
            unset($p->id);
            unset($p->keterangan);
            $cek = $this->M_database->ubah_data('opmt_turunan_skp', 'id_opmt_turunan_skp', $p->id_opmt_turunan_skp, $p);
            $dt = $this->db->query("SELECT b.id_opmt_target_skp from opmt_turunan_skp a left join opmt_target_bulanan_skp b on a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp WHERE id_opmt_turunan_skp={$p->id_opmt_turunan_skp}")->row_array();
            $this->update_kualitas_tahunan($dt['id_opmt_target_skp']);
        } else {
            $p->id_opmt_target_bulanan_skp = $p->id;
            unset($p->id);
            unset($p->keterangan);
            $cek = $this->M_database->ubah_data('opmt_target_bulanan_skp', 'id_opmt_target_bulanan_skp', $p->id_opmt_target_bulanan_skp, $p);
            $dt = $this->db->query("SELECT id_opmt_target_skp from opmt_target_bulanan_skp  WHERE id_opmt_target_bulanan_skp={$p->id_opmt_target_bulanan_skp}")->row_array();
            $this->update_kualitas_tahunan($dt['id_opmt_target_skp']);
        }

        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Kualitas berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Kualitas gagal diubah';
            $this->j($a);
        }
    }

    public function update_kualitas_tahunan($id) {
        $data = $this->db->query("SELECT * FROM (
SELECT a.id_opmt_target_skp,b.id_opmt_target_bulanan_skp,c.bulan,a.kegiatan_tahunan,a.kegiatan_tahunan as kegiatan_bulanan,coalesce(b.realisasi_kualitas,0)realisasi_kualitas
FROM opmt_target_skp a
INNER JOIN opmt_target_bulanan_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND b.turunan=0
LEFT JOIN opmt_bulanan_skp c on b.id_opmt_bulanan_skp=c.id_opmt_bulanan_skp
WHERE a.id_opmt_target_skp={$id}
UNION ALL
SELECT a.id_opmt_target_skp,b.id_opmt_target_bulanan_skp,d.bulan,a.kegiatan_tahunan,c.kegiatan_turunan as kegiatan_bulanan,coalesce(c.realisasi_kualitas,0)realisasi_kualitas
FROM opmt_target_skp a
INNER JOIN opmt_target_bulanan_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND b.turunan=1
INNER JOIN opmt_turunan_skp c ON c.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp
LEFT JOIN opmt_bulanan_skp d on b.id_opmt_bulanan_skp=d.id_opmt_bulanan_skp
WHERE a.id_opmt_target_skp={$id}
) x order by id_opmt_target_skp,bulan asc")->result_array();
        foreach ($data as $dt) {
            $nilai[] = $dt['realisasi_kualitas'];
        }
//        die(var_dump($nilai));
        for ($i = 0; $i < count($nilai); $i++) {
            foreach (array_keys($nilai, 0) as $key) {
                unset($nilai[$key]);
            }
        }
        $rata = count($nilai) == 0 ? 0 : (array_sum($nilai) / count($nilai));
        $cek = $this->db->from("opmt_realisasi_skp")->where('id_opmt_target_skp', $id)->count_all_results();
        if ($cek == 0) {
            $this->db->query("INSERT INTO opmt_realisasi_skp (id_opmt_target_skp,kualitas) VALUES('{$id}','{$rata}')");
        } else {
            $this->db->query("UPDATE opmt_realisasi_skp SET kualitas={$rata} WHERE id_opmt_target_skp='{$id}'");
        }
    }

    public function nilai_perilaku() {
        $id_user = $this->session->userdata('id_user');
        $x['bawahan'] = $this->db->query("SELECT * FROM dd_user where atasan_langsung={$id_user}")->result_array();
        $x['tahun'] = $this->db->query("SELECT distinct year(awal_periode_skp) tahun FROM opmt_tahunan_skp")->result_array();
        $this->load->view('atasan/v_nilai_perilaku', $x);
    }

    public function lihat_perilaku() {
        $id_user = $this->input->post('id_user');
        $tahun = $this->input->post('tahun');
        $x['dt_perilaku'] = $this->db->query("SELECT * FROM opmt_perilaku WHERE tahun={$tahun} AND id_dd_user={$id_user}")->result_array();
        $x['nilai_rata'] = $this->db->query("SELECT AVG(orientasi_pelayanan) orientasi,AVG(integritas) integritas,AVG(komitmen) komitmen,AVG(disiplin) disiplin,AVG(kerjasama) kerjasama,AVG(kepemimpinan) kepemimpinan FROM opmt_perilaku WHERE tahun={$tahun} AND id_dd_user={$id_user}")->row_array();
        $this->load->view('atasan/v_tbl_perilaku', $x);
    }

    public function tambah_perilaku($tahun, $bulan, $id_user) {
        $x['xtahun'] = $tahun;
        $x['xbulan'] = $bulan;
        $x['id_user'] = $id_user;
        $x['user'] = $this->db->query("SELECT * FROM dd_user where id_dd_user={$id_user}")->row_array();
        $x['dt_perilaku'] = $this->db->query("SELECT * FROM opmt_perilaku where id_dd_user={$id_user} AND tahun={$tahun} AND bulan={$bulan}")->row_array();
        $this->load->view('atasan/v_tambah_perilaku', $x);
    }

    public function utama_skp_harian() {
        $x['tahun'] = $this->db->query("SELECT distinct year(tanggal) tahun FROM opmt_realisasi_harian_skp")->result_array();
        $this->load->view('atasan/v_utama_skp_harian', $x);
    }

    public function lihat_skp_harian() {
        $bln = $this->input->post('bln');
        $thn = $this->input->post('thn');
        $nama = $this->input->post('nama');

        $param = "";
        if ($nama !== "") {
            $param .= " AND c.nama LIKE '%{$nama}%'";
        }
        if ($bln !== 'all') {
            $param .= " AND month(a.tanggal)='{$bln}'";
        }
        if ($thn !== 'all') {
            $param .= " AND year(a.tanggal)='{$thn}'";
        }
        $id_user = $this->session->userdata("id_user");
        $x['harian'] = $this->db->query("SELECT a.id_opmt_realisasi_harian_skp,a.tanggal,c.nama,a.kegiatan_harian_skp,d.kegiatan_turunan kegiatan_bulanan,a.kuantitas,e.satuan_kuantitas
FROM opmt_realisasi_harian_skp a
LEFT JOIN opmt_target_bulanan_skp b on a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp
LEFT JOIN dd_kuantitas e ON e.id_dd_kuantitas=a.satuan_kuantitas
INNER JOIN dd_user c on a.id_dd_user=c.id_dd_user AND c.atasan_langsung={$id_user}
LEFT JOIN opmt_turunan_skp d on d.id_opmt_turunan_skp=a.id_opmt_target_bulanan_skp
		WHERE 1=1 {$param}
")->result_array();
        $this->load->view('atasan/v_lihat_skp_harian', $x);
    }

    public function lihat_harian_skp($id) {
        $x['realisasi_skp'] = $this->db->query("SELECT a.tanggal,a.proses,a.kegiatan_harian_skp,a.kuantitas,c.satuan_kuantitas,b.kegiatan,d.kegiatan_tahunan
FROM opmt_realisasi_harian_skp a 
#left join opmt_target_bulanan_skp b on a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp
LEFT JOIN (
SELECT a.id_opmt_target_bulanan_skp,b.kegiatan_tahunan kegiatan,'utama' ket
FROM opmt_Target_bulanan_skp a 
INNER JOIN opmt_target_skp b on a.id_opmt_target_skp=b.id_opmt_target_skp
UNION ALL
SELECT a.id_opmt_turunan_skp,a.kegiatan_turunan,'turunan' 
FROM opmt_turunan_skp a 
)b ON a.ket=b.ket COLLATE utf8_general_ci AND a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp
LEFT JOIN dd_kuantitas c on c.id_dd_kuantitas=a.satuan_kuantitas
LEFT JOIN opmt_target_skp d on d.id_opmt_target_skp=a.id_opmt_target_skp
WHERE a.id_opmt_realisasi_harian_skp=
" . $id)->row_array();
        $this->load->view('atasan/v_lihat_harian_skp', $x);
    }

    public function update_bulanan_skp() {
        $id = $this->input->post('id');
        $nilai = $this->input->post('nilai');
        $this->db->where('id_opmt_bulanan_skp', $id);
        $data = array('nilai_skp' => $nilai);
        $update = $this->db->update('opmt_bulanan_skp', $data);
        if ($update) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Diupdate";
        }
        $this->j($a);
    }

    public function dt_harian_skp() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $bln = $this->input->get('bln');
        $thn = $this->input->get('thn');
        $nama = $this->input->get('nama');

        $param = "";
        if ($nama !== "") {
            $param .= " AND c.nama LIKE '%{$nama}%'";
        }
        if ($bln !== 'all') {
            $param .= " AND month(a.tanggal)='{$bln}'";
        }
        if ($thn !== 'all') {
            $param .= " AND year(a.tanggal)='{$thn}'";
        }
        $id_user = $this->session->userdata("id_user");
        $harian = $this->db->query("SELECT a.id_opmt_realisasi_harian_skp,a.tanggal,c.nama,a.kegiatan_harian_skp,d.kegiatan_turunan kegiatan_bulanan,a.kuantitas,e.satuan_kuantitas
FROM opmt_realisasi_harian_skp a
LEFT JOIN opmt_target_bulanan_skp b on a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp
LEFT JOIN dd_kuantitas e ON e.id_dd_kuantitas=a.satuan_kuantitas
INNER JOIN dd_user c on a.id_dd_user=c.id_dd_user AND c.atasan_langsung={$id_user}
LEFT JOIN opmt_turunan_skp d on d.id_opmt_turunan_skp=a.id_opmt_target_bulanan_skp
		WHERE 1=1 {$param} LIMIT {$offset},{$limit}
")->result_array();
        $ttl_data = $this->db->query("SELECT COUNT(*) ttl
FROM opmt_realisasi_harian_skp a
LEFT JOIN opmt_target_bulanan_skp b on a.id_opmt_target_bulanan_skp=b.id_opmt_target_bulanan_skp
LEFT JOIN dd_kuantitas e ON e.id_dd_kuantitas=a.satuan_kuantitas
INNER JOIN dd_user c on a.id_dd_user=c.id_dd_user AND c.atasan_langsung={$id_user}
LEFT JOIN opmt_turunan_skp d on d.id_opmt_turunan_skp=a.id_opmt_target_bulanan_skp
		WHERE 1=1")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($harian as $hsl) {

            $link_detail = '<a href="javascript:void(0)" onclick="lihat_harian(' . $hsl['id_opmt_realisasi_harian_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_harian(' . $hsl['id_opmt_realisasi_harian_skp'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_detail' => $link_detail,
                'tanggal' => date('d M Y', strtotime($hsl['tanggal'])),
                'kegiatan_harian_skp' => $hsl['kegiatan_harian_skp'],
                'skp_bulanan' => $hsl['kegiatan_bulanan'],
                'kuantitas' => $hsl['kuantitas'],
                'nama' => $hsl['nama'],
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

    public function dt_bulanan_bawahan() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $nama = $this->input->get('nama');
        $par_sql = " WHERE a.tahun={$tahun} AND a.bulan={$bulan}";
        if ($nama !== "") {
            $par_sql .= " AND b.nama LIKE '%" . $nama . "%'";
        }
        $id_user = $this->session->userdata('id_user');
        $bulanan = $this->db->query("SELECT * FROM opmt_bulanan_skp a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.atasan_langsung={$id_user} {$par_sql} LIMIT {$offset},{$limit}")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM opmt_bulanan_skp a INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.atasan_langsung={$id_user} {$par_sql}")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($bulanan as $hsl) {
            $link_kualitas = '<a href="javascript:void(0)" onclick="realisasi_bulanan(' . $hsl['id_opmt_bulanan_skp'] . ')">
<i class="fa fa-pencil text-success"/></a>';
            $status_approve = $hsl['nilai_skp'] > 0 ? 'Disetujui' : 'Belum Disetujui';
            $cek[] = array(
                'no' => $no,
                'link_kualitas' => $link_kualitas,
                'bulan' => $hsl['bulan'],
                'tahun' => $hsl['tahun'],
                'nama' => $hsl['nama'],
                'status_approve' => $status_approve,
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

    public function dt_bawahan() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $id_user = $this->session->userdata('id_user');
        $bawahan = $this->db->query("SELECT * FROM dd_user a LEFT JOIN dd_jabatan b on a.jabatan=b.id_dd_jabatan WHERE atasan_langsung={$id_user} LIMIT {$offset},{$limit}")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM dd_user a LEFT JOIN dd_jabatan b on a.jabatan=b.id_dd_jabatan WHERE atasan_langsung={$id_user}")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($bawahan as $hsl) {
            $link_drop = '<a href="javascript:void(0)" onclick="drop_staff_bawahan(' . $hsl['id_dd_user'] . ')">
<i class="fa fa-trash text-danger"/></a>';
            $cek[] = array(
                'no' => $no,
                'link_drop' => $link_drop,
                'nama' => $hsl['nama'],
                'nip' => $hsl['nip'],
                'nama_jabatan' => $hsl['nama_jabatan']
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

    public function dt_tahunan_bawahan() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $par_sql = "";
        $nama = $this->input->get('nama');
        if ($nama !== "") {
            $par_sql .= " AND b.nama LIKE '%" . $nama . "%'";
        }
        $tahun = $this->input->get('tahun');
        if ($tahun !== "") {
            $par_sql .= " AND YEAR(a.awal_periode_skp)='" . $tahun . "'";
        }
        $id_user = $this->session->userdata('id_user');
        $bawahan = $this->db->query("SELECT * FROM opmt_tahunan_skp a
INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.atasan_langsung='" . $id_user . "' {$par_sql} LIMIT {$offset},{$limit}")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM opmt_tahunan_skp a
INNER JOIN dd_user b on a.id_dd_user=b.id_dd_user AND b.atasan_langsung='" . $id_user . "' {$par_sql}")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($bawahan as $hsl) {
            $link_realisasi = '<a href="javascript:void(0)" onclick="realisasi_bawahan(' . $hsl['id_opmt_tahunan_skp'] . ')">
<i class="fa fa-pencil text-danger"/></a>';
            $cek[] = array(
                'no' => $no,
                'link_realisasi' => $link_realisasi,
                'nama' => $hsl['nama'],
                'periode' => date('d M Y', strtotime($hsl['awal_periode_skp'])) . ' - ' . date('d M Y', strtotime($hsl['akhir_periode_skp'])),
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

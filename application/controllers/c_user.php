<?php

class C_user extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model("M_database");
        $this->cek_sesi();
    }

    public function index() {
        $this->load->view('user/v_utama');
    }

    public function cek_sesi() {
        if ($this->session->userdata('id_user') == "") {
            $this->session->sess_destroy();
            echo '<script>';
            echo "alert('Sesi anda telah berakhir, silahkan login kembali');";
            echo 'window.parent.location = "./"';
            echo '</script>';
        }
    }

    public function profile() {
        $id_user = $this->session->userdata('id_user');
        $this->db->join('tbljabatan b', 'b.kodejab=a.jabatan', 'LEFT');
        $this->db->join('tblstruktural c', 'c.kodeunit=a.unit_kerja', 'LEFT');
        $this->db->join('dd_ruang_pangkat d', 'd.id_dd_ruang_pangkat=a.gol_ruang', 'LEFT');
        $this->db->join('dd_user e', 'e.id_dd_user=a.atasan_langsung', 'LEFT');
        $this->db->join('dd_user f', 'f.id_dd_user=a.atasan_2', 'LEFT');
        $this->db->join('dd_user g', 'g.id_dd_user=a.atasan_3', 'LEFT');
		 $this->db->join('dd_spesimen h', 'a.lok_ker=h.id_dd_spesimen', 'LEFT');
        $this->db->select('a.*,b.jabatan nama_jabatan,c.kodeunit uker, c.unitkerja nama_uker,d.*,
		e.nama nama_1,f.nama nama_2,g.nama nama_3, h.lokasi_spesimen lokasi');
        $x['user'] = $this->db->where('a.id_dd_user', $id_user)->from('dd_user a')->get()->row_array();
        $x['list_user'] = $this->db->from('dd_user')->where('id_dd_user !=', $id_user)->get()->result_array();
        $this->load->view('user/v_profile', $x);
    }
	
	public function get_lokasi() {
        $nip = $this->session->userdata('nip');
        $nama = $this->input->post('q');
        $q = "SELECT id_dd_spesimen id, lokasi_spesimen label,lokasi_spesimen value  FROM dd_spesimen WHERE lokasi_spesimen LIKE '$nama%'";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }

    public function get_user() {
        $nip = $this->session->userdata('nip');
        $nama = $this->input->post('q');
        $q = "SELECT id_dd_user as id, concat(nip, '-', nama) as label, rtrim(nama) as value FROM dd_user WHERE (nama LIKE '%" . $nama . "%' OR nip LIKE '%" . $nama . "%' ) AND NIP NOT IN('{$nip}')  ORDER BY value ASC";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }
	
	public function get_uker() {
        $nip = $this->session->userdata('nip');
        $nama = $this->input->post('q');
        $q = "SELECT kodeunit as id, unitkerja as label, unitkerja as value FROM 
		tblstruktural WHERE unitkerja LIKE '%" . $nama . "%'";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }
	
	public function get_jabatan() {
        $nip = $this->session->userdata('nip');
        $nama = $this->input->post('q');
        $q = "SELECT kodejab as id, jabatan as label, jabatan as value FROM 
		tbljabatan WHERE jabatan LIKE  '".$nama."%'";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }
	
	public function get_pangkat() {
        $nip = $this->session->userdata('nip');
        $nama = $this->input->post('q');
        $q = "SELECT id_dd_ruang_pangkat as id, concat(pangkat,' / ',golongan_ruang) as label,
		concat(pangkat,' / ',golongan_ruang) as value FROM 
		dd_ruang_pangkat WHERE pangkat LIKE  '".$nama."%' OR golongan_ruang LIKE '".$nama."%' ";
        $data = $this->db->query($q)->result();
        echo json_encode($data);
    }

    public function skp_tahunan() {
        $this->load->view('user/v_tahunan_skp');
    }

    public function skp_bulanan() {
        $this->load->view('user/v_bulanan_skp');
    }

    public function skp_harian() {
        $x['tahun'] = $this->db->query("SELECT DISTINCT YEAR(tanggal) tahun FROM opmt_tugas_tambahan")->result_array();
        $this->load->view('user/v_harian_skp', $x);
    }

    public function tugas_tambahan() {
        $x['tahun'] = $this->db->query("SELECT DISTINCT YEAR(tanggal) tahun FROM opmt_tugas_tambahan")->result_array();
        $this->load->view('user/v_tugas_tambahan', $x);
    }

    public function kreatifitas() {
        $x['tahun'] = $this->db->query("SELECT DISTINCT YEAR(tanggal) tahun FROM opmt_kreatifitas_skp")->result_array();
        $this->load->view('user/v_kreatifitas', $x);
    }

    public function lihat_harian_skp() {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $param = "";
        if ($bulan !== "all") {
            $param .= " AND month(a.tanggal)='{$bulan}'";
        }
        if ($tahun !== "all") {
            $param .= " AND year(a.tanggal)='{$tahun}'";
        }
        $id_user = $this->session->userdata('id_user');
        $x['harian'] = $this->db->query("SELECT * FROM opmt_realisasi_harian_skp a
LEFT JOIN (
SELECT a.id_opmt_target_bulanan_skp as id,b.kegiatan_tahunan as kegiatan_bulanan,'utama' as ket FROM opmt_target_bulanan_skp a
INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND a.id_dd_user=15

UNION ALL
SELECT id_opmt_turunan_skp as id,kegiatan_turunan,'turunan'as ket FROM opmt_turunan_skp d
INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
INNER JOIN opmt_target_skp f on e.id_opmt_target_skp=f.id_opmt_target_skp
INNER JOIN opmt_tahunan_skp g on g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp AND g.id_dd_user={$id_user}
)b on a.ket=b.ket AND b.id=a.id_opmt_target_bulanan_skp
LEFT JOIN dd_kuantitas c ON c.id_dd_kuantitas=a.satuan_kuantitas
		WHERE a.id_dd_user={$id_user}
		{$param} ORDER BY tanggal DESC
")->result_array();
        $this->load->view('user/v_tbl_harian_skp', $x);
    }

    public function lihat_tugas_tambahan() {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $param = "";
        if ($bulan !== "all") {
            $param .= " AND month(a.tanggal)='{$bulan}'";
        }
        if ($tahun !== "all") {
            $param .= " AND year(a.tanggal)='{$tahun}'";
        }
        $tahun = date("Y");
        $id_user = $this->session->userdata('id_user');
        $x['tugas'] = $this->db->query("SELECT * FROM opmt_tugas_tambahan a LEFT JOIN dd_kuantitas b on a.satuan_kuantitas=b.id_dd_kuantitas
		WHERE a.id_dd_user={$id_user} {$param}
")->result_array();
        $this->load->view('user/v_tbl_tugas_tambahan', $x);
    }

    public function lihat_kreatifitas() {
        $bulan = $this->input->post('bulan');
        $tahun = $this->input->post('tahun');
        $param = "";
        if ($bulan !== "all") {
            $param .= " AND month(a.tanggal)={$bulan}";
        }if ($tahun !== "all") {
            $param .= " AND year(a.tanggal)={$tahun}";
        }
        $id_user = $this->session->userdata('id_user');
        $x['kreatifitas'] = $this->db->query("SELECT * FROM opmt_kreatifitas_skp a LEFT JOIN dd_kuantitas b on a.satuan_kuantitas=b.id_dd_kuantitas
		WHERE a.id_dd_user={$id_user} {$param}
")->result_array();
        $this->load->view('user/v_tbl_kreatifitas', $x);
    }

    public function tambah_realisasi_tahunan_skp($id_tahun, $id) {
        $x['id'] = $id;
        $x['id_tahun'] = $id_tahun;
        $x['realisasi_skp'] = $this->db->query("SELECT * FROM opmt_realisasi_skp WHERE id_opmt_target_skp=" . $id)->row_array();
        $this->load->view('user/v_tambah_realisasi_tahunan_skp', $x);
    }

    public function tambah_harian_skp() {
        $bulan = (int) date('m');
        $tahun = date('Y');
        $id_user = $this->session->userdata('id_user');
        $x['parameter'] = $this->db->get('dc_parameter_bulan')->row_array();
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $x['skp_tahunan'] = $this->db->query("SELECT * FROM opmt_target_skp a 
INNER JOIN opmt_tahunan_skp b oN a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND b.id_dd_user={$id_user} AND year(b.awal_periode_skp)={$tahun} ")->result_array();
        $x['skp_bulanan'] = $this->db->query("SELECT * FROM(
SELECT a.id_opmt_target_bulanan_skp id,a.id_opmt_target_bulanan_skp,b.id_opmt_bulanan_skp,a.id_opmt_target_skp,b.tahun,d.kegiatan_tahunan kegiatan,a.turunan,a.target_kuantitas,c.satuan_kuantitas,a.realisasi_kualitas,a.target_waktu,a.biaya,'utama' ket
FROM (`opmt_target_bulanan_skp` a) 
INNER JOIN `opmt_bulanan_skp` b ON `b`.`id_opmt_bulanan_skp`=`a`.`id_opmt_bulanan_skp` AND b.id_dd_user={$id_user} AND tahun={$tahun} AND bulan={$bulan}
INNER JOIN `opmt_target_skp` d ON `d`.`id_opmt_target_skp`=`a`.`id_opmt_target_skp` 
LEFT JOIN `dd_kuantitas` c ON `c`.`id_dd_kuantitas`=`a`.`satuan_kuantitas` 
WHERE a.turunan=0
 UNION ALL
 SELECT d.id_opmt_turunan_skp,e.id_opmt_target_bulanan_skp,f.id_opmt_bulanan_skp,e.id_opmt_target_skp,f.tahun,d.kegiatan_turunan,' ',d.target_kuantitas,g.satuan_kuantitas,d.kualitas,d.target_waktu,d.biaya,'turunan' ket
 FROM opmt_turunan_skp d
 INNER JOIN opmt_target_bulanan_skp e on e.id_opmt_target_bulanan_skp =d.id_opmt_target_bulanan_skp
 INNER JOIN opmt_bulanan_skp f on f.id_opmt_bulanan_skp=e.id_opmt_bulanan_skp AND f.id_dd_user={$id_user} AND tahun={$tahun} AND bulan={$bulan}
 INNER JOIN `dd_kuantitas` g ON `g`.`id_dd_kuantitas`=`d`.`satuan_kuantitas` 
 ) a order by a.id_opmt_target_bulanan_skp")->result_array();
        $x['realisasi_skp'] = $this->db->query("SELECT * FROM opmt_realisasi_skp WHERE id_opmt_target_skp=" . $id_user)->row_array();
        $this->load->view('user/v_tambah_harian_skp', $x);
    }

    public function tambah_tugas_tambahan() {
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $this->load->view('user/v_tambah_tugas_tambahan', $x);
    }

    public function tambah_kreatifitas() {
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $this->load->view('user/v_tambah_kreatifitas', $x);
    }

    public function ubah_harian_skp($id) {
        $id_user = $this->session->userdata('id_user');
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $x['skp_tahunan'] = $this->db->query("SELECT * FROM opmt_target_skp a 
INNER JOIN opmt_tahunan_skp b oN a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND b.id_dd_user={$id_user}")->result_array();
        $x['parameter'] = $this->db->get('dc_parameter_bulan')->row_array();

        $x['skp_bulanan'] = $this->db->query("SELECT * FROM(
SELECT a.id_opmt_target_bulanan_skp id,a.id_opmt_target_bulanan_skp,b.id_opmt_bulanan_skp,a.id_opmt_target_skp,b.tahun,d.kegiatan_tahunan kegiatan,a.turunan,a.target_kuantitas,c.satuan_kuantitas,a.realisasi_kualitas,a.target_waktu,a.biaya,'utama' ket
FROM (`opmt_target_bulanan_skp` a) 
INNER JOIN `opmt_bulanan_skp` b ON `b`.`id_opmt_bulanan_skp`=`a`.`id_opmt_bulanan_skp` AND b.id_dd_user={$id_user} AND tahun=" . date('Y') . " 
INNER JOIN `opmt_target_skp` d ON `d`.`id_opmt_target_skp`=`a`.`id_opmt_target_skp` 
LEFT JOIN `dd_kuantitas` c ON `c`.`id_dd_kuantitas`=`a`.`satuan_kuantitas` 
WHERE a.turunan=0  
 UNION ALL
 SELECT d.id_opmt_turunan_skp,e.id_opmt_target_bulanan_skp,f.id_opmt_bulanan_skp,e.id_opmt_target_skp,f.tahun,d.kegiatan_turunan,' ',d.target_kuantitas,g.satuan_kuantitas,d.kualitas,d.target_waktu,d.biaya,'turunan' ket
 FROM opmt_turunan_skp d
 INNER JOIN opmt_target_bulanan_skp e on e.id_opmt_target_bulanan_skp =d.id_opmt_target_bulanan_skp
 INNER JOIN opmt_bulanan_skp f on f.id_opmt_bulanan_skp=e.id_opmt_bulanan_skp AND f.id_dd_user={$id_user} AND tahun=" . date('Y') . "   
 INNER JOIN `dd_kuantitas` g ON `g`.`id_dd_kuantitas`=`d`.`satuan_kuantitas` 
 ) a order by a.id_opmt_target_bulanan_skp")->result_array();
        $x['realisasi_skp'] = $this->db->query("SELECT * FROM opmt_realisasi_skp WHERE id_opmt_target_skp=" . $id_user)->row_array();
        $x['harian_skp'] = $this->db->query("SELECT * FROM opmt_realisasi_harian_skp WHERE id_opmt_realisasi_harian_skp=" . $id)->row_array();
        $this->load->view('user/v_tambah_harian_skp', $x);
    }

    public function tambah_tahunan_skp() {
        $x['cek_akses'] = $this->db->query("SELECT * FROM dc_parameter_bulan")->row_array();
        $this->load->view('user/v_tambah_tahunan_skp', $x);
    }

    public function tambah_bulanan_skp() {
        $x['cek_akses'] = $this->db->query("SELECT * FROM dc_parameter_bulan")->row_array();
        $this->load->view('user/v_tambah_bulanan_skp', $x);
    }

    public function target_tahunan_skp($id) {
        $data['id'] = $id;
        $data['periode'] = $this->db->query("SELECT * FROM opmt_tahunan_skp WHERE id_opmt_tahunan_skp='" . $id . "'")->row_array();
        $this->load->view('user/v_target_tahunan_skp', $data);
    }

    public function turunan($id, $id_opmt_bulanan, $id_turunan) {
        $data['id'] = $id;
        $data['id_opmt_bulanan'] = $id_opmt_bulanan;
        $data['id_turunan'] = $id_turunan;
        $data['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $data['target_tahunan'] = $this->db->query("SELECT * FROM opmt_target_skp WHERE id_opmt_target_skp='" . $id . "'")->row_array();
//        $data['turunan_skp'] = $this->db->query("SELECT * FROM opmt_turunan_skp WHERE id_opmt_turunan_skp='" . $id_turunan . "'")->row_array();
        $this->load->view('user/v_tambah_turunan', $data);
    }

    public function ubah_turunan($id, $id_turunan, $id_opmt_bulanan) {
        $data['id'] = $id;
        $data['id_bulanan'] = $id_opmt_bulanan;
        $data['id_turunan'] = $id_opmt_bulanan;

        $data['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $data['target_tahunan'] = $this->db->query("SELECT * FROM opmt_target_skp WHERE id_opmt_target_skp='" . $id . "'")->row_array();
        $data['turunan_skp'] = $this->db->query("SELECT * FROM opmt_turunan_skp WHERE id_opmt_turunan_skp='" . $id_turunan . "'")->row_array();
        $this->load->view('user/v_tambah_turunan', $data);
    }

    public function input_biaya_bulanan_skp($id, $ket, $id_opmt_bulanan) {
        $data['id'] = $id;
        $data['id_bulanan'] = $id_opmt_bulanan;
        $data['ket'] = $ket;
        if ($ket == 'utama') {
            $data['target'] = $this->db->query("SELECT * FROM opmt_target_bulanan_skp WHERE id_opmt_target_bulanan_skp='" . $id . "'")->row_array();
        } else {
            $data['target'] = $this->db->query("SELECT * FROM opmt_turunan_skp WHERE id_opmt_turunan_skp='" . $id . "'")->row_array();
        }
        $this->load->view('user/v_tambah_biaya', $data);
    }

    public function target_bulanan_skp($id) {
        $data['id'] = $id;
        $id_user = $this->session->userdata('id_user');
        $data['id_user'] = $id_user;
        $bulan = $this->db->query("SELECT * FROM opmt_bulanan_skp WHERE id_opmt_bulanan_skp={$id}")->row_array();
        $data['spesimen'] = $this->db->query('SELECT * FROM dd_spesimen')->result_array();
        $data['bawahan'] = $this->db->query("SELECT * from dd_user where atasan_langsung={$id_user}")->result_array();
        $data['turunan'] = $this->db->query("SELECT * FROM(
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
        $data['periode'] = $this->db->query("SELECT * FROM opmt_bulanan_skp WHERE id_opmt_bulanan_skp='" . $id . "'")->row_array();
        $this->load->view('user/v_target_bulanan_skp_2', $data);
    }

    public function get_nama() {
        $id = $this->input->post("bawahan");
        $user = $this->db->query("SELECT nama from dd_user where id_dd_user={$id}")->row_array();
        echo $user['nama'];
    }

    public function drop_target() {
        $id = $this->input->post("id");
        $bawahan = $this->input->post("bawahan");
        $ket = $this->input->post("ket");
        $id_opmt_bulanan_skp = $this->input->post("id_opmt_bulanan_skp");
        $flag = $this->input->post('flag');
        $id_dd_user_bawahan = $flag == 1 ? $bawahan : "";
        $table_utama = "opmt_target_bulanan_skp";
        $table_turunan = "opmt_turunan_skp";
        if ($ket == "utama") {
            $cek = $this->db->query("UPDATE {$table_utama} SET id_dd_user_bawahan='{$id_dd_user_bawahan}' WHERE id_opmt_target_bulanan_skp={$id}");
        } else {
            $cek = $this->db->query("UPDATE {$table_turunan} SET id_dd_user_bawahan='{$id_dd_user_bawahan}' WHERE id_opmt_turunan_skp={$id}");
        }
    }

    public function realisasi_bulanan_skp($id) {
        $data['id'] = $id;
        $id_user = $this->session->userdata('id_user');
        $periode = $this->db->query("SELECT * FROM opmt_bulanan_skp WHERE id_opmt_bulanan_skp={$id}")->row_array();
        $data['periode'] = $periode;
        $data['disposisi'] = $this->db->query("SELECT * FROM opmt_disposisi WHERE month(tanggal_disposisi)={$periode['bulan']} AND id_dd_user={$id_user}")->result_array();
	$bulan = $this->db->query("SELECT * FROM opmt_bulanan_skp WHERE id_opmt_bulanan_skp={$id}")->row_array();
        $data['realisasi'] = $this->db->query("SELECT a.*,b.kuantitas realisasi_kuantitas
FROM(
SELECT a.id_dd_user,a.id_dd_user_bawahan,a.id_opmt_target_bulanan_skp id,a.realisasi_waktu,a.realisasi_kualitas,a.realisasi_biaya,a.id_opmt_target_bulanan_skp,b.id_opmt_bulanan_skp,a.id_opmt_target_skp,b.tahun,d.kegiatan_tahunan kegiatan,a.turunan,a.target_kuantitas,c.satuan_kuantitas,100 AS kualitas,a.target_waktu,a.biaya,'utama' ket,'0' ket2
FROM (`opmt_target_bulanan_skp` a) 
INNER JOIN `opmt_bulanan_skp` b ON `b`.`id_opmt_bulanan_skp`=`a`.`id_opmt_bulanan_skp` AND b.bulan={$bulan['bulan']} AND b.tahun={$bulan['tahun']}
LEFT JOIN `opmt_target_skp` d ON `d`.`id_opmt_target_skp`=`a`.`id_opmt_target_skp` 
LEFT JOIN `dd_kuantitas` c ON `c`.`id_dd_kuantitas`=`a`.`satuan_kuantitas` 
WHERE ( a.id_dd_user={$id_user} OR a.id_dd_user_bawahan={$id_user})
 UNION ALL
 SELECT d.id_dd_user,d.id_dd_user_bawahan,d.id_opmt_turunan_skp,d.realisasi_waktu,d.realisasi_kualitas,d.realisasi_biaya,e.id_opmt_target_bulanan_skp,f.id_opmt_bulanan_skp,e.id_opmt_target_skp,f.tahun,d.kegiatan_turunan,' ',d.target_kuantitas,g.satuan_kuantitas,d.kualitas,d.target_waktu,d.biaya,'turunan' ket,'1' ket2
FROM opmt_turunan_skp d
 LEFT JOIN opmt_target_bulanan_skp e on e.id_opmt_target_bulanan_skp =d.id_opmt_target_bulanan_skp
 INNER JOIN opmt_bulanan_skp f on f.id_opmt_bulanan_skp=e.id_opmt_bulanan_skp AND f.bulan={$bulan['bulan']} AND f.tahun={$bulan['tahun']}
 LEFT JOIN `dd_kuantitas` g ON `g`.`id_dd_kuantitas`=`d`.`satuan_kuantitas`
WHERE ( d.id_dd_user={$id_user} OR d.id_dd_user_bawahan={$id_user}) 
) a LEFT JOIN(
SELECT id_opmt_target_bulanan_skp,turunan,sum(kuantitas) kuantitas
FROM opmt_realisasi_harian_skp
	WHERE year(tanggal)={$periode['tahun']} AND month(tanggal)={$periode['bulan']} GROUP BY id_opmt_target_bulanan_skp,turunan
)b on a.id=b.id_opmt_target_bulanan_skp AND a.ket2=b.turunan
ORDER BY a.id_opmt_target_bulanan_skp")->result_array();

        $this->load->view('user/v_realisasi_bulanan_skp', $data);
    }

    public function realisasi_tahunan_skp($id) {
        $x['id'] = $id;
        $id_user = $this->session->userdata('id_user');
		
		$sql	 = "SELECT a.*,g.angka_kredit,b.satuan_kuantitas,h.awal_periode_skp, h.akhir_periode_skp,SUM(CASE WHEN d.proses=0 THEN d.kuantitas ELSE 0 END)realisasi_kuantitas,c.biaya biaya_realisasi,c.waktu waktu_realisasi,c.kualitas realisasi_kualitas FROM opmt_target_skp a
		LEFT JOIN opmt_target_bulanan_skp e on e.id_opmt_target_skp=a.id_opmt_target_skp AND e.id_dd_user={$id_user}
		LEFT JOIN opmt_bulanan_skp f on f.id_opmt_bulanan_skp=e.id_opmt_bulanan_skp AND f.id_dd_user={$id_user}
		LEFT JOIN dd_kuantitas b ON a.satuan_kuantitas=b.id_dd_kuantitas
		LEFT JOIN opmt_realisasi_skp c ON c.id_opmt_target_skp=a.id_opmt_target_skp
		LEFT JOIN opmt_realisasi_harian_skp d ON d.id_opmt_target_skp=a.id_opmt_target_skp AND 
		d.proses='0' AND month(d.tanggal)=f.bulan AND e.id_dd_user={$id_user}
		LEFT JOIN opmt_detail_kegiatan_jabatan g ON a.id_opmt_detail_kegiatan_jabatan = g.id_opmt_detail_kegiatan_jabatan
		LEFT JOIN opmt_tahunan_skp h ON h.id_opmt_tahunan_skp = a.id_opmt_tahunan_skp
		WHERE a.id_opmt_tahunan_skp='{$id}'
		GROUP BY a.id_opmt_target_skp";

        $x['real'] = $this->db->query($sql)->result_array();
        $periode = $this->db->query("SELECT * FROM opmt_tahunan_skp WHERE id_opmt_tahunan_skp='" . $id . "'")->row_array();
        $x['periode'] = $periode;
        
        $x['kreatifitas'] = $this->db->query("SELECT * FROM opmt_kreatifitas_skp WHERE year(tanggal)='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->result_array();
		
        $x['nilai_kreatifitas2'] = $this->db->query("SELECT * FROM opmt_kreatifitas_atasan WHERE tahun='" . date('Y', strtotime($periode['awal_periode_skp'])) . "' AND id_dd_user={$id_user}")->row_array();
        $this->load->view('user/v_realisasi_tahunan_skp', $x);
    }

    public function tambah_target_tahunan_skp($id) {
        $data['id'] = $id;
        $id_user = $this->session->userdata('id_user');
        $data['dt_skp_tahunan_atasan'] = $this->db->query("select b.* from opmt_tahunan_skp a
INNER JOIN opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND a.id_dd_user=(select atasan_langsung from dd_user where id_dd_user={$id_user})")->result_array();
        $data['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $periode = $this->db->query("SELECT * FROM opmt_tahunan_skp WHERE id_opmt_tahunan_skp='" . $id . "'")->row_array();
        $data['periode'] = $periode;
        /*
		$data_user = $this->db->query("select a.*,b.kodeunit,b.unitkerja from dd_user 
		a INNER JOIN tblstruktural b ON b.kodeunit= concat(left(a.unit_kerja,3),'00')
WHERE a.id_dd_user={$id_user}")->row_array();
        */
		$data_user = $this->db->query("select a.*,b.kodeunit,b.unitkerja from dd_user 
		a INNER JOIN tblstruktural b ON b.kodeunit=a.unit_kerja 
		WHERE a.id_dd_user={$id_user}")->row_array();
		$data['rencana'] = $this->db->query("select * from opmt_rkt a
LEFT JOIN opmt_sasaran_strategis b on a.id_opmt_rkt=b.id_opmt_rkt
where kodeunit='{$data_user['kodeunit']}'")->result_array();
        $data['direktorat'] = $data_user['unitkerja'];
        $this->load->view('user/v_tambah_target_tahunan_skp', $data);
    }

    public function indikator_kinerja() {
        $id = $this->input->post('id');
        $x['indikator_utama'] = $this->db->where('flag_utama', 1)->where('id_opmt_sasaran_strategis', $id)->from("opmt_ik")->get()->result_array();
        $x['indikator_strategis'] = $this->db->where('flag_utama', 0)->where('id_opmt_sasaran_strategis', $id)->from("opmt_ik")->get()->result_array();
        $this->load->view('user/v_indikator', $x);
    }

    public function tambah_target_bulanan_skp($id) {
        $data['id'] = $id;
        $id_user = $this->session->userdata('id_user');
        $data_bulanan = $this->db->query("SELECT * FROM opmt_bulanan_skp WHERE id_opmt_bulanan_skp='" . $id . "'")->row_array();
        $data_tahunan = $this->db->query("SELECT * FROM opmt_tahunan_skp WHERE id_dd_user='" . $id_user . "' AND YEAR(awal_periode_skp)='" . $data_bulanan['tahun'] . "'")->result_array();
        $data['tahun'] = $data_bulanan['tahun'];
        $data['bulan'] = $data_bulanan['bulan'];
        $data['dt_skp_tahunan'] = $this->db->query("SELECT b.* FROM opmt_tahunan_skp a 
INNER JOIN opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp
WHERE a.id_dd_user={$id_user}")->result_array();
        $data['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $data['periode'] = $this->db->query("SELECT * FROM opmt_tahunan_skp WHERE id_opmt_tahunan_skp='" . $id . "'")->row_array();
        $this->load->view('user/v_tambah_target_bulanan_skp', $data);
    }

    public function ubah_target_bulanan_skp($id, $id_bulanan) {
        $data['id'] = $id;
        $id_user = $this->session->userdata('id_user');
        $data_bulanan = $this->db->query("SELECT * FROM opmt_bulanan_skp WHERE id_opmt_bulanan_skp='" . $id_bulanan . "'")->row_array();
        $data_tahunan = $this->db->query("SELECT * FROM opmt_tahunan_skp WHERE id_dd_user='" . $id_user . "' AND YEAR(awal_periode_skp)='" . $data_bulanan['tahun'] . "'")->result_array();
        foreach ($data_tahunan as $dt) {
            $id_opmt_tahunan_skp = $dt['id_opmt_tahunan_skp'];
        }
        $data['tahun'] = $data_bulanan['tahun'];
        $data['bulan'] = $data_bulanan['bulan'];
        $data['dt_skp_tahunan'] = $this->db->query("SELECT b.* FROM opmt_tahunan_skp a 
INNER JOIN opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp
WHERE a.id_dd_user={$id_user}")->result_array();
        $data['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $data['periode'] = $this->db->query("SELECT * FROM opmt_tahunan_skp WHERE id_opmt_tahunan_skp='" . $id . "'")->row_array();
        $data['target_bulanan_skp'] = $this->db->query("SELECT a.*,b.kegiatan_tahunan FROM opmt_target_bulanan_skp a LEFT JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp WHERE a.id_opmt_target_bulanan_skp='" . $id . "' ")->row_array();

        $this->load->view('user/v_tambah_target_bulanan_skp', $data);
    }

    public function aksi_profile() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->password == '') {
            unset($p->password);
        } else {
            $p->password = base64_encode($p->password);
        }

        $cek = $this->M_database->ubah_data('dd_user', 'id_dd_user', $p->id_dd_user, $p);

        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Profile berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Profile gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_bulanan_skp() {
        $p = json_decode(file_get_contents('php://input'));
        $p->id_dd_user = $this->session->userdata('id_user');
        $p->nip = $this->session->userdata('nip');
        if ($p->id_opmt_bulanan_skp == '') {
            unset($p->id_opmt_bulanan_skp);
            $p->id_dd_user = $this->session->userdata('id_user');
            $cek = $this->M_database->tambah_data('opmt_bulanan_skp', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_bulanan_skp', 'id_opmt_bulanan_skp', $p->id_opmt_bulanan_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Bulanan SKP berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Bulanan SKP gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_harian_skp() {
        $p = json_decode(file_get_contents('php://input'));
		
        if (isset($p->proses)) {
            $p->proses = 1;
        } else {
            $p->proses = 0;
        }
        $p->id_dd_user = $this->session->userdata('id_user');
        $par_bulanan = explode("-", $p->id_opmt_target_bulanan_skp);
        $p->id_opmt_target_bulanan_skp = $par_bulanan[0];
        $ket = $par_bulanan[1];
        if ($ket == 'utama') {
            $p->turunan = 0;
        } else {
            $p->turunan = 1;
        }
        if ($p->id_opmt_realisasi_harian_skp == '') {
            unset($p->id_opmt_realisasi_harian_skp);
//            $p->id_dd_user = $this->session->userdata('id_user');
            $cek = $this->M_database->tambah_data('opmt_realisasi_harian_skp', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_realisasi_harian_skp', 'id_opmt_realisasi_harian_skp', $p->id_opmt_realisasi_harian_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Harian SKP berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Harian SKP gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_tahunan_skp() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_opmt_tahunan_skp == '') {
            unset($p->id_opmt_tahunan_skp);
            $cek = $this->M_database->tambah_data('opmt_tahunan_skp', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_tahunan_skp', 'id_opmt_tahunan_skp', $p->id_opmt_tahunan_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Tahun SKP berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Tahun SKP gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_realisasi_skp() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_opmt_realisasi_skp == '0') {
            unset($p->id_opmt_realisasi_skp);
            $cek = $this->M_database->tambah_data('opmt_realisasi_skp', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_realisasi_skp', 'id_opmt_realisasi_skp', $p->id_opmt_realisasi_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Realisasi SKP berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Realisasi SKP gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_tugas_tambahan() {
        $p = json_decode(file_get_contents('php://input'));
        $p->id_dd_user = $this->session->userdata('id_user');
        if ($p->id_opmt_tugas_tambahan == '') {
            unset($p->id_opmt_tugas_tambahan);
            $cek = $this->M_database->tambah_data('opmt_tugas_tambahan', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_tugas_tambahan', 'id_opmt_tugas_tambahan', $p->id_opmt_tugas_tambahan, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Tugas Tambahan berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Tugas Tambahan gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_kreatifitas() {
        $p = json_decode(file_get_contents('php://input'));
        $p->id_dd_user = $this->session->userdata('id_user');
        if ($p->id_opmt_kreatifitas_skp == '') {
            unset($p->id_opmt_kreatifitas_skp);
            $cek = $this->M_database->tambah_data('opmt_kreatifitas_skp', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_kreatifitas_skp', 'id_opmt_kreatifitas_skp', $p->id_opmt_kreatifitas_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Nilai kreatifitas berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Nilai kreatifitas gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_turunan_skp() {
        $p = json_decode(file_get_contents('php://input'));

        if ($p->id_opmt_turunan_skp == '') {
            unset($p->id_opmt_turunan_skp);
            $p->id_dd_user = $this->session->userdata('id_user');
            $cek = $this->M_database->tambah_data('opmt_turunan_skp', $p);
        } else {
            unset($p->id_opmt_target_bulanan_skp);
            $cek = $this->M_database->ubah_data('opmt_turunan_skp', 'id_opmt_turunan_skp', $p->id_opmt_turunan_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Turunan SKP berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Turunan SKP gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_biaya_skp() {
        $p = json_decode(file_get_contents('php://input'));
        $p->id_dd_user = $this->session->userdata('id_user');
        if (isset($p->id_opmt_turunan_skp)) {
            if ($p->id_opmt_turunan_skp == "") {
                unset($p->id_opmt_turunan_skp);
                $cek = $this->M_database->tambah_data('opmt_turunan_skp', $p);
            } else {
                $cek = $this->M_database->ubah_data('opmt_turunan_skp', 'id_opmt_turunan_skp', $p->id_opmt_turunan_skp, $p);
            }
        } else {

            $cek = $this->M_database->ubah_data('opmt_target_bulanan_skp', 'id_opmt_target_bulanan_skp', $p->id_opmt_target_bulanan_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Turunan SKP berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Turunan SKP gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_target_tahunan_skp() {
        $p = json_decode(file_get_contents('php://input'));
		
        $p->id_dd_user = $this->session->userdata('id_user');
        if ($p->id_opmt_target_skp == '') {
			
			
			//var_dump($p);exit;
            unset($p->id_opmt_target_skp);
            $cek = $this->M_database->tambah_data('opmt_target_skp', $p);
        } else {
            $cek = $this->M_database->ubah_data('opmt_target_skp', 'id_opmt_target_skp', $p->id_opmt_target_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Target SKP berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Target SKP gagal diubah';
            $this->j($a);
        }
    }

    public function aksi_target_bulanan_skp() {
        $p = json_decode(file_get_contents('php://input'));
        if ($p->turunan == 'ya') {
            $p->turunan = 1;
            $p->target_kuantitas = "0";
            $p->target_waktu = "0";
            $p->satuan_kuantitas = "0";
            $p->biaya = "0";
        } else {
            $p->turunan = 0;
        }
        if ($p->id_opmt_target_bulanan_skp == '') {
            unset($p->id_opmt_target_bulanan_skp);
            $p->id_dd_user = $this->session->userdata('id_user');
			
			//var_dump($p);exit;
            $cek = $this->M_database->tambah_data('opmt_target_bulanan_skp', $p);
        } else {
            if ($p->turunan == 0) {
                $this->db->where('id_opmt_target_bulanan_skp', $p->id_opmt_target_bulanan_skp);
                $this->db->delete('opmt_turunan_skp');
            }
            $cek = $this->M_database->ubah_data('opmt_target_bulanan_skp', 'id_opmt_target_bulanan_skp', $p->id_opmt_target_bulanan_skp, $p);
        }
        if ($cek) {
            $a['status'] = 1;
            $a['ket'] = 'Target SKP Bulanan berhasil diubah';
            $this->j($a);
        } else {
            $a['status'] = 0;
            $a['ket'] = 'Target SKP Bulanan gagal diubah';
            $this->j($a);
        }
    }

    public function dt_target_tahunan_skp() {
        $this->benchmark->mark('a');
        $id_user = $this->session->userdata('id_user');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('tahunan_skp'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('tahunan_skp');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.id_opmt_target_skp";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
        $id = $this->input->get('id_target');
//        $par_where[] = array('where' => 'a.nama_jabatan', 'value' => $txt);
        $par_join[] = array('table' => 'opmt_tahunan_skp b', 'type' => 'INNER', 'on' => "b.id_opmt_tahunan_skp=a.id_opmt_tahunan_skp AND b.id_dd_user={$id_user} AND b.id_opmt_tahunan_skp={$id}");
        $par_join[] = array('table' => 'dd_kuantitas c', 'type' => 'LEFT', 'on' => 'c.id_dd_kuantitas=a.satuan_kuantitas');
        $group_by = 'a.id_opmt_target_skp';
        $sel = 'a.*,year(b.awal_periode_skp) tahun,c.satuan_kuantitas';
        $data = $this->M_database->list_data($select = $sel, $table = 'opmt_target_skp a', $par_join, $par_where = array(), $cari = 'year(a.awal_periode_skp)', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'opmt_target_skp a', $par_join, $par_where = array(), $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_target_tahunan_skp(' . $hsl['id_opmt_target_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_target_tahunan_skp(' . $hsl['id_opmt_target_skp'] . ')">
<i class="fa fa-trash text-danger"/></a>';


            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'tahun' => $hsl['tahun'],
                'kegiatan_tahunan' => $hsl['kegiatan_tahunan'],
                'target_kualitas' => 100,
                'target_kuantitas' => $hsl['target_kuantitas'] . ' ' . $hsl['satuan_kuantitas'],
                'target_waktu' => $hsl['target_waktu'] . ' bulan',
                'biaya' => number_format($hsl['biaya']),
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

    public function dt_target_bulanan_skp() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('tahun'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('tahun');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.id_opmt_target_bulanan_skp";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
//        $par_where[] = array('where' => 'a.nama_jabatan', 'value' => $txt);
        $par_join[] = array('table' => 'opmt_bulanan_skp b', 'type' => 'LEFT', 'on' => 'b.id_opmt_bulanan_skp=a.id_opmt_bulanan_skp');
        $par_join[] = array('table' => 'opmt_target_skp d', 'type' => 'LEFT', 'on' => 'd.id_opmt_target_skp=a.id_opmt_target_skp');
        $par_join[] = array('table' => 'dd_kuantitas c', 'type' => 'LEFT', 'on' => 'c.id_dd_kuantitas=a.satuan_kuantitas');
        $group_by = 'a.id_opmt_target_bulanan_skp';
        $sel = 'a.*,d.kegiatan_tahunan,b.tahun,c.satuan_kuantitas';
        $data = $this->M_database->list_data($select = $sel, $table = 'opmt_target_bulanan_skp2 a', $par_join, $par_where = array(), $cari = 'tahun', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'opmt_target_bulanan_skp a', $par_join, $par_where = array(), $cari = 'b.tahun', $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {
            if ($hsl['turunan'] == 1) {
                $link_turunan = '<a href="javascript:void(0)" onclick="lihat_turunan(' . $hsl['id_opmt_target_bulanan_skp'] . ',' . $hsl['id_opmt_target_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            } else {
                $link_turunan = "";
            }
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_target_bulanan_skp(' . $hsl['id_opmt_target_bulanan_skp'] . ',' . $hsl['id_opmt_bulanan_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_target_bulanan_skp(' . $hsl['id_opmt_target_bulanan_skp'] . ')">
<i class="fa fa-trash text-danger"/></a>';


            $cek[] = array(
                'no' => $no,
                'link_turunan' => $link_turunan,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'tahun' => $hsl['tahun'],
                'kegiatan_tahunan' => $hsl['kegiatan_tahunan'],
                'target_kuantitas' => $hsl['target_kuantitas'] . ' ' . $hsl['satuan_kuantitas'],
                'target_waktu' => $hsl['target_waktu'] . ' bulan',
                'biaya' => number_format($hsl['biaya']),
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

    public function dt_tahunan_skp() {
        $this->benchmark->mark('a');
        $id_user = $this->session->userdata('id_user');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('tahunan_skp'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('tahunan_skp');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.awal_periode_skp";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
        $par_where[] = array('where' => 'a.id_dd_user', 'value' => $id_user);
        $par_join[] = array();
        $group_by = '';
        $sel = 'a.*';
        $data = $this->M_database->list_data($select = $sel, $table = 'opmt_tahunan_skp a', $par_join = array(), $par_where, $cari = 'year(a.awal_periode_skp)', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'opmt_tahunan_skp a', $par_join = array(), $par_where, $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_tahunan_skp(' . $hsl['id_opmt_tahunan_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_tahunan_skp(' . $hsl['id_opmt_tahunan_skp'] . ')">
<i class="fa fa-trash text-danger"/></a>';
            $link_target_skp = '<a href="javascript:void(0)" onclick="target_tahunan_skp(' . $hsl['id_opmt_tahunan_skp'] . ')">
<i class="fa fa-file text-info"/></a>';
            $link_realisasi = '<a href="javascript:void(0)" onclick="realisasi_tahunan_skp(' . $hsl['id_opmt_tahunan_skp'] . ')">
<i class="fa fa-dashboard text-primary"/></a>';

            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'periode_skp' => date('d M Y', strtotime($hsl['awal_periode_skp'])) . ' - ' . date('d M Y', strtotime($hsl['akhir_periode_skp'])),
                'link_target_skp' => $link_target_skp,
                'link_realisasi' => $link_realisasi,
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

    public function dt_bulanan_skp() {
        $this->benchmark->mark('a');

        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');

        if (!($this->input->get('tahunan_skp'))) {
            $txt = "";
        } else {
            $txt = $this->input->get('tahunan_skp');
        }
        if (!($this->input->get('sort'))) {
            $sort = "a.tahun";
        } else {
            $sort = $this->input->get('sort');
        }
        if (!($this->input->get('order'))) {
            $order = "";
        } else {
            $order = $this->input->get('order');
        }
        $id_user = $this->session->userdata('id_user');
        $par_where[] = array('where' => 'a.id_dd_user', 'value' => $id_user);
        $par_join[] = array();
        $group_by = '';
        $sel = 'a.*';
        $data = $this->M_database->list_data($select = $sel, $table = 'opmt_bulanan_skp a', $par_join = array(), $par_where, $cari = 'tahun', $txt, $limit, $offset, $sort, $order, $group_by);
        $ttl = $this->M_database->ttl_data($table = 'opmt_bulanan_skp a', $par_join = array(), $par_where, $cari, $txt, $group_by);

        $no = $offset + 1;
        foreach ($data as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_bulanan_skp(' . $hsl['id_opmt_bulanan_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_bulanan_skp(' . $hsl['id_opmt_bulanan_skp'] . ')">
<i class="fa fa-trash text-danger"/></a>';
            $link_target_skp = '<a href="javascript:void(0)" onclick="target_bulanan_skp(' . $hsl['id_opmt_bulanan_skp'] . ')">
<i class="fa fa-file text-info"/></a>';
            $link_realisasi = '<a href="javascript:void(0)" onclick="realisasi_bulanan_skp(' . $hsl['id_opmt_bulanan_skp'] . ')">
<i class="fa fa-dashboard text-primary"/></a>';

            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'status_approve' => $hsl['nilai_skp'] > 0 ? 'Disetujui' : 'Belum Disetujui',
                'tahun' => $hsl['tahun'],
                'bulan' => $hsl['bulan'],
                'link_target_skp' => $link_target_skp,
                'link_realisasi' => $link_realisasi,
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

    public function ubah_tahunan_skp($id) {
        $x['cek_akses'] = $this->db->query("SELECT * FROM dc_parameter_bulan")->row_array();
        $x['tahunan_skp'] = $this->db->where('id_opmt_tahunan_skp', $id)->get('opmt_tahunan_skp')->row_array();
        $this->load->view('user/v_tambah_tahunan_skp', $x);
    }

    public function ubah_target_tahunan_skp($id) {
        $id_user = $this->session->userdata('id_user');
        $x['dt_skp_tahunan_atasan'] = $this->db->query("select b.* from opmt_tahunan_skp a
INNER JOIN opmt_target_skp b on a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND a.id_dd_user=(select atasan_langsung from dd_user where id_dd_user={$id_user})")->result_array();
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $x['target_tahunan_skp'] = $this->db->where('id_opmt_target_skp', $id)->join('opmt_tahunan_skp b', 'a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp', 'LEFT')->get('opmt_target_skp a')->row_array();
        $data_user = $this->db->query("select a.*,b.kodeunit,b.unitkerja from dd_user a INNER JOIN tblstruktural b ON b.kodeunit= concat(left(a.unit_kerja,3),'00')
WHERE a.id_dd_user={$id_user}")->row_array();
        $x['rencana'] = $this->db->query("select * from opmt_rkt a
LEFT JOIN opmt_sasaran_strategis b on a.id_opmt_rkt=b.id_opmt_rkt
where kodeunit='{$data_user['kodeunit']}'")->result_array();
        $x['direktorat'] = $data_user['unitkerja'];
        $this->load->view('user/v_tambah_target_tahunan_skp', $x);
    }

    public function ubah_tugas_tambahan($id) {
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $x['tugas'] = $this->db->query("SELECT * FROM opmt_tugas_tambahan WHERE id_opmt_tugas_tambahan={$id}")->row_array();
        $this->load->view('user/v_tambah_tugas_tambahan', $x);
    }

    public function ubah_kreatifitas($id) {
        $x['dt_kuantitas'] = $this->db->get('dd_kuantitas')->result_array();
        $x['dt_kreatifitas'] = $this->db->query("SELECT * FROM opmt_kreatifitas_skp WHERE id_opmt_kreatifitas_skp={$id}")->row_array();
        $this->load->view('user/v_tambah_kreatifitas', $x);
    }

    public function hapus_tahunan_skp() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_tahunan_skp', 'id_opmt_tahunan_skp', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_tugas_tambahan() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_tugas_tambahan', 'id_opmt_tugas_tambahan', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_kreatifitas() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_kreatifitas_skp', 'id_opmt_kreatifitas_skp', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_target_tahunan_skp() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_target_skp', 'id_opmt_target_skp', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_target_bulanan_skp() {
        $id = $this->input->post('id');
        $ket = $this->input->post('ket');
        if ($ket == 'turunan') {
            $hapus = $this->M_database->hapus_data('opmt_turunan_skp', 'id_opmt_turunan_skp', $id);
        } else {
            $hapus = $this->M_database->hapus_data('opmt_target_bulanan_skp', 'id_opmt_target_bulanan_skp', $id);
        }
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_realisasi_skp() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_realisasi_skp', 'id_opmt_realisasi_skp', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_harian() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_realisasi_harian_skp', 'id_opmt_realisasi_harian_skp', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function hapus_bulanan_skp() {
        $id = $this->input->post('id');
        $hapus = $this->M_database->hapus_data('opmt_bulanan_skp', 'id_opmt_bulanan_skp', $id);
        if ($hapus) {
            $a ['status'] = 1;
            $a['ket'] = "Data Berhasil Dihapus";
        }
        $this->j($a);
    }

    public function dt_tugas_tambahan() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');
        $param = "";
        if ($bulan !== "all") {
            $param .= " AND month(a.tanggal)='{$bulan}'";
        }
        if ($tahun !== "all") {
            $param .= " AND year(a.tanggal)='{$tahun}'";
        }
        $tahun = date("Y");
        $id_user = $this->session->userdata('id_user');
        $harian = $this->db->query("SELECT * FROM opmt_tugas_tambahan a LEFT JOIN dd_kuantitas b on a.satuan_kuantitas=b.id_dd_kuantitas
		WHERE a.id_dd_user={$id_user} {$param} LIMIT {$offset},{$limit}
")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM opmt_tugas_tambahan a LEFT JOIN dd_kuantitas b on a.satuan_kuantitas=b.id_dd_kuantitas
		WHERE a.id_dd_user={$id_user} {$param}")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($harian as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_tugas_tambahan(' . $hsl['id_opmt_tugas_tambahan'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_tugas_tambahan(' . $hsl['id_opmt_tugas_tambahan'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'tanggal' => date('d M Y', strtotime($hsl['tanggal'])),
                'tugas_tambahan' => $hsl['tugas_tambahan'],
                'kuantitas' => $hsl['target_kuantitas'] . ' ' . $hsl['satuan_kuantitas'],
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

    public function harian_skp() {
        $x['tahun'] = $this->db->query("SELECT DISTINCT YEAR(tanggal) tahun FROM opmt_tugas_tambahan")->result_array();
        $this->load->view('user/v_harian_skp', $x);
    }

    public function dt_harian_skp() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $param = "";
        if ($bulan !== "all") {
            $param .= " AND month(a.tanggal)='{$bulan}'";
        }
        if ($tahun !== "all") {
            $param .= " AND year(a.tanggal)='{$tahun}'";
        }
        $id_user = $this->session->userdata('id_user');
        $harian = $this->db->query("SELECT * FROM opmt_realisasi_harian_skp a
LEFT JOIN (
SELECT a.id_opmt_target_bulanan_skp as id,b.kegiatan_tahunan as kegiatan_bulanan,'utama' as ket FROM opmt_target_bulanan_skp a
INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND a.id_dd_user=15

UNION ALL
SELECT id_opmt_turunan_skp as id,kegiatan_turunan,'turunan'as ket FROM opmt_turunan_skp d
INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
INNER JOIN opmt_target_skp f on e.id_opmt_target_skp=f.id_opmt_target_skp
INNER JOIN opmt_tahunan_skp g on g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp AND g.id_dd_user={$id_user}
)b on a.ket=b.ket AND b.id=a.id_opmt_target_bulanan_skp
LEFT JOIN dd_kuantitas c ON c.id_dd_kuantitas=a.satuan_kuantitas
		WHERE a.id_dd_user={$id_user}
		{$param} ORDER BY tanggal DESC LIMIT {$offset},{$limit}
")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM opmt_realisasi_harian_skp a
LEFT JOIN (
SELECT a.id_opmt_target_bulanan_skp as id,b.kegiatan_tahunan as kegiatan_bulanan,'utama' as ket FROM opmt_target_bulanan_skp a
INNER JOIN opmt_target_skp b ON a.id_opmt_target_skp=b.id_opmt_target_skp AND a.id_dd_user=15

UNION ALL
SELECT id_opmt_turunan_skp as id,kegiatan_turunan,'turunan'as ket FROM opmt_turunan_skp d
INNER JOIN opmt_target_bulanan_skp e ON d.id_opmt_target_bulanan_skp=e.id_opmt_target_bulanan_skp
INNER JOIN opmt_target_skp f on e.id_opmt_target_skp=f.id_opmt_target_skp
INNER JOIN opmt_tahunan_skp g on g.id_opmt_tahunan_skp=f.id_opmt_tahunan_skp AND g.id_dd_user={$id_user}
)b on a.ket=b.ket AND b.id=a.id_opmt_target_bulanan_skp
LEFT JOIN dd_kuantitas c ON c.id_dd_kuantitas=a.satuan_kuantitas
		WHERE a.id_dd_user={$id_user} {$param}")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($harian as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_harian(' . $hsl['id_opmt_realisasi_harian_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_harian(' . $hsl['id_opmt_realisasi_harian_skp'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'tanggal' => date('d M Y', strtotime($hsl['tanggal'])),
                'kegiatan_harian_skp' => $hsl['kegiatan_harian_skp'],
                'skp_bulanan' => $hsl['kegiatan_bulanan'],
                'kuantitas' => $hsl['kuantitas'],
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
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

    public function dt_kreatifitas() {
        $this->benchmark->mark('a');
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $bulan = $this->input->get('bulan');
        $tahun = $this->input->get('tahun');

        $param = "";
        if ($bulan !== "all") {
            $param .= " AND month(a.tanggal)='{$bulan}'";
        }
        if ($tahun !== "all") {
            $param .= " AND year(a.tanggal)='{$tahun}'";
        }
        $id_user = $this->session->userdata('id_user');
        $kreatifitas = $this->db->query("SELECT * FROM opmt_kreatifitas_skp a LEFT JOIN dd_kuantitas b on a.satuan_kuantitas=b.id_dd_kuantitas
		WHERE a.id_dd_user={$id_user} {$param} LIMIT {$offset},{$limit}
")->result_array();
        $ttl_data = $this->db->query("SELECT count(*) ttl FROM opmt_kreatifitas_skp a LEFT JOIN dd_kuantitas b on a.satuan_kuantitas=b.id_dd_kuantitas
		WHERE a.id_dd_user={$id_user} {$param}")->row_array();
        $ttl = $ttl_data['ttl'];
        $no = $offset + 1;
        foreach ($kreatifitas as $hsl) {

            $link_edit = '<a href="javascript:void(0)" onclick="ubah_kreatifitas(' . $hsl['id_opmt_kreatifitas_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_kreatifitas(' . $hsl['id_opmt_kreatifitas_skp'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            $cek[] = array(
                'no' => $no,
                'link_edit' => $link_edit,
                'link_hapus' => $link_hapus,
                'tanggal' => date('d M Y', strtotime($hsl['tanggal'])),
                'kreatifitas' => $hsl['kreatifitas'],
                'kuantitas' => $hsl['target_kuantitas'] . ' ' . $hsl['satuan_kuantitas'],
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

    public function rubah_pass() {
        $user = $this->db->get('dd_user')->result_array();
        foreach ($user as $dt) {
            $this->rubah_pass2($dt['id_dd_user'], $dt['nip']);
        }
    }

    public function rubah_pass2($id, $pass) {
        $this->db->where('id_dd_user', $id);
        $data = array("password" => base64_encode($pass));
        $update = $this->db->update('dd_user', $data);
    }

    public function get_target_tahun() {
        $tahun = date('Y', strtotime($this->input->post('tanggal')));
        $id_user = $this->session->userdata('id_user');
        $z = $this->db->query("SELECT * FROM opmt_target_skp a 
INNER JOIN opmt_tahunan_skp b oN a.id_opmt_tahunan_skp=b.id_opmt_tahunan_skp AND b.id_dd_user={$id_user} AND year(b.awal_periode_skp)={$tahun}")->result();
        echo json_encode($z);
    }

public function get_user_bulanan_skp($id,$ket){
if($ket=='turunan'){
	$data=$this->db->query("SELECT id_dd_user_bawahan FROM opmt_turunan_skp WHERE id_opmt_turunan_skp={$id}")->row_array();
}else{
	$data=$this->db->query("SELECT id_dd_user_bawahan FROM opmt_target_bulanan_skp WHERE id_opmt_target_bulanan_skp={$id}")->row_array();
}	
echo $data['id_dd_user_bawahan'];
}

    public function get_target_bulan() {
        $tahun = date('Y', strtotime($this->input->post('tanggal')));
        $bulan = (int) date('m', strtotime($this->input->post('tanggal')));
        $id_user = $this->session->userdata('id_user');
        $x = $this->db->query("SELECT * FROM(
SELECT a.id_opmt_target_bulanan_skp id,a.id_opmt_target_bulanan_skp,b.id_opmt_bulanan_skp,a.id_opmt_target_skp,b.tahun,d.kegiatan_tahunan kegiatan,a.turunan,a.target_kuantitas,c.satuan_kuantitas,a.realisasi_kualitas,a.target_waktu,a.biaya,'utama' ket
FROM (`opmt_target_bulanan_skp` a) 
INNER JOIN `opmt_bulanan_skp` b ON `b`.`id_opmt_bulanan_skp`=`a`.`id_opmt_bulanan_skp` AND tahun={$tahun} AND bulan={$bulan}
INNER JOIN `opmt_target_skp` d ON `d`.`id_opmt_target_skp`=`a`.`id_opmt_target_skp` 
LEFT JOIN `dd_kuantitas` c ON `c`.`id_dd_kuantitas`=`a`.`satuan_kuantitas` 
WHERE a.turunan=0 AND ( a.id_dd_user={$id_user} OR a.id_dd_user_bawahan={$id_user} )
 UNION ALL
 SELECT d.id_opmt_turunan_skp,e.id_opmt_target_bulanan_skp,f.id_opmt_bulanan_skp,e.id_opmt_target_skp,f.tahun,d.kegiatan_turunan,' ',d.target_kuantitas,g.satuan_kuantitas,d.kualitas,d.target_waktu,d.biaya,'turunan' ket
 FROM opmt_turunan_skp d
 INNER JOIN opmt_target_bulanan_skp e on e.id_opmt_target_bulanan_skp =d.id_opmt_target_bulanan_skp
 INNER JOIN opmt_bulanan_skp f on f.id_opmt_bulanan_skp=e.id_opmt_bulanan_skp  AND tahun={$tahun} AND bulan={$bulan}
 INNER JOIN `dd_kuantitas` g ON `g`.`id_dd_kuantitas`=`d`.`satuan_kuantitas` 
 WHERE (d.id_dd_user ={$id_user} or d.id_dd_user_bawahan={$id_user})
 ) a order by a.id_opmt_target_bulanan_skp")->result();
        echo json_encode($x);
    }

}

?>
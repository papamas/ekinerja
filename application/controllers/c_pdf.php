<?php

class C_pdf extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function cetak_target_tahunan_skp($id, $lokasi) {
        
		$id_user = $this->session->userdata('id_user');   
        $filename = 'Target SKP.pdf';
		
		$this->load->library('PDFTC', array());
		$this->pdftc->setTitle_Header('Target SKP');
		$this->pdftc->setTitle('Target SKP');
		$this->pdftc->setPrintHeader(false);
		$this->pdftc->setPrintFooter(false);
		$this->pdftc->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdftc->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->pdftc->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->pdftc->SetMargins(10, 35, PDF_MARGIN_RIGHT);
		$this->pdftc->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdftc->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->pdftc->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		
		
		$qprestasi		= $this->_getPrestasi($id_user,$id,$lokasi);
		
		//var_dump($qprestasi->result_array());exit;
		$prestasi		= $qprestasi->row();
		
		
		$kegiatan		= $this->_getTargetTahunan($id_user,$id);			
		
		$tbl ='<table cellspacing="0" cellpadding="1" border="1">
		<tr style="font-weight:bold;">
			<td width="30" align="center">NO</td>
			<td colspan="3" width="365">I. PEJABAT PENILAI</td>
			<td width="40" align="center">NO</td>
			<td colspan="3" width="365">II. PEGAWAI NEGERI SIPIL YANG DINILAI</td>
		</tr>
		<tr>
			<td width="30" align="center">1.</td>
			<td width="125">Nama</td><td width="240">: '.$prestasi->nama_atasan_langsung.'</td>
			<td width="40" align="center">1.</td>
			<td width="125">Nama</td><td width="240">: '.$prestasi->nama.' </td>
		</tr>
		<tr>
			<td width="30" align="center">2.</td>
			<td width="125">NIP</td><td width="240">: '.$prestasi->nip_atasan_langsung.'</td>
			<td width="40" align="center">2.</td>
			<td width="125">NIP</td><td width="240">: '.$prestasi->nip.'</td>
		</tr>
		
		<tr>
			<td width="30" align="center">3.</td>
			<td width="125">pangkat/Gol.Ruang</td><td width="240">: '.$prestasi->golongan_ruang_atasan_langsung.', '.$prestasi->pangkat_atasan_langsung.'</td>
			<td width="40" align="center">3.</td>
			<td width="125">pangkat/Gol.Ruang</td><td width="240">: '.$prestasi->golongan_ruang.', '.$prestasi->pangkat.'</td>
		</tr>
		
		<tr>
			<td width="30" align="center">4.</td>
			<td width="125">Jabatan</td><td width="240">: '.$prestasi->jabatan_atasan_langsung.'</td>
			<td width="40" align="center">4.</td>
			<td width="125">Jabatan</td><td width="240">: '.$prestasi->jabatan.'</td>
		</tr>
		
		<tr>
			<td width="30" align="center">5.</td>
			<td width="125">Unit Kerja</td><td width="240">: '.$prestasi->unitkerja_atasan_langsung.'</td>
			<td width="40" align="center">5.</td>
			<td width="125">Unit Kerja</td><td width="240">: '.$prestasi->unitkerja.'</td>
		</tr>
		
		<tr style="font-weight:bold;" >
			<td width="30" rowspan="2" align="center">NO</td>
			<td width="365" rowspan="2" align="center">III. KEGIATAN TUGAS JABATAN</td>
			<td width="40" rowspan="2" align="center">AK</td>
			<td width="365" align="center">TARGET</td>
		</tr>
		<tr style="font-weight:bold;">
			<td width="100" align="center">KUANT/OUTPUT</td>
			<td width="70" align="center">MUTU</td>
			<td width="100" align="center">WAKTU</td>
			<td width="95" align="center">BIAYA</td>
		</tr>
		<tr bgcolor="#d0e1e1">
			<td width="30"  align="center">1</td>
			<td width="365" align="center">2</td>
			<td width="40" align="center">3</td>
			<td width="100" align="center">4</td>
			<td width="70" align="center">5</td>
			<td width="100" align="center">6</td>
			<td width="95" align="center">7</td>							
		</tr>';
		$no = 1;
		foreach($kegiatan->result() as $val){
			
			$tbl .='<tr>
				<td width="30"  align="center">'.$no.'.</td>';
			
			if(!is_null($val->angka_kredit)){	
				$tbl .='<td width="365" align="left"> '.$val->kegiatan_tahunan.
				'('.$val->angka_kredit.'/'.$val->satuan_kuantitas.')</td>
				<td width="40" align="center"> '.($val->angka_kredit*$val->target_kuantitas).'</td>';
			}else{
				$tbl .='<td width="365" align="left"> '.$val->kegiatan_tahunan.'</td>
				<td width="40" align="center">-</td>';
			
			}	
			$tbl .='<td width="100" align="center">'.$val->target_kuantitas.' '.$val->satuan_kuantitas.'</td>
				<td width="70" align="center">100</td>
				<td width="100" align="center">'.$val->target_waktu.' bulan</td>
				<td width="95" align="center">'.$val->target_biaya.'</td>
			</tr>';
			$no++;
		}		
			$tbl .='</table>';
	   
		$this->pdftc->AddPage('L', 'A4');
		$this->pdftc->SetFont('courier', 'B', 14);
		$this->pdftc->Setxy(0,12);
		$this->pdftc->Write(0, '   FORMULIR SASARAN KERJA', '', 0, 'C', true, 0, false, false, 0);
		$this->pdftc->Write(0, 'PEGAWAI NEGERI SIPIL', '', 0, 'C', true, 0, false, false, 0);		
		$this->pdftc->SetFont('freesans', '', 10);		

		
		$this->pdftc->SetXY(50, 160);
		$this->pdftc->Cell(30, 0, 'Pejabat Penilai,', 0,0, 'C', 0, '', 0, false, 'B', 'B');
		$this->pdftc->SetXY(50, 177);
		$this->pdftc->Cell(30, 0, $prestasi->nama_atasan_langsung, 0,0, 'C', 0, '', 0, false, 'B', 'B');
		
		$this->pdftc->SetXY(50, 180);
		$this->pdftc->Cell(30, 0, 'NIP.'.$prestasi->nip_atasan_langsung, 0,0, 'C', 0, '', 0, false, 'B', 'B');
					
		$this->pdftc->SetXY(235, 155);
		$this->pdftc->Cell(30, 0, $prestasi->lokasi_spesimen.', '.$prestasi->format_awal_periode_skp, 0,0, 'C', 0, '', 0, false, 'B', 'B');
		
		$this->pdftc->SetXY(235, 160);
		$this->pdftc->Cell(30, 0, 'Pegawai Negeri Sipil Yang Dinilai,', 0,0, 'C', 0, '', 0, false, 'B', 'B');
		
		$this->pdftc->SetXY(235, 177);
		$this->pdftc->Cell(30, 0,$prestasi->nama, 0,0, 'C', 0, '', 0, false, 'B', 'B');
		
		$this->pdftc->SetXY(235, 180);
		$this->pdftc->Cell(30, 0, 'NIP.'.$prestasi->nip, 0,0, 'C', 0, '', 0, false, 'B', 'B');				
		$this->pdftc->SetY(25);		
		$this->pdftc->writeHTML($tbl, true, false, false, false, '');	
		$this->pdftc->Output($filename, 'I');
			
		/*
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
		*/
    }
	
	function _getPrestasi($id_user, $id,$tahun){
	    $sql="SELECT 
    c.nip,
    c.id_dd_user,
    c.nama,
    SF_FORMATTANGGAL(a.awal_periode_skp) format_awal_periode_skp,
    o.lokasi_spesimen,
    m.golongan_ruang,
    m.pangkat,
    n.jabatan,
    c.atasan_langsung,
    c.atasan_2,
    c.atasan_3,
    d.nip nip_atasan_langsung,
    d.nama nama_atasan_langsung,
    e.jabatan jabatan_atasan_langsung,
    f.golongan_ruang golongan_ruang_atasan_langsung,
    f.pangkat pangkat_atasan_langsung,
    g.nip nip_atasan_2,
    g.nama nama_atasan_2,
    h.jabatan jabatan_atasan_2,
    i.golongan_ruang golongan_ruang_atasan_2,
    i.pangkat pangkat_atasan_2,
    CASE
        WHEN j.jenis = 'JFT' THEN 2
        WHEN j.jenis = 'JST' THEN 1
        WHEN j.jenis = 'JFU' THEN 4
        ELSE 3
    END jenis_jabatan,
    k.unitkerja unitkerja_atasan_langsung,
    l.unitkerja unitkerja_atasan_2, p.unitkerja 
FROM
    opmt_tahunan_skp  a
        LEFT JOIN
    dd_user c ON a.id_dd_user = c.id_dd_user
        LEFT JOIN
    dd_ruang_pangkat m ON c.gol_ruang = m.id_dd_ruang_pangkat
        LEFT JOIN
    tbljabatan n ON c.jabatan = n.kodejab
        LEFT JOIN
    dd_user d ON c.atasan_langsung = d.id_dd_user
        LEFT JOIN
    tbljabatan e ON d.jabatan = e.kodejab
        LEFT JOIN
    dd_ruang_pangkat f ON d.gol_ruang = f.id_dd_ruang_pangkat
        LEFT JOIN
    dd_user g ON c.atasan_2 = g.id_dd_user
        LEFT JOIN
    tbljabatan h ON g.jabatan = h.kodejab
        LEFT JOIN
    dd_ruang_pangkat i ON g.gol_ruang = i.id_dd_ruang_pangkat
        LEFT JOIN
    tbljabatan j ON c.jabatan = j.kodejab
        LEFT JOIN
    tblstruktural k ON d.unit_kerja = k.kodeunit
        LEFT JOIN
    tblstruktural l ON g.unit_kerja = l.kodeunit
        LEFT JOIN
    dd_spesimen o ON c.lok_ker = o.id_dd_spesimen
	LEFT JOIN tblstruktural p ON c.unit_kerja = p.kodeunit
       WHERE
    year(a.akhir_periode_skp) = '$tahun'
         AND a.id_dd_user = '$id_user'
         AND a.id_opmt_tahunan_skp = '$id'";
		 
		$query		= $this->db->query($sql);
		
		return $query;
		
	}
	
	function _getTargetTahunan($id_user,$id_tahun)
	{
	    $sql	="SELECT c.*, 
ROUND(c.nilai_kuantitas + c.nilai_kualitas + c.nilai_waktu,2) perhitungan,
CASE
	WHEN c.target_biaya > 0 THEN ROUND((c.nilai_kuantitas + c.nilai_kualitas + c.nilai_waktu )/4,3)
    ELSE ROUND((c.nilai_kuantitas + c.nilai_kualitas + c.nilai_waktu )/3,3)
END
nilai
FROM (SELECT b.*,
CASE
    WHEN b.persen_waktu <=24 THEN ((1.76 * b.target_Waktu - b.realisasi_waktu ) / b.target_waktu) * 100
    ELSE 76 - ((((1.76 * b.target_waktu - b.realisasi_waktu) / b.target_waktu ) * 100 ) - 100 )
END
nilai_waktu,
CASE
	WHEN b.persen_biaya <= 24 THEN  ((1.76 * b.target_biaya - b.realisasi_biaya) / b.target_biaya) * 100
    ELSE 76 - ((((1.76 * b.target_biaya - b.realisasi_biaya) / b.target_biaya ) * 100 ) - 100 )
END
nilai_biaya
FROM ( SELECT a.*,
(realisasi_kuantitas/target_kuantitas) * 100 nilai_kuantitas,
(realisasi_kualitas/100) * 100 nilai_kualitas,
100 - ( (realisasi_waktu/target_waktu) * 100) persen_waktu,
100 - ( (realisasi_biaya/target_biaya) * 100) persen_biaya
FROM 
(SELECT a.id_opmt_target_skp, a.id_opmt_detail_kegiatan_jabatan, f.angka_kredit, a.kegiatan_tahunan,a.target_kuantitas,
b.satuan_kuantitas,a.target_waktu,a.biaya target_biaya,
CASE 
	WHEN ISNULL(sum(c.kuantitas)) THEN 0
    ELSE sum(c.kuantitas)
END
realisasi_kuantitas,
CASE 
	WHEN ISNULL(d.kualitas) THEN 0
    ELSE d.kualitas
END
realisasi_kualitas,d.waktu realisasi_waktu,d.biaya realisasi_biaya, a.id_dd_user, 
e.id_opmt_tahunan_skp, e.awal_periode_skp, e.akhir_periode_skp
FROM  opmt_target_skp a
LEFT JOIN  dd_kuantitas b on a.satuan_kuantitas = b.id_dd_kuantitas
LEFT JOIN  opmt_realisasi_harian_skp c ON a.id_opmt_target_skp = c.id_opmt_target_skp AND c.proses=0
LEFT JOIN  opmt_realisasi_skp d ON a.id_opmt_target_skp = d.id_opmt_target_skp
LEFT JOIN  opmt_tahunan_skp e ON e.id_opmt_tahunan_skp = a.id_opmt_tahunan_skp
LEFT JOIN  opmt_detail_kegiatan_jabatan f ON a.id_opmt_detail_kegiatan_jabatan = f.id_opmt_detail_kegiatan_jabatan
WHERE a.id_dd_user='$id_user'
GROUP BY a.id_opmt_target_skp
 ) a) b ) c WHERE c.id_opmt_tahunan_skp ='$id_tahun' ";
		$query	=$this->db->query($sql);
		return $query;
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

    public function cetak_target_bulanan_skp($id) {
		
		$sql="SELECT a.id_opmt_bulanan_skp , b.kegiatan_tahunan,
c.kegiatan_turunan,c.target_kuantitas,c.satuan_kuantitas,c.kualitas,c.target_waktu,c.biaya,
c.realisasi_kualitas,c.realisasi_waktu,c.realisasi_biaya,
d.*
FROM opmt_target_bulanan_skp a
LEFT JOIN  opmt_target_skp b ON a.id_opmt_target_skp = b.id_opmt_target_skp
LEFT JOIN  opmt_turunan_skp c ON c.id_opmt_target_bulanan_skp = a.id_opmt_target_bulanan_skp
LEFT JOIN  opmt_realisasi_harian_skp d ON d.id_opmt_target_skp = b.id_opmt_target_skp 
where a.id_opmt_bulanan_skp='27504';";
		
		$this->load->library('PDFTC', array());
		
		$this->pdftc->setTitle_Header('Nilai Capaian SKP');
		$this->pdftc->setTitle('Nilai Capaian SKP');
		$this->pdftc->setPrintHeader(false);
		$this->pdftc->setPrintFooter(false);
		$this->pdftc->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdftc->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->pdftc->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->pdftc->SetMargins(10, 35, PDF_MARGIN_RIGHT);
		$this->pdftc->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdftc->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->pdftc->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		$this->pdftc->AddPage('L', 'A4');
		
		$this->pdftc->SetMargins(5,0,5);
		$this->pdftc->SetFont('courier', 'B', 14);
		$this->pdftc->Setxy(0,12);
		$this->pdftc->Write(0, 'PENILAIAN CAPAIAN SASARAN KERJA', '', 0, 'C', true, 0, false, false, 0);
		$this->pdftc->Write(0, 'PEGAWAI NEGERI SIPIL', '', 0, 'C', true, 0, false, false, 0);
		
		$tbl ='		
			<table cellspacing="0" cellpadding="1" border="1" style="border-collapse: collapse; ">    
		<tr style="font-weight:bold;">
			<td width="20" rowspan="2" align="center">NO</td>
			<td width="230" rowspan="2" align="center">I. KEGIATAN TUGAS JABATAN</td>
			<td width="30" rowspan="2" align="center">AK</td>
			<td width="190" align="center">TARGET</td>
			<td width="30" rowspan="2" align="center">AK</td>
			<td width="190" align="center">REALISASI</td>
			
			<td width="75" align="center" rowspan="2">PENGHITUNGAN</td>
			<td width="50" align="center" rowspan="2">NILAI<br/>CAPAIAN<br/>SKP</td>
		</tr>
		<tr style="font-weight:bold;">
			<td width="70" align="center">KUANT/<br/>OUTPUT</td>
			<td width="30" align="center">MUTU</td>
			<td width="40" align="center">WAKTU</td>
			<td width="50" align="center">BIAYA</td>
			
			<td width="70" align="center">KUANT/<br/>OUTPUT</td>
			<td width="30" align="center">MUTU</td>
			<td width="40" align="center">WAKTU</td>
			<td width="50" align="center">BIAYA</td>
		</tr>
		
		<tr bgcolor="#d0e1e1">
			<td width="20"  align="center">1</td>
			<td width="230" align="center">2</td>
			<td width="30" align="center">3</td>
			<td width="70" align="center">4</td>
			<td width="30" align="center">5</td>
			<td width="40" align="center">6</td>
			<td width="50" align="center">7</td>
			<td width="30" align="center">8</td>
			
			<td width="70" align="center">9</td>
			<td width="30" align="center">10</td>
			<td width="40" align="center">11</td>
			<td width="50" align="center">12</td>
			
			<td width="75" align="center">13</td>
			<td width="50" align="center">14</td>
		</tr>';
		
		
		$this->pdftc->writeHTML($tbl, true, false, true, false, '');
		$this->pdftc->Output('REALISASI.pdf', 'I');
		
		/*
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
		*/
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
        
        
        $filename = 'Nilai Capaian SKP.pdf';
		
		$kegiatan		= $this->_getKegiatanTahunan($id_user,$id);	
		$row_kegiatan	= $kegiatan->row();
		
		$this->load->library('PDFTC', array());
		$this->pdftc->setTitle_Header('Nilai Capaian SKP');
		$this->pdftc->setTitle('Nilai Capaian SKP');
		$this->pdftc->setPrintHeader(false);
		$this->pdftc->setPrintFooter(false);
		$this->pdftc->setHeaderFont(array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->pdftc->setFooterFont(array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
		$this->pdftc->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);
		$this->pdftc->SetMargins(10, 35, PDF_MARGIN_RIGHT);
		$this->pdftc->SetHeaderMargin(PDF_MARGIN_HEADER);
		$this->pdftc->SetFooterMargin(PDF_MARGIN_FOOTER);
		$this->pdftc->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
		$this->pdftc->AddPage('L', 'A4');
		
		$this->pdftc->SetMargins(5,0,5);
		$this->pdftc->SetFont('courier', 'B', 14);
		$this->pdftc->Setxy(0,12);
		$this->pdftc->Write(0, 'PENILAIAN CAPAIAN SASARAN KERJA', '', 0, 'C', true, 0, false, false, 0);
		$this->pdftc->Write(0, 'PEGAWAI NEGERI SIPIL', '', 0, 'C', true, 0, false, false, 0);
		$this->pdftc->SetFont('freesans', '', 10);
		$this->pdftc->Write(0, 'Jangka Waktu Penilaian : '.$row_kegiatan->format_awal_periode_skp.' s/d '.$row_kegiatan->format_akhir_periode_skp, '', 0, 'L', true, 0, false, false, 0);
		$this->pdftc->SetFont('freesans', '', 8);
			$tbl ='		
				<table cellspacing="0" cellpadding="1" border="1" style="border-collapse: collapse; ">    
			<tr style="font-weight:bold;">
				<td width="20" rowspan="2" align="center">NO</td>
				<td width="230" rowspan="2" align="center">I. KEGIATAN TUGAS JABATAN</td>
				<td width="30" rowspan="2" align="center">AK</td>
				<td width="190" align="center">TARGET</td>
				<td width="30" rowspan="2" align="center">AK</td>
				<td width="190" align="center">REALISASI</td>
				
				<td width="75" align="center" rowspan="2">PENGHITUNGAN</td>
				<td width="50" align="center" rowspan="2">NILAI<br/>CAPAIAN<br/>SKP</td>
			</tr>
			<tr style="font-weight:bold;">
				<td width="70" align="center">KUANT/<br/>OUTPUT</td>
				<td width="30" align="center">MUTU</td>
				<td width="40" align="center">WAKTU</td>
				<td width="50" align="center">BIAYA</td>
				
				<td width="70" align="center">KUANT/<br/>OUTPUT</td>
				<td width="30" align="center">MUTU</td>
				<td width="40" align="center">WAKTU</td>
				<td width="50" align="center">BIAYA</td>
			</tr>
			
			<tr bgcolor="#d0e1e1">
				<td width="20"  align="center">1</td>
				<td width="230" align="center">2</td>
				<td width="30" align="center">3</td>
				<td width="70" align="center">4</td>
				<td width="30" align="center">5</td>
				<td width="40" align="center">6</td>
				<td width="50" align="center">7</td>
				<td width="30" align="center">8</td>
				
				<td width="70" align="center">9</td>
				<td width="30" align="center">10</td>
				<td width="40" align="center">11</td>
				<td width="50" align="center">12</td>
				
				<td width="75" align="center">13</td>
				<td width="50" align="center">14</td>
			</tr>';
				
			$no 		= 1;
			$total_nilai= 0;
			$total_nilai_capaian_skp = 0;
			$jumlah_kegiatan = $kegiatan->num_rows();
			foreach ($kegiatan->result() as $value)
			{
				$tbl .='<tr>
					<td width="20"  align="center">'.$no.'.</td>';
					if(!IS_NULL($value->angka_kredit)){
						$tbl .='
						<td width="230" align="left">'. $value->kegiatan_tahunan.'('.$value->angka_kredit.'/'.$value->satuan_kuantitas.')</td>
						<td width="30" align="center">'.$value->angka_kredit*$value->target_kuantitas.'</td>';
					}else{
					    $tbl .='<td width="230" align="left">'. $value->kegiatan_tahunan.'</td>
						<td width="30" align="center">-</td>';
					}						
					$tbl .='<td width="70" align="center">'.$value->target_kuantitas.' '.$value->satuan_kuantitas.'</td>
					<td width="30" align="center">100</td>
					<td width="40" align="center">'.$value->target_waktu.' bulan</td>
					<td width="50" align="center">'.$value->target_biaya.'</td>';
					if(!IS_NULL($value->angka_kredit)){						
						$tbl .='<td width="30" align="center">'.$value->angka_kredit*$value->realisasi_kuantitas.'</td>';
					}else{
						$tbl .='<td width="30" align="center">-</td>';
                    }
 					
					$tbl .='<td width="70" align="center">'.$value->realisasi_kuantitas.' '.$value->satuan_kuantitas.'</td>';
					
					$tbl .='
					<td width="30" align="center">'.$value->realisasi_kualitas.'</td>
					<td width="40" align="center">'.$value->realisasi_waktu.' bulan</td>
					<td width="50" align="center">'.$value->realisasi_biaya.'</td>
					
					<td width="75" align="center">'.ROUND($value->perhitungan,2).'</td>
					<td width="50" align="center">'.ROUND($value->nilai,2).'</td>
				</tr>';
				
				$total_nilai	= $total_nilai +  $value->nilai;
				$no++;
			}	
			
			$tbl .= '<tr style="font-weight:bold;" bgcolor="#d0e1e1">
				<td width="765" align="center" colspan="6"> Jumlah Nilai SKP</td>
				<td width="50" align="center" >'.ROUND($total_nilai/$jumlah_kegiatan,2).'</td>
			</tr>';
			
			$tbl .= '<tr style="font-weight:bold;">
				
				<td width="250" colspan="2" align="left">II. TUGAS TAMBAHAN DAN KREATIVITAS/UNSUR PENUNJANG:</td>
				<td width="30"  align="center"></td>
				<td width="190" align="center"></td>
				<td width="220" align="center"></td>
				<td width="75" align="center" ></td>
				<td width="50" align="center" ></td>
			</tr>';
			
			//var_dump($row_kegiatan->awal_periode_skp);exit;
			
			
			$tugas_tambahan = $this->_getTugasTambahan($id_user,$row_kegiatan->awal_periode_skp,$row_kegiatan->akhir_periode_skp);
			
			$kreatifitas = $this->_getKreatifitas($id_user,$row_kegiatan->awal_periode_skp,$row_kegiatan->akhir_periode_skp);
			
			
			$no = 1;
			$total_tugas = 	$tugas_tambahan->num_rows();
			if ($total_tugas == 0) {
				$nilai_tgs = 0;
			} else if ($total_tugas <= 3) {
				$nilai_tgs = 1;
			} else if ($total_tugas <= 6) {
				$nilai_tgs = 2;
			} else if ($total_tugas <= 7) {
			    $nilai_tgs = 3;
			}else {
				$nilai_tgs = 3;
			}
			
			if($tugas_tambahan->num_rows() > 0){
				$tbl .= '<tr style="font-weight:bold;">				
				<td width="250" colspan="2" align="left">a. Tugas Tambahan:</td>
				<td width="30"  align="center"></td>
				<td width="190" align="center"></td>
				<td width="220" align="center"></td>
				<td width="75" align="center" ></td>
				<td width="50" align="center" ></td>
			</tr>';
			
				foreach($tugas_tambahan->result() as $value)
				{
					$tbl .='<tr>
						<td width="20"  align="center">'.$no.'.</td>
						<td width="230" align="left">'. $value->tugas_tambahan.'</td>
						<td width="30"  align="center"></td>
						<td width="190" align="center"></td>
						<td width="220" align="center"></td>
						<td width="75" align="center" ></td>';
						if($no == 1){
							$tbl .='<td width="50" align="center" valign="bottom" rowspan="'.$total_tugas.'">'.$nilai_tgs.'</td></tr>';
						}else {
							$tbl .='</tr>';
						}
						
					$no++;
				}
			}
			
			$nilai_kreatifitas  = 0;
			
			if($kreatifitas->num_rows() > 0){
				$kreatif   = $kreatifitas->row();				
				$tbl .= '<tr style="font-weight:bold;">
					
					<td width="250" colspan="2" align="left">b. Kreatifitas:</td>
					<td width="30"  align="center"></td>
					<td width="190" align="center"></td>
					<td width="220" align="center"></td>
					<td width="75" align="center" ></td>
					<td width="50" align="center" ></td>
				</tr>';
			
				$no =1;
				foreach($kreatifitas->result() as $value){
				$tbl .='<tr>
						<td width="20"  align="center">'.$no.'.</td>
						<td width="230" align="left">'. $value->kreatifitas.'</td>
						<td width="30"  align="center"></td>
						<td width="190" align="center"></td>
						<td width="220" align="center"></td>
						<td width="75" align="center" ></td>';
                        if($no == 1){
							$tbl .= '<td width="50" align="center" rowspan="'.$kreatifitas->num_rows().'">'.$value->nilai_kreatifitas.'</td></tr>';
						}else {
							$tbl .='</tr>';
						}						
				    $no++;
                }	
				
				$nilai_kreatifitas  = $kreatif->nilai_kreatifitas;	
			}		
			
			$nilai_capai_skp =($total_nilai/$jumlah_kegiatan)+ $nilai_tgs;			
			$total_nilai_capaian_skp = $total_nilai_capaian_skp + $nilai_capai_skp + $nilai_kreatifitas;
			
			
			$tbl .='<tr style="font-weight:bold;font-size:10;">
				<td colspan="6"  align="center">NILAI CAPAIAN SKP</td>        
				<td width="50" align="center" >'.ROUND($total_nilai_capaian_skp,2).'</td>
			</tr>
		</table>';
		
		
		$atasan_langsung = $this->_getAtasanlangsung($id_user);
		if($atasan_langsung->num_rows() > 0 ){
			$row  = $atasan_langsung->row();
			$nama_atasan_langsung = $row->nama_atasan_langsung;
			$nip_atasan_langsung  = $row->nip_atasan_langsung;
			$lokasi_kerja		  = $row->lokasi_spesimen;			
		}else{
			$nama_atasan_langsung ="";
			$nip_atasan_langsung ="";
			$lokasi_kerja="";
		}
		

			$this->pdftc->SetFont('freesans', '', 9);
			$this->pdftc->SetXY(235, 165);
			$this->pdftc->Cell(30, 0, $lokasi_kerja.', '.$row_kegiatan->format_akhir_periode_skp, 0,0, 'C', 0, '', 0, false, 'B', 'B');
			
			$this->pdftc->SetXY(235, 169);
			$this->pdftc->Cell(30, 0, 'Pejabat Penilai,', 0,0, 'C', 0, '', 0, false, 'B', 'B');
			
			$this->pdftc->SetXY(235, 178);
			$this->pdftc->Cell(30, 0, $nama_atasan_langsung, 0,0, 'C', 0, '', 0, false, 'B', 'B');
			
			$this->pdftc->SetXY(235, 181);
			$this->pdftc->Cell(30, 0, 'NIP.'.$nip_atasan_langsung, 0,0, 'C', 0, '', 0, false, 'B', 'B');
		
			$this->pdftc->SetY(30);
			$this->pdftc->writeHTML($tbl, true, false, true, false, '');
		    $this->pdftc->Output($filename, 'I');
		
    }
	
	
	function _getAtasanlangsung($id_user)
	{
		$sql="SELECT a.atasan_langsung,c.lokasi_spesimen,
		b.nama nama_atasan_langsung, b.nip nip_atasan_langsung
		FROM dd_user a
		LEFT JOIN  dd_user b ON a.atasan_langsung = b.id_dd_user
		LEFT JOIN dd_spesimen c ON c.id_dd_spesimen = a.lok_ker
		where a.id_dd_user='$id_user'";
		$query =  $this->db->query($sql);
		return $query;
		
	}
	
	function _getKegiatanTahunan($id_user,$id_tahun)
	{
	    $sql	="SELECT c.*, 
ROUND(c.nilai_kuantitas + c.nilai_kualitas + c.nilai_waktu,2) perhitungan,
CASE
	WHEN c.target_biaya > 0 THEN ROUND((c.nilai_kuantitas + c.nilai_kualitas + c.nilai_waktu )/4,3)
    ELSE ROUND((c.nilai_kuantitas + c.nilai_kualitas + c.nilai_waktu )/3,3)
END
nilai
FROM (SELECT b.*,
CASE
    WHEN b.persen_waktu <=24 THEN ((1.76 * b.target_Waktu - b.realisasi_waktu ) / b.target_waktu) * 100
    ELSE 76 - ((((1.76 * b.target_waktu - b.realisasi_waktu) / b.target_waktu ) * 100 ) - 100 )
END
nilai_waktu,
CASE
	WHEN b.persen_biaya <= 24 THEN  ((1.76 * b.target_biaya - b.realisasi_biaya) / b.target_biaya) * 100
    ELSE 76 - ((((1.76 * b.target_biaya - b.realisasi_biaya) / b.target_biaya ) * 100 ) - 100 )
END
nilai_biaya
FROM ( SELECT a.*,
(realisasi_kuantitas/target_kuantitas) * 100 nilai_kuantitas,
(realisasi_kualitas/100) * 100 nilai_kualitas,
100 - ( (realisasi_waktu/target_waktu) * 100) persen_waktu,
100 - ( (realisasi_biaya/target_biaya) * 100) persen_biaya
FROM 
(SELECT a.id_opmt_target_skp, a.id_opmt_detail_kegiatan_jabatan, 
f.angka_kredit, a.kegiatan_tahunan,a.target_kuantitas,
b.satuan_kuantitas,a.target_waktu,a.biaya target_biaya,
CASE 
	WHEN ISNULL(sum(c.kuantitas)) THEN 0
    ELSE sum(c.kuantitas)
END
realisasi_kuantitas,
CASE 
	WHEN ISNULL(d.kualitas) THEN 0
    ELSE d.kualitas
END
realisasi_kualitas,d.waktu realisasi_waktu,d.biaya realisasi_biaya, a.id_dd_user, 
e.id_opmt_tahunan_skp, e.awal_periode_skp, e.akhir_periode_skp,
sf_formatTanggal(e.awal_periode_skp) format_awal_periode_skp,
sf_formatTanggal(e.akhir_periode_skp) format_akhir_periode_skp
FROM opmt_target_skp a
LEFT JOIN dd_kuantitas b on a.satuan_kuantitas = b.id_dd_kuantitas
LEFT JOIN opmt_realisasi_harian_skp c ON a.id_opmt_target_skp = c.id_opmt_target_skp AND c.proses=0
LEFT JOIN opmt_realisasi_skp d ON a.id_opmt_target_skp = d.id_opmt_target_skp
LEFT JOIN opmt_tahunan_skp e ON e.id_opmt_tahunan_skp = a.id_opmt_tahunan_skp
LEFT JOIN opmt_detail_kegiatan_jabatan f ON a.id_opmt_detail_kegiatan_jabatan = f.id_opmt_detail_kegiatan_jabatan
WHERE a.id_dd_user='$id_user'
GROUP BY a.id_opmt_target_skp
 ) a) b ) c WHERE c.id_opmt_tahunan_skp ='$id_tahun' ";
		$query	=$this->db->query($sql);
		return $query;
	}
	
	
	function _getTugasTambahan($id,$start,$end)
	{
		$sql="SELECT a.* FROM opmt_tugas_tambahan  a
WHERE a.id_dd_user='$id' AND date(a.tanggal) between '$start' AND '$end' ";
        $query	=$this->db->query($sql);
		return $query;
	}
	
	function _getKreatifitas($id,$start,$end)
	{
		$sql="SELECT a.*, b.* FROM opmt_kreatifitas_skp a
LEFT JOIN opmt_kreatifitas_atasan b ON a.id_dd_user = b.id_dd_user
WHERE a.id_dd_user='$id' AND date(a.tanggal) between '$start' AND '$end' ";
        $query	=$this->db->query($sql);
		return $query;
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
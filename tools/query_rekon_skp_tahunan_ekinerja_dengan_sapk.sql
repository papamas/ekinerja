SELECT d.ORANG_ID ATASANPEJABATPENILAI_ORANG_ID , c.ORANG_ID PEJABATPENILAI_ORANG_ID,b.ORANG_ID PNSDINILAI_ORANG_ID, 
a.tahun TAHUN, a.sasaran_kerja_pegawai NILAI_SKP,
a.orientasi_pelayanan ORIENTASI_PELAYANAN,
a.integritas INTEGRITAS,
a.komitmen KOMITMEN, 
a.disiplin DISIPLIN,
a.kerjasama KERJASAMA,
a.kepemimpinan KEPEMIMPINAN,
a.jabatan_atasan_penilai ATASAN_PENILAI_JABATAN,
a.jabatan_penilai PENILAI_JABATAN,
a.golongan_penilai PENILAI_GOLONGAN,
a.golongan_atasan_penilai ATASAN_PENILAI_GOLONGAN,
' ' PENILAI_TMT_GOLONGAN,' ' ATASAN_PENILAI_TMT_GOLONGAN,
a.unor_penilai PENILAI_UNOR_NAMA,
a.unor_atasan_penilai ATASAN_PENILAI_UNOR_NAMA,
a.nama_penilai PENILAI_NAMA,
a.nama_atasan_penilai ATASAN_PENILAI_NAMA,
' ' PENILAI_NIP_NRP,
' ' ATASAN_PENILAI_NIP_NRP,
'PNS' STATUS_PENILAI,
'PNS' STATUS_ATASAN_PENILAI,
a.jenis_jabatan JENIS_JABATAN
FROM (
SELECT a.*, b.nip,c.nip nip_penilai,c.nama nama_penilai, 
d.nip nip_atasan_penilai,d.nama nama_atasan_penilai, 
e.jabatan jabatan_penilai,f.jabatan jabatan_atasan_penilai,
g.Golongan golongan_penilai, h.Golongan golongan_atasan_penilai,
i.unitkerja unor_penilai,j.unitkerja unor_atasan_penilai,
CASE
    WHEN k.jenis='JFT' THEN 2
    WHEN k.jenis='JST' THEN 1
    WHEN k.jenis='JFU' THEN 4
    ELSE 3
END
jenis_jabatan
FROM ( SELECT i.id_dd_user,YEAR(i.akhir_periode_skp) tahun,i.sasaran_kerja_pegawai,
ROUND(SUM(j.orientasi_pelayanan)/count(j.id_opmt_perilaku),2) orientasi_pelayanan,
ROUND(SUM(j.integritas)/count(j.id_opmt_perilaku),2) integritas,
ROUND(SUM(j.komitmen)/count(j.id_opmt_perilaku),2) komitmen,
ROUND(SUM(j.disiplin)/count(j.disiplin),2) disiplin,
ROUND(SUM(j.kerjasama)/count(j.kerjasama),2) kerjasama,
ROUND(SUM(j.kepemimpinan)/count(j.kepemimpinan),2) kepemimpinan
FROM 
(SELECT h.*,
ROUND(SUM(h.nilai_capaian_skp)/COUNT(h.id_dd_user),2) sasaran_kerja_pegawai
FROM 
(SELECT g.* , g.jumlah_nilai_skp + g.nilai_tugas_tambahan nilai_capaian_skp
FROM (
SELECT e.* , COUNT(f.id_opmt_tugas_tambahan) jumlah_tugas_tambahan,
CASE
 WHEN (COUNT(f.id_opmt_tugas_tambahan) = 0) THEN 0
 WHEN (COUNT(f.id_opmt_tugas_tambahan) < 4) THEN 1
 WHEN (COUNT(f.id_opmt_tugas_tambahan) < 7) THEN 2
 ELSE 3
END
nilai_tugas_tambahan
FROM 
(SELECT d.*,SUM(d.nilai)/COUNT(d.nilai) jumlah_nilai_skp
FROM
(SELECT c.*, 
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
FROM ekinerja.opmt_target_skp a
LEFT JOIN ekinerja.dd_kuantitas b on a.satuan_kuantitas = b.id_dd_kuantitas
LEFT JOIN ekinerja.opmt_realisasi_harian_skp c ON a.id_opmt_target_skp = c.id_opmt_target_skp AND c.proses=0
LEFT JOIN ekinerja.opmt_realisasi_skp d ON a.id_opmt_target_skp = d.id_opmt_target_skp
INNER JOIN ekinerja.opmt_tahunan_skp e ON e.id_opmt_tahunan_skp = a.id_opmt_tahunan_skp
LEFT JOIN ekinerja.opmt_detail_kegiatan_jabatan f ON a.id_opmt_detail_kegiatan_jabatan = f.id_opmt_detail_kegiatan_jabatan
GROUP BY a.id_opmt_target_skp
 ) a) b ) c ) d
 GROUP BY d.id_opmt_tahunan_skp,d.id_dd_user ) e
LEFT JOIN ekinerja.opmt_tugas_tambahan f   ON  f.id_dd_user = e.id_dd_user
WHERE  f.id_dd_user=e.id_dd_user AND DATE(f.tanggal) BETWEEN DATE(e.awal_periode_skp) AND DATE(e.akhir_periode_skp)
GROUP BY e.id_opmt_tahunan_skp,e.id_dd_user ) g
) h GROUP BY h.id_dd_user) i
LEFT JOIN ekinerja.opmt_perilaku j ON (j.id_dd_user = i.id_dd_user AND j.tahun=YEAR(i.akhir_periode_skp))
WHERE YEAR(i.akhir_periode_skp)='2019' 
GROUP BY i.id_dd_user  ) a
LEFT JOIN dd_user b ON b.id_dd_user = a.id_dd_user
LEFT JOIN dd_user c ON c.id_dd_user = b.atasan_langsung
LEFT JOIN dd_user d ON d.id_dd_user = b.atasan_2
LEFT JOIN ekinerja.tbljabatan e ON e.kodejab = c.jabatan
LEFT JOIN ekinerja.tbljabatan f ON f.kodejab = d.jabatan
LEFT JOIN ekinerja.tblgolongan g ON g.KodeGol = c.gol_ruang
LEFT JOIN ekinerja.tblgolongan h ON h.KodeGol = d.gol_ruang
LEFT JOIN ekinerja.tblstruktural i ON i.kodeunit = c.unit_kerja
LEFT JOIN ekinerja.tblstruktural j ON j.kodeunit = d.unit_kerja
LEFT JOIN ekinerja.tbljabatan k ON k.kodejab = b.jabatan
) a
LEFT JOIN MIRROR.PUPNS b on a.nip = b.PNS_NIPBARU
LEFT JOIN MIRROR.PUPNS c on a.nip_penilai = c.PNS_NIPBARU
LEFT JOIN MIRROR.PUPNS d on a.nip_atasan_penilai = d.PNS_NIPBARU
SELECT b.*, b.NILAI_SKP+NILAI_PERILAKU NILAI_KINERJA_BULANAN  FROM 
(SELECT a.NIP,a.NAMA, a.TAHUN, a. JABATAN,
a.UNOR, a.PANGKAT,a.NILAI_SKP_RATA_RATA,(a.NILAI_SKP_RATA_RATA*60)/100 NILAI_SKP,
CASE
    WHEN a.kepemimpinan > 0 THEN ROUND((a.ORIENTASI_PELAYANAN+a.INTEGRITAS+a.KOMITMEN+a.DISIPLIN+a.KERJASAMA+a.KEPEMIMPINAN)/6,2)
    ELSE ROUND((a.ORIENTASI_PELAYANAN+a.INTEGRITAS+a.KOMITMEN+a.DISIPLIN+a.KERJASAMA+a.KEPEMIMPINAN)/5,2)
END
NILAI_RATA_RATA_PERILAKU,
CASE
    WHEN a.kepemimpinan > 0 THEN ROUND((((a.ORIENTASI_PELAYANAN+a.INTEGRITAS+a.KOMITMEN+a.DISIPLIN+a.KERJASAMA+a.KEPEMIMPINAN)/6)*40)/100,2)
    ELSE ROUND((((a.ORIENTASI_PELAYANAN+a.INTEGRITAS+a.KOMITMEN+a.DISIPLIN+a.KERJASAMA+a.KEPEMIMPINAN)/5)*60)/100,2)
END
NILAI_PERILAKU
FROM (SELECT a.nip NIP,c.nama NAMA,a.tahun TAHUN,
e.jabatan JABATAN,f.unitkerja UNOR,CONCAT(g.Golongan ,', ', g.Pangkat ) PANGKAT,
ROUND((SUM(a.nilai_skp)/count(a.nip)),2) NILAI_SKP_RATA_RATA,
ROUND(SUM(b.orientasi_pelayanan)/count(a.nip),2) ORIENTASI_PELAYANAN,
ROUND(SUM(b.integritas)/count(a.nip),2) INTEGRITAS, 
ROUND(SUM(b.komitmen)/count(a.nip),2) KOMITMEN,
ROUND(SUM(b.disiplin)/count(a.nip),2) DISIPLIN,
ROUND(SUM(b.kerjasama)/count(a.nip),2) KERJASAMA,
ROUND(SUM(b.kepemimpinan)/count(a.nip),2) KEPEMIMPINAN
FROM ekinerja.opmt_bulanan_skp a
LEFT JOIN ekinerja.opmt_perilaku b ON (a.id_dd_user=b.id_dd_user AND a.bulan = b.bulan)
LEFT JOIN ekinerja.dd_user c on a.id_dd_user = c.id_dd_user
LEFT JOIN ekinerja.dd_user d on c.atasan_langsung = d.id_dd_user
LEFT JOIN ekinerja.tbljabatan e on c.jabatan = e.kodejab
LEFT JOIN ekinerja.tblstruktural f ON c.unit_kerja = f.kodeunit
LEFT JOIN ekinerja.tblgolongan g ON g.KodeGol = c.gol_ruang
WHERE a.nilai_skp != 0 
and a.tahun='2019'
GROUP by a.nip)a ) b



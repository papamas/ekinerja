
<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    }.tengah{text-align: center !important;}#table4 thead th{text-align: center !important;vertical-align: middle;}
</style>
<h4>Bulan <?= bulan($bulan) . ' ' . $tahun ?></h4>
<div >
    <table id="table4" border="0.5" style="border:1px;">
        <thead >
            <tr style="padding:10px;border:1px;background-color:grey;color:black;font-size: 14px;font-weight:bold;">
                <th width='35' align='center'>No</th>
                <th width='85' align='center'>Bulan</th>
                <th width='75' align='center'>Tahun</th>
                <th width='150' align='center'>Nama</th>
                <th width='85' align='center'>NIP</th>
                <th width='125' align='center'>Jabatan</th>
                <th width='250' align='center'>Unit</th>
                <th width='200' align='center'>Lokasi</th>
                <th width='75' align='center'>Nilai SKP Bulanan</th>
                <th width='100' align='center'>Status</th>

            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($rekap_skp as $dt) {
                if ($dt['nilai_skp'] > 0) {
                    $status = "Disetujui";
                } elseif ($dt['nilai_skp'] == "" && $dt['id_opmt_bulanan_skp'] > 0) {
                    $status = "Belum Disetujui / Belum Approve";
                } else {
                    $status = "Belum Membuat SKP Bulanan";
                }
                ?>
                <tr>
                    <td align="center"><?= $no ?></td>
                    <td align="center"><?= bulan($bulan) ?></td>
                    <td align="center"><?= $tahun ?></td>
                    <td><?= $dt['nama'] ?></td>
                    <td><?= $dt['nip'] ?></td>
                    <td width="200"><?= $dt['jabatan'] ?></td>
                    <td width="200"><?= $dt['unitkerja'] ?></td>
                    <td width="100"><?= $dt['Lokasi'] ?></td>
                    <td align="center"><?= number_format($dt['nilai_skp'], 2) ?></td>
                    <td width="100"><?= $status ?></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </tbody>
    </table>
  
</div>



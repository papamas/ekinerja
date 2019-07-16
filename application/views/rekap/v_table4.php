
<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    }.tengah{text-align: center !important;}#table4 thead th{text-align: center !important;vertical-align: middle;}
</style>
<h4 style="text-align: center;margin-bottom: 40px;">Bulan <?= bulan($bulan) . ' ' . $tahun ?></h4>
<div style="margin-top:-30px;">
    <table id="table4" class="display table table-bordered" cellspacing="0" width="100%">
        <thead class="ui-state-default">
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Unit</th>
                <th>Lokasi</th>
                <th>Nilai SKP Bulanan</th>
                <th>Status</th>

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
                    <td><?= $dt['jabatan'] ?></td>
                    <td><?= $dt['unitkerja'] ?></td>
                    <td><?= $dt['Lokasi'] ?></td>
                    <td align="center"><?= number_format($dt['nilai_skp'], 2) ?></td>
                    <td><?= $status ?></td>
                </tr>
                <?php
                $no++;
            }
            ?>
        </tbody>
    </table>
    <div style="float:right;">
        <button class="btn ui-state-focus" onclick="cetak_rekap()">Cetak</button>
    </div>
</div>



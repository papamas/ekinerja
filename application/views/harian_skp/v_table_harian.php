<style>
    .judul th {
        text-align: center !important;
    }.tengah{text-align: center;}
</style>

<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead class="ui-state-default judul dataTables_scrollHead">
        <tr class="judul">
            <th class="ui-state-default">No</th>
            <th class="ui-state-default">Tanggal</th>
            <th class="ui-state-default">Kegiatan Harian SKP</th>
            <th class="ui-state-default">SKP Bulanan</th>
            <th class="ui-state-default">Kuantitas</th>
            <th class="ui-state-default">Status Proses</th>
            <th class="ui-state-default">Status Kesesuaian</th>
            <th class="ui-state-default">Edit</th>
            <th class="ui-state-default">Hapus</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $ttl_sesuai = 0;
        foreach ($dt_harian as $dt) {
            if ($dt['sesuai'] == 1) {
                $ttl_sesuai++;
            }
            $link_edit = '<a href="javascript:void(0)" onclick="ubah_harian(' . $dt['id_opmt_realisasi_harian_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            $link_hapus = '<a href="javascript:void(0)" onclick="hapus_harian(' . $dt['id_opmt_realisasi_harian_skp'] . ')">
<i class="fa fa-trash text-danger"/>
</a>';
            ?>
            <tr>
                <td class="tengah"><?= $no; ?></td>
                <td class="tengah"><?= date('d M Y', strtotime($dt['tanggal'])); ?></td>
                <td><?= $dt['kegiatan_harian_skp']; ?></td>
                <td><?= $dt['kegiatan_bulanan']; ?></td>
                <td><?= $dt['kuantitas'] . ' ' . $dt['satuan_kuantitas']; ?></td>
                <td style="text-align: center;font-weight: bold;"><?= $dt['proses'] == 1 ? "Proses" : ""; ?></td>
                <td style="background: <?= $dt['sesuai'] == 1 ? 'green' : '' ?>;text-align: center;font-weight: bold;"><?=
                    $dt['sesuai'] == 1 ? "Sesuai" : "";
                    ;
                    ?></td>
                <td class="tengah"><?= $link_edit; ?></td>
                <td class="tengah"><?= $link_hapus; ?></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </tbody>
    <tfoot class="ui-state-default">
        <tr>
            <td colspan="3" class="ui-state-default">Jumlah Kegiatan Harian SKP</td>
            <td  class="ui-state-default"><?= count($dt_harian) . ' Kegiatan' ?></td>
            <td colspan="3" class="ui-state-default">Jumlah Sesuai</td>
            <td colspan="2" class="ui-state-default"><?= $ttl_sesuai ?> Kegiatan</td>
        </tr>
        <tr>
            <td colspan="6" class="ui-state-default">Persentase</td>
            <td colspan="3" class="ui-state-default"><?= count($dt_harian) == 0 ? 0 : $ttl_sesuai / count($dt_harian) * 100 ?> %</td>
        </tr>
    </tfoot>
</table>
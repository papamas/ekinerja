<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_realisasi thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }
    #tbl_realisasi td{
        border:solid 1px black;
    }
</style>
<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    }
</style>
<ol class="breadcrumb bc-3" style="margin-top:-30px;">
    <li>
        <a href="javascript:void(0)">
            <i class="glyphicon glyphicon-home"></i>
            SKP
        </a>
    </li>
    <li><a href="javascript:void(0)">Tahunan Bawahan</a></li>
    <li><a href="javascript:void(0)">Realisasi </a></li>
</ol>
<div class="row" style="margin-top:-10px;">
    <div class="col-lg-12" style="text-align:center;font-weight:bold;font-size:14px;">
        <span>REALISASI SKP TAHUNAN </span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="text-align:center;font-weight:bold;font-size:14px;">
        <span>Periode <?= $dari . ' sampai ' . $sampai ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="text-align:center;font-weight:bold;font-size:14px;">
        <span>Nama Bawahan: <?= $nama ?></span>
    </div>
</div>
<table class="table" id="tbl_realisasi">
    <thead class="sorting_disabled ui-state-default">
        <tr>
            <td rowspan="2" style="vertical-align:middle;">No</td>
            <td rowspan="2" style="vertical-align:middle;">Kegiatan</td>
            <td colspan="4">Target</td>
            <td colspan="4">Realisasi</td>
            <td colspan="2">Penilaian</td>
            <!--<td rowspan="2">Input Kualitas</td></tr>-->
        <tr><td>Kuantitas</td><td>Kualitas</td><td>Waktu</td><td>Biaya</td><td>Kuantitas</td><td>Kualitas</td><td>Waktu</td><td>Biaya</td><td>Perhitungan</td><td>Nilai</td></tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $i = 0;
        $total_nilai = 0;
        foreach ($real as $real_arr) {
            $target_kuantitas = $real_arr['target_kuantitas'];
            $real_kuantitas = $real_arr['kuantitas_realisasi'];
            $target_kualitas = 100;
            $real_kualitas = $real_arr['kualitas'];
            $target_waktu = $real_arr['target_waktu'];
            $real_waktu = $real_arr['waktu_realisasi'];
            $target_biaya = $real_arr['biaya'];
            $real_biaya = $real_arr['biaya_realisasi'];
            $nilai_kuantitas = ($real_kuantitas / $target_kuantitas) * 100;
            $nilai_kualitas = ($real_kualitas / $target_kualitas) * 100;
            $persentase_waktu = 100 - ($real_waktu / $target_waktu * 100);
            if ($persentase_waktu <= 24) {
                $nilai_waktu = ((1.76 * $target_waktu - $real_waktu) / $target_waktu) * 100;
            } else {
                $nilai_waktu = 76 - ((((1.76 * $target_waktu - $real_waktu) / $target_waktu) * 100) - 100);
            }
            $persentase_biaya = $target_biaya == 0 ? 0 : 100 - ($real_biaya / $target_biaya * 100);
            if ($persentase_biaya <= 24) {
                $nilai_biaya = $target_biaya == 0 ? 0 : ((1.76 * $target_biaya - $real_biaya) / $target_biaya) * 100;
            } else {
                $nilai_biaya = $target_biaya == 0 ? 0 : 76 - ((((1.76 * $target_biaya - $real_biaya) / $target_biaya) * 100) - 100);
            }

            $perhitungan = $nilai_biaya + $nilai_waktu + $nilai_kualitas + $nilai_kuantitas;
            if ($target_biaya > 0) {
                $nilai = $perhitungan / 4;
            } else {
                $nilai = $perhitungan / 3;
            }
            ?>

            <tr style="text-align:center;">
                <td align="center"><?= $no ?></td>
                <td><?= $real_arr['kegiatan_tahunan'] ?></td>
                <td><?= $real_arr['target_kuantitas'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                <td>100</td>
                <td><?= $real_arr['target_waktu'] . ' bulan' ?></td>
                <td><?= number_format($real_arr['biaya']) ?></td>
                <td><?= $real_arr['kuantitas_realisasi'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                <td><?= number_format($real_arr['kualitas'],2) ?></td>
                <td><?= $real_arr['waktu_realisasi'] . ' bulan' ?></td>
                <td><?= number_format($real_arr['biaya_realisasi']) ?></td>
                <td><?= number_format($perhitungan) ?></td>
                <td><?= number_format($ttl_nilai[] = $nilai, 2) ?></td>
                <!--<td align="center"><a href="javascript:void(0)" onclick="input_kualitas('<?= $real_arr['id_opmt_target_skp'] ?>')"><i class="fa fa-file-o text-primary"></i></a></td>-->
            </tr>
            <?php
            $no++;
            $i++;
        }
        ?>
        <tr  class="sorting_disabled ui-state-default">
            <td colspan="11" align="center">Nilai SKP</td>
            <td style='text-align: center !important'><?= !isset($ttl_nilai) ? 0 : number_format($total_nilai = array_sum($ttl_nilai) / $i, 2) ?></td>
        </tr>
        <tr>
            <td colspan="11" align="left" style="font-weight: bold;">Tugas Tambahan</td>
            <td></td>
        </tr>
        <?php
        $ttl_tgs = count($tugas_tambahan);
        if ($ttl_tgs == 0) {
            $nilai_tgs = 0;
        } elseif ($ttl_tgs < 4) {
            $nilai_tgs = 1;
        } else if ($ttl_tgs < 7) {
            $nilai_tgs = 2;
        } else {
            $nilai_tgs = 3;
        }$i = 0;
        foreach ($tugas_tambahan as $arr2) {
            ?>
            <tr>
                <td colspan="11" align="left" ><?= $arr2['tugas_tambahan'] ?></td>
                <?php if ($i == 0) { ?>
                    <td rowspan="<?= $ttl_tgs ?>" style="vertical-align: middle;text-align: center !important;"><?= $nilai_tgs; ?></td>
    <?php } ?>

            </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td colspan="11" align="left" style="font-weight: bold;">Kreatifitas</td>
            <td></td>

        </tr>
        <?php
        $nilai_kreatif = 0;
        $ttl_kreatif = count($kreatifitas);
        $j = 0;
        if (!isset($nilai)) {
            $nilai = 0;
        }
        foreach ($kreatifitas as $arr3) {
            ?>
            <tr>
                <td colspan="11" align="left" ><?= $arr3['kreatifitas'] ?></td>
                <?php if ($j == 0) { ?>
                    <td rowspan="<?= $ttl_kreatif ?>" style="text-align: center;vertical-align: middle;"><?= isset($nilai_kreatifitas2['nilai_kreatifitas']) ? $nilai_kreatif = $nilai_kreatifitas2['nilai_kreatifitas'] : $nilai_kreatif = 0 ?></td>
                <?php
                $j++;
            }
            ?>
                <!--<td></td>-->
            </tr>
    <?php
}
?>
        <tr class="sorting_disabled ui-state-default">
            <td colspan="11" align="center">Total Nilai SKP</td>
            <td style='text-align: center !important'><?= number_format($total_nilai + $nilai_kreatif + $nilai_tgs, 2) ?></td>

        </tr>
    </tbody>
</table>
<button class="btn btn-primary pull-left fa fa-pencil" onclick="input_nilai_kreatifitas('<?= $id ?>', '<?= $id_user ?>', '<?= $tahun ?>')">Input Nilai Kreatifitas</button>

<script>
    function input_kualitas(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_atasan/tambah_kualitas' + '/' + id);
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_NORMAL);
        dialog.open();

    }

    function input_nilai_kreatifitas(id, id_user, tahun) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_atasan/tambah_kreatifitas' + '/' + id + '/' + id_user + '/' + tahun);
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_NORMAL);
        dialog.open();

    }

</script>
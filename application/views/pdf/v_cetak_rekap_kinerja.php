<h4 style="text-align: center;">TAHUN <?= $tahun ?></h4>
<?php
$par_tahun = "";
$no = 1;
$param = "";

foreach ($rekap_skp as $data) {
    ?>
    <?php if ($par_tahun !== $data['kegiatan_tahunan']) { ?>
        <h4 style="text-align: center;"><?= strtoupper($data['kegiatan_tahunan']) ?></h4>
    <?php } ?>
    <?php if ($par_tahun !== $data['kegiatan_tahunan']) {
        ?>

        <table border="0.1" padding="1" style="border:1px;" class="table table-bordered">

            <?php
	
            $no = 1;
            $par_i = 1;
            for ($i = 1; $i <= 12; $i++) {
                ?>
                <tr>
                    <td colspan="3" style="background: rgb(15,36,63);color:white;text-align:center;"><?= bulan($i) ?></td>
                </tr>
                <?= $i == 1 ? '<tr style="background:rgb(226,108,10);text-align:center;font-weight:bold;"><td width="50">No</td><td width="815">Kegiatan Bulanan</td><td width="200">Nilai Kualitas Bulanan</td></tr>' : '' ?>

                <?=
                !empty(${"bulanan_" . $i . '_' . $data['id_opmt_target_skp']}) ? implode(" ", ${"bulanan_" . $i . '_' . $data['id_opmt_target_skp']}) : "";
            }
            ?>
            <?php
            if ($i !== $par_i) {
                
//                echo "rata_" . $par_i . "_" . $data['id_opmt_target_skp'];
                $nilai = !empty(${"rata_" .  $data['id_opmt_target_skp']}) ? number_format(${"rata_" . $data['id_opmt_target_skp']}, 2) : 0;
                echo '<tr><td style="background:rgb(226,108,10);text-align:center;font-weight:bold;" colspan="2">Nilai SKP Tahunan</td><td align="right">' . $nilai . '</td></tr>';
                echo "</table>";
            }
            $par_i = $i;
            ?>
            <?php
            $no++;
            $param = $data['id_opmt_target_skp'];
        }
        ?>

        <?php
        $par_tahun = $data['kegiatan_tahunan'];
    }
    ?>
       



<div class="container">
    <style>.tengah{text-align:center;}</style>
    <h1 style="text-align: center;">SKP TAHUN <?= $tahun ?></h1>

    <table class=" table table-bordered">
        <?php
        $par_1 = "";
        foreach ($detail as $dt) {
            ?>
   <?php if ($dt['id_opmt_target_skp_atasan'] > 0 && $par_1 <> $dt['id_opmt_target_skp_atasan']) { ?>
            <thead class="ui-state-default tengah">
                <tr>
                    <td colspan="3"><?= $dt['kegiatan_tahunan'] ?></td>
                </tr>
            </thead>

         
                <tr class="ui-state-highlight tengah">
                    <td>Kegiatan SKP Bawahan</td>
                    <td>Kuantitas/Satuan Kuantitas</td>
                    <td>Nama Bawahan</td>
                </tr>
            <?php }if ($dt['id_opmt_target_skp_atasan'] > 0 ) { ?>
                <tr>
                    <td><?=$dt['kegiatan_bawahan']?></td>
                    <td><?=$dt['target_kuantitas'].' '.$dt['satuan_kuantitas']?></td>
                    <td><?=$dt['nama']?></td>
                </tr>
                <?php
            }$par_1 = $dt['id_opmt_target_skp_atasan'];
        }
        ?>
    </table>
</div>
<tr>
    <td>Klasifikasi SKP Bulanan</td>
    <td> : </td> 
    <td colspan="3">
        <select class="form-control" name="id_opmt_target_bulanan_skp">
            <?php
            $harian_skp['turunan'] == 1 ? $ket = "turunan" : "utama";
            foreach ($skp_bulanan as $arr) {
                ?>    
                <option value="<?= $arr['id'] . '-' . $arr['ket'] ?>" <?= !isset($harian_skp) ? '' : $arr['id'] . '-' . $arr['ket'] == $harian_skp['id_opmt_target_bulanan_skp'] . '-' . $ket ? 'selected' : '' ?>><?= $arr['kegiatan'] ?></option>
            <?php }
            ?>
        </select>
    </td>
</tr>
<tr>
    <td>Klasifikasi SKP Tahunan</td>
    <td> : </td> 
    <td colspan="3">
        <select class="form-control" name="id_opmt_target_skp">
            <?php
            foreach ($skp_tahunan as $arr) {
                ?>    
                <option value="<?= $arr['id_opmt_target_skp'] ?>" <?= !isset($harian_skp) ? '' : $arr['id_opmt_target_skp'] == $harian_skp['id_opmt_target_skp'] ? 'selected' : '' ?>><?= $arr['kegiatan_tahunan'] ?></option>
            <?php }
            ?>
        </select>
    </td>
</tr>

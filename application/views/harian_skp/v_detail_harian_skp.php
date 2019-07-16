<?php
if (isset($harian_skp)) {
    $id_opmt_realisasi_harian_skp = $harian_skp['id_opmt_realisasi_harian_skp'];
    $tanggal = $harian_skp['tanggal'];
    $proses = $harian_skp['proses'];
    $kegiatan_harian_skp = $harian_skp['kegiatan_harian_skp'];
    $kuantitas = $harian_skp['kuantitas'];
    $satuan_kuantitas = $harian_skp['satuan_kuantitas'];
    $id_opmt_target_skp = $harian_skp['id_opmt_target_skp'];
    $id_opmt_target_bulanan_skp = $harian_skp['id_opmt_target_bulanan_skp'];
} else {
    $id_opmt_realisasi_harian_skp = "";
    $tanggal = "";
    $proses = "";
    $kegiatan_harian_skp = "";
    $kuantitas = "";
    $satuan_kuantitas = "";
    $id_opmt_target_skp = "";
    $id_opmt_target_bulanan_skp = "";
//    $periode_awal = $periode['awal_periode_skp'];
//    $periode_akhir = $periode['akhir_periode_skp'];
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }td{vertical-align:middle !important;}
</style>

<table class="table">
    <tr>
        <td style="width:150px !important;">Tanggal</td>
        <td> : </td> 
        <td colspan="3">
            <input type="text" class="form-control tanggal" disabled name="tanggal" value="<?= $tanggal == "" ? date('Y-m-d') : $tanggal ?>" style="width: 200px;">
        </td>
    </tr>
    <tr>
        <td>Proses</td>
        <td> : </td> 
        <td colspan="3">

            <input type="checkbox" disabled name="proses" <?= $proses == 1 ? 'checked' : '' ?> class="form-control" style="width: 30px;">
        </td>
    </tr>

    <tr>
        <td>Kegiatan Harian SKP</td>
        <td> : </td> 
        <td colspan="3">
            <textarea class="form-control" disabled name="kegiatan_harian_skp"><?= $kegiatan_harian_skp ?>
            </textarea>
        </td>
    </tr>
    <tr>

        <td>Kuantitas</td>
        <td>:</td>
        <td>
            <input type="text" disabled class="form-control" name="kuantitas" style="width:50px;" value="<?= $kuantitas ?>">
        </td>

        <td>Satuan Kuantitas</td>
        <td>
            <select class="form-control isi" disabled name="satuan_kuantitas">
                <?= pilihan_list($dt_kuantitas, 'satuan_kuantitas', 'id_dd_kuantitas', $satuan_kuantitas) ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Klasifikasi SKP Bulanan</td>
        <td> : </td> 
        <td colspan="3">
            <select class="form-control" disabled name="id_opmt_target_bulanan_skp">
                <?php
                foreach ($skp_bulanan as $arr) {
                    ?>    
                    <option value="<?= $arr['id'] . '-' . $arr['ket'] ?>"></option>
                <?php }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td>Klasifikasi SKP Tahunan</td>
        <td> : </td> 
        <td colspan="3">
            <select class="form-control" disabled name="id_opmt_target_skp">
                <?php
                foreach ($skp_tahunan as $arr) {
                    ?>    
                    <option value="<?= $arr['id_opmt_target_skp'] ?>" <?= !isset($harian_skp) ? '' : $arr['id_opmt_target_skp'] == $harian_skp['id_opmt_target_skp'] ? 'selected' : '' ?>><?= $arr['kegiatan_tahunan'] ?></option>
                <?php }
                ?>
            </select>
        </td>
    </tr>

    <tr>
        <td></td>
        <td> </td>
        <td><button class="btn btn-danger" onclick="$('.close').click();" >TUTUP</button></td>
    </tr>

</table>

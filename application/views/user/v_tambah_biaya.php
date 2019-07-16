<?php
//$id_opmt_turunan_skp = $target['id_opmt_turunan_skp'];
$id_opmt_target_bulanan_skp = $target['id_opmt_target_bulanan_skp'];
$biaya = $target['biaya'];
$realisasi_biaya = $target['realisasi_biaya'];
$target_waktu = $target['target_waktu'];
$realisasi_waktu = $target['realisasi_waktu'];
$id_opmt_bulanan_skp = $id_bulanan;
if ($ket == 'utama') {
    $param = 'id_opmt_target_bulanan_skp';
} else {
    $param = 'id_opmt_turunan_skp';
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }td{vertical-align:middle;}
</style>
<form id="frm_biaya_skp" method="post">
    <table class="table">
        <tr>
            <td>Target Biaya</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" id="id_opmt_bulanan_skp" value="<?= $id_opmt_bulanan_skp ?>">
                <input type="hidden" id="ket" value="<?= $ket ?>">
                <input type="hidden" name="<?= $param ?>" value="<?= $id ?>">
                <?= $target['biaya'] ?>
            </td>
        </tr>

        <tr>
            <td>Realisasi Biaya</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control isi" name="realisasi_biaya" value="<?= $realisasi_biaya ?>"></td>
        </tr>
        <tr>
            <td>Target Waktu</td>
            <td> : </td> 
            <td>
                <?= $target_waktu ?> Hari </td>
        </tr>
        <tr>
            <td>Realisasi Waktu</td>
            <td> : </td> 
            <td>
                <div class="input-group">
                    <select name="realisasi_waktu" class="form-control isi">
                        <?php for ($i = 1; $i <= 31; $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == $realisasi_waktu ? 'selected' : '' ?>><?= $i ?></option>
                        <?php } ?>
                    </select>
                    <div class="input-group-addon">Hari</div>
                </div>
            </td>
        </tr>

        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>

    </table>
</form>

<script>

    $("#frm_biaya_skp").submit(function (e) {
        e.preventDefault();
        var id2 = $('#id_opmt_bulanan_skp').val();
        var frm_biaya_skp = $("#frm_biaya_skp");
        var form = getFormData(frm_biaya_skp);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_biaya_skp",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('c_user/realisasi_bulanan_skp' + '/' + id2);
            } else {
                alert(response.ket);
            }
        });

    });

</script>
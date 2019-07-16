<?php
if (isset($realisasi_skp)) {
    $id_opmt_realisasi_skp = isset($realisasi_skp['id_opmt_realisasi_skp'])?$realisasi_skp['id_opmt_realisasi_skp']:0;
    $biaya = isset($realisasi_skp['biaya'])?$realisasi_skp['biaya']:0;
    $waktu = isset($realisasi_skp['waktu'])?$realisasi_skp['waktu']:0;
} else {
    $id_opmt_realisasi_skp = "";
    $biaya = "";
    $waktu = "";
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }
</style>
<form id="frm_realisasi_skp" method="post">
    <table class="table">
        <tr>
            <td>Realisasi Biaya</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_opmt_target_skp" value="<?= $id ?>">
                <input type="hidden" name="id_opmt_realisasi_skp" value="<?= $id_opmt_realisasi_skp ?>">
                <input type="text" class="form-control" name="biaya" value="<?= $biaya ?>"></td>
        </tr>
        <tr>
            <td>Realisasi Waktu</td>
            <td> : </td> 
            <td>

                <input type="text" class="form-control" name="waktu" value="<?= $waktu ?>"></td>
        </tr>
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>

    $("#frm_realisasi_skp").submit(function (e) {
        e.preventDefault();
        var frm_realisasi_skp = $("#frm_realisasi_skp");
        var form = getFormData(frm_realisasi_skp);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_realisasi_skp",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('c_user/realisasi_tahunan_skp' + '/' +<?= $id_tahun ?>);
            } else {
                alert(response.ket);
            }
        });

    });

</script>
<?php
if (isset($dt_kreatifitas)) {
    $id_ompt_kreatifitas_atasan = isset($dt_kreatifitas['id_opmt_kreatifitas_atasan'])?$dt_kreatifitas['id_opmt_kreatifitas_atasan']:"";
    $id_opmt_tahunan_skp = isset($dt_kreatifitas['id_opmt_tahunan_skp'])?$dt_kreatifitas['id_opmt_tahunan_skp']:"";
    $nilai_kreatifitas = isset($dt_kreatifitas['nilai_kreatifitas'])?$dt_kreatifitas['nilai_kreatifitas']:"";
} else {
    $id_ompt_kreatifitas_atasan = "";
    $id_opmt_tahunan_skp = $id;
    $nilai_kreatifitas = "";
//    $periode_awal = $periode['awal_periode_skp'];
//    $periode_akhir = $periode['akhir_periode_skp'];
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }td{vertical-align:middle;}
</style>

<form id="frm_kreatifitas" method="post">
    <table class="table">
        <tr>
            <td>Nilai Kreatifitas</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" name="id_opmt_kreatifitas_atasan" value="<?=$id_ompt_kreatifitas_atasan?>">
                <input type="hidden" name="id_dd_user" value="<?=$id_user?>">
                <input type="hidden" name="tahun" value="<?=$tahun?>">
                <input type="hidden" name="id_opmt_tahunan_skp" value="<?= $id_opmt_tahunan_skp ?>">
                <input type="text" class="form-control" name="nilai_kreatifitas" value="<?= $nilai_kreatifitas ?>">
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
    $("#frm_kreatifitas").submit(function (e) {
        e.preventDefault();
        var frm_kreatifitas = $("#frm_kreatifitas");
        var form = getFormData(frm_kreatifitas);
        $.ajax({
            type: "POST",
            url: "c_atasan/aksi_kreatifitas",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
				realisasi_bawahan(<?=$id?>);
            } else {
                alert(response.ket);
            }
        });

    });
    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
</script>
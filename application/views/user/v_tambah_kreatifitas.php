<?php
if (isset($dt_kreatifitas)) {
    $id_opmt_kreatifitas_skp = $dt_kreatifitas['id_opmt_kreatifitas_skp'];
    $tanggal = $dt_kreatifitas['tanggal'];
    $kreatifitas = $dt_kreatifitas['kreatifitas'];
    $target_kuantitas = $dt_kreatifitas['target_kuantitas'];
    $satuan_kuantitas = $dt_kreatifitas['satuan_kuantitas'];
} else {
    $id_opmt_kreatifitas_skp = "";
    $tanggal = "";
    $kreatifitas = "";
    $target_kuantitas = "";
    $satuan_kuantitas = "";
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
<div style="text-align: center;font-weight: bold;">Kreatifitas</div>
<form id="frm_kreatifitas_tambahan" method="post">
    <table class="table">
        <tr>
            <td style="width:150px !important;">Tanggal</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" name="id_opmt_kreatifitas_skp" value="<?= $id_opmt_kreatifitas_skp ?>">
                <input type="text" class="form-control tanggal" name="tanggal" value="<?= $tanggal == "" ? date('Y-m-d') : $tanggal ?>" style="width: 200px;">
            </td>
        </tr>
        <tr>
            <td>Kreatifitas</td>
            <td> : </td> 
            <td colspan="3">
                <textarea class="form-control" name="kreatifitas"><?= $kreatifitas ?>
                </textarea>
            </td>
        </tr>
        <tr>

            <td>Kuantitas</td>
            <td>:</td>
            <td>
                <input type="text" class="form-control" name="target_kuantitas" style="width:50px;" value="<?= $target_kuantitas ?>">
            </td>

            <td>Satuan Kuantitas</td>
            <td>
                <select class="form-control isi" name="satuan_kuantitas">
                    <?= pilihan_list($dt_kuantitas, 'satuan_kuantitas', 'id_dd_kuantitas', $satuan_kuantitas) ?>
                </select>
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

    $("#frm_kreatifitas_tambahan").submit(function (e) {
        e.preventDefault();
        var frm_kreatifitas_tambahan = $("#frm_kreatifitas_tambahan");
        var form = getFormData(frm_kreatifitas_tambahan);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_kreatifitas",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_kreatifitas();
            } else {
                alert(response.ket);
            }
        });

    });
    $('.tanggal').datepicker({
       dateFormat: 'yy-mm-dd',
        autoclose: true
    });
</script>
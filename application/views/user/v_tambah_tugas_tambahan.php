<?php
if (isset($tugas)) {
    $id_opmt_tugas_tambahan = $tugas['id_opmt_tugas_tambahan'];
    $tanggal = $tugas['tanggal'];
    $tugas_tambahan = $tugas['tugas_tambahan'];
    $target_kuantitas = $tugas['target_kuantitas'];
    $satuan_kuantitas = $tugas['satuan_kuantitas'];
} else {
    $id_opmt_tugas_tambahan = "";
    $tanggal = "";
    $tugas_tambahan = "";
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
<div style="text-align: center;font-weight: bold;">Tugas Tambahan</div>
<form id="frm_tugas_tambahan" method="post">
    <table class="table">
        <tr>
            <td style="width:150px !important;">Tanggal</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" name="id_opmt_tugas_tambahan" value="<?= $id_opmt_tugas_tambahan ?>">
                <input type="text" class="form-control tanggal" name="tanggal" value="<?= $tanggal == "" ? date('Y-m-d') : $tanggal ?>" style="width: 200px;">
            </td>
        </tr>
        <tr>
            <td>Tugas Tambahan</td>
            <td> : </td> 
            <td colspan="3">
                <textarea class="form-control" name="tugas_tambahan"><?= $tugas_tambahan ?></textarea>
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

    $("#frm_tugas_tambahan").submit(function (e) {
        e.preventDefault();
        var frm_tugas_tambahan = $("#frm_tugas_tambahan");
        var form = getFormData(frm_tugas_tambahan);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_tugas_tambahan",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_tugas_tambahan();
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
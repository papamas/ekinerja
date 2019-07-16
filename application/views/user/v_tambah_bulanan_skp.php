<?php
if (isset($bulanan_skp)) {
    $id_opmt_bulanan_skp = $bulanan_skp['id_opmt_bulanan_skp'];
    $tahun = $bulanan_skp['tahun'];
    $bulan = $bulanan_skp['bulan'];
} else {
    $id_opmt_bulanan_skp = "";
    $bulan = "";
    $tahun = "";
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }
</style>
<form id="frm_bulanan_skp" method="post">
    <table class="table">
        <tr>
            <td>Tahun</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_opmt_bulanan_skp">
                <select class="form-control" name="tahun" <?= $cek_akses['parameter_bulan'] == 1 ? 'disabled' : '' ?>>
                    <?php for ($i = date('Y') - 3; $i <= date('Y'); $i++) {
                        ?>
                        <option value="<?= $i ?>" <?= $i == (int) date('Y') ? 'selected' : '' ?>><?= $i ?></option>
                    <?php } ?>
                </select></td>
        </tr>
        <tr>
            <td>Bulan</td>
            <td> : </td> 
            <td>
                <select class="form-control" name="bulan" <?= $cek_akses['parameter_bulan'] == 1 ? 'disabled' : '' ?>>
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value="<?= $i ?>" <?= $i == (int) date('m') ? 'selected' : '' ?>><?= $i ?></option>
                    <?php } ?>
                </select>
            </td>
        </tr>
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button>
            </td>
        </tr>
    </table>
</form>
<script>

    $("#frm_bulanan_skp").submit(function (e) {
         $(this).find(':input').prop('disabled', false);
        e.preventDefault();
        var frm_bulanan_skp = $("#frm_bulanan_skp");
        var form = getFormData(frm_bulanan_skp);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_bulanan_skp",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refreshBulanan();
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
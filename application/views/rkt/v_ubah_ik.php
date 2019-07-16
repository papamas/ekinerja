<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmRKT" method="post">
    <table class="table">
        <tr>
            <td style="width: 180px;">Indikator Kinerja <?= $flag == 1 ? "Utama" : "Kegiatan" ?></td>
            <td>
                <input type="hidden" name="id_opmt_ik" value="<?= $id ?>">
                <input type="hidden" name="flag_utama" id="flag_utama" value="<?= $flag ?>">
                <textarea class="form-control" name="indikator_kinerja"><?=$indikator['indikator_kinerja']?></textarea>
            </td>
        </tr>
        <tr>
            <td>Target</td>
            <td><input type="text" class="form-control" name="target" value="<?=$indikator['target']?>"></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>

    $("#frmRKT").submit(function (e) {
        e.preventDefault();
        var frmRKT = $("#frmRKT");
        var flag = $('#flag_utama').val();
        var form = getFormData(frmRKT);
        $.ajax({
            type: "POST",
            url: "admin/c_rkt/aksi_ubah_ik",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                if (flag == 1) {
                    refresh_iku();
                } else {
                    refresh_ikk();
                }
//                menu('admin/c_rkt');
            } else {
                alert(response.ket);
            }
        });

    });

</script>
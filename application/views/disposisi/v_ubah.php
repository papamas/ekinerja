<style>
    form td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmDisposisi" method="post">
    <table class="table">
        <?php foreach ($dt_disposisi as $dt) { ?>
            <input type="hidden" name="id_opmt_disposisi" value="<?= $dt['id_opmt_disposisi'] ?>">
            <tr>
                <td>Nama Bawahan</td>
                <td>
                    <select class="form-control" name="id_dd_user">
                        <?= pilihan_list($dt_user, 'nama', 'id_dd_user', $dt['id_dd_user']) ?>
                    </select></td>
            </tr>
            <tr>
                <td>Tanggal</td>
                <td><input type="text" class="form-control tanggal" name="tanggal_disposisi" value="<?= $dt['tanggal_disposisi'] ?>"></td>
            </tr>
            <tr>
                <td>Kegiatan</td>
                <td colspan="4">
                    <textarea class="form-control" name="kegiatan"><?= $dt['kegiatan'] ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Waktu Pengerjaan</td>
                <td>
                    <input type="text" class="form-control" name="waktu_pengerjaan" value="<?= $dt['waktu_pengerjaan'] ?>">
                </td>
                <td>Hari</td>

            </tr>
            <tr>
                <td></td>
                <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
            </tr>
        <?php } ?>
    </table>
</form>

<script>
    $('.tanggal').datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose: true
    });
    $('.waktu').timepicker({
        minuteStep: 1,
        template: 'modal',
        appendWidgetTo: 'body',
        showSeconds: false,
        showMeridian: false,
        defaultTime: false
    });

    $("#frmDisposisi").submit(function (e) {
        e.preventDefault();
        var id2 = $('#id_opmt_bulanan_skp').val();
        var frmDisposisi = $("#frmDisposisi");
        var form = getFormData(frmDisposisi);
        $.ajax({
            type: "POST",
            url: "c_disposisi/aksi_ubah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('c_disposisi');
            } else {
                alert(response.ket);
            }
        });

    });
</script>
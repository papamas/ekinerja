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
                <td>Tanggal Disposisi</td>
                <td><?= date('d M Y',strtotime($dt['tanggal_disposisi'])) ?></td>
            </tr>
            <tr>
                <td>Kegiatan</td>
                <td colspan="4">
                    <?= $dt['kegiatan'] ?>
                </td>
            </tr>
            <tr>
                <td>Waktu Pengerjaan</td>
                <td>
                    <?= $dt['waktu_pengerjaan'] ?>
                    Hari</td>
            </tr>
            <tr>
                <td>Status Pekerjaan</td>
                <td>
                    <select class="form-control" name="status_disposisi_bawahan">
                        <option value="1" <?= $dt['status_disposisi_bawahan'] == 1 ? 'selected' : '' ?>>Selesai Dilaksanakan</option>
                        <option value="0" <?= $dt['status_disposisi_bawahan'] == 0 ? 'selected' : '' ?>>Dalam Pengerjaan</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
            </tr>
        <?php } ?>
    </table>
</form>

<script>
    $("#frmDisposisi").submit(function (e) {
        e.preventDefault();
        var id2 = $('#id_opmt_bulanan_skp').val();
        var frmDisposisi = $("#frmDisposisi");
        var form = getFormData(frmDisposisi);
        $.ajax({
            type: "POST",
            url: "c_disposisi/aksi_ubah_status",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('c_disposisi/bawahan');
            } else {
                alert(response.ket);
            }
        });

    });
</script>
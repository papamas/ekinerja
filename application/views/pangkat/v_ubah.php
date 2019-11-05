<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmJabatan" method="post">
    <table class="table">
        <?php foreach ($dt_pangkat as $dt) { ?>

            <tr>
                <td>Golongan</td>
                <td>
                    <input type="hidden" class="form-control " name="id_dd_ruang_pangkat" value="<?= $dt['id_dd_ruang_pangkat'] ?>">
                    <input type="text" class="form-control " name="golongan_ruang" value="<?= $dt['golongan_ruang'] ?>">
                </td>
            </tr>
            <tr>
                <td>Pangkat</td>
                <td><input type="text" class="form-control " name="pangkat" value="<?= $dt['pangkat'] ?>"></td>
            </tr>

            <tr>
                <td></td>
                <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
            </tr>
        <?php } ?>
    </table>
</form>

<script>

    $("#frmJabatan").submit(function (e) {
        e.preventDefault();
        var frmJabatan = $("#frmJabatan");
        var form = getFormData(frmJabatan);
        $.ajax({
            type: "POST",
            url: "admin/c_pangkat/aksi_ubah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('admin/c_pangkat');
            } else {
                alert(response.ket);
            }
        });

    });
</script>
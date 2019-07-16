<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmKuantitas" method="post">
    <table class="table">
        <?php foreach ($dt_kuantitas as $dt) { ?>
            <input type="hidden" value="<?= $dt['id_dd_kuantitas'] ?>" name="id_dd_kuantitas">
            <tr>
                <td>Kuantitas</td>
                <td><input type="text" class="form-control " name="satuan_kuantitas" value="<?= $dt['satuan_kuantitas'] ?>"></td>
            </tr>

            <tr>
                <td></td>
                <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
            </tr>
        <?php } ?>
    </table>
</form>

<script>

    $("#frmKuantitas").submit(function (e) {
        e.preventDefault();
        var frmKuantitas = $("#frmKuantitas");
        var form = getFormData(frmKuantitas);
        $.ajax({
            type: "POST",
            url: "admin/c_kuantitas/aksi_ubah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('admin/c_kuantitas');
            } else {
                alert(response.ket);
            }
        });

    });
</script>
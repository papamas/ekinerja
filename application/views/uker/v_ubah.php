<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmJabatan" method="post">
    <table class="table">
        <?php foreach ($dt_uker as $dt) { ?>
            <input type="hidden" value="<?= $dt['kodeunit'] ?>" name="kodeunit">
            <tr>
                <td>Kode Unit</td>
                <td><input type="text" class="form-control " name="kodeunit" value="<?= $dt['kodeunit'] ?>"></td>
            </tr>
            <tr>
                <td>Unit Kerja</td>
                <td><input type="text" class="form-control " name="unitkerja" value="<?= $dt['unitkerja'] ?>"></td>
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
            url: "admin/c_uker/aksi_ubah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('admin/c_uker');
            } else {
                alert(response.ket);
            }
        });

    });
</script>
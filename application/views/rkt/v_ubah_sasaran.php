<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmRKT" method="post">
    <table class="table">
        <tr>
            <td style="width: 150px;">Sasaran Strategis</td>
            <td>
                <input type="hidden" name="id_opmt_sasaran_strategis" value="<?= $sasaran['id_opmt_sasaran_strategis'] ?>">
                <textarea class="form-control" name="sasaran_strategis"><?= $sasaran['sasaran_strategis'] ?></textarea>

            </td>
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
        var form = getFormData(frmRKT);
        $.ajax({
            type: "POST",
            url: "admin/c_rkt/aksi_ubah_sasaran",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_sasaran();
//                menu('admin/c_rkt');
            } else {
                alert(response.ket);
            }
        });

    });

</script>
          
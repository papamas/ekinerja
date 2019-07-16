<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmKuantitas" method="post">
    <table class="table">

        <tr>
            <td>Kuantitas</td>
            <td><input type="text" class="form-control " name="satuan_kuantitas"></td>
        </tr>

        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>

    $("#frmKuantitas").submit(function (e) {
        e.preventDefault();
        var frmKuantitas = $("#frmKuantitas");
        var form = getFormData(frmKuantitas);
        $.ajax({
            type: "POST",
            url: "admin/c_kuantitas/aksi_tambah",
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
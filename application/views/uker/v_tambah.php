<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmUnit" method="post">
    <table class="table">
        <tr>
            <td>Kode Unit</td>
            <td><input type="text" class="form-control " name="kodeunit"></td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td><input type="text" class="form-control " name="unitkerja"></td>
        </tr>

        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>

    $("#frmUnit").submit(function (e) {
        e.preventDefault();
        var frmUnit = $("#frmUnit");
        var form = getFormData(frmUnit);
        $.ajax({
            type: "POST",
            url: "admin/c_uker/aksi_tambah",
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
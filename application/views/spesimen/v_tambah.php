<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmSpesimen" method="post">
    <table class="table">
        <tr>
            <td>Lokasi Spesimen</td>
            <td><input type="text" class="form-control " name="lokasi_spesimen"></td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>

    $("#frmSpesimen").submit(function (e) {
        e.preventDefault();
        var frmSpesimen = $("#frmSpesimen");
        var form = getFormData(frmSpesimen);
        $.ajax({
            type: "POST",
            url: "admin/c_spesimen/aksi_tambah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('admin/c_spesimen');
            } else {
                alert(response.ket);
            }
        });

    });

</script>
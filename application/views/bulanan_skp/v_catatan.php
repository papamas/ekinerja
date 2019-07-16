<style>
   #frmCatatan td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmCatatan" method="post">
    <table class="table">
        <tr>
            <td>Catatan</td>
            <td>
                <input type="hidden" name="id_opmt_bulanan_skp" value="<?=$id?>">
                <textarea class="form-control" name="catatan"><?=$catatan['catatan']?></textarea>
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>

    $("#frmCatatan").submit(function (e) {
        e.preventDefault();
        var frmCatatan = $("#frmCatatan");
        var form = getFormData(frmCatatan);
        $.ajax({
            type: "POST",
            url: "c_bulanan_skp/aksi_ubah_catatan",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                cariSKP();
            } else {
                alert(response.ket);
            }
        });

    });

</script>
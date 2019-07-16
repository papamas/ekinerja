<style>
   #frmkegiatan td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmkegiatan" method="post">
    <table class="table">
        <tr>
            <td>Butir Kegiatan Jabatan</td>
            <td>
                <input type="hidden" name="id_opmt_kegiatan_jabatan" value="<?=$id?>">
                <textarea class="form-control" name="kegiatan_jabatan"></textarea>
            </td>
        </tr>
        <tr>
            <td>Satuan Hasil</td>
            <td>
                <input type="text" class="form-control " name="satuan_hasil" >
            </td>
        </tr>
        <tr>
            <td>Angka Kredit</td>
            <td>
                <input type="text" class="form-control " name="angka_kredit" >
            </td>
        </tr>
        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>

    $("#frmkegiatan").submit(function (e) {
        e.preventDefault();
        var frmkegiatan = $("#frmkegiatan");
        var form = getFormData(frmkegiatan);
        $.ajax({
            type: "POST",
            url: "admin/c_kegiatan_jabatan/aksi_tambah_detail",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_kegiatan();
            } else {
                alert(response.ket);
            }
        });

    });
    
</script>
<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmRKT" method="post">
    <table class="table">
        <tr>
            <td>Tahun</td>
            <td><input type="text" class="form-control " name="tahun" style="width:100px;"></td>
        </tr>
        <tr>
            <td style="width: 150px;">Nama Unit</td>
            <td>
                <select class="form-control" name="kodeunit">
                    <?= pilihan_list($unit, 'unitkerja', 'kodeunit', $default = '') ?>
                    <option value=""></option>
                </select>    
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
            url: "admin/c_rkt/aksi_tambah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_kegiatan_rkt();
//                menu('admin/c_rkt');
            } else {
                alert(response.ket);
            }
        });

    });

</script>
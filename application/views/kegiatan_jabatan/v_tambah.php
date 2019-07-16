<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmSpesimen" method="post">
    <table class="table">
        <tr>
            <td>Nama Jabatan</td>
            <td>
                <select class="form-control ui-state-default" style="font-size:12px;" id="jabatan">
                    <?= pilihan_list($jabatan, 'jabatan', 'kodejab', '') ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Kode Jabatan</td>
            <td>
                <input type="text" class="form-control " name="kodejab" id="kodejab" readonly>
            </td>
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
            url: "admin/c_kegiatan_jabatan/aksi_tambah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
               refresh_kegiatan_jabatan();
            } else {
                alert(response.ket);
            }
        });

    });
    $('#jabatan').on('click', function () {
        $('#kodejab').val($(this).val());
    });
</script>
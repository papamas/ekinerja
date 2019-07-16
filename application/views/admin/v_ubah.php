<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmAdmin" method="post">
    <table class="table">
        <?php foreach ($dt_admin as $dt) { ?>
            <input type="hidden" name="id_dd_user" value="<?= $dt['id_dd_user'] ?>">
         
            <tr>
                <td>Username</td>
                <td><input type="text" class="form-control " name="username" value="<?= $dt['username'] ?>"></td>
            </tr>
            <tr>
                <td>Password</td>
                <td><input type="password" class="form-control " name="password" value="<?= base64_decode($dt['password']) ?>"></td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
            </tr>
        <?php } ?>
    </table>
</form>

<script>

    $("#frmAdmin").submit(function (e) {
        e.preventDefault();
        var frmAdmin = $("#frmAdmin");
        var form = getFormData(frmAdmin);
        $.ajax({
            type: "POST",
            url: "admin/c_admin/aksi_ubah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('admin/c_user');
            } else {
                alert(response.ket);
            }
        });

    });
</script>
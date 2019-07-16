<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmUser" method="post">
    <table class="table">
        <tr>
            <td>Username</td>
            <td><input type="text" class="form-control " name="username"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="password" class="form-control " name="password"></td>
        </tr>


        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>

    $("#frmUser").submit(function (e) {
        e.preventDefault();
        var frmUser = $("#frmUser");
        var form = getFormData(frmUser);
        $.ajax({
            type: "POST",
            url: "admin/c_admin/aksi_tambah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('admin/c_admin');
            } else {
                alert(response.ket);
            }
        });

    });

</script>
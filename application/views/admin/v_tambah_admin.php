<?php
if (isset($user)) {
    $id_dd_user = $user['id_dd_user'];
    $username = $user['username'];
    $password = base64_decode($user['password']);
} else {
    $id_dd_user = "";
    $username = "";
    $password = "";
}
?>

<form id="frm_user" method="post">
    <table class="table">
        <tr>
            <td>Username Admin</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_dd_user" value="<?= $id_dd_user ?>">
                <input type="text" class="form-control" name="username" value="<?= $username ?>"></td>
        </tr>
        <tr>
            <td>Password Admin</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="jabatan" value="0">
                <input type="text" class="form-control" name="password" value="<?= $password ?>"></td>
        </tr>

        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>

    $("#frm_user").submit(function (e) {
        e.preventDefault();
        var frm_user = $("#frm_user");
        var form = getFormData(frm_user);
        $.ajax({
            type: "POST",
            url: "c_admin/aksi_admin",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_admin();
            } else {
                alert(response.ket);
            }
        });

    });

</script>
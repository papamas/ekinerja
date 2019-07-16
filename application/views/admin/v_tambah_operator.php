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
            <td>Username Operator</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_dd_user" value="<?= $id_dd_user ?>">
                <input type="text" class="form-control" name="username" value="<?= $username ?>"></td>
        </tr>
        <tr>
            <td>Password Operator</td>
            <td> : </td> 
            <td>
            
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
            url: "c_admin/aksi_operator",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('c_admin/operator');
            } else {
                alert(response.ket);
            }
        });

    });

</script>
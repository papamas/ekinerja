<?php
if (isset($user)) {
    $id_dd_user = $user['id_dd_user'];
    $nip = $user['nip'];
    $nama = $user['nama'];
    $username = $user['username'];
    $password = base64_decode($user['password']);
    $jabatan_data = $user['jabatan'];
    $uker_data = $user['unit_kerja'];
} else {
    $id_dd_user = "";
    $nip = "";
    $nama = "";
    $username = "";
    $password = "";
    $jabatan_data = "";
    $uker_data = "";
}
?>

<form id="frm_user" method="post">
    <table class="table">
        <tr>
            <td>NIP</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_dd_user" value="<?= $id_dd_user ?>">
                <input type="text" class="form-control" name="nip" value="<?= $nip ?>"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" name="nama" value="<?= $nama ?>"></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td> : </td> 
            <td>
                <select class="form-control" name="jabatan">
                    <?= pilihan_list($jabatan, 'nama_jabatan', 'id_dd_jabatan', $jabatan_data) ?>
                </select>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td> : </td> 
            <td>
                <select class="form-control" name="unit_kerja">
                    <?= pilihan_list($uker, 'nama_uker', 'id_dd_uker', $uker_data) ?>
                </select>
        </tr>
        <tr>
            <td>Gol. Ruang/Pangkat</td>
            <td> : </td> 
            <td>
                <select class="form-control" name="gol_ruang">
                    <?php
                    foreach ($pangkat as $dt_pangkat) {
                        echo'<option value="' . $dt_pangkat["id_dd_ruang_pangkat"] . '">' . $dt_pangkat["golongan_ruang"] . '/' . $dt_pangkat["pangkat"] . '</option>';
                    }
                    ?>

                </select>
        </tr>
        <tr>
            <td>Username</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" name="username" value="<?= $username ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" name="password" value="<?= $password ?>">
            </td>
        </tr>

        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" id="btn_simpan" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>
<?php if ($jenis == "detail") { ?>
        $('.form-control').attr('disabled', true);
        $('#btn_simpan').css('display', 'none');
<?php } ?>
    $("#frm_user").submit(function (e) {
        e.preventDefault();
        var frm_user = $("#frm_user");
        var form = getFormData(frm_user);
        $.ajax({
            type: "POST",
            url: "c_admin/aksi_user",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_user();
            } else {
                alert(response.ket);
            }
        });

    });

</script>
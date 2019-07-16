<?php
if (isset($pangkat)) {
    $id_dd_ruang_pangkat = $pangkat['id_dd_ruang_pangkat'];
    $golongan_ruang = $pangkat['golongan_ruang'];
    $pangkat = $pangkat['pangkat'];
} else {
    $id_dd_ruang_pangkat = "";
    $golongan_ruang = "";
    $pangkat = "";
}
?>

<form id="frm_pangkat" method="post">
    <table class="table">
        <tr>
            <td>Golongan Ruang</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_dd_ruang_pangkat" value="<?= $id_dd_ruang_pangkat ?>">
                <input type="text" class="form-control" name="golongan_ruang" value="<?= $golongan_ruang ?>"></td>
        </tr>
        <tr>
            <td>Pangkat</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" name="pangkat" value="<?= $pangkat ?>"></td>
        </tr>

        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>

    $("#frm_pangkat").submit(function (e) {
        e.preventDefault();
        var frm_pangkat = $("#frm_pangkat");
        var form = getFormData(frm_pangkat);
        $.ajax({
            type: "POST",
            url: "c_admin/aksi_pangkat",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_pangkat();
            } else {
                alert(response.ket);
            }
        });

    });
   
</script>
<?php
if (isset($jabatan)) {
    $id_dd_jabatan = $jabatan['id_dd_jabatan'];
    $nama_jabatan = $jabatan['nama_jabatan'];
    $tunjangan = $jabatan['tunjangan'];
} else {
    $id_dd_jabatan = "";
    $nama_jabatan = "";
    $tunjangan = "";
}
?>

<form id="frm_jabatan" method="post">
    <table class="table">
        <tr>
            <td>Jabatan</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_dd_jabatan" value="<?=$id_dd_jabatan?>">
                <input type="text" class="form-control" name="nama_jabatan" value="<?=$nama_jabatan?>"></td>
        </tr>
        <tr>
            <td>Nominal Tunjangan</td>
            <td> : </td>
            <td><input type="text" class="form-control angka" name="tunjangan" value="<?=number_format($tunjangan)?>"></td>
        </tr>
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>

    $("#frm_jabatan").submit(function (e) {
        e.preventDefault();
        var frm_jabatan = $("#frm_jabatan");
        var form = getFormData(frm_jabatan);
        $.ajax({
            type: "POST",
            url: "c_admin/aksi_jabatan",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_jabatan();
            } else {
                alert(response.ket);
            }
        });

    });
    $('.angka').on('change', function () {
        $(this).val(numeral($(this).val()).format('0,0.00'));
    });
</script>
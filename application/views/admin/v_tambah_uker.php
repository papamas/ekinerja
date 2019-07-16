<?php
if (isset($uker)) {
    $id_dd_uker = $uker['id_dd_uker'];
    $nama_uker = $uker['nama_uker'];

} else {
    $id_dd_uker = "";
    $nama_uker = "";

}
?>

<form id="frm_uker" method="post">
    <table class="table">
        <tr>
            <td>Unit Kerja</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_dd_uker" value="<?=$id_dd_uker?>">
                <input type="text" class="form-control" name="nama_uker" value="<?=$nama_uker?>"></td>
        </tr>
        
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>

    $("#frm_uker").submit(function (e) {
        e.preventDefault();
        var frm_uker = $("#frm_uker");
        var form = getFormData(frm_uker);
        $.ajax({
            type: "POST",
            url: "c_admin/aksi_uker",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_uker();
            } else {
                alert(response.ket);
            }
        });

    });
    $('.angka').on('change', function () {
        $(this).val(numeral($(this).val()).format('0,0.00'));
    });
</script>
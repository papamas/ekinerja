<?php
if (isset($kuantitas)) {
    $id_dd_kuantitas = $kuantitas['id_dd_kuantitas'];
    $satuan_kuantitas = $kuantitas['satuan_kuantitas'];

} else {
    $id_dd_kuantitas = "";
    $satuan_kuantitas = "";

}
?>

<form id="frm_kuantitas" method="post">
    <table class="table">
        <tr>
            <td>Satuan Kuantitas</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_dd_kuantitas" value="<?=$id_dd_kuantitas?>">
                <input type="text" class="form-control" name="satuan_kuantitas" value="<?=$satuan_kuantitas?>"></td>
        </tr>
        
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>

    $("#frm_kuantitas").submit(function (e) {
        e.preventDefault();
        var frm_kuantitas = $("#frm_kuantitas");
        var form = getFormData(frm_kuantitas);
        $.ajax({
            type: "POST",
            url: "c_admin/aksi_kuantitas",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_kuantitas();
            } else {
                alert(response.ket);
            }
        });

    });

</script>
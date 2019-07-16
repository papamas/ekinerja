<?php
if (isset($tahunan_skp)) {
    $id_opmt_tahunan_skp = $tahunan_skp['id_opmt_tahunan_skp'];
    $awal_periode_skp = $tahunan_skp['awal_periode_skp'];
    $akhir_periode_skp = $tahunan_skp['akhir_periode_skp'];
} else {
    $id_opmt_tahunan_skp = "";
    $awal_periode_skp = "";
    $akhir_periode_skp = "";
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }
</style>
<form id="frm_tahunan_skp" method="post">
    <table class="table">
        <tr>
            <td>Dari Tanggal/Bulan/Tahun</td>
            <td> : </td> 
            <td>
                
				<input type="hidden" name="id_dd_user" value="<?= $this->session->userdata('id_user') ?>">
                <input type="hidden" name="id_opmt_tahunan_skp" value="<?= $id_opmt_tahunan_skp ?>">
                <input type="text" class="form-control tanggal" name="awal_periode_skp" value="<?= $awal_periode_skp ?>"></td>
        </tr>
        <tr>
            <td>Sampai Tanggal/Bulan/Tahun</td>
            <td> : </td> 
            <td>

                <input type="text" class="form-control tanggal" name="akhir_periode_skp" value="<?= $akhir_periode_skp ?>"></td>
        </tr>
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>

    $("#frm_tahunan_skp").submit(function (e) {
        e.preventDefault();
        var frm_tahunan_skp = $("#frm_tahunan_skp");
        var form = getFormData(frm_tahunan_skp);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_tahunan_skp",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                cariSKP();
            } else {
                alert(response.ket);
            }
        });

    });
    var date = '<?= date('Y-m-d') ?>';
    $('.tanggal').datepicker({
<?php if ($cek_akses['parameter_bulan'] == 1) { ?>
            minDate: date,
    <?php
}
?>
        dateFormat: 'yy-mm-dd',
        autoclose: true
    });
</script>
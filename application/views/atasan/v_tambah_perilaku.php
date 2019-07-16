<?php
if (isset($dt_perilaku)&&count($dt_perilaku)>0) {
    $id_opmt_perilaku = $dt_perilaku['id_opmt_perilaku'];
    $tahun = $dt_perilaku['tahun'];
    $bulan = $dt_perilaku['bulan'];
    $orientasi_pelayanan = $dt_perilaku['orientasi_pelayanan'];
    $integritas = $dt_perilaku['integritas'];
    $komitmen = $dt_perilaku['komitmen'];
    $disiplin = $dt_perilaku['disiplin'];
    $kerjasama = $dt_perilaku['kerjasama'];
    $kepemimpinan = $dt_perilaku['kepemimpinan'];
	
} else {
    $id_opmt_perilaku ="";
    $tahun = $xtahun;
    $bulan = $xbulan;
    $orientasi_pelayanan = "";
    $integritas = "";
    $komitmen = "";
    $disiplin = "";
    $kerjasama ="";
    $kepemimpinan = "";
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }td{vertical-align:middle;}
</style>
<div style="text-align:center;font-weight:bold;"><?=$user['nama']?></div>
<div style="text-align:center;font-weight:bold;"><?="Bulan ".date('F',strtotime($tahun.'-'.$xbulan.'-01')).' Tahun '.$tahun?></div>

<form id="frm_perilaku" method="post">
    <table class="table">

        <tr>
            <td>Orientasi Pelayanan</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" name="id_opmt_perilaku" value="<?=$id_opmt_perilaku?>">
				<input type="hidden" name="tahun" value="<?=$tahun?>">
				<input type="hidden" name="bulan" value="<?=$bulan?>">
				<input type="hidden" name="id_dd_user" value="<?=$id_user?>">
                <input type="text" class="form-control" name="orientasi_pelayanan" value="<?= $orientasi_pelayanan ?>">
            </td>
        </tr>
        <tr>
            <td>Integritas</td>
            <td> : </td> 
            <td colspan="3">
              
                <input type="text" class="form-control" name="integritas" value="<?= $integritas ?>">
            </td>
        </tr>    <tr>
            <td>Komitmen</td>
            <td> : </td> 
            <td colspan="3">
              
                <input type="text" class="form-control" name="komitmen" value="<?= $komitmen ?>">
            </td>
        </tr>    <tr>
            <td>Disiplin</td>
            <td> : </td> 
            <td colspan="3">
              
                <input type="text" class="form-control" name="disiplin" value="<?= $disiplin ?>">
            </td>
        </tr>    <tr>
            <td>Kerja Sama</td>
            <td> : </td> 
            <td colspan="3">
              
                <input type="text" class="form-control" name="kerjasama" value="<?= $kerjasama ?>">
            </td>
        </tr>    <tr>
            <td>Kepemimpinan</td>
            <td> : </td> 
            <td colspan="3">
              
                <input type="text" class="form-control" name="kepemimpinan" value="<?= $kepemimpinan ?>">
            </td>
        </tr>
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>

    </table>
</form>

<script>

    $("#frm_perilaku").submit(function (e) {
        e.preventDefault();
        var frm_perilaku = $("#frm_perilaku");
        var form = getFormData(frm_perilaku);
        $.ajax({
            type: "POST",
            url: "c_atasan/aksi_perilaku",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
               lihat_perilaku();
            } else {
                alert(response.ket);
            }
        });

    });
    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
</script>
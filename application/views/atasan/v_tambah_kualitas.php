<?php
if (isset($dt_kualitas)) {
    $id_opmt_realisasi_skp = $dt_kualitas['id_opmt_realisasi_skp'];
    $id_opmt_tahunan_skp = $dt_kualitas['id_opmt_tahunan_skp'];
    $kualitas = $dt_kualitas['kualitas'];
    $kegiatan_tahunan = $dt_kualitas['kegiatan_tahunan'];
    $target_kuantitas = $dt_kualitas['target_kuantitas'];
    $target_waktu = $dt_kualitas['target_waktu'];
    $target_biaya = $dt_kualitas['biaya'];
		$id_opmt_target_skp=$dt_kualitas['id_opmt_target_skp'];

    $realisasi_biaya = $dt_kualitas['realisasi_biaya'];
    $real_kuantitas = $dt_kualitas['real_kuantitas'];
    $real_waktu = $dt_kualitas['real_waktu'];
    $satuan = $dt_kualitas['satuan'];
} else {
    $id_opmt_target_bulanan_skp = "";
    $id_opmt_tahunan_skp = $id;
	$id_opmt_target_skp=$dt_kualitas['id_opmt_target_skp'];
    $kualitas = "";
//    $periode_awal = $periode['awal_periode_skp'];
//    $periode_akhir = $periode['akhir_periode_skp'];
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }td{vertical-align:middle;}
</style>
<div style="text-align:center;font-weight:bold;">INPUT KUALITAS</div>
<form id="frm_kualitas" method="post">
    <table class="table">
        <tr>
            <td>Kegiatan</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" id="id_opmt_tahunan_skp" value="<?= $id_opmt_tahunan_skp ?>">
				<input type="hidden" name="id_opmt_target_skp" value="<?=$id_opmt_target_skp?>">
                <input type="hidden" name="id_opmt_realisasi_skp" value="<?= $id_opmt_realisasi_skp ?>">
                <?= $kegiatan_tahunan ?>
            </td>
            <td></td>
            <td></td>

        </tr>
        <tr>
            <td>Target Kuantitas</td>
            <td>:</td>
            <td><?= $target_kuantitas . ' ' . $satuan ?></td>
            <td>Realisasi Kuantitas</td>
            <td>:</td>
            <td><?= $real_kuantitas . ' ' . $satuan ?></td>
        </tr>
        <tr>
            <td>Target Waktu</td>
            <td>:</td>
            <td><?= $target_waktu . ' Bulan' ?></td>
            <td>Realisasi Waktu</td>
            <td>:</td>
            <td><?= $real_waktu . ' Bulan' ?></td>
        </tr>
        <tr>
            <td>Target Biaya</td>
            <td>:</td>
            <td><?= "Rp. " . number_format($target_biaya) ?></td>
            <td>Realisasi Biaya</td>
            <td>:</td>
            <td><?= "Rp. " . number_format($realisasi_biaya) ?></td>
        </tr>
        <tr>
            <td style="font-weight:bold;">Nilai Kualitas</td>
            <td></td>
            <td><input type="text" class="form-control" name="kualitas" value="<?= $kualitas ?>"></td>
            <td></td>
            <td></td>
            <td></td>
        </tr>
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>

    </table>
</form>

<script>

    $("#frm_kualitas").submit(function (e) {
        e.preventDefault();
        var frm_kualitas = $("#frm_kualitas");
        var form = getFormData(frm_kualitas);
        $.ajax({
            type: "POST",
            url: "c_atasan/aksi_kualitas",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                realisasi_bawahan($('#id_opmt_tahunan_skp').val());
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
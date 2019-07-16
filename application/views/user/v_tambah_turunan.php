<?php
if (isset($turunan_skp)) {
    $id_opmt_turunan_skp = $turunan_skp['id_opmt_turunan_skp'];
    $id_opmt_target_bulanan_skp = $turunan_skp['id_opmt_target_bulanan_skp'];
    $kegiatan_turunan = $turunan_skp['kegiatan_turunan'];
    $target_kuantitas = $turunan_skp['target_kuantitas'];
    $satuan_kuantitas = $turunan_skp['satuan_kuantitas'];
    $target_waktu = $turunan_skp['target_waktu'];
    $biaya = $turunan_skp['biaya'];
    $kualitas = $turunan_skp['kualitas'];
    $id_opmt_bulanan_skp = $id_bulanan;
} else {
    $id_opmt_turunan_skp = "";
    $id_opmt_target_bulanan_skp = $id_opmt_bulanan;
    $kegiatan_turunan = "";
    $target_kuantitas = "";
    $satuan_kuantitas = "";
    $target_waktu = "";
    $biaya = "";
    $kualitas = "";
    $id_opmt_bulanan_skp = $id;
//    $periode_awal = $periode['awal_periode_skp'];
//    $periode_akhir = $periode['akhir_periode_skp'];
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }td{vertical-align:middle !important;}
</style>
<form id="frm_turunan_skp" method="post">
    <table class="table">
        <tr>
            <td style="width:290px !important;">SKP Tahunan</td>
            <td> : </td> 
            <td colspan="3">
                <input type="text" class="form-control" readonly="" value="<?= $target_tahunan['kegiatan_tahunan'] ?>" style="width: 430px;">
            </td>
        </tr>
        <tr>
            <td>Kegiatan Turunan</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" id="id_opmt_bulanan_skp" value="<?= $id_turunan ?>">
                <input type="hidden" name="id_opmt_turunan_skp" value="<?= $id_opmt_turunan_skp ?>">
                <input type="hidden" name="id_opmt_target_bulanan_skp" value="<?= $id_opmt_target_bulanan_skp ?>">
                <textarea class="form-control" name="kegiatan_turunan" style="width: 430px;"><?= $kegiatan_turunan ?></textarea>

            </td>
        </tr>

        <tr>
            <td>Target Kuantitas Bulanan</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control isi" name="target_kuantitas" value="<?= $target_kuantitas ?>"></td>

            <td>Satuan Kuantitas</td>
            <td>
                <select class="form-control isi" name="satuan_kuantitas">
                    <?= pilihan_list($dt_kuantitas, 'satuan_kuantitas', 'id_dd_kuantitas', $satuan_kuantitas) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Kualitas</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control isi" name="kualitas" value="100">
            </td>
        </tr>
        <tr>
            <td>Target Waktu</td>
            <td> : </td> 
            <td>
                <select class="form-control" name="target_waktu">
                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                        <option value="<?= $i ?>" <?= $target_waktu == $i ? 'selected' : '' ?>><?= $i ?> </option>
                    <?php } ?>
                </select>
            </td>
            <td>Hari</td>
        </tr>
        <tr>
            <td>Biaya Bulanan</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control isi" name="biaya" value="<?= $biaya ?>">
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

    $("#frm_turunan_skp").submit(function (e) {
        e.preventDefault();
        var id2 = $('#id_opmt_bulanan_skp').val();
        var frm_turunan_skp = $("#frm_turunan_skp");
        var form = getFormData(frm_turunan_skp);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_turunan_skp",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('c_user/target_bulanan_skp' + '/' + id2);
            } else {
                alert(response.ket);
            }
        });

    });

</script>
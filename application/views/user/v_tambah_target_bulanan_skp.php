<?php
if (isset($target_bulanan_skp)) {
    $id_opmt_target_bulanan_skp = $target_bulanan_skp['id_opmt_target_bulanan_skp'];
    $id_opmt_target_skp = $target_bulanan_skp['id_opmt_target_skp'];
    $kegiatan_bulanan = $target_bulanan_skp['kegiatan_tahunan'];
    $target_kuantitas = $target_bulanan_skp['target_kuantitas'];
    $target_waktu = $target_bulanan_skp['target_waktu'];
    $biaya = $target_bulanan_skp['biaya'];
    $turunan = $target_bulanan_skp['turunan'];
    $satuan_kuantitas = $target_bulanan_skp['satuan_kuantitas'];
    $id_opmt_bulanan_skp = $target_bulanan_skp['id_opmt_bulanan_skp'];
} else {
    $id_opmt_target_bulanan_skp = "";
    $id_opmt_target_skp = "";
    $awal_periode_skp = "";
    $kegiatan_bulanan = "";
    $target_kuantitas = "";
    $target_waktu = "";
    $biaya = "";
    $turunan = "";
    $satuan_kuantitas = "";
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
<form id="frm_target_bulanan_skp" method="post">
    <table class="table">
        <tr>
            <td>Bulan</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_opmt_target_bulanan_skp" value="<?= $id_opmt_target_bulanan_skp ?>">  
                <input type="hidden" name="id_opmt_bulanan_skp" id="id_opmt_bulanan_skp" value="<?= $id_opmt_bulanan_skp ?>">
                <?= bulan($bulan) ?>
        </tr>
        <tr>
            <td>SKP Tahunan</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" name="id_opmt_target_skp" value="<?= $id_opmt_target_skp ?>">
                <select class="form-control" name="id_opmt_target_skp">
                    <?= pilihan_list($dt_skp_tahunan, "kegiatan_tahunan", "id_opmt_target_skp", $id_opmt_target_skp) ?>
                </select></td>
        </tr>
        <tr>
            <td>Turunan</td>
            <td> : </td> 
            <td colspan="3">
                <input type="radio" name="turunan" class="turunan" value="ya" <?= $turunan == 1 ? 'checked' : '' ?>>Ya
                <input type="radio" name="turunan" class="turunan" value="tidak" <?= $turunan == 0 ? 'checked' : '' ?>>Tidak
            </td>
        </tr>
        <tr>
            <td>Target Kuantitas</td>
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
            <td>Target Waktu</td>
            <td> : </td> 
            <td>
                <select class="form-control" name="target_waktu">
                    <?php for ($i = 1; $i <= 31; $i++) { ?>
                        <option value="<?= $i ?>" <?= $target_waktu == $i ? 'selected' : '' ?>><?= $i ?> </option>
                    <?php } ?>
                </select>
            </td>
            <td>Hari </td>
        </tr>
        <tr>
            <td>Biaya Bulanan</td>
            <td> : </td> 
            <td>

                <input type="text" class="form-control isi" name="biaya" value="<?= $biaya ?>"></td>
        </tr>
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" >Simpan</button></td>
        </tr>

    </table>
</form>

<script>
    function cek_isi() {
        var cek = $('.turunan').val();
        if (cek == '1') {
            $('.isi').attr('disabled', true);
            $('.isi').val('');
        } else {
            $('.isi').attr('disabled', false);

        }
    }
    $('.turunan').on('click', function () {
        var cek = $(this).val();
        if (cek == 'ya') {
            $('.isi').attr('disabled', true);
            $('.isi').val('');
        } else {
            $('.isi').attr('disabled', false);
            $('.isi').val('');
        }
    });
    cek_isi();
    $("#frm_target_bulanan_skp").submit(function (e) {
        e.preventDefault();
        var frm_target_bulanan_skp = $("#frm_target_bulanan_skp");
        var id = $('#id_opmt_bulanan_skp').val();
        var form = getFormData(frm_target_bulanan_skp);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_target_bulanan_skp",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('c_user/target_bulanan_skp' + '/' + id);
            } else {
                alert(response.ket);
            }
        });

    });

</script>
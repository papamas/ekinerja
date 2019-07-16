<?php
if (isset($target_tahunan_skp)) {
    $id_opmt_target_skp = $target_tahunan_skp['id_opmt_target_skp'];
    $kegiatan_tahunan = $target_tahunan_skp['kegiatan_tahunan'];
    $target_kuantitas = $target_tahunan_skp['target_kuantitas'];
    $target_waktu = $target_tahunan_skp['target_waktu'];
    $biaya = $target_tahunan_skp['biaya'];
    $satuan_kuantitas = $target_tahunan_skp['satuan_kuantitas'];
    $id_opmt_tahunan_skp = $target_tahunan_skp['id_opmt_tahunan_skp'];
    $periode_awal = $target_tahunan_skp['awal_periode_skp'];
    $periode_akhir = $target_tahunan_skp['akhir_periode_skp'];
    $id_opmt_target_skp_atasan = $target_tahunan_skp['id_opmt_target_skp_atasan'];
	$id_opmt_detail_kegiatan_jabatan = $target_tahunan_skp['id_opmt_detail_kegiatan_jabatan'];
	
} else {
    $id_opmt_target_skp = "";
    $awal_periode_skp = "";
    $kegiatan_tahunan = "";
    $target_kuantitas = "";
    $target_waktu = "";
    $biaya = "";
    $satuan_kuantitas = "";
    $id_opmt_tahunan_skp = $id;
    $periode_awal = $periode['awal_periode_skp'];
    $periode_akhir = $periode['akhir_periode_skp'];
    $id_opmt_target_skp_atasan = "";
	$id_opmt_detail_kegiatan_jabatan ="";
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }td{vertical-align:middle !important;}
</style>
<div class="row">
    <div class="col-lg-5">
        <form id="frm_target_tahunan_skp" method="post">
            <table class="table">
                <tr>
                    <td>Periode</td>
                    <td> : </td> 
                    <td style="width: 150px;">
                        <input type="hidden" name="id_opmt_tahunan_skp" value="<?= $id_opmt_tahunan_skp ?>">
                        <?= date('d M', strtotime($periode_awal)) . ' - ' . date('d M Y', strtotime($periode_akhir)) ?>
                </tr>
                <tr>
                    <td>SKP Tahunan Atasan</td>
                    <td> : </td>
                    <td colspan="2">
                        <select class="form-control" name="id_opmt_target_skp_atasan">
                            <option value="0">Belum Cascading</option>
                            <?php
                            foreach ($dt_skp_tahunan_atasan as $dt) {
                                ?>   
                                <option value="<?= $dt['id_opmt_target_skp'] ?>" <?= $dt['id_opmt_target_skp'] == $id_opmt_target_skp_atasan ? 'selected' : '' ?>><?= $dt['kegiatan_tahunan'] ?></option>
                            <?php }
                            ?>
                        </select></td>
                </tr>
                <tr>
                    <td>Kegiatan Tahunan</td>
                    <td> : </td> 
                    <td colspan="3">
                        <input type="hidden" id="id_opmt_detail_kegiatan_jabatan" name="id_opmt_detail_kegiatan_jabatan" value="<?=$id_opmt_detail_kegiatan_jabatan ?>">
						<input type="hidden" name="id_opmt_target_skp" value="<?= $id_opmt_target_skp ?>">
						
                        <textarea class="form-control" name="kegiatan_tahunan" id="kegiatan_tahunan"><?= $kegiatan_tahunan ?></textarea></td>
                </tr>
                <tr>
                    <td>Target Kuantitas</td>
                    <td> : </td> 
                    <td style="width: 50px;">
                        <input type="text" class="form-control" name="target_kuantitas" value="<?= $target_kuantitas ?>"></td>
                    <td>
                        <select class="form-control" name="satuan_kuantitas" id="satuan_kuantitas" style="font-size: 12px;">
                            <?= pilihan_list($dt_kuantitas, 'satuan_kuantitas', 'id_dd_kuantitas', $satuan_kuantitas) ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Target Waktu</td>
                    <td> : </td> 
                    <td>

                        <input type="text" class="form-control" name="target_waktu" value="<?= $target_waktu ?>"></td>
                </tr>
                <tr>
                    <td>Biaya</td>
                    <td> : </td> 
                    <td>

                        <input type="text" class="form-control" name="biaya" value="<?= $biaya ?>"></td>
                </tr>
                <tr>
                    <td></td>
                    <td> </td>
                    <td><button class="btn btn-primary" >Simpan</button></td>
                </tr>

            </table>
        </form>
    </div>
    <div class="col-lg-7" id="tbl_kegiatan">

    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div style="text-align: center;font-weight: bold;font-size: 18px;">RENCANA KERJA TAHUNAN</div>
        <div style="text-align: center;font-weight: bold;font-size: 18px;"><?= $direktorat . ' ' . date('Y', strtotime($periode_awal)) ?></div><br>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <div class="input-group"><div class="input-group-addon"><b>Rencana Strategis</b></div><select class="form-control" id="rencana_strategis"><?= pilihan_list($rencana, 'sasaran_strategis', 'id_opmt_sasaran_strategis', $default = "") ?></select>

        </div>

    </div>
</div>
<div class="row">
    <div id="div_indikator"></div>
</div>
<script>

    $("#frm_target_tahunan_skp").submit(function (e) {
        e.preventDefault();
        var frm_target_tahunan_skp = $("#frm_target_tahunan_skp");
        var form = getFormData(frm_target_tahunan_skp);
        $.ajax({
            type: "POST",
            url: "c_user/aksi_target_tahunan_skp",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refreshTarget();
            } else {
                alert(response.ket);
            }
        });

    });
    $('.tanggal').datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose: true
    });

    $.get('admin/c_kegiatan_jabatan/detail2', {}, function (data) {
        $('#tbl_kegiatan').html(data);
    });
    $('#rencana_strategis').on('click change', function () {
        refresh_indikator();

    });
    refresh_indikator();
    function refresh_indikator() {
        var id = $('#rencana_strategis').val();
        $.post('c_user/indikator_kinerja', {id: id}, function (data) {
            $('#div_indikator').html(data);
        });
    }
</script>
<?php
if (isset($harian_skp)) {
    $id_opmt_realisasi_harian_skp = $harian_skp['id_opmt_realisasi_harian_skp'];
    $tanggal = $harian_skp['tanggal'];
    $proses = $harian_skp['proses'];
    $kegiatan_harian_skp = $harian_skp['kegiatan_harian_skp'];
    $kuantitas = $harian_skp['kuantitas'];
    $satuan_kuantitas = $harian_skp['satuan_kuantitas'];
    $id_opmt_target_skp = $harian_skp['id_opmt_target_skp'];
    $id_opmt_target_bulanan_skp = $harian_skp['id_opmt_target_bulanan_skp'];
    $turunan = $harian_skp['turunan'];
} else {
    $id_opmt_realisasi_harian_skp = "";
    $tanggal = "";
    $proses = "";
    $kegiatan_harian_skp = "";
    $kuantitas = "";
    $satuan_kuantitas = "";
    $id_opmt_target_skp = "";
    $id_opmt_target_bulanan_skp = "";
    $turunan = '';
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
<form id="frm_harian_skp" method="post">
    <table class="table">
        <tr>
            <td style="width:150px !important;">Tanggal</td>
            <td> : </td> 
            <td colspan="3">
                <input type="text" class="form-control tanggal" name="tanggal" value="<?= $tanggal == "" ? date('Y-m-d') : $tanggal ?>" style="width: 200px;">
            </td>
        </tr>
        <tr>
            <td>Proses</td>
            <td> : </td> 
            <td colspan="3">
                <input type="hidden" name="id_opmt_realisasi_harian_skp" value="<?= $id_opmt_realisasi_harian_skp ?>">

                <input type="checkbox" name="proses" id="proses" <?= $proses == 1 ? 'checked' : '' ?> class="form-control" style="width: 30px;">
            </td>
        </tr>

        <tr>
            <td>Kegiatan Harian SKP</td>
            <td> : </td> 
            <td colspan="3">
                <textarea class="form-control" name="kegiatan_harian_skp"><?= $kegiatan_harian_skp ?></textarea>
            </td>
        </tr>
        <tr>

            <td>Kuantitas</td>
            <td>:</td>
            <td>
                <input type="text" class="form-control" name="kuantitas" style="width:50px;" value="<?= $kuantitas ?>">
            </td>

            <td>Satuan Kuantitas</td>
            <td>
                <select class="form-control isi" name="satuan_kuantitas">
                    <?= pilihan_list($dt_kuantitas, 'satuan_kuantitas', 'id_dd_kuantitas', $satuan_kuantitas) ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Klasifikasi SKP Bulanan</td>
            <td> : </td> 
            <td colspan="3">
                <select class="form-control" name="id_opmt_target_bulanan_skp" id="id_opmt_target_bulanan_skp">
                    <?php
                    $ket2 = $turunan == 1 ? "turunan" : "utama";
                    foreach ($skp_bulanan as $arr) {
                        ?>    
                        <option value="<?= $arr['id'] . '-' . $arr['ket'] ?>" <?= !isset($harian_skp) ? '' : $arr['id'] . '-' . $arr['ket'] == $harian_skp['id_opmt_target_bulanan_skp'] . '-' . $ket2 ? 'selected' : '' ?>><?= $arr['kegiatan'] ?></option>
                    <?php }
                    ?>
                </select>
            </td>
        </tr>
        <tr>
            <td>Klasifikasi SKP Tahunan</td>
            <td> : </td> 
            <td colspan="3">
                <select class="form-control" name="id_opmt_target_skp" id="id_opmt_target_skp">
                    <?php
                    foreach ($skp_tahunan as $arr) {
                        ?>    
                        <option value="<?= $arr['id_opmt_target_skp'] ?>" <?= !isset($harian_skp) ? '' : $arr['id_opmt_target_skp'] == $harian_skp['id_opmt_target_skp'] ? 'selected' : '' ?>><?= $arr['kegiatan_tahunan'] ?></option>
                    <?php }
                    ?>
                </select>
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
    $("#frm_harian_skp").submit(function (e) {
    e.preventDefault();
    var frm_harian_skp = $("#frm_harian_skp");
    var form = getFormData(frm_harian_skp);
    var target_bulanan = document.getElementById("id_opmt_target_bulanan_skp").options.length;
    var target_tahunan = document.getElementById("id_opmt_target_skp").options.length;
    if (target_tahunan == '') {
    alert('Target Tahunan Tidak Ada');
    } else if (target_bulanan == '') {
    alert('Target Bulanan Tidak Ada');
    } else {
    $.ajax({
    type: "POST",
            url: "c_user/aksi_harian_skp",
            data: JSON.stringify(form),
            dataType: 'json'
    }).done(function (response) {
    if (response.status === 1) {
    alert(response.ket);
    $('.close').click();
    refresh_harian_skp();
    } else {
    alert(response.ket);
    }
    });
    }
    });
    $('.tanggal').datepicker({
    dateFormat: 'yy-mm-dd',
            autoclose: true,
<?php if ($parameter['parameter_bulan'] == 1) { ?>
        minDate: 0,
<?php } ?>
    onSelect: function (dateText, inst) {
    var date = $(this).val();
    document.getElementById("id_opmt_target_skp").options.length = 0;
    document.getElementById("id_opmt_target_bulanan_skp").options.length = 0;
    $.post('c_user/get_target_tahun', {tanggal: date}, function (data) {
    var x = JSON.parse(data);
    for (i = 0; i < x.length; i++) {
    $('#id_opmt_target_skp').append($('<option>', {
    value: x[i].id_opmt_target_skp,
            text: x[i].kegiatan_tahunan
    }));
    }
    });
    $.post('c_user/get_target_bulan', {tanggal: date}, function (data) {
    var x = JSON.parse(data);
//                alert(x.length);
//                alert(x[0].kegiatan_tahunan);
    for (i = 0; i < x.length; i++) {
    $('#id_opmt_target_bulanan_skp').append($('<option>', {
    value: x[i].id + '-' + x[i].ket,
            text: x[i].kegiatan
    }));
    }
    });
//            $("#start").val(date + time.toString(' HH:mm').toString());

    }
    });
    $('input[name=proses]').on("change", function(){
    var cek = $(this).prop('checked');
    if (cek == true){
    var r = confirm("Apakah Anda Yakin Kegiatan yang diinput merupakan Proses?");
    if (!r){
    $(this).attr('checked', false);
    }
    }
    else{
    var r2 = confirm("Apakah Anda Yakin Kegiatan yang diinput Bukan merupakan Proses?");
    if (!r2){
    $(this).prop('checked', true);
    }
    }

    });
</script>
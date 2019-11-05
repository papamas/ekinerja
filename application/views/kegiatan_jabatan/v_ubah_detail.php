<style>
   #frmSpesimen td{
        vertical-align: middle !important;font-family: "gotham";
    }
</style>
<form id="frmSpesimen" method="post">
    <table class="table">
        <   <input type="hidden" name="id_opmt_detail_kegiatan_jabatan" value="<?= $dt['id_opmt_detail_kegiatan_jabatan'] ?>">

            <tr>
                <td>Butir Kegiatan Jabatan</td>
                <td>
                    <textarea class="form-control" name="kegiatan_jabatan"><?= $dt['kegiatan_jabatan'] ?></textarea>
                </td>
            </tr>
            <tr>
                <td>Satuan Hasil</td>
                <td>
                    <select class="form-control" name="satuan_hasil" id="satuan_hasil">
					<?php foreach($satuan_hasil as $value):?>
					<option value="<?=$value['id_dd_kuantitas']?>"><?=$value['satuan_kuantitas']?></option>
					<?php endforeach;?>
					</select>
					<!--
					<input type="hidden" class="form-control " name="id_satuan_hasil" value="<?= $dt['satuan_hasil'] ?>" >
                    <input type="text" class="form-control " name="satuan_hasil" value="<?= $dt['satuan_kuantitas'] ?>" >
                    !-->
				</td>
            </tr>
            <tr>
                <td>Angka Kredit</td>
                <td>
                    <input type="text" class="form-control " name="angka_kredit" value="<?= $dt['angka_kredit'] ?>" >
                </td>
            </tr>
            <tr>
                <td></td>
                <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
            </tr>
        
    </table>
</form>

<script>

   $("#satuan_hasil").val('<?= $dt['satuan_hasil']?>');
    $("#frmSpesimen").submit(function (e) {
        e.preventDefault();
        var frmSpesimen = $("#frmSpesimen");
        var form = getFormData(frmSpesimen);
        $.ajax({
            type: "POST",
            url: "admin/c_kegiatan_jabatan/aksi_ubah_detail",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                refresh_kegiatan();
            } else {
                alert(response.ket);
            }
        });

    });

 
</script>
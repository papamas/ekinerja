<form id="frmProduktivitas" method="post">
    <table class="table">
        <tr>
            <td colspan="4" style="text-align: center;font-weight: bold;">Produktivitas</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td><input type="text" class="form-control tanggal" name="tanggal"></td>
        </tr>
        <tr>
            <td>Produktivitas</td>
            <td colspan="4">
                <textarea class="form-control" name="produktivitas"></textarea>
            </td>
        </tr>
        <tr>
            <td>Kuantitas</td>
            <td>
                <input type="text" class="form-control" name="target_kuantitas">
            </td>
            <td>Satuan</td>
            <td>
                <select class="form-control" name="satuan_kuantitas">
                    <?=
                    pilihan_list($dt_kuantitas, 'satuan_kuantitas', 'id_dd_kuantitas', $default)
                    ?></select>

            </td>
        </tr>
        <tr>
            <td>Jam Mulai</td>
            <td>
                <div class="input-group bootstrap-timepicker timepicker">
                    <input type="text" class="form-control input-small waktu" name="jam_mulai">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
            </td>
            <td>Jam Selesai</td>
            <td>
                <div class="input-group bootstrap-timepicker timepicker">
                    <input type="text" class="form-control input-small waktu" name="jam_selesai">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-time"></i></span>
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>
    $('.tanggal').datepicker({
        dateFormat: 'yy-mm-dd',
        autoclose: true
    });
    $('.waktu').timepicker({
        minuteStep: 1,
        template: 'modal',
        appendWidgetTo: 'body',
        showSeconds: false,
        showMeridian: false,
        defaultTime: false
    });

    $("#frmProduktivitas").submit(function (e) {
        e.preventDefault();
        var id2 = $('#id_opmt_bulanan_skp').val();
        var frmProduktivitas = $("#frmProduktivitas");
        var form = getFormData(frmProduktivitas);
        $.ajax({
            type: "POST",
            url: "c_produktivitas/aksi_tambah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('c_produktivitas');
            } else {
                alert(response.ket);
            }
        });

    });
</script>
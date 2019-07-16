<style>
    .form-control select option{font-size: 12px !important;}
</style>
<div class="row">
    <div class="col-lg-10">
        <table style="text-align:center;font-weight:bold;font-size:12px;" class="table">
            <tr>
                <td>Unit Kerja</td>
                <td>
                    <select class="form-control" id="uker">
                        <?= pilihan_list($unit, 'nama_uker', 'id_dd_uker', '') ?>
                    </select>
                </td>
                <td>Bulan</td>
                <td>
                    <select id="bln" class="form-control">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= $i ?>"><?= bulan($i) ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>Tahun</td>
                <td>
                    <select class="form-control" id="thn">
                        <?= pilihan_list($tahun, 'tahun', 'tahun', '') ?>
                    </select>
                </td>
                <td>NIP</td>
                <td><input type="text" class="form-control" id="nip"></td>
                <td><button class="btn btn-primary" onclick="cari(0)">Cari</button></td>
        </table>
    </div>
</div>
<table id="tbl_rekap_tunjangan" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">
</table>
<div id="ajaxTunjangan"></div>
<script>
    function cari(hal) {
        var thn = $('#thn').val();
        var bln = $('#bln').val();
        var uker = $('#uker').val();
        var nip = $('#nip').val();
        $('#ajaxTunjangan').html('');
        $.post('c_admin/lihat_rekap_tunjangan', {thn: thn, bln: bln, uker: uker, nip: nip, page: hal}, function (data) {
            $('#ajaxTunjangan').html(data);
        });
    }
    cari();

    function cetak_tunjangan() {
        var thn = $('#thn').val();
        var bln = $('#bln').val();
        var uker = $('#uker').val();
        var nip = $('#nip').val();
        var dialog = new BootstrapDialog({
            title: '<div style="font-size:12px;">Data Rekap Tunjangan</div>',
            message: function () {
//                var $message = $('<div></div>').load('c_pdf/cetak_jfk/' + jenis );
                var $message = $('<iframe src=c_pdf/cetak_tunjangan/' + thn + '/' + bln + '/' + uker + '/' + nip + ' style="width:100%;height:300px;"></iframe>');
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_WIDE);
        dialog.open();
    }

</script>
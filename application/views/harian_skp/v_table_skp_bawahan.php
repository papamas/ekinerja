
<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    }th{vertical-align: middle !important;}
</style>
<ol class="breadcrumb bc-3" style="margin-top:-30px;">
    <li>
        <a href="javascript:void(0)">
            <i class="glyphicon glyphicon-home"></i>
            SKP Harian
        </a>
    </li>
    <li><a href="javascript:void(0)">Bawahan</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float: right;">
        <table id="tbl_utama_skp_harian">
            <tr>
                <td>Nama Bawahan</td>
                <td><input type="text" class="form-control" id="nama"></td>

                <td>Tanggal</td>
                <td>
                    <input type="text" id="tanggal" class="form-control" placeholder="Tanggal">
                </td>
                <td>Bulan</td>
                <td>
                    <select class="form-control" id="bulan">
                        <option value="all">-all-</option>
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == (int) date('m') ? 'selected' : '' ?>><?= bulan($i) ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>Tahun</td>
                <td><select class="form-control" id="tahun">
                        <option value="all">-all-</option>
                        <?php foreach ($tahun as $arr) { ?>
                            <option value="<?= $arr['tahun'] ?>"<?= $arr['tahun'] == date('Y') ? 'selected' : '' ?>><?= $arr['tahun'] ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <button class="btn btn-primary" onclick="refresh_harian_skp()">Cari</button>
                </td>
            </tr>
        </table>
    </div>

    <div id="hasilAjaxHarian"></div>
</div>
<script type="text/javascript">
    function refresh_harian_skp() {
        var nama = $('#nama').val();
        var tanggal = $('#tanggal').val();
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        $.post("c_harian_skp/ajax_bawahan", {nama: nama, tanggal: tanggal, bulan: bulan, tahun: tahun}, function (data) {
            $("#hasilAjaxHarian").html(data);
        });
    }
    refresh_harian_skp();
    function lihat_harian(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_atasan/lihat_harian_skp' + '/' + id);
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_NORMAL);
        dialog.open();
    }
</script>
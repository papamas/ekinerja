<style>
    .breadcrumb  li a{
        color:#0000C0 !important;
    }
</style>
<ol class="breadcrumb bc-3" style="margin-top:-30px;">
    <li>
        <a href="javascript:void(0)">
            <i class="glyphicon glyphicon-home"></i>
            Atasan
        </a>
    </li>
    <li><a href="javascript:void(0)">SKP Tahunan User</a></li>
</ol>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <table>
                <tr>
                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">Tahun</div>
                            <select class="form-control ui-state-default" id="tahun">
                                <?= pilihan_list($tahun, "tahun", "tahun", ""); ?>
                            </select>
                        </div>
                    </td>
                    <td> <button class = "btn btn-primary" onclick="cari_detail()">Cari</button></td>
                    <td> <button class = "btn btn-success" onclick="cetak_detail()">Cetak</button></td>
                </tr>
            </table>

        </div>
    </div>
    <div id="ajaxHasil"></div>
    <script>
        function cetak_detail() {
            var tahun = $('#tahun').val();
            var dialog = new BootstrapDialog({
                title: '<div style="font-size:12px;">Laporan Target Bulanan SKP</div>',
                message: function () {
//                var $message = $('<div></div>').load('c_pdf/cetak_jfk/' + jenis );
                    var $message = $('<iframe src=c_pdf/cetak_rekap_kinerja/' + tahun + ' style="width:100%;height:300px;"></iframe>');
                    return $message;
                }
            });
            dialog.realize();
            dialog.getModalBody().css('background-color', 'lightblue');
            dialog.getModalBody().css('color', '#000');
            dialog.setSize(BootstrapDialog.SIZE_WIDE);
            dialog.open();

        }

        function cari_detail() {
            var tahun = $('#tahun').val();
            var user = '<?= $this->session->userdata('id_user') ?>';
            $.get('c_pdf/pdf_cetak_rekap_kinerja/' + tahun + '/' + user, function (data) {
                $('#ajaxHasil').html(data);
            });
        }

    </script>
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
    <li><a href="javascript:void(0)">Detail SKP Tahunan</a></li>
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
                </tr>
            </table>

        </div>
    </div>
    <div id="ajaxHasil"></div>
    <script>
        function cari_detail() {
            var tahun = $('#tahun').val();
            $.post('c_detail_skp_tahunan/bawahan', {tahun: tahun}, function (data) {
                $('#ajaxHasil').html(data);
            });
        }

    </script>
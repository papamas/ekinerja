<div class="row" style="margin-top:-40px;">
    <div class="col-sm-12">
        <div style="float:left;">
            <table>
                <tr>
                    <td>  
                        <div class="input-group">
                            <div class="input-group-addon">Bulan</div>
                            <select class="form-control ui-state-focus" id="bulan">
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?= $i ?>" <?= $i == (int) date('m') ? 'selected' : '' ?>>
                                        <?= bulan($i) ?>
                                    </option>
                                <?php } ?>                            </select>
                        </div>
                    </td>
                    <td>                 
                        <div class="input-group">
                            <div class="input-group-addon">Tahun</div>
                            <select class="form-control ui-state-focus" id="tahun">
                                <?= pilihan_list($tahun, 'tahun', 'tahun', date('Y')) ?>
                            </select>
                        </div>
                    </td>
                    <td>   
                        <button class="btn btn-primary" onclick="lihat_laporan()"><i class="fa fa-search"></i>Cari</button>
                    </td>
                </tr>
            </table>
        </div>
        <div style="float:right;">
            <div class="input-group">
                <div class="input-group-addon">Kategori</div>
                <select class="form-control ui-state-error" id="jenis">
                    <option value="1">Ranking 1 -50 Pegawai</option>
                    <option value="2">Rekap Pegawai yang belum membuat SKP Bulanan</option>
                    <option value="3">Rekap Pegawai Belum Disetujui Atasan</option>
                </select>
            </div>
        </div>
    </div>
</div>
<div id="ajaxLaporan"></div>
<script>
    function lihat_laporan() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        var jenis = $('#jenis').val();
        $.post('admin/c_fitur/lihat_laporan', {bulan: bulan, tahun: tahun, jenis: jenis}, function (data) {
            $('#ajaxLaporan').html(data);
        });
    }
    lihat_laporan();
</script>

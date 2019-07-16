
<style>
    .judul th {
        text-align: center !important;
    }.tengah{text-align: center;}th{vertical-align: middle !important;}
</style>

<table id="table" class="table table-striped table-bordered" cellspacing="0" width="100%">
    <thead class="ui-state-default judul dataTables_scrollHead">
        <tr class="judul">
            <th class="ui-state-default">No</th>
            <th class="ui-state-default">Tanggal</th>
            <th class="ui-state-default">Nama Bawahan</th>
            <th class="ui-state-default">Keg. Harian SKP</th>
            <th class="ui-state-default">SKP Bulanan</th>
            <th class="ui-state-default">Kuantitas</th>
            <th class="ui-state-default">Status</th>
            <th class="ui-state-default">View Detail</th>
            <th class="ui-state-default">Kesesuaian</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $ttl_sesuai = 0;
        foreach ($dt_harian as $dt) {

            if ($dt['sesuai'] == 1) {
                $ttl_sesuai++;
            }
            $link_detail = '<a href="javascript:void(0)" onclick="detail_harian(' . $dt['id_opmt_realisasi_harian_skp'] . ')">
<i class="fa fa-pencil text-success"/>
</a>';
            ?>
            <tr>
                <td class="tengah"><?= $no; ?></td>
                <td class="tengah"><?= date('d M Y', strtotime($dt['tanggal'])); ?></td>
                <td><?= $dt['nama']; ?></td>
                <td><?= $dt['kegiatan_harian_skp']; ?></td>
                <td><?= $dt['kegiatan_bulanan']; ?></td>
                <td><?= $dt['kuantitas'] . ' ' . $dt['satuan_kuantitas']; ?></td>
                <td style="background: <?= $dt['proses'] == 1 ? 'green' : '' ?>;text-align: center;font-weight: bold;"><?= $dt['proses'] == 1 ? "Proses" : ""; ?></td>
                <td class="tengah"><?= $link_detail; ?></td>
                <td class="tengah"><input type="checkbox" class="form-control check" id="<?= $dt['id_opmt_realisasi_harian_skp'] ?>" <?= $dt['sesuai'] == 1 ? 'checked' : '' ?>></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </tbody>
    <tfoot class="ui-state-default">
        <tr>
            <td colspan="3" class="ui-state-default">Jumlah Kegiatan Harian SKP</td>
            <td  class="ui-state-default"><?= count($dt_harian) . ' Kegiatan' ?></td>
            <td colspan="3" class="ui-state-default">Jumlah Sesuai</td>
            <td colspan="2" class="ui-state-default"><?= $ttl_sesuai ?> Kegiatan</td>
        </tr>
        <tr>
            <td colspan="6" class="ui-state-default">Persentase</td>
            <td colspan="3" class="ui-state-default" ><?=count($dt_harian)==0?0: $ttl_sesuai / count($dt_harian) * 100 ?> %</td>
        </tr>
    </tfoot>
</table>
<div style="float:left;width:300px;margin-top:-20px;">
    <div class="col-md-2">
        <input type="checkbox" class="form-control ui-state-checked check-all"></div>
    <div class="col-md-5" style="margin-top:10px;"><span id="info_cek">Check All</span></div>
</div>

<script>
    $('.check').on('change', function () {
        var cek = $(this).is(":checked");
        var id = $(this).attr('id');
        $.post('c_harian_skp/update_sesuai', {id: id, cek: cek}, function (x) {
            if (x == 'ok') {
                refresh_harian_skp()
            }
        });
    });
    $('.check-all').click(function (event) {
        if ($(this).is(":checked")) {
            $('#info_cek').html('Uncheck All');
            // Iterate each checkbox
            $('.check').each(function () {
                this.checked = true;
                var cek = $(this).is(":checked");
                var id = $(this).attr('id');
                $.post('c_harian_skp/update_sesuai', {id: id, cek: cek}, function (x) {

                });
            });

        } else {
            $('#info_cek').html('Check All');
            $('.check').each(function () {
                this.checked = false;
                var cek = $(this).is(":checked");
                var id = $(this).attr('id');
                $.post('c_harian_skp/update_sesuai', {id: id, cek: cek}, function (x) {
                });
            });

        }

    });

    function detail_harian(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_harian_skp/detail' + '/' + id);
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
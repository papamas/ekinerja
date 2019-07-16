
<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    }
</style>
<ol class="breadcrumb bc-3" style="margin-top:-30px;">
    <li>
        <a href="javascript:void(0)">
            <i class="glyphicon glyphicon-home"></i>
            SKP
        </a>
    </li>
    <li><a href="javascript:void(0)">Harian</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float: left;">
        <button class="btn btn-primary" onclick="tambah_harian()">Input Laporan Harian Kinerja SKP</button>
    </div>

    <div style="float: right;">
        <table style="font-size: 12px;">
            <tr>
                <td>Periode</td>
                <td>
                    <input type="text" class="form-control" id="tanggal" placeholder="Tanggal">
                </td>
                <td>
                    <select class="form-control" id="bulan">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == (int) date('m') ? 'selected' : '' ?>><?= bulan($i) ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select class="form-control" id="tahun">
                        <option value="all">all</option>
                        <?php foreach ($tahun as $arr) { ?>
                            <option value="<?= $arr['tahun'] ?>" <?= $arr['tahun'] == (int) date('Y') ? 'selected' : '' ?>><?= $arr['tahun'] ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><button class="btn btn-primary btn-lg " onclick="refresh_harian_skp()"><i class="fa fa-search-plus"></i>Cari</button></td>
            </tr>
        </table>
    </div>
    <div id="hasilAjaxHarian"></div>
</div>
<script type="text/javascript">
    function refresh_harian_skp() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        var tanggal = $('#tanggal').val();
        $.post('c_harian_skp/ajax', {tanggal: tanggal, bulan: bulan, tahun, tahun}, function (data) {
            $("#hasilAjaxHarian").html(data);
        });
    }
    refresh_harian_skp();
//    var table;
//    table = $('#table').DataTable({
//        "searching": false,
//        "processing": true, //Feature control the processing indicator.
//        "serverSide": true, //Feature control DataTables' server-side processing mode.
//        "order": [], //Initial no order.
//
//        // Load data for the table's content from an Ajax source
//        "ajax": {
//            "url": "<?php echo site_url('c_harian_skp/ajax_list') ?>",
//            "type": "POST",
//            "data": function (d) {
//                d.tahun = $('#tahun').val();
//                d.bulan = $('#bulan').val();
//            }s
//        }, scrollY: 230, "scrollX": true,
//
//        //Set column definition initialisation properties.
//        "columnDefs": [
//            {
//                "width": "3%", className: "dt-center",
//                "targets": [0], //first column / numbering column
//                "orderable": false, //set not orderable
//            }, {
//                "width": "10%", className: "dt-center",
//                "targets": [1]
//            }, {
//                "width": "20%", className: "dt-center", "orderable": false,
//                "targets": [2]
//            }, {
//                className: "dt-center", "orderable": false,
//                "targets": [3]
//            }, {
//                "width": "10%", className: "dt-center", "orderable": false,
//                "targets": [4]
//            }, {
//                "width": "10%", className: "dt-center", "orderable": false,
//                "targets": [5]
//            }, {
//                "width": "10%", className: "dt-center", "orderable": false,
//                "targets": [6]
//            },
//        ],
//
//    });
//
//    function refresh_harian_skp() {
//        table.ajax.reload();
//    }

    function hapus_harian(id) {
        var r = confirm("Yakin ingin menghapus realisasi Harian SKP ini ?");
        if (r) {
            $.post('c_user/hapus_harian', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    refresh_harian_skp();
                }
            });
        }
    }

    function tambah_harian() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_user/tambah_harian_skp');
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
    function ubah_harian(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_user/ubah_harian_skp' + '/' + id);
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
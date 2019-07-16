
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
            SKP Bulanan
        </a>
    </li>
    <li><a href="javascript:void(0)"> Bawahan</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <button class="btn btn-primary" onclick="cetak()">Cetak Rekap Catatan Pribadi</button>
    </div>
    <div style="float: right;">
        <table>
            <tr>
                <td><input type="text" id="nama" class="form-control" placeholder="Nama Bawahan"></td>
                <td><input type="text" id="tahun" class="form-control" placeholder="Tahun"></td>
                <td>
                    <select class="form-control" id="bulan">
                        <option value="all">Semua</option>
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == date('m') ? 'selected' : '' ?>><?= bulan($i) ?></option>
                        <?php } ?>
                    </select>    
                </td>
                <td> <button onclick="cariSKP()" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i>Cari</button></td>
            </tr>
        </table>

    </div>
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Status Approve</th>
                <th>Nama Bawahan</th>
                <th>Catatan Pribadi</th>
                <th>Nilai Kualitas Bawahan</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    var table;
    table = $('#table').DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('c_bulanan_skp/ajax_list_bawahan') ?>",
            "type": "POST",
            "data": function (d) {
                d.nama = $('#nama').val();
                d.tahun = $('#tahun').val();
                d.bulan = $('#bulan').val();
            }
        }, scrollY: 230, "scrollX": true,

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0]//first column / numbering column
                , //set not orderable
            }, {
                "width": "5%", className: "dt-center", "orderable": false,
                "targets": [1]
            }, {
                "width": "5%", className: "dt-center", "orderable": true,
                "targets": [2]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [3]
            }, {
                "width": "15%", className: "dt-center", "orderable": true,
                "targets": [4]
            }, {
                "width": "10%", className: "dt-center", "orderable": true,
                "targets": [5]
            }
            , {
                "width": "10%", className: "dt-center", "orderable": true,
                "targets": [6]
            }
        ],

    });

    function cariSKP() {
        table.ajax.reload();
    }

    function realisasi_bulanan(id) {
        menu('c_atasan/realisasi_bulanan_bawahan' + '/' + id);
    }

    function catatan_bulanan(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_bulanan_skp/tambah_catatan/' + id);
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

    function cetak() {
        BootstrapDialog.show({
            title: 'Pilih Bawahan',
            message: '<table class="table"><tr><td>Tahun</td><td><select class="form-control" id="tahun_cat"><?= count($tahun_cat) == 0 ? "" : pilihan_list($tahun_cat, "tahun", "tahun", "") ?></select></td><tr><td>Nama Bawahan</td><td><select class="form-control" id="bawahan_cat"><?= count($bawahan_cat) == 0 ? "" : pilihan_list($bawahan_cat, "nama", "id_dd_user", "") ?></select></td></tr></table>'
            ,
            buttons: [{
                    label: 'Cetak', cssClass: 'btn-primary ',
                    action: function (dialog) {
                       cetak_catatan_skp();
                    }
                }]
        });
    }


    function cetak_catatan_skp() {
        var tahun = $('#tahun_cat').val();
        var bawahan = $('#bawahan_cat').val();
        var dialog = new BootstrapDialog({
            title: '<div style="font-size:12px;">Laporan Catatan</div>',
            message: function () {
//                var $message = $('<div></div>').load('c_pdf/cetak_jfk/' + jenis );
                var $message = $('<iframe src=c_pdf/cetak_catatan/' + tahun + '/' + bawahan + ' style="width:100%;height:300px;"></iframe>');
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
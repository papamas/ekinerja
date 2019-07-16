
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
    <li><a href="javascript:void(0)">Tahunan</a></li>
    <li><a href="javascript:void(0)">Target </a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float: right;">
        <table>
            <tr>
                <td><input type="hidden" id="id_target" class="form-control" value="<?= $id ?>"></td>
                <td><input type="text" id="tahunan_skp" class="form-control" placeholder="Tahun"></td>
                <td> <button onclick="cariSKP()" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i>Cari</button></td>
            </tr>
        </table>

    </div>
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Kegiatan Tahunan</th>
                <th>Target Kuantitas</th>
                <th>Target Kualitas</th>
                <th>Target Waktu</th>
                <th>Biaya</th>
                <th>Edit</th>
                <th>Hapus</th>
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
            "url": "<?php echo site_url('c_tahunan_skp/ajax_list_target') ?>",
            "type": "POST",
            "data": function (d) {
                d.status = $('#tahunan_skp').val();
                d.id = $('#id_target').val();
            }
        }, scrollY: 230, "scrollX": true,
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, {
                "width": "3%",
                className: "dt-center",
                "targets": [1]
            }, {
                className: "dt-center", "orderable": true,
                "targets": [2]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [3]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [4]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [5]
            }
            , {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [6]
            }
            , {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [7]
            }
            , {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [8]
            }
        ],
    });
    function cariSKP() {
        table.ajax.reload();
    }

    function tambah_target_tahunan_skp(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_user/tambah_target_tahunan_skp' + '/' + id);
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

    function ubah_target_tahunan_skp(id) {

        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_user/ubah_target_tahunan_skp' + '/' + id);
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

    function hapus_target_tahunan_skp(id) {
        var r = confirm("Yakin ingin menghapus target_tahunan_skp ini ?");
        if (r) {
            $.post('c_user/hapus_target_tahunan_skp', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    refresh_target_tahunan_skp();
                }
            });
        }
    }

    function cetak_target_tahunan_skp(id) {
        var dialog = new BootstrapDialog({
            title: '<div style="font-size:12px;">Laporan Data JFK</div>',
            message: function () {
//                var $message = $('<div></div>').load('c_pdf/cetak_jfk/' + jenis );
                var $message = $('<iframe src=c_pdf/cetak_target_tahunan_skp/' + id + ' style="width:100%;height:300px;"></iframe>');
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
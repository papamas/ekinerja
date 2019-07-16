
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
    <li><a href="javascript:void(0)">Bulanan</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <button onclick="tambah_bulanan_skp()" class="btn btn-primary"><i class="fa fa-plus-circle"></i> Tambah</button>
    </div>
    <div style="float: right;">
        <table>
            <tr>
                <td><input type="text" id="bulanan_skp" class="form-control" placeholder="Tahun" value="<?=date('Y')?>"></td>
                <td> <button onclick="refreshBulanan()" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i>Cari</button></td>
            </tr>
        </table>

    </div>
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Bulan</th>
                <th>Nilai SKP</th>
                <th>Hapus</th>
                <th>Target SKP Bulanan</th>
                <th>Realisasi SKP Bulanan</th>
                <th>Status Approve</th>
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
            "url": "<?php echo site_url('c_bulanan_skp/ajax_list') ?>",
            "type": "POST",
            "data": function (d) {
                d.status = $('#bulanan_skp').val();
            }
        }, scrollY: 230, "scrollX": true,

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, {
                "width": "8%", className: "dt-center",
                "targets": [1]
            }, {
                "width": "8%", className: "dt-center", "orderable": false,
                "targets": [2]
            }, {
                "width": "8%", className: "dt-center", "orderable": false,
                "targets": [3]
            }, {
                "width": "5%", className: "dt-center", "orderable": false,
                "targets": [4]
            }, {
                "width": "13%", className: "dt-center", "orderable": false,
                "targets": [5]
            }, {
                "width": "13%", className: "dt-center", "orderable": false,
                "targets": [6]
            }, {
               className: "dt-center", "orderable": false,
                "targets": [7],
                "createdCell": function (td, cellData, rowData, row, col) {
                    if (cellData == "Disetujui") {
                        $(td).css('background', 'green');
                        $(td).css('color', 'white');
                    } else {
                        $(td).css('background', 'red');
                        $(td).css('color', 'white');
                    }
                }
            },
        ],

    });

    function refreshBulanan() {
        table.ajax.reload();
    }

    function tambah_bulanan_skp() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_user/tambah_bulanan_skp');
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

    function target_bulanan_skp(id) {
        menu('c_user/target_bulanan_skp' + '/' + id);
    }

    function realisasi_bulanan_skp(id) {
        menu('c_user/realisasi_bulanan_skp' + '/' + id);
    }

    function ubah_bulanan_skp(id) {

        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_user/ubah_bulanan_skp' + '/' + id);
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

    function hapus_bulanan_skp(id) {
        var r = confirm("Yakin ingin menghapus bulanan_skp ini ?");
        if (r) {
            $.post('c_user/hapus_bulanan_skp', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    refreshBulanan();
                }
            });


        }
    }
</script>

<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    } td.blink_me {
        animation: blinker 1s linear infinite;
    }.kiri{
        text-align: left;
    }

    @keyframes blinker {  
        50% { opacity: 0; }
    }
</style>
<ol class="breadcrumb bc-3" style="margin-top:-30px;">
    <li>
        <a href="javascript:void(0)">
            <i class="glyphicon glyphicon-home"></i>
            Admin
        </a>
    </li>
    <li><a href="javascript:void(0)">Kuantitas</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <button class="btn btn-info" onclick="tambah_kuantitas()">Input</button>
    </div>
    <div style="float: right;">
        <table style="font-size: 12px;">
            <tr>
                <td>Kuantitas</td>
                <td>
                    <input type="text" class="form-control" id="kuantitas">
                </td>
                <td><button class="btn btn-primary btn-lg fa fa-search-plus" onclick="refresh_kuantitas()" >Cari</button></td>
            </tr>
        </table>
    </div>
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Satuan Kuantitas</th>
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
            "url": "<?php echo site_url('admin/c_kuantitas/ajax_list') ?>",
            "type": "POST",
            "data": function (d) {
                d.kuantitas = $('#kuantitas').val();
            }
        }, scrollY: 230, "scrollX": true,
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, {
                className: "dt-center",
                "targets": [1], "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css('text-align', 'left');
                }
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [2]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [3]
            }
        ],
    });
    function refresh_kuantitas() {
        table.ajax.reload();
    }

    function tambah_kuantitas() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_kuantitas/tambah');
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
    function ubah_kuantitas(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_kuantitas/ubah' + '/' + id);
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

    function hapus_kuantitas(id) {
        var r = confirm("Yakin ingin menghapus Kuantitas ini ?");
        if (r) {
            $.post('admin/c_kuantitas/hapus_kuantitas', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    alert('Kuantitas berhasil dihapus');
                    refresh_kuantitas();
                }
            });
        }
    }
</script>
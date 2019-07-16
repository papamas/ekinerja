
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
    <li><a href="javascript:void(0)">Spesimen Lokasi</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <button class="btn btn-info" onclick="tambah_spesimen()">Tambah Spesimen</button>
      
    </div>
    
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Lokasi</th>
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
            "url": "<?php echo site_url('admin/c_spesimen/ajax_list') ?>",
            "type": "POST",
            "data": function (d) {
                d.nip = $('#nip').val();
                d.nama = $('#nama').val();
            }
        }, scrollY: 270, "scrollX": true,
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, {
                className: "dt-center", "width": "10%",
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
    function refresh_spesimen() {
        table.ajax.reload();
    }

    function tambah_spesimen() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_spesimen/tambah');
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
    function ubah_spesimen(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_spesimen/ubah' + '/' + id);
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
    function detail_spesimen(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_spesimen/detail' + '/' + id);
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

    function hapus_spesimen(id) {
        var r = confirm("Yakin ingin menghapus Lokasi ini ?");
        if (r) {
            $.post('admin/c_spesimen/hapus_spesimen', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    alert('Lokasi Spesimen berhasil dihapus');
                    refresh_spesimen();
                }
            });
        }
    }
</script>
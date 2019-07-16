
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
<ol class="breadcrumb bc-3" style="margin-top:-60px;">
    <li>
        <a href="javascript:void(0)">
            <i class="glyphicon glyphicon-home"></i>
            Admin
        </a>
    </li>
    <li><a href="javascript:void(0)">Sasaran Strategis</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <input type="hidden" id="id" value="<?=$id?>">
        <button class="btn btn-info" onclick="tambah_sasaran(<?=$id?>)">Tambah Sasaran Strategis</button>
    </div>

    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Sasaran Strategis</th>
                <th>Edit</th>
                <th>Hapus</th>
                <th>IKU & IKK</th>
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
            "url": "<?php echo site_url('admin/c_rkt/ajax_list_detail') ?>",
            "type": "POST",
            "data": function (d) {
                d.id = $('#id').val();
//                d.tahun = $('#tahun').val();
            }
        }, "scrollX": true,
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
                className: "dt-center ", "orderable": false,"width": "10%",
                "targets": [2]
            }, {
               className: "dt-center", "orderable": false,"width": "10%",
                "targets": [3]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [4]
            }
          
        ],
    });
    function refresh_sasaran() {
        table.ajax.reload();
    }

    function tambah_sasaran(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_rkt/tambah_sasaran/'+id);
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
    function ubah_sasaran(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_rkt/ubah_sasaran' + '/' + id);
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
    function detail_kegiatan_unit(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_kegiatan_unit/detail' + '/' + id);
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

function hapus_sasaran(id) {
        var r = confirm("Yakin ingin menghapus sasaran strategis ini ?");
        if (r) {
            $.post('admin/c_rkt/hapus_sasaran', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    alert('Sasaran strategis berhasil dihapus');
                    refresh_sasaran();
                }
            });
        }
    }
</script>
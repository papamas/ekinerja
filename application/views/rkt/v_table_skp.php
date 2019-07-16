
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
    <li><a href="javascript:void(0)">Rencana Kerja Tahunan</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <button class="btn btn-info" onclick="tambah_kegiatan_rkt()">Tambah Unit</button>
    </div>
    <div style="float:right;">
        <span>
            <table>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="unit" placeholder="Unit Kerja">
                    </td>
                    <td>
                        <input type="text" class="form-control" id="tahun" placeholder="Tahun">
                    </td>
                    <td>
                        <button class="btn btn-info" onclick="refresh_kegiatan_unit()">Cari</button>
                    </td> 
                </tr>
            </table>
        </span>
    </div>

    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tahun</th>
                <th>Kode Unit</th>
                <th>Unit</th>
                <th>Hapus</th>
                <th>Data RKT</th>
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
            "url": "<?php echo site_url('admin/c_rkt/ajax_list') ?>",
            "type": "POST",
            "data": function (d) {
                d.unit = $('#unit').val();
                d.tahun = $('#tahun').val();
            }
        }, "scrollX": true,
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, {
                className: "dt-center", "width": "10%",
                "targets": [1]
            }, {
                className: "dt-center ", "orderable": false,"width": "10%",
                "targets": [2], "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css('text-align', 'left');
                }
            }, {
               className: "dt-center", "orderable": false,
                "targets": [3]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [4]
            }
            , {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [5]
            }
        ],
    });
    function refresh_kegiatan_rkt() {
        table.ajax.reload();
    }

    function tambah_kegiatan_rkt() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_rkt/tambah');
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_WIDE);
        dialog.open();
    }
    function ubah_kegiatan_unit(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_kegiatan_unit/ubah' + '/' + id);
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

function hapus_rkt(id) {
        var r = confirm("Yakin ingin menghapus Unit RKT ini ?");
        if (r) {
            $.post('admin/c_rkt/hapus_rkt', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    alert('Unit RKT berhasil dihapus');
                    refresh_kegiatan_rkt();
                }
            });
        }
    }
</script>
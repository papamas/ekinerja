
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
    <li><a href="javascript:void(0)">Kegiatan Jabatan</a></li>
    <li><a href="javascript:void(0)">Detail </a></li>
</ol>
<h4 style="text-align: center;"><?= $jabatan['jabatan'] ?></h4>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <button class="btn btn-info" onclick="tambah_kegiatan(<?= $id ?>)">Input Kegiatan</button>
    </div>
    <div style="float:right;">
        <span>
            <table>
                <tr>
                    <td>
                        <input type="hidden" class="form-control" id="id" value="<?= $id ?>">
                        <input type="text" class="form-control" id="nama" placeholder="Kegiatan Jabatan">
                    </td>
                    <td>
                        <button class="btn btn-info" onclick="refresh_kegiatan()">Cari</button>
                    </td> 
                </tr>
            </table>
        </span>
    </div>

    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Butir Kegiatan Jabatan</th>
                <th>Satuan Hasil</th>
                <th>Angka Kredit</th>
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
            "url": "<?php echo site_url('admin/c_kegiatan_jabatan/ajax_list_detail') ?>",
            "type": "POST",
            "data": function (d) {
                d.id = $('#id').val();
              
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
                "targets": [1]
            }, {
                className: "dt-center ", "orderable": false, "width": "10%",
                "targets": [2], "createdCell": function (td, cellData, rowData, row, col) {
                    $(td).css('text-align', 'left');
                }
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
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
    function refresh_kegiatan() {
        table.ajax.reload();
    }

    function tambah_kegiatan(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_kegiatan_jabatan/tambah_detail/'+id);
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
    function ubah_kegiatan(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_kegiatan_jabatan/ubah_detail' + '/' + id);
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

    function hapus_kegiatan(id) {
        var r = confirm("Yakin ingin menghapus Kegiatan Jabatan ini ?");
        if (r) {
            $.post('admin/c_kegiatan_jabatan/hapus_kegiatan_jabatan_detail', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    alert('Kegiatan Jabatan berhasil dihapus');
                    refresh_kegiatan();
                }
            });
        }
    }
</script>
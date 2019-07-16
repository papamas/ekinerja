
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
    <li><a href="javascript:void(0)">Indikator Kinerja Utama & Kegiatan</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <input type="hidden" id="id" value="<?= $id ?>">
        <button class="btn btn-info" onclick="tambah_iku(<?= $id ?>)">Tambah IKU</button>
    </div>

    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Indikator Kinerja Utama (IKU)</th>
                <th>Target</th>
                <th>Edit</th>
                <th>Hapus</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<div style="padding:10px;">
    <div style="float:left;">
        <input type="hidden" id="id" value="<?= $id ?>">
        <button class="btn btn-info" onclick="tambah_ikk(<?= $id ?>)">Tambah IKK</button>
    </div>

    <table id="table2" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Indikator Kinerja Kegiatan (IKK)</th>
                <th>Target</th>
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
    var table2;
    table = $('#table').DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/c_rkt/ajax_list_ik') ?>",
            "type": "POST",
            "data": function (d) {
                d.id = $('#id').val();
                d.flag = 1;
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
                className: "dt-center ", "orderable": false, "width": "10%",
                "targets": [2]
            }, {
                className: "dt-center", "orderable": false, "width": "10%",
                "targets": [3]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [4]
            }

        ],
    });

    table2 = $('#table2').DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/c_rkt/ajax_list_ik') ?>",
            "type": "POST",
            "data": function (d) {
                d.id = $('#id').val();
                d.flag = 0;
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
                className: "dt-center ", "orderable": false, "width": "10%",
                "targets": [2]
            }, {
                className: "dt-center", "orderable": false, "width": "10%",
                "targets": [3]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [4]
            }

        ],
    });
    function refresh_iku() {
        table.ajax.reload();
    }

    function refresh_ikk() {
        table2.ajax.reload();
    }

    function tambah_iku(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_rkt/tambah_ik/' + id + '/1');
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

    function tambah_ikk(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_rkt/tambah_ik/' + id + '/0');
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

    function edit_ik(id,flag) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('admin/c_rkt/ubah_ik' + '/' + id+ '/' + flag);
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


    function hapus_ik(id, flag) {
        var r = confirm("Yakin ingin menghapus Indikator Kinerja ini ?");
        if (r) {
            $.post('admin/c_rkt/hapus_ik', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    alert('Indikator Kinerja berhasil dihapus');
                    if (flag == 1) {
                        refresh_iku();
                    } else {
                        refresh_ikk();
                    }
                }
            });
        }
    }
</script>
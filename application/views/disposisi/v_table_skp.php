
<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    } td.blink_me {
        animation: blinker 1s linear infinite;
    }

    @keyframes blinker {  
        50% { opacity: 0; }
    }
</style>
<ol class="breadcrumb bc-3" style="margin-top:-30px;">
    <li>
        <a href="javascript:void(0)">
            <i class="glyphicon glyphicon-home"></i>
            SKP
        </a>
    </li>
    <li><a href="javascript:void(0)">Disposisi</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <button class="btn btn-info" onclick="tambah_disposisi()">Input</button>
    </div>
    <div style="float: right;">
        <table style="font-size: 12px;">
            <tr>
                <td>Periode</td>
                <td>
                    <select class="form-control" id="tahun">
                        <option value="all">all</option>
                        <?php foreach ($tahun as $arr) { ?>
                            <option value="<?= $arr['tahun'] ?>" <?= $arr['tahun'] == (int) date('Y') ? 'selected' : '' ?>><?= $arr['tahun'] ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><button class="btn btn-primary btn-lg fa fa-search-plus" onclick="refresh_disposisi()" >Cari</button></td>
            </tr>
        </table>
    </div>
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Bawahan</th>
                <th>NIP</th>
                <th>Tgl Disposisi</th>
                <th>Kegiatan</th>
                <th>Waktu Pengerjaan (Deadline)</th>
                <th>Status Waktu</th>
                <th>Status Pekerjaan (Bawahan)</th>
                <th>Status Pekerjaan (Atasan)</th>
                <th>Edit</th>
                <th>Edit Status Pekerjaan</th>
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
            "url": "<?php echo site_url('c_disposisi/ajax_list') ?>",
            "type": "POST",
            "data": function (d) {
                d.tahun = $('#tahun').val();
            }
        }, scrollY: 230, "scrollX": true,
        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, {
                "width": "10%", className: "dt-center",
                "targets": [1]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [2]
            }, {
                className: "dt-center", "orderable": false,
                "targets": [3]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [4]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [5]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [6],
                "createdCell": function (td, cellData, rowData, row, col) {
                    if (cellData == '3 Hari Sebelum Deadline' || cellData == '2 Hari Sebelum Deadline' || cellData == '1 Hari Sebelum Deadline' || cellData == 'Deadline Hari Ini' || cellData == 'Melewati Deadline') {
                        $(td).addClass('blink_me');
                        $(td).css('color', 'red');
                        $(td).css('font-weight', 'bold');
                    }
                    if (cellData == '0') {

                    }
                }
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [7],
                "createdCell": function (td, cellData, rowData, row, col) {
                    if (cellData == "Selesai Dilaksanakan") {
                        $(td).css('background', 'green');
                        $(td).css('color', 'white');
                    } else if (cellData == "Dalam Pengerjaan") {
                        $(td).css('background', 'blue');
                        $(td).css('color', 'white');
                    }
                }
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [8],
                "createdCell": function (td, cellData, rowData, row, col) {
                    if (cellData == "Selesai Dilaksanakan") {
                        $(td).css('background', 'green');
                        $(td).css('color', 'white');
                    } else if (cellData == "Tidak Dilaksanakan") {
                        $(td).css('background', 'red');
                        $(td).css('color', 'white');
                    } else if (cellData == "Dilaksanakan Melewati Deadline") {
                        $(td).css('background', 'orange');
                        $(td).css('color', 'white');
                    } else {
                        $(td).css('background', 'white');
                        $(td).css('color', 'white');
                    }
                }
            }
            ,
            {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [9]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [10]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [11]
            },
        ],
    });
    function refresh_disposisi() {
        table.ajax.reload();
    }

    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    function tambah_disposisi() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_disposisi/tambah');
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
    function ubah_disposisi(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_disposisi/ubah' + '/' + id);
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

    function ubah_status(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_disposisi/ubah_status' + '/' + id);
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

    function hapus_disposisi(id) {
        var r = confirm("Yakin ingin menghapus Disposisi ini ?");
        if (r) {
            $.post('c_disposisi/hapus_disposisi', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    refresh_produktivitas();
                }
            });
        }
    }
</script>
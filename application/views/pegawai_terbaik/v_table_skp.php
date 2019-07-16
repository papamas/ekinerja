
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
            Admin
        </a>
    </li>
    <li><a href="javascript:void(0)">Pegawai Terbaik</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float:left;">
        <table>
            <tr>
                <td>Bulan</td>
                <td>
                    <select class="form-control" id="bulan">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == date('m') ? 'selected' : '' ?>><?= bulan($i) ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select class="form-control" id="tahun">
                        <?= pilihan_list($dt_tahun, 'tahun', 'tahun', date('Y')) ?>
                    </select></td>
                <td> <button onclick="refreshData()" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i>Cari</button></td>
            </tr>
        </table>
    </div>
    <div style="float: right;">

    </div>
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Nilai SKP Bulanan</th>
                <th>Jumlah Kegiatan Harian SKP</th>
                <th>Jumlah Tugas Tambahan</th>
                <th>Jumlah Produktivitas</th>
                <th>Jumlah Tugas Tambahan Disposisi</th>
                <th>Pilih Pegawai Terbaik</th>
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
            "url": "<?php echo site_url('admin/c_pegawai_terbaik/ajax_list') ?>",
            "type": "POST",
            "data": function (d) {
                d.bulan = $('#bulan').val();
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
                className: "dt-center",
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
                "targets": [6]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [7]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [8]
            }],

    });

    function refreshData() {
        table.ajax.reload();
    }

    function update(id, tahun, bulan) {
        $.post('admin/c_pegawai_terbaik/update', {id: id, tahun: tahun, bulan: bulan}, function (data) {
            if (data == 'ok') {
                refreshData();
            }
        });
//        alert(id);
    }
</script>
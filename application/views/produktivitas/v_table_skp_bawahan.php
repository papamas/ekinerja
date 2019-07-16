
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
    <li><a href="javascript:void(0)">Non SKP</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
   
    <div style="float: right;">
        <table style="font-size: 12px;">
            <tr>
                <td>
                    <select class="form-control" id="id_dd_user">
                        <?= pilihan_list($dt_user, 'nama', 'id_dd_user',  "")?>
                    </select>
                </td>
                <td>
                    <select class="form-control" id="bulan">
                        <option value="all">all</option>
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == (int) date('m') ? 'selected' : '' ?>><?= bulan($i) ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td>
                    <select class="form-control" id="tahun">
                        <option value="all">all</option>
                        <?php foreach ($tahun as $arr) { ?>
                            <option value="<?= $arr['tahun'] ?>" <?= $arr['tahun'] == (int) date('Y') ? 'selected' : '' ?>><?= $arr['tahun'] ?></option>
                        <?php } ?>
                    </select>
                </td>
                <td><button class="btn btn-primary btn-lg fa fa-search-plus" onclick="refresh_produktivitas()" >Cari</button></td>
            </tr>
        </table>
    </div>
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama Bawahan</th>
                <th>NIP</th>
                <th>Keg. Non SKP</th>
                <th>Kuantitas</th>
                <th>Jam Mulai</th>
                <th>Jam Selesai</th>
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
            "url": "<?php echo site_url('c_produktivitas/ajax_list_bawahan') ?>",
            "type": "POST",
            "data": function (d) {
                d.tahun = $('#tahun').val();
                d.bulan = $('#bulan').val();
                d.nama = $('#id_dd_user').val();
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
                "width": "20%", className: "dt-center", "orderable": false,
                "targets": [2]
            }, {
                 "width": "15%",className: "dt-center", "orderable": false,
                "targets": [3]
            }, {
                "width": "5%", className: "dt-center", "orderable": false,
                "targets": [4]
            }, {
                "width": "5%", className: "dt-center", "orderable": false,
                "targets": [5]
            },
        ],

    });

    function refresh_produktivitas() {
        table.ajax.reload();
    }

</script>
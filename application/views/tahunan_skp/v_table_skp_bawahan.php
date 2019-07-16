
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
    <li><a href="javascript:void(0)">Tahunan Bawahan</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    <div style="float: right;">
        <table>
            <tr>
                <td><input type="text" id="tahunan_skp" class="form-control" placeholder="Tahun"></td>
                <td> <button onclick="cariSKP()" class="btn btn-primary"><i class="glyphicon glyphicon-search"></i>Cari</button></td>
            </tr>
        </table>

    </div>
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Realisasi</th>
                <th>Nama</th>
                <th>Periode</th>
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
            "url": "<?php echo site_url('c_tahunan_skp/ajax_list_bawahan') ?>",
            "type": "POST",
            "data": function (d) {
                d.status = $('#tahunan_skp').val();
            }
        }, scrollY: 230, "scrollX": true,

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0]//first column / numbering column
               , //set not orderable
            }, {
               "width": "5%", className: "dt-center", "orderable": false,
                "targets": [1]
            }, {
                 className: "dt-center", "orderable": true,
                "targets": [2]
            }, {
                "width": "15%", className: "dt-center", "orderable": false,
                "targets": [3]
            }
        ],

    });

    function cariSKP() {
        table.ajax.reload();
    }

    function realisasi_bawahan(id) {
        menu('c_atasan/realisasi_bawahan' + '/' + id);
    }
</script>
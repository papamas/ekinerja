
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
            Atasan
        </a>
    </li>
    <li><a href="javascript:void(0)">Staff Bawahan</a></li>
</ol>
<div style="padding:10px;margin-top:-30px;">
    
    <table id="table" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Jabatan</th>
                <th>Drop</th>
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
            "url": "<?php echo site_url('c_staff_bawahan/ajax_list') ?>",
            "type": "POST",
            "data": function (d) {
                d.tahun = $('#tahun').val();
                d.bulan = $('#bulan').val();
            }
        }, scrollY: 230, "scrollX": true,

        //Set column definition initialisation properties.
        "columnDefs": [
            {
                "width": "3%", className: "dt-center",
                "targets": [0], //first column / numbering column
                "orderable": false, //set not orderable
            }, {
                "width": "30%", className: "dt-center",
                "targets": [1]
            }, {
                "width": "20%", className: "dt-center", "orderable": false,
                "targets": [2]
            }, {
                className: "dt-center", "orderable": false,
                "targets": [3]
            }, {
                "width": "10%", className: "dt-center", "orderable": false,
                "targets": [4]
            },
        ],

    });

    function refresh_staff_bawahan() {
        table.ajax.reload();
    }

    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    function drop_staff_bawahan(id) {
        var r = confirm("Yakin ingin mendrop staff bawahan ini ?");
        if (r) {
            $.post('c_atasan/drop_staff_bawahan', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                  refresh_staff_bawahan();
                }
            });
        }
    }
</script>
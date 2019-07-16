
<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    }
</style>
<h4 style="text-align: center;margin-bottom: 40px;">Bulan <?= bulan($bulan) . ' ' . $tahun ?></h4>
<div style="margin-top:-30px;">
    <table id="table3" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>NIP</th>
                <th>Unit</th>
                <th>Status</th>
                <th>Lokasi</th>

            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<input type="hidden" id="startData">
<input type="hidden" id="maxData">
<script type="text/javascript">
    var table3;
    table3 = $('#table3').on('xhr.dt', function (e, settings, json, xhr) {
        $('#startData').val(json.mulai);
        $('#maxData').val(json.sampai);
    }).DataTable({
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/c_fitur/ajax_list3') ?>",
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
            }],

    });

    function refreshData() {
        table3.ajax.reload();
    }
   function turun() {
        var min = $('#startData').val() + 5;
        var max = $('#maxData').val();
        var prosesTurun = setInterval(function () {
            if (min != max) {
                $(".dataTables_scrollBody").scrollTo('.c' + min);
            } else {
                clearInterval(prosesTurun);
                 lihat_laporan();
            }
            min++;
        }, 1000);

    }

    function naik() {
        var min = $('#startData').val();
        var max = $('#maxData').val()-5;
        var prosesNaik = setInterval(function () {
            if (min != max) {
                $(".dataTables_scrollBody").scrollTo('.c' + max);
            } else {
                clearInterval(prosesNaik);
                turun();
            }
            max--;
        }, 1000);
    }


</script>
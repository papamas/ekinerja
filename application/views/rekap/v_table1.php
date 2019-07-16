
<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    }.pilih{
	background:red !important;color:white;
	}
</style>
<h4 style="text-align: center;margin-bottom: 40px;">Bulan <?= bulan($bulan) . ' ' . $tahun ?></h4>

<div style="margin-top:-30px;">
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
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<input type="hidden" id="startData">
<input type="hidden" id="maxData">
<input type="hidden" id="idInterval">
<script type="text/javascript">

    var table;
    table = $('#table').on('xhr.dt', function (e, settings, json, xhr) {
        $('#startData').val(json.mulai);
        $('#maxData').val(json.sampai);
    }).DataTable({
        "scrollX": true,
        "animate": true, scrollCollapse:true,
        "lengthChange": false, "pageLength": 50, scrollY: 320,
        "searching": false,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/c_fitur/ajax_list1') ?>",
            "type": "POST",
            "data": function (d) {
                d.bulan = $('#bulan').val();
                d.tahun = $('#tahun').val();
            }
        },
        "fnInitComplete": function (oSettings, json) {
            turun();
//            $("html, body").animate({scrollTop: $(document).height()}, 50000);
        }, fnRowCallback: function (nRow, aData, iDisplayIndex, iDisplayIndexFull) {
            $(nRow).addClass("c" + aData[0]);
//            $('#maxData').val(aData[0]);
        },

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
            }],

    });

    function refreshData() {
        table.ajax.reload();
    }

    function turun() {
	    var min = parseInt($('#startData').val()) ;
        var max = parseInt($('#maxData').val());
		ClearAllIntervals();
	    var prosesTurun = setInterval(function () {
		if (min > max) {
		lihat_laporan();
               
            } else {
			 var selection = $('.c' + min );
             $(".dataTables_scrollBody").scrollTo('.c' + min);
			  $("tr[role='row']").removeClass("pilih");
				selection.addClass("pilih");
				min++;				 
            }
        
			//console.log(min+'-'+max);
	//	console.log(min);
	//	console.log('id interval '+prosesTurun);
        }, 1000);
		$('#idInterval').val(prosesTurun);
       
    }

    function naik() {
        var min = $('#startData').val();
        var max = $('#maxData').val() - 5;
        var prosesNaik = setInterval(function () {
            if (min != max) {
                $(".dataTables_scrollBody").scrollTo('.c' + max);
            } else {
                clearInterval(prosesNaik);
				 refreshData();
                turun();
				
            }
            max--;
        }, 1000);

    }

function ClearAllIntervals() {
    for (var i = 1; i < 99999; i++)
        window.clearInterval(i);
}
</script>
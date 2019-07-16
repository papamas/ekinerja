
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
    }.dataTables_length{display:none;}
</style>
<h4 style="text-align: center;"><?= 'JABATAN ' . strtoupper($jabatan['jabatan']) ?></h4>
<div style="padding:10px;margin-top:-10px;">
    <div style="float:right;">
        <span>
            <table>
                <tr>
                    <td>
                        <input type="text" class="form-control" id="nama" placeholder="Kegiatan">
                    </td>
                    <td>
                        <button class="btn btn-info" onclick="refresh_2()">Cari</button>
                    </td> 
                </tr>
            </table>
        </span>
    </div>

    <table id="table_kegiatan" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>No</th>
                <th>Butir Kegiatan Jabatan</th>
                <th>Satuan Hasil</th>
                <th>Angka Kredit</th>
                <th>Salin</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>
<script type="text/javascript">
    var tbl2;
    tbl2 = $('#table_kegiatan').DataTable({
        "searching": false, "paging": true,  "pageLength": 5,
        "processing": true, //Feature control the processing indicator.
        "serverSide": true, //Feature control DataTables' server-side processing mode.
        "order": [], //Initial no order.

        // Load data for the table's content from an Ajax source
        "ajax": {
            "url": "<?php echo site_url('admin/c_kegiatan_jabatan/ajax_list_detail2') ?>",
            "type": "POST",
            "data": function (d) {
                d.jabatan = $('#nama').val();

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

        ],
    });

    function refresh_2() {
        tbl2.ajax.reload();
    }

    function copy_kegiatan(id) {
        $.post('admin/c_kegiatan_jabatan/get_detail', {id: id}, function (data) {
            var x = JSON.parse(data);
            var kegiatan = x[0].kegiatan_jabatan;
            var satuan = x[0].satuan_hasil;
			var angka_kredit = x[0].id_opmt_detail_kegiatan_jabatan;
			
            $('#kegiatan_tahunan').html(kegiatan);
            $('#satuan_kuantitas').val(satuan);
			$('#id_opmt_detail_kegiatan_jabatan').val(angka_kredit);
        });
    }
</script>
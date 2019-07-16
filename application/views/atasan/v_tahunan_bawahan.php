<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_tahunan_bawahan thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_tahunan_bawahan td{
        border:solid 1px black;
    }.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>

<div id="toolbar2" style="margin-top:-20px;">
    <table style="font-size: 12px;">
        <tr>
            <td>Nama Bawahan</td>
            <td><input type="text" class="form-control" id="nama"></td>
            <td>Tahun</td>
            <td><input type="text" class="form-control" id="tahun"></td>
            <td><button class="btn btn-info" onclick="refresh_bawahan()">Cari</button></td>
    </table>
</div>

<table id="tbl_tahunan_bawahan" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true"></table>

<script>

    function realisasi_bawahan(id) {
        menu('c_atasan/realisasi_bawahan' + '/' + id);
    }

    $('#tbl_tahunan_bawahan').bootstrapTable({
        url: '<?= base_url('c_atasan/dt_tahunan_bawahan') ?>',
        queryParams: function (p) {
            return{
                nama: $('#nama').val(),
                tahun: $('#tahun').val(),
                search: p.search,
                limit: p.limit,
                offset: p.offset,
                order: p.order,
                sort: p.sort
            };
        },
        columns: [
            {
                field: 'no', title: 'No', halign: 'center', class: 'tengah', valign: 'middle'
            },
            {
                field: 'nama', title: 'Nama Bawahan', class: 'tengah', valign: 'middle', halign: 'center'
            }, {
                field: 'periode', title: 'Periode SKP', class: 'tengah', valign: 'middle', halign: 'center'
            },
            {
                field: 'link_realisasi', title: 'Realisasi', class: 'tengah', valign: 'middle', halign: 'center'
            },
        ],
        pagination: true, clickToSelect: true,
        sortable: true, striped: true,
        sidePagination: 'server',
        searchOnEnterKey: true, search: false,
        checkbox: true
        , responseHandler: function (res) {
            $('#loading_time').html('Loaded in ' + res.lama + ' detik');
            return res;
        },
        onLoadSuccess: function (a) {
            return false;
        }
    });

    function refresh_bawahan() {
        $('#tbl_tahunan_bawahan').bootstrapTable('refresh');
    }
</script>
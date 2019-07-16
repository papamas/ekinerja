<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_bulanan_bawahan thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_bulanan_bawahan td{
        border:solid 1px black;
    }.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>
<div class="row">
    <div class="col-md-8" style="margin-bottom:-20px;">
        <table class="table">
            <tr>
                <td style="vertical-align: middle;width:100px;">Nama Bawahan</td>
                <td><input type="text" class="form-control" id="nama"></td>
                <td style="vertical-align: middle;">Bulan</td>
                <td>
                    <select class="form-control" id="bulan">
                        <?php for ($i = 1; $i <= 12; $i++) { ?>
                            <option value="<?= $i ?>" <?= $i == date('m') ? 'selected' : '' ?>><?= date('F', strtotime('2017-' . $i . '-01')) ?></option>
                        <?php } ?>
                    </select>    
                </td>
                <td style="vertical-align: middle;">Tahun</td>
                <td>
                    <select class="form-control" id="tahun">
                        <option value="<?= date('Y') ?>"><?= date('Y') ?></option>
                    </select>
                </td>
                <td><button class="btn btn-success" onclick="refresh_bulanan_bawahan()">Cari</button></td>
            </tr>
        </table>
    </div>
    <table id="tbl_bulanan_bawahan" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">
    </table>
</div>


<script>
    $('#tbl_bulanan_bawahan').bootstrapTable({
        url: '<?= base_url('c_bulanan_skp/dt_bulanan_bawahan') ?>',
        queryParams: function (p) {
            return{
                bulan: $('#bulan').val(),
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
                field: 'bulan', title: 'Bulan', class: 'tengah', valign: 'middle', halign: 'center'
            },
            {
                field: 'tahun', title: 'Tahun', class: 'tengah', valign: 'middle', halign: 'center'
            },

            {
                field: 'status_approve', title: 'Status Approve', class: 'tengah', valign: 'middle', halign: 'center'
            },

            {
                field: 'nama', title: 'Nama Bawahan', halign: 'center', class: 'tengah', valign: 'middle'
            },
            {
                field: 'link_kualitas', title: 'Nilai Kualitas Bawahan', halign: 'center', class: 'tengah', valign: 'middle'
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

    function refresh_bulanan_bawahan() {
        $('#tbl_bulanan_bawahan').bootstrapTable('refresh');
    }

    function realisasi_bulanan(id) {
        menu('c_atasan/realisasi_bulanan_bawahan' + '/' + id);
    }
</script>
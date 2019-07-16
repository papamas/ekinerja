<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_harian_skp_bawahan thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_harian_skp_bawahan td{
        border:solid 1px black;
    }.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>
<table id="tbl_utama_skp_harian">
    <tr>
        <td>Nama Bawahan</td>
        <td><input type="text" class="form-control" id="nama"></td>

        <td>Bulan</td>
        <td>
            <select class="form-control" id="bulan">
                <option value="all">-all-</option>
                <?php for ($i = 1; $i <= 12; $i++) { ?>
                    <option value="<?= $i ?>"><?= bulan($i) ?></option>
                <?php } ?>
            </select>
        </td>
        <td>Tahun</td>
        <td><select class="form-control" id="tahun">
                <option value="all">-all-</option>
                <?php foreach ($tahun as $arr) { ?>
                    <option value="<?= $arr['tahun'] ?>"><?= $arr['tahun'] ?></option>
                <?php } ?>
            </select>
        </td>
        <td>
            <button class="btn btn-primary" onclick="refresh_harian()">Cari</button>
        </td>
    </tr>
</table>

<table id="tbl_harian_skp_bawahan" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true"></table>

<script>

    function lihat_harian(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_atasan/lihat_harian_skp' + '/' + id);
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

    $('#tbl_harian_skp_bawahan').bootstrapTable({
        url: '<?= base_url('c_atasan/dt_harian_skp') ?>',
        queryParams: function (p) {
            return{
                thn: $('#bulan').val(),
                bln: $('#tahun').val(),
                nama: $('#nama').val(),
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
                field: 'tanggal', title: 'Tanggal', class: 'tengah', valign: 'middle', halign: 'center'
            }, {
                field: 'nama', title: 'Nama', class: 'tengah', valign: 'middle', halign: 'center'
            },
            {
                field: 'kegiatan_harian_skp', title: 'Kegiatan Harian SKP', class: 'tengah', valign: 'middle', halign: 'center'
            },
            {
                field: 'skp_bulanan', title: 'SKP Bulanan', class: 'tengah', valign: 'middle', halign: 'center'
            },
            {
                field: 'kuantitas', title: 'Kuantitas', class: 'tengah', valign: 'middle', halign: 'center'
            },

            {
                field: 'link_detail', title: 'View Detail', halign: 'center', class: 'tengah', valign: 'middle'
            }
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

    function refresh_harian() {
        $('#tbl_harian_skp_bawahan').bootstrapTable('refresh');
    }

</script>
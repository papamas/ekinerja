<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_harian_skp thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_harian_skp td{
        border:solid 1px black;
    }.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>
<div style="float:left;">
    <button class="btn btn-info" onclick="tambah_harian_skp()">Input Laporan Harian Kinerja SKP</button>
</div>
<div style="float:right">
    <table style="font-size: 12px;">
        <tr>
            <td>Periode</td>
            <td>
                <select class="form-control" id="bulan">
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
            <td><button class="btn btn-primary fa fa-search-plus" onclick="refresh_harian_skp()" >Cari</button></td>
        </tr>
    </table>
</div>
<table id="tbl_harian_skp" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    function tambah_harian_skp() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/tambah_harian_skp');
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


    $('#tbl_harian_skp').bootstrapTable({
        url: '<?= base_url('C_user/dt_harian_skp') ?>',
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
                field: 'tanggal', title: 'Tanggal', class: 'tengah', valign: 'middle', halign: 'center'
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
                field: 'link_edit', title: 'Edit', halign: 'center', class: 'tengah', valign: 'middle'
            },
            {
                field: 'link_hapus', title: 'Hapus', halign: 'center', class: 'tengah', valign: 'middle'
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

    function refresh_harian_skp() {
        $('#tbl_harian_skp').bootstrapTable('refresh');
    }

    function hapus_harian(id) {
        var r = confirm("Yakin ingin menghapus realisasi Harian SKP ini ?");
        if (r) {
            $.post('C_user/hapus_harian', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    harian_skp();
                }
            });
        }
    }

    function ubah_harian(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/ubah_harian_skp' + '/' + id);
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
</script>
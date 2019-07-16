<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_kreatifitas thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_kreatifitas td{
        border:solid 1px black;
    }.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>
<div style="float:left;">
    <button class="btn btn-info" onclick="tambah_kreatifitas()">Input</button>
</div>
<div style="float:right">
    <table style="font-size: 12px;">
        <tr>
            <td>Periode</td>
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
            <td><button class="btn btn-primary fa fa-search-plus" onclick="refresh_kreatifitas()" >Cari</button></td>
        </tr>
    </table>
</div>
<table id="tbl_kreatifitas" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    $('.tanggal').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
    });
    function tambah_kreatifitas() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/tambah_kreatifitas');
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

    $('#tbl_kreatifitas').bootstrapTable({
        url: '<?= base_url('C_user/dt_kreatifitas') ?>',
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
                field: 'kreatifitas', title: 'Kreatifitas', class: 'tengah', valign: 'middle', halign: 'center'
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

    function refresh_kreatifitas() {
        $('#tbl_kreatifitas').bootstrapTable('refresh');
    }
    function hapus_kreatifitas(id) {
        var r = confirm("Yakin ingin menghapus kreatifitas tambahan ini ?");
        if (r) {
            $.post('C_user/hapus_kreatifitas', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    menu('C_user/kreatifitas')
                }
            });
        }
    }

    function ubah_kreatifitas(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/ubah_kreatifitas' + '/' + id);
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
<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_tugas_tambahan thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_tugas_tambahan td{
        border:solid 1px black;
    }.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>
<div style="float:left;">
    <button class="btn btn-info" onclick="tambah_tugas_tambahan()">Input</button>
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
            <td><button class="btn btn-primary fa fa-search-plus" onclick="refresh_tugas_tambahan()">Cari</button></td>
        </tr>
    </table>
</div>
<table id="tbl_tugas_tambahan" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true"></table>

<script>

    $('#tbl_tugas_tambahan').bootstrapTable({
        url: '<?= base_url('C_user/dt_tugas_tambahan') ?>',
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
            }, {
                field: 'tugas_tambahan', title: 'Tugas Tambahan', class: 'tengah', valign: 'middle', halign: 'center'
            },

            {
                field: 'kuantitas', title: 'Kuantitas', class: 'tengah', valign: 'middle', halign: 'center'
            },
            {
                field: 'link_edit', title: 'Edit', halign: 'center', class: 'tengah', valign: 'middle'
            },
            {
                field: 'link_hapus', title: 'Edit', halign: 'center', class: 'tengah', valign: 'middle'
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


    function tambah_tugas_tambahan() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/tambah_tugas_tambahan');
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
    function refresh_tugas_tambahan() {
        $('#tbl_tugas_tambahan').bootstrapTable('refresh');
    }

    function hapus_tugas_tambahan(id) {
        var r = confirm("Yakin ingin menghapus tugas tambahan ini ?");
        if (r) {
            $.post('C_user/hapus_tugas_tambahan', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    menu('C_user/tugas_tambahan')
                }
            });
        }
    }

    function ubah_tugas_tambahan(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/ubah_tugas_tambahan' + '/' + id);
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
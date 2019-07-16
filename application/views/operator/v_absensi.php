<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_absensi thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_absensi td{
        border:solid 1px black;
    }.judul{font-weight: bold;}
</style>

<button class="btn btn-primary" onclick="tbh_absensi()">Tambah Data Absensi Pegawai</button>
<div id="toolbar2">
    <table class="table" style="width:800px;vertical-align: middle;">
        <tr>
            <td valign="middle">Bulan</td>
            <td>
                <?php
                $tahun = date('Y');
                $bulan = (int) date('m');
                ?>
                <select class="form-control" id="bln">
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value = "<?= $i ?>" <?= $i == $bulan ? 'selected' : ''; ?>><?= bulan($i) ?></option>
                    <?php }
                    ?>
                </select>
            </td>
            <td>Tahun</td>
            <td>
                <select class="form-control" id="thn">
                    <?php for ($i = 2015; $i <= 2020; $i++) { ?>
                        <option value = "<?= $i ?>" <?= $i == $tahun ? 'selected' : ''; ?>><?= $i ?></option>
                    <?php }
                    ?>
                </select>
            </td>
            <td>Unit</td>
            <td>
                <select class="form-control" id="unit">
                    <?php foreach ($unit as $arr) { ?>
                        <option value = "<?= $arr['id_dd_uker'] ?>"><?= $arr['nama_uker'] ?></option>
                    <?php }
                    ?>
                </select>

            </td>
            <td><button class="btn btn-info" onclick="refresh_absensi()">Cari</button></td>
        </tr>
    </table>
</div>
<table id="tbl_absensi" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    function tbh_absensi() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_operator/tambah_absensi');
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

    $('#tbl_absensi').bootstrapTable({
        url: '<?= base_url('c_operator/dt_absensi') ?>',
        queryParams: function (p) {
            return{
                bln: $('#bln').val(),
                thn: $('#thn').val(),
                unit: $('#unit').val(),
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
                field: 'nip', title: 'NIP', halign: 'center', class: 'tengah', valign: 'middle'
            },
            {
                field: 'nama', title: 'Nama', halign: 'center', class: 'tengah', valign: 'middle'
            },
            {
                field: 'nilai_absensi', title: 'Nilai Absensi', halign: 'center', class: 'tengah', valign: 'middle'
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

    function hapus_absensi(id) {
        var r = confirm("Yakin ingin menghapus Data ini ?");
        if (r) {
            $.post('c_operator/hapus_absensi', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    lihat_absensi();
                }
            });
        }

    }

    function ubah_absensi(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_operator/ubah_absensi' + '/' + id);
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

    function refresh_absensi() {
        $('#tbl_absensi').bootstrapTable('refresh');
    }
</script>
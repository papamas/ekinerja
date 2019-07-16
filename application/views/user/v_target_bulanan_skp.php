<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
</style>
<div class="row">
    <div class="col-lg-12" style="text-align:center;font-weight:bold;font-size:14px;">
        <span style="text-transform: capitalize;">TARGET SKP BULAN <?= strtoupper(date('F', strtotime("2017-" . $periode['bulan'] . "-01"))) ?><?php $periode['bulan'] ?> TAHUN <?= $periode['tahun'] ?></span>
    </div>
</div>

<div style="float:left;">
    <table>
        <tr>
            <td>
                <button class="btn btn-success fa fa-pencil-square" onclick="tambah_target_bulanan_skp(<?= $id ?>)"> Tambah</button>
            </td>
        </tr>
    </table>
</div>
<div style="float:right;"> 
    <table>
        <tr>
            <td>  
                <div class="input-group">
                    <div class="input-group-addon">Tahun</div>
                    <input  type="text" id="tahun" class="form-control">
                </div>
            </td>
            <td>
                <button class="btn btn-primary fa fa-search" onclick="refresh_target_bulanan_skp()"> Cari</button>   
            </td>
        </tr>
    </table>
</div>
<br>
<table id="tbl_target_bulanan_skp" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>
<button class="btn btn-primary pull-right fa fa-print" onclick="cetak_target_bulanan_skp('<?= $id ?>')">Cetak</button>
<script>
    function get_tbl_target_bulanan_skp() {

        $('#tbl_target_bulanan_skp').bootstrapTable({
            url: '<?= base_url('C_user/dt_target_bulanan_skp') ?>',
            queryParams: function (p) {
                return{
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
                    field: 'no', title: 'No', halign: 'center', class: 'nox', valign: 'middle'
                },
                {
                    field: 'tahun', title: 'Tahun', class: 'kiri', valign: 'middle', halign: 'center'
                },
                {
                    field: 'kegiatan_tahunan', title: 'Kegiatan Tahunan', class: 'kiri', valign: 'middle', halign: 'center'
                },
                {
                    field: 'link_turunan', title: 'Turunan', class: 'kiri', valign: 'middle', halign: 'center'
                },
                {
                    field: 'target_kuantitas', title: 'Target Kuantitas', class: 'kiri', valign: 'middle', halign: 'center'
                },
                {
                    field: 'satuan_kuantitas', title: 'Target Kualitas', class: 'kiri', valign: 'middle', halign: 'center'
                },
                {
                    field: 'target_waktu', title: 'Target Waktu', class: 'kiri', valign: 'middle', halign: 'center'
                },
                {
                    field: 'biaya', title: 'Biaya', class: 'kiri', valign: 'middle', halign: 'center'
                },
                {
                    field: 'link_edit', title: 'Edit', halign: 'center', class: 'nox', valign: 'middle'
                },
                {
                    field: 'link_hapus', title: 'Hapus', halign: 'center', class: 'nox', valign: 'middle'
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

    }
    get_tbl_target_bulanan_skp();

    function tambah_target_bulanan_skp(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/tambah_target_bulanan_skp' + '/' + id);
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

    function ubah_target_bulanan_skp(id, id_bulanan) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/ubah_target_bulanan_skp' + '/' + id + '/' + id_bulanan);
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
    function lihat_turunan(id, id_tahunan) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/turunan' + '/' + id + '/' + id_tahunan);
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

    function hapus_target_bulanan_skp(id) {
        var r = confirm("Yakin ingin menghapus target_bulanan_skp ini ?");
        if (r) {
            $.post('C_user/hapus_target_bulanan_skp', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    refresh_target_bulanan_skp();
                }
            });


        }
    }

    function cetak_target_bulanan_skp(id) {
        var dialog = new BootstrapDialog({
            title: '<div style="font-size:12px;">Laporan Data JFK</div>',
            message: function () {
//                var $message = $('<div></div>').load('C_pdf/cetak_jfk/' + jenis );
                var $message = $('<iframe src=C_pdf/cetak_target_bulanan_skp/' + id + ' style="width:100%;height:300px;"></iframe>');
                return $message;
            }
        });
        dialog.realize();

        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_WIDE);
        dialog.open();
    }
    function refresh_target_bulanan_skp() {
        $('#tbl_target_bulanan_skp').bootstrapTable('refresh');
    }
</script>
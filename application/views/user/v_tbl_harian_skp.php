<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_harian_skp thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_harian_skp td{
        border:solid 1px black;
    }
</style>
<table id="tbl_harian_skp" class="table">
    <thead>
        <tr>
            <td>No</td>
            <td>Tanggal</td>
            <td>Kegiatan Harian SKP</td>
            <td>SKP Bulanan</td>
            <td>Kuantitas</td>
            <td>Edit</td>
            <td>Hapus</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($harian as $arr) {
            ?>
            <tr>
                <td class="tengah"><?= $no ?></td>
                <td><?= date('d M Y', strtotime($arr['tanggal'])) ?></td>
                <td><?= $arr['kegiatan_harian_skp'] ?></td>
                <td><?= $arr['kegiatan_bulanan'] ?></td>
                <td class="tengah"><?= $arr['kuantitas'] . ' ' . $arr['satuan_kuantitas'] ?></td>
                <td class="tengah"><a href="javascript:void(0)" onclick="ubah_harian('<?= $arr['id_opmt_realisasi_harian_skp'] ?>')"><i class="fa fa-pencil text-primary"></i></a></td>
                <td class="tengah"><a href="javascript:void(0)" onclick="hapus_harian('<?= $arr['id_opmt_realisasi_harian_skp'] ?>')"><i class="fa fa-trash text-danger"></i></a></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </tbody>
</table>

<script>
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
                var $message = $('<div></div>').load('C_user/ubah_harian_skp'+'/'+id);
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
<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_tugas_tambahan_skp thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_tugas_tambahan_skp td{
        border:solid 1px black;
    }
</style>
<table id="tbl_tugas_tambahan_skp" class="table">
    <thead>
        <tr>
            <td>No</td>
            <td>Tanggal</td>
            <td>Tugas Tambahan</td>
            <td>Kuantitas</td>
            <td>Edit</td>
            <td>Hapus</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($tugas as $arr) {
            ?>
            <tr>
                <td class="tengah"><?= $no ?></td>
                <td><?= date('d M Y', strtotime($arr['tanggal'])) ?></td>
                <td><?= $arr['tugas_tambahan'] ?></td>
                <td class="tengah"><?= $arr['target_kuantitas'] . ' ' . $arr['satuan_kuantitas'] ?></td>
                <td class="tengah"><a href="javascript:void(0)" onclick="ubah_tugas_tambahan('<?= $arr['id_opmt_tugas_tambahan'] ?>')"><i class="fa fa-pencil text-primary"></i></a></td>
                <td class="tengah"><a href="javascript:void(0)" onclick="hapus_tugas_tambahan('<?= $arr['id_opmt_tugas_tambahan'] ?>')"><i class="fa fa-trash text-danger"></i></a></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </tbody>
</table>

<script>
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
                var $message = $('<div></div>').load('C_user/ubah_tugas_tambahan'+'/'+id);
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
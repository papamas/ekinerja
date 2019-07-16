<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_absensi thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_absensi td{
        border:solid 1px black;
    }.judul{font-weight: bold;}
</style>


<table class="table" id="tbl_absensi">
    <thead>
        <tr>
            <td>No</td>
            <td>Bulan</td>
            <td>Tahun</td>
            <td>NIP</td>
            <td>Nama</td>
            <td>Nilai Absensi</td>
            <td>Edit</td>
            <td>Hapus</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($absensi as $arr) {
            ?>
            <tr>
                <td><?= $no ?></td>
                <td><?= $arr['bulan'] ?></td>
                <td><?= $arr['tahun'] ?></td>
                <td><?= $arr['nip'] ?></td>
                <td><?= $arr['nama'] ?></td>
                <td><?= $arr['nilai_absensi'] ?></td>
                <td class="tengah"><a href="javascript:void(0)" onclick="ubah_absensi('<?= $arr['id_opmt_absensi'] ?>')"><i class="fa fa-pencil text-primary"></i></a></td>
                <td class="tengah"><a href="javascript:void(0)" onclick="hapus_absensi('<?= $arr['id_opmt_absensi'] ?>')"><i class="fa fa-trash text-danger"></i></a></td>
            </tr>
<?php } ?>
    </tbody>
</table>

<script>
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
                var $message = $('<div></div>').load('c_operator/ubah_absensi'+'/'+id);
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
<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_bulanan_skp thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_bulanan_skp td{
        border:solid 1px black;
    }
</style>
<table id="tbl_bulanan_skp" class="table">
    <thead>
        <tr>
            <td>No</td>
            <td>Bulan</td>
            <td>Tahun</td>
            <td>Status Approve</td>
            <td>Nama Bawahan</td>
            <td>Nilai Kualitas Bawahan</td>

        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($bulanan as $arr) {
            ?>
            <tr>
                <td class="tengah"><?= $no ?></td>
                <td class="tengah"><?= $arr['bulan'] ?></td>
                <td class="tengah"><?= $arr['tahun']?></td>
                <td class="tengah"><?= $arr['nilai_skp']>0?'Disetujui':'Belum Disetujui'?></td>
                <td class="tengah"><?= $arr['nama']?></td>
                <td class="tengah"><a href="javascript:void(0)" onclick="realisasi_bulanan('<?= $arr['id_opmt_bulanan_skp'] ?>')"><i class="fa fa-pencil text-primary"></i></a></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </tbody>
</table>

<script>
    function realisasi_bulanan(id) {
        menu('c_atasan/realisasi_bulanan_bawahan' + '/' + id);
    }
</script>
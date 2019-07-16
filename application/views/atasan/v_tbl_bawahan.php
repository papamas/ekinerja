<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_bawahan_skp thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_bawahan_skp td{
        border:solid 1px black;
    }
</style>
<table id="tbl_bawahan_skp" class="table">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama Bawahan</td>
            <td>Periode SKP</td>
            <td>Realisasi</td>

        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($bawahan as $arr) {
            ?>
            <tr>
                <td class="tengah"><?= $no ?></td>
                <td><?= $arr['nama'] ?></td>
                <td class="tengah"><?= date('d M Y', strtotime($arr['awal_periode_skp'])) . ' - ' . date('d M Y', strtotime($arr['akhir_periode_skp'])) ?></td>
                <td class="tengah"><a href="javascript:void(0)" onclick="realisasi_bawahan('<?= $arr['id_opmt_tahunan_skp'] ?>')"><i class="fa fa-pencil text-primary"></i></a></td>
            </tr>
            <?php
            $no++;
        }
        ?>
    </tbody>
</table>

<script>
    function realisasi_bawahan(id) {
        menu('c_atasan/realisasi_bawahan' + '/' + id);
    }
</script>
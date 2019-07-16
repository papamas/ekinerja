<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_tunjangan thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_tunjangan td{
        border:solid 1px black;
    }.judul{font-weight: bold;}
</style>

<table class="table" id="tbl_tunjangan">
    <thead>
        <tr>
            <td rowspan="2" style="vertical-align: middle;">No</td>
            <td rowspan="2" style="vertical-align: middle;">Nama</td>
            <td rowspan="2" style="vertical-align: middle;">NIP</td>
            <td rowspan="2" style="vertical-align: middle;">PAGU TTP(Berdasarkan Jabatan)</td>
            <td colspan="3">TTP SKP</td>
            <td colspan="2">TTP ID</td>
            <td colspan="2">Faktor Pengurang</td>
            <td rowspan="2" style="vertical-align: middle;">Jumlah Diterima</td>
        </tr>
        <tr>
            <td>SKP Bulanan</td>
            <td>Range</td>
            <td>Perhitungan (Pagu x Range x 40%)</td>
            <td>TTP ID Absensi (%)</td>
            <td>Perhitungan (Pagu x TTP ID x 60%)</td>
            <td>Jumlah Pengurang</td>
            <td>Perhitungan</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $no_2 = 'a';
        $par = '';
        $i = 0;

        function range2($nilai) {
            if ($nilai >= 85) {
                $range_nilai = 1;
            } elseif ($nilai >= 76) {
                $range_nilai = 90 / 100;
            } elseif ($nilai >= 60) {
                $range_nilai = 80 / 100;
            } elseif ($nilai >= 51) {
                $range_nilai = 70 / 100;
            } else {
                $range_nilai = 60 / 100;
            }
            return $range_nilai;
        }

        foreach ($tunjangan as $real_arr) {
            $nama = $real_arr['nama'];
            $nip = $real_arr['nip'];
            $pagu = $real_arr['tunjangan'];
            $nilai_skp = $real_arr['nilai_skp'];
            $range_nilai = range2($nilai_skp);
            $perhitungan1 = ($pagu * $range_nilai) * 0.4;
            $nilai_absensi = $real_arr['nilai_absensi'];
            $perhitungan2 = ($nilai_absensi / 100 * $pagu) * 0.6;
            $persentase_pengurang = $real_arr['persentase_pengurang'];
            $jumlah_pengurang = $persentase_pengurang * $pagu / 100;
            $jumlah_diterima = $perhitungan1 + $perhitungan2 - $jumlah_pengurang;
            ?>
            <tr align="center" style="vertical-align: middle;">
                <td><?= $no ?></td>
                <td><?= $nama ?></td>
                <td><?= $nip ?></td>
                <td><?= number_format($pagu) ?></td>
                <td><?= number_format($nilai_skp) ?></td>
                <td><?= number_format($range_nilai * 100) . ' %' ?></td>
                <td><?= number_format($perhitungan1) ?></td>
                <td><?= number_format($nilai_absensi) . " %" ?></td>
                <td><?= number_format($perhitungan2) ?></td>
                <td><?= number_format($persentase_pengurang) ?></td>
                <td><?= number_format($jumlah_pengurang) ?></td>
                <td><?= number_format($jumlah_diterima) ?></td>
            </tr>

            <?php
            $no++;
        }
        ?>
    </tbody>
</table>

<div style="float:left;">
    <ul class="pagination" style="margin-top:-10px;">
        <?php if ($page > 0) { ?>
            <li><a href="javascript:void(0)" onclick="cari(<?= $prev ?>)"><<</a></li>
        <?php } ?>
        <?php for ($i = $page + 1; $i <= min($page + 11, $total_page); $i++) { ?>
            <li class="active"><a href="javascript:void(0)" onclick="cari(<?= $i ?>)"><?= $i ?></a></li>
        <?php } ?>
        <?php if ($page < $total_page) { ?>
        <li class="<?= $total_page == 1 || $page == $total_page ? 'disabled' : '' ?>"><a href="javascript:void(0)" onclick="cari(<?= $next ?>)">>></a></li>
        <?php }?>
    </ul> 
</div>
<div style="float:right;margin-top:-10px;">
    <button class="btn btn-success" onclick="cetak_tunjangan();">Cetak</button>   
</div>


<script>

    function cetak_tunjangan() {
        var thn = $('#thn').val();
        var bln = $('#bln').val();
        var uker = $('#uker').val();
        var nip = $('#nip').val();
        var dialog = new BootstrapDialog({
            title: '<div style="font-size:12px;">Data Rekap Tunjangan</div>',
            message: function () {
//                var $message = $('<div></div>').load('c_pdf/cetak_jfk/' + jenis );
                var $message = $('<iframe src=c_pdf/cetak_tunjangan/' + thn + '/' + bln + '/' + uker + '/' + nip + ' style="width:100%;height:300px;"></iframe>');
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_WIDE);
        dialog.open();
    }

</script>
<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_realisasi thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:black;border:solid 1px black;
    }
    #tbl_realisasi td{
        border:solid 1px black;
    }
</style>
<div class="row">
    <div class="col-lg-12" style="text-align:center;font-weight:bold;font-size:14px;">
        <span>REALISASI SKP TAHUNAN <?= date('Y', strtotime($periode['awal_periode_skp'])) ?></span>
    </div>
</div>
<div class="row">
    <div class="col-lg-12" style="text-align:center;font-weight:bold;font-size:14px;">
        <span><?=strtoupper($user['nama'])?></span>
    </div>
</div>
<table width="100%" id="tbl_realisasi" style="color:black;">
    <thead>
        <tr>
            <td rowspan="2" style="vertical-align:middle;">No</td>
            <td rowspan="2" style="vertical-align:middle;width:250px;">Kegiatan</td>
            <td colspan="4" width="100">Target</td>
            <td colspan="4" width="100">Realisasi</td>
            <td colspan="2" width="100">Penilaian</td>
           </tr>
        <tr><td width="70">Kuantitas</td><td width="70">Kualitas</td><td width="70">Waktu</td><td width="70">Biaya</td><td width="70">Kuantitas</td><td width="60">Kualitas</td><td width="60">Waktu</td><td width="60">Biaya</td><td width="80">Perhitungan</td><td width="60">Nilai</td></tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        foreach ($real as $real_arr) {
            $target_kuantitas = $real_arr['target_kuantitas'];
            $real_kuantitas = $real_arr['realisasi_kuantitas'];
            $target_kualitas = 100;
            $real_kualitas = $real_arr['realisasi_kualitas'];
            $target_waktu = $real_arr['target_waktu'];
            $real_waktu = $real_arr['waktu_realisasi'];
            $target_biaya = $real_arr['biaya'];
            $real_biaya = $real_arr['biaya_realisasi'];
            $nilai_kuantitas = ($real_kuantitas / $target_kuantitas) * 100;
            $nilai_kualitas = ($real_kualitas / $target_kualitas) * 100;
            $persentase_waktu = 100 - ($real_waktu / $target_waktu * 100);
            if ($persentase_waktu <= 24) {
                $nilai_waktu = ((1.76 * $target_waktu - $real_waktu) / $target_waktu) * 100;
            } else {
                $nilai_waktu = 76 - ((((1.76 * $target_waktu - $real_waktu) / $target_waktu) * 100) - 100);
            }
            $persentase_biaya =$target_biaya==0?0: 100 - ($real_biaya / $target_biaya * 100);
            if ($persentase_biaya <= 24) {
                $nilai_biaya = $target_biaya==0?0:((1.76 * $target_biaya - $real_biaya) / $target_biaya) * 100;
            } else {
                $nilai_biaya =$target_biaya==0?0: 76 - ((((1.76 * $target_biaya - $real_biaya) / $target_biaya) * 100) - 100);
            }

            $perhitungan = $nilai_biaya + $nilai_waktu + $nilai_kualitas + $nilai_kuantitas;
            if ($target_biaya > 0) {
                $nilai = $perhitungan / 4;
            } else {
                $nilai = $perhitungan / 3;
            }
            ?>
            <tr>
                <td align="center"><?= $no ?></td>
                <td><?= $real_arr['kegiatan_tahunan'] ?></td>
                <td><?= $real_arr['target_kuantitas'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                <td>100</td>
                <td><?= $real_arr['target_waktu'] . ' bulan' ?></td>
                <td><?= number_format($real_arr['biaya']) ?></td>
                <td><?= $real_arr['realisasi_kuantitas'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                <td><?= $real_arr['realisasi_kualitas'] ?></td>
                <td><?= $real_arr['waktu_realisasi'] ?></td>
                <td align="center"><?= number_format($real_arr['biaya_realisasi']) ?></td>
                <td align="center"><?= number_format($perhitungan) ?></td>
                <td align="center"><?= number_format($ttl_nilai[] = $nilai, 2) ?></td>

            </tr>
            <?php
            $no++;
        }
        ?>
        <tr style="background:#dff0d8;font-weight:bold;">
            <td colspan="11" align="center">Nilai SKP</td>
            <td align="center"><?= !isset($ttl_nilai)?$total_nilai =0:number_format($total_nilai = array_sum($ttl_nilai)/count($ttl_nilai),2) ?></td>
    
        </tr>
        <tr>
            <td colspan="11" align="left" style="font-weight: bold;">Tugas Tambahan</td>
            <td></td>
     
        </tr>
        <?php
        $ttl_tgs = count($tugas_tambahan);
        if($ttl_tgs==0){
            $nilai_tgs=0;
        }
        else if ($ttl_tgs < 4 ) {
            $nilai_tgs = 1;
        } else if ($ttl_tgs < 7) {
            $nilai_tgs = 2;
        } else {
            $nilai_tgs = 3;
        }$i = 0;
        foreach ($tugas_tambahan as $arr2) {
            ?>
            <tr>
                <td colspan="11" align="left" ><?= $arr2['tugas_tambahan'] ?></td>
                <?php if ($i == 0) { ?>
                    <td rowspan="<?= $ttl_tgs ?>" style="vertical-align: middle;text-align: center;"><?= $nilai_tgs; ?></td>
                <?php } ?>
               
            </tr>
            <?php
            $i++;
        }
        ?>
        <tr>
            <td colspan="11" align="left" style="font-weight: bold;">Kreatifitas</td>
            <td></td>
         
        </tr>
        <?php
        $ttl_kreatif = count($kreatifitas);
        $nilai_kreatif = 0;
        $j = 0;
        foreach ($kreatifitas as $arr3) {
            ?>
            <tr>
                <td colspan="11" align="left" ><?= $arr3['kreatifitas'] ?></td>
                <?php if ($j == 0) { ?>
                    <td rowspan="<?= $ttl_kreatif ?>" style="text-align: center;vertical-align: middle;"><?= $nilai_kreatif=$nilai_kreatifitas2['nilai_kreatifitas'] ?></td>
                    <?php
                    $j++;
                }
                ?>
            
            </tr>
            <?php
        }
        ?>
        <tr style="background:#dff0d8;font-weight:bold;">
            <td colspan="11" align="center">Total Nilai SKP</td>
            <td align="center"><?=number_format($nilai_tgs+$nilai_kreatif+$total_nilai,2)?></td>
     
        </tr>
    </tbody>
</table>


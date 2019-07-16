<?php
if (isset($realisasi_skp)) {
    $tanggal = $realisasi_skp['tanggal'];
    $proses = $realisasi_skp['proses'];
    $kegiatan_harian_skp = $realisasi_skp['kegiatan_harian_skp'];
    $kuantitas = $realisasi_skp['kuantitas'];
    $satuan_kuantitas = $realisasi_skp['satuan_kuantitas'];
    $kegiatan_tahunan = $realisasi_skp['kegiatan_tahunan'];
    $kegiatan = $realisasi_skp['kegiatan'];
    
}
?>
<style>
    .ui-state-default{
        color:black !important;
        background:blue;
    }td{vertical-align:middle;}
</style>
<form id="frm_harian_skp" method="post">
    <table class="table">
        <tr>
            <td style="width:150px !important;">Tanggal</td>
            <td> : </td> 
            <td colspan="3">
                <input type="text" class="form-control" name="tanggal" value="<?= $tanggal == "" ? date('Y-m-d') : $tanggal ?>" style="width: 200px;" readonly>
            </td>
        </tr>
        <tr>
            <td>Proses</td>
            <td> : </td> 
            <td colspan="3">
                <input type="checkbox" name="proses" <?= $proses == 1 ? 'checked' : '' ?> class="form-control" style="width: 30px;" readonly>
            </td>
        </tr>

        <tr>
            <td>Kegiatan Harian SKP</td>
            <td> : </td> 
            <td colspan="3">
                <textarea class="form-control" name="kegiatan_harian_skp" readonly><?=$kegiatan_harian_skp?>
                </textarea>
            </td>
        </tr>
        <tr>

            <td>Kuantitas</td>
            <td>:</td>
            <td>
                <input type="text" class="form-control" name="kuantitas" style="width:50px;" value="<?=$kuantitas?>" readonly>
            </td>

            <td>Satuan Kuantitas</td>
            <td>
                   <input type="text" class="form-control" name="kuantitas" style="width:50px;" value="<?=$kuantitas?>" readonly>
         
            </td>
        </tr>
        <tr>
            <td>Klasifikasi SKP Bulanan</td>
            <td> : </td> 
            <td colspan="3">
                        <input type="text" class="form-control" value="<?=$kegiatan?>" readonly>
            </td>
        </tr>
        <tr>
            <td>Klasifikasi SKP Tahunan</td>
            <td> : </td> 
            <td colspan="3">
                <input type="text" class="form-control" value="<?=$kegiatan_tahunan?>" readonly>
            </td>
        </tr>

    </table>
</form>

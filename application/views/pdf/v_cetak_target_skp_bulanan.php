
<style>
    #tbl_rekap td{
        font-size: 12px;
    }
</style>

<div style="font-weight:bold;font-size:16px;text-align:center;">
    <?= $judul1 ?>
</div><br>
<div style="font-weight:bold;font-size:16px;text-align:center;">
    <?= $judul2 ?>
</div><br>
<div style="font-weight:bold;font-size:16px;text-align:center;">
    <?= $judul3 ?>
</div><br>
<hr>

<table cellpadding="1" border="0.5" style="border:1px;" id="tbl_rekap" class="table table-bordered">
    <thead>
        <tr style="text-align: center;border:1px;background-color:grey;color:black;font-size: 14px;font-weight:bold;">
            <td width="35">No</td>
            <td width="490" colspan="2">PEJABAT PENILAI</td>
            <td width="35">No</td>
            <td width="490"colspan="2">PEGAWAI NEGERA SIPIL YANG DINILAI</td>
        </tr>

    </thead>
    <tbody style="font-size: 12px;">
        <tr>
            <td align="center">1</td>
            <td>Nama</td>
            <td><?= $atasan['nama'] ?></td>
            <td></td>
            <td>Nama</td>
            <td><?= $user['nama'] ?></td>
        </tr>
        <tr>
            <td align="center">2</td>
            <td>NIP</td>
            <td><?= $atasan['nip'] ?></td>
            <td></td>
            <td>NIP</td>
            <td><?= $user['nip'] ?></td>
        </tr>
        <tr>
            <td align="center">3</td>
            <td>Pangkat/Gol.Ruang</td>
            <td><?= $atasan['pangkat'] ?></td>
            <td></td>
            <td>Pangkat/Gol.Ruang</td>
            <td><?= $user['pangkat'] ?></td>
        </tr>
        <tr height="40">
            <td align="center">4</td>
            <td valign="top">Jabatan</td>
            <td width="200" valign="top"><?= $atasan['nama_jabatan'] ?></td>
            <td></td>
            <td valign="top">Jabatan</td>
            <td width="200"  valign="top"><?= $user['nama_jabatan'] ?></td>
        </tr>
        <tr>
            <td align="center">5</td>
            <td valign="top">Unit Kerja</td>
            <td width="200" height="50"><?= $atasan['nama_uker'] ?></td>
            <td></td>
            <td valign="top">Unit Kerja</td>
            <td valign="top" width="200" height="50"><?= $user['nama_uker'] ?></td>
        </tr> 
    </tbody>
</table>

<table cellpadding="1" border="0.5" style="border:1px;" id="tbl_rekap" class="table table-bordered">
    <thead>
        <tr style="text-align: center;border:1px;background-color:grey;color:black;font-size: 14px;font-weight:bold;">
            <td width="35" rowspan="2">No</td>
            <td width="490" rowspan="2">KEGIATAN TUGAS JABATAN</td>
            <td width="35" rowspan="2">AK</td>
            <td width="490"colspan="4">TARGET</td>
        </tr>
        <tr style="text-align: center;border:1px;background-color:grey;color:black;font-size: 14px;font-weight:bold;">
            <td>KUANT/OUTPUT</td>
            <td>KUAL/MUTU</td>
            <td>WAKTU</td>
            <td>BIAYA</td>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $no_2 = 'a';
        $par = '';
        $par_id = '';
        $i = 0;
        foreach ($target as $arr) {
            if ($arr['id_dd_user_bawahan'] > 0 && $i > 0 && $arr['id_dd_user'] !== $this->session->userdata('id_user')) {
                $no++;
            } elseif ($par_id !== "" && $par_id !== $arr['id_opmt_target_bulanan_skp']) {
                $no++;
                $no_2 = 'a';
            }

            if ($arr['id_dd_user_bawahan'] == 0 || empty($arr['id_dd_user_bawahan'])) {
                $id_opmt_bulanan_skp = $arr['id_opmt_bulanan_skp'];
            } else {
                $id_opmt_bulanan_skp = $id;
            }
            if ($arr['ket'] == 'utama' && $par == "turunan") {
                //$no++;
                $no_2 = 'a';
            }
            ?>
            <tr>
                <td align="center">  <?php
                    if ($arr['id_dd_user_bawahan'] > 0 && $arr['id_dd_user'] !== $this->session->userdata('id_user')) {
                        echo $no;
                    } elseif ($par_id !== $arr['id_opmt_target_bulanan_skp']) {
                        echo $no;
                    } else {
                        echo $no . '.' . $no_2;
                    }
                    ?>  </td>
                <td><?= $arr['kegiatan'] ?></td>
                <td></td>
                <td align="center"><?= $arr['turunan'] == 1 ? "" : $arr['target_kuantitas'] . ' ' . $arr['satuan_kuantitas'] ?></td>
                <td align="center"><?= $arr['turunan'] == 1 ? "" : $arr['kualitas'] ?></td>
                <td align="center"><?= $arr['turunan'] == 1 ? "" : $arr['target_waktu'] . ' Hari' ?></td>
                <td align="right"><?= $arr['turunan'] == 1 ? "" : number_format($arr['biaya']) ?></td>
            </tr>
            <?php
            if ($arr['ket'] == 'turunan') {
                $no_2++;
            } $par = $arr['ket'];
            $i++;
            $par_id = $arr['id_opmt_target_bulanan_skp'];
        }
        ?>
    </tbody>
</table>
<br>
<table style="width:100%;" style="text-align: center;color:black;font-size: 12px;font-weight:bold;">
    <tr>
        <td width="300"></td>
        <td width="300"></td>
        <td align="center" width="600"><?= $lokasi['lokasi_spesimen'] ?>, <?= date('d M Y') ?></td>
    </tr>
    <tr>
        <td width="300">Pejabat Penilai</td>
        <td width="300"></td>
        <td align="center" width="600">Pegawai Negeri Sipil Yang Dinilai</td>
    </tr>
    <tr style="font-size:40px;"><td>&nbsp;</td><td></td></tr>
    <tr><td><?= $atasan['nama'] ?></td><td width="300"></td><td><?= $user['nama'] ?></td></tr>

    <tr><td><?= $atasan['nip'] ?></td><td width="300"></td><td><?= $user['nip'] ?></td></tr>
</table>
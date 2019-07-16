<style>
    .dataTables_length{
        color:#0000C0 !important;
    }.breadcrumb a{
        color:#285e8e !important;font-size:12px !important;
    }
</style>
<ol class="breadcrumb bc-3" style="margin-top:-30px;">
    <li>
        <a href="javascript:void(0)">
            <i class="glyphicon glyphicon-home"></i>
            SKP
        </a>
    </li>
    <li><a href="javascript:void(0)">Tahunan</a></li>
    <li><a href="javascript:void(0)">Realisasi </a></li>
</ol>
<div style="padding:10px;">
    <div class="row">
        <div class="col-lg-12" style="text-align:center;font-weight:bold;font-size:14px;">
            <span>REALISASI SKP TAHUNAN <?= date('Y', strtotime($periode['awal_periode_skp'])) ?></span>
        </div>
    </div>

    <table class="table table-bordered" id="tbl_realisasi">
        <thead class="sorting_disabled ui-state-default">
            <tr style="text-align:center;">
                <td rowspan="2" style="vertical-align:middle;">No</td>
                <td rowspan="2" style="vertical-align:middle;">Kegiatan</td>
                <td colspan="4">Target</td>
                <td colspan="4">Realisasi</td>
                <td colspan="2">Penilaian</td>
                <td rowspan="2" style="vertical-align:middle;">Input Biaya & Waktu</td></tr>
            <tr style="text-align:center;"><td>Kuantitas</td><td>Kualitas</td><td>Waktu</td><td>Biaya</td><td>Kuantitas</td><td>Kualitas</td><td>Waktu</td><td>Biaya</td><td>Perhitungan</td><td>Nilai</td></tr>
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
                $persentase_biaya = $target_biaya == 0 ? 0 : 100 - ($real_biaya / $target_biaya * 100);
                if ($persentase_biaya <= 24) {
                    $nilai_biaya = $target_biaya == 0 ? 0 : ((1.76 * $target_biaya - $real_biaya) / $target_biaya) * 100;
                } else {
                    $nilai_biaya = $target_biaya == 0 ? 0 : 76 - ((((1.76 * $target_biaya - $real_biaya) / $target_biaya) * 100) - 100);
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
                    <td align="center"><?= $real_arr['kegiatan_tahunan'] ?></td>
                    <td align="center"><?= $real_arr['target_kuantitas'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                    <td align="center">100</td>
                    <td align="center"><?= $real_arr['target_waktu'] . ' bulan' ?></td>
                    <td align="center"><?= number_format($real_arr['biaya']) ?></td>
                    <td align="center"><?= $real_arr['realisasi_kuantitas'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                    <td align="center"><?=  number_format($real_arr['realisasi_kualitas'],2) ?></td>
                    <td align="center"><?= $real_arr['waktu_realisasi'] ?></td>
                    <td align="center"><?= number_format($real_arr['biaya_realisasi']) ?></td>
                    <td align="center"><?= number_format($perhitungan) ?></td>
                    <td align="center"><?= number_format($ttl_nilai[] = $nilai, 2) ?></td>
                    <td align="center"><a href="javascript:void(0)" onclick="input_biaya('<?= $id ?>', '<?= $real_arr['id_opmt_target_skp'] ?>')"><i class="fa fa-file-o text-primary"></i></a></td>
                </tr>
                <?php
                $no++;
            }
            ?>
            <tr style="background:#dff0d8;font-weight:bold;">
                <td colspan="11" align="center">Nilai SKP</td>
                <td><?= !isset($ttl_nilai) ? $total_nilai = 0 : number_format($total_nilai = array_sum($ttl_nilai) / count($ttl_nilai), 2) ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="11" align="left" style="font-weight: bold;">Tugas Tambahan</td>
                <td></td>
                <td></td>
            </tr>
            <?php
            $ttl_tgs = count($tugas_tambahan);
            if ($ttl_tgs == 0) {
                $nilai_tgs = 0;
            } else if ($ttl_tgs < 4) {
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
                    <td></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tr>
                <td colspan="11" align="left" style="font-weight: bold;">Kreatifitas</td>
                <td></td>
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
                        <td rowspan="<?= $ttl_kreatif ?>" style="text-align: center;vertical-align: middle;"><?= $nilai_kreatif = isset($nilai_kreatifitas2['nilai_kreatifitas']) ? $nilai_kreatifitas2['nilai_kreatifitas'] : 0 ?></td>
                        <?php
                        $j++;
                    }
                    ?>
                    <td></td>
                </tr>
                <?php
            }
            ?>
            <tr style="background:#dff0d8;font-weight:bold;">
                <td colspan="11" align="center">Total Nilai SKP</td>
                <td><?= number_format($nilai_tgs + $nilai_kreatif + $total_nilai, 2) ?></td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <button class="btn btn-primary pull-right fa fa-print" onclick="cetak_realisasi_tahunan_skp('<?= $id ?>')">Cetak</button>
</div>
<script>


    function input_biaya(id_tahun, id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_user/tambah_realisasi_tahunan_skp' + '/' + id_tahun + '/' + id);
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

    function ubah_realisasi_tahunan_skp(id) {

        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_user/ubah_realisasi_tahunan_skp' + '/' + id);
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

    function hapus_realisasi_tahunan_skp(id) {
        var r = confirm("Yakin ingin menghapus realisasi_tahunan_skp ini ?");
        if (r) {
            $.post('c_user/hapus_realisasi_tahunan_skp', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    refresh_realisasi_tahunan_skp();
                }
            });


        }
    }

    function cetak_realisasi_tahunan_skp(id) {
        var dialog = new BootstrapDialog({
            title: '<div style="font-size:12px;">Cetak Realisasi Tahunan SKP</div>',
            message: function () {
//                var $message = $('<div></div>').load('c_pdf/cetak_jfk/' + jenis );
                var $message = $('<iframe src=c_pdf/cetak_realisasi_tahunan_skp/' + id + ' style="width:100%;height:300px;"></iframe>');
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
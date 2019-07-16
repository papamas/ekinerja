<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_realisasi thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_realisasi td{
        border:solid 1px black;
    }.judul{font-weight: bold;}td{vertical-align: middle !important;}
</style>
<div style="padding:10px;">
    <div class="row">
        <div class="col-lg-12" style="text-align:center;font-weight:bold;font-size:14px;">
            <span style="text-transform: capitalize;">REALISASI SKP BULAN <?= bulan($periode['bulan']) ?>  TAHUN <?= $periode['tahun'] ?><br>
                <?= strtoupper($periode['nama']) ?>
            </span>
        </div>
    </div>

    <table class="table" id="tbl_realisasi">
        <thead class="ui-state-default">
            <tr>
                <td class="tengah" rowspan="2">No</td>
                <td class="tengah" rowspan="2">Kegiatan Bulanan</td>
                <td colspan="4">Target</td>
                <td colspan="4">Realisasi</td>
                <td class="tengah" rowspan="2">Perhitungan</td>
                <td class="tengah" rowspan="2">Nilai</td>
                <td class="tengah" rowspan="2">Input Kualitas</td>
            </tr>
            <tr>
                <td>Kuantitas</td>
                <td>Kualitas</td>
                <td>Waktu</td>
                <td>Biaya</td>
                <td>Kuantitas</td>
                <td>Kualitas</td>
                <td>Waktu</td>
                <td>Biaya</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            $no_2 = 'a';
            $par = '';
            $i = 0;$k=0;
            $id_opmt_bulanan_skp = "";
            $par_id = "";$par_id_user="";
            foreach ($realisasi as $real_arr) {
		if ($real_arr['id_dd_user_bawahan']>0&&$i>1&&$par_user!==$real_arr['id_dd_user']) {
                            $no++;
                        }
                elseif ($par_id !== "" && $par_id !== $real_arr['id_opmt_target_bulanan_skp']) {
                    $no++;
                    $no_2 = 'a';
                }

                if ($real_arr['id_dd_user_bawahan'] == 0 || empty($real_arr['id_dd_user_bawahan'])) {
                    $id_opmt_bulanan_skp = $real_arr['id_opmt_bulanan_skp'];
                } else {
                    $id_opmt_bulanan_skp = $id;
                }
                if ($real_arr['ket'] == 'utama' && $par == "turunan") {
                    //$no++;
                    $no_2 = 'a';
                }
                if ($real_arr['id_dd_user'] !== $this->session->userdata('id_user') && $real_arr['id_dd_user_bawahan'] > 0&&$par_user!==$real_arr['id_dd_user']) {
                    $no++;
                    $no_2 = '';
                }
		

 		if ($real_arr['id_dd_user_bawahan']== $this->session->userdata('id_user') ) {
                    $no++;
                    $no_2 = '';
                }
		

//echo $real_arr['id_dd_user_bawahan'].'tes'.$this->session->userdata('id_user') ;


                $target_waktu = $real_arr['target_waktu'];
                $real_waktu = $real_arr['realisasi_waktu'];
                $target_kuantitas = $real_arr['target_kuantitas'];
                $realisasi_kuantitas = !isset($real_arr['realisasi_kuantitas']) ? '' : $real_arr['realisasi_kuantitas'];
                $target_kualitas = 100;
                $realisasi_kualitas = $real_arr['realisasi_kualitas'];
                $target_waktu = $real_arr['target_waktu'];
                $realisasi_waktu = !isset($real_arr['realisasi_waktu']) ? '' : $real_arr['realisasi_waktu'];
                $target_biaya = $real_arr['biaya'];
                $realisasi_biaya = $real_arr['realisasi_biaya'];
                $nilai_kuantitas = $target_kuantitas == 0 ? 0 : ($realisasi_kuantitas / $target_kuantitas) * 100;
                $nilai_kualitas = ($realisasi_kualitas / $target_kualitas) * 100;
                $persentase_waktu = $target_waktu == 0 ? 0 : 100 - ($real_waktu / $target_waktu * 100);
                if ($persentase_waktu <= 24) {
                    $nilai_waktu = $target_waktu == 0 ? 0 : ((1.76 * $target_waktu - $real_waktu) / $target_waktu) * 100;
                } else {
                    $nilai_waktu = $target_waktu == 0 ? 0 : 76 - ((((1.76 * $target_waktu - $real_waktu) / $target_waktu) * 100) - 100);
                }
                $efisiensi_biaya = $target_biaya == 0 ? 0 : 100 - ($realisasi_biaya / $target_biaya * 100);
                if ($efisiensi_biaya <= 24) {
                    $nilai_biaya = $target_biaya == 0 ? 0 : ((1.76 * $target_biaya - $realisasi_biaya) / $target_biaya) * 100;
                } else {
                    $nilai_biaya = $target_biaya == 0 ? 0 : 76 - ((((1.76 * $target_biaya - $realisasi_biaya) / $target_biaya) * 100) - 100);
                }
                $perhitungan = $realisasi_kuantitas == "" ? "" : $nilai_biaya + $nilai_waktu + $nilai_kualitas + $nilai_kuantitas;
                if ($target_biaya > 0) {
                    $nilai = $perhitungan == "" ? "" : $perhitungan / 4;
                } else {
                    $nilai = $perhitungan == "" ? "" : $perhitungan / 3;
                }
                $ttl_nilai[] = 0;
                ?>
                <tr class="<?= $real_arr['ket'] == 'utama' ? 'judul' : '' ?>">
                    <td align="center">
                        <?php
if($real_arr['id_dd_user_bawahan']>0&&$par_user!==$real_arr['id_dd_user']){
echo $no;
}
                        elseif ($par_id !== $real_arr['id_opmt_target_bulanan_skp']) {
                            echo $no;
                        } else {
                            echo $no . '.' . $no_2;
                        }
                        ?>
                    </td>
                    <td><?= $real_arr['kegiatan'] ?></td>
                    <td class="tengah"><?= $real_arr['turunan'] == 1 ? "" : $real_arr['target_kuantitas'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                    <td class="tengah"><?= $real_arr['turunan'] == 1 ? "" : 100 ?></td>
                    <td class="tengah"><?= $real_arr['turunan'] == 1 ? "" : $real_arr['target_waktu'] . ' hari' ?></td>
                    <td class="angka"><?= $real_arr['turunan'] == 1 ? "" : number_format($real_arr['biaya']) ?></td>
                    <td class="tengah"><?= $real_arr['turunan'] == 1 ? "" : $real_arr['realisasi_kuantitas'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                    <td class="tengah"><?= $real_arr['turunan'] == 1 ? "" : number_format($real_arr['realisasi_kualitas']) ?></td>
                    <td class="tengah"><?= $real_arr['turunan'] == 1 ? "" : $real_arr['realisasi_waktu'] . " hari" ?></td>
                    <td class = "angka"><?= $real_arr['turunan'] == 1 ? "" : number_format($real_arr['realisasi_biaya'])
                    ?></td>
                    <td align="center"><?= $perhitungan == "" ? "" : number_format($perhitungan) ?></td>
                    <td align="center"><?= $nilai == false ? "" : number_format($ttl_nilai[] = $nilai,2) ?></td>
                    <td align="center">
                        <?php
                        if ($real_arr['id_dd_user_bawahan'] > 0 && $real_arr['id_dd_user'] !== $this->session->userdata('id_user')) {
                            echo'';
                        } elseif ($real_arr['turunan'] == 0 && $real_arr['ket'] == 'utama') {
                            ?>
                            <a href="javascript:void(0)" onclick="input_kualitas_bulanan_skp('<?= $real_arr['id'] ?>', '<?= $real_arr['ket'] ?>', '<?= $id_opmt_bulanan_skp ?>')"><i class="fa fa-pencil-square text-primary"></i></a>
                        <?php } elseif ($real_arr['ket'] == 'turunan') { ?>
                            <a href="javascript:void(0)" onclick="input_kualitas_bulanan_skp('<?= $real_arr['id'] ?>', '<?= $real_arr['ket'] ?>', '<?= $id_opmt_bulanan_skp ?>')"><i class="fa fa-pencil-square text-primary"></i></a>
                            <?php
                        }
//                        if ($perhitungan !== "") {
                        if ($real_arr['target_kuantitas'] > 0) {
                            $k++;
                        }
                        if ($real_arr['ket'] == 'turunan'&&($real_arr['id_dd_user_bawahan']==''||$real_arr['id_dd_user_bawahan']==0)) {
                            $no_2++;
                        }
elseif($real_arr['ket']=='turunan'&&$par=='turunan'){$no_2++;}
			$par_id_user=$real_arr['id_dd_user'];

                        ?>
                    </td>
                </tr>
                <?php
                $par = $real_arr['ket'];
                $par_id = $real_arr['id_opmt_target_bulanan_skp'];
$i++;
            }
            ?>
            <tr style="background-color:#dff0d8;text-align: center;font-weight: bold;">
                <td colspan="11">Nilai SKP </td>
                <td><?= $i == 0 ? $total_nilai = 0 : number_format($total_nilai = array_sum($ttl_nilai) / $k, 2) ?></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="11" style="font-weight:bold;">Disposisi Tugas ( Status : Selesai Dilaksanakan dari Atasan )</td>
                <td></td>
                <td></td>
            </tr>
            <?php
            $ttl_tgs = count($disposisi);
            $i = 0;
            $nilai_dsp = 0;
            foreach ($disposisi as $arr2) {
                ?>
                <tr>
                    <td colspan="11" align="left" ><?= $arr2['kegiatan'] ?></td>
                    <?php if ($i == 0) { ?>
                        <td rowspan="<?= $ttl_tgs ?>" style="vertical-align: middle;text-align: center;"><?= $nilai_dsp = $arr2['status_disposisi_atasan'] == 1 ? 3 : 0; ?></td>
                    <?php } ?>
                    <td></td>
                </tr>
                <?php
                $i++;
            }
            ?>
            <tr style="background-color:#dff0d8;text-align: center;font-weight: bold;">
                <td colspan="11">Total Nilai SKP</td>
                <td><?= number_format($nilai_bulanan = $total_nilai + $nilai_dsp, 2) ?>
                    <input type="hidden" id="nilai_skp" value="<?= $nilai_bulanan ?>">
                    <input type="hidden" id="id_opmt_bulanan_skp" value="<?= $id_opmt_bulanan_skp ?>">
                </td>
                <td></td>
            </tr>
        </tbody>
    </table>
    <button class="btn btn-success" onclick="update_skp_bawahan();"><i class="fa fa-check"></i>Approve</button>
</div>
<script>

    function input_kualitas_bulanan_skp(id, ket, id_bulanan) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_atasan/input_kualitas_bulanan_skp' + '/' + id + '/' + ket + '/' + id_bulanan);
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_WIDE);
        dialog.open();
    }

    function hapus_target_bulanan_skp(id, ket, id2) {
        var r = confirm("Yakin ingin menghapus Data ini ?");
        if (r) {
            $.post('c_user/hapus_target_bulanan_skp', {id: id, ket: ket}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    menu('c_user/target_bulanan_skp' + '/' + id2);
                }
            });
        }
    }

    function cetak_target_bulanan_skp(id) {


        var dialog = new BootstrapDialog({
            title: '<div style="font-size:12px;">Laporan Data JFK</div>',
            message: function () {
//                var $message = $('<div></div>').load('c_pdf/cetak_jfk/' + jenis );
                var $message = $('<iframe src=c_pdf/cetak_target_bulanan_skp/' + id + ' style="width:100%;height:300px;"></iframe>');
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_WIDE);
        dialog.open();

    }

    function update_skp_bawahan() {
        var cek = '<?= $parameter['parameter_approve'] ?>';
        if (cek == 1) {
            alert('Belum dapat disetujui');
        } else {
            var id = $('#id_opmt_bulanan_skp').val();
            var nilai = $('#nilai_skp').val();
            var r = confirm("Yakin ingin mengapprove nilai SKP ini ?");
            if (r) {
                $.post('c_bulanan_skp/update_bulanan_skp', {id: id, nilai: nilai}, function (data) {
                    if (data.status == 1) {
                        alert(data.ket);
                        menu('c_atasan/realisasi_bulanan_bawahan' + '/' + id);
                    }
                });
            }
        }
    }

</script>
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
                <td rowspan="2" style="vertical-align:middle;">NO</td>
                <td rowspan="2" style="vertical-align:middle;">I. KEGIATAN TUGAS JABATAN</td>
				<td rowspan="2">AK</td>
                <td colspan="4">TARGET</td>
				<td rowspan="2">AK</td>
                <td colspan="4">REALISASI</td>
                <td rowspan="2">PERHITUNGAN</td>
				<td rowspan="2">NILAI CAPAIAN SKP</td>
                <td rowspan="2" style="vertical-align:middle;">Input Biaya & Waktu</td>
			</tr>
            <tr style="text-align:center;">			  
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
			$total_ak_realisasi= 0;
			$total_ak_target   = 0;
			
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
				if(!IS_NULL($real_arr['angka_kredit'])) {
					$ak  =  ' ('.$real_arr['angka_kredit'].'/'.$real_arr['satuan_kuantitas'].')';
					$tak =  $real_arr['angka_kredit'] * $real_arr['target_kuantitas'];
					$rak =  $real_arr['angka_kredit'] * $real_arr['realisasi_kuantitas'];
					$total_ak_target = $total_ak_target + $tak;
					$total_ak_realisasi = $total_ak_realisasi + $rak;
				}else{
					$ak  = "";
					$tak = "-";
					$rak = "-";					
					
				}
				
                ?>
                <tr>
                    <td align="center"><?= $no ?></td>
                    <td align="left"><?= $real_arr['kegiatan_tahunan'].$ak?></td>
					<td align="center"><?= $tak ?></td>
                    <td align="center"><?= $real_arr['target_kuantitas'] . ' ' . $real_arr['satuan_kuantitas'] ?></td>
                    <td align="center">100</td>
                    <td align="center"><?= $real_arr['target_waktu'] . ' bulan' ?></td>
                    <td align="center"><?= number_format($real_arr['biaya']) ?></td>
					<td align="center"><?= $tak ?></td>
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
			if($total_ak_target == 0){
					$total_ak_target = "-";
			} 
			
			if($total_ak_realisasi == 0){
					$total_ak_realisasi = "-";
			} 
            ?>
            <tr style="background:#dff0d8;font-weight:bold;">
                <td colspan="2" align="center">Jumlah</td>
				<td  align="center"><?php echo $total_ak_target?></td>
				<td colspan="4" align="center"></td>
				<td align="center"><?php echo $total_ak_realisasi?></td>
				<td colspan="5" align="center"></td>
                <td align="center"><?= !isset($ttl_nilai) ? $total_nilai = 0 : number_format($total_nilai = array_sum($ttl_nilai) / count($ttl_nilai), 2) ?></td>
                <td></td>
            </tr>
			<tr>
                <td colspan="13" align="left" style="font-weight: bold;">II. TUGAS TAMBAHAN DAN KREATIFITAS</td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td colspan="13" align="left" style="font-weight: bold;">a. Tugas Tambahan</td>
                <td></td>
                <td></td>
            </tr>
            <?php
			$sql="SELECT * FROM opmt_tugas_tambahan WHERE DATE(tanggal)  BETWEEN DATE('{$real_arr['awal_periode_skp']}') AND DATE('{$real_arr['akhir_periode_skp']}') AND id_dd_user='{$real_arr['id_dd_user']}' ";
			
						
			$tugas_tambahan = $this->db->query($sql)->result_array();
			
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
			$no = 1;
            foreach ($tugas_tambahan as $arr2) {
                ?>
                <tr>
				    <td><?php echo $no; ?>.</td>
                    <td colspan="12" align="left" ><?= $arr2['tugas_tambahan'] ?></td>
                    <?php if ($i == 0) { ?>
                        <td rowspan="<?= $ttl_tgs ?>" style="vertical-align: middle;text-align: center;"><?= $nilai_tgs; ?></td>
                    <?php } ?>
                    <td></td>
                </tr>
                <?php
                $i++;
				$no ++;
            }
			
            ?>
            
            <?php
            
			$bulan  = date('n',strtotime($real_arr['akhir_periode_skp']));
			$des ='<tr>              
				<td colspan="13" align="left" style="font-weight: bold;">b. Kreatifitas</td>
                <td></td>
                <td></td>
            </tr>';
           
			$ttl_kreatif = count($kreatifitas);
            $nilai_kreatif = 0;
			
			if($bulan === '12'){
				
				echo $des;			
				$j = 0;
				$no = 1;
				foreach ($kreatifitas as $arr3) {
					?>
					<tr>
						 <td><?php echo $no; ?>.</td>
						<td colspan="12" align="left" ><?= $arr3['kreatifitas'] ?></td>
						<?php if ($j == 0) { ?>
							<td rowspan="<?= $ttl_kreatif ?>" style="text-align: center;vertical-align: middle;"><?= $nilai_kreatif = isset($nilai_kreatifitas2['nilai_kreatifitas']) ? $nilai_kreatifitas2['nilai_kreatifitas'] : 0 ?></td>
							<?php
							$j++;
						}
						?>
						<td></td>
					</tr>
					<?php
					$no ++;
				}
			}	
            ?>
            <tr style="background:#dff0d8;font-weight:bold;">
                <td colspan="13" align="center">NILAI CAPAIAN SKP</td>
                <td align="center" ><?= number_format($nilai_tgs + $nilai_kreatif + $total_nilai, 2) ?></td>
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
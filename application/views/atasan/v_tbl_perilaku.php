<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_perilaku thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;font-size:12px;
    }
    #tbl_perilaku td{
        border:solid 1px black;
    }
</style>
<?php
foreach ($dt_perilaku as $arr) {
    ${"orientasi_" . $arr['bulan']} = $arr['orientasi_pelayanan'];
    ${"integritas_" . $arr['bulan']} = $arr['integritas'];
    ${"komitmen_" . $arr['bulan']} = $arr['komitmen'];
    ${"disiplin_" . $arr['bulan']} = $arr['disiplin'];
    ${"kerjasama_" . $arr['bulan']} = $arr['kerjasama'];
    ${"kepemimpinan_" . $arr['bulan']} = $arr['kepemimpinan'];
}
?>
<div class="row">
    <?php for ($i = 1; $i <= 6; $i++) {
        $bagi = 0;
        $a = 0;
        $b = 0;
        $c = 0;
        $d = 0;
        $e = 0;
        $f = 0;
        ?>
        <div class="col-md-2" style="padding:3px;">
            <table id="tbl_perilaku" class="table">
                <thead class="ui-state-default">
                    <tr>
                        <td><?= date('F', strtotime('2017-' . $i . '-01')) ?></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center;"><button class="btn btn-primary btn-sm" onclick="input_perilaku('<?= $i ?>')">Input</button></td>
                    </tr>
                    <tr>

                        <td>
                            Orientasi Pelayanan <span style="float:right;">: <?= isset(${"orientasi_" . $i}) ? $a = ${"orientasi_" . $i} : "" ?></span> <br>
                            Integritas <span style="float:right;">: <?= isset(${"integritas_" . $i}) ? $b = ${"integritas_" . $i} : "" ?></span><br>
                            Komitmen <span style="float:right;">: <?= isset(${"komitmen_" . $i}) ? $c = ${"komitmen_" . $i} : "" ?></span><br>
                            Disiplin <span style="float:right;">: <?= isset(${"disiplin_" . $i}) ? $d = ${"disiplin_" . $i} : "" ?></span><br>
                            Kerja Sama <span style="float:right;">: <?= isset(${"kerjasama_" . $i}) ? $e = ${"kerjasama_" . $i} : "" ?></span><br>
                            Kepemimpinan <span style="float:right;">: <?= isset(${"kepemimpinan_" . $i}) ? $f = ${"kepemimpinan_" . $i} : "" ?></span><br><br> 
        <?php if ($a > 0) {
            $bagi++;
        }if ($b > 0) {
            $bagi++;
        }if ($c > 0) {
            $bagi++;
        }if ($d > 0) {
            $bagi++;
        }if ($e > 0) {
            $bagi++;
        }if ($f > 0) {
            $bagi++;
        } ?>
                            Nilai Rata-Rata <span style="float:right;">: <?= isset(${"integritas_" . $i}) ? number_format(($a + $b + $c + $d + $e + $f) / $bagi, 2) : "" ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
<?php } ?>
</div>

<div class="row">
<?php
$bagi = 0;
for ($i = 7; $i <= 12; $i++) {
    $bagi = 0;
    $a = 0;
    $b = 0;
    $c = 0;
    $d = 0;
    $e = 0;
    $f = 0;
    ?>
        <div class="col-sm-2" style="padding:3px;">
            <table id="tbl_perilaku" class="table">
                <thead class="ui-state-default">
                    <tr>
                        <td><?= date('F', strtotime('2017-' . $i . '-01')) ?></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="text-align:center;"><button class="btn btn-primary btn-sm" onclick="input_perilaku('<?= $i ?>')">Input</button></td>
                    </tr>
                    <tr>
                        <td>
                            Orientasi Pelayanan <span style="float:right;">: <?= isset(${"orientasi_" . $i}) ? $a = ${"orientasi_" . $i} : "" ?></span> <br>
                            Integritas <span style="float:right;">: <?= isset(${"integritas_" . $i}) ? $b = ${"integritas_" . $i} : "" ?></span><br>
                            Komitmen <span style="float:right;">: <?= isset(${"komitmen_" . $i}) ? $c = ${"komitmen_" . $i} : "" ?></span><br>
                            Disiplin <span style="float:right;">: <?= isset(${"disiplin_" . $i}) ? $d = ${"disiplin_" . $i} : "" ?></span><br>
                            Kerja Sama <span style="float:right;">: <?= isset(${"kerjasama_" . $i}) ? $e = ${"kerjasama_" . $i} : "" ?></span><br>
                            Kepemimpinan <span style="float:right;">: <?= isset(${"kerjasama_" . $i}) ? $f = ${"kepemimpinan_" . $i} : "" ?></span><br><br> 
                            <?php if ($a > 0) {
                                $bagi++;
                            }if ($b > 0) {
                                $bagi++;
                            }if ($c > 0) {
                                $bagi++;
                            }if ($d > 0) {
                                $bagi++;
                            }if ($e > 0) {
                                $bagi++;
                            }if ($f > 0) {
                                $bagi++;
                            } ?>
                            Nilai Rata-Rata <span style="float:right;">: <?= isset(${"kerjasama_" . $i}) ? number_format(($a + $b + $c + $d + $e + $f) / $bagi, 2) : "" ?></span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
<?php }$bagi = 0; ?>
</div>
<div class="row">
    <div class="col-sm-12" style="padding:3px;">
        <table id="tbl_perilaku" class="table">
            <thead class="ui-state-default  ">
                <tr>
                    <td colspan="3">RATA-RATA NILAI TAHUNAN</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td style="width: 400px;border-right: 0px;" ></td>
                    <td style="border-left: 0px;border-right:0px;"">
                        Orientasi Pelayanan <span style="float:right;">: <?= isset($nilai_rata) ? $a = number_format($nilai_rata['orientasi']) : "" ?></span> <br>
                        Integritas <span style="float:right;">: <?= isset($nilai_rata) ? $b = number_format($nilai_rata['integritas']) : "" ?></span><br>
                        Komitmen <span style="float:right;">: <?= isset($nilai_rata) ? $c = number_format($nilai_rata['komitmen']) : "" ?></span><br>
                        Disiplin <span style="float:right;">: <?= isset($nilai_rata) ? $d = number_format($nilai_rata['disiplin']) : "" ?></span><br>
                        Kerja Sama <span style="float:right;">: <?= isset($nilai_rata) ? $e = number_format($nilai_rata['kerjasama']) : "" ?></span><br>
                        Kepemimpinan <span style="float:right;">: <?= isset($nilai_rata) ? $f = number_format($nilai_rata['kepemimpinan']) : "" ?></span><br><br> 
<?php if ($a > 0) {
    $bagi++;
}if ($b > 0) {
    $bagi++;
}if ($c > 0) {
    $bagi++;
}if ($d > 0) {
    $bagi++;
}if ($e > 0) {
    $bagi++;
}if ($f > 0) {
    $bagi++;
} ?>
                        Nilai Rata-Rata <span style="float:right;">: <?= isset($nilai_rata) ? number_format(($a + $b + $c + $d + $e + $f) / $bagi, 2) : "" ?></span>
                    </td>
                    <td style="width: 400px;border-left: 0px;" ></td>
                </tr>
            </tbody>
        </table>

    </div>
</div>
<script>
    function input_perilaku(id) {
        var id_user = $('#nama').val();
        var tahun = $('#tahun').val();
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_atasan/tambah_perilaku' + '/' + tahun + '/' + id + '/' + id_user);
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_SMALL);
        dialog.open();

    }
</script>
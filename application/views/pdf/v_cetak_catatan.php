<h4 style="text-align: center;">TAHUN : <?= $tahun ?></h4>
<h4 style="text-align: center;">NAMA :  <?= $nama ?></h4>
<div style="width:1360px;">
    <div style="margin: 0 auto;">
        <table padding="1" style="border:1px;" border="1" class="table table-bordered">

            <?php
            for ($i = 1; $i <= 12; $i++) {
                ?>
                <tr border="1">
                    <td style="background: rgb(15,36,63);color:white;text-align:center;"><?= bulan($i) ?></td>
                </tr>
                <?=
                !empty(${"cat_" . $i }) ? '<tr><td width="1024">' . implode(" ", ${"cat_" . $i }) . '</td></tr>' : "";
            }
            ?>
        </table>
    </div>
</div>
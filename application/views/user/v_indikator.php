<style>
    .table-striped{
        background: white;
    }
</style>
<div class="col-lg-6">
    <table class="table table-bordered table-striped">
        <thead style="color:white;font-weight: bold;background:blue;">
            <tr align="center">
                <td>No</td>
                <td>Indikator Kinerja Utama</td>
                <td>Target</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($indikator_utama as $dt1) {
                ?>
                <tr align="center">
                    <td><?= $no ?></td>
                    <td><?= $dt1['indikator_kinerja'] ?></td>
                    <td><?= $dt1['target'] ?></td>
                </tr>
                <?php $no++;
            } ?>
        </tbody>
    </table>
</div>
<div class="col-lg-6">
    <table class="table table-bordered table-striped">
        <thead style="color:white;font-weight: bold;background:blue;">
            <tr align="center">
                <td>No</td>
                <td>Indikator Kinerja Strategis</td>
                <td>Target</td>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            foreach ($indikator_strategis as $dt2) {
                ?>
                <tr align="center">
                    <td><?= $no ?></td>
                    <td><?= $dt2['indikator_kinerja'] ?></td>
                    <td><?= $dt2['target'] ?></td>
                </tr>
    <?php $no++;
} ?>
        </tbody>
    </table>
</div>
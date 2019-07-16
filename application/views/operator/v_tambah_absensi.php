<?php
if (!empty($absensi)) {
    $id_opmt_absensi = $absensi['id_opmt_absensi'];
    $nilai = $absensi['nilai_absensi'];
    $id_user = $absensi['id_dd_user'];
    $nama = $absensi['nama'];
    $nip = $absensi['nip'];
} else {
    $id_opmt_absensi = "";
    $nilai = "";
    $id_user = "";
    $nama = "";
    $nip = "";
}
?>
<style>
    ul,li{
        font-size:11px;
    }
    .ui-autocomplete {
        max-height: 200px;        z-index: 9999;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
    }  * html .ui-autocomplete {
        height: 100px;
    }
    .ui-autocomplete {
        position: absolute;
        top: 100%;
        left: 0;
        z-index: 9999;
        float: left;
        display: none;
        min-width: 160px;
        _width: 160px;
        padding: 4px 0;
        margin: 2px 0 0 0;
        list-style: none;
        background-color: #ffffff;
        border-color: #ccc;
        border-color: rgba(0, 0, 0, 0.2);
        border-style: solid;
        border-width: 1px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        -webkit-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -moz-box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        box-shadow: 0 5px 10px rgba(0, 0, 0, 0.2);
        -webkit-background-clip: padding-box;
        -moz-background-clip: padding;
        background-clip: padding-box;
        *border-right-width: 2px;
        *border-bottom-width: 2px;

        .ui-menu-item > a.ui-corner-all {
            display: block;
            padding: 3px 15px;
            clear: both;
            font-weight: normal;
            line-height: 18px;
            color: #555555;
            white-space: nowrap;

            &.ui-state-hover, &.ui-state-active {
                color: #ffffff;
                text-decoration: none;
                background-color: #0088cc;
                border-radius: 0px;
                -webkit-border-radius: 0px;
                -moz-border-radius: 0px;
                background-image: none;
            }
        }
    }
</style>
<form id="frm_absensi" method="post">
    <input type="hidden" name="id_opmt_absensi" value="<?= $id_opmt_absensi ?>">
    <table class="table" style="width:800px;">
        <tr>
            <td>Bulan</td>
            <td>
                <?php
                $tahun = date('Y');
                $bulan = (int) date('m');
                ?>
                <select class="form-control" id="bln" name="bulan">
                    <?php for ($i = 1; $i <= 12; $i++) { ?>
                        <option value = "<?= $i ?>" <?= $i == $bulan ? 'selected' : ''; ?>><?= bulan($i) ?></option>
                    <?php }
                    ?>
                </select>
            </td>
            <td>Tahun</td>
            <td>
                <select class="form-control" id="thn" name="tahun">
                    <?php for ($i = 2015; $i <= 2020; $i++) { ?>
                        <option value = "<?= $i ?>" <?= $i == $tahun ? 'selected' : ''; ?>><?= $i ?></option>
                    <?php }
                    ?>
                </select>
            </td>
        </tr><tr>
            <td>NIP</td>
            <td>
                <input type="hidden" id="id_user" name="id_dd_user" value="<?= $id_user ?>"> 
                <input type="text" id="nip" class="form-control" value="<?= $nip ?>">
            </td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><div id="nama"><?= $nama ?></div></td>
        </tr>
        <tr>
            <td>Nilai Absensi</td>
            <td><input type="text" class="form-control" name="nilai_absensi" value="<?= $nilai ?>"></td>
        </tr>

    </table>
</form>
<div style="text-align:right;margin-right:10px;">
    <button class="btn btn-primary" onclick="simpan_absensi()">SIMPAN</button>
</div>

<script>
    function simpan_absensi() {
        $("#frm_absensi").submit();
    }

    $("#frm_absensi").submit(function (e) {
        e.preventDefault();
        var frm_absensi = $("#frm_absensi");
        var form = getFormData(frm_absensi);
        $.ajax({
            type: "POST",
            url: "c_operator/aksi_absensi",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                lihat_absensi();
                $('.close').click();
            } else {
                alert(response.ket);
            }
        });

    });
    $("#nip").autocomplete({
        source: function (request, response) {
            $.ajax({
                type: "POST",
                url: "c_operator/get_nip",
                data: {q: request.term},
                success: response,
                dataType: 'json',
                minLength: 2,
                delay: 100
            });
        },
        select: function (event, ui) {
            $('#id_user').val(ui.item.id);
            $('#nama').html(ui.item.nama);
        }});
</script>
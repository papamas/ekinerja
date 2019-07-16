<style>
    td{
        vertical-align: middle !important;font-family: "gotham";
    } .ui-autocomplete {
        max-height: 200px;        z-index: 9999;
        overflow-y: auto;
        /* prevent horizontal scrollbar */
        overflow-x: hidden;
    }  * html .ui-autocomplete {
        height: 100px;
    }
    .ui-autocomplete {
        position: absolute;font-size:12px;
        top: 100%;
        left: 0;
        z-index: 9999;
        float: left;
        display: none;
        min-width: 160px;
        width: 160px;
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
    }.ui-autocomplete-input{font-size: 12px;}.ui-menu-item{font-size: 12px;}
</style>
<form id="frmUser" method="post">
    <table class="table">
        <tr>
            <td>NIP</td>
            <td><input type="text" class="form-control " name="nip"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" class="form-control " name="nama"></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>
                 <input class="jabatan form-control" type="text">
                <input type="hidden" name="jabatan" id="jabatan">
            </td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>
                <input class="uker form-control" type="text">
                <input type="hidden" name="unit_kerja" id="unit_kerja">
            </td>
        </tr>
        <tr>
            <td>Gol. Ruang / Pangkat</td>
            <td>
                <input class="gol_ruang form-control" type="text">
                <input type="hidden" name="gol_ruang" id="gol_ruang">
            </td>
        </tr>

        <tr>
            <td>Username</td>
            <td><input type="text" class="form-control " name="username"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="text" class="form-control " name="password"></td>
        </tr>


        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary">Simpan</button></td>
        </tr>
    </table>
</form>

<script>

    $("#frmUser").submit(function (e) {
        e.preventDefault();
        var frmUser = $("#frmUser");
        var form = getFormData(frmUser);
        $.ajax({
            type: "POST",
            url: "admin/c_user/aksi_tambah",
            data: JSON.stringify(form),
            dataType: 'json'
        }).done(function (response) {
            if (response.status === 1) {
                alert(response.ket);
                $('.close').click();
                menu('admin/c_user');
            } else {
                alert(response.ket);
            }
        });

    });

    $(".uker").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?= base_url('admin/c_user/uker_json') ?>",
                type: "POST",
                data: {q: request.term},
                dataType: 'json',
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 0,
        select: function (event, ui) {
            var id = ($(this).attr('id'));
            $('#unit_kerja').val(ui.item.id);
        }, open: function () {
            var id = ($(this).attr('id'));
            $('#unit_kerja').val('');
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
    $(".gol_ruang").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?= base_url('admin/c_user/gol_ruang_json') ?>",
                type: "POST",
                data: {q: request.term},
                dataType: 'json',
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 0,
        select: function (event, ui) {
            $('#gol_ruang').val(ui.item.id);
        }, open: function () {
            $('#gol_ruang').val('');
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
    $(".jabatan").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "<?= base_url('admin/c_user/jabatan_json') ?>",
                type: "POST",
                data: {q: request.term},
                dataType: 'json',
                success: function (data) {
                    response(data);
                }
            });
        },
        minLength: 0,
        select: function (event, ui) {
            $('#jabatan').val(ui.item.id);
        }, open: function () {
            $('#jabatan').val('');
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
</script>
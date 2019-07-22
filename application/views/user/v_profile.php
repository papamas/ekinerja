<?php
if (isset($user)) {
    $id_dd_user = $user['id_dd_user'];
    $nip = $user['nip'];
    $nama = $user['nama'];
    $username = $user['username'];

    $jabatan_data = $user['nama_jabatan'];
    $pangkat = $user['Pangkat'] . ' / ' . $user['Golongan'];
    $uker_data = $user['nama_uker'];
    $atasan_langsung = $user['atasan_langsung'];
    $atasan_2 = $user['atasan_2'];
    $atasan_3 = $user['atasan_3'];
	$lokasi = $user['lokasi'];
} else {
    $id_dd_user = "";
    $nip = "";
    $nama = "";
    $username = "";
    $password = "";
    $jabatan_data = "";
    $uker_data = "";
    $atasan_langsung = "";
    $atasan_2 = "";
    $atasan_3 = "";
	$lokasi = "";
}
?>
<style>
    .ui-autocomplete {
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
<form id="frm_user" method="post" style="overflow: auto;height:400px;">
    <table class="table">
        <tr>
            <td style="width:100px;">NIP</td>
            <td> : </td> 
            <td>
                <input type="hidden" name="id_dd_user" value="<?= $id_dd_user ?>">
                <input type="text" class="form-control"  value="<?= $nip ?>" readonly></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" value="<?= $nama ?>" readonly></td>
        </tr>
        <tr>
            <td>Username</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" value="<?= $username ?>" readonly></td>
        </tr>
        <tr>
            <td>Password (Jika ingin diubah)</td>
            <td> : </td> 
            <td>
                <input type="password" class="form-control" name="password" id="password" >
            </td>
        </tr>
        <tr>
            <td>Konfirmasi Password</td>
            <td> : </td> 
            <td>
                <input type="password" class="form-control" id="password_ulang">
            </td>
        </tr>
        <tr>
            <td>Atasan Langsung</td>
            <td> : </td>
            <td>
                <input type="text" class="form-control atasan" id="atasan_langsung" name="atasan_langsung" value="<?= $user['nama_1'] ?>"></td>
        <input type="hidden" name="atasan_langsung" id="atasan_langsung_id" value="<?= $user['atasan_langsung'] ?>">
        </tr>
        <tr>
            <td>Atasan II</td>
            <td> : </td>
            <td>
                <input type="text" class="form-control atasan" id="atasan_2" name="atasan_2" value="<?= $user['nama_2'] ?>"></td>
        <input type="hidden" name="atasan_2" id="atasan_2_id" value="<?= $user['atasan_2'] ?>">
        </tr>
        <tr>
            <td>Atasan III</td>
            <td> : </td>
            <td>
                <input type="text" class="form-control atasan" id="atasan_3" name="atasan_3" value="<?= $user['nama_3'] ?>"></td>
        <input type="hidden" name="atasan_3" id="atasan_3_id" value="<?= $user['atasan_3'] ?>">
        </tr>

        <tr>
            <td>Unit Kerja</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" value="<?= $uker_data ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" value="<?= $jabatan_data ?>" readonly>
            </td>
        </tr>
        <tr>
            <td>Pangkat/Gol. Ruang</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" value="<?= $pangkat ?>" readonly> 
            </td>
        </tr>
		 <tr>
            <td>Lokasi Kerja</td>
            <td> : </td> 
            <td>
                <input type="text" class="form-control" value="<?=$lokasi?>" id="lokasi"  > 
				 <input type="hidden" name="lok_ker" id="lokasi_id" value="<?= $user['lok_ker'] ?>">
            </td>
        </tr>
        <tr>
            <td></td>
            <td> </td>
            <td><button class="btn btn-primary" id="btn_simpan" >Simpan</button></td>
        </tr>
    </table>
</form>
<script>
    $('#password').val('');
    $("#frm_user").submit(function (e) {
        e.preventDefault();
        var pass = $('#password').val();
        var pass_ulang = $('#password_ulang').val();
        if (pass !== pass_ulang && pass !== "") {
            alert('Password tidak sama');
            $('#password_ulang').focus();
        } else {
            var frm_user = $("#frm_user");
            var form = getFormData(frm_user);
            $.ajax({
                type: "POST",
                url: "c_user/aksi_profile",
                data: JSON.stringify(form),
                dataType: 'json'
            }).done(function (response) {
                if (response.status === 1) {
                    alert(response.ket);
                    $('.close').click();
                    //refresh_user();
                } else {
                    alert(response.ket);
                }
            });
        }
    });
    $(".atasan").autocomplete({
        source: function (request, response) {

            $.ajax({
                url: "<?= base_url('c_user/get_user') ?>",
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
            $('#' + id + "_id").val(ui.item.id);
//            $('#atasan2').val(ui.item.label);
        }, open: function () {
            var id = ($(this).attr('id'));
            $('#' + id + "_id").val('');
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
	
	$("#lokasi").autocomplete({
        source: function (request, response) {

            $.ajax({
                url: "<?= base_url('c_user/get_lokasi') ?>",
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
			 $('#' + id + "_id").val(ui.item.id);
//            $('#atasan2').val(ui.item.label);
        }, open: function () {
            var id = ($(this).attr('id'));
            $('#' + id + "_id").val('');
            $(this).removeClass("ui-corner-all").addClass("ui-corner-top");
        },
        close: function () {
            $(this).removeClass("ui-corner-top").addClass("ui-corner-all");
        }
    });
</script>
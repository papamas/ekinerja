<table class="table" id="tbl_detail">
    <?php foreach ($dt_user as $dt) { ?>
        <input type="hidden" name="id_dd_user" value="<?= $dt['id_dd_user'] ?>">
        <tr>
            <td>NIP</td>
            <td><input type="text" class="form-control " name="nip" value="<?= $dt['nip'] ?>"></td>
        </tr>
        <tr>
            <td>Nama</td>
            <td><input type="text" class="form-control " name="nama" value="<?= $dt['nama'] ?>"></td>
        </tr>
        <tr>
            <td>Jabatan</td>
            <td>
                <input class="jabatan form-control" type="text" value="<?= $dt['jabatan'] ?>">
                <input type="hidden" name="jabatan" id="jabatan" value="<?= $dt['kodejab'] ?>"
            </td>
        </tr>
        <tr>
            <td>Unit Kerja</td>
            <td>
                <input class="uker form-control" type="text" value="<?= $dt['unitkerja'] ?>">
                <input type="hidden" name="unit_kerja" id="unit_kerja" value="<?= $dt['kodeunit'] ?>">
            </td>
        </tr>
        <tr>
            <td>Gol. Ruang / Pangkat</td>
            <td>
                <input class="gol_ruang form-control" type="text" value="<?= $dt['nama_golongan'] ?>">
                <input type="hidden" name="gol_ruang" id="gol_ruang" value="<?= $dt['id_dd_ruang_pangkat'] ?>">
            </td>
        </tr>

        <tr>
            <td>Username</td>
            <td><input type="text" class="form-control " name="username" value="<?= $dt['username'] ?>"></td>
        </tr>
        <tr>
            <td>Password</td>
            <td><input type="text" class="form-control " name="password" value="<?= base64_decode($dt['password']) ?>"></td>
        </tr>
        <tr>
            <td>Atasan Langsung</td>
            <td><input type="text" class="form-control " name="username" value="<?= $dt['atasan_langsung'] ?>"></td>
        </tr>
        <tr>
            <td>Atasan II</td>
            <td><input type="text" class="form-control " name="username" value="<?= $dt['atasan_2'] ?>"></td>
        </tr>
        <tr>
            <td>Atasan III</td>
            <td><input type="text" class="form-control " name="username" value="<?= $dt['atasan_3'] ?>"></td>
        </tr>

        <tr>
            <td></td>
            <td style="text-align: right;"><button class="btn btn-primary" onclick="$('.close').click()">Simpan</button></td>
        </tr>
    <?php } ?>
</table>
<script>
    $('#tbl_detail input').attr('disabled', 'true');
</script>
<div style="padding:10px;">
    <div style="float:right;font-size:12px !important;">
        <table>
            <tr>
                <td>Nama Bawahan</td>
                <td>
                    <select class="form-control" id="nama">
                        <?= pilihan_list($bawahan, "nama", "id_dd_user", "") ?>
                    </select>
                </td>
                <td>Tahun</td>
                <td>
                    <select class="form-control" id="tahun">
                        <?= pilihan_list($tahun, "tahun", "tahun", "") ?>
                    </select>
                </td>
                <td>  <button class="btn btn-primary" onclick="lihat_perilaku()" <?= count($bawahan) == 0 ? 'disabled' : '' ?>>Cari</button></td>
            </tr>
        </table>
    </div>
    <div style="clear:both;margin-bottom:10px;"></div>
    <div id="ajaxPerilaku"></div>
</div>

<script>

    function lihat_perilaku() {
        var id_user = $('#nama').val();
        var tahun = $('#tahun').val();
        if (id_user === "") {
            alert("Anda Tidak Memiliki Bawahan");
        } else {
            $.post('c_atasan/lihat_perilaku', {id_user: id_user, tahun: tahun}, function (hasil) {
                $('#ajaxPerilaku').html(hasil);
            });
        }
    }
</script>
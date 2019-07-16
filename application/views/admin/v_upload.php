<form id="frm_user" method="POST" >
    <table class="table">

        <tr>
            <td>Browse File</td>
            <td>&nbsp;:&nbsp;</td>
            <td>
                <div style="position:relative;">
                    <a class='btn btn-primary btn-sm' href='javascript:;'><div id="file_upload_dokumen"> Upload Dokumen</div>   
                        <input type="file" id="file_upld" style='position:absolute;z-index:2;top:0;left:0;filter: alpha(opacity=0);-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=0)";opacity:0;background-color:transparent;color:transparent;' name="file_upload" size="40"  onchange='$("#file_upload_dokumen").text($(this).val());
                                $("#nama_file_upload_dokumen").val($(this).val());'>
                    </a>
                    &nbsp;
                    <input type="text" name="nama_file_upload" id="nama_file_upload_dokumen" style="display: none;">
                </div>

            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <button class="btn btn-primary btn-sm entypo-upload-cloud" id="btn_upload"><i class="fa fa-upload" id="i_upload" ></i> Upload</button></td>
            </td>

        </tr>
    </table>
</form>

<script>
    $("#frm_user").on('submit', (function (e) {
        $('#btn_upload').prop('disabled', true);
        e.preventDefault();
        if ($("#nama_file_upload_dokumen").val() == "") {
            alert('File Upload Masih Kosong');
        } else {

            $.ajax({
                url: "<?= base_url('c_admin/proses_upload_user') ?>", // Url to which the request is send
                type: "POST", // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                beforeSend: function () {
                    $('#btn_upload').prop('disabled', true);
                },
                success: function (data) {
//                    NProgress.done();
                    if (data.status == '1') {
                        $("#file_upload_dokumen").html('Upload Dokumen');
                        $("#nama_file_upload").val('');
                        alert('Total Data : ' + data.total + ' Data Berhasil Ditambah : ' + data.dt_masuk + ' Status : ' + data.ket + ' Uploaded Time : ' + data.lama);
                        $('.close').click();
                    } else {
                        alert(data.ket);
                        alert(data.detail.message);

                    }
                }
            }
            );
        }
    }));
</script>
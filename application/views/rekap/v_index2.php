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
<div class="row" style="margin-top:-40px;">
    <div class="col-sm-12">
        <div style="float:left;">
            <table>
                <tr>
                    <td>  
                        <div class="input-group">
                            <div class="input-group-addon">Bulan</div>
                            <select class="form-control ui-state-focus" id="bulan">
                                <?php for ($i = 1; $i <= 12; $i++) { ?>
                                    <option value="<?= $i ?>" <?= $i == (int) date('m') ? 'selected' : '' ?>>
                                        <?= bulan($i) ?>
                                    </option>
                                <?php } ?>                            </select>
                        </div>
                    </td>
                    <td>                 
                        <div class="input-group">
                            <div class="input-group-addon">Tahun</div>
                            <select class="form-control ui-state-focus" id="tahun">
                                <?= pilihan_list($tahun, 'tahun', 'tahun', date('Y')) ?>
                            </select>
                        </div>
                    </td>

                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">Unit</div>
                            <input type="text" class="form-control atasan" id="uker" name="uker" >
                            <input type="hidden" id="uker_id">
                        </div>
                    </td>
                    <td>
                        <div class="input-group">
                            <div class="input-group-addon">Status</div>
                            <select class="form-control ui-state-default" id="status">
                                <option value="1">Disetujui</option>                                
                                <option value="2">Belum Disetujui</option>                                
                                <option value="3" selected="">Belum Membuat SKP Bulanan</option>                                
                            </select>
                        </div>
                    </td>
                    <td>   
                        <button class="btn btn-primary" onclick="lihat_laporan()"><i class="fa fa-search"></i>Cari</button>
                    </td>
                </tr>
            </table>
        </div>
        <div style="float:right;">

        </div>
    </div>
</div>
<div id="ajaxLaporan"></div>
<script>
    function lihat_laporan() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        var jenis = $('#uker_id').val();
        var status = $('#status').val();
        $.post('admin/c_rekap_skp/lihat_laporan', {bulan: bulan, tahun: tahun, jenis: jenis, status: status}, function (data) {
            $('#ajaxLaporan').html(data);
        });
    }
    lihat_laporan();

    $(".atasan").autocomplete({
        source: function (request, response) {

            $.ajax({
                url: "<?= base_url('admin/c_rekap_skp/get_uker') ?>",
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


    function cetak_rekap() {
        var bulan = $('#bulan').val();
        var tahun = $('#tahun').val();
        var jenis = $('#uker_id').val();
if(jenis==''){jenis=0;}
 	var status = $('#status').val();
        var dialog = new BootstrapDialog({
            title: '<div style="font-size:12px;">Laporan Rekap</div>',
            message: function () {
//                var $message = $('<div></div>').load('c_pdf/cetak_jfk/' + jenis'/'.status );
                var $message = $('<iframe src=c_pdf/cetak_rekap/' + bulan + '/' + tahun + '/' + jenis +'/'+status+ ' style="width:100%;height:300px;"></iframe>');
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

<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_tahunan_skp thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_tahunan_skp td{
        border:solid 1px black;
		}.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>
<div style="float:left;">
    <table>
        <tr>
            <td>
                <button class="btn btn-success fa fa-pencil-square" onclick="tambah_tahunan_skp()"> Tambah Periode SKP</button>
            </td>
        </tr>
    </table>
</div>
<div style="float:right;"> 
    <table>
        <tr>
            <td>  
                <div class="input-group">
                    <div class="input-group-addon">Tahun</div>
                    <input  type="text" id="tahunan_skp" class="form-control">
                </div>
            </td>
            <td>
                <button class="btn btn-primary fa fa-search" onclick="refresh_tahunan_skp()"> Cari</button>   
            </td>
        </tr>
    </table>
</div>
<br>
<table id="tbl_tahunan_skp" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    function get_tbl_tahunan_skp() {
       
        $('#tbl_tahunan_skp').bootstrapTable({
            url: '<?= base_url('C_user/dt_tahunan_skp') ?>',
            queryParams: function (p) {
                return{
                    tahunan_skp: $('#tahunan_skp').val(),
                    search: p.search,
                    limit: p.limit,
                    offset: p.offset,
                    order: p.order,
                    sort: p.sort
                };
            },
            columns: [
                {
                    field: 'no', title: 'No', halign: 'center', class: 'tengah', valign: 'middle'
                },
                {
                    field: 'periode_skp', title: 'Periode SKP', class: 'kiri', valign: 'middle', halign: 'center'
                },
             
                {
                    field: 'link_edit', title: 'Edit', halign: 'center', class: 'tengah', valign: 'middle'
                },
                {
                    field: 'link_hapus', title: 'Hapus', halign: 'center', class: 'tengah', valign: 'middle'
                },
                {
                    field: 'link_target_skp', title: 'Target SKP', halign: 'center', class: 'tengah', valign: 'middle'
                },
                {
                    field: 'link_realisasi', title: 'Realisasi', halign: 'center', class: 'tengah', valign: 'middle'
                },
            ],
            pagination: true, clickToSelect: true,
            sortable: true, striped: true,
            sidePagination: 'server',
            searchOnEnterKey: true, search: false,
            checkbox: true
            , responseHandler: function (res) {
                $('#loading_time').html('Loaded in ' + res.lama + ' detik');
                return res;
            },
            onLoadSuccess: function (a) {
                return false;
            }
        });

    }
    get_tbl_tahunan_skp();

    function tambah_tahunan_skp() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/tambah_tahunan_skp');
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_NORMAL);
        dialog.open();

    }
	
	function target_tahunan_skp(id){
		menu('C_user/target_tahunan_skp'+'/'+id);
	}
		
	function realisasi_tahunan_skp(id){
		menu('C_user/realisasi_tahunan_skp'+'/'+id);
	}
	
    function ubah_tahunan_skp(id) {

        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/ubah_tahunan_skp' + '/' + id);
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_NORMAL);
        dialog.open();

    }

    function hapus_tahunan_skp(id) {
        var r = confirm("Yakin ingin menghapus tahunan_skp ini ?");
        if (r) {
            $.post('C_user/hapus_tahunan_skp', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    refresh_tahunan_skp();
                }
            });


        }
    }
    function refresh_tahunan_skp() {
        $('#tbl_tahunan_skp').bootstrapTable('refresh');
    }
</script>
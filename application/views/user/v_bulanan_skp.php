<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_bulanan_skp thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_bulanan_skp td{
        border:solid 1px black;
		}.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>
<div style="float:left;">
    <table>
        <tr>
            <td>
                <button class="btn btn-success fa fa-pencil-square" onclick="tambah_bulanan_skp()"> Tambah Periode SKP</button>
            </td>
        </tr>
    </table>
</div>

<table id="tbl_bulanan_skp" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    function get_tbl_bulanan_skp() {  
        $('#tbl_bulanan_skp').bootstrapTable({
            url: '<?= base_url('C_user/dt_bulanan_skp') ?>',
            queryParams: function (p) {
                return{
//                    bulanan_skp: $('#bulanan_skp').val(),
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
                    field: 'tahun', title: 'Tahun', class: 'tengah', valign: 'middle', halign: 'center'
                },
              {
                    field: 'bulan', title: 'Bulan', class: 'tengah', valign: 'middle', halign: 'center'
                },
              {
                    field: 'status_approve', title: 'Status Approve', class: 'tengah', valign: 'middle', halign: 'center'
                },
               
                {
                    field: 'link_hapus', title: 'Hapus', halign: 'center', class: 'tengah', valign: 'middle'
                },
                {
                    field: 'link_target_skp', title: 'Target SKP Bulanan', halign: 'center', class: 'tengah', valign: 'middle'
                },
                {
                    field: 'link_realisasi', title: 'Realisasi SKP Bulanan', halign: 'center', class: 'tengah', valign: 'middle'
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
    get_tbl_bulanan_skp();

    function tambah_bulanan_skp() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('C_user/tambah_bulanan_skp');
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
	
	function target_bulanan_skp(id){
		menu('C_user/target_bulanan_skp'+'/'+id);
	}
		
	function realisasi_bulanan_skp(id){
		menu('C_user/realisasi_bulanan_skp'+'/'+id);
	}
	
    function ubah_bulanan_skp(id) {

        var dialog = new BootstrapDialog({
            message: function () {
                    var $message = $('<div></div>').load('C_user/ubah_bulanan_skp' + '/' + id);
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

        function hapus_bulanan_skp(id) {
            var r = confirm("Yakin ingin menghapus bulanan_skp ini ?");
            if (r) {
                $.post('C_user/hapus_bulanan_skp', {id: id}, function (data) {
                    if (data.status == 1) {
                        alert(data.ket);
                        refresh_bulanan_skp();
                    }
                });


            }
        }
    function refresh_bulanan_skp() {
        $('#tbl_bulanan_skp').bootstrapTable('refresh');
    }
</script>
<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_uker thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_uker td{
        border:solid 1px black;
		}.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>

<div style="float:left;">
    <table>
        <tr>
            <td>
                <button class="btn btn-success fa fa-pencil-square" onclick="tambah_uker()"> Tambah</button>
            </td>
        </tr>
    </table>
</div>
<div style="float:right;"> 
    <table>
        <tr>
            <td>  
                <div class="input-group">
                    <div class="input-group-addon">Uker</div>
                    <input  type="text" id="uker" class="form-control">
                </div>
            </td>
            <td>
                <button class="btn btn-primary fa fa-search" onclick="refresh_uker()"> Cari</button>   
            </td>
        </tr>
    </table>
</div>
<br>
<table id="tbl_uker" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    function get_tbl_uker() {
       
        $('#tbl_uker').bootstrapTable({
            url: '<?= base_url('c_admin/dt_uker') ?>',
            queryParams: function (p) {
                return{
                    uker: $('#uker').val(),
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
                    field: 'nama_uker', title: 'Nama Unit Kerja', class: 'tengah', valign: 'middle', halign: 'center'
                },
             
                {
                    field: 'link_edit', title: 'Edit', halign: 'center', class: 'tengah', valign: 'middle'
                },
                {
                    field: 'link_hapus', title: 'Hapus', halign: 'center', class: 'tengah', valign: 'middle'
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
    get_tbl_uker();

    function tambah_uker() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/tambah_uker');
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
    function ubah_uker(id) {

        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/ubah_uker' + '/' + id);
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

    function hapus_uker(id) {
        var r = confirm("Yakin ingin menghapus uker ini ?");
        if (r) {
            $.post('c_admin/hapus_uker', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    refresh_uker();
                }
            });


        }
    }
    function refresh_uker() {
        $('#tbl_uker').bootstrapTable('refresh');
    }
</script>
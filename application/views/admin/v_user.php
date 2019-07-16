<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_user thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_user td{
        border:solid 1px black;
		}.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>

<div style="float:left;">
    <table>
        <tr>
            <td>
                <button class="btn btn-success fa fa-pencil-square" onclick="tambah_user()"> Tambah</button>
            </td>
            <td>&nbsp;</td>
            <td>
                <button class="btn btn-primary fa fa-upload" onclick="import_user()"> Import</button>
            </td>
            <td>&nbsp;</td>
            <td>
                <a class="btn btn-info fa fa-file-excel-o" href="_files/templete _user_gresik.xls" > Template</a>
            </td>
        </tr>
    </table>
</div>
<div style="float:right;"> 
    <table>
        <tr>
            <td>  
                <div class="input-group">
                    <div class="input-group-addon">NIP</div>
                    <input  type="text" id="nip" class="form-control">
                </div>
            </td>
            <td>  
                <div class="input-group">
                    <div class="input-group-addon">Nama</div>
                    <input  type="text" id="nama" class="form-control">
                </div>
            </td>
            <td>
                <button class="btn btn-primary fa fa-search" onclick="refresh_user()"> Cari</button>   
            </td>
        </tr>
    </table>
</div>
<br>
<table id="tbl_user" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    function get_tbl_user() {

        $('#tbl_user').bootstrapTable({
            url: '<?= base_url('c_admin/dt_user') ?>',
            queryParams: function (p) {
                return{
                    nip: $('#nip').val(),
                    nama: $('#nama').val(),
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
                    field: 'nip', title: 'NIP', class: 'tengah', valign: 'middle', halign: 'center'
                },
                {
                    field: 'nama', title: 'Nama', class: 'tengah', valign: 'middle', halign: 'center'
                },
                {
                    field: 'jabatan', title: 'Jabatan', class: 'tengah', valign: 'middle', halign: 'center'
                },
                {
                    field: 'username', title: 'Username', class: 'tengah', valign: 'middle', halign: 'center'
                },
                {
                    field: 'password', title: 'Password', class: 'tengah', valign: 'middle', halign: 'center'
                },
                {
                    field: 'link_detail', title: 'Detail', halign: 'center', class: 'tengah', valign: 'middle'
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
    get_tbl_user();

    function tambah_user() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/tambah_user');
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
    function ubah_user(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/ubah_user' + '/' + id);
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
    function detail_user(id) {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/detail_user' + '/' + id);
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
    function import_user() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/upload_user' );
                return $message;
            }
        });
        dialog.realize();
        dialog.getModalHeader().hide();
        dialog.getModalBody().css('background-color', 'lightblue');
        dialog.getModalBody().css('color', '#000');
        dialog.setSize(BootstrapDialog.SIZE_SMALL);
        dialog.open();
    }

    function hapus_user(id) {
        var r = confirm("Yakin ingin menghapus user ini ?");
        if (r) {
            $.post('c_admin/hapus_user', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    refresh_user();
                }
            });


        }
    }
    
    function refresh_user() {
        $('#tbl_user').bootstrapTable('refresh');
    }
</script>
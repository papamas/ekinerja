<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_operator thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_operator td{
        border:solid 1px black;
		}.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>
<div style="float:left;">
    <table>
        <tr>
            <td>
                <button class="btn btn-success fa fa-pencil-square" onclick="tambah_operator()"> Tambah</button>
            </td>
        </tr>
    </table>
</div>
<div style="float:right;"> 
    <table>
        <tr>
            <td>  
                <div class="input-group">
                    <div class="input-group-addon">Operator</div>
                    <input  type="text" id="Operator" class="form-control">
                </div>
            </td>
            <td>
                <button class="btn btn-primary fa fa-search" onclick="refresh_Operator()"> Cari</button>   
            </td>
        </tr>
    </table>
</div>
<br>
<table id="tbl_operator" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    function get_tbl_operator() {
        $('#tbl_operator').bootstrapTable({
            url: '<?= base_url('c_admin/dt_operator') ?>',
            queryParams: function (p) {
                return{
                    Operator: $('#Operator').val(),
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
                    field: 'username', title: 'Username Operator Absensi', class: 'tengah', valign: 'middle', halign: 'center'
                },

                {
                    field: 'password', title: 'Password Operator Absensi', class: 'tengah', valign: 'middle', halign: 'center'
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
    get_tbl_operator();

    function tambah_operator() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/tambah_operator');
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
    function ubah_operator(id) {

        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/ubah_operator' + '/' + id);
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

    function hapus_operator(id) {
        var r = confirm("Yakin ingin menghapus operator ini ?");
        if (r) {
            $.post('c_admin/hapus_operator', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    menu('c_admin/operator')
                }
            });


        }
    }
    function refresh_operator() {
        $('#tbl_operator').bootstrapTable('refresh');
    }
</script>
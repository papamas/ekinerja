
<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 390px !important;}
    #tbl_jabatan thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_jabatan td{
        border:solid 1px black;
		}.judul{font-weight: bold;}.pagination .page-pre{color:black !important;}.tengah{text-align:center;}
</style>

<div style="float:left;">
    <table>
        <tr>
            <td>
                <button class="btn btn-success fa fa-pencil-square" onclick="tambah_jabatan()"> Tambah</button>
            </td>
        </tr>
    </table>
</div>
<div style="float:right;"> 
    <table>
        <tr>
            <td>  
                <div class="input-group">
                    <div class="input-group-addon">Jabatan</div>
                    <input  type="text" id="jabatan" class="form-control">
                </div>
            </td>
            <td>
                <button class="btn btn-primary fa fa-search" onclick="refresh_jabatan()"> Cari</button>   
            </td>
        </tr>
    </table>
</div>
<br>
<table id="tbl_jabatan" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>

<script>
    function get_tbl_jabatan() {
        var jabatan = $('#jabatan').val();
      
        $('#tbl_jabatan').bootstrapTable({
            url: '<?= base_url('c_admin/dt_jabatan') ?>',
            queryParams: function (p) {
                return{
                    jabatan: $('#jabatan').val(),
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
                    field: 'nama_jabatan', title: 'Jabatan', class: 'tengah', valign: 'middle', halign: 'center'
                },
                {
                    field: 'tunjangan', title: 'Nominal Tunjangan', halign: 'center', class: 'tengah', valign: 'middle'
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
    get_tbl_jabatan();

    function tambah_jabatan() {
        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/tambah_jabatan');
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
    function ubah_jabatan(id) {

        var dialog = new BootstrapDialog({
            message: function () {
                var $message = $('<div></div>').load('c_admin/ubah_jabatan' + '/' + id);
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

    function hapus_jabatan(id) {
        var r = confirm("Yakin ingin menghapus jabatan ini ?");
        if (r) {
            $.post('c_admin/hapus_jabatan', {id: id}, function (data) {
                if (data.status == 1) {
                    alert(data.ket);
                    refresh_jabatan();
                }
            });


        }
    }
    function refresh_jabatan() {
        $('#tbl_jabatan').bootstrapTable('refresh');
    }
</script>
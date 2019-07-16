<style>
    .table,btn{font-size:12px !important;}.fixed-table-body{height: 200px !important;}
    #tbl_bawahan thead{
        background-color:#006e2e;text-align:center;font-weight:bold;color:white;border:solid 1px black;
    }.angka{text-align: right;}.tengah{text-align: center;}
    #tbl_bawahan td{
        border:solid 1px black;
    }
</style>

<table id="tbl_bawahan" data-toolbar="#toolbar2" data-toggle="table" data-pagination="true">

</table>
<script>
    function drop_staff_bawahan(id) {
        var r = confirm("Yakin ingin mendrop staff bawahan ini ?");
        if (r) {
            $.post('c_atasan/drop_staff_bawahan', {id: id}, function (hasil) {
                if (hasil.status == 1) {
                    menu('c_atasan/staff_bawahan');
                }
            });
        }
    }

         $('#tbl_bawahan').bootstrapTable({
            url: '<?= base_url('c_atasan/dt_bawahan') ?>',
            queryParams: function (p) {
                return{
                 
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
                    field: 'nama', title: 'Nama Bawahan', class: 'tengah', valign: 'middle', halign: 'center'
                },
                {
                    field: 'nip', title: 'NIP', class: 'tengah', valign: 'middle', halign: 'center'
                },
                {
                    field: 'nama_jabatan', title: 'Jabatan', halign: 'center', class: 'tengah', valign: 'middle'
                },
                {
                    field: 'link_drop', title: 'Drop', halign: 'center', class: 'tengah', valign: 'middle'
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
</script>
<html>
    <head>
        <title>EKINERJA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="EKINERJA" />
        <link href="_images/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <style>
            .badge {
                -webkit-animation-name: blinker;
                -webkit-animation-duration: 1s;
                -webkit-animation-timing-function: linear;
                -webkit-animation-iteration-count: infinite;

                -moz-animation-name: blinker;
                -moz-animation-duration: 1s;
                -moz-animation-timing-function: linear;
                -moz-animation-iteration-count: infinite;

                animation-name: blinker;
                animation-duration: 1s;
                animation-timing-function: linear;
                animation-iteration-count: infinite;
            }
            .badge:hover {
                color: #ffffff;
                text-decoration: none;
                cursor: pointer;
            }
            .badge-error {
                background-color: #b94a48;
            }
            .badge-error:hover {
                background-color: #953b39;
            }
            .badge-warning {
                background-color: #f89406;
            }
            .badge-warning:hover {
                background-color: #c67605;
            }
            .badge-success {
                background-color: #E13300 !important;
            }
            @-moz-keyframes blinker {  
                0% { opacity: 1.0; }
                50% { opacity: 0.0; }
                100% { opacity: 1.0; }
            }

            @-webkit-keyframes blinker {  
                0% { opacity: 1.0; }
                50% { opacity: 0.0; }
                100% { opacity: 1.0; }
            }

            @keyframes blinker {  
                0% { opacity: 1.0; }
                50% { opacity: 0.0; }
                100% { opacity: 1.0; }
            }
            @font-face {
                font-family: "lobster";
                src: url("_fonts/LobsterTwo-Regular.otf");
            }
            @font-face {
                font-family: "gotham";
                src: url("_fonts/Gotham Bold Regular.ttf");
            }
            html,body
            {
                width: 100%;
                height: 100%;
                margin: 0px;
                padding: 0px;
                overflow-x: hidden; 
                font-family: "lobster"
            }

            .dropdown ul li:hover{
                background: none !important;
            }
            #header{
                padding-top:5px;padding-left:20px;color:white;font-weight:bold;margin-bottom:20px; 
                height:58px;/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#a90329+0,8f0222+44,6d0019+100;Brown+Red+3D */
                /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#006e2e+0,006e2e+100;Green+Flat+%233 */
                background: #002166; /* Old browsers */
                background: -moz-linear-gradient(top, #002166 0%, #003399 100%); /* FF3.6-15 */
                background: -webkit-linear-gradient(top, #002166 0%,#003399 100%); /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(to bottom, #002166 0%,#003399 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#006e2e', endColorstr='#006e2e',GradientType=0 ); /* IE6-9 */
            }
            #footer{
                padding:5px;font-size:10px; font-family: "gotham";
                height:80px;/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#a90329+0,8f0222+44,6d0019+100;Brown+Red+3D */
                /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#006e2e+0,006e2e+100;Green+Flat+%233 */
                background: #002166; /* Old browsers */
                background: -moz-linear-gradient(top, #002166 0%, #003399 100%); /* FF3.6-15 */
                background: -webkit-linear-gradient(top, #002166 0%,#003399 100%); /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(to bottom, #002166 0%,#003399 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#006e2e', endColorstr='#006e2e',GradientType=0 ); /* IE6-9 */text-align: center;color:white;
            }#header a{
                font-family: "gotham";
            }
            .wrap{
                white-space:normal; word-wrap: break-word; height: 50px !important;text-align: center;
            }
            .wrap2{
                white-space:normal; word-wrap: break-word;width: 140px;vertical-align: middle;
            }.select2-search__field{
                z-index: 99999;
            }
            #profile{
                width: 150px;text-align: center;padding:10px;font-family: 'gotham';color:#002166;font-size:11px;
            }
            #footer2{
                text-align: center;
            }a{
                color: white !important;text-decoration: none;  font-family: "gotham";font-weight:bold;
            }a:hover{cursor:pointer ; } .table{
                border: 0px !important;border-bottom: 0px solid #dddddd;font-size: 12px;
            }.angka{text-align: right;}.dropdown-menu a {color:#006e2e !important;font-size:11px;font-weight: bold;}ul a{font-size:11px !important;font-weight: bold;}button{font-size:12px !important;}
        </style>
        <link href="_css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
        <!--<link href="_css/bootstrap-table.min.css" type="text/css" rel="stylesheet" media="all">-->
        <link href="_css/bootstrap-dialog.min.css" type="text/css" rel="stylesheet" media="all">
        <link href="_css/nprogress.css" type="text/css" rel="stylesheet" media="all">
        <link href="_css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all">
        <!--        <link href="_plugins/jqueryui/jquery-ui.min.css" type="text/css" rel="stylesheet" media="all">-->
        <link href="<?= base_url() ?>_css/datepicker3.css" rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="_plugins/jQueryUI-1.11.4/jquery-ui.min.css"/>
        <link rel="stylesheet" type="text/css" href="_plugins/DataTables-1.10.15/css/dataTables.jqueryui.min.css"/>
        <link rel="stylesheet" type="text/css" href="_plugins/Responsive-2.1.1/css/responsive.jqueryui.min.css"/>  </head>
    <body>
        <div class="row" style="margin-bottom:0px;padding-left:30px;padding-right:30px;">
            <div class="col-md-12">
                <div style="margin-top:15px;">
                    <div style="float:left">
                        <img src="_images/icon_dialScore.png" style="width:100px;">
                    </div>
                    <div style="float:left;">
                        <div style="width: 200px;text-align: left;padding:10px;">
                            <img src="_images/logo.png" style="width:200px;">
                        </div>
                    </div>
                </div>
                <div style="float:right;">
                    <div id="profile">
                        <span style="position:absolute;text-align: left;top:20px;right:15px;font-weight: bold;">Selamat Datang</span> <br>
                        <span style="position:absolute;text-align: left;top:40px;right:15px;"><?= $nama . " / " . $nip ?></span>
                        <span style="position:absolute;top:60px;right:15px;"><?= $jabatan . " / " . $nama_uker ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top:5px;">
            <div class="col-md-12" id="menu_atas">
                <div id="header" style="padding:1px;font-size:10px !important;">
                    <div style="position:absolute;right:140px;top:-70px;"><a href="javascript:void(0)" onclick="menu('c_disposisi/bawahan');" ><span class="badge badge-success"><?= $ttl_dsp['ttl'] ?></span></a></div>
                    <div style="float:left;">
                        <?php if ($jabatan == 'Admin') { ?>
                            <ul class="nav nav-tabs">
                                <li><a href="./" class="wrap" style="width: 79px;line-height: 30px;">Beranda</a></li>
                                <li class="dropdown">
                                    <a class="wrap dropdown-toggle" data-toggle="dropdown" style="width: 90px;line-height: 30px;">Data 
                                        <span class="caret"></span>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <li><a href="javascript:void(0)" onclick="menu('admin/c_jabatan')">Jabatan & Tunjangan</a></li>
                                        <li><a href="javascript:void(0)" onclick="menu('admin/c_uker')">Unit Kerja</a></li>
                                        <li><a href="javascript:void(0)" onclick="menu('admin/c_pangkat')">Gol. Ruang dan Pangkat</a></li>
                                        <li><a href="javascript:void(0)" onclick="menu('admin/c_user')">User</a></li>
                                        <li><a href="javascript:void(0)" onclick="menu('admin/c_admin')">Admin</a></li>
                                        <li><a href="javascript:void(0)" onclick="menu('admin/c_kuantitas')">Satuan Kuantitas</a></li>
                                        <li><a href="javascript:void(0)" onclick="menu('admin/c_rkt')">Rencana Kerja Tahunan</a></li>

                                    </ul>
                                </li>
                                <li><a href="javascript:void(0)" style="width: 130px;line-height: 30px;" onclick="pengaturan()" class="wrap">Pengaturan</a></li>
                                <li><a href="javascript:void(0)" style="width: 230px;line-height: 30px;" onclick="menu('admin/c_rekap_skp')" class="wrap">Rekap (Berdasarkan SKP Bulanan)</a></li>
                                <li><a href="javascript:void(0)" style="width: 130px;line-height: 30px;" onclick="menu('admin/c_pegawai_terbaik')" class="wrap">Pegawai Terbaik</a></li>
                                <li><a href="javascript:void(0)" style="width: 130px;line-height: 30px;" onclick="menu('admin/c_spesimen')" class="wrap">Spesimen Lokasi</a></li>
                                <li><a href="javascript:void(0)" style="width: 130px;line-height: 30px;" onclick="menu('admin/c_fitur')" class="wrap">Fitur View Rekap</a></li>
                                <li><a href="javascript:void(0)" style="width: 230px;line-height: 30px;" onclick="menu('admin/c_kegiatan_jabatan')" class="wrap">Data Kegiatan Jabatan</a></li>
                                <li>  
                                    <a href="c_main/logout" class="wrap" style="width: 80px;line-height: 30px;">Logout</a> 
                                </li>
                            </ul>

                        </div>
                    <?php } elseif ($jabatan == 'Operator') { ?>
                        <a href="./" class="wrap">Beranda</a>
                        <a href="javascript:void(0)" onclick="menu('c_operator/absensi')" class="wrap">Absensi Manual</a>
                        <a href="javascript:void(0)" onclick="menu('c_operator/faktor_pengurang')" class="wrap">Faktor Pengurang</a>
                        <a href="c_main/logout" class="wrap">Logout</a>

                    <?php } else { ?>
                        <style>
                            .nav-tabs li:hover{
                                background-color: none !important;color:red;
                            }
                        </style>
                        <ul class="nav nav-tabs">
                            <li><a href="./" class="wrap" style="width: 79px;line-height: 30px;">Beranda</a></li>
                            <li class="dropdown">
                                <a class="wrap dropdown-toggle" data-toggle="dropdown" style="width: 90px;line-height: 30px;">SKP 
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="menu('c_tahunan_skp')">Target dan Realisasi Tahunan</a></li>
                                    <li><a href="javascript:void(0)" onclick="menu('c_tahunan_skp/bawahan')">SKP Bawahan Tahunan</a></li>
                                    <li><a href="javascript:void(0)" onclick="menu('c_bulanan_skp')">Target dan Realisasi Bulanan</a></li>
                                    <li><a href="javascript:void(0)" onclick="menu('c_bulanan_skp/bawahan')">SKP Bulanan Bawahan Bulanan</a></li>
                                </ul>
                            </li>

                            <li class="dropdown">
                                <a class="wrap dropdown-toggle" data-toggle="dropdown" style="width: 140px;line-height: 30px;">Perilaku Bulanan
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="menu('c_atasan/nilai_perilaku')">Nilai Perilaku Bulanan Bawahan</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a class="wrap dropdown-toggle" data-toggle="dropdown" style="width: 120px;">Lap. Harian Kinerja SKP
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="menu('c_harian_skp')">Lap. Harian Kinerja SKP</a></li>

                                    <li><a href="javascript:void(0)" onclick="menu('c_harian_skp/bawahan')">Lap. Harian Kinerja SKP Bawahan</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0)" style="width: 130px;" onclick="menu('c_tugas_tambahan')" class="wrap">Lap. Harian Tugas Tambahan</a></li>
                            <li class="dropdown">
                                <a class="wrap dropdown-toggle" data-toggle="dropdown" style="width: 130px;line-height: 30px;">Non SKP
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="menu('c_produktivitas')">Lap. Harian Non SKP</a></li>

                                    <li><a href="javascript:void(0)" onclick="menu('c_produktivitas/bawahan')">Lap. Harian Non SKP Bawahan</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0)" onclick="menu('c_kreatifitas')" class="wrap" style="width: 100px;line-height: 30px;">Kreatifitas</a></li>
                            <li class="dropdown">
                                <a class="wrap dropdown-toggle" data-toggle="dropdown" style="width: 130px;line-height: 30px;">Disposisi 
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="menu('c_disposisi')">Disposisi</a></li>

                                    <li><a href="javascript:void(0)" onclick="menu('c_disposisi/bawahan')">Tindak Lanjut</a></li>
                                </ul>
                            </li>
                            <li><a href="javascript:void(0)" onclick="menu('c_staff_bawahan')" style="width: 100px;" class="wrap">Edit Staff Bawahan</a></li>
                            <li><a href="javascript:void(0)" class="wrap" onclick="profile()" style="width: 100px;line-height: 30px;">Edit Profile</a></li>

                           <li class="dropdown">
                                <a class="wrap dropdown-toggle" data-toggle="dropdown" style="width: 145px;line-height: 30px;margin-right:-20px;">Detail SKP Tahunan 
                                    <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="javascript:void(0)" onclick="menu('c_detail_skp_tahunan/user')">User</a></li>
                                    <li><a href="javascript:void(0)" onclick="menu('c_detail_skp_tahunan')">Bawahan</a></li>
                                </ul>
                            </li>
                            <li>  
                                <a href="c_main/logout" class="wrap" style="width: 80px;line-height: 30px;">Logout</a> 
                            </li>
                        </ul>
                    </div> 
                </div>


            <?php } ?>
        </div>

        <div class="row" style="min-height: 400px;padding:15px;">
            <div class="col-md-12" id="tengah" style="padding:30px;">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="footer">
                    BADAN KEPEGAWAIAN NEGARA</br>
                    DIREKTORAT KINERJA APARATUR SIPIL NEGARA</br>
                    Gedung 2 Lantai 11 Jalan Letjend Soetoyo No. 12 Cililitan , Jakarta Timur<br/>
                    Http://ekinerja-tunkin.bkn.go.id
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div id="footer2" style="font-size: 10px;">
                    Hak Cipta &copy 2017 Badan Kepegawaian Negara
                </div>
            </div>
        </div>

        <script src="_js/jQuery-2.1.4.min.js"></script>
        <!--<script type="text/javascript" src="_plugins/DataTables/js/jquery.dataTables.min.js"></script>-->
        <script type="text/javascript" src="_js/jquery.dataTables.min.js"></script>
        <script src="_js/bootstrap.min.js"></script>
        <script src="_js/bootstrap-dialog.min.js"></script>
        <script src="_js/nprogress.js"></script>
        <script src="_js/highcharts.js"></script>
        <script src="_js/highcharts-more.js"></script>
        <script src="_js/numeral.min.js"></script>
        <!--<script src="_js/jquery-migrate-3.0.0.js"></script>-->
        <script src="<?= base_url() ?>_js/bootstrap-datepicker.js"></script>
        <script type="text/javascript" src="_plugins/jQueryUI-1.11.4/jquery-ui.min.js"></script>
        <script type="text/javascript" src="_plugins/DataTables-1.10.15/js/jquery.dataTables.min.js"></script>
        <script type="text/javascript" src="_plugins/DataTables-1.10.15/js/dataTables.jqueryui.min.js"></script>
        <script type="text/javascript" src="_plugins/Responsive-2.1.1/js/dataTables.responsive.min.js"></script>
        <script type="text/javascript" src="_js/jquery.scrollTo.min.js"></script>
        <script type="text/javascript" src="_js/dataTables.scrollResize.js"></script>
        <script type="text/javascript" src="_plugins/Responsive-2.1.1/js/responsive.jqueryui.min.js"></script>
        <script type="text/javascript" src="_js/bootstrap-timepicker.js"></script>
        <script>
                                        function menu(link) {
                                            $.ajax({
                                                url: link,
                                                type: 'get',
                                                dataType: "html",
                                                beforeSend: function () {
                                                    NProgress.start();
                                                    $('#tengah').hide();
                                                    $('#tengah').empty();
                                                },
                                                success: function (data) {
                                                    NProgress.done();
                                                    $('#tengah').show();
                                                    $('#tengah').html(data);
                                                }
                                            });
                                        }

                                        function getFormData($form) {
                                            var unindexed_array = $form.serializeArray();
                                            var indexed_array = {};

                                            $.map(unindexed_array, function (n, i) {
                                                indexed_array[n['name']] = n['value'];
                                            });

                                            return indexed_array;
                                        }
                                        function pengaturan() {

                                            var dialog = new BootstrapDialog({
                                                message: function () {
                                                    var $message = $('<div></div>').load('c_admin/pengaturan');
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
                                        function profile() {
                                            var dialog = new BootstrapDialog({
                                                title: 'Ubah Profile',
                                                message: function () {
                                                    var $message = $('<div></div>').load('c_user/profile');
                                                    return $message;
                                                }
                                            });
                                            dialog.realize();
                                            //                                        dialog.getModalHeader().hide();
                                            dialog.getModalBody().css('background-color', 'lightblue');
                                            dialog.getModalBody().css('color', '#000');
                                            dialog.setSize(BootstrapDialog.SIZE_NORMAL);
                                            dialog.open();

                                        }

                                        menu('c_dashboard');
        </script>

    </body>
</html>
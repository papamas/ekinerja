<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="description" content="Jamkrindo Admin Panel" />
        <meta name="author" content="" />
        <link rel="shortcut icon" href="_images/favicon.ico"/>
        <title>E-Kinerja | Dashboard</title>

        <link rel="stylesheet" href="assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
        <link rel="stylesheet" href="assets/css/font-icons/entypo/css/entypo.css">
        <!--        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">-->
        <link rel="stylesheet" href="assets/css/bootstrap.css">
        <link href="_css/bootstrap-dialog.min.css" type="text/css" rel="stylesheet" media="all">
        <link rel="stylesheet" href="assets/css/neon-core.css">
        <!--<link rel="stylesheet" href="assets/css/neon-theme.css">-->
        <!--<link rel="stylesheet" href="assets/css/neon-forms.css">-->
        <!--<link rel="stylesheet" href="assets/css/custom.css">-->
        <link rel="stylesheet" href="assets/css/skins/facebook.css">
        <link rel="stylesheet" href="_css/nprogress.css">
        <link rel="stylesheet" href="_css/datepicker.css">
        <link rel="stylesheet" href="_css/AdminLTE.min.css">
        <link rel="stylesheet" href="assets/js/datatables/responsive/css/datatables.responsive.css">
    </head>

    <body class="page-body skin-facebook page-fade" data-url="http://neon.dev">

        <div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
            <div class="sidebar-menu">
                <div class="sidebar-menu-inner">

                    <header class="logo-env" style="margin-bottom: -20px;">

                        <!-- logo -->
                        <div class="logo">
                            <a href="./">
                                <img src="_images/logo.png" width="175" height="50" alt="" style="background:white;" />
                            </a>
                        </div>

                        <!-- logo collapse icon -->
                        <div class="sidebar-collapse">
                            <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                                <i class="entypo-menu"></i>
                            </a>
                        </div>


                        <!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
                        <div class="sidebar-mobile-menu visible-xs">
                            <a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
                                <i class="entypo-menu"></i>
                            </a>
                        </div>

                    </header>

                    <div class="sidebar-user-info">
                        <div class="sui-normal" style="font-size: 10px;">
                            <a href="#" class="user-link">
                                <!--<img src="_images/icon_dialScore.png" alt="" class="img-circle" width="70" />-->
                                <span>Welcome,</span>
                                <strong style="font-size: 12px;"><?= $nama . " / " . $nip ?><br><?= $jabatan . " / " . $nama_uker ?></strong>
                            </a>
                        </div>
                        <div class="sui-hover inline-links animate-in"><!-- You can remove "inline-links" class to make links appear vertically, class "animate-in" will make A elements animateable when click on user profile -->
                            <a href="C_main/logout">
                                <i class="entypo-lock"></i>
                                Log Off
                            </a>
                            <span class="close-sui-popup">&times;</span><!-- this is mandatory -->				</div>
                    </div>

                    <ul id="main-menu" class="main-menu">
                        <!-- add class "multiple-expanded" to allow multiple submenus to open -->
                        <!-- class "auto-inherit-active-class" will automatically add "active" class for parent elements who are marked already with class "active" -->
                        <li class="opened active">
                            <a href="./">
                                <i class="entypo-gauge"></i>
                                <span class="title">Dashboard</span>
                            </a>
                        </li>
                        <?php
                        switch ($jabatan) {
                            case "Admin":
                                ?>
                                <li><a href="javascript:void(0)" class="wrap" onclick=""> <i class="entypo-briefcase"></i>
                                        <span class="title">SKP Tahunan</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick=""><i class="entypo-address"></i>
                                        <span class="title">Lap. Kinerja SKP</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick=""><i class="entypo-arrow-combo"></i>
                                        <span class="title">Lap. Produktivitas</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick=""><i class="entypo-attention"></i>
                                        <span class="title">Status Persetujuan Atasan</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick=""><i class="entypo-basket"></i>
                                        <span class="title">Persetujuan Bulanan</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick=""><i class="entypo-block"></i>
                                        <span class="title">Edit Staff Bawahan</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick=""><i class="entypo-bucket"></i>
                                        <span class="title">SKP Tahunan Bawahan</span></a></li>
                                <li> <a href="javascript:void(0)" class="wrap" onclick="profile()"><i class="entypo-cc-pd"></i>
                                        <span class="title">Edit Profile</span></a></li>

                                <?php
                                break;
                            case 'Operator':
                                ?>
                                <li><a href="javascript:void(0)" class="wrap" onclick="menu('C_operator/absensi')"> <i class="entypo-briefcase"></i>
                                        <span class="title">Absensi Manual</span></a></li>

                                <li><a href="javascript:void(0)" class="wrap" onclick="menu('C_operator/faktor_pengurang')"> <i class="entypo-briefcase"></i>
                                        <span class="title">Faktor Pengurang</span></a></li>
                                <?php
                                break;
                            default:
                                ?>

                                <li>
                                    <a href="./">
                                        <i class="entypo-archive"></i>
                                        <span class="title">SKP Tahunan</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_user/skp_tahunan')">
                                                <span class="title">Target dan Realisasi</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_atasan/skp_tahunan_bawahan')">
                                                <span class="title">SKP Bawahan</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="./">
                                        <i class="entypo-archive"></i>
                                        <span class="title">SKP Bulanan</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_user/skp_bulanan')">
                                                <span class="title">Target dan Realisasi</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_atasan/skp_bulanan_bawahan')">
                                                <span class="title">SKP Bawahan</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="./">
                                        <i class="entypo-archive"></i>
                                        <span class="title">Perilaku Bulanan</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_atasan/nilai_perilaku')">
                                                <span class="title">Nilai Perilaku Bulanan Bawahan</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li>
                                    <a href="./">
                                        <i class="entypo-archive"></i>
                                        <span class="title">Lap. Harian Kinerja SKP</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_user/harian_skp')">
                                                <span class="title">Lap. Harian Kinerja SKP</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_atasan/utama_skp_harian')">
                                                <span class="title">Lap. Harian Kinerja SKP Bawahan</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li><a href="javascript:void(0)" class="wrap" onclick="menu('C_user/tugas_tambahan')"> <i class="entypo-briefcase"></i>
                                        <span class="title">Lap. Harian Tugas Tambahan</span></a></li>

                                <li>
                                    <a href="./">
                                        <i class="entypo-archive"></i>
                                        <span class="title">Lap. Harian Produktivitas</span>
                                    </a>
                                    <ul>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_user/harian_skp')">
                                                <span class="title">Lap. Harian Produktivitas</span>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="javascript:void(0)" onclick="menu('C_atasan/utama_skp_harian')">
                                                <span class="title">LLap. Harian Produktivitas Bawahan</span>
                                            </a>
                                        </li>
                                    </ul>
                                </li>

                                <li><a href="javascript:void(0)" class="wrap" onclick="menu('C_user/tugas_tambahan')"> <i class="entypo-briefcase"></i>
                                        <span class="title">Kreatifitas</span></a></li>      
                                <li><a href="javascript:void(0)" class="wrap" onclick="menu('C_user/tugas_tambahan')"> <i class="entypo-briefcase"></i>
                                        <span class="title">Disposisi Tugas</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick="menu('C_user/tugas_tambahan')"> <i class="entypo-briefcase"></i>
                                        <span class="title">Edit Staff Bawahan</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick="profile()"> <i class="entypo-briefcase"></i>
                                        <span class="title">Edit Profile</span></a></li>
                                <li><a href="javascript:void(0)" class="wrap" onclick="menu('C_user/tugas_tambahan')"> <i class="entypo-briefcase"></i>
                                        <span class="title">Menu Detail SKP Tahunan</span></a></li>
                                <?php
                                break;
                        }
                        ?>

                </div>

            </div>

            <div class="main-content">

                <div class="row" id="content" style="min-height: 500px;">
                    <div class="col-sm-12">
                        <div class="well">
                            <h1><?= date('d M Y') ?></h1>
                            <h3>Welcome to the site <strong><?= $this->session->userdata('user') ?></strong></h3>
                        </div>
                    </div>
                </div>
                <hr />

                <!-- Footer -->
                <footer class="main" style="text-align: center;">
                    &copy; 2017 <strong>Jamkrindo Dashboard</strong> 
                </footer>
            </div>
            <script src="_js/jQuery-2.1.4.min.js"></script>
            <!--<script src="_js/jquery-3.2.0.min.js"></script>-->
            <script src="_js/bootstrap.min.js"></script>
            <script src="_js/bootstrap-table.js"></script>
            <script src="_js/nprogress.js"></script>
            <script src="_js/highcharts.js"></script>
            <script src="_js/highcharts-more.js"></script>
            <script src="_js/bootstrap-datepicker.js"></script>    
            <script src="_js/bootstrap-dialog.min.js"></script>    
            <!--<script>$.noConflict();</script>-->
            <script type="text/javascript">
                            function menu(link) {
                                $.ajax({
                                    url: link,
                                    type: 'get',
                                    dataType: "html",
                                    beforeSend: function () {
                                        NProgress.start();
                                        $('#content').empty();
                                    },
                                    success: function (data) {
                                        NProgress.done();
                                        $('#content').html(data);
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
                                        var $message = $('<div></div>').load('C_admin/pengaturan');
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
                                        var $message = $('<div></div>').load('C_user/profile');
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

                            menu('C_dashboard');
            </script>
            <!-- Imported styles on this page -->
            <link rel="stylesheet" href="assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
            <link rel="stylesheet" href="assets/js/rickshaw/rickshaw.min.css">

            <!-- Bottom scripts (common) -->
            <script src="assets/js/gsap/main-gsap.js"></script>
            <script src="assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
            <script src="assets/js/bootstrap.js"></script>
            <script src="assets/js/joinable.js"></script>
            <script src="assets/js/resizeable.js"></script>
            <script src="assets/js/neon-api.js"></script>
            <script src="_js/jquery.stickytableheaders.js"></script>
            <script src="assets/js/jquery.dataTables.min.js"></script>
            <script src="assets/js/datatables/TableTools.min.js"></script>

            <script src="assets/js/dataTables.bootstrap.js"></script>
            <script src="assets/js/datatables/jquery.dataTables.columnFilter.js"></script>
            <script src="assets/js/datatables/lodash.min.js"></script>
            <script src="assets/js/datatables/responsive/js/datatables.responsive.js"></script>
            <!-- JavaScripts initializations and stuff -->
            <script src="assets/js/neon-custom.js"></script>

            <!-- Demo Settings -->
            <script src="assets/js/neon-demo.js"></script>
            <script src="_js/numeral.min.js"></script>
            <script src="_js/Chart.js"></script>
            <script src="_js/Chart.Core.js"></script>
            <script src="_js/Chart.Doughnut.js"></script>
            <script src="_js/raphael-2.1.4.min.js"></script>
            <script src="_js/justgage.js"></script>
            <script src="_js/chartjs-plugin-zoom.js"></script>
            <script src="_js/jquery.table2excel.js"></script>
    </body>
</html>
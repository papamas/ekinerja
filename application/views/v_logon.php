<html>
    <head>
        <title>E-KINERJA</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="EKINERJA" />
        <style>
            html,body
            {/* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#1e5799+0,2989d8+50,207cca+51,7db9e8+100;Blue+Gloss+Default */
                background: rgb(30,87,153); /* Old browsers */
                background: -moz-linear-gradient(top,  rgba(30,87,153,1) 0%, rgba(41,137,216,1) 50%, rgba(32,124,202,1) 51%, rgba(125,185,232,1) 100%); /* FF3.6-15 */
                background: -webkit-linear-gradient(top,  rgba(30,87,153,1) 0%,rgba(41,137,216,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%); /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(to bottom,  rgba(30,87,153,1) 0%,rgba(41,137,216,1) 50%,rgba(32,124,202,1) 51%,rgba(125,185,232,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#1e5799', endColorstr='#7db9e8',GradientType=0 ); /* IE6-9 */

                width: 100%;
                height: 100%;
                margin: 0px;
                padding: 5px;
                overflow-x: hidden; 
                font-family: "lobster"
            }
            .judul1{
                font-size: 18px;text-align: center;font-weight: bold;
            }
            @font-face {
                font-family: "lobster";
                src: url("_fonts/LobsterTwo-Regular.otf");
            }
            @font-face {
                font-family: "gotham";
                src: url("_fonts/Gotham Bold Regular.ttf");
            }
            #logo_bkn,img{
                width:100px;margin-left:10px;  
                -webkit-filter: drop-shadow(6px 6px 5px rgba(3,0,0,0.5));float:left;
            }.tbl_login{
                font-family: "gotham";color: white;font-size: 12px;
            }
            #kiri{
                height: 100%;
                background-image: url('_images/IMG_1770.JPG');
                background-repeat: no-repeat;
                -moz-background-size:100% 100%;
                -webkit-background-size:100% 100%;
                background-size:100% 100%;

            }#kanan{
                height: 100%;
                color:white;
                font-family: "gotham";
                /* Permalink - use to edit and share this gradient: http://colorzilla.com/gradient-editor/#271f70+0,202172+100 */
                background: rgb(39,31,112); /* Old browsers */
                background: -moz-linear-gradient(top,  rgba(39,31,112,1) 0%, rgba(32,33,114,1) 100%); /* FF3.6-15 */
                background: -webkit-linear-gradient(top,  rgba(39,31,112,1) 0%,rgba(32,33,114,1) 100%); /* Chrome10-25,Safari5.1-6 */
                background: linear-gradient(to bottom,  rgba(39,31,112,1) 0%,rgba(32,33,114,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
                filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#271f70', endColorstr='#202172',GradientType=0 ); /* IE6-9 */

            }#layout-kanan{
                margin-top:100px;
            }#div_login:hover{
                opacity:1;
                -webkit-transition:opacity 1s ease-in-out;
                -moz-transition:opacity 1s ease-in-out;
                -ms-transition:opacity 1s ease-in-out;
                -o-transition:opacity 1s ease-in-out;
                transition:opacity 1s ease-in-out;
            }#logo_kanan{
                float:right;
            }
        </style>
        <link href="_images/favicon.ico" rel="shortcut icon" type="image/x-icon">
        <link href="_css/bootstrap.min.css" type="text/css" rel="stylesheet" media="all">
        <link href="_css/bootstrap-table.css" type="text/css" rel="stylesheet" media="all">
        <link href="_css/bootstrap-dialog.min.css" type="text/css" rel="stylesheet" media="all">
        <link href="_css/nprogress.css" type="text/css" rel="stylesheet" media="all">
        <link href="_css/font-awesome.min.css" type="text/css" rel="stylesheet" media="all">

        <link href="_plugins/jqueryui/jquery-ui.min.css" type="text/css" rel="stylesheet" media="all">
    </head>
    <body>

        <div id="layout">
            <div class="row">
                <div class="col-md-7" id="kiri">
                    <div id="logo_bkn">
                        <img src="_images/BKN Logo.png" style="width: 200px;"/>
                    </div>
                    <div id="logo_kanan" style="margin-top:10px;">
                        <a href="_files/petunjuk.pdf"><img src="_images/icon-lg-guides-blue.png" style="width:70px;"></a>
                        <a href="_files/faq.doc"><img src="_images/faq2.png" style="width:70px;"></a>
                    </div>
                    <!--<div style="clear:both"></div>-->
                    <div style="width:350px;margin:auto;margin-top:210px;opacity:0.8;" id="div_login">
                        <!--                        <div style="width: 330px;margin-bottom: 10px;">
                                                    <img src="_images/icon_dialScore.png" class="gambar" style="width:100px;">
                                                    <img src="_images/logo.png" class="gambar" style="width:200px;">
                                                </div>-->
                        <div class="panel" style="background: #143270;color:white;font-weight: bold;">
                            <div class="panel-heading text-center text-capitalize"><?= $pesan ?></div>
                            <div class="panel-body" style="background: #0088cc;">
                                <form action="c_main/validasi" method="post">
                                    <table class="table tbl_login">
                                        <tr style="border:0px !important;">
                                            <td>Username</td>
                                            <td>
                                                <div class="input-group">					
                                                    <input class="form-control" name="username" type="text"/>
                                                    <div class="input-group-addon">
                                                        <i class="glyphicon glyphicon-user"/></i>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Password</td>
                                            <td>
                                                <div class="input-group">					
                                                    <input class="form-control" name="password" type="password"/>
                                                    <div class="input-group-addon">
                                                        <i class="glyphicon glyphicon-lock"/></i>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td/>
                                            <td>
                                                <input type="submit" class="btn" style="background: #143270;color:white;font-weight: bold;width:130px;" value="Login">
                                            </td>
                                        </tr>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $bulan = date('m') == '1' ? 12 : (int) date('m') - 1
                ?>
                <div class="col-md-5" id="kanan">
                    <div id="layout-kanan">
                        <div style="width:400px;margin:auto;">
                            <div class="judul1">PEGAWAI TERBAIK BULAN <?= bulan($bulan) ?><br>TAHUN <?= date('Y') ?></div>
                        </div>
                        <br><br>
                        <div style="border: solid 1px white;width:200px;margin:auto;padding:10px;font-size:24px;text-align: center;">
                            <?= isset($pt['nilai_skp']) ? number_format($pt['nilai_skp'], 2) : '0' ?>
                        </div>
                        <div style="width:200px;margin:auto;padding:10px;font-size:24px;text-align: center;">
                            <?php
                            $ket = explode("-", ket_nilai(isset($pt['nilai_skp']) ? $pt['nilai_skp'] : 0));
                            echo $ket[0]
                            ?>
                            <img src="_images/Star 1.png" style="width: 100%;margin-left:-3px;">
                        </div>
                        <br><br><br><br>
                        <div style="width:100%;margin:auto;padding:10px;" class="judul1">
                            <?= isset($pt['nama']) ? $pt['nama'] : 'Belum Ada' ?><br>
                            <?= isset($pt['nip']) ? $pt['nip'] : 'Belum Ada' ?><br>
                            <?= isset($pt['jabatan']) ? $pt['jabatan'] : 'Belum Ada' ?>
                        </div>
                        <div style="bottom:10px;font-size:10px;text-align: center;position:absolute;width: 100%;">
                            Penilaian dilakukan oleh Tim Kinerja BKPP Kab. Gorontalo dengan mempertimbangkan berbagai aspek
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <script src="_js/jquery-3.2.0.min.js"></script>
        <script src="_js/bootstrap.min.js"></script>
        <script src="_js/jquery.pixelentity.shiner.min.js"></script>
        <script src="_js/bootstrap-table.js"></script>
        <script src="_plugins/jqueryui/jquery-ui.min.js"></script>

        <script>
            function ubahUkuran() {
                var ukuran = screen.width - 15;
                $('#layout').css('max-width', ukuran + 'px');
                $('#layout').css('height', '100%');
            }
            ubahUkuran();
            $(window).resize(function () {
                ubahUkuran();
            });
            $(document).ready(function () {
                $(".peShiner").peShiner({api: true, paused: true, reverse: true, repeat: 1});
            });


            $("#frm_login").on('submit', (function (e) {
                e.preventDefault();
                var frm_login = $("#frm_login");
                var form = getFormData(frm_login);
                $.ajax({
                    type: "POST",
                    url: "c_main/validasi",
                    data: JSON.stringify(form),
                    dataType: 'json',
                    // contentType: 'application/json; charset=utf-8'
                }).done(function (response) {
                    if (response.status === 1) {
                        alert('Berhasil Login');
                        window.location.replace('./');
                    } else {
                        alert(response.ket);
                    }
                });

            }));

        </script>
    </body>
</html>
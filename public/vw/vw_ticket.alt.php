<?php
require("../config.php");
if (!isset($_SESSION["role"]))
{
    header("location: ../index.php");
}
$roleuser = $_SESSION['role'];
$uiduser = $_SESSION['uid'];
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];

$sql2 = "SELECT 
a.nama,
CASE
WHEN b.us_role = 1 THEN 'user'
WHEN b.us_role = 2 THEN 'PIC'
WHEN b.us_role = 3 THEN 'Admin'
END AS role
FROM hris_dev.mr_peg_jabatan a
JOIN ticket_staging.t_role b
ON a.user_uid=b.us_uid
WHERE b.us_uid='$uiduser'
";
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_array($result2);
$namas=$row2[0];
$roles=$row2[1];


if ($roleuser == 3) {
    $sql = "
    SELECT DISTINCT
    A.id AS 'id',
    DATE_FORMAT(A.created_at, '%d %M %Y %H:%i') AS 'Tanggal',
    A.no_ticket AS 'nomor tiket',
    E.Nama_div AS 'nama Divisi',
    C.category_name AS 'nama category',
    B.detail_category_name AS 'nama category detail',
    A.problem,
    CASE
    WHEN A.flag ='0' THEN 'open'
    WHEN A.flag ='1' THEN 'close'
    WHEN A.flag ='2' THEN 'hold'
    END AS 'status tiket',
    A.detail,
    F.nama,A.nama_file
    FROM ticket_staging.t_transaksi A
    LEFT JOIN ticket_staging.t_category_detail B
    ON A.id_detail = B.id
    LEFT JOIN ticket_staging.t_category C
    ON B.id_category = C.id
    LEFT JOIN ticket_staging.t_mapping_pic D
    ON A.pic = D.user_uid
    LEFT JOIN hris_dev.mr_peg_info_personal F
    ON D.user_uid = F.user_uid
    LEFT JOIN ticket_staging.t_divisi E
    ON C.id_divisi = E.kode_div
    WHERE A.id>1
    ORDER BY A.created_at DESC ";

} else {

    $sql = "
    SELECT DISTINCT
    A.id AS 'id',
    DATE_FORMAT(A.created_at, '%d %M %Y %H:%i') AS 'Tanggal',
    A.no_ticket AS 'nomor tiket',
    E.Nama_div AS 'nama Divisi',
    C.category_name AS 'nama category',
    B.detail_category_name AS 'nama category detail',
    A.problem,
    CASE
    WHEN A.flag ='0' THEN 'open'
    WHEN A.flag ='1' THEN 'close'
    WHEN A.flag ='2' THEN 'hold'
    END AS 'status tiket',
    A.detail,
    F.nama,A.nama_file
    FROM ticket_staging.t_transaksi A
    LEFT JOIN ticket_staging.t_category_detail B
    ON A.id_detail = B.id
    LEFT JOIN ticket_staging.t_category C
    ON B.id_category = C.id
    LEFT JOIN ticket_staging.t_mapping_pic D
    ON A.pic = D.user_uid
    LEFT JOIN hris_dev.mr_peg_info_personal F
    ON D.user_uid = F.user_uid
    LEFT JOIN ticket_staging.t_divisi E
    ON C.id_divisi = E.kode_div
    WHERE A.id>1 AND A.pic_report='$uiduser'
    ORDER BY A.created_at DESC ";
}

$result = mysqli_query($con, $sql);

?>
<!doctype html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../kisel.png"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <!-- Bootstrap core CSS     -->
    <link href="<?php echo _CDN_HOST ?>/assets/css/bootstrap.min.css" rel="stylesheet"/>
    <!--  Material Dashboard CSS    -->
    <link href="<?php echo _CDN_HOST ?>/assets/css/material-dashboard.css" rel="stylesheet"/>
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="<?php echo _CDN_HOST ?>/assets/css/demo.css" rel="stylesheet"/>
    <!--     Fonts and icons     -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/>
    <script src="<?php echo _CDN_HOST ?>/assets/js/chartist.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>
        Ticketing
    </title>
</head>

<body>
<style>

    .hidden-content { display:none; }

</style>
<div class="wrapper">
    <div class="sidebar" data-active-color="rose" data-background-color="black"
         data-image="<?php echo _CDN_HOST ?>/assets/img/sidebar-1.jpg">
        <!--
    Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
    Tip 2: you can also add an image using data-image tag
    Tip 3: you can change the color of the sidebar with data-background-color="white | black"
-->
        <div class="logo">
            <a class="simple-text">
                <?php echo $namas; ?>
            </a>
        </div>
        <div class="logo logo-mini">
            <a class="simple-text">
                <i class="material-icons">account_circle</i>
            </a>
        </div>
        <div class="sidebar-wrapper">
            <div class="user">
                <div class="photo">
                </div>
                <div class="info">
                    <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                        <?php echo $roles; ?>
                        <b class="caret"></b>
                    </a>
                    <div class="collapse" id="collapseExample">
                        <ul class="nav">
                            <li>
                                <a href="../proses/pros_logout.php">Log Out</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <ul class="nav">
                <li>
                    <a href="vw_dashboard.php">
                        <i class="material-icons">dashboard</i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <?php
                include "tamplateH.php";
                ?>
            </ul>
        </div>
    </div>
    <div class="main-panel">
        <nav class="navbar navbar-transparent navbar-absolute">
            <div class="container-fluid">
                <div class="navbar-minimize">
                    <button id="minimizeSidebar" class="btn btn-round btn-white btn-fill btn-just-icon">
                        <i class="material-icons visible-on-sidebar-regular">more_vert</i>
                        <i class="material-icons visible-on-sidebar-mini">view_list</i>
                    </button>
                </div>
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#"> Ticketing </a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="rose">
                                <i class="material-icons">description</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title" style="display: inline-block">Ticket List</h4>
                                <button class="btn btn-rose" data-toggle="modal"
                                        data-target="#addtiket" style="float: right">Create Ticket
                                    <i class="material-icons">add</i>
                                </button>
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->

                                </div>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                           cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center;">Date</th>
                                            <th style="text-align: center;">No Ticket</th>
                                            <th style="text-align: center;">Divisi</th>
                                            <th style="text-align: center;">Category</th>
                                            <th style="text-align: center;">Detail Category</th>
                                            <th style="text-align: center;">Problem</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Keterangan</th>
                                            <th style="text-align: center;">PIC</th>
                                            <th style="text-align: center;">Attachment</th>
                                            <!--                                            <th style="text-align: center;">PIC</th>-->
                                            <!--                                            <th class="text-center">Actions</th>-->
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th style="text-align: center;">Date</th>
                                            <th style="text-align: center;">No Ticket</th>
                                            <th style="text-align: center;">Divisi</th>
                                            <th style="text-align: center;">Category</th>
                                            <th style="text-align: center;">Detail Category</th>
                                            <th style="text-align: center;">Problem</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">Keterangan</th>
                                            <th style="text-align: center;">PIC</th>
                                            <th style="text-align: center;">Attachment</th>
                                            <!--                                            <th style="text-align: center;">PIC</th>-->
                                            <!--                                            <th class="text-center">Actions</th>-->
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        <tr>
                                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                            <td align="center"><?php echo $row[1]; ?></td>
                                            <td align="center"><?php echo $row[2]; ?></td>
                                            <td align="center"><?php echo $row[3]; ?></td>
                                            <td align="center"><?php echo $row[4]; ?></td>
                                            <td align="center"><?php echo $row[5]; ?></td>
                                            <!--                                            <td align="center">--><?php //echo $row[6]; ?><!--</td>-->
                                            <td align="center">
                                                <div class="content-holder">
                                                    <a href="#" class="expand-content-link">Problem <?php echo $row[2]; ?></a>
                                                    <div class="hidden-content"><?php echo $row[6]; ?></div>
                                                </div>
                                            </td>
                                            <td align="center"><?php echo $row[7]; ?></td>
                                            <!--                                            <td align="center">--><?php //echo $row[8]; ?><!--</td>-->
                                            <td align="center">
                                                <div class="content-holder">
                                                    <a href="#" class="expand-content-link">Keterangan <?php echo $row[2]; ?></a>
                                                    <div class="hidden-content"><?php echo $row[8]; ?></div>
                                                </div>
                                            </td>
                                            <td align="center"><?php echo $row[9]; ?></td>
                                            <td align="center"><a href='#' data-target='#attachShow' data-backdrop='static' data-keyboard='false' class='attach' data-nama="<?php echo $row[10]; ?>"><?php echo $row[10]; ?></a></td>
                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>

                                    <div class="modal fade" id="attachShow" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Show Attachment</h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body-attach">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="addtiket" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Create Ticket</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="material-icons">clear</i>
                            </button>
                        </div>
                        <form class="form-horizontal" id="uploadForm">
                            <div class="modal-body">

                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3">Divisi</label>
                                        <div class="col-md-9">
                                            <select name="idComboDivisi" id="idComboDivisi"
                                                    class="idComboT form-control selectpicker">
                                                <option disabled>--Pilih Divisi--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row">
                                        <input type="hidden" id="creator" name="creator" value="<?php echo $uid; ?>">
                                        <label class="col-md-3 label-on-left">Category Name</label>
                                        <div class="col-md-9">
                                            <select name="idComboCategory" id="idComboCategory"
                                                    class="idComboT form-control selectpicker" id="selectbasic">
                                                <option disabled>--Pilih Category--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3">Detail Category</label>
                                        <div class="col-md-9">
                                            <select name="idComboCategoryD" id="idComboCategoryD"
                                                    class="idComboT form-control selectpicker" id="selectbasic">
                                                <option disabled>--Pilih Category--</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3">Priority</label>
                                        <div class="col-md-9">
                                            <select name="prio" id="prio" class="prio form-control selectpicker"
                                                    id="selectbasic">
                                                <option value="1">Low</option>
                                                <option value="2">Medium</option>
                                                <option value="3">High</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <!--                                <div class="row">-->
                                <!--                                    <div class="form-group row">-->
                                <!--                                        <label class="col-md-3 col-form-label">Attachment</label>-->
                                <!--                                        <div class="col-md-9">-->
                                <!--                                            <div class="fileinput fileinput-new text-center" data-provides="fileinput">-->
                                <!--                                                <div class="fileinput-new thumbnail">-->
                                <!--                                                    <img src="../material-dashboard-pro-html-v1.1.0/assets/img/placeholder.jpg" alt="...">-->
                                <!--                                                </div>-->
                                <!--                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>-->
                                <!--                                                <div>-->
                                <!--                                                    <span class="btn btn-round btn-rose btn-file">-->
                                <!--                                                        <span class="fileinput-new">Add Photo</span>-->
                                <!--                                                        <span class="fileinput-exists">Change</span>-->
                                <!--                                                        <input type="image" name="image" id="image" />-->
                                <!--                                                    </span>-->
                                <!--                                                    <br />-->
                                <!--                                                    <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>-->
                                <!--                                                </div>-->
                                <!--                                            </div>-->
                                <!--                                        </div>-->
                                <!--                                    </div>-->
                                <!--                                </div>-->
                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Problem</label>
                                        <div class="col-md-9">
                                            <textarea class="form-control" rows="3" name="problem" id="prob"></textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Attachment (.jpeg,.jpg,.PNG,.pdf)</label>
                                        <div class="col-md-9">

                                            <!--                                            <input name="file" id="uploadfile" type="file" class="inputFile" accept="pdf/*,image/*">-->
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <!--                            <a onclick="InsertSendTicket()" id="button" class="btn btn-rose" href="vw_ticket.php"> Submit</a>-->
                                <!--                            <a type="submit" value="submit" onclick="InsertSendTicket()" class="btn btn-rose">-->
                                <!--                                Submit</a>-->
                                <input name="file" type="file" class="inputFile" accept="application/pdf,image/*"/>
                                <a onclick="InsertSendTicket()" class="btn btn-rose">
                                    Submit</a>
                                <!--                            <input onclick="InsertSendTicket()" type="submit" value="Submit" class="btn btn-rose" />-->
                                <!--                            <input onclick="InsertSendTicket()" type="submit" value="Submit" class="btn btn-rose" />-->
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <script>
        $(document).ready(function () {
            ComboDivisi();
            comboCategory();
            ComboDataAll();
        });

        $(document).on('click','.attach',function(e){
            e.preventDefault();
            $("#attachShow").modal({
                backdrop: 'static',
                keyboard: false});
            $.post('vw_read.php',
                {nama:$(this).attr('data-nama')},
                function(html){
                    $(".modal-body-attach").html(html);
                }
            );
        });

        function ComboDivisi() {
            console.log('alip');
            $.post("../ajax/divisi.php",
                // function (data) {
                // console.log(data);
                //     $(data).each(function (i, v) {
                //         $("#idComboDivisi").append('<option value="' + v['ID'] + '">' + v['Nama_div'] + '</option>');
                //     });
                //     // $("#idComboDivisi").selectpicker('refresh');
                //     // comboCategoryD();
                // }, "json");
                function (data) {
                    console.log(data);
                    $(data).each(function (i, v) {
                        $("#idComboDivisi").append('<option value="' + v['kode_div'] + '">' + v['Nama_div'] + '</option>');
                    });
                    $("#idComboDivisi").selectpicker('refresh');
                    comboCategory();
                }, "json");
        }

        function comboCategory(b) {
            $("#idComboCategory").html("");
            $("#idComboCategory").append('<option value="">--Pilih Kategori--</option>');
            if (b) {
                $.post("../ajax/category.php",
                    {"kode_div": b},
                    function (data) {
                        $(data).each(function (i, v) {
                            $("#idComboCategory").append('<option value="' + v['id'] + '">' + v['nama'] + '</option>');
                        });
                        $("#idComboCategory").selectpicker('refresh');
                        comboCategoryD();
                    }, "json");
            }

        }

        function comboCategoryD(a) {
            $("#idComboCategoryD").html("");
            $("#idComboCategoryD").append('<option value="">--Pilih Detail Kategori--</option>');

            if (a) {
                console.log("data ada");
                $.post("../ajax/categoryD.php",
                    {"id_category": a},
                    function (data) {
                        $(data).each(function (i, v) {
                            $("#idComboCategoryD").append('<option value="' + v['id'] + '">' + v['detail_name'] + '</option>');
                        });
                        $("#idComboCategoryD").selectpicker('refresh');

                    }, "json");
            }
        }

        function ComboDataAll() {
            $("#idComboDivisi").change(function () {
                comboCategory($(this).val());
            });

            $("#idComboCategory").change(function () {
                comboCategoryD($(this).val());
            });
        }

        function InsertSendTicket() {
            var data = {
                idComboDivisi: $("#idComboDivisi").val(),
                idComboCategory: $("#idComboCategory").val(),
                idComboCategoryD: $("#idComboCategoryD").val(),
                prio: $("#prio").val(),
                creator: $("#creator").val(),
                prob: $("#prob").val()
            };
            console.log(data);
            if (data.idComboDivisi && data.idComboCategory && data.idComboCategoryD && data.prob) {
                // $.post("../ajax/submitTicket.php",
                //     {
                //         "prio": data.prio,
                //         "divisi": data.idComboDivisi,
                //         "creator": data.creator,
                //         "category": data.idComboCategory,
                //         "category_detail": data.idComboCategoryD,
                //         "masalah": data.prob
                //     },
                //     "json");
                $.post("../",
                    {
                        "creator": data.creator,
                        "category_detail": data.idComboCategoryD,
                        "masalah": data.prob,
                        "divisi": data.idComboDivisi
                    },
                    "json");
                $("#uploadForm").click(function (e) {
                    e.preventDefault();
                    $.ajax({
                        // url: "../ajax/uploadfiles.php",
                        type: "POST",
                        data:  new FormData(this),
                        contentType: false,
                        cache: false,
                        processData:false,
                        success: function(data)
                        {
                            // swal("Ticket Berhasil Diupload");
                            // swal({
                            //     title: "Success!",
                            //     text: "Reloading..",
                            //     type: "success",
                            //     timer: 2000,
                            //     showConfirmButton: false
                            // }, function(){
                            //     window.location.href = "vw_ticket.php";
                            // });
                            location.reload();
                            swal('Please wait');
                            swal.showLoading();
                        },
                    });
                });
                // location.reload();
                // swal("yak");
            }

            else {
                swal("Silahkan Cek Inputan");
            }
        }

    </script>

    <!--                            <script>-->
    <!--                                $(document).ready(function(){-->
    <!--                                    $("#button").click(function(){-->
    <!--                                        var catdet=$("#catdet").val();-->
    <!--                                        var prio=$("#prio").val();-->
    <!--                                        var prob=$("#prob").val();-->
    <!--                                        $.ajax({-->
    <!--                                            url:'../proses/pros_add_ticket.php',-->
    <!--                                            method:'POST',-->
    <!--                                             data:{-->
    <!--                                                catdet:catdet,-->
    <!--                                                prio:prio,-->
    <!--                                                prob:prob-->
    <!--                                            },-->
    <!--                                            success:function(data){-->
    <!--                                                alert(data);-->
    <!--                                            }-->
    <!--                                        });-->
    <!--                                    });-->
    <!--                                });-->
    <!--                            </script>-->
    <!--                            <Script>-->
    <!--                                function data1(){-->
    <!--                                    var data = {-->
    <!--                                        message: $("#prob").val(),-->
    <!--                                        catdet: $("#catdet").val()-->
    <!--                                    };-->
    <!--                                    $.ajax({-->
    <!--                                        type: "POST",-->
    <!--                                        url: "kirimemail.php",-->
    <!--                                        data: data,-->
    <!--                                        success: function(){-->
    <!--                                            $('.success').fadeIn(1000);-->
    <!--                                        }-->
    <!--                                    });-->
    <!--                                }-->
    <!--                            </script>-->
    <script>
        jQuery(document).ready(function() {
            jQuery(".expand-content-link").click(function() {
                jQuery(this).next(".hidden-content").toggle();
                return false;
            });
        });
    </script>
</body>
<!--   Core JS Files   -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery-3.1.1.min.js" type="text/javascript"></script>
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo _CDN_HOST ?>/assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo _CDN_HOST ?>/assets/js/material.min.js" type="text/javascript"></script>
<script src="<?php echo _CDN_HOST ?>/assets/js/perfect-scrollbar.jquery.min.js"
        type="text/javascript"></script>
<!-- Forms Validations Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.validate.min.js"></script>
<!--  Plugin for Date Time Picker and Full Calendar Plugin-->
<script src="<?php echo _CDN_HOST ?>/assets/js/moment.min.js"></script>
<!--  Charts Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/chartist.min.js"></script>
<!--  Plugin for the Wizard -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.bootstrap-wizard.js"></script>
<!--  Notifications Plugin    -->
<script src="<?php echo _CDN_HOST ?>/assets/js/bootstrap-notify.js"></script>
<!-- DateTimePicker Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/bootstrap-datetimepicker.js"></script>
<!-- Vector Map plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery-jvectormap.js"></script>
<!-- Sliders Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/nouislider.min.js"></script>
<!--  Google Maps Plugin    -->
<script src="https://maps.googleapis.com/maps/api/js"></script>
<!-- Select Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.select-bootstrap.js"></script>
<!--  DataTables.net Plugin    -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.datatables.js"></script>
<!-- Sweet Alert 2 plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/sweetalert2.js"></script>
<!--	Plugin for Fileupload, full documentation here: http://www.jasny.net/bootstrap/javascript/#fileinput -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo _CDN_HOST ?>/assets/js/fullcalendar.min.js"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo _CDN_HOST ?>/assets/js/material-dashboard.js"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="<?php echo _CDN_HOST ?>/assets/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatables').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            orderFixed: [[ 0, "desc" ]],
            responsive: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search records",
            }

        });


        var table = $('#datatables').DataTable();

        // Edit record
        table.on('click', '.edit', function () {
            $tr = $(this).closest('tr');

            var data = table.row($tr).data();
            alert('You press on Row: ' + data[0] + ' ' + data[1] + ' ' + data[2] + '\'s row.');
        });

        $('.card .material-datatables label').addClass('form-group');
    });
</script>


</html>
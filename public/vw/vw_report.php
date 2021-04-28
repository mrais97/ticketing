<?php
require("../config.php");
if (!isset($_SESSION["role"])) {
    header("location: ../index.php");
}
$roleuser = $_SESSION['role'];
$uiduser = $_SESSION['uid'];
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];


$sql = "
    SELECT DISTINCT
    A.id AS 'id',
    DATE_FORMAT(A.created_at, '%d %M %Y') AS 'Tanggal',
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

$result = mysqli_query($con, $sql);

$sql2 = "SELECT 
a.nama,
CASE
WHEN b.us_role = 1 THEN 'user'
WHEN b.us_role = 2 THEN 'PIC'
WHEN b.us_role = 3 THEN 'Admin'
END AS role
FROM ticket_staging.mr_peg_info_personal a
JOIN ticket_staging.t_role b
ON a.user_uid=b.us_uid
WHERE b.us_uid='$uiduser'
";
$result2 = mysqli_query($con, $sql2);
$row2 = mysqli_fetch_array($result2);
$namas = $row2[0];
$roles = $row2[1];

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
        Report Ticket
    </title>
</head>

<body>
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
                    <a class="navbar-brand" href="#"> Report Ticket </a>
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
                                <h4 class="card-title" style="display: inline-block">Report Ticket</h4>
                                <!--                                <button class="btn btn-rose" style="float: right">Download Report-->
                                <!--                                    <a href="../proses/pros_report.php"></a>-->
                                <!--                                    <i class="material-icons">get_app</i>-->
                                <!--                                </button>-->
                                <!--                                <a class="btn btn-rose" style="float: right" href="../proses/pros_report.php">-->
                                <!--                                    Download Report-->
                                <!--                                    <i class="material-icons">get_app</i>-->
                                <!--                                </a>-->
                                <div class="toolbar">
                                    <!--        Here you can write extra buttons/actions for the toolbar              -->

                                </div>
                                <form class="form-horizontal" method="POST">
                                    <!--                                    method="POST" action="../proses/pros_report_alt.php"-->
                                    <!--                                    <input type="hidden" id="username" name="username"-->
                                    <!--                                           value="-->
                                    <?php //echo $username; ?><!--">-->
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Start Date</label>
                                                <div class="col-md-9">
                                                    <input id="from" name='from' type="date" value="<?php echo date("Y-m-01");?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">To Date</label>
                                                <div class="col-md-9">
                                                    <input id="to" name='to' type="date" value="<?php echo date("Y-m-d");?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Division</label>
                                                <div class="col-md-9">
                                                    <select name="idComboDivisi" id="idComboDivisi"
                                                            class="combook col-md-3">
                                                        <option value="0">All</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Category</label>
                                                <div class="col-md-9">
                                                    <select name="idComboCategory" id="idComboCategory"
                                                            class="combook col-md-3">
                                                        <option value="0">All</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Detail
                                                    Category</label>
                                                <div class="col-md-9">
                                                    <select name="idComboCategoryD" id="idComboCategoryD"
                                                            class="combook col-md-3">
                                                        <option value="0">All</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Flag</label>
                                                <div class="col-md-9">
                                                    <select data-style="select-with-transition" name='flag' id="flag"
                                                            class="col-md-3">
                                                        <option value="">All</option>
                                                        <option value="0">Open</option>
                                                        <option value="1">Close</option>
                                                        <option value="2">Hold</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="col-md-12" align="right">
                                            <a onclick="reportok()" class="btn btn-rose">
                                                <i class="material-icons">get_app</i> Download Report
                                            </a>
                                            <!--                                            <button class="btn btn-rose" id="button" type="submit" value="submit"><i-->
                                            <!--                                                        class="material-icons">get_app</i> Download Report-->
                                            <!--                                            </button>-->
                                            <script>
                                                $(document).ready(function () {
                                                    ComboDivisi();
                                                    comboCategory();
                                                    ComboDataAll();
                                                    OjjK();
                                                });

                                                function reportok() {
                                                    window.location = "../proses/pros_report_alt.php?div=" + $("#idComboDivisi").val()
                                                        + "&cat=" + $("#idComboCategory").val()
                                                        + "&catdet=" + $("#idComboCategoryD").val()
                                                        + "&to=" + $("#to").val()
                                                        + "&from=" + $("#from").val()
                                                        + "&flag=" + $("#flag").val();
                                                    swal({
                                                      title: 'Sedang mendownload File',
                                                      text: "silahkan tunggu sebentar",
                                                      showConfirmButton: false,
                                                      closeOnClickOutside: false,
                                                      allowOutsideClick: false,
                                                      allowEscapeKey: false
                                                      });
                                                      swal.showLoading();
                                                      window.setTimeout(function () {
                                                          location.reload();
                                                      }, 10000);
                                                }

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
                                                    $("#idComboCategory").append('<option value="0">All</option>');
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
                                                    $("#idComboCategoryD").append('<option value="0">All</option>');

                                                    if (a) {
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

                                                function OjjK() {
                                                }

                                                $(document).ready(function () {
                                                    $("#button").click(function () {
                                                        var combo = {
                                                            idComboCategory: $("#idComboCategory").val(),
                                                            idComboCategoryD: $("#idComboCategoryD").val()
                                                        };
                                                        console.log(combo);
                                                        var to = $("#to").val();
                                                        var from = $("#from").val();
                                                        var flag = $("#flag").val();
                                                        // $.ajax({
                                                        //     url: '../proses/pros_report_alt.php',
                                                        //     method: 'POST',
                                                        //     data: {
                                                        //         to: to,
                                                        //         "cat": combo.idComboCategory,
                                                        //         "catid": combo.idComboCategoryD,
                                                        //         from: from,
                                                        //         flag: flag
                                                        //     },
                                                        //     success: function (data) {
                                                        //         swal({
                                                        //             title: 'Sedang mendownload File',
                                                        //             text: "silahkan tunggu sebentar",
                                                        //             showConfirmButton: false,
                                                        //             closeOnClickOutside: false,
                                                        //             allowOutsideClick: false,
                                                        //             allowEscapeKey: false
                                                        //         });
                                                        //         swal.showLoading();
                                                        //         window.setTimeout(function () {
                                                        //             // location.reload();
                                                        //         }, 2000);
                                                        //     }
                                                        // });
                                                    });
                                                });
                                            </script>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
<!--<script src="--><?php //echo _CDN_HOST ?><!--/assets/js/jquery.select-bootstrap.js"></script>-->
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
            orderFixed: [[0, "desc"]],
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
<script>
    $(document).ready(function () {
        $('#example').DataTable({
            initComplete: function () {
                this.api().columns().every(function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
                        .appendTo($(column.footer()).empty())
                        .on('change', function () {
                            var val = $.fn.dataTable.util.escapeRegex(
                                $(this).val()
                            );

                            column
                                .search(val ? '^' + val + '$' : '', true, false)
                                .draw();
                        });

                    column.data().unique().sort().each(function (d, j) {
                        select.append('<option value="' + d + '">' + d + '</option>')
                    });
                });
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        md.initSliders()
        demo.initFormExtendedDatetimepickers();
    });
</script>


</html>
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
    C.category_name AS 'nama category',
    B.detail_category_name AS 'nama category detail',
    A.problem,
    CASE
    WHEN A.flag ='0' THEN 'open'
    WHEN A.flag ='1' THEN 'close'
    WHEN A.flag ='2' THEN 'hold'
    END AS 'status tiket',
    F.nama
    FROM ticket_staging.t_transaksi A
    LEFT JOIN ticket_staging.t_category_detail B
    ON A.id_detail = B.id
    LEFT JOIN ticket_staging.t_category C
    ON B.id_category = C.id
    LEFT JOIN ticket_staging.t_mapping_pic D
    ON A.pic = D.user_uid
    LEFT JOIN hris_dev.mr_peg_info_personal F
    ON D.user_uid = F.user_uid
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
FROM hris_dev.mr_peg_jabatan a
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
                                <a class="btn btn-rose" style="float: right" href="../proses/pros_report.php">
                                    Download Report
                                    <i class="material-icons">get_app</i>
                                </a>
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
                                            <th style="text-align: center;">Category</th>
                                            <th style="text-align: center;">Detail Category</th>
                                            <th style="text-align: center;">Problem</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">PIC</th>
                                            <!--                                            <th style="text-align: center;">PIC</th>-->
                                            <!--                                            <th class="text-center">Actions</th>-->
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th style="text-align: center;">Date</th>
                                            <th style="text-align: center;">No Ticket</th>
                                            <th style="text-align: center;">Category</th>
                                            <th style="text-align: center;">Detail Category</th>
                                            <th style="text-align: center;">Problem</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">PIC</th>
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
                                            <td align="center"><?php echo $row[6]; ?></td>
                                            <td align="center"><?php echo $row[7]; ?></td>

                                        </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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
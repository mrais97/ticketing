<?php
require("../config.php");
if (!isset($_SESSION["role"])) {
    header("location: ../index.php");
}
$roleuser = $_SESSION['role'];
$uiduser = $_SESSION['uid'];

$sql2 = "SELECT DISTINCT
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
        User Management
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
                    <a class="navbar-brand" href="#"> User Management </a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">

                        <li class="separator hidden-lg hidden-md"></li>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 ">
                        <div class="row">
                            <div class="col-lg-12 col-md-12">
                                <div class="card">
                                    <!--                                    <div class="card-header card-header-tabs" data-background-color="rose">-->
                                    <!--                                        <div class="nav-tabs-navigation">-->
                                    <!--                                            <div class="nav-tabs-wrapper">-->
                                    <!--                                                <span class="nav-tabs-title"></span>-->
                                    <!--                                                <ul class="nav nav-tabs" data-tabs="tabs">-->
                                    <!--                                                    <li class="active">-->
                                    <!--                                                        <a href="#marissa" data-toggle="tab">-->
                                    <!--                                                            <i class="material-icons">person</i> Marissa-->
                                    <!--                                                            <div class="ripple-container"></div>-->
                                    <!--                                                        </a>-->
                                    <!--                                                    </li>-->
                                    <!--                                                    <li class="">-->
                                    <!--                                                        <a href="#non" data-toggle="tab">-->
                                    <!--                                                            <i class="material-icons">person_outline</i> Non-Marissa-->
                                    <!--                                                            <div class="ripple-container"></div>-->
                                    <!--                                                        </a>-->
                                    <!--                                                    </li>-->
                                    <!--                                                </ul>-->
                                    <!--                                            </div>-->
                                    <!--                                        </div>-->
                                    <!--                                    </div>-->
                                    <div class="card-content">
                                        <div class="card-header card-header-icon" data-background-color="rose">
                                            <i class="material-icons">description</i>
                                        </div>
                                        <!--                                        <button class="btn btn-rose" data-toggle="modal"-->
                                        <!--                                                data-target="#addtiket" style="float: right">Create User-->
                                        <!--                                            <i class="material-icons">person_add</i>-->
                                        <!--                                        </button>-->
                                        <div class="card-content">
                                            <h4 class="card-title" style="display: inline-block">User List</h4>
                                            <div class="toolbar">
                                                <!--        Here you can write extra buttons/actions for the toolbar              -->

                                            </div>
                                            <?php
                                            $sql = "
                                                SELECT DISTINCT a.us_uid,e.nik,
                                                CASE 
                                                     WHEN a.us_role ='1' THEN 'User'
                                                     WHEN a.us_role ='2' THEN 'PIC'
                                                     WHEN a.us_role ='3' THEN 'Admin'
                                                 END AS 'Role',d.KSLDIV,b.nama
                                                 FROM ticket_staging.t_role a
                                                 JOIN ticket_staging.mr_peg_info_personal b
                                                 ON a.us_uid = b.user_uid
                                                JOIN ticket_staging.mr_peg_penugasan c ON c.user_uid = a.us_uid
                                                JOIN ticket_staging.mr_ksldiv d ON d.ID_KSLDIV = c.ID_KSLDIV
                                                JOIN ticket_staging.mr_peg_perikatan e ON a.us_uid = e.user_uid
                                                 WHERE a.id>1 AND b.flag_input='1' AND c.flag_input='1' AND e.status_karyawan='1'";

                                            $result = mysqli_query($con, $sql);
                                            ?>
                                            <div class="material-datatables">
                                                <table id="datatables"
                                                       class="table table-striped table-no-bordered table-hover"
                                                       cellspacing="0" width="100%" style="width:100%">
                                                    <thead>
                                                    <tr>
                                                        <th style="text-align: center;">ID User</th>
                                                        <th style="text-align: center;">NIK</th>
                                                        <th style="text-align: center;">Divisi</th>
                                                        <th style="text-align: center;">User Name</th>
                                                        <th style="text-align: center;">User Role</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                    </thead>
                                                    <tfoot>
                                                    <tr>
                                                        <th style="text-align: center;">ID User</th>
                                                        <th style="text-align: center;">NIK</th>

                                                        <th style="text-align: center;">Divisi</th>

                                                        <th style="text-align: center;">User Name</th>
                                                        <th style="text-align: center;">User Role</th>
                                                        <th class="text-center">Actions</th>
                                                    </tr>
                                                    </tfoot>
                                                    <tbody>
                                                    <tr>
                                                        <?php while ($row = mysqli_fetch_array($result)) { ?>
                                                        <td align="center"><?php echo $row[0]; ?></td>
                                                        <td align="center"><?php echo $row[1]; ?></td>
                                                        <td align="center"><?php echo $row[3]; ?></td>
                                                        <td align="center"><?php echo $row[4]; ?></td>
                                                        <td align="center"><?php echo $row[2]; ?></td>
                                                        <td style="text-align: center"
                                                            class="td-actions text-right">
                                                            <a class="btn btn-rose btn-fill" <?php echo "href='vw_edit_role.php?id=$row[0]'"; ?>>
                                                                <i class="material-icons">edit</i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                    <?php } ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                        <!--                                            <div class="tab-pane" id="non">-->
                                        <!--                                                --><?php
                                        //                                                $sql3 = "
                                        //                                                SELECT user_uid,full_name,username,email,bagian,
                                        //                                                CASE
                                        //                                                     WHEN id_role ='1' THEN 'User'
                                        //                                                     WHEN id_role ='2' THEN 'PIC'
                                        //                                                     WHEN id_role ='3' THEN 'Admin'
                                        //                                                END AS 'Role',
                                        //                                                CASE
                                        //                                                     WHEN flag ='1' THEN 'Active'
                                        //                                                     WHEN flag ='0' THEN 'Non-Active'
                                        //                                                END AS 'Status'
                                        //                                                FROM ticket_staging.t_user
                                        //                                                ";
                                        //
                                        //                                                $result1 = mysqli_query($con, $sql3);
                                        //                                                ?>
                                        <!--                                                <div class="material-datatables">-->
                                        <!--                                                    <table id="datatables2"-->
                                        <!--                                                           class="table table-striped table-no-bordered table-hover"-->
                                        <!--                                                           cellspacing="0" width="100%" style="width:100%">-->
                                        <!--                                                        <thead>-->
                                        <!--                                                        <tr>-->
                                        <!--                                                            <th style="text-align: center;">ID User</th>-->
                                        <!--                                                            <th style="text-align: center;">Name</th>-->
                                        <!--                                                            <th style="text-align: center;">Username</th>-->
                                        <!--                                                            <th style="text-align: center;">Email</th>-->
                                        <!--                                                            <th style="text-align: center;">Divisi</th>-->
                                        <!--                                                            <th style="text-align: center;">User Role</th>-->
                                        <!--                                                            <th style="text-align: center;">Status</th>-->
                                        <!--                                                            <th class="text-center">Actions</th>-->
                                        <!--                                                        </tr>-->
                                        <!--                                                        </thead>-->
                                        <!--                                                        <tfoot>-->
                                        <!--                                                        <tr>-->
                                        <!--                                                            <th style="text-align: center;">ID User</th>-->
                                        <!--                                                            <th style="text-align: center;">Name</th>-->
                                        <!--                                                            <th style="text-align: center;">Username</th>-->
                                        <!--                                                            <th style="text-align: center;">Email</th>-->
                                        <!--                                                            <th style="text-align: center;">Divisi</th>-->
                                        <!--                                                            <th style="text-align: center;">User Role</th>-->
                                        <!--                                                            <th style="text-align: center;">Status</th>-->
                                        <!--                                                            <th class="text-center">Actions</th>-->
                                        <!--                                                        </tr>-->
                                        <!--                                                        </tfoot>-->
                                        <!--                                                        <tbody>-->
                                        <!--                                                        <tr>-->
                                        <!--                                                            --><?php //while ($row1 = mysqli_fetch_array($result1)) { ?>
                                        <!--                                                            <td align="center">-->
                                        <?php //echo $row1[0]; ?><!--</td>-->
                                        <!--                                                            <td align="center">-->
                                        <?php //echo $row1[1]; ?><!--</td>-->
                                        <!--                                                            <td align="center">-->
                                        <?php //echo $row1[2]; ?><!--</td>-->
                                        <!--                                                            <td align="center">-->
                                        <?php //echo $row1[3]; ?><!--</td>-->
                                        <?php //echo $row1[3]; ?><!--</td>-->
                                        <!--                                                            <td align="center">-->
                                        <?php //echo $row1[4]; ?><!--</td>-->
                                        <!--                                                            <td align="center">-->
                                        <?php //echo $row1[5]; ?><!--</td>-->
                                        <!--                                                            <td align="center">-->
                                        <?php //echo $row1[6]; ?><!--</td>-->
                                        <!--                                                            <td style="text-align: center"-->
                                        <!--                                                                class="td-actions text-right">-->
                                        <!--                                                                <a class="btn btn-rose btn-fill" -->
                                        <!--                                        --><?php //echo "href='vw_edit_role_non.php?id=$row1[0]'"; ?>
                                        <!--                                                                    <i class="material-icons">edit</i>-->
                                        <!--                                                                </a>-->
                                        <!--                                                            </td>-->
                                        <!--                                                        </tr>-->
                                        <!--                                                        --><?php //} ?>
                                        <!--                                                        </tbody>-->
                                        <!--                                                    </table>-->
                                        <!--                                                </div>-->
                                        <!--                                            </div>-->
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
                    <!--                       <div class="modal-header">-->
                    <!--                            <h3 class="modal-title">Create User</h3>-->
                    <!--                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">-->
                    <!--                                <i class="material-icons">clear</i>-->
                    <!--                            </button>-->
                    <!--                       </div>-->
                    <form class="form-horizontal" id="uploadForm">
                        <div class="modal-body">
                            <div class="row">
                                <div class="form-group row">
                                    <label class="col-md-3 label-on-left">Nama Lengkap</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="fulname"><!--</input>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group row">
                                    <label class="col-md-3 label-on-left">Username</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="username" minlength="6"
                                               placeholder="Min 6 karakter">
                                        <!--</input>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group row">
                                    <label class="col-md-3 label-on-left">Email</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="email" id="email"><!--</input>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group row">
                                    <label class="col-md-3 label-on-left">Bagian</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="bagian"><!--</input>-->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group row">
                                    <label class="col-md-3 label-on-left">Jabatan</label>
                                    <div class="col-md-9">
                                        <input class="form-control" type="text" id="jab"><!--</input>-->
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button class="btn btn-rose" id="button">Add</button>
                            <script>
                                $(document).ready(function () {
                                    $("#button").click(function () {
                                        var fulname = $("#fulname").val();
                                        var username = $("#username").val();
                                        var email = $("#email").val();
                                        var bagian = $("#bagian").val();
                                        var jab = $("#jab").val();
                                        if (fulname && username && email && bagian && jab) {
                                            $.ajax({
                                                url: '../proses/pros_add_role.php',
                                                method: 'POST',
                                                data: {
                                                    fulname: fulname,
                                                    username: username,
                                                    email: email,
                                                    bagian: bagian,
                                                    jab: jab
                                                },
                                                success: function (data) {
                                                    $(location).attr('href', 'vw_role.php');
                                                }
                                            });
                                        }
                                        else {
                                            swal("Silahkan Cek Inputan");
                                        }
                                    });
                                });
                            </script>
                        </div>
                    </form>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('#datatables2').DataTable({
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


        var table = $('#datatables2').DataTable();

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
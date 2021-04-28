<?php
$id = $_GET['id'];
require("../config.php");
if (!isset($_SESSION["role"]))
{
    header("location: ../index.php");
}
$roleuser= $_SESSION['role'];
$uiduser= $_SESSION['uid'];
$sql = "SELECT * FROM t_category WHERE id='$id' ";

$result = mysqli_query($con, $sql);
$data = mysqli_fetch_array($result);

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
        Category
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
                    <a class="navbar-brand" href="#">Ticket Category</a>
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
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="rose">
                                <i class="material-icons">description</i>
                            </div>
                            <div class="card-content">
                                <h4 class="card-title" style="display: inline-block">Edit Category</h4>
                                <form class="form-horizontal" method="POST">
                                    <div class="form-group">
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-sm-3" style="text-align: right;">Category ID</label>
                                                <div class="col-sm-6">
                                                    <input class="form-control" type="text" id="catid" value="<?php echo $data['id']; ?>" disabled="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Category Name</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" id="catname" value="<?php echo $data['category_name']; ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Category Status</label>
                                                <div class="col-md-9">
                                                    <select class="col-md-3" data-style="select-with-transition" id="flag">
                                                        <option value="1"<?php if ($data['flag'] == '1') echo ' selected="selected"'; ?>>Active</option>
                                                        <option value="0"<?php if ($data['flag'] == '0') echo ' selected="selected"'; ?>>Non-Active</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="col-md-12" align="right">
                                    <button class="btn btn-rose" id="button">Save Changes</button>
                                    <script>
                                        $(document).ready(function () {
                                            $("#button").click(function () {
                                                var catid = $("#catid").val();
                                                var catname = $("#catname").val();
                                                var flag = $("#flag").val();
                                                if(catid && catname && flag) {
                                                $.ajax({
                                                    url: '../proses/pros_edit_category.php',
                                                    method: 'POST',
                                                    data: {
                                                        catid:catid,
                                                        catname: catname,
                                                        flag: flag
                                                    },
                                                    success: function (data) {
                                                        $(location).attr('href', 'vw_category.php');
                                                    }
                                                });
                                                }
                                                else{
                                                    swal("Silahkan Cek Inputan");
                                                }
                                            });
                                        });
                                    </script>
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


</html>
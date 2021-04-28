<?php
require("../config.php");
if (!isset($_SESSION["role"]))
{
    header("location: ../index.php");
}
$roleuser= $_SESSION['role'];
$uiduser= $_SESSION['uid'];
$sql = "SELECT 
        a.id AS 'ID Category',
        b.Nama_div,
        a.category_name AS 'Category Name',
        CASE 
        WHEN a.flag ='0' THEN 'Non-Active'
        WHEN a.flag ='1' THEN 'Active'
        END AS 'Status'
        FROM t_category a
        JOIN t_divisi b 
        ON a.id_divisi = b.kode_div
        ";

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
                    <a class="navbar-brand" href="#"> Ticket Category </a>
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
                                <h4 class="card-title" style="display: inline-block">Category List</h4>
                                <button class="btn btn-rose" data-toggle="modal"
                                        data-target="#addcat" style="float: right">Create Category
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
                                            <th style="text-align: center;">ID Category</th>
                                            <th style="text-align: center;">Divisi</th>
                                            <th style="text-align: center;">Category Name</th>
                                            <th style="text-align: center;">Category Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th style="text-align: center;">ID Category</th>
                                            <th style="text-align: center;">Divisi</th>
                                            <th style="text-align: center;">Category Name</th>
                                            <th style="text-align: center;">Category Status</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        <tr>
                                            <?php while ($row = mysqli_fetch_array($result)) { ?>
                                            <td align="center"><?php echo $row[0]; ?></td>
                                            <td align="center"><?php echo $row[1]; ?></td>
                                            <td align="center"><?php echo $row[2]; ?></td>
                                            <td align="center"><?php echo $row[3]; ?></td>
                                            <td style="text-align: center" class="td-actions text-right">
                                                <a class="btn btn-rose btn-fill" <?php echo "href='vw_edit_category.php?id=$row[0]'"; ?>>
                                                    <i class="material-icons">edit</i>
                                                </a>
                                            </td>
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
            <div class="modal fade" id="addcat" tabindex="-1" role="dialog">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title">Create Category</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="material-icons">clear</i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form class="form-horizontal">
                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3 label-on-left">Category Name</label>
                                        <div class="col-md-9">
                                            <input class="form-control" type="text" id="catname"><!--</input>-->
                                        </div>
                                    </div>
                                </div>
<!--                                <div class="row">-->
<!--                                    <div class="form-group row">-->
<!--                                        <label class="col-md-3">Divisi</label>-->
<!--                                        <select class="col-md-3" data-style="select-with-transition" id="div">-->
<!--                                            <option value="">--Pilih Divisi--</option>-->
<!--                                            --><?php
//                                            $sql = mysqli_query($con, "SELECT ID,Nama_divisi FROM t_divisi where flag='1'");
//                                            while ($row = $sql->fetch_assoc()){
//                                                echo "<option value=".$row['ID'].">".$row['Nama_divisi']."</option>";
//                                            }
//                                            ?>
<!--                                        </select>-->
<!--                                    </div>-->
<!--                                </div>-->
                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3">Divisi</label>
                                        <select class="col-md-3" data-style="select-with-transition" id="div">
                                            <option value="">--Pilih Divisi--</option>
                                            <?php
                                             $sql = mysqli_query($con, "SELECT kode_div,Nama_div FROM t_divisi where Flag='1'");
                                             while ($row = $sql->fetch_assoc()){
                                             echo "<option value=".$row['kode_div'].">".$row['Nama_div']."</option>";
                                             }
                                             ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3">Category Status</label>
                                        <select class="col-md-3" data-style="select-with-transition" id="flag">
                                            <option value="">--Pilih Status--</option>
                                            <option value="1">Active</option>
                                            <option value="0">Non-Active</option>
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="modal-footer">
                            <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            <button class="btn btn-rose" id="button">Add</button>
                            <script>
                                $(document).ready(function () {
                                    $("#button").click(function () {
                                        var catname = $("#catname").val();
                                        var div = $("#div").val();
                                        var flag = $("#flag").val();
                                        if(catname && flag) {
                                            $.ajax({
                                                url: '../proses/pros_add_category.php',
                                                method: 'POST',
                                                data: {
                                                    catname: catname,
                                                    div: div,
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



<html>
<?php
require("../config.php");
if (!isset($_SESSION["role"])) {
    header("location: ../index.php");
}
$roleuser = $_SESSION['role'];
$uiduser = $_SESSION['uid'];

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

if ($roleuser == 3) {
    $sql = "
SELECT
A.id AS 'id',
DATE_FORMAT(A.created_at, '%d %M %Y %H:%i') AS 'Tanggal',
A.no_ticket AS 'nomor tiket',
CASE 
WHEN E.nama IS NULL THEN (SELECT UPPER(G.full_name) FROM t_user G  WHERE A.pic_report=G.user_uid)
ELSE E.nama
END AS 'Creator',
H.KSLDIV AS 'nama Divisi',
C.category_name AS 'nama category',
B.detail_category_name AS 'nama category detail',
A.problem,
CASE
WHEN A.flag ='0' THEN 'open'
WHEN A.flag ='1' THEN 'close'
WHEN A.flag ='2' THEN 'hold'
END AS 'status tiket',
F.nama,
A.detail,
A.nama_file,
CASE
WHEN A.priority ='1' THEN 'Low'
WHEN A.priority ='2' THEN 'Medium'
WHEN A.priority ='3' THEN 'High'
END AS 'Prioritas',
CASE
WHEN A.priority ='1' THEN '(3 X 24 Jam)'
WHEN A.priority ='2' THEN '(2 X 24 Jam)'
WHEN A.priority ='3' THEN '(1 X 24 Jam)'
END AS 'waktu'
FROM ticket_staging.t_transaksi A
LEFT JOIN ticket_staging.t_category_detail B
ON A.id_detail = B.id
LEFT JOIN ticket_staging.t_category C
ON B.id_category = C.id
LEFT JOIN ticket_staging.mr_peg_info_personal F
ON A.pic = F.user_uid
LEFT JOIN ticket_staging.mr_peg_info_personal E
ON A.pic_report = E.user_uid
LEFT JOIN ticket_staging.t_divisi D
ON C.id_divisi = D.kode_div
LEFT JOIN ticket_staging.mr_peg_penugasan G
ON A.pic_report  = G.user_uid
LEFT JOIN ticket_staging.mr_ksldiv H
ON G.ID_KSLDIV = H.ID_KSLDIV
WHERE A.id>1 AND G.flag_input='1' AND A.flag = '1' AND A.id_divisi='59' AND C.id='5'
ORDER BY A.created_at DESC";

} else {
    $sql = "
SELECT
A.id AS 'id',
DATE_FORMAT(A.created_at, '%d %M %Y %H:%i') AS 'Tanggal',
A.no_ticket AS 'nomor tiket',
CASE 
WHEN E.nama IS NULL THEN (SELECT UPPER(G.full_name) FROM t_user G  WHERE A.pic_report=G.user_uid)
ELSE E.nama
END AS 'Creator',
H.KSLDIV AS 'nama Divisi',
C.category_name AS 'nama category',
B.detail_category_name AS 'nama category detail',
A.problem,
CASE
WHEN A.flag ='0' THEN 'open'
WHEN A.flag ='1' THEN 'close'
WHEN A.flag ='2' THEN 'hold'
END AS 'status tiket',
F.nama,
A.detail,
A.nama_file,
CASE
WHEN A.priority ='1' THEN 'Low'
WHEN A.priority ='2' THEN 'Medium'
WHEN A.priority ='3' THEN 'High'
END AS 'Prioritas',
CASE
WHEN A.priority ='1' THEN '(3 X 24 Jam)'
WHEN A.priority ='2' THEN '(2 X 24 Jam)'
WHEN A.priority ='3' THEN '(1 X 24 Jam)'
END AS 'waktu'
FROM ticket_staging.t_transaksi A
LEFT JOIN ticket_staging.t_category_detail B
ON A.id_detail = B.id
LEFT JOIN ticket_staging.t_category C
ON B.id_category = C.id
LEFT JOIN ticket_staging.mr_peg_info_personal F
ON A.pic = F.user_uid
LEFT JOIN ticket_staging.mr_peg_info_personal E
ON A.pic_report = E.user_uid
LEFT JOIN ticket_staging.t_divisi D
ON C.id_divisi = D.kode_div
LEFT JOIN ticket_staging.t_mapping_pic I
ON B.id = I.id_detail
LEFT JOIN ticket_staging.mr_peg_penugasan G
ON A.pic_report  = G.user_uid
LEFT JOIN ticket_staging.mr_ksldiv H
ON G.ID_KSLDIV = H.ID_KSLDIV
WHERE A.id>1 AND I.user_uid='$uiduser' AND I.flag='1' AND G.flag_input='1' AND A.flag = '1' AND A.id_divisi='59' AND C.id='5'
ORDER BY A.created_at DESC";
}

$result = mysqli_query($con, $sql);
?>
<!doctype html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" href="../kisel.png"/>
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
    <meta http-equiv="refresh" content="180"/>
    <title>
        Ticket Management
    </title>
</head>

<body>
<style>

    .hidden-content {
        display: none;
    }

</style>
<div class="wrapper">
    <div class="sidebar" data-active-color="rose" data-background-color="black"
         data-image="<?php echo _CDN_HOST ?>/assets/img/sidebar-1.jpg">
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
                    <a class="navbar-brand" href="#"> Ticket Management </a>
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
                                <div class="toolbar">
                                </div>
                                <div class="material-datatables">
                                    <table id="datatables" class="table table-striped table-no-bordered table-hover"
                                           cellspacing="0" width="100%" style="width:100%">
                                        <thead>
                                        <tr>
                                            <th style="text-align: center;">Date</th>
                                            <th style="text-align: center;">No Ticket</th>
                                            <th style="text-align: center;">Creator</th>
                                            <th style="text-align: center;">Category</th>
                                            <th style="text-align: center;">Detail Category</th>
                                            <th style="text-align: center;">Problem</th>
                                            <th style="text-align: center;">Prioritas</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">PIC</th>
                                            <th style="text-align: center;">Keterangan</th>
                                            <th style="text-align: center;">Attachment</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </thead>
                                        <tfoot>
                                        <tr>
                                            <th style="text-align: center;">Date</th>
                                            <th style="text-align: center;">No Ticket</th>
                                            <th style="text-align: center;">Creator</th>
                                            <th style="text-align: center;">Category</th>
                                            <th style="text-align: center;">Detail Category</th>
                                            <th style="text-align: center;">Problem</th>
                                            <th style="text-align: center;">Prioritas</th>
                                            <th style="text-align: center;">Status</th>
                                            <th style="text-align: center;">PIC</th>
                                            <th style="text-align: center;">Keterangan</th>
                                            <th style="text-align: center;">Attachment</th>
                                            <th class="text-center">Actions</th>
                                        </tr>
                                        </tfoot>
                                        <tbody>
                                        <?php while ($row = mysqli_fetch_array($result)) {
                                            if ($row[8] == 'open') { ?>
                                                <!--                                                <tr style="font-weight:900;">-->
                                                <tr style="font-weight: bold">
                                                    <td align="center"><?php echo $row[1]; ?></td><!--date-->
                                                    <td align="center"><?php echo $row[2]; ?></td><!--no ticket-->
                                                    <td align="center"><?php echo $row[3]; ?><!--creator-->
                                                        <div class="content-holder">
                                                            <a href="#"
                                                               class="expand-content-link">Divisi</a>
                                                            <div class="hidden-content"><?php echo $row[4]; ?></div>
                                                        </div>
                                                    </td><!--creator-->
                                                    <td align="center"><?php echo $row[5]; ?></td><!--category-->
                                                    <td align="center"><?php echo $row[6]; ?></td><!--det category-->
                                                    <td align="center" class="more"><?php echo $row[7]; ?> >
                                                        <!--problem-->
                                                    <td align="center"><?php echo $row[13]; ?>
                                                        <br><?php echo $row[12]; ?></td><!--prioritas-->
                                                    <td align="center"
                                                        style="color: #e74c3c;font-weight: bold;"><?php echo $row[8]; ?></td><!--status-->
                                                    <td align="center"><?php echo $row[9]; ?></td><!--PIC-->
                                                    <td align="center" class="more">
                                                        <?php echo $row[10]; ?><!--problem--></td>
                                                    <?php if ($row[11] !='') { ?>
                                                        <td align="center"><a href='#' data-target='#attachShow'
                                                                              data-backdrop='static' data-keyboard='false'
                                                                              class='attach'
                                                                              data-nama="<?php echo $row[11]; ?>"><i
                                                                        class="material-icons">insert_drive_file</i></a>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td align="center"><a href='#' data-target='#attachShow'
                                                                              data-backdrop='static' data-keyboard='false'
                                                                              class='attach'
                                                                              data-nama="<?php echo $row[11]; ?>"><?php echo $row[11]; ?></a>
                                                        </td>
                                                    <?php } ?>
                                                    <td style="text-align: center" class="td-actions text-right">
                                                        <a class="btn btn-rose btn-fill" <?php echo "href='vw_edit_ticket_manager.php?id=$row[0]'"; ?>>
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } else if ($row[8] == 'close') { ?>
                                                <tr style="opacity: 0.6;font-weight: bold">
                                                    <td align="center"><?php echo $row[1]; ?></td><!--date-->
                                                    <td align="center"><?php echo $row[2]; ?></td><!--no ticket-->
                                                    <td align="center"><?php echo $row[3]; ?><!--creator-->
                                                        <div class="content-holder">
                                                            <a href="#"
                                                               class="expand-content-link">Divisi</a>
                                                            <div class="hidden-content"><?php echo $row[4]; ?></div>
                                                        </div>
                                                    </td><!--creator-->
                                                    <td align="center"><?php echo $row[5]; ?></td><!--category-->
                                                    <td align="center"><?php echo $row[6]; ?></td><!--det category-->
                                                    <td align="center" class="more"><?php echo $row[7]; ?> >
                                                        <!--problem-->
                                                    <td align="center"><?php echo $row[13]; ?>
                                                        <br><?php echo $row[12]; ?></td><!--prioritas-->
                                                    <td align="center"
                                                        style="color: #1abc9c;font-weight: bold;"><?php echo $row[8]; ?></td><!--status-->
                                                    <td align="center"><?php echo $row[9]; ?></td><!--PIC-->
                                                    <td align="center" class="more">
                                                        <?php echo $row[10]; ?><!--problem--></td>
                                                    <?php if ($row[11] !='') { ?>
                                                        <td align="center"><a href='#' data-target='#attachShow'
                                                                              data-backdrop='static' data-keyboard='false'
                                                                              class='attach'
                                                                              data-nama="<?php echo $row[11]; ?>"><i
                                                                        class="material-icons">insert_drive_file</i></a>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td align="center"><a href='#' data-target='#attachShow'
                                                                              data-backdrop='static' data-keyboard='false'
                                                                              class='attach'
                                                                              data-nama="<?php echo $row[11]; ?>"><?php echo $row[11]; ?></a>
                                                        </td>
                                                    <?php } ?>
                                                    <td style="text-align: center" class="td-actions text-right">
                                                        <a class="btn btn-success btn-fill" <?php echo "href='vw_edit_ticket_manager.php?id=$row[0]'"; ?>>
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php } else { ?>
                                                <tr>
                                                    <td align="center"><?php echo $row[1]; ?></td><!--date-->
                                                    <td align="center"><?php echo $row[2]; ?></td><!--no ticket-->
                                                    <td align="center"><?php echo $row[3]; ?><!--creator-->
                                                        <div class="content-holder">
                                                            <a href="#"
                                                               class="expand-content-link">Divisi</a>
                                                            <div class="hidden-content"><?php echo $row[4]; ?></div>
                                                        </div>
                                                    </td><!--creator-->
                                                    <td align="center"><?php echo $row[5]; ?></td><!--category-->
                                                    <td align="center"><?php echo $row[6]; ?></td><!--det category-->
                                                    <td align="center" class="more"><?php echo $row[7]; ?> >
                                                        <!--problem-->
                                                    <td align="center"><?php echo $row[13]; ?>
                                                        <br><?php echo $row[12]; ?></td><!--prioritas-->
                                                    <td align="center"
                                                        style="color: #f1c40f;font-weight: bold;"><?php echo $row[8]; ?></td><!--status-->
                                                    <td align="center"><?php echo $row[9]; ?></td><!--PIC-->
                                                    <td align="center" class="more">
                                                        <?php echo $row[10]; ?><!--problem--></td>
                                                    <?php if ($row[11] !='') { ?>
                                                        <td align="center"><a href='#' data-target='#attachShow'
                                                                              data-backdrop='static' data-keyboard='false'
                                                                              class='attach'
                                                                              data-nama="<?php echo $row[11]; ?>"><i
                                                                        class="material-icons">insert_drive_file</i></a>
                                                        </td>
                                                    <?php } else { ?>
                                                        <td align="center"><a href='#' data-target='#attachShow'
                                                                              data-backdrop='static' data-keyboard='false'
                                                                              class='attach'
                                                                              data-nama="<?php echo $row[11]; ?>"><?php echo $row[11]; ?></a>
                                                        </td>
                                                    <?php } ?>
                                                    <td style="text-align: center" class="td-actions text-right">
                                                        <a class="btn btn-rose btn-fill" <?php echo "href='vw_edit_ticket_manager.php?id=$row[0]'"; ?>>
                                                            <i class="material-icons">edit</i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php }
                                        } ?>
                                        </tbody>
                                    </table>
                                    <div class="modal fade" id="attachShow" tabindex="-1" role="dialog"
                                         aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="exampleModalLongTitle">Show
                                                        Attachment</h5>
                                                    </button>
                                                </div>
                                                <div class="modal-body-attach">
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Close
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <script>
                                        $(document).on('click', '.attach', function (e) {
                                            e.preventDefault();
                                            $("#attachShow").modal({
                                                backdrop: 'static',
                                                keyboard: false
                                            });
                                            $.post('vw_read.php',
                                                {nama: $(this).attr('data-nama')},
                                                function (html) {
                                                    $(".modal-body-attach").html(html);
                                                }
                                            );
                                        });
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .morecontent span {
            display: none;
        }

        .morelink {
            display: block;
        }
    </style>
    <script>
        jQuery(document).ready(function () {
            jQuery(".expand-content-link").click(function () {
                jQuery(this).next(".hidden-content").toggle();
                return false;
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            // Configure/customize these variables.
            var showChar = 70;  // How many characters are shown by default
            var ellipsestext = "...";
            var moretext = "Show more";
            var lesstext = "Show less";


            $('.more').each(function () {
                var content = $(this).html();

                if (content.length > showChar) {

                    var c = content.substr(0, showChar);
                    var h = content.substr(showChar, content.length - showChar);

                    var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span>' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink">' + moretext + '</a></span>';

                    $(this).html(html);
                }

            });

            $(".morelink").click(function () {
                if ($(this).hasClass("less")) {
                    $(this).removeClass("less");
                    $(this).html(moretext);
                } else {
                    $(this).addClass("less");
                    $(this).html(lesstext);
                }
                $(this).parent().prev().toggle();
                $(this).prev().toggle();
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
            order: [[1, "desc"]],
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
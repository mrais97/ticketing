<?php
require "../config.php";
if (!isset($_SESSION["role"])) {
    header("location: ../index.php");
}
$roleuser = $_SESSION['role'];
$uiduser = $_SESSION['uid'];
$username = $_SESSION['username'];

$sql1 = "SELECT 
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
$result1 = mysqli_query($con, $sql1);
$row1 = mysqli_fetch_array($result1);
$namas = $row1[0];
$roles = $row1[1];
// result1,sql1,row1


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
    <title>
        Dashboard
    </title>
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>

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
                                <a href="<?php echo _BASE_DIR ?>proses/pros_logout.php">Log Out</a>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
            <ul class="nav">
                <li>
                    <a href="<?php echo _BASE_DIR ?>vw/vw_dashboard.php">
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
                    <a class="navbar-brand" href="#"> Dashboard </a>
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
                                    <div class="card-header card-header-tabs" data-background-color="rose">
                                        <div class="nav-tabs-navigation">
                                            <div class="nav-tabs-wrapper">
                                                <span class="nav-tabs-title"></span>
                                                <ul class="nav nav-tabs" data-tabs="tabs">
                                                    <li class="active">
                                                        <a href="#All" data-toggle="tab">
                                                            <i class="material-icons">assessment</i> All
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#IT" data-toggle="tab">
                                                            <i class="material-icons">desktop_windows</i> IT
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#GA" data-toggle="tab">
                                                            <i class="material-icons">location_city</i> GA
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                    <li class="">
                                                        <a href="#ITW" data-toggle="tab">
                                                            <i class="material-icons">public</i> IT - WILAYAH
                                                            <div class="ripple-container"></div>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-content">
                                        <div class="tab-content">
                                            <div class="tab-pane active" id="All">
                                                <table class="table">
                                                    <tbody>
                                                    <?php
                                                    if ($roleuser == 3) {
                                                        $sql2 = "SELECT
                                                    COUNT(flag) AS 'Total',
                                                    COUNT(CASE WHEN flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM t_transaksi WHERE id > 1";
                                                    } else if ($roleuser == 2) {
                                                        $sql2 = "SELECT
                                                    COUNT(A.flag) AS 'Total',
                                                    COUNT(CASE WHEN A.flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN A.flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN A.flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM ticket_staging.t_transaksi A
                                                    LEFT JOIN ticket_staging.t_category_detail B
                                                    ON A.id_detail = B.id
                                                    LEFT JOIN ticket_staging.t_mapping_pic G
                                                    ON B.id = G.id_detail
                                                    WHERE A.id>1 AND G.user_uid='$uiduser' and G.flag='1'";
                                                    } else {
                                                        $sql2 = "SELECT
                                                    COUNT(flag) AS 'Total',
                                                    COUNT(CASE WHEN flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM t_transaksi WHERE id > 1 and pic_report = '$uiduser'";
                                                    }


                                                    $result2 = mysqli_query($con, $sql2);
                                                    $records = mysqli_num_rows($result2);

                                                    while ($row2 = mysqli_fetch_array($result2)) {
                                                        $total = $row2['Total'];
                                                        $open = $row2['Open'];
                                                        $close = $row2['Close'];
                                                        $hold = $row2['Hold'];
                                                    }
                                                    ?>
                                                    <script type="text/javascript">
                                                        google.load("visualization", "1", {packages: ["corechart"]});
                                                        google.setOnLoadCallback(drawChart);

                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([

                                                                ['Category', 'Value'],
                                                                <?php
                                                                if ($roleuser == 3) {
                                                                    $query = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else if ($roleuser == 2) {
                                                                    $query = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  LEFT JOIN t_mapping_pic D 
                                                                  ON B.id = D.id_detail
                                                                  WHERE A.id>1 AND D.user_uid='$uiduser' and D.flag='1'
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else {
                                                                    $query = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                WHERE A.id>1 and A.pic_report = '$uiduser'
                                                              GROUP BY C.category_name
                                                                ";

                                                                }

                                                                $exec = mysqli_query($con, $query);
                                                                while ($row3 = mysqli_fetch_array($exec)) {

                                                                    echo "['" . $row3['Category'] . "'," . $row3['Value'] . "],";
                                                                }
                                                                ?>

                                                            ]);


                                                            var options = {
                                                                width: 480,
                                                                height: 350,
                                                                chartArea: {
                                                                    left: 80,
                                                                    top: 50,
                                                                    'width': '100%',
                                                                    'height': '60%'
                                                                },
                                                                legend: {'position': 'bottom'},
                                                                color: ['yellow', 'green', 'blue']

                                                            }
                                                            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart1"));
                                                            chart.draw(data, options);
                                                        }
                                                    </script>
                                                    <script type="text/javascript">
                                                        google.load("visualization", "1", {packages: ["corechart"]});
                                                        google.setOnLoadCallback(drawChart);

                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([

                                                                ['Category', 'Value'],
                                                                <?php
                                                                if ($roleuser == 3) {
                                                                    $query = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else if ($roleuser == 2) {
                                                                    $query = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  LEFT JOIN t_mapping_pic D 
                                                                  ON B.id = D.id_detail
                                                                  WHERE A.id>1 AND D.user_uid='$uiduser' and D.flag='1'
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else {
                                                                    $query = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                WHERE A.id>1 and A.pic_report = '$uiduser'
                                                              GROUP BY C.category_name
                                                                ";

                                                                }

                                                                $exec = mysqli_query($con, $query);
                                                                while ($row3 = mysqli_fetch_array($exec)) {

                                                                    echo "['" . $row3['Category'] . "'," . $row3['Value'] . "],";
                                                                }
                                                                ?>

                                                            ]);


                                                            var options = {
                                                                is3D: 'true',
                                                                width: 480,
                                                                height: 350,
                                                                chartArea: {
                                                                    left: 120,
                                                                    top: 50,
                                                                    'width': '100%',
                                                                    'height': '60%'
                                                                },
                                                                colors: ['#00FF7F', '#ff7b25', '#4169E1', '#DC143C']
                                                            };
                                                            var chart = new google.visualization.PieChart(document.getElementById('chart_div1'));
                                                            chart.draw(data, options);
                                                        }
                                                    </script>
                                                    <div class="tab-content">
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="orange">
                                                                    <i class="material-icons">list</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Total Ticket</p>
                                                                    <h3 class="card-title"> <?php echo $total; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager.php">View All ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="rose">
                                                                    <i class="material-icons">add</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Open</p>
                                                                    <h3 class="card-title"><?php echo $open; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_open.php">View Open ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="green">
                                                                    <i class="material-icons">clear</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Close</p>
                                                                    <h3 class="card-title"><?php echo $close; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_close.php">View Close ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="blue">
                                                                    <i class="material-icons">error_outline</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">hold</p>
                                                                    <h3 class="card-title"><?php echo $hold; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_hold.php">View Hold ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header card-header-icon"
                                                                     data-background-color="blue">
                                                                    <i class="material-icons">insert_chart</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <h4 class="card-title">Ticket Category
                                                                    </h4>
                                                                </div>
                                                                <div id="columnchart1" class="ct-chart"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header card-header-icon"
                                                                     data-background-color="red">
                                                                    <i class="material-icons">pie_chart</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <h4 class="card-title">Ticket Category
                                                                    </h4>
                                                                </div>
                                                                <div id="chart_div1" class="ct-chart"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--result2,records,total,open,close,hold,query,exec,sql2,row2,row3<-->
                                            <div class="tab-pane" id="IT">
                                                <table class="table">
                                                    <tbody>
                                                    <?php
                                                    if ($roleuser == 3) {
                                                        $sql3 = "SELECT
                                                     COUNT(flag) AS 'Total',
                                                     COUNT(CASE WHEN flag ='0' THEN 'Open' END)AS 'Open' ,
                                                     COUNT(CASE WHEN flag ='1' THEN 'Close' END)AS 'Close' ,
                                                     COUNT(CASE WHEN flag ='2' THEN 'Hold' END)AS 'Hold'
                                                     FROM t_transaksi WHERE id > 1 AND id_divisi='59'";
                                                    } else if ($roleuser == 2) {
                                                        $sql3 = "SELECT
                                                    COUNT(A.flag) AS 'Total',
                                                    COUNT(CASE WHEN A.flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN A.flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN A.flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM ticket_staging.t_transaksi A
                                                    LEFT JOIN ticket_staging.t_category_detail B
                                                    ON A.id_detail = B.id
                                                    LEFT JOIN ticket_staging.t_mapping_pic G
                                                    ON B.id = G.id_detail
                                                    WHERE A.id>1 AND A.id_divisi='59' AND G.user_uid='$uiduser' and G.flag='1'";

                                                    } else {
                                                        $sql3 = "SELECT
                                                    COUNT(flag) AS 'Total',
                                                    COUNT(CASE WHEN flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM t_transaksi WHERE id > 1 AND id_divisi='59' and pic_report = '$uiduser'";
                                                    }


                                                    $result3 = mysqli_query($con, $sql3);
                                                    $records1 = mysqli_num_rows($result3);

                                                    while ($row4 = mysqli_fetch_array($result3)) {
                                                        $total1 = $row4['Total'];
                                                        $open1 = $row4['Open'];
                                                        $close1 = $row4['Close'];
                                                        $hold1 = $row4['Hold'];
                                                    }
                                                    ?>
                                                    <script type="text/javascript">
                                                        google.load("visualization", "1", {packages: ["corechart"]});
                                                        google.setOnLoadCallback(drawChart);

                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([

                                                                ['Category', 'Value'],
                                                                <?php
                                                                if ($roleuser == 3) {
                                                                    $query1 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1 AND C.id_divisi='59'
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else if ($roleuser == 2) {
                                                                    $query1 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  LEFT JOIN t_mapping_pic D 
                                                                  ON B.id = D.id_detail
                                                                  WHERE A.id>1 AND C.id_divisi='59' AND D.user_uid='$uiduser' and D.flag='1'
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else {
                                                                    $query1 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1 AND C.id_divisi='59' and A.pic_report = '$uiduser'
                                                              GROUP BY C.category_name
                                                                ";

                                                                }

                                                                $exec1 = mysqli_query($con, $query1);
                                                                while ($row5 = mysqli_fetch_array($exec1)) {

                                                                    echo "['" . $row5['Category'] . "'," . $row5['Value'] . "],";
                                                                }
                                                                ?>

                                                            ]);


                                                            var options = {
                                                                width: 480,
                                                                height: 350,
                                                                chartArea: {
                                                                    left: 80,
                                                                    top: 50,
                                                                    'width': '100%',
                                                                    'height': '60%'
                                                                },
                                                                legend: {'position': 'bottom'},
                                                                color: ['yellow', 'green', 'blue']

                                                            }
                                                            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart2"));
                                                            chart.draw(data, options);
                                                        }
                                                    </script>
                                                    <script type="text/javascript">
                                                        google.load("visualization", "1", {packages: ["corechart"]});
                                                        google.setOnLoadCallback(drawChart);

                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([

                                                                ['Category', 'Value'],
                                                                <?php
                                                                if ($roleuser == 3) {
                                                                    $query1 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1 AND C.id_divisi='59'
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else if ($roleuser == 2) {
                                                                    $query1 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  LEFT JOIN t_mapping_pic D 
                                                                  ON B.id = D.id_detail
                                                                  WHERE A.id>1 AND C.id_divisi='59' AND D.user_uid='$uiduser' and D.flag='1'
                                                                GROUP BY C.category_name
                                                                ";

                                                                } else {
                                                                    $query1 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1 AND C.id_divisi='59'and A.pic_report = '$uiduser'
                                                              GROUP BY C.category_name
                                                                ";
                                                                }

                                                                $exec1 = mysqli_query($con, $query1);
                                                                while ($row5 = mysqli_fetch_array($exec1)) {

                                                                    echo "['" . $row5['Category'] . "'," . $row5['Value'] . "],";
                                                                }
                                                                ?>

                                                            ]);


                                                            var options = {
                                                                is3D: 'true',
                                                                width: 480,
                                                                height: 350,
                                                                chartArea: {
                                                                    left: 120,
                                                                    top: 50,
                                                                    'width': '100%',
                                                                    'height': '60%'
                                                                },
                                                                colors: ['#00FF7F', '#4169E1', '#DC143C']
                                                            };
                                                            var chart = new google.visualization.PieChart(document.getElementById('chart_div2'));
                                                            chart.draw(data, options);
                                                        }
                                                    </script>
                                                    <div class="tab-content">
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="orange">
                                                                    <i class="material-icons">list</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Total Ticket</p>
                                                                    <h3 class="card-title"> <?php echo $total1; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_it_all.php">View All ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="rose">
                                                                    <i class="material-icons">add</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Open</p>
                                                                    <h3 class="card-title"><?php echo $open1; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_it_open.php">View Open ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="green">
                                                                    <i class="material-icons">clear</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Close</p>
                                                                    <h3 class="card-title"><?php echo $close1; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_it_close.php">View Close ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="blue">
                                                                    <i class="material-icons">error_outline</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">hold</p>
                                                                    <h3 class="card-title"><?php echo $hold1; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_it_hold.php">View Hold ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header card-header-icon"
                                                                     data-background-color="blue">
                                                                    <i class="material-icons">insert_chart</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <h4 class="card-title">Ticket Category
                                                                        <small>- Multiple Bars Chart</small>
                                                                    </h4>
                                                                </div>
                                                                <div id="columnchart2" class="ct-chart"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header card-header-icon"
                                                                     data-background-color="red">
                                                                    <i class="material-icons">pie_chart</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <h4 class="card-title">Ticket Category
                                                                        <small>- Pie Chart</small>
                                                                    </h4>
                                                                </div>
                                                                <div id="chart_div2" class="ct-chart"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--result3,records1,total1,open1,close1,hold1,query1,exec1,sql3,row4,row5<-->
                                            <div class="tab-pane" id="GA">
                                                <table class="table">
                                                    <tbody>
                                                    <?php
                                                    if ($roleuser == 3) {
                                                        $sql4 = "SELECT
                                                    COUNT(flag) AS 'Total',
                                                    COUNT(CASE WHEN flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM t_transaksi WHERE id > 1 AND id_divisi='57'";
                                                    } else if ($roleuser == 2) {
                                                        $sql4 = "SELECT
                                                    COUNT(A.flag) AS 'Total',
                                                    COUNT(CASE WHEN A.flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN A.flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN A.flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM ticket_staging.t_transaksi A
                                                    LEFT JOIN ticket_staging.t_category_detail B
                                                    ON A.id_detail = B.id
                                                    LEFT JOIN ticket_staging.t_mapping_pic G
                                                    ON B.id = G.id_detail
                                                    WHERE A.id>1 AND A.id_divisi='57' AND G.user_uid='$uiduser' and G.flag='1'";

                                                    } else {
                                                        $sql4 = "SELECT
                                                    COUNT(flag) AS 'Total',
                                                    COUNT(CASE WHEN flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM t_transaksi WHERE id > 1 AND id_divisi='57' and pic_report = '$uiduser'";
                                                    }


                                                    $result4 = mysqli_query($con, $sql4);
                                                    $records2 = mysqli_num_rows($result4);

                                                    while ($row6 = mysqli_fetch_array($result4)) {
                                                        $total2 = $row6['Total'];
                                                        $open2 = $row6['Open'];
                                                        $close2 = $row6['Close'];
                                                        $hold2 = $row6['Hold'];
                                                    }
                                                    ?>
                                                    <script type="text/javascript">
                                                        google.load("visualization", "1", {packages: ["corechart"]});
                                                        google.setOnLoadCallback(drawChart);

                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([

                                                                ['Category', 'Value'],
                                                                <?php
                                                                if ($roleuser == 3) {
                                                                    $query2 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1 AND C.id_divisi='57'
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else if ($roleuser == 2) {
                                                                    $query2 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  LEFT JOIN t_mapping_pic D 
                                                                  ON B.id = D.id_detail
                                                                  WHERE A.id>1 AND C.id_divisi='57' AND D.user_uid='$uiduser' and D.flag='1'
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else {
                                                                    $query2 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1 AND C.id_divisi='57'and A.pic_report = '$uiduser'
                                                              GROUP BY C.category_name
                                                                ";

                                                                }

                                                                $exec2 = mysqli_query($con, $query2);
                                                                while ($row7 = mysqli_fetch_array($exec2)) {

                                                                    echo "['" . $row7['Category'] . "'," . $row7['Value'] . "],";
                                                                }
                                                                ?>

                                                            ]);


                                                            var options = {
                                                                width: 480,
                                                                height: 350,
                                                                chartArea: {
                                                                    left: 80,
                                                                    top: 50,
                                                                    'width': '100%',
                                                                    'height': '60%'
                                                                },
                                                                legend: {'position': 'bottom'},
                                                                color: ['yellow', 'green', 'blue']

                                                            }
                                                            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart3"));
                                                            chart.draw(data, options);
                                                        }
                                                    </script>
                                                    <script type="text/javascript">
                                                        google.load("visualization", "1", {packages: ["corechart"]});
                                                        google.setOnLoadCallback(drawChart);

                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([

                                                                ['Category', 'Value'],
                                                                <?php
                                                                if ($roleuser == 3) {
                                                                    $query2 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1 AND C.id_divisi='57'
                                                                GROUP BY C.category_name
                                                                ";
                                                                } else if ($roleuser == 2) {
                                                                    $query2 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  LEFT JOIN t_mapping_pic D 
                                                                  ON B.id = D.id_detail
                                                                  WHERE A.id>1 AND C.id_divisi='57' AND D.user_uid='$uiduser' and D.flag='1'
                                                                GROUP BY C.category_name
                                                                ";

                                                                } else {
                                                                    $query2 = "SELECT 
                                                                 C.category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                 LEFT JOIN t_category C
                                                                  ON B.id_category=C.id
                                                                  WHERE A.id>1 AND C.id_divisi='57' and A.pic_report = '$uiduser'
                                                              GROUP BY C.category_name
                                                                ";
                                                                }

                                                                $exec2 = mysqli_query($con, $query2);
                                                                while ($row7 = mysqli_fetch_array($exec2)) {

                                                                    echo "['" . $row7['Category'] . "'," . $row7['Value'] . "],";
                                                                }
                                                                ?>

                                                            ]);


                                                            var options = {
                                                                is3D: 'true',
                                                                width: 480,
                                                                height: 350,
                                                                chartArea: {
                                                                    left: 120,
                                                                    top: 50,
                                                                    'width': '100%',
                                                                    'height': '60%'
                                                                },
                                                                colors: ['#00FF7F', '#4169E1', '#DC143C']
                                                            };
                                                            var chart = new google.visualization.PieChart(document.getElementById('chart_div3'));
                                                            chart.draw(data, options);
                                                        }
                                                    </script>
                                                    <div class="tab-content">
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="orange">
                                                                    <i class="material-icons">list</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Total Ticket</p>
                                                                    <h3 class="card-title"> <?php echo $total2; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_ga_all.php">View All ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php }?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="rose">
                                                                    <i class="material-icons">add</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Open</p>
                                                                    <h3 class="card-title"><?php echo $open2; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_ga_open.php">View Open ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="green">
                                                                    <i class="material-icons">clear</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Close</p>
                                                                    <h3 class="card-title"><?php echo $close2; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_ga_close.php">View Close ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="blue">
                                                                    <i class="material-icons">error_outline</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">hold</p>
                                                                    <h3 class="card-title"><?php echo $hold2; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_ga_hold.php">View Hold ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header card-header-icon"
                                                                     data-background-color="blue">
                                                                    <i class="material-icons">insert_chart</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <h4 class="card-title">Ticket Category
                                                                        <small>- Multiple Bars Chart</small>
                                                                    </h4>
                                                                </div>
                                                                <div id="columnchart3" class="ct-chart"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header card-header-icon"
                                                                     data-background-color="red">
                                                                    <i class="material-icons">pie_chart</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <h4 class="card-title">Ticket Category
                                                                        <small>- Pie Chart</small>
                                                                    </h4>
                                                                </div>
                                                                <div id="chart_div3" class="ct-chart"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--result4,records2,total2,open2,close2,hold2,query2,exec2,sql4,row6,row7<-->
                                            <div class="tab-pane" id="ITW">
                                                <table class="table">
                                                    <tbody>
                                                    <?php
                                                    if ($roleuser == 3) {
                                                        $sql5 = "SELECT
                                                    COUNT(a.flag) AS 'Total',
                                                    COUNT(CASE WHEN a.flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN a.flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN a.flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM t_transaksi a
                                                    LEFT JOIN t_category_detail b
                                                    ON a.id_detail=b.id
                                                    WHERE a.id > 1 AND a.id_divisi='59' AND b.id_category='5'";
                                                    } else if ($roleuser == 2) {
                                                        $sql5 = "SELECT
                                                    COUNT(A.flag) AS 'Total',
                                                    COUNT(CASE WHEN A.flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN A.flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN A.flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM ticket_staging.t_transaksi A
                                                    LEFT JOIN ticket_staging.t_category_detail B
                                                    ON A.id_detail = B.id
                                                    LEFT JOIN ticket_staging.t_mapping_pic G
                                                    ON B.id = G.id_detail
                                                    WHERE A.id>1 AND A.id_divisi='59' AND G.user_uid='$uiduser' AND G.flag='1' AND B.id_category='5'";

                                                    } else {
                                                        $sql5 = "SELECT
                                                    COUNT(a.flag) AS 'Total',
                                                    COUNT(CASE WHEN a.flag ='0' THEN 'Open' END)AS 'Open' ,
                                                    COUNT(CASE WHEN a.flag ='1' THEN 'Close' END)AS 'Close' ,
                                                    COUNT(CASE WHEN a.flag ='2' THEN 'Hold' END)AS 'Hold'
                                                    FROM t_transaksi a
                                                    LEFT JOIN t_category_detail b
                                                    ON a.id_detail=b.id
                                                    WHERE a.id > 1 AND a.id_divisi='59' and a.pic_report = '$uiduser' AND b.id_category='5'";
                                                    }

                                                    $result5 = mysqli_query($con, $sql5);
                                                    $records3 = mysqli_num_rows($result5);

                                                    while ($row8 = mysqli_fetch_array($result5)) {
                                                        $total3 = $row8['Total'];
                                                        $open3 = $row8['Open'];
                                                        $close3 = $row8['Close'];
                                                        $hold3 = $row8['Hold'];
                                                    }
                                                    ?>
                                                    <script type="text/javascript">
                                                        google.load("visualization", "1", {packages: ["corechart"]});
                                                        google.setOnLoadCallback(drawChart);

                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([

                                                                ['Category', 'Value'],
                                                                <?php
                                                                if ($roleuser == 3) {
                                                                    $query3 = "SELECT 
                                                                 B.detail_category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                  WHERE A.id>1 AND B.id_category='5'
                                                                GROUP BY B.detail_category_name
                                                                ";
                                                                } else if ($roleuser == 2) {
                                                                    $query3 = "SELECT 
                                                                 B.detail_category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                  LEFT JOIN t_mapping_pic D 
                                                                  ON B.id = D.id_detail
                                                                  WHERE A.id>1 AND B.id_category='5' AND D.user_uid='$uiduser' and D.flag='1'
                                                                GROUP BY B.detail_category_name
                                                                ";
                                                                } else {
                                                                    $query3 = "SELECT 
                                                                 B.detail_category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                  WHERE A.id>1 AND B.id_category='5' and A.pic_report = '$uiduser'
                                                              GROUP BY B.detail_category_name
                                                                ";

                                                                }

                                                                $exec3 = mysqli_query($con, $query3);
                                                                while ($row9 = mysqli_fetch_array($exec3)) {

                                                                    echo "['" . $row9['Category'] . "'," . $row9['Value'] . "],";
                                                                }
                                                                ?>

                                                            ]);


                                                            var options = {
                                                                width: 480,
                                                                height: 350,
                                                                chartArea: {
                                                                    left: 80,
                                                                    top: 50,
                                                                    'width': '100%',
                                                                    'height': '60%'
                                                                },
                                                                legend: {'position': 'bottom'},
                                                                colors: ['#FFC312', '#EA2027', '#009432','#006266','#12CBC4','#0652DD','#1B1464','#FDA7DF','#5758BB','#ED4C67','#833471']

                                                            };
                                                            var chart = new google.visualization.ColumnChart(document.getElementById("columnchart4"));
                                                            chart.draw(data, options);
                                                        }
                                                    </script>
                                                    <script type="text/javascript">
                                                        google.load("visualization", "1", {packages: ["corechart"]});
                                                        google.setOnLoadCallback(drawChart);

                                                        function drawChart() {
                                                            var data = google.visualization.arrayToDataTable([

                                                                ['Category', 'Value'],
                                                                <?php
                                                                if ($roleuser == 3) {
                                                                    $query3 = "SELECT 
                                                                 B.detail_category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                  WHERE A.id>1 AND B.id_category='5'
                                                                GROUP BY B.detail_category_name
                                                                ";
                                                                } else if ($roleuser == 2) {
                                                                    $query3 = "SELECT 
                                                                 B.detail_category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                  LEFT JOIN t_mapping_pic D 
                                                                  ON B.id = D.id_detail
                                                                  WHERE A.id>1 AND B.id_category='5' AND D.user_uid='$uiduser' and D.flag='1'
                                                                GROUP BY B.detail_category_name
                                                                ";

                                                                } else {
                                                                    $query3 = "SELECT 
                                                                 B.detail_category_name AS 'Category' ,
                                                                 COUNT(A.id) AS 'Value'
                                                                FROM t_transaksi A 
                                                                 LEFT JOIN t_category_detail B
                                                                  ON A.id_detail=B.id
                                                                  WHERE A.id>1 AND B.id_category='5' and A.pic_report = '$uiduser'
                                                              GROUP BY B.detail_category_name
                                                                ";
                                                                }

                                                                $exec3 = mysqli_query($con, $query3);
                                                                while ($row9 = mysqli_fetch_array($exec3)) {

                                                                    echo "['" . $row9['Category'] . "'," . $row9['Value'] . "],";
                                                                }
                                                                ?>

                                                            ]);


                                                            var options = {
                                                                is3D: 'true',
                                                                width: 480,
                                                                height: 350,
                                                                chartArea: {
                                                                    left: 120,
                                                                    top: 50,
                                                                    'width': '100%',
                                                                    'height': '60%'
                                                                },
                                                                colors: ['#FFC312', '#EA2027', '#009432','#006266','#12CBC4','#0652DD','#1B1464','#FDA7DF','#5758BB','#ED4C67','#833471']
                                                            };
                                                            var chart = new google.visualization.PieChart(document.getElementById('chart_div4'));
                                                            chart.draw(data, options);
                                                        }
                                                    </script>
                                                    <div class="tab-content">
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="orange">
                                                                    <i class="material-icons">list</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Total Ticket</p>
                                                                    <h3 class="card-title"> <?php echo $total3; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_itw_all.php">View All ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="rose">
                                                                    <i class="material-icons">add</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Open</p>
                                                                    <h3 class="card-title"><?php echo $open3; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_itw_open.php">View Open ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="green">
                                                                    <i class="material-icons">clear</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">Close</p>
                                                                    <h3 class="card-title"><?php echo $close3; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_itw_close.php">View Close ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-3 col-md-6 col-sm-6">
                                                            <div class="card card-stats">
                                                                <div class="card-header" data-background-color="blue">
                                                                    <i class="material-icons">error_outline</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <p class="category">hold</p>
                                                                    <h3 class="card-title"><?php echo $hold3; ?></h3>
                                                                </div>
                                                                <?php if ($roleuser > 1) { ?>
                                                                    <div class="card-footer">
                                                                        <div class="stats">
                                                                            <a style="font-size: 15px" href="vw_ticket_manager_itw_hold.php">View Hold ticket here...</a>
                                                                        </div>
                                                                    </div>
                                                                <?php } ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header card-header-icon"
                                                                     data-background-color="blue">
                                                                    <i class="material-icons">insert_chart</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <h4 class="card-title">Ticket Category
                                                                        <small>- Multiple Bars Chart</small>
                                                                    </h4>
                                                                </div>
                                                                <div id="columnchart4" class="ct-chart"></div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="card">
                                                                <div class="card-header card-header-icon"
                                                                     data-background-color="red">
                                                                    <i class="material-icons">pie_chart</i>
                                                                </div>
                                                                <div class="card-content">
                                                                    <h4 class="card-title">Ticket Category
                                                                        <small>- Pie Chart</small>
                                                                    </h4>
                                                                </div>
                                                                <div id="chart_div4" class="ct-chart"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <!--result5,records3,total3,open3,close3,hold3,query3,exec3,sql5,row8,row8<-->
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
<!-- Material Dashboard DEMO methods, don't include it in your project! (NOW THIS IS MY PROJECT)-->
<script src="<?php echo _CDN_HOST ?>/assets/js/demo.js"></script>
<script>
    $(document).ready(function () {
        demo.initDashboardPageCharts();
        demo.initCharts();
        demo.initVectorMap();
    });
</script>

</html>
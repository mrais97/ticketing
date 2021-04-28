<?php
$idtiket = $_GET['id'];
require("../config.php");

if (!isset($_SESSION["role"])){
    header("location: ../index.php");
}

$roleuser	= $_SESSION['role'];
$uiduser	= $_SESSION['uid'];
$sql 		= "SELECT * FROM t_transaksi WHERE id='$idtiket' ";

$result 	= mysqli_query($con, $sql);
$data 		= mysqli_fetch_array($result);
//$catdet 	= $data['id_detail'];
$creator	=	$data['pic_report'];

$sqlnamas 	= "SELECT 
					a.nama,
						CASE
					WHEN 
						b.us_role = 1 THEN 'user'
					WHEN 
						b.us_role = 2 THEN 'PIC'
					WHEN 
						b.us_role = 3 THEN 'Admin'
					END AS role
				FROM 
					ticket_staging.mr_peg_info_personal a
					JOIN ticket_staging.t_role b ON 
					a.user_uid=b.us_uid
				WHERE 
					b.us_uid='$uiduser'
				";
				
$resultnamas = mysqli_query($con, $sqlnamas);
$rownamas 	 = mysqli_fetch_array($resultnamas);
$namas		 = $rownamas[0];
$roles		 = $rownamas[1];

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
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700|Material+Icons"/>
    <script src="<?php echo _CDN_HOST ?>/assets/js/chartist.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <title>
        Ticket Management
    </title>
</head>
<body>
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
                    <a class="navbar-brand" href="#">Ticket Manager</a>
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
                                <h4 class="card-title" style="display: inline-block">Edit Ticket</h4>
                                <form class="form-horizontal" method="POST">
								<input type="hidden" name="CsrfToken" id="CsrfToken" value="<?php echo $_SESSION['csrf_token']; ?>" >
                                    <div class="form-group">
                                        <input type="hidden" id="idpic" name="idpic" value="<?php echo $uiduser; ?>">
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Ticket Status</label>
                                                <div class="col-md-9">
                                                    <select data-style="select-with-transition" id="flag"
                                                            class="col-md-3">
                                                        <option value="0"<?php if ($data['flag'] == '0') echo ' selected="selected"'; ?>>Open</option>
                                                        <option value="1"<?php if ($data['flag'] == '1') echo ' selected="selected"'; ?>>Close</option>
                                                        <option value="2"<?php if ($data['flag'] == '2') echo ' selected="selected"'; ?>>Hold</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3" style="text-align: right;">Ticket Number</label>
                                                <div class="col-md-6">
                                                    <input class="form-control" type="text" id="ticknumber"
                                                           value="<?php echo $data['no_ticket']; ?>" disabled="">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label" style="text-align: right;">Problem</label>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" rows="2" id="prob"
                                                              value="<?php echo $data['problem']; ?>"
                                                              disabled=""><?php echo $data['problem']; ?>
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="form-group row">
                                                <label class="col-md-3 col-form-label" style="text-align: right;">Keterangan</label>
                                                <div class="col-md-6">
                                                    <textarea class="form-control" rows="2" id="ket"
                                                              value="<?php echo $data['detail']; ?>">
                                                        <?php echo $data['detail']; ?>
                                                    </textarea>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="hidden" id="namapic" name="namapic" value="<?php
                                        $sql1 = "SELECT nama FROM ticket_staging.mr_peg_info_personal WHERE user_uid='$uiduser'";
                                        $result1 = mysqli_query($con, $sql1);
                                        $data1 = mysqli_fetch_array($result1);
                                        $namapic = $data1['nama'];

                                        echo $namapic; ?>">

                                        <input type="hidden" id="emailcreator" name="emailcreator" value="<?php
                                        $sql2 = "SELECT email_kantor FROM ticket_staging.mr_peg_info_personal WHERE user_uid='$creator'";
                                        $result2 = mysqli_query($con, $sql2);
                                        $data2 = mysqli_fetch_array($result2);
                                        $emailto = $data2['email_kantor'];

                                        echo $emailto; ?>">

                                        <input type="hidden" id="emailpic" name="emailpic" value="<?php
                                        $sql3 = "SELECT email_kantor FROM ticket_staging.mr_peg_info_personal WHERE user_uid='$uiduser'";
                                        $result3 = mysqli_query($con, $sql3);
                                        $data3 = mysqli_fetch_array($result3);
                                        $emailpic = $data3['email_kantor'];

                                        echo $emailpic; ?>">

                                </form>
                            </div>
                            <div class="card-footer">
                                <div class="col-md-12" align="right">
                                    <!--                                    <button class="btn btn-rose" id="button">Save Changes</button>-->
                                    <a onclick="EditTicket()" id="button" class="btn btn-rose">
                                        Save Changes</a>
                                    <script>
                                        function EditTicket() {
                                            var data = {
                                                ticknumber: $("#ticknumber").val(),
                                                namapic: $("#namapic").val(),
                                                idpic: $("#idpic").val(),
                                                creator: $("#creator").val(),
                                                emailcreator: $("#emailcreator").val(),
                                                emailpic: $("#emailpic").val(),
                                                flag: $("#flag").val(),
                                                prob: $("#prob").val(),
                                                ket: $("#ket").val(),
												CsrfToken: $("#CsrfToken").val()
                                            };
                                            console.log(data);
                                            if (ket) {
												$.post("../ajax/submitTicket2.php",
												{
													"ticknumber": data.ticknumber,
													"idpic": data.idpic,
													"creator": data.creator,
													"flag": data.flag,
													"prob": data.prob,
													"ket": data.ket,
													"CsrfToken": data.CsrfToken
												},
												"json");
												
												$.post("../ajax/sendMail2.php",
												{
													"ticknumber": data.ticknumber,
													"idpic": data.idpic,
													"namapic": data.namapic,
													"creator": data.creator,
													"emailcreator": data.emailcreator,
													"emailpic": data.emailpic,
													"flag": data.flag,
													"prob": data.prob,
													"ket": data.ket
												},
												"json");
												
												if(data.flag == 1){
													var ketStatus = "Ticket Close";
												}else if(data.flag == 2){
													var ketStatus = "Ticket Hold";
												}else{
													var ketStatus = "Ticket Open";
												}
												
												swal({
													title: 'Tiket Berhasil di-Update,\nDengan Status: '+ketStatus,
													text: "Redirecting..",
													type: "success",
													timer: 7000,
													showConfirmButton: false,
													closeOnClickOutside: false,
													allowOutsideClick: false,
													allowEscapeKey: false
												});
												swal.showLoading();
												window.setTimeout(function () {
													//location.reload();
													$(location).attr('href', 'vw_ticket_manager.php');
												}, 5);
                                            }else{
                                                swal("Silahkan Cek Inputan");
                                            }
                                        }
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
<script src="<?php echo _CDN_HOST ?>/assets/js/perfect-scrollbar.jquery.min.js" type="text/javascript"></script>
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
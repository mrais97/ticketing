<?php
require("../config.php");
if (!isset($_SESSION["role"])) {
    header("location: ../index.php");
}
$roleuser 	= $_SESSION['role'];
$uiduser 	= $_SESSION['uid'];

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
$result2 	= mysqli_query($con, $sql2);
$row2 		= mysqli_fetch_array($result2);
$hitung 	= mysqli_num_rows($result2);

if ($hitung >= 1) {
    $namas = $row2[0];
    $roles = $row2[1];
} else {
    $sql5 = "SELECT 
				full_name,
				CASE 
					WHEN id_role = 1 THEN 'user'
					WHEN id_role = 2 THEN 'PIC'
					WHEN id_role = 3 THEN 'Admin'
				END AS role
			FROM 
				ticket_staging.t_user 
			WHERE 
				user_uid='$uiduser' AND flag='1'
			";
    $result5 	= mysqli_query($con, $sql5);
    $row8 		= mysqli_fetch_array($result5);
    $namas 		= $row8[0];
    $roles 		= $row8[1];
}

if ($roleuser == 3) {
    $sql = "SELECT DISTINCT
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
				F.nama,A.nama_file,
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
			FROM 
				ticket_staging.t_transaksi A
				LEFT JOIN ticket_staging.t_category_detail B
				ON A.id_detail = B.id
				LEFT JOIN ticket_staging.t_category C
				ON B.id_category = C.id
				LEFT JOIN ticket_staging.t_mapping_pic D
				ON A.pic = D.user_uid
				LEFT JOIN ticket_staging.mr_peg_info_personal F
				ON D.user_uid = F.user_uid
				LEFT JOIN ticket_staging.t_divisi E
				ON C.id_divisi = E.kode_div
			WHERE 
				A.id>1
				ORDER BY A.created_at DESC ";
} else {
    $sql = "SELECT DISTINCT
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
				F.nama,A.nama_file,
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
			FROM 
				ticket_staging.t_transaksi A
				LEFT JOIN ticket_staging.t_category_detail B
				ON A.id_detail = B.id
				LEFT JOIN ticket_staging.t_category C
				ON B.id_category = C.id
				LEFT JOIN ticket_staging.t_mapping_pic D
				ON A.pic = D.user_uid
				LEFT JOIN ticket_staging.mr_peg_info_personal F
				ON D.user_uid = F.user_uid
				LEFT JOIN ticket_staging.t_divisi E
				ON C.id_divisi = E.kode_div
			WHERE 
				A.id>1 AND 
				A.pic_report='$uiduser'
				ORDER BY A.created_at DESC ";
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
    <meta http-equiv="refresh" content="600"/>
    <title>
        Ticketing
    </title>
</head>
<div class="modal" tabindex="-1" role="dialog" id="form_keluar">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary">Save changes</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

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
                    <a class="navbar-brand" href="#"> Form Aplikasi </a>
                </div>
            </div>
        </nav>
        <div class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header card-header-icon" data-background-color="rose">
                                <i class="material-icons">apps</i>
                            </div>
                            <div class="list-group">
                                <div class="list-group-item py-4 open" data-acc-step="">
                                    <div class="card-content">
                                        <h4 class="card-title" style="display: inline-block">FORM PERMINTAAN IT APPLICATION AND DEVELOPMENT</h4>
                                    <div class="toolbar">
                                </div>
                            </div>
                            <div class="mb-3">
                                <form action="" class="row g-3">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="exampleFormControlInput1" class="form-label">Nama</label>
                                                <input type="text" class="form-control" id="nama">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="exampleFormControlInput1" class="form-label">Jabatan</label>
                                                <input type="text" class="form-control" id="jabatan">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="exampleFormControlInput1" class="form-label">Divisi</label>
                                                <input type="text" class="form-control" id="divisi">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="exampleFormControlInput1" class="form-label">NIK</label>
                                                <input type="text" class="form-control" id="nik">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-">
                                                <label for="exampleFormControlInput1" class="form-label">Tanggal</label>
                                                <input type="text" class="form-control" id="tanggal">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="exampleFormControlInput1" class="form-label">Telp/Email</label>
                                                <input type="text" class="form-control" id="telp_email">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="exampleFormControlInput1" class="form-label">Subjek Permintaan</label>
                                                <input type="text" class="form-control" id="subjek">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-body">
                                                <label for="exampleFormControlInput1" class="form-label">Service yang diminta</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" value="" id="aplikasi_baru">
                                                    <label for="aplikasi_baru" class="form-check-label">Aplikasi Baru</label>
                                                    <input type="text" class="form-control" id="nama_aplikasi" placeholder="Nama Aplikasi...">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" value="" id="penambahan">
                                                    <label for="penambahan" class="form-check-label">Penambahan / Modifikasi Aplikasi yang sudah ada</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" value="" id="database">
                                                    <label for="database" class="form-check-label">Database Baru Untuk Tracking Informasi Detail</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" value="" id="penggantian">
                                                    <label for="penggantian" class="form-check-label">Penggantian Aplikasi yang sudah ada</label>
                                                    <input type="text" class="form-control" id="penggantian_aplikasi" placeholder="Nama Aplikasi">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" value="" id="otomasi">
                                                    <label for="otomasi" class="form-check-label">Otomasi Proses Manual yang sedan berjalan</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" value="" id="lainnya">
                                                    <label for="lainnya" class="form-check-label">Lainnya :</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="form-group">

                                
                                <div class="row row-sm">
                                    <div class="col-sm-2">
                                        <form class="form-horizontal" id="form_select">
						                    <input type="hidden" name="CsrfToken" id="CsrfToken" value="<?php echo $_SESSION['csrf_token']; ?>" >
                                            <label class="">Service</label>
                                            <select name="prio"  class="prio form-control selectpicker" id="selectbasic">
                                            <option value="" style="Display: none;">Prioritas</option>
                                                <option  value="aplkasi-baru" >
                                                Aplikasi Baru</option>
                                                <option value="pergantian-aplikasi">Pergantian Aplikasi Yang Sudah Ada</option>
                                                <option value="otomasi-proses">Otomasi Proses Manual Yang Sedang Berjalan</option>
                                            </select>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="namaAplikasi">Nama Aplikasi</label>
                                <input type="nama-aplikasi" class="form-control" id="namaAplikasi" placeholder="">
                            </div>
	                        <div class="form-group">
		                        <label for="deskripsi">Deskripsi</label>
		                        <textarea class="form-control" id="alamat" rows="3" placeholder=""></textarea>
	                        </div>
                            <div class="row">
                                    <div class="form-group row">
                                        <label class="col-md-3 col-form-label">Attachment (.jpeg,.jpg,.PNG,.pdf)</label>
                                        <div class="col-md-9">
                                        </div>
                                    </div>
                            </div>
                            <div class="modal-footer">
                                <input name="file" type="file" class="inputFile" accept="application/pdf,image/*"/>
                                <a onclick="InsertSendTicket()" class="btn btn-rose">Submit</a>
                                <button class="btn" data-dismiss="modal" aria-hidden="true">Close</button>
                            </div>
                        </div>
                    </div>
                </div>
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
        function InsertSendTicket() {
            var data = {
                idComboDivisi: $("#idComboDivisi").val(),
                idComboCategory: $("#idComboCategory").val(),
                idComboCategoryD: $("#idComboCategoryD").val(),
                prio: $("#prio").val(),
                creator: $("#creator").val(),
                prob: $("#prob").val(),
				CsrfToken: $("#CsrfToken").val()
            };
        }
			
</script>
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
<script src="<?php echo _CDN_HOST ?>/assets/js/jasny-bootstrap.min.js"></script>
<!--  Full Calendar Plugin    -->
<script src="<?php echo _CDN_HOST ?>/assets/js/fullcalendar.min.js"></script>
<!-- TagsInput Plugin -->
<script src="<?php echo _CDN_HOST ?>/assets/js/jquery.tagsinput.js"></script>
<!-- Material Dashboard javascript methods -->
<script src="<?php echo _CDN_HOST ?>/assets/js/material-dashboard.js"></script>
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
    // $("#form_keluar").modal("show");

// $( "#Pilihan_aplikasi_baru" ).click(function() {
        
// });
// $('#selectbasic option').on('click', function(){
//     // alert($(this).text());
//     keluar_modal()
// });

$("#selectbasic").change(function(){
    keluar_modal()
});
function keluar_modal(){
    $("#form_keluar").modal("show");

}
// document.querySelector('#Pilihan_aplikasi_baru').addEventListener('click', event => {
//  $("#form_keluar").modal("show");
// });
</script>


</html>
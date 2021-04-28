<?php
//$con 		= mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
require("../config.php");

if (!isset($_SESSION["role"])) {
    header("location: ../index.php");
}

$ticknumber	= mysqli_real_escape_string($con, $_POST['ticknumber']);
$idpic		= mysqli_real_escape_string($con, $_POST['idpic']);
$flag		= mysqli_real_escape_string($con, $_POST['flag']);
$prob		= mysqli_real_escape_string($con, $_POST['prob']);
$ket		= mysqli_real_escape_string($con, $_POST['ket']);

$uiduser 	= $_SESSION['uid'];
$csrf_token = $_SESSION['csrf_token'];
$CsrfToken 	= $_POST['CsrfToken'];

//$ket = preg_replace('/[^A-Za-z0-9\w\ ]/i', '', $ket);
//$ket = preg_replace('/[^-a-zA-Z0-9,._()@?!%#=+ ]/i', '', $ket);
//$ket = mysqli_real_escape_string($conn, strip_tags($ket));

$ket = trim($ket);
if($CsrfToken == $csrf_token && $uiduser != ""){
	if ($flag == 1) {
		$sql = "UPDATE t_transaksi
					SET no_ticket= '$ticknumber',
						flag = '$flag',
						detail='$ket',
						updated_at = CAST(NOW() AS DATETIME), 
						pic='$idpic',
						finish_date = CAST(NOW() AS DATETIME)
				WHERE 
					no_ticket= '$ticknumber'";
	}else{
		$sql = "UPDATE t_transaksi
					SET no_ticket= '$ticknumber',
					flag = '$flag',detail='$ket',
					updated_at = CAST(NOW() AS DATETIME),
					hold_date = CAST(NOW() AS DATETIME), 
					pic='$idpic'
				WHERE 
					no_ticket= '$ticknumber' ";
	}
	if ($con->query($sql) === TRUE) {
		echo $sql;
	}else{
		echo "Failed..!";
	}
}else{
	echo "Failed";
} 
?>
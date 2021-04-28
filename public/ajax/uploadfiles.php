<?php
require("../config.php");

if (!isset($_SESSION["role"])) {
    header("location: ../index.php");
}
$roleuser 	= $_SESSION['role'];
$uiduser 	= $_SESSION['uid'];
//$uid 		= $_SESSION['uid'];
$username 	= $_SESSION['username'];

$postPrio 		= mysqli_real_escape_string($con, $_POST['prio']);
$postDiv 		= mysqli_real_escape_string($con, $_POST['idComboDivisi']);
$postDetail 	= mysqli_real_escape_string($con, $_POST['idComboCategoryD']);
$namafile 		= $_FILES['file']['tmp_name'];
$postUid 		= mysqli_real_escape_string($con, $_POST['creator']);
$postMasalah1 	= mysqli_real_escape_string($con, $_POST['problem']);
//$postMasalah  = preg_replace('/[^A-Za-z0-9\w\ ]/i', '', $postMasalah1);
$postMasalah2 	= preg_replace('/[^-a-zA-Z0-9,._()@?!%#=+ ]/i', '', $postMasalah1);
$postMasalah 	= trim($postMasalah2);

$csrf_token 	= $_SESSION['csrf_token'];
$CsrfToken 		= $_POST['CsrfToken'];

if ($postDiv == '59') {
    $namadiv = 'IT';
} else {
    $namadiv = 'GA';
}


if($CsrfToken == $csrf_token && $uiduser != ""){
	if (file_exists($namafile)) {
		$size 		= $_FILES['file']['size'];
		$format 	= $_FILES['file']['type'];
		$namafile 	= $_FILES['file']['name'];
		$allowed 	= array('jpeg','JPEG', 'png','PNG', 'jpg','JPG', 'pdf','PDF');
		$ext 		= pathinfo($namafile, PATHINFO_EXTENSION);
		$finfo 		= finfo_open(FILEINFO_MIME_TYPE);
		$mime 		= finfo_file($finfo, $_FILES['file']['tmp_name']);
		$acceptable = array(
			'image/jpeg',
			'image/JPEG',
			'image/jpg',
			'image/JPG',
			'image/png',
			'image/PNG',
			'application/pdf',
			'application/PDF'
		);
		if (!in_array($ext, $allowed)) {
			echo "format salah";
			$res = "format";

		} else {
			if ($size >= 1500000) {
				echo "file besar";
				$res = "big";
			} else {
				if (is_uploaded_file($_FILES['file']['tmp_name'])) {
					$sourcePath = $_FILES['file']['tmp_name'];
					$targetPath = _UPLOAD_FOLDER . "/" . $_FILES['file']['name'];
					if (move_uploaded_file($sourcePath, $targetPath)) {
						$sql = "INSERT INTO t_transaksi(
									pic_report, id_detail,
									problem, start_date,
									finish_date, flag,
									priority, detail,
									created_at, updated_at,
									no_ticket, id_divisi,
									nama_file
								)
								SELECT
									'$postUid', '$postDetail',
									'$postMasalah', NOW(),
									'-', '0',
									'$postPrio', '',
									now(), now(),
									CONCAT(LPAD(MAX(A.id), 6, '0'), '/$namadiv-' , (SELECT id_category FROM t_category_detail WHERE id='$postDetail') , '/' , DATE_FORMAT(NOW(),'%m') , '/' , DATE_FORMAT(NOW(),'%Y')),
									'$postDiv','$namafile'
								FROM t_transaksi A";
						echo $sql;
						if ($con->query($sql) === TRUE) {
							echo "lanjut";
						} else {
							echo "failed";
						}
					} else {
						echo "gagal";
					}
				}
			}
		}
	} else {
		$sql = "INSERT INTO t_transaksi(
					pic_report, id_detail,
					problem, start_date,
					finish_date, flag,
					priority, detail,
					created_at, updated_at,
					no_ticket, id_divisi,
					nama_file
					)
				SELECT
					'$postUid', '$postDetail',
					'$postMasalah', NOW(),
					'-', '0',
					'$postPrio', '-',
					now(), now(),
					CONCAT(LPAD(MAX(A.id), 6, '0'), '/$namadiv-' , (SELECT id_category FROM t_category_detail WHERE id='$postDetail') , '/' , DATE_FORMAT(NOW(),'%m') , '/' , DATE_FORMAT(NOW(),'%Y')),
					'$postDiv',''
				FROM t_transaksi A";
		//echo $sql;
		if ($con->query($sql) === TRUE) {
			echo "<meta http-equiv='refresh' content='0'>";
		} else {
			echo "failed";
		}
	}
}else{
	die("Failed..!");
	exit();
}
?>
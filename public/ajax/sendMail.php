<?php
//error_reporting(E_ALL);
//ini_set("display_errors", 1);

//if(isset($_POST)){
    $masalah 			= $_POST['masalah'];
    $creator 			= $_POST['creator'];
    $postPrio 			= $_POST['prio'];
    $category_detail 	= $_POST['category_detail'];

    require("../config.php");

    if ($postPrio == 1) {
        $prio = "LOW";
        $time = "(3 x 24 Jam)";
    } elseif ($postPrio == 2) {
        $prio = "MEDIUM";
        $time = "(2 x 24 Jam)";
    } else {
        $prio = "HIGH";
        $time = "(1 x 24 Jam)";
    }

    $sql1 = "
			SELECT 
				d.nama,c.jabatan,
			CASE 
				WHEN a.id_cabangwil <= 2 THEN b.ksldiv 
			ELSE CONCAT(b.ksldiv,' ',e.cabangwil) END AS ksldiv,
				d.email_kantor
			FROM 
				ticket_staging.mr_peg_penugasan a
			LEFT JOIN ticket_staging.mr_ksldiv b ON 
				a.id_ksldiv = b.id_ksldiv
			LEFT JOIN ticket_staging.mr_jabatan c ON 
				a.id_jabatan = c.id_jabatan
			LEFT JOIN ticket_staging.mr_peg_info_personal d ON 
				a.user_uid = d.user_uid
			LEFT JOIN ticket_staging.mr_cabangwil e ON 
				a.id_cabangwil = e.id_cabangwil
			WHERE 
				a.user_uid   = '$creator' AND 
				a.flag_input = '1'
			";
			
    $result1 = mysqli_query($con, $sql1);
    $data1 = mysqli_fetch_array($result1);
    $hitung = mysqli_num_rows($result1);

    if ($hitung >= 1) {
        $nama = $data1['nama'];
        $jabatan = $data1['jabatan'];
        $ksldiv = $data1['ksldiv'];
        $emailcreator = $data1['email_kantor'];
    } else {
        $sql5 = "
				SELECT 
					full_name,
					jabatan,
					bagian,
					email
				FROM 
					ticket_staging.t_user 
				WHERE 
					user_uid = '$creator' AND 
					flag = '1'
				";
				
        $result5 = mysqli_query($con, $sql5);
        $row8 = mysqli_fetch_array($result5);
        $nama = $row8['full_name'];
        $jabatan = $row8['jabatan'];
        $ksldiv = $row8['bagian'];
        $emailcreator = $row8['email'];
    }

    $sql = mysqli_query($con, "
						SELECT
							DISTINCT
							c.email_kantor
						FROM 
							ticket_staging.t_category_detail a
						JOIN ticket_staging.t_mapping_pic b ON 
							a.id=b.id_detail
						JOIN ticket_staging.mr_peg_info_personal c ON 
							b.user_uid=c.user_uid
						WHERE 
							a.id   = '$category_detail' AND 
							b.flag = '1'
						");
		$sql2 = "
				SELECT 
					DISTINCT
					d.category_name,
					a.detail_category_name,
					e.Email_div
				FROM 
						ticket_staging.t_category_detail a
					JOIN ticket_staging.t_mapping_pic b ON 
						a.id=b.id_detail
					JOIN ticket_staging.t_category d ON 
						a.id_category=d.id
					JOIN ticket_staging.t_divisi e ON 
						d.id_divisi=e.kode_div
				WHERE 
					a.id   = '$category_detail' AND 
					b.flag = '1'
				";

		$result2 = mysqli_query($con, $sql2);
		$row2 	 = mysqli_fetch_array($result2);

		//require '../module/PHPMailer.php';
		//require '../module/PHPMailer/PHPMailerAutoload.php';
	

		// With Composer
		use PHPMailer\PHPMailer\PHPMailer;
		use PHPMailer\PHPMailer\Exception;

		require '../module/vendor/autoload.php';

		// Without Composer
		//use PHPMailer\PHPMailer\PHPMailer;
		//use PHPMailer\PHPMailer\Exception;

		//require '../module/vendor/phpmailer/phpmailer/src/Exception.php';
		//require '../module/vendor/phpmailer/phpmailer/src/PHPMailer.php';
		//require '../module/vendor/phpmailer/phpmailer/src/SMTP.php';

		$mail = new PHPMailer;
		$mail->isSMTP(); 
		//$mail->SMTPDebug 		= 2;
		$mail->SMTPSecure 		= 'ssl';  																			// set mailer to use SMTP
		$mail->Port 			= 465;
		$mail->Host 			= "mail.kiselindonesia.com";  														// specify main and backup server
		$mail->SMTPAuth 		= true;     																		// turn on SMTP authentication
		$mail->SMTPKeepAlive 	= true;    																			// SMTP connection will not close after each email sent, reduces SMTP overhead
		
		//Enabling Allow less secure apps:
		$mail->SMTPOptions = array(
			'ssl' => array(
				'verify_peer' => false,
				'verify_peer_name' => false,
				'allow_self_signed' => true
			)
		);
		
		$mail->Username 		= "no-reply@kiselindonesia.com";  													// SMTP username
		$mail->Password 		= "@Kisel123456"; 																	// SMTP password
		$mail->From 			= "no-reply@kiselindonesia.com";
		$mail->FromName 		= "Ticket Alert ($prio)";
		$message = file_get_contents('../mail_template.html');
		$message = str_replace('%detail_category_name%', $row2['detail_category_name'], $message);
		$message = str_replace('%category_name%', $row2['category_name'], $message);
		$message = str_replace('%nama%', $nama, $message);
		$message = str_replace('%prio%', $prio, $message);
		$message = str_replace('%time%', $time, $message);
		$message = str_replace('%jabatan%', $jabatan, $message);
		$message = str_replace('%ksldiv%', $ksldiv, $message);
		$message = str_replace('%masalah%', $masalah, $message);
		while ($row = $sql->fetch_assoc()) {
			$mail->addAddress($row['email_kantor']);
		}
		//$mail->addAddress('dedin_fathudin@kiselindonesia.com');
		
		$mail->addCc($row2['Email_div']);																			//$emailcreator // OPEN THIS WHEN DONE
		//$mail->addCc('dedin_fathudin@kiselindonesia.com');																			//$emailcreator // OPEN THIS WHEN DONE
		$mail->addCc($emailcreator);																				
		//$mail->addCc('dedin_fathudin@kiselindonesia.com');																				
		$mail->IsHTML(true);                               															// set email format to HTML
		$mail->Subject = "Problem " . $row2['detail_category_name'];
		$mail->MsgHTML($message);
		
		//echo "df: ".$row2['Email_div'];
		//$mail->Send();
		
		 if (!$mail->Send()) {
			$MsgMail = "Mailer Error: " . $mail->ErrorInfo;
		}else{
			$MsgMail = "Message has been sent successfully..";
			$mail->clearAddresses();
			$mail->clearAttachments();
		}
		echo $MsgMail;
//};
exit();
?>

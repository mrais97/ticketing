<?php
//echo "berhasil";
//$tanggal_sekarang = date("Ymd H:i:s");
//$tanggal_h1 = date('Ymd', strtotime ( '-1 day' . $tanggal_sekarang));
//$tanggal_h7 = date('Ymd', strtotime ( '-7 day' . $tanggal_sekarang));

//if(isset($_FILES['image'])){
//    $errors= array();
//    $file_name = $_FILES['image']['name'];
//    $file_size = $_FILES['image']['size'];
//    $file_tmp = $_FILES['image']['tmp_name'];
//    $file_type = $_FILES['image']['type'];
//    $file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
//
//    $expensions= array("jpeg","jpg","png","pdf");
//
//    if(in_array($file_ext,$expensions)=== false){
//        $errors[]="extension not allowed, please choose a PDF, JPEG or PNG file.";
//    }
//
//    if($file_size > 2097152) {
//        $errors[]='File size must be excately 2 MB';
//    }
//
//    if(empty($errors)==true) {
//        move_uploaded_file($file_tmp,"uploads/".$file_name); 					//The folder where you would like your file to be saved
//        echo "Success";
//    }else{
//        print_r($errors);
//    }
//}

//if($_POST){
    $ticknumber		= $_POST['ticknumber'];
    $namapic		= $_POST['namapic'];
    $idpic			= $_POST['idpic'];
    $emailcreator	= $_POST['emailcreator'];
    $emailpic		= $_POST['emailpic'];
    $flag			= $_POST['flag']; 											//cari nama status
    $prob           = $_POST['prob'];
    $ket            = $_POST['ket'];
	
    require("../config.php");
    if ($emailcreator != '') {
        $sql = mysqli_query($con, "
									SELECT
									CASE
										WHEN '$flag' =0 THEN 'open'
										WHEN '$flag' =1 THEN 'close'
										WHEN '$flag' =2 THEN 'hold'
										END AS 'status',
										b.nama AS namacreator,
										b.email_kantor AS email,
										c.detail_category_name AS catdetname,
										d.category_name AS catname,
										e.Email_div
									FROM 
										ticket_staging.t_transaksi a
									LEFT JOIN ticket_staging.mr_peg_info_personal b
										ON a.pic_report=b.user_uid
									LEFT JOIN ticket_staging.t_category_detail c
										ON a.id_detail=c.id
									LEFT JOIN ticket_staging.t_category d
										ON c.id_category=d.id
									LEFT JOIN ticket_staging.t_divisi e
										ON d.id_divisi=e.kode_div
									WHERE 
										a.no_ticket='$ticknumber'
									");
    }else{
        $sql = mysqli_query($con, "
									SELECT
									CASE
										WHEN '$flag' =0 THEN 'open'
										WHEN '$flag' =1 THEN 'close'
										WHEN '$flag' =2 THEN 'hold'
										END AS 'status',
										b.full_name AS namacreator,
										b.email,
										c.detail_category_name AS catdetname,
										d.category_name AS catname,
										e.Email_div
									FROM 
										ticket_staging.t_transaksi a
									LEFT JOIN ticket_staging.t_user b
										ON a.pic_report=b.user_uid
									LEFT JOIN ticket_staging.t_category_detail c
										ON a.id_detail=c.id
									LEFT JOIN ticket_staging.t_category d
										ON c.id_category=d.id
									LEFT JOIN ticket_staging.t_divisi e
										ON d.id_divisi=e.kode_div
									WHERE 
										a.no_ticket='$ticknumber'
									");
    }
    $data 					= mysqli_fetch_array($sql);
    $status 				= $data['status'];
    $email 					= $data['email'];
    $emaildiv 				= $data['Email_div'];
    $namacreator 			= $data['namacreator'];
    $detail_category_name 	= $data['catdetname'];
    $category_name			= $data['catname'];

    //require '../module/PHPMailer.php';
	
	// With Composer
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\Exception;

	require '../module/vendor/autoload.php';
	
	$mail 					= new PHPMailer;
	$mail->isSMTP(); 
    $mail->SMTPSecure 		= 'ssl';  										// set mailer to use SMTP
    $mail->Port 			= 465;
    $mail->Host 			= "mail.kiselindonesia.com";  					// specify main and backup server
    $mail->SMTPAuth 		= true;     									// turn on SMTP authentication
    $mail->SMTPKeepAlive 	= true; 										// SMTP connection will not close after each email sent, reduces SMTP overhead
	
	//Enabling Allow less secure apps:
	$mail->SMTPOptions = array(
		'ssl' => array(
			'verify_peer' => false,
			'verify_peer_name' => false,
			'allow_self_signed' => true
		)
	);
	
    $mail->Username = "no-reply@kiselindonesia.com";  						// SMTP username
    $mail->Password = "@Kisel123456"; 										// SMTP password
    $mail->From 	= "no-reply@kiselindonesia.com";
    $mail->FromName = "Update Ticket";

    $message = file_get_contents('../mail_template2.html');
    $message = str_replace('%namacreator%', $namacreator, $message);
    $message = str_replace('%detail_category_name%', $detail_category_name, $message);
    $message = str_replace('%category_name%', $category_name, $message);
    $message = str_replace('%ticknumber%', $ticknumber, $message);
    $message = str_replace('%prob%', $prob, $message);
    $message = str_replace('%status%', $status, $message);
    $message = str_replace('%namapic%', $namapic, $message);
    $message = str_replace('%ket%', $ket, $message);

//-------testing mail
// $mail->addAddress("dimas_erlangga@kiselindonesia.c/om");
//-------fix mail. mr.peg.kontak

//loop
    $mail->addAddress($email);
	
//$mail->addAddress("Azhar_ismunanto@kiselindonesia.com");

    $mail->addCc($emaildiv);//it-support@kiselindonesia.com
    $mail->addCc($emailpic);
	
//$mail->AddReplyTo("no-reply@kiselindonesia.com", "no-reply");
//$mail->AddAttachment("/home/it-dev/reporting/report_traveloka_".$tanggal_h7."-".$tanggal_h1.".xls.gz", "Report Traveloka (".$tanggal_h7."-".$tanggal_h1.").xls.gz");
    $mail->IsHTML(true);                               			// set email format to HTML
	
    $mail->Subject = "Nomor " . $ticknumber;
    $mail->MsgHTML($message);
	
//    $mail->MsgHTML("Dear Pak/Bu $namacreator <br/><br/>" .
//        "Telah diubah status tiket nomor $ticknumber , dengan problem : <br/><br/>" . $prob .
//        "<br/><br/>Status diubah menjadi : $status ," .
//        "<br/>oleh $namapic, dengan keterangan : <br/><br/>" . $ket .
//        "<br/><br/>Best regards , IT."
//    );
    //$mail->Send();
	
	if (!$mail->Send()) {
		$MsgMail = "Mailer Error: " . $mail->ErrorInfo;
	}else{
		$MsgMail = "Message has been sent successfully..";
		$mail->clearAddresses();
		$mail->clearAttachments();
	}
//};
exit();
?>

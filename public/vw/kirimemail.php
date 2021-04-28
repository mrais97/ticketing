<?php
// echo "berhasil";
$tanggal_sekarang = date("Ymd H:i:s");
$tanggal_h1 = date('Ymd', strtotime ( '-1 day' . $tanggal_sekarang));
$tanggal_h7 = date('Ymd', strtotime ( '-7 day' . $tanggal_sekarang));
if($_POST){
//    $name = $_POST['name'];
//    $email = $_POST['email'];
    $message = $_POST['message'];
    $catdet = $_POST['catdet'];

    require("../config.php");
    $sql = "SELECT * FROM trans WHERE id_detail='$catdet' AND problem LIKE '%$message%'";
    $result = mysqli_query($con, $sql);
    $data = mysqli_fetch_array($result);
    $catdet = $data['id_detail'];
}
require 'PHPMailer.php';
$mail = new PHPMailer();
$mail->IsSMTP();
$mail->SMTPSecure = 'ssl';  // set mailer to use SMTP
$mail->Port = 465;
$mail->Host = "mail.kiselindonesia.com";  // specify main and backup server
$mail->SMTPAuth = true;     // turn on SMTP authentication
$mail->SMTPKeepAlive = true; 	// SMTP connection will not close after each email sent, reduces SMTP overhead
$mail->Username = "no-reply@kiselindonesia.com";  // SMTP username
$mail->Password = "@Kisel123456"; // SMTP password
$mail->From = "no-reply@kiselindonesia.com";
//$mail->FromName = "Problem ".$catdet;
//-------testing mail
// $mail->addAddress("dimas_erlangga@kiselindonesia.com");
//-------fix mail
$mail->addAddress("alif_pratama@kiselindonesia.com");
//$mail->addAddress("Azhar_ismunanto@kiselindonesia.com");
//$mail->addCc("azwar_nurrosat@kiselindonesia.com");
//$mail->addCc("dimas_erlangga@kiselindonesia.com");
//$mail->AddReplyTo("no-reply@kiselindonesia.com", "no-reply");
//$mail->AddAttachment("/home/it-dev/reporting/report_traveloka_".$tanggal_h7."-".$tanggal_h1.".xls.gz", "Report Traveloka (".$tanggal_h7."-".$tanggal_h1.").xls.gz");
$mail->IsHTML(true);                               // set email format to HTML
$mail->Subject = "Problem ".$catdet;
$mail->MsgHTML("Dear Rekan-rekan IT Support,<br/><br/>"."Berikut saya sampaikan problem yang saya alami dengan rincian berikut : <br/>".$message."<br/><br/>Mohon bantuannya, Best regards."); //$email
$mail->Send();

exit
?>

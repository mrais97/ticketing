<?php
//if($_POST){
//    $masalah = $_POST['masalah'];
//    $creator = $_POST['creator'];
//    $category_detail = $_POST['category_detail'];
//    require("../config.php");
//
//$sql1 = "
//SELECT  a.nama,c.jabatan,b.ksldiv,d.email_kantor
//FROM hris_dev.mr_peg_jabatan a
//LEFT JOIN hris_dev.mr_ksldiv b
//ON a.divisi=b.id_ksldiv
//LEFT JOIN hris_dev.mr_jabatan c
//ON a.jabatan=c.id_jabatan
//LEFT JOIN hris_dev.mr_peg_info_kontak d
//ON a.user_uid=d.user_uid
//WHERE a.user_uid='$creator'";
//    $result1 = mysqli_query($con, $sql1);
//    $data1 = mysqli_fetch_array($result1);
//    $nama = $data1['nama'];
//    $jabatan = $data1['jabatan'];
//    $ksldiv = $data1['ksldiv'];
//    $emailcreator = $data1['email_kantor'];
//
//$sql = mysqli_query($con,"
//SELECT
//a.detail_category_name , c.email_kantor
//FROM ticket_staging.t_category_detail a
//JOIN ticket_staging.t_mapping_pic b
//ON a.id=b.id_detail
//JOIN hris_dev.mr_peg_info_kontak c
//ON b.user_uid=c.user_uid
//WHERE a.id='$category_detail' and b.flag='1'");
//
//
//    $mail = new PHPMailer();
//    $mail->IsSMTP();
//    $mail->SMTPSecure = 'ssl';  // set mailer to use SMTP
//    $mail->Port = 465;
//    $mail->Host = "mail.kiselindonesia.com";  // specify main and backup server
//    $mail->SMTPAuth = true;     // turn on SMTP authentication
//    $mail->SMTPKeepAlive = true; 	// SMTP connection will not close after each email sent, reduces SMTP overhead
//    $mail->Username = "no-reply@kiselindonesia.com";  // SMTP username
//    $mail->Password = "@Kisel123456"; // SMTP password
//    $mail->From = "no-reply@kiselindonesia.com";
//    $mail->FromName = "Ticket Alert";
//    while ($row = $sql->fetch_assoc()){
//        require '../module/PHPMailer.php';
//        $message = file_get_contents('../mail_template.html');
//        $message = str_replace('%detail_category_name%', $row['detail_category_name'], $message);
//        $message = str_replace('%nama%', $nama, $message);
//        $message = str_replace('%jabatan%', $jabatan, $message);
//        $message = str_replace('%ksldiv%', $ksldiv, $message);
//        $message = str_replace('%masalah%', $masalah, $message);
//
//    $mail->addAddress($row['email_kantor']);
//    $mail->addCc("alif_pratama@kiselindonesia.com");//it-support@kiselindonesia.com
//    $mail->addCc("nur_fitriyah@kiselindonesia.com");//$emailcreator
////$mail->AddReplyTo("no-reply@kiselindonesia.com", "no-reply");
////$mail->AddAttachment("/home/it-dev/reporting/report_traveloka_".$tanggal_h7."-".$tanggal_h1.".xls.gz", "Report Traveloka (".$tanggal_h7."-".$tanggal_h1.").xls.gz");
//    $mail->IsHTML(true);                               // set email format to HTML
//    $mail->Subject = "Problem " . $row['detail_category_name'];
//    $mail->MsgHTML($message);
//    $mail->Send();
//    }};
//?>
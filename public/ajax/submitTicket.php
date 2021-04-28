<?php
require("../config.php");
if(is_array($_FILES)) {
    print_r($_FILES);
}
$postPrio=$_POST['prio'];
$postDiv=$_POST['divisi'];
$postDetail=$_POST['category_detail'];
$postMasalah=$_POST['masalah'];
$postMasalah = preg_replace('/[^-a-zA-Z0-9,._()@?!%#=+ ]/i', '', $postMasalah);
$postMasalah = trim($postMasalah);
//$postMasalah = mysqli_real_escape_string($conn, strip_tags($postMasalah));
$postUid=$_POST['creator'];
echo $postPrio;
//
//$sql=
//    "
//INSERT INTO t_transaksi
//(
//pic_report,
//id_detail,
//problem,
//start_date,
//finish_date,
//flag,
//priority,
//detail,
//created_at,
//updated_at,
//no_ticket,
//id_divisi
//)
//SELECT
//'$postUid',
//'$postDetail',
//'$postMasalah',
//NOW(),
//'-',
//'0',
//'$postPrio',
//'-',
//now(),
//now(),
//CONCAT(LPAD(MAX(A.id), 6, '0'), '/IT-' , (SELECT id_category FROM t_category_detail WHERE id='$postDetail') , '/' , DATE_FORMAT(NOW(),'%m') , '/' , DATE_FORMAT(NOW(),'%Y')),
//'$postDiv'
//FROM t_transaksi A
//";
//echo $sql;
//
//if ($con->query($sql) === TRUE) {
//
//    echo "<meta http-equiv='refresh' content='0'>";
//}
//else
//{
//    echo "failed";
//}


?>
<?php
require ("../config.php");
$kode_div=$_POST['kode_div'];
//echo $kode_div;
$rs = mysqli_query($con, "
SELECT a.user_uid,c.nama 
FROM ticket_staging.mr_peg_penugasan a
JOIN t_role b ON a.user_uid=b.us_uid
JOIN mr_peg_info_personal c ON a.user_uid=c.user_uid
WHERE a.flag_input='1' AND a.status_pms='1' AND a.id_KSLDIV ='$kode_div'
");
while ($row = $rs->fetch_assoc()){
    $id = $row['user_uid'];
    $nm = strtolower($row['nama']);
    $res[] = ["id" => $id, "nama" => $nm];
}
header('Content-type: application/json');
echo json_encode($res);



?>
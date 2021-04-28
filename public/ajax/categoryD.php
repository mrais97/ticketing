<?php

require ("../config.php");

$uiduser = $_SESSION['uid'];

$id=$_POST['id_category'];

if ($id=='5'){
    $rs = mysqli_query($con, "SELECT DISTINCT a.id,a.detail_category_name
FROM t_category_detail a
LEFT JOIN mr_peg_penugasan b
ON a.id_cabangwil=b.ID_CABANGWIL
WHERE a.id_category='$id' AND b.user_uid='$uiduser'");


}else{
    $rs = mysqli_query($con, "SELECT id,detail_category_name FROM t_category_detail WHERE flag='1' and id_category = $id");
}

while ($row = $rs->fetch_assoc()){
    $id = $row['id'];
    $nm = strtolower($row['detail_category_name']);
    $res[] = ["id" => $id, "detail_name" => $nm];
}

header('Content-type: application/json');
echo json_encode($res);
?>
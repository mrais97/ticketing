<?php
require ("../config.php");
//$id_div=$_POST['id_divisi'];
$kode_div=$_POST['kode_div'];
$rs = mysqli_query($con, "SELECT id,category_name FROM t_category WHERE flag='1' and id_divisi='$kode_div'");
//$rs = mysqli_query($con, "SELECT id,category_name FROM t_category WHERE flag='1'");
while ($row = $rs->fetch_assoc()){
    $id = $row['id'];
    $nm = strtolower($row['category_name']);
    $res[] = ["id" => $id, "nama" => $nm];
}
header('Content-type: application/json');
echo json_encode($res);
?>
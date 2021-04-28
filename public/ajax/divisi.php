<?php
require ("../config.php");
$rs = mysqli_query($con, "SELECT ID ,Nama_div,kode_div FROM t_divisi WHERE Flag='1'");
while ($row = $rs->fetch_assoc()){
    $id_div = $row['ID'];
    $kode_div = $row['kode_div'];
    $nm = $row['Nama_div'];
    $res[] = ["ID" => $id_div, "Nama_div" => $nm, "kode_div" => $kode_div];
}
header('Content-type: application/json');
echo json_encode($res);



?>
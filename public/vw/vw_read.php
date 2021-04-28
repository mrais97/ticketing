<?php
require("../config.php");
$namekey    = $_POST['nama'];
$path = _UPLOAD_FOLDER."/".$namekey;
$type = pathinfo($path, PATHINFO_EXTENSION);
$type_case = strtolower($type);
$data = file_get_contents($path);
if($type_case == 'pdf'){
    $base64 = 'data:application/' . $type . ';base64,' . base64_encode($data);
    echo '<embed src="'.$base64.'" style="width: 100%; height: 500px;"></embed>';
}else{
    $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
    echo '<img src="'.$base64.'" style="width: 100%;" >';
}
?>


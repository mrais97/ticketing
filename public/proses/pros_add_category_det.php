<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$catdetname = trim($_POST['catdetname']);

if (empty($catdetname)) {
    $msg = 'You must enter an address' ;
} else {
    $catdetname = mysqli_real_escape_string($conn, strip_tags($catdetname));

    $cat = $_POST['cat'];
    $flag = $_POST['flag'];
    $sql = "INSERT INTO t_category_detail
(id,detail_category_name,id_category,flag,created_at,updated_at)
SELECT MAX(id)+1, '$catdetname', '$cat','$flag',CAST(NOW() AS DATETIME),CAST(NOW() AS DATETIME) 
FROM t_category_detail";
    if ($conn->query($sql) === TRUE) {
        echo "data inserted";
    } else {
        echo "failed";
    }
}
?>
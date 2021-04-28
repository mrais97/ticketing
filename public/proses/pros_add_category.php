<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$catname = $_POST['catname'];
$div = $_POST['div'];
$catname = preg_replace('/[^A-Za-z0-9\w\ ]/i', '', $catname);
$flag = $_POST['flag'];
if (!isset($catname) || trim($catname) == '') {
    echo '<script language="javascript">';
    echo 'alert("message successfully sent")';
    echo '</script>';
} else {
    $sql = "INSERT INTO t_category (id, id_divisi,category_name, flag, created_at, update_at) SELECT MAX(id)+1, $div,'$catname', '$flag',CAST(NOW() AS DATETIME),CAST(NOW() AS DATETIME) FROM t_category";
    if ($conn->query($sql) === TRUE) {
        echo "data inserted";
    } else {
        echo "failed";
    }
};
?>
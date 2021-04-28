<?php
$conn = mysqli_connect('10.76.128.207', 'ticket-devops', 'd3v0p5@Bismillah!@#', 'ticket_staging');
$catdet=$_POST['catdet'];
$prio=$_POST['prio'];
$prob=$_POST['prob'];
$sql="INSERT INTO trans
(id_trans,id_detail,problem,start_date,finish_date,flag_trans,priority,detail,created_at,updated_at,no_ticket)
SELECT
MAX(A.id_trans)+1,
'$catdet',
'$prob',
'-',
'-',
'0',
'$prio',
'-',
CAST(NOW() AS DATETIME),
CAST(NOW() AS DATETIME),
CONCAT(LPAD((MAX(A.id_trans)+1), 6, '0'), '/IT-' , (SELECT id_category FROM category_detail WHERE id_detail='$catdet') , '/' , DATE_FORMAT(NOW(),'%m') , '/' , DATE_FORMAT(NOW(),'%Y') )
FROM trans A";
if ($conn->query($sql) === TRUE) {
    echo "data inserted";
}
else
{
    echo "failed";
}
?>
<?php
require("../config.php");

$request = $_REQUEST;
$col = array(
    0 => 'id',
    1 => 'tanggal',
    2 => 'nomor_tiket',
    3 => 'creator',
    4 => 'nama_divisi',
    5 => 'nama_cat',
    6 => 'nama_catdet',
    7 => 'problem',
    8 => 'status_tiket',
    9 => 'nama',
    10 => 'detail',
    11 => 'nama_file',
    12 => 'prioritas',
    13 => 'waktu'
);

//create column like table in database
$sql = "SELECT 
                id,
                tanggal,
                nomor_tiket,
                creator,
                nama_divisi,
                nama_cat,
                nama_catdet,
                problem,  
                status_tiket,
                nama,
                detail,
                nama_file,
                prioritas,
                waktu
               FROM 
                t_transaksi_m";
$query = mysqli_query($con, $sql);
$totalData = mysqli_num_rows($query);
$totalFilter = $totalData;

//Search
$sql = "SELECT 
                id,
                tanggal,
                nomor_tiket,
                creator,
                nama_divisi,
                nama_cat,
                nama_catdet,
                problem,  
                status_tiket,
                nama,
                detail,
                nama_file,
                prioritas,
                waktu
               FROM 
                t_transaksi_m
               WHERE 1=1";

if (!empty($request['search']['value'])) {
    $sql .= " AND ( tanggal LIKE '%" . $request['search']['value'] . "%'";
    $sql .= " OR nomor_tiket LIKE '%" . $request['search']['value'] . "%'";
    $sql .= " OR creator LIKE '%" . $request['search']['value'] . "%'";
    $sql .= " OR nama_divisi LIKE '%" . $request['search']['value'] . "%'";
    $sql .= " OR nama_cat LIKE '%" . $request['search']['value'] . "%'";
    $sql .= " OR nama_catdet LIKE '%" . $request['search']['value'] . "%'";
    $sql .= " OR nama LIKE '%" . $request['search']['value'] . "%'";
    $sql .= " OR detail LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR nama_file LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR prioritas LIKE '%" . $request['search']['value'] . "%' ";
    $sql .= " OR waktu LIKE '%" . $request['search']['value'] . "%' )";
}

//Order
$sql.=" ORDER BY ".$col[$request['order'][0]['column']]."   ".$request['order'][0]['dir']."  LIMIT ".
    $request['start']."  ,".$request['length']."  ";
$query=mysqli_query($con,$sql);
$data=array();
while($row=mysqli_fetch_array($query)){
    $subdata=array();
    $subdata[]=$row[1]; //tanggal
    $subdata[]=$row[2]; //nomor_tiket
    $subdata[]=$row[3]; //creator
    $subdata[]=$row[4]; //nama_divisi           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[5]; //nama_cat           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[6]; //nama_catdet           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[7]; //problem           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[8]; //status_tiket           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[9]; //nama           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[10]; //detail           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[11]; //nama_file           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[12]; //prioritas           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]=$row[13]; //waktu           //create event on click in button edit in cell datatable for display modal dialog           $row[0] is id in table on database
    $subdata[]='<a class="btn btn-warning btn-fill" href="vw_edit_ticket_manager.php?id='.$row[0].'">
                    <i class="material-icons">edit</i></a>';
    $data[]=$subdata;
}
$json_data=array(
    "draw"              =>  intval($request['draw']),
    "recordsTotal"      =>  intval($totalData),
    "recordsFiltered"   =>  intval($totalFilter),
    "data"              =>  $data
);
echo json_encode($json_data);
?>
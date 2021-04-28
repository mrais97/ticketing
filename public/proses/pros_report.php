<?php
// Load file koneksi.php
require("../config.php");
if (!isset($_SESSION["role"]))
{
    header("location: ../index.php");
}
$roleuser = $_SESSION['role'];
$uiduser = $_SESSION['uid'];
$uid = $_SESSION['uid'];
$username = $_SESSION['username'];

// Load plugin PHPExcel nya
require_once '../PHPExcel/PHPExcel.php';

// Panggil class PHPExcel nya
$excel = new PHPExcel();


// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
$style_col = array(
    'font' => array('bold' => true), // Set font nya jadi bold
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER , // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
);

// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
$style_row = array(
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER , // Set text jadi ditengah secara horizontal (center)
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
    ),
    'borders' => array(
        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
    )
);


$excel->setActiveSheetIndex(0)->setCellValue('A1', "Report Ticket"); // Set kolom A1 dengan tulisan "DATA SISWA"
$excel->getActiveSheet()->mergeCells('A1:O1'); // Set Merge Cell pada kolom A1 sampai F1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1


// Buat header tabel nya pada baris ke 3
$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
$excel->setActiveSheetIndex(0)->setCellValue('B3', "NO TICKET"); // Set kolom B3 dengan tulisan "NIS"
$excel->setActiveSheetIndex(0)->setCellValue('C3', "PEMBUAT TIKET"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('D3', "NIK PEMBUAT TIKET"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('E3', "DEPT. PEMBUAT TIKET"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('F3', "DIV. PEMBUAT TIKET"); // Set kolom C3 dengan tulisan "NAMA"
$excel->setActiveSheetIndex(0)->setCellValue('G3', "PIC TIKET"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
$excel->setActiveSheetIndex(0)->setCellValue('H3', "NIK PIC TIKET"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
$excel->setActiveSheetIndex(0)->setCellValue('I3', "KATEGORI DETAIL"); // Set kolom E3 dengan tulisan "TELEPON"
$excel->setActiveSheetIndex(0)->setCellValue('J3', "KATEGORI"); // Set kolom F3 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('K3', "WAKTU MULAI"); // Set kolom F3 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('L3', "WAKTU SELESAI"); // Set kolom F3 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('M3', "WAKTU HOLD (JAM)"); // Set kolom F3 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('N3', "WAKTU PENGERJAAN (JAM)"); // Set kolom F3 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('O3', "PRIORITAS"); // Set kolom F3 dengan tulisan "ALAMAT"
$excel->setActiveSheetIndex(0)->setCellValue('P3', "STATUS TIKET"); // Set kolom F3 dengan tulisan "ALAMAT"

// Apply style header yang telah kita buat tadi ke masing-masing kolom header
$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('G3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('H3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('I3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('J3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('K3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('L3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('M3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('N3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('O3')->applyFromArray($style_col);
$excel->getActiveSheet()->getStyle('P3')->applyFromArray($style_col);

// Set height baris ke 1, 2 dan 3
$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);


// Buat query untuk menampilkan semua data siswa

$query="SELECT 
a.no_ticket,
h.nama AS Creator,
b.nik AS nikcreator,
f.KSLDIV AS KSLDIV,
g.KSLDEPT AS KSLDEPT,
z.nama AS PIC,
c.nik AS nikpic,
d.detail_category_name,
e.category_name,
a.start_date,
a.finish_date,
TIMESTAMPDIFF(HOUR,a.hold_date,a.finish_date)AS 'Hold_Time',
TIMESTAMPDIFF(HOUR,a.start_date,a.finish_date)AS 'Work_Time',
CASE 
WHEN a.priority = 1 THEN 'Low'
WHEN a.priority = 2 THEN 'Medium'
WHEN a.priority = 3 THEN 'High'
END AS 'priority',
CASE
WHEN a.flag ='0' THEN 'open'
WHEN a.flag ='1' THEN 'close'
WHEN a.flag ='2' THEN 'hold'
END AS 'status'
FROM ticket_staging.t_transaksi a
LEFT JOIN ticket_staging.mr_peg_perikatan b
ON a.pic_report=b.user_uid
LEFT JOIN ticket_staging.mr_peg_perikatan c
ON a.pic=c.user_uid
LEFT JOIN ticket_staging.mr_peg_info_personal z
ON a.pic=z.user_uid
LEFT JOIN ticket_staging.mr_peg_info_personal h
ON a.pic_report=h.user_uid
LEFT JOIN ticket_staging.t_category_detail d
ON a.id_detail=d.id
LEFT JOIN ticket_staging.t_category e
ON d.id_category=e.id
LEFT JOIN ticket_staging.mr_peg_penugasan i
ON a.pic_report=i.user_uid
LEFT JOIN ticket_staging.mr_ksldiv f
ON i.ID_KSLDIV=f.ID_KSLDIV
LEFT JOIN ticket_staging.mr_ksldept g
ON i.ID_KSLDEPT=g.ID_KSLDEPT
WHERE a.id>1 AND i.status_pms='1' AND b.status_karyawan='1' AND c.status_karyawan='1'
AND DATE(a.start_date) BETWEEN '$froms' AND '$tos'
AND a.id_divisi IN ($divs)
AND e.id IN ($cats)
AND d.id IN ($catids)
AND a.flag IN ($flags)";

echo $query;

//$sql = mysqli_query($con,$query);

$no = 1; // Untuk penomoran tabel, di awal set dengan 1
$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['no_ticket']);
    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['Creator']);
    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['nikcreator']);
    $excel->setActiveSheetIndex(0)->setCellValue('E'.$numrow, $data['KSLDIV']);
    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['KSLDEPT']);
    $excel->setActiveSheetIndex(0)->setCellValue('G'.$numrow, $data['PIC']);
    $excel->setActiveSheetIndex(0)->setCellValue('H'.$numrow, $data['nikpic']);
    $excel->setActiveSheetIndex(0)->setCellValue('I'.$numrow, $data['detail_category_name']);
    $excel->setActiveSheetIndex(0)->setCellValue('J'.$numrow, $data['category_name']);
    $excel->setActiveSheetIndex(0)->setCellValue('K'.$numrow, $data['start_date']);
    $excel->setActiveSheetIndex(0)->setCellValue('L'.$numrow, $data['finish_date']);
    $excel->setActiveSheetIndex(0)->setCellValue('M'.$numrow, $data['Hold_Time']);
    $excel->setActiveSheetIndex(0)->setCellValue('N'.$numrow, $data['Work_Time']);
    $excel->setActiveSheetIndex(0)->setCellValue('O'.$numrow, $data['priority']);
    $excel->setActiveSheetIndex(0)->setCellValue('P'.$numrow, $data['status']);


// Khusus untuk no telepon. kita set type kolom nya jadi STRING
//	$excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $data['telp'], PHPExcel_Cell_DataType::TYPE_STRING);
//
//	$excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['alamat']);

    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('G'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('H'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('I'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('J'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('K'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('L'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('M'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('N'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('O'.$numrow)->applyFromArray($style_row);
    $excel->getActiveSheet()->getStyle('P'.$numrow)->applyFromArray($style_row);

    $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);

    $no++; // Tambah 1 setiap kali looping
    $numrow++; // Tambah 1 setiap kali looping
}

// Set width kolom
$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E
$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('G')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('H')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('I')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('J')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('K')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('L')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('M')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('N')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('O')->setWidth(30); // Set width kolom F
$excel->getActiveSheet()->getColumnDimension('P')->setWidth(30); // Set width kolom F

// Set orientasi kertas jadi LANDSCAPE
$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);

// Set judul file excel nya
$excel->getActiveSheet(0)->setTitle("Report Tiket");
$excel->setActiveSheetIndex(0);

// Proses file excel
//obob_end_clean

ob_end_clean();
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="ticket_report.xls"'); // Set nama file excel nya
header('Cache-Control: max-age=0');
header('Pragma: no-cache');
header('Expires: 0');
ob_end_clean();

$write = PHPExcel_IOFactory::createWriter($excel, 'Excel5');
//Excel2007
$write->save('php://output');
?>







<?php
//// Load file koneksi.php
//include "koneksi.php";
//
//// Load plugin PHPExcel nya
//require_once 'PHPExcel/PHPExcel.php';
//
//// Panggil class PHPExcel nya
//$excel = new PHPExcel();
//
//// Settingan awal fil excel
//$excel->getProperties()->setCreator('My Notes Code')
//    ->setLastModifiedBy('My Notes Code')
//    ->setTitle("Data Siswa")
//    ->setSubject("Siswa")
//    ->setDescription("Laporan Semua Data Siswa")
//    ->setKeywords("Data Siswa");
//
//// Buat sebuah variabel untuk menampung pengaturan style dari header tabel
//$style_col = array(
//    'font' => array('bold' => true), // Set font nya jadi bold
//    'alignment' => array(
//        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER, // Set text jadi ditengah secara horizontal (center)
//        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
//    ),
//    'borders' => array(
//        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
//        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
//        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
//        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
//    )
//);
//
//// Buat sebuah variabel untuk menampung pengaturan style dari isi tabel
//$style_row = array(
//    'alignment' => array(
//        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER // Set text jadi di tengah secara vertical (middle)
//    ),
//    'borders' => array(
//        'top' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border top dengan garis tipis
//        'right' => array('style'  => PHPExcel_Style_Border::BORDER_THIN),  // Set border right dengan garis tipis
//        'bottom' => array('style'  => PHPExcel_Style_Border::BORDER_THIN), // Set border bottom dengan garis tipis
//        'left' => array('style'  => PHPExcel_Style_Border::BORDER_THIN) // Set border left dengan garis tipis
//    )
//);
//
//$excel->setActiveSheetIndex(0)->setCellValue('A1', "DATA SISWA"); // Set kolom A1 dengan tulisan "DATA SISWA"
//$excel->getActiveSheet()->mergeCells('A1:F1'); // Set Merge Cell pada kolom A1 sampai F1
//$excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(TRUE); // Set bold kolom A1
//$excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(15); // Set font size 15 untuk kolom A1
//$excel->getActiveSheet()->getStyle('A1')->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER); // Set text center untuk kolom A1
//
//// Buat header tabel nya pada baris ke 3
//$excel->setActiveSheetIndex(0)->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"
//$excel->setActiveSheetIndex(0)->setCellValue('B3', "NIS"); // Set kolom B3 dengan tulisan "NIS"
//$excel->setActiveSheetIndex(0)->setCellValue('C3', "NAMA"); // Set kolom C3 dengan tulisan "NAMA"
//$excel->setActiveSheetIndex(0)->setCellValue('D3', "JENIS KELAMIN"); // Set kolom D3 dengan tulisan "JENIS KELAMIN"
//$excel->setActiveSheetIndex(0)->setCellValue('E3', "TELEPON"); // Set kolom E3 dengan tulisan "TELEPON"
//$excel->setActiveSheetIndex(0)->setCellValue('F3', "ALAMAT"); // Set kolom F3 dengan tulisan "ALAMAT"
//
//// Apply style header yang telah kita buat tadi ke masing-masing kolom header
//$excel->getActiveSheet()->getStyle('A3')->applyFromArray($style_col);
//$excel->getActiveSheet()->getStyle('B3')->applyFromArray($style_col);
//$excel->getActiveSheet()->getStyle('C3')->applyFromArray($style_col);
//$excel->getActiveSheet()->getStyle('D3')->applyFromArray($style_col);
//$excel->getActiveSheet()->getStyle('E3')->applyFromArray($style_col);
//$excel->getActiveSheet()->getStyle('F3')->applyFromArray($style_col);
//
//// Set height baris ke 1, 2 dan 3
//$excel->getActiveSheet()->getRowDimension('1')->setRowHeight(20);
//$excel->getActiveSheet()->getRowDimension('2')->setRowHeight(20);
//$excel->getActiveSheet()->getRowDimension('3')->setRowHeight(20);
//
//// Buat query untuk menampilkan semua data siswa
//$sql = mysqli_query($connect, "SELECT * FROM siswa");
//
//$no = 1; // Untuk penomoran tabel, di awal set dengan 1
//$numrow = 4; // Set baris pertama untuk isi tabel adalah baris ke 4
//while($data = mysqli_fetch_array($sql)){ // Ambil semua data dari hasil eksekusi $sql
//    $excel->setActiveSheetIndex(0)->setCellValue('A'.$numrow, $no);
//    $excel->setActiveSheetIndex(0)->setCellValue('B'.$numrow, $data['nis']);
//    $excel->setActiveSheetIndex(0)->setCellValue('C'.$numrow, $data['nama']);
//    $excel->setActiveSheetIndex(0)->setCellValue('D'.$numrow, $data['jenis_kelamin']);
//
//    // Khusus untuk no telepon. kita set type kolom nya jadi STRING
//    $excel->setActiveSheetIndex(0)->setCellValueExplicit('E'.$numrow, $data['telp'], PHPExcel_Cell_DataType::TYPE_STRING);
//
//    $excel->setActiveSheetIndex(0)->setCellValue('F'.$numrow, $data['alamat']);
//
//    // Apply style row yang telah kita buat tadi ke masing-masing baris (isi tabel)
//    $excel->getActiveSheet()->getStyle('A'.$numrow)->applyFromArray($style_row);
//    $excel->getActiveSheet()->getStyle('B'.$numrow)->applyFromArray($style_row);
//    $excel->getActiveSheet()->getStyle('C'.$numrow)->applyFromArray($style_row);
//    $excel->getActiveSheet()->getStyle('D'.$numrow)->applyFromArray($style_row);
//    $excel->getActiveSheet()->getStyle('E'.$numrow)->applyFromArray($style_row);
//    $excel->getActiveSheet()->getStyle('F'.$numrow)->applyFromArray($style_row);
//
//    $excel->getActiveSheet()->getRowDimension($numrow)->setRowHeight(20);
//
//    $no++; // Tambah 1 setiap kali looping
//    $numrow++; // Tambah 1 setiap kali looping
//}
//
//// Set width kolom
//$excel->getActiveSheet()->getColumnDimension('A')->setWidth(5); // Set width kolom A
//$excel->getActiveSheet()->getColumnDimension('B')->setWidth(15); // Set width kolom B
//$excel->getActiveSheet()->getColumnDimension('C')->setWidth(25); // Set width kolom C
//$excel->getActiveSheet()->getColumnDimension('D')->setWidth(20); // Set width kolom D
//$excel->getActiveSheet()->getColumnDimension('E')->setWidth(15); // Set width kolom E
//$excel->getActiveSheet()->getColumnDimension('F')->setWidth(30); // Set width kolom F
//
//// Set orientasi kertas jadi LANDSCAPE
//$excel->getActiveSheet()->getPageSetup()->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_LANDSCAPE);
//
//// Set judul file excel nya
//$excel->getActiveSheet(0)->setTitle("Laporan Data Transaksi");
//$excel->setActiveSheetIndex(0);
//
//// Proses file excel
//header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
//header('Content-Disposition: attachment; filename="Data Siswa.xlsx"'); // Set nama file excel nya
//header('Cache-Control: max-age=0');
//
//$write = PHPExcel_IOFactory::createWriter($excel, 'Excel2007');
//$write->save('php://output');
//?>

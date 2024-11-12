<?php
require('fpdf186/fpdf.php');
require 'DB.php';

// استعلام لجلب البيانات
$query = "SELECT ID, name, phonNumber ,destination, email , date FROM skylanddb";
$result = mysqli_query($conn, $query);

class PDF extends FPDF {
    // إنشاء رأس الصفحة
    function Header() {
        $this->SetFont('Arial', 'B', 14);
        $this->Cell(0, 10, 'Mail Report', 0, 1, 'C');
        $this->Ln(10);
    }

    // إنشاء تذييل الصفحة
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // إنشاء جدول
    function CreateTable($header, $data) {
        // عرض العناوين
       // إعداد حجم الخط للعناوين
$this->SetFont('Arial', 'B', 12);

// تحديد أحجام الأعمدة
$columnWidths = [
    'ID' => 20,
    'name' => 30,
    'phonNumber' => 30,
    'destination' => 40,
    'email' => 50,
    'date' => 30
];

// عرض العناوين
foreach ($header as $col) {
    // تحقق إذا كان هناك حجم محدد للعمود
    $width = isset($columnWidths[$col]) ? $columnWidths[$col] : 30;
    $this->Cell($width, 7, $col, 1);
}

$this->Ln();

        // عرض البيانات
        $this->SetFont('Arial', '', 12);
        foreach ($data as $row) {
            $this->Cell(20, 6, $row['ID'], 1);
            $this->Cell(30, 6, $row['name'], 1);
            $this->Cell(30, 6, $row['phonNumber'], 1);
            $this->Cell(40, 6, $row['destination'], 1);
            $this->Cell(50, 6, $row['email'], 1);
            $this->Cell(30, 6, $row['date'], 1);
            $this->Ln();
        }
    }
}

// إعداد البيانات
$data = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row;
    }
}

mysqli_close($conn);

// إنشاء PDF
$pdf = new PDF();
$pdf->AddPage();
$header = ['ID', 'name', 'phonNumber' ,'destination','email','date'];
$pdf->CreateTable($header, $data);
$pdf->Output();
?>
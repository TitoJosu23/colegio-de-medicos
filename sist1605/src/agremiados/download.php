<?php
session_start();
require '../../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Pdf\Mpdf;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Conexión a la base de datos
require '../includes/db.php';

// Verificar si el usuario tiene permisos
if (!isset($_SESSION['user_id']) || $_SESSION['rol'] != 'admin') {
    header('Location: ../login.php');
    exit();
}

// Obtener el formato del archivo
$format = isset($_GET['format']) ? $_GET['format'] : 'excel';

// Consultar la base de datos para obtener los médicos
$stmt = $pdo->prepare('SELECT * FROM medicos');
$stmt->execute();
$medicos = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Crear el objeto Spreadsheet
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();

// Añadir encabezado con título
$sheet->mergeCells('B1:H1');
$sheet->setCellValue('B1', 'COLEGIO DE MÉDICOS DEL ESTADO GUÁRICO');
$sheet->getStyle('B1')->getFont()->setBold(true)->setSize(16);
$sheet->getStyle('B1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

$sheet->mergeCells('B2:H2');
$sheet->setCellValue('B2', 'LISTADO DE MÉDICOS INSCRITOS');
$sheet->getStyle('B2')->getFont()->setBold(true)->setSize(14);
$sheet->getStyle('B2')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

// Añadir encabezados a las columnas
$sheet->setCellValue('B4', 'ID');
$sheet->setCellValue('C4', 'Cédula');
$sheet->setCellValue('D4', 'Nombre');
$sheet->setCellValue('E4', 'Apellido');
$sheet->setCellValue('F4', 'Estatus');

// Aplicar estilo de negrita y bordes a los encabezados
$headerStyle = [
    'font' => ['bold' => true],
    'borders' => [
        'allBorders' => [
            'borderStyle' => Border::BORDER_THIN,
            'color' => ['rgb' => '000000'],
        ],
    ],
];
$sheet->getStyle('B4:F4')->applyFromArray($headerStyle);

// Añadir datos a las columnas
$row = 5;
foreach ($medicos as $medico) {
    $sheet->setCellValue('B' . $row, $medico['id']);
    $sheet->setCellValue('C' . $row, $medico['cedula']);
    $sheet->setCellValue('D' . $row, $medico['nombre']);
    $sheet->setCellValue('F' . $row, $medico['apellido']);
    $sheet->setCellValue('E' . $row, $medico['estatus']);
    $row++;
}

// Aplicar bordes a toda la tabla
$highestRow = $sheet->getHighestRow();
$highestColumn = $sheet->getHighestColumn();
$range = 'B4:' . $highestColumn . $highestRow;
$sheet->getStyle($range)->getBorders()->getAllBorders()->setBorderStyle(Border::BORDER_THIN)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color('000000'));

if ($format === 'pdf') {
    // Configurar la hoja para PDF
    $writer = new Mpdf($spreadsheet);
    $writer->setSheetIndex(0);
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment;filename="listado_medicos.pdf"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
} else {
    // Configurar la hoja para Excel
    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="listado_medicos.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
}

exit();
?>

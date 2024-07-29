<?php
include_once 'config.php';

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="balance_sheet.xlsx"');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class BalanceSheet {
    private $conn;
    private $user_table = "users";
    private $expense_table = "expenses";
    private $split_table = "splits";

    public function __construct($db) {
        $this->conn = $db;
    }

    function generate() {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'Expense ID');
        $sheet->setCellValue('B1', 'Expense Amount');
        $sheet->setCellValue('C1', 'Method');
        $sheet->setCellValue('D1', 'Description');
        $sheet->setCellValue('E1', 'User');
        $sheet->setCellValue('F1', 'Split Amount');
        $sheet->setCellValue('G1', 'Split Percentage');

        $query = "SELECT e.id as expense_id, e.amount as expense_amount, e.method as expense_method, e.description as expense_description,
                         u.name as user_name, s.amount as split_amount, s.percentage as split_percentage
                  FROM " . $this->expense_table . " e
                  JOIN " . $this->split_table . " s ON e.id = s.expense_id
                  JOIN " . $this->user_table . " u ON s.user_id = u.id";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        $row_num = 2;
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $sheet->setCellValue('A' . $row_num, $row['expense_id']);
            $sheet->setCellValue('B' . $row_num, $row['expense_amount']);
            $sheet->setCellValue('C' . $row_num, $row['expense_method']);
            $sheet->setCellValue('D' . $row_num, $row['expense_description']);
            $sheet->setCellValue('E' . $row_num, $row['user_name']);
            $sheet->setCellValue('F' . $row_num, $row['split_amount']);
            $sheet->setCellValue('G' . $row_num, $row['split_percentage']);
            $row_num++;
        }

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
}

$database = new Database();
$db = $database->getConnection();

$balanceSheet = new BalanceSheet($db);
$balanceSheet->generate();
?>

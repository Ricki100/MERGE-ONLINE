<?php
session_start();

// Debug: Log file upload info
if (isset($_FILES['csv'])) {
    error_log(print_r($_FILES['csv'], true));
}

header('Content-Type: application/json');

if (!isset($_FILES['csv'])) {
    echo json_encode(['error' => 'No file uploaded']);
    exit;
}

$file = $_FILES['csv'];
if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['error' => 'File upload failed']);
    exit;
}

// Check file extension
$extension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
if (!in_array($extension, ['csv', 'xlsx', 'xls'])) {
    echo json_encode(['error' => 'Invalid file format. Please upload a CSV or Excel file']);
    exit;
}

try {
    if ($extension === 'csv') {
        // Handle CSV file
        $handle = fopen($file['tmp_name'], 'r');
        if ($handle === false) {
            throw new Exception('Could not open CSV file');
        }

        // Read headers
        $headers = fgetcsv($handle, 0, ",", "\"", "\\");
        if ($headers === false) {
            throw new Exception('Could not read CSV headers');
        }

        // Read data
        $data = [];
        while (($row = fgetcsv($handle, 0, ",", "\"", "\\")) !== false) {
            $data[] = array_combine($headers, $row);
        }
        fclose($handle);
    } else {
        // Handle Excel file
        require __DIR__ . '/../vendor/autoload.php';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file['tmp_name']);
        $worksheet = $spreadsheet->getActiveSheet();
        
        // Get headers
        $headers = [];
        foreach ($worksheet->getRowIterator(1, 1) as $row) {
            foreach ($row->getCellIterator() as $cell) {
                $headers[] = $cell->getValue();
            }
        }

        // Get data
        $data = [];
        foreach ($worksheet->getRowIterator(2) as $row) {
            $rowData = [];
            $i = 0;
            foreach ($row->getCellIterator() as $cell) {
                $rowData[$headers[$i]] = $cell->getValue();
                $i++;
            }
            $data[] = $rowData;
        }
    }

    // Store data in session
    $_SESSION['csv_data'] = $data;

    echo json_encode([
        'columns' => array_keys($data[0]),
        'preview' => array_slice($data, 0, 20),
        'all_data' => $data,
        'total_rows' => count($data)
    ]);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
} 
<?php
require_once 'includes/init.php';
require_once 'includes/auth.php';
require_once 'vendor/autoload.php';

if (!isLoggedIn()) {
    header('Location: index.php?page=login');
    exit();
}

$report_id = $_GET['id'] ?? null;
if (!$report_id) {
    header('Location: index.php?page=reports');
    exit();
}

$report = getReport($report_id, $_SESSION['user_id']);
if (!$report) {
    $_SESSION['error'] = "Report not found or access denied";
    header('Location: index.php?page=reports');
    exit();
}

// Create PDF using DOMPDF
use Dompdf\Dompdf;
use Dompdf\Options;

$options = new Options();
$options->set('isHtml5ParserEnabled', true);
$options->set('isPhpEnabled', true);

$dompdf = new Dompdf($options);

// Prepare HTML for PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>' . htmlspecialchars($report['title']) . '</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .header { margin-bottom: 20px; }
        .report-info { margin-bottom: 30px; }
        .content { margin-top: 20px; }
        .project-summary, .progress-update, .activity {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>' . htmlspecialchars($report['title']) . '</h1>
        <div class="report-info">
            <p><strong>Generated:</strong> ' . date('F j, Y g:i A', strtotime($report['created_at'])) . '</p>
            <p><strong>Type:</strong> ' . htmlspecialchars($report['type']) . '</p>
            <p><strong>Date Range:</strong> ' . 
                date('M j, Y', strtotime($report['from_date'])) . ' - ' . 
                date('M j, Y', strtotime($report['to_date'])) . '</p>
        </div>
    </div>
    <div class="content">
        ' . $report['content'] . '
    </div>
</body>
</html>';

$dompdf->loadHtml($html);
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();

// Generate filename
$filename = preg_replace('/[^a-z0-9]+/', '-', strtolower($report['title'])) . '-' . date('Y-m-d') . '.pdf';

// Output PDF for download
$dompdf->stream($filename, array('Attachment' => true));
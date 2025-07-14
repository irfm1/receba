<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';

$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

try {
    $result = DB::select('SELECT strftime("%Y-%m", issue_date) as month, SUM(total_amount) as total FROM invoices WHERE deleted_at IS NULL GROUP BY month ORDER BY month');
    
    echo "Query executed successfully!\n";
    echo "Monthly revenue data:\n";
    
    foreach ($result as $row) {
        echo "Month: " . $row->month . " - Revenue: R$ " . number_format($row->total, 2, ',', '.') . "\n";
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}

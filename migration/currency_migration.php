<?php
/**
 * Currency Migration Script
 * This script helps migrate from old currency system to new Kenyan currency system
 */

require_once '../config/Database.php';
require_once '../libs/CurrencyHelper.php';

class CurrencyMigration {
    private $db;
    
    public function __construct() {
        try {
            $this->db = new PDO('mysql:host=' . host . ';dbname=' . dbname, username, password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    /**
     * Convert Sri Lankan Rupees to Kenyan Shillings
     * You can adjust the conversion rate as needed
     */
    public function convertCurrency($amount, $conversionRate = 0.77) {
        return round($amount * $conversionRate, 2);
    }
    
    /**
     * Update all currency values in the database
     */
    public function migrateCurrencyValues($conversionRate = 0.77, $dryRun = true) {
        echo "Starting currency migration...\n";
        echo "Conversion rate: 1 LKR = $conversionRate KES\n";
        echo "Dry run: " . ($dryRun ? "Yes" : "No") . "\n\n";
        
        $tables = [
            'car_transactions' => ['amount'],
            'packages' => ['price'],
            'lu_packages' => ['price'],
            'nonreglu_transactions' => ['amount'],
            'lubricants' => ['Price'],
            'lubricant_expense' => ['price', 'total'],
            'lubricant_income' => ['price', 'lubricantincome'],
            'fuel_expense' => ['fuelpayment'],
            'fuel_income' => ['amount', 'fuelincome'],
            'payment' => ['paid'],
            'orders' => ['Orderamnt'],
            'attendance' => ['shiftprice']
        ];
        
        foreach ($tables as $table => $columns) {
            echo "Processing table: $table\n";
            
            foreach ($columns as $column) {
                try {
                    // Get current values
                    $stmt = $this->db->prepare("SELECT * FROM `$table` WHERE `$column` IS NOT NULL AND `$column` != ''");
                    $stmt->execute();
                    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    
                    echo "  - Column $column: " . count($rows) . " records\n";
                    
                    if (!$dryRun) {
                        foreach ($rows as $row) {
                            $oldValue = floatval($row[$column]);
                            $newValue = $this->convertCurrency($oldValue, $conversionRate);
                            
                            // Update the record
                            $primaryKey = $this->getPrimaryKey($table);
                            if ($primaryKey && isset($row[$primaryKey])) {
                                $updateStmt = $this->db->prepare("UPDATE `$table` SET `$column` = ? WHERE `$primaryKey` = ?");
                                $updateStmt->execute([$newValue, $row[$primaryKey]]);
                            }
                        }
                    }
                    
                } catch (PDOException $e) {
                    echo "    Error processing $table.$column: " . $e->getMessage() . "\n";
                }
            }
            echo "\n";
        }
        
        if ($dryRun) {
            echo "This was a dry run. No data was modified.\n";
            echo "To perform the actual migration, set \$dryRun = false\n";
        } else {
            echo "Migration completed successfully!\n";
        }
    }
    
    /**
     * Get primary key for a table
     */
    private function getPrimaryKey($table) {
        $primaryKeys = [
            'car_transactions' => 'id',
            'packages' => 'id',
            'lu_packages' => 'id',
            'nonreglu_transactions' => 'id',
            'lubricants' => 'Id',
            'lubricant_expense' => 'Id',
            'lubricant_income' => 'prdIncomeID',
            'fuel_expense' => 'Id',
            'fuel_income' => 'incomeID',
            'payment' => 'Id',
            'orders' => 'Id',
            'attendance' => 'atid'
        ];
        
        return isset($primaryKeys[$table]) ? $primaryKeys[$table] : null;
    }
    
    /**
     * Create a backup of the database before migration
     */
    public function createBackup() {
        $backupFile = 'backup_' . date('Y-m-d_H-i-s') . '.json';
        
        echo "Creating PHP-based backup: $backupFile\n";
        
        try {
            $backup = [];
            $tables = [
                'car_transactions', 'packages', 'lu_packages', 'nonreglu_transactions',
                'lubricants', 'lubricant_expense', 'lubricant_income', 'fuel_expense',
                'fuel_income', 'payment', 'orders', 'attendance'
            ];
            
            foreach ($tables as $table) {
                $stmt = $this->db->prepare("SELECT * FROM `$table`");
                $stmt->execute();
                $backup[$table] = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
            
            file_put_contents($backupFile, json_encode($backup, JSON_PRETTY_PRINT));
            echo "Backup created successfully!\n";
            return $backupFile;
            
        } catch (Exception $e) {
            echo "Backup failed: " . $e->getMessage() . "\n";
            return false;
        }
    }
}

// Usage example:
if (php_sapi_name() === 'cli') {
    $migration = new CurrencyMigration();
    
    // Create backup first
    echo "=== Currency Migration Tool ===\n";
    echo "This tool will convert existing currency values from LKR to KES\n\n";
    
    $backup = $migration->createBackup();
    if ($backup) {
        echo "\n";
        
        // Perform dry run first
        $migration->migrateCurrencyValues(0.77, true);
        
        echo "\nTo perform actual migration, uncomment the line below:\n";
        echo "// \$migration->migrateCurrencyValues(0.77, false);\n";
        
        // Actually perform the migration
        echo "\n" . str_repeat("=", 50) . "\n";
        echo "PERFORMING ACTUAL MIGRATION...\n";
        echo str_repeat("=", 50) . "\n";
        $migration->migrateCurrencyValues(0.77, false);
    }
} else {
    echo "This script should be run from the command line.\n";
}
?>




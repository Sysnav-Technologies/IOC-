<?php
// Simple script to check if debug logging is working
$logFile = __DIR__ . '/debug_cpanel.log';
$timestamp = date('Y-m-d H:i:s');

file_put_contents($logFile, "\n[$timestamp] Test log entry - logging system is working", FILE_APPEND);

echo "Log test complete. Check debug_cpanel.log file.";

// Also display current log contents if file exists
if (file_exists($logFile)) {
    echo "<pre>";
    echo "Current log contents:\n";
    echo file_get_contents($logFile);
    echo "</pre>";
} else {
    echo "Log file doesn't exist yet.";
}
?>

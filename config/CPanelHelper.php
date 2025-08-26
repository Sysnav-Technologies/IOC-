<?php
/**
 * cPanel Compatibility Helper
 * Handles environment detection and path adjustments for cPanel hosting
 */
class CPanelHelper {
    
    /**
     * Check if running on cPanel environment
     */
    public static function isCPanel() {
        // Check for common cPanel indicators
        return (
            isset($_SERVER['HTTP_HOST']) && 
            $_SERVER['HTTP_HOST'] !== 'localhost' && 
            $_SERVER['HTTP_HOST'] !== '127.0.0.1' &&
            (strpos($_SERVER['DOCUMENT_ROOT'], '/public_html') !== false ||
             strpos($_SERVER['DOCUMENT_ROOT'], '/www') !== false)
        );
    }
    
    /**
     * Get the correct base path for the application
     */
    public static function getBasePath() {
        if (self::isCPanel()) {
            // On cPanel, usually in public_html
            return $_SERVER['DOCUMENT_ROOT'] . '/';
        } else {
            // Local development
            return $_SERVER['DOCUMENT_ROOT'] . '/IOC/';
        }
    }
    
    /**
     * Get the correct URL base
     */
    public static function getBaseURL() {
        $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
        
        // Check if we're on localhost (development)
        if ($_SERVER['HTTP_HOST'] === 'localhost' || 
            $_SERVER['HTTP_HOST'] === '127.0.0.1' || 
            strpos($_SERVER['HTTP_HOST'], ':') !== false) {
            // Development environment - include /IOC/
            return $protocol . '://' . $_SERVER['HTTP_HOST'] . '/IOC/';
        }
        
        // Production cPanel environment - auto-detect path
        $scriptPath = $_SERVER['SCRIPT_NAME'] ?? '';
        $basePath = '/';
        
        // Extract directory path from script path
        if (strpos($scriptPath, 'index.php') !== false) {
            $detectedPath = dirname($scriptPath);
            if ($detectedPath !== '.' && $detectedPath !== '/') {
                $basePath = $detectedPath . '/';
            }
        }
        
        // Ensure proper format
        $basePath = rtrim($basePath, '/') . '/';
        if ($basePath === '//') $basePath = '/';
        
        return $protocol . '://' . $_SERVER['HTTP_HOST'] . $basePath;
    }
    
    /**
     * Check database connection and provide helpful error messages
     */
    public static function checkDatabaseConnection() {
        try {
            require_once __DIR__ . '/Config.php';
            $dbConfig = Config::getDbConfig();
            
            $pdo = new PDO(
                "mysql:host={$dbConfig['host']};dbname={$dbConfig['name']}", 
                $dbConfig['username'], 
                $dbConfig['password']
            );
            
            return ['success' => true, 'message' => 'Database connection successful'];
        } catch (PDOException $e) {
            $errorMsg = 'Database connection failed: ' . $e->getMessage();
            
            // Provide specific help for common cPanel issues
            if (strpos($e->getMessage(), 'Access denied') !== false) {
                $errorMsg .= "\n\nFor cPanel hosting:\n";
                $errorMsg .= "1. Check your database credentials in .env file\n";
                $errorMsg .= "2. Ensure database user has proper permissions\n";
                $errorMsg .= "3. Verify database name includes your cPanel username prefix\n";
                $errorMsg .= "4. Check if your hosting allows external database connections";
            }
            
            return ['success' => false, 'message' => $errorMsg];
        }
    }
}

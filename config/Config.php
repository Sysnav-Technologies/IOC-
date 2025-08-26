<?php

/**
 * Configuration Helper Class
 * Centralized configuration management with environment variable support
 */
class Config {
    private static $loaded = false;
    
    /**
     * Load environment variables from .env file
     */
    public static function loadEnv() {
        if (self::$loaded) {
            return; // Already loaded
        }
        
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '#') === 0) continue; // Skip comments
                if (strpos($line, '=') !== false) {
                    list($key, $value) = explode('=', $line, 2);
                    $_ENV[trim($key)] = trim($value);
                }
            }
        }
        
        self::$loaded = true;
    }
    
    /**
     * Get database configuration
     */
    public static function getDbConfig() {
        self::loadEnv();
        return [
            'host' => isset($_ENV['DB_HOST']) ? $_ENV['DB_HOST'] : 'localhost',
            'name' => isset($_ENV['DB_NAME']) ? $_ENV['DB_NAME'] : 'ioc',
            'username' => isset($_ENV['DB_USERNAME']) ? $_ENV['DB_USERNAME'] : 'root',
            'password' => isset($_ENV['DB_PASSWORD']) ? $_ENV['DB_PASSWORD'] : ''
        ];
    }
    
    /**
     * Get mail configuration
     */
    public static function getMailConfig() {
        self::loadEnv();
        return [
            'host' => isset($_ENV['MAIL_HOST']) ? $_ENV['MAIL_HOST'] : 'ssl://smtp.gmail.com',
            'port' => isset($_ENV['MAIL_PORT']) ? $_ENV['MAIL_PORT'] : 465,
            'username' => isset($_ENV['MAIL_USERNAME']) ? $_ENV['MAIL_USERNAME'] : 'ioc.negambo@gmail.com',
            'password' => isset($_ENV['MAIL_PASSWORD']) ? $_ENV['MAIL_PASSWORD'] : 'IocNegambo123',
            'encryption' => isset($_ENV['MAIL_ENCRYPTION']) ? $_ENV['MAIL_ENCRYPTION'] : 'ssl',
            'from_address' => isset($_ENV['MAIL_FROM_ADDRESS']) ? $_ENV['MAIL_FROM_ADDRESS'] : 'carwash@gmail.com',
            'from_name' => isset($_ENV['MAIL_FROM_NAME']) ? $_ENV['MAIL_FROM_NAME'] : 'IOC'
        ];
    }
    
    /**
     * Get SMS configuration
     */
    public static function getSmsConfig() {
        self::loadEnv();
        return [
            'api_key' => isset($_ENV['SMS_API_KEY']) ? $_ENV['SMS_API_KEY'] : '0fd288d7',
            'api_secret' => isset($_ENV['SMS_API_SECRET']) ? $_ENV['SMS_API_SECRET'] : '4ba994ca'
        ];
    }
}

<?php
/**
 * Currency Helper Class
 * Handles all currency formatting and display operations
 */
class CurrencyHelper {
    
    private static $currencyCode;
    private static $currencySymbol;
    private static $currencyName;
    private static $decimalPlaces;
    private static $thousandsSeparator;
    private static $decimalSeparator;
    private static $symbolPosition;
    
    /**
     * Initialize currency settings from environment
     */
    public static function init() {
        self::loadEnvSettings();
    }
    
    /**
     * Load currency settings from .env file
     */
    private static function loadEnvSettings() {
        $envFile = __DIR__ . '/../.env';
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            foreach ($lines as $line) {
                if (strpos($line, '#') === 0) continue; // Skip comments
                list($key, $value) = explode('=', $line, 2);
                $_ENV[trim($key)] = trim($value);
            }
        }
        
        // Set currency properties
        self::$currencyCode = isset($_ENV['CURRENCY_CODE']) ? $_ENV['CURRENCY_CODE'] : 'KES';
        self::$currencySymbol = isset($_ENV['CURRENCY_SYMBOL']) ? $_ENV['CURRENCY_SYMBOL'] : 'KSh';
        self::$currencyName = isset($_ENV['CURRENCY_NAME']) ? $_ENV['CURRENCY_NAME'] : 'Kenyan Shilling';
        self::$decimalPlaces = isset($_ENV['CURRENCY_DECIMAL_PLACES']) ? (int)$_ENV['CURRENCY_DECIMAL_PLACES'] : 2;
        self::$thousandsSeparator = isset($_ENV['CURRENCY_THOUSANDS_SEPARATOR']) ? $_ENV['CURRENCY_THOUSANDS_SEPARATOR'] : ',';
        self::$decimalSeparator = isset($_ENV['CURRENCY_DECIMAL_SEPARATOR']) ? $_ENV['CURRENCY_DECIMAL_SEPARATOR'] : '.';
        self::$symbolPosition = isset($_ENV['CURRENCY_SYMBOL_POSITION']) ? $_ENV['CURRENCY_SYMBOL_POSITION'] : 'before';
    }
    
    /**
     * Format currency amount for display
     * @param float $amount
     * @param bool $includeSymbol
     * @return string
     */
    public static function format($amount, $includeSymbol = true) {
        if (self::$currencyCode === null) {
            self::init();
        }
        
        $formattedAmount = number_format(
            (float)$amount, 
            self::$decimalPlaces, 
            self::$decimalSeparator, 
            self::$thousandsSeparator
        );
        
        if (!$includeSymbol) {
            return $formattedAmount;
        }
        
        if (self::$symbolPosition === 'before') {
            return self::$currencySymbol . ' ' . $formattedAmount;
        } else {
            return $formattedAmount . ' ' . self::$currencySymbol;
        }
    }
    
    /**
     * Get currency symbol
     * @return string
     */
    public static function getSymbol() {
        if (self::$currencyCode === null) {
            self::init();
        }
        return self::$currencySymbol;
    }
    
    /**
     * Get currency code
     * @return string
     */
    public static function getCode() {
        if (self::$currencyCode === null) {
            self::init();
        }
        return self::$currencyCode;
    }
    
    /**
     * Get currency name
     * @return string
     */
    public static function getName() {
        if (self::$currencyCode === null) {
            self::init();
        }
        return self::$currencyName;
    }
    
    /**
     * Parse currency input to float
     * @param string $input
     * @return float
     */
    public static function parseAmount($input) {
        if (self::$currencyCode === null) {
            self::init();
        }
        
        // Remove currency symbol and spaces
        $cleaned = str_replace([self::$currencySymbol, ' '], '', $input);
        
        // Replace thousands separator with empty string
        $cleaned = str_replace(self::$thousandsSeparator, '', $cleaned);
        
        // Replace decimal separator with dot if different
        if (self::$decimalSeparator !== '.') {
            $cleaned = str_replace(self::$decimalSeparator, '.', $cleaned);
        }
        
        return (float)$cleaned;
    }
    
    /**
     * Get currency settings as array
     * @return array
     */
    public static function getSettings() {
        if (self::$currencyCode === null) {
            self::init();
        }
        
        return [
            'code' => self::$currencyCode,
            'symbol' => self::$currencySymbol,
            'name' => self::$currencyName,
            'decimal_places' => self::$decimalPlaces,
            'thousands_separator' => self::$thousandsSeparator,
            'decimal_separator' => self::$decimalSeparator,
            'symbol_position' => self::$symbolPosition
        ];
    }
    
    /**
     * Convert old currency values to new currency
     * This function can be used for migration if needed
     * @param float $amount
     * @param float $conversionRate
     * @return float
     */
    public static function convertCurrency($amount, $conversionRate = 1.0) {
        return (float)$amount * $conversionRate;
    }
}




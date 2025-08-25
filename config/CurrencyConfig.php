<?php
/**
 * Currency Configuration File
 * Edit this file to change currency settings for your locale
 */

class CurrencyConfig {
    
    // Available currency configurations
    public static $currencies = [
        'KES' => [
            'code' => 'KES',
            'symbol' => 'KSh',
            'name' => 'Kenyan Shilling',
            'decimal_places' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_position' => 'before'
        ],
        'USD' => [
            'code' => 'USD',
            'symbol' => '$',
            'name' => 'US Dollar',
            'decimal_places' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_position' => 'before'
        ],
        'EUR' => [
            'code' => 'EUR',
            'symbol' => '€',
            'name' => 'Euro',
            'decimal_places' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_position' => 'after'
        ],
        'GBP' => [
            'code' => 'GBP',
            'symbol' => '£',
            'name' => 'British Pound',
            'decimal_places' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_position' => 'before'
        ],
        'LKR' => [
            'code' => 'LKR',
            'symbol' => 'Rs',
            'name' => 'Sri Lankan Rupee',
            'decimal_places' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_position' => 'before'
        ],
        'INR' => [
            'code' => 'INR',
            'symbol' => '₹',
            'name' => 'Indian Rupee',
            'decimal_places' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_position' => 'before'
        ],
        'TZS' => [
            'code' => 'TZS',
            'symbol' => 'TSh',
            'name' => 'Tanzanian Shilling',
            'decimal_places' => 2,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_position' => 'before'
        ],
        'UGX' => [
            'code' => 'UGX',
            'symbol' => 'USh',
            'name' => 'Ugandan Shilling',
            'decimal_places' => 0,
            'thousands_separator' => ',',
            'decimal_separator' => '.',
            'symbol_position' => 'before'
        ]
    ];
    
    /**
     * Get currency configuration by code
     */
    public static function getCurrency($code) {
        return isset(self::$currencies[$code]) ? self::$currencies[$code] : self::$currencies['KES'];
    }
    
    /**
     * Get all available currencies
     */
    public static function getAllCurrencies() {
        return self::$currencies;
    }
    
    /**
     * Update .env file with new currency settings
     */
    public static function updateEnvFile($currencyCode) {
        $currency = self::getCurrency($currencyCode);
        $envFile = __DIR__ . '/../.env';
        
        if (file_exists($envFile)) {
            $lines = file($envFile, FILE_IGNORE_NEW_LINES);
            $newLines = [];
            
            foreach ($lines as $line) {
                if (strpos($line, 'CURRENCY_') === 0) continue;
                if (strpos($line, '#') === 0 || empty(trim($line))) {
                    $newLines[] = $line;
                    continue;
                }
                $newLines[] = $line;
            }
            
            // Add currency settings
            $newLines[] = '';
            $newLines[] = '# Currency Configuration';
            $newLines[] = 'CURRENCY_CODE=' . $currency['code'];
            $newLines[] = 'CURRENCY_SYMBOL=' . $currency['symbol'];
            $newLines[] = 'CURRENCY_NAME=' . $currency['name'];
            $newLines[] = 'CURRENCY_DECIMAL_PLACES=' . $currency['decimal_places'];
            $newLines[] = 'CURRENCY_THOUSANDS_SEPARATOR=' . $currency['thousands_separator'];
            $newLines[] = 'CURRENCY_DECIMAL_SEPARATOR=' . $currency['decimal_separator'];
            $newLines[] = 'CURRENCY_SYMBOL_POSITION=' . $currency['symbol_position'];
            
            file_put_contents($envFile, implode("\n", $newLines));
            return true;
        }
        
        return false;
    }
}
?>




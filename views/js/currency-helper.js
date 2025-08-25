/**
 * Currency Helper JavaScript Functions
 * Handles currency formatting on the client side
 */

// Currency settings - will be populated from PHP
var CurrencySettings = {
    code: 'KES',
    symbol: 'KSh',
    name: 'Kenyan Shilling',
    decimalPlaces: 2,
    thousandsSeparator: ',',
    decimalSeparator: '.',
    symbolPosition: 'before'
};

/**
 * Format amount as currency
 * @param {number} amount 
 * @param {boolean} includeSymbol 
 * @returns {string}
 */
function formatCurrency(amount, includeSymbol = true) {
    if (isNaN(amount) || amount === null || amount === undefined) {
        amount = 0;
    }
    
    var formattedAmount = parseFloat(amount).toFixed(CurrencySettings.decimalPlaces);
    
    // Add thousands separator
    formattedAmount = formattedAmount.replace(/\B(?=(\d{3})+(?!\d))/g, CurrencySettings.thousandsSeparator);
    
    // Replace decimal separator if different from dot
    if (CurrencySettings.decimalSeparator !== '.') {
        formattedAmount = formattedAmount.replace('.', CurrencySettings.decimalSeparator);
    }
    
    if (!includeSymbol) {
        return formattedAmount;
    }
    
    if (CurrencySettings.symbolPosition === 'before') {
        return CurrencySettings.symbol + ' ' + formattedAmount;
    } else {
        return formattedAmount + ' ' + CurrencySettings.symbol;
    }
}

/**
 * Parse currency string to float
 * @param {string} currencyString 
 * @returns {number}
 */
function parseCurrency(currencyString) {
    if (!currencyString) return 0;
    
    // Remove currency symbol and spaces
    var cleaned = currencyString.replace(new RegExp(CurrencySettings.symbol.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g'), '');
    cleaned = cleaned.replace(/\s/g, '');
    
    // Remove thousands separator
    cleaned = cleaned.replace(new RegExp('\\' + CurrencySettings.thousandsSeparator, 'g'), '');
    
    // Replace decimal separator with dot if different
    if (CurrencySettings.decimalSeparator !== '.') {
        cleaned = cleaned.replace(CurrencySettings.decimalSeparator, '.');
    }
    
    return parseFloat(cleaned) || 0;
}

/**
 * Format input field for currency
 * @param {HTMLInputElement} inputElement 
 */
function formatCurrencyInput(inputElement) {
    var value = parseCurrency(inputElement.value);
    inputElement.value = formatCurrency(value, false);
}

/**
 * Update currency settings from server
 * @param {object} settings 
 */
function updateCurrencySettings(settings) {
    CurrencySettings = Object.assign(CurrencySettings, settings);
}

/**
 * Initialize currency formatting for all currency input fields
 */
function initializeCurrencyInputs() {
    // Format all inputs with class 'currency-input'
    $(document).on('blur', '.currency-input', function() {
        formatCurrencyInput(this);
    });
    
    // Format all inputs with class 'currency-display'
    $('.currency-display').each(function() {
        var amount = parseCurrency($(this).text());
        $(this).text(formatCurrency(amount));
    });
    
    // Format all table cells with class 'currency-cell'
    $('.currency-cell').each(function() {
        var amount = parseCurrency($(this).text());
        $(this).text(formatCurrency(amount));
    });
}

/**
 * Calculate percentage and format as currency
 * @param {number} amount 
 * @param {number} percentage 
 * @returns {string}
 */
function calculatePercentage(amount, percentage) {
    var result = (amount * percentage) / 100;
    return formatCurrency(result);
}

/**
 * Calculate discount and return new amount
 * @param {number} originalAmount 
 * @param {number} discountPercentage 
 * @returns {number}
 */
function applyDiscount(originalAmount, discountPercentage) {
    return originalAmount * (1 - discountPercentage / 100);
}

// Initialize when document is ready
$(document).ready(function() {
    initializeCurrencyInputs();
});

// Export functions for global use
window.formatCurrency = formatCurrency;
window.parseCurrency = parseCurrency;
window.formatCurrencyInput = formatCurrencyInput;
window.updateCurrencySettings = updateCurrencySettings;
window.calculatePercentage = calculatePercentage;
window.applyDiscount = applyDiscount;




<!DOCTYPE html>
<html>
<head>
    <title>IOC Currency Setup</title>
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container" style="margin-top: 50px;">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">IOC System Currency Configuration</h3>
                    </div>
                    <div class="panel-body">
                        <?php
                        require_once '../config/CurrencyConfig.php';
                        require_once '../libs/CurrencyHelper.php';
                        
                        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['currency_code'])) {
                            $success = CurrencyConfig::updateEnvFile($_POST['currency_code']);
                            if ($success) {
                                echo '<div class="alert alert-success">Currency updated successfully! Please refresh the system to see changes.</div>';
                            } else {
                                echo '<div class="alert alert-danger">Failed to update currency configuration.</div>';
                            }
                        }
                        
                        CurrencyHelper::init();
                        $currentCurrency = CurrencyHelper::getCode();
                        $currencies = CurrencyConfig::getAllCurrencies();
                        ?>
                        
                        <form method="post">
                            <div class="form-group">
                                <label for="currency_code">Select Currency:</label>
                                <select class="form-control" id="currency_code" name="currency_code" onchange="updatePreview()">
                                    <?php foreach ($currencies as $code => $currency): ?>
                                        <option value="<?php echo $code; ?>" <?php echo ($code === $currentCurrency) ? 'selected' : ''; ?>>
                                            <?php echo $currency['name'] . ' (' . $currency['symbol'] . ')'; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            
                            <div class="panel panel-info">
                                <div class="panel-heading">Preview</div>
                                <div class="panel-body">
                                    <p><strong>Currency Code:</strong> <span id="preview-code"><?php echo $currentCurrency; ?></span></p>
                                    <p><strong>Symbol:</strong> <span id="preview-symbol"><?php echo CurrencyHelper::getSymbol(); ?></span></p>
                                    <p><strong>Sample Amount:</strong> <span id="preview-amount"><?php echo CurrencyHelper::format(1234.56); ?></span></p>
                                </div>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Currency</button>
                            <a href="../" class="btn btn-default">Back to System</a>
                        </form>
                        
                        <hr>
                        
                        <div class="panel panel-warning">
                            <div class="panel-heading">Migration Notice</div>
                            <div class="panel-body">
                                <p><strong>Important:</strong> If you are changing from an existing currency, you may need to run the migration script to convert existing values.</p>
                                <p>The migration script is located at: <code>migration/currency_migration.php</code></p>
                                <p>Run it from the command line: <code>php migration/currency_migration.php</code></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const currencies = <?php echo json_encode($currencies); ?>;
        
        function updatePreview() {
            const selectedCode = document.getElementById('currency_code').value;
            const currency = currencies[selectedCode];
            
            document.getElementById('preview-code').textContent = currency.code;
            document.getElementById('preview-symbol').textContent = currency.symbol;
            
            // Format sample amount
            const amount = 1234.56;
            let formatted = amount.toFixed(currency.decimal_places);
            formatted = formatted.replace(/\B(?=(\d{3})+(?!\d))/g, currency.thousands_separator);
            
            if (currency.decimal_separator !== '.') {
                formatted = formatted.replace('.', currency.decimal_separator);
            }
            
            if (currency.symbol_position === 'before') {
                formatted = currency.symbol + ' ' + formatted;
            } else {
                formatted = formatted + ' ' + currency.symbol;
            }
            
            document.getElementById('preview-amount').textContent = formatted;
        }
    </script>
</body>
</html>




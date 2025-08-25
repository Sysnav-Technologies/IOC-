<?php
/**
 * Sample implementation showing how to update existing views
 * Copy these patterns to update other view files
 */

// Include this at the top of your PHP files (usually done in header.php)
require_once 'libs/CurrencyHelper.php';

// Example: Update table headers to show currency symbol
echo '<th>Price (' . CurrencyHelper::getSymbol() . ')</th>';
echo '<th>Amount (' . CurrencyHelper::getSymbol() . ')</th>';

// Example: Format currency values in PHP
$price = 1500.00;
echo '<td class="currency-cell">' . CurrencyHelper::format($price) . '</td>';

// Example: Parse form input
if (isset($_POST['amount'])) {
    $amount = CurrencyHelper::parseAmount($_POST['amount']);
    // Now $amount is a clean float value
}

// Example: JavaScript integration in PHP views
?>
<script>
// Update JavaScript currency settings from PHP
updateCurrencySettings(<?php echo json_encode(CurrencyHelper::getSettings()); ?>);

// Format amounts on page load
$(document).ready(function() {
    $('.currency-display').each(function() {
        var amount = parseCurrency($(this).text());
        $(this).text(formatCurrency(amount));
    });
});

// Handle form submissions
$('#myForm').submit(function(e) {
    // Parse currency inputs before submitting
    var amount = parseCurrency($('#amount').val());
    $('#amount').val(amount); // Send clean number to server
});
</script>

<?php
/**
 * Common patterns for updating views:
 */

// 1. TABLE HEADERS - Update from:
// <th>Price(Rs)</th>
// To:
// <th>Price (<?php echo CurrencyHelper::getSymbol(); ?>)</th>

// 2. INPUT LABELS - Update from:
// <label>Amount</label>
// To:
// <label>Amount (<?php echo CurrencyHelper::getSymbol(); ?>)</label>

// 3. DISPLAY VALUES - Update from:
// <td><?php echo $row['amount']; ?></td>
// To:
// <td class="currency-cell"><?php echo CurrencyHelper::format($row['amount']); ?></td>

// 4. FORM INPUTS - Add currency formatting class:
// <input type="text" class="form-control currency-input" name="amount">

// 5. JAVASCRIPT CALCULATIONS - Update from:
// var amount = parseFloat($("#amount").val());
// To:
// var amount = parseCurrency($("#amount").val());

// 6. JAVASCRIPT DISPLAY - Update from:
// $("#total").text(total.toFixed(2));
// To:
// $("#total").text(formatCurrency(total));

// 7. FORM SUBMISSION - Update from:
// var amount = $("#amount").val();
// To:
// var amount = parseCurrency($("#amount").val());
?>

<!-- HTML Examples -->

<!-- Original input field -->
<!-- <input type="text" name="price" placeholder="Enter price"> -->

<!-- Updated input field -->
<input type="text" name="price" class="currency-input" placeholder="Enter price in <?php echo CurrencyHelper::getSymbol(); ?>">

<!-- Original table cell -->
<!-- <td>1500.00</td> -->

<!-- Updated table cell -->
<td class="currency-cell"><?php echo CurrencyHelper::format(1500.00); ?></td>

<!-- Example of a complete form field -->
<div class="form-group">
    <label for="amount">Amount (<?php echo CurrencyHelper::getSymbol(); ?>)</label>
    <input type="text" 
           class="form-control currency-input" 
           id="amount" 
           name="amount" 
           placeholder="0.00">
</div>

<script>
// Example of handling the form submission
$('#transactionForm').submit(function(e) {
    e.preventDefault();
    
    var formData = {
        customer_name: $('#customer_name').val(),
        amount: parseCurrency($('#amount').val()), // Parse currency before sending
        date: $('#date').val()
    };
    
    $.post('process_transaction.php', formData, function(response) {
        if (response.success) {
            swal("Success!", "Transaction added successfully!", "success");
            // Refresh or redirect as needed
        }
    });
});
</script>




<?php
/**
 * Fix Script: Array Initialization Bug
 * This script fixes the issue where variables are initialized as empty strings 
 * but later used with array append operator []
 */

$modelsPath = __DIR__ . '/models/';
$files = glob($modelsPath . '*.php');

$fixedCount = 0;
$totalFiles = 0;

foreach ($files as $file) {
    $totalFiles++;
    $content = file_get_contents($file);
    $originalContent = $content;
    
    // Pattern to match variables initialized as empty string followed by array usage
    $patterns = [
        // Match: $variable = ''; followed later by $variable[] = 
        '/(\$\w+)\s*=\s*\'\';\s*\n((?:.*\n)*?)(\s*while\s*\([^)]+\)\s*\{\s*\n\s*\1\[\]\s*=)/m',
        // Alternative pattern for different formatting
        '/(\$\w+)\s*=\s*\'\';\s*\n((?:.*\n)*?)(\1\[\]\s*=)/m'
    ];
    
    foreach ($patterns as $pattern) {
        $content = preg_replace_callback($pattern, function($matches) {
            $varName = $matches[1];
            $middleContent = $matches[2];
            $arrayUsage = $matches[3];
            
            // Replace empty string initialization with empty array
            $newInit = str_replace("= '';", "= []; // Fixed: Initialize as array", $varName . " = '';");
            
            return $newInit . "\n" . $middleContent . $arrayUsage;
        }, $content);
    }
    
    // Simple replacement for obvious cases
    $simpleReplacements = [
        '/(\$\w+)\s*=\s*\'\';\s*$/m' => function($matches) use ($content) {
            $varName = $matches[1];
            // Check if this variable is used with [] later in the file
            if (preg_match('/' . preg_quote($varName) . '\[\]\s*=/', $content)) {
                return $varName . ' = []; // Fixed: Initialize as array';
            }
            return $matches[0]; // No change if not used as array
        }
    ];
    
    foreach ($simpleReplacements as $pattern => $replacement) {
        $content = preg_replace_callback($pattern, $replacement, $content);
    }
    
    if ($content !== $originalContent) {
        file_put_contents($file, $content);
        $fixedCount++;
        echo "Fixed: " . basename($file) . "\n";
    }
}

echo "\nSummary:\n";
echo "Total files checked: $totalFiles\n";
echo "Files fixed: $fixedCount\n";
echo "Fix complete!\n";
?>

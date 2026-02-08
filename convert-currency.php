<?php

/**
 * Script to convert all USD currency formatting to Sri Lankan Rupees
 */

$viewsPath = __DIR__ . '/resources/views';

// Pattern to match: ${{ number_format($variable, 2) }}
$pattern = '/\$\{\{\s*number_format\((\$[a-zA-Z_\[\]\'->]+),\s*2\)\s*\}\}/';
$replacement = '{{ format_currency($1) }}';

// Get all blade files
$iterator = new RecursiveIteratorIterator(
    new RecursiveDirectoryIterator($viewsPath)
);

$bladeFiles = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $bladeFiles[] = $file->getPathname();
    }
}

echo "Found " . count($bladeFiles) . " blade files\n\n";

$updatedFiles = 0;
$totalReplacements = 0;

foreach ($bladeFiles as $filePath) {
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Replace the pattern
    $newContent = preg_replace($pattern, $replacement, $content, -1, $count);
    
    if ($count > 0) {
        file_put_contents($filePath, $newContent);
        $updatedFiles++;
        $totalReplacements += $count;
        echo "✓ Updated: " . basename($filePath) . " ($count replacements)\n";
    }
}

echo "\n=== Summary ===\n";
echo "Files updated: $updatedFiles\n";
echo "Total replacements: $totalReplacements\n";
echo "\nAll USD ($) currency symbols have been replaced with format_currency() helper!\n";

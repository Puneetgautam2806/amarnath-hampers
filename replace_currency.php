<?php
$directory = new RecursiveDirectoryIterator('c:/xampp/htdocs/gift_eshop/resources/views');
$iterator = new RecursiveIteratorIterator($directory);
$files = new RegexIterator($iterator, '/^.+\.blade\.php$/i', RecursiveRegexIterator::GET_MATCH);

foreach ($files as $file) {
    $path = $file[0];
    $content = file_get_contents($path);
    $original = $content;
    
    // Replace ${{ ... }} with ₹ {{ ... }}
    $content = preg_replace('/\$(\s*\{\{\s*number_format)/', '₹$1', $content);
    $content = preg_replace('/\$(\s*\{\{\s*\$)/', '₹$1', $content);

    // Replace >$number with >₹number
    $content = preg_replace('/>\$([0-9]+)/', '>₹$1', $content);
    // Replace >$ {{ with >₹ {{
    $content = preg_replace('/>\$\{\{/', '>₹{{', $content);
    // Any remaining >$
    $content = str_replace('>$', '>₹', $content);
    
    // Replace >$< with >₹<
    $content = str_replace('>$<', '>₹<', $content);

    // Some places might have <span>$
    $content = str_replace('<span>$', '<span>₹', $content);
    $content = str_replace('<del>$', '<del>₹', $content);
    
    // Check specific strings from app.blade.php dropdown
    $content = str_replace('<i class="fas fa-usd"></i> USD', '<i class="fas fa-rupee-sign"></i> INR', $content);
    $content = str_replace('<a class="dropdown-item" href="#">USD</a>', '<a class="dropdown-item" href="#">INR</a>', $content);
    
    if ($content !== $original) {
        file_put_contents($path, $content);
        echo "Updated $path\n";
    }
}
echo "Done.\n";

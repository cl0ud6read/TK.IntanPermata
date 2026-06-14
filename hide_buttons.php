<?php

$dir = 'c:\laravel10\inventory-management-system-main\resources\views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getFilename() === 'index.blade.php') {
        $content = file_get_contents($file->getPathname());
        
        // Find if there's an unwrapped <x-primary-button ...> ... </x-primary-button>
        // and wrap it.
        $pattern = '/(<x-primary-button[^>]*>.*?<\/x-primary-button>)/s';
        
        if (preg_match_all($pattern, $content, $matches)) {
            $changed = false;
            foreach ($matches[1] as $buttonText) {
                // Check if it's already wrapped in @if(auth()->user()->role === 'admin')
                // This is a naive check but works for this specific codebase
                if (strpos($content, "@if(auth()->user()->role === 'admin')\n            " . $buttonText) === false &&
                    strpos($content, "@if(auth()->user()->role === 'admin')" . $buttonText) === false &&
                    strpos($buttonText, 'heroicon-o-plus') !== false) {
                    
                    $replacement = "@if(auth()->user()->role === 'admin')\n            " . trim($buttonText) . "\n            @endif";
                    $content = str_replace($buttonText, $replacement, $content);
                    $changed = true;
                }
            }
            if ($changed) {
                file_put_contents($file->getPathname(), $content);
                echo "Wrapped button in: " . $file->getPathname() . "\n";
            }
        }
    }
}
echo "Done.\n";

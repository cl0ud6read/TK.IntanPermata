<?php

$dir = 'c:\laravel10\inventory-management-system-main\app\Livewire';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($dir));

$replacements = [
    // Messages
    "'Customer updated successfully.'" => "'Pelanggan berhasil diperbarui.'",
    "'Customer created successfully.'" => "'Pelanggan berhasil dibuat.'",
    "'Supplier updated successfully.'" => "'Pemasok berhasil diperbarui.'",
    "'Supplier created successfully.'" => "'Pemasok berhasil dibuat.'",
    "'Category updated successfully.'" => "'Kategori berhasil diperbarui.'",
    "'Category created successfully.'" => "'Kategori berhasil dibuat.'",
    "'Unit updated successfully.'" => "'Satuan berhasil diperbarui.'",
    "'Unit created successfully.'" => "'Satuan berhasil dibuat.'",
    "'Product updated successfully.'" => "'Produk berhasil diperbarui.'",
    "'Product created successfully.'" => "'Produk berhasil dibuat.'",
    "'Finance Category updated successfully.'" => "'Kategori Keuangan berhasil diperbarui.'",
    "'Finance Category created successfully.'" => "'Kategori Keuangan berhasil dibuat.'",
    "'Transaction updated successfully.'" => "'Transaksi berhasil diperbarui.'",
    "'Transaction recorded successfully.'" => "'Transaksi berhasil dicatat.'",
    "'Settings updated successfully.'" => "'Pengaturan berhasil disimpan.'",
    "'User updated successfully.'" => "'Pengguna berhasil diperbarui.'",
    "'User created successfully.'" => "'Pengguna berhasil dibuat.'",
    
    // Errors
    "'Error: '" => "'Terjadi kesalahan: '",
];

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $content = file_get_contents($file->getPathname());
        $original = $content;
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        if ($content !== $original) {
            file_put_contents($file->getPathname(), $content);
            echo "Translated: " . $file->getFilename() . "\n";
        }
    }
}
echo "Done.\n";

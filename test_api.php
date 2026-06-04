<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);

$request = Illuminate\Http\Request::create('/ajax/customers/store', 'POST', [
    'name' => 'Test Customer',
    'phone' => '123456789'
]);
$response = $kernel->handle($request);
echo "STATUS: " . $response->getStatusCode() . "\n";
echo "CONTENT: " . $response->getContent() . "\n";

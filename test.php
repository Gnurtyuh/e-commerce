<?php
$request = new \Illuminate\Http\Request();
$request->merge(["name" => "Demo Product", "categoryId" => 1, "description" => "A demo product", "status" => "ACTIVE"]);
$controller = app(\App\Http\Controllers\Admin\ProductController::class);
try {
    $controller->store($request);
    echo "Success`n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "`n";
}

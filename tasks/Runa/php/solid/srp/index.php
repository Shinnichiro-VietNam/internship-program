<?php
require_once 'srp_good.php';

// 1. Data
$order = [
    "customer" => "John Doe",
    "items" => [
        ["price" => 20, "quantity" => 2],
        ["price" => 15, "quantity" => 1],
    ],
];

// 2. Setup
$cal = new OrderCal();
$log = new OrderLog();
$show = new OrderShow();

// 3. Execution
$total = $cal->calculateTotal($order["items"]); // Calculate total
$log->saveLog($order["customer"], $total);          // Save log
$show->showReceipt($order["customer"], $total);      // Display HTML
<?php

/**
 * * 【悪い点（Bad）】
* 1. 計算 /calculate the total amount
* 2. 保存 /save to text file
* 3. 表示 /display HTML output
* These three different responsibilities are mixed in one process() method.
*/

class OrderProcessor
{
    public function process(array $order): void
    {
        $total = 0;

        foreach ($order["items"] as $item) {
            $total += $item["price"] * $item["quantity"];
        }

        echo "Order total: $" . $total . PHP_EOL;

        $file = fopen("order_log.txt", "a");
        fwrite($file, "Customer: " . $order["customer"] . ", Total: $" . $total . PHP_EOL);
        fclose($file);

        echo "<h1>Order Receipt</h1>";
        echo "<p>Customer: " . $order["customer"] . "</p>";
        echo "<p>Total: $" . $total . "</p>";
    }
}

$processor = new OrderProcessor();
$processor->process([
    "customer" => "John Doe",
    "items" => [
        ["price" => 20, "quantity" => 2],
        ["price" => 15, "quantity" => 1],
    ],
]);

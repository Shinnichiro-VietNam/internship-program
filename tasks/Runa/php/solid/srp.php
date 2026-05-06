<?php

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

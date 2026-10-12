<?php
/**
 * * 【修正のポイント（Good）】
 * - 合計金額の計算ロジックを独立させる
 *    - By separating the calculation logic, we can make it easier to modify and reuse.
 * - ファイル保存処理を専用クラスに切り出す
 *    - By extracting the file saving process to a dedicated class, we can make it easier to modify and reuse.
 * - HTML表示をテンプレート化または専用クラスに任せる
 *    - By letting the HTML display be handled by a template or a dedicated class, we can make it easier to modify and reuse.
 */

class OrderCal {
    public function calculateTotal(array $items): float {
        $total = 0;
        foreach ($items as $item) {
            $total += $item["price"] * $item["quantity"];
        }
        return $total;
    }
}

class OrderLog {
    public function saveLog(string $customer, float $total): void {
        $file = fopen("order_log.txt", "a");
        fwrite($file, "Customer: " . $customer . ", Total: $" . $total . PHP_EOL);
        fclose($file);
    }
}

class OrderShow {
    public function showReceipt(string $customer, float $total): void {
        echo "<h1>Order Receipt</h1>";
        echo "<p>Customer: " . $customer . "</p>";
        echo "<p>Total: $" . $total . "</p>";
    }
}


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
$total = $cal->calculateTotal($order["items"]);
$log->saveLog($order["customer"], $total);
$show->showReceipt($order["customer"], $total);
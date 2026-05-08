<?php

/**
 * 【良い点（Good）】
 * 1. インターフェースを機能ごとに分けることで、不要なメソッドの実装を強制しない
 * Separate interfaces by function so that implementation of unnecessary methods is not forced.
 * 2. クラスが必要な機能だけを「選んで」実装できるため、コードがスッキリする
 * Classes can "choose" only the functions they need, making the code cleaner.
 */

interface Codable {
    public function code(): void;
}

interface Testable {
    public function test(): void;
}

interface Deployable {
    public function deploy(): void;
}

class Developer implements Codable, Testable {
    public function code(): void {
        echo "Writing code." . PHP_EOL;
    }

    public function test(): void {
        echo "Running unit tests." . PHP_EOL;
    }
}


class DevOpsEngineer implements Deployable {
    public function deploy(): void {
        echo "Deploying the application." . PHP_EOL;
    }
}

$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'] ?? '';
    ob_start();

    if ($role === 'dev') {
        $dev = new Developer();
        $dev->code();
        $dev->test();
    } elseif ($role === 'devops') {
        $devOps = new DevOpsEngineer();
        $devOps->deploy();
    }

    $result = ob_get_clean();
}
?>

<!DOCTYPE html>
<html lang="ja">
<head><title>ISP Demo</title></head>
<body>
    <h2>エンジニアの働き (ISP)</h2>

    <form method="POST">
        職種を選択:
        <select name="role">
            <option value="dev">コーダー</option>
            <option value="devops">デプロイャー</option>
        </select>
        <button type="submit">動く</button>
    </form>

    <?php if ($result): ?>
        <p><strong>結果:</strong><br><?php echo nl2br(htmlspecialchars($result)); ?></p>
    <?php endif; ?>

</body>
</html>
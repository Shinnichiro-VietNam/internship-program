<?php
/**
 * 【良い点（Good）】
 * 1. 飛べる鳥(Flyable)とそうでない鳥を分けることで、予期せぬエラーを防ぐ
 *    - By distinguishing between birds that can fly and those that cannot, unexpected errors can be prevented.
 * 2. 共通の親クラスの機能は、どの鳥でも安全に入れ替え可能
 *    - The common parent class features can be safely swapped between any bird.
 */

class Bird {
    public function eat(): string {
        return "Eating food...";
    }
}

interface Flyable {
    public function fly(): string;
}

class Sparrow extends Bird implements Flyable {
    public function fly(): string {
        return "Sparrow is flying high!";
    }
}

class Penguin extends Bird {
    public function swim(): string {
        return "Penguin is swimming fast!";
    }
}

$result = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? '';

    if ($type === 'sparrow') {
        $bird = new Sparrow();
        $result = $bird->eat() . " " . $bird->fly();
    } elseif ($type === 'penguin') {
        $bird = new Penguin();
        $result = $bird->eat() . " " . $bird->swim();
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head><title>LSP Demo</title></head>
<body>
    <h2>鳥の動き (LSP)</h2>

    <form method="POST">
        鳥を選択:
        <select name="type">
            <option value="sparrow">Sparrow</option>
            <option value="penguin">Penguin</option>
        </select>
        <button type="submit">動く</button>
    </form>

    <?php if ($result): ?>
        <p><strong>結果:</strong> <?php echo htmlspecialchars($result); ?></p>
    <?php endif; ?>
</body>
</html>
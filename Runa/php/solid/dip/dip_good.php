<?php
/**
 * 【良い点（Good）】
 * 1. 抽象(Interface)に依存させることで、特定のDBとの結合を断ち切った
 *    - By relying on abstraction, we severed the ties to a specific database
 * 2. 依存性の注入(DI)により、外部から使用するDBを自由に差し替え可能
 *    - By injecting dependencies, we can freely replace the database used by the external user
 */

interface Database {
    public function save(string $name): string;
}

class MySQLDatabase implements Database {
    public function save(string $name): string {
        return "MySQL: User $name saved.";
    }
}

class UserService {
    public function __construct(private Database $db) {}

    public function register(string $name): string {
        return $this->db->save($name) . " (Process Complete)";
    }
}

$result = "";
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $service = new UserService(new MySQLDatabase());
    $result = $service->register($_POST['name'] ?? 'Guest');
}
?>
<!DOCTYPE html>
<html lang="ja">
<body>
    <h2>User Registration (DIP)</h2>
    <form method="POST">
        Name: <input type="text" name="name" required>
        <button type="submit">Register</button>
    </form>

    <?php if ($result): ?>
        <p><strong>Result:</strong> <?php echo htmlspecialchars($result); ?></p>
    <?php endif; ?>
</body>
</html>
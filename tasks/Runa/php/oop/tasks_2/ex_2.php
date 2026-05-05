<?php
declare(strict_types=1);
class Candidate{
    private int $id;
    private string $name;
    private string $dob;
    private int $math;
    private int $english;
    private int $literature;

    public function __construct(int $id, string $name, string $dob, int $math, int $literature, int $english){
        $this->id = $id;
        $this->name = $name;
        $this->dob = $dob;
        $this->math = $math;
        $this->literature = $literature;
        $this->english = $english;
    }

    public function calculateTotalScore(): int {
        return $this->math + $this->english + $this->literature;
    }

    public function displayInfo(): string {
        $total = $this->calculateTotalScore();
        return "ID: {$this->id}, Name: {$this->name}, DoB: {$this->dob}, Math: {$this->math}, Literature: {$this->literature}, English: {$this->english}, Total: {$total}";
    }

}

class TestCandidate {
    private array $candidates = [];

    public function handleInput(array $rawCandidates): void {
        $this->candidates = [];

        foreach ($rawCandidates as $raw) {
            $id = isset($raw['id']) ? (int) $raw['id'] : 0;
            $name = isset($raw['name']) ? trim((string) $raw['name']) : '';
            $dob = isset($raw['dob']) ? trim((string) $raw['dob']) : '';
            $math = isset($raw['math']) ? (int) $raw['math'] : 0;
            $literature = isset($raw['literature']) ? (int) $raw['literature'] : 0;
            $english = isset($raw['english']) ? (int) $raw['english'] : 0;

            if ($id <= 0 || $name === '' || $dob === '') {
                continue;
            }

            $this->candidates[] = new Candidate($id, $name, $dob, $math, $literature, $english);
        }
    }

    public function filterPassingCandidates(): array {
        return array_filter($this->candidates, function (Candidate $candidate) {
            return $candidate->calculateTotalScore() > 15;
        });
    }
}

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ex_2</title>
</head>
<body>
    <header>
        <h1>Candidate Management</h1>
    </header>
    <?php
    function h(string $value): string {
        return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
    $step = ($method === 'POST' && isset($_POST['step'])) ? (string) $_POST['step'] : 'n';

    $n = 0;
    if ($method === 'POST' && isset($_POST['n'])) {
        $n = max(0, (int) $_POST['n']);
    }

    if ($step === 'n') {
        ?>
        <main>
            <form method="post">
                人数 n:
                <input id="n" type="number" name="n" min="1" max="50" required>
                <input type="hidden" name="step" value="details">
                <button type="submit">Submit</button>
            </form>
        </main>
        <?php
    } elseif ($step === 'details') {
        if ($n <= 0) {
            $n = 1;
        }
        ?>
        <main>
            <form method="post">
                <input type="hidden" name="step" value="result">
                <input type="hidden" name="n" value="<?= h((string) $n) ?>">

                <p>情報を入力してください（合計が15点より大きい人だけ表示します）</p>

                <?php for ($i = 0; $i < $n; $i++): ?>
                    <h3>Candidate <?= h((string) ($i + 1)) ?></h3>
                    ID: <input type="number" name="candidates[<?= $i ?>][id]" min="1" required><br>
                    Name: <input type="text" name="candidates[<?= $i ?>][name]" required><br>
                    Date of Birth: <input type="text" name="candidates[<?= $i ?>][dob]" placeholder="YYYY-MM-DD" required><br>
                    Math: <input type="number" name="candidates[<?= $i ?>][math]" min="0" max="10" required><br>
                    Literature: <input type="number" name="candidates[<?= $i ?>][literature]" min="0" max="10" required><br>
                    English: <input type="number" name="candidates[<?= $i ?>][english]" min="0" max="10" required><br>
                    <br>
                <?php endfor; ?>

                <button type="submit">判定する</button>
                <button type="submit" name="step" value="n">人数からやり直す</button>
            </form>
        </main>
        <?php
    } elseif ($step === 'result') {
        $rawCandidates = [];
        if (isset($_POST['candidates']) && is_array($_POST['candidates'])) {
            $rawCandidates = $_POST['candidates'];
        }

        $testCandidate = new TestCandidate();
        $testCandidate->handleInput($rawCandidates);
        $passingCandidates = $testCandidate->filterPassingCandidates();

        ?>
        <footer>
            <h2>結果（合計 > 15）</h2>
            <?php if (count($passingCandidates) === 0): ?>
                該当者はいませんでした。<br>
            <?php else: ?>
                <?php foreach ($passingCandidates as $candidate): ?>
                    <?= h($candidate->displayInfo()) ?><br>
                <?php endforeach; ?>
            <?php endif; ?>

            <form method="post">
                <button type="submit" name="step" value="n">最初から</button>
            </form>
        </footer>
        <?php
    }
    ?>
</body>
</html>
<?php
class CustomDate {
    private $day;
    private $month;
    private $year;

    public function __construct($day, $month, $year) {
        if (!checkdate($month, $day, $year)) {
            throw new Exception ("Enter date in current format.");
        }
        $this -> day = $day;
        $this -> month = $month;
        $this -> year = $year;
    }

    public function isValidDate() {
        return checkdate($this -> month, $this -> day, $this -> year);
    }

    public function isLeapYear() {
        if ($this -> year % 400 == 0) {
            return true;
        } else if ($this -> year % 100 == 0) {
            return false;
        } else if ($this -> year % 4 == 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getNextDate() {
        $nextDay = $this -> day;
        $nextMonth = $this -> month;
        $nextYear = $this -> year;

        $maxDays = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

        if ($this -> isLeapYear()) {
            $maxDays[1] = 29;
        }

        $nextDay++;

        if ($nextDay > $maxDays[$this -> month -1]) {
            $nextDay = 1;
            $nextMonth++;

            if ($nextMonth > 12) {
                $nextMonth = 1;
                $nextYear++;
            }
        }

        return new CustomDate($nextDay, $nextMonth, $nextYear);

    }

    public function display() {
        return "{$this -> year}-{$this -> month}-{$this -> day}";
    }
}
?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $day = $_POST["day"];
        $month = $_POST["month"];
        $year = $_POST["year"];
        $date = new CustomDate($day, $month, $year);
        $nextDate = $date -> getNextDate();
        $results = $nextDate -> display();
    } catch (Exception $e) {
        $results = $e -> getMessage();
    }
}
?>








<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Next Date Calculation</title>
</head>
<body>
    <header>
        <h1>Next Date Calculation</h1>
    </header>

    <main>
        <section>
            <form method="post">
                <div>
                    <label>Year:</label>
                    <input type="number" name="year" placeholder="yyyy" required>
                </div>
                <div>
                    <label>Month:</label>
                    <input type="number" name="month" placeholder="mm" required>
                </div>
                <div>
                    <label>Day:</label>
                    <input type="number" name="day" placeholder="dd" required>
                </div>
                <button type="submit">Calculate Next Date</button>
            </form>

            <div>
                <?php if(isset($results)): ?>
                    <h3>Next Date</h3>
                    <p><?php echo $results; ?></p>
                <?php endif; ?>
            </div>
        </section>
    </main>

    <footer>
    </footer>
</body>
</html>
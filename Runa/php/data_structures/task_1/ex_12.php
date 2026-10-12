<?php
declare(strict_types=1);

class Graph {
    private array $adjList = [];

    public function addVertex(string|int $id): void {
        if (!isset($this->adjList[$id])) {
            $this->adjList[$id] = [];
        }
    }

    public function addEdge(string|int $a, string|int $b): void {
        $this->addVertex($a);
        $this->addVertex($b);
        $this->adjList[$a][] = $b;
        $this->adjList[$b][] = $a;
    }

    public function getNeighbors(string|int $id): array {
        return $this->adjList[$id] ?? [];
    }

    public function bfs(string|int $start): array {
        if (!isset($this->adjList[$start])) return [];

        $visitOrder = [];
        $visited = [];
        $queue = [];

        $queue[] = $start;
        $visited[$start] = true;

        while (!empty($queue)) {
            $curr = array_shift($queue);
            $visitOrder[] = $curr;

            foreach ($this->getNeighbors($curr) as $x) {
                if (!isset($visited[$x])) {
                    $visited[$x] = true;
                    $queue[] = $x;
                }
            }
        }

        return $visitOrder;
    }


    public function dfs(string|int $start): array {
        if (!isset($this->adjList[$start])) return [];

        $visitOrder = [];
        $visited = [];

        // 再帰関数を呼び出す
        $this->dfsRec($start, $visited, $visitOrder);

        return $visitOrder;
    }

    // JavaScriptの dfsRec と全く同じロジック
    private function dfsRec(string|int $s, array &$visited, array &$res): void {
        $visited[$s] = true;
        $res[] = $s;

        foreach ($this->getNeighbors($s) as $i) {
            if (!isset($visited[$i])) {
                $this->dfsRec($i, $visited, $res);
            }
        }
    }

    public function shortestPathLength(string|int $start, string|int $target): int {
        if (!isset($this->adjList[$start]) || !isset($this->adjList[$target])) {
            return -1;
        }
        if ($start === $target) {
            return 0;
        }

        $queue = [$start];
        $distances = [$start => 0];
        $front = 0;

        while (!empty($queue)) {
            $curr = $queue[$front++];

            if ($curr === $target) {
                return $distances[$curr];
            }

            foreach ($this->getNeighbors($curr) as $x) {
                if (!isset($distances[$x])) {
                    $distances[$x] = $distances[$curr] + 1;
                    $queue[] = $x;
                }
            }
        }

        return -1;
    }
}

// ==========================================
// Testing
// ==========================================
$graph = new Graph();
$graph->addEdge(1, 2);
$graph->addEdge(1, 0);
$graph->addEdge(2, 0);
$graph->addEdge(2, 3);
$graph->addEdge(2, 4);

echo "BFS Order: [" . implode(' ', $graph->bfs(0)) . "]\n";
echo "DFS Order: [" . implode(' ', $graph->dfs(0)) . "]\n\n";

echo "Path 0 to 3: " . $graph->shortestPathLength(0, 3) . " (Expected: 2 / 0->2->3)\n";
echo "Path 1 to 4: " . $graph->shortestPathLength(1, 4) . " (Expected: 2 / 1->2->4)\n";
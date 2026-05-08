<?php

/**
 * * 【悪い点（Bad）】
 * 1. Bird を Penguin に置き換えた途端、エラーで止まる
 * If you want to add a new bird that cannot fly, you need to modify the Bird class
 */

class Bird
{
    public function fly(): void
    {
        echo "Flying in the sky." . PHP_EOL;
    }
}

class Sparrow extends Bird
{
    public function fly(): void
    {
        echo "Sparrow is flying." . PHP_EOL;
    }
}

class Penguin extends Bird
{
    public function fly(): void
    {
        throw new Exception("Penguins cannot fly.");
    }
}

function makeBirdFly(Bird $bird): void
{
    $bird->fly();
}

makeBirdFly(new Sparrow());
makeBirdFly(new Penguin());

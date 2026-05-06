<?php

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

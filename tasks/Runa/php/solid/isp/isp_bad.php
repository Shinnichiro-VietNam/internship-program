<?php

interface Worker
{
    public function code(): void;

    public function test(): void;

    public function deploy(): void;
}

class Developer implements Worker
{
    public function code(): void
    {
        echo "Writing code." . PHP_EOL;
    }

    public function test(): void
    {
        echo "Running unit tests." . PHP_EOL;
    }

    public function deploy(): void
    {
        echo "I do not deploy, but I must implement this method." . PHP_EOL;
    }
}

class DevOpsEngineer implements Worker
{
    public function code(): void
    {
        echo "I do not code features, but I must implement this method." . PHP_EOL;
    }

    public function test(): void
    {
        echo "I do not run app tests, but I must implement this method." . PHP_EOL;
    }

    public function deploy(): void
    {
        echo "Deploying the application." . PHP_EOL;
    }
}

$developer = new Developer();
$developer->code();
$developer->deploy();

$devOps = new DevOpsEngineer();
$devOps->deploy();

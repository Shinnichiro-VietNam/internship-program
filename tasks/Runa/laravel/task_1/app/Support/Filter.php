<?php

namespace App\Support;

final class Filter
{
    public static function filled(array $filters, string $key): bool
    {
        return array_key_exists($key, $filters)
            && $filters[$key] !== null
            && $filters[$key] !== '';
    }
}

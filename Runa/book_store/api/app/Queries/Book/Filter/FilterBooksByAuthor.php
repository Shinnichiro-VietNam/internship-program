<?php

namespace App\Queries\Book\Filter;

use Illuminate\Database\Eloquent\Builder;

final class FilterBooksByAuthor
{
    public function apply(Builder $query, ?string $author): Builder
    {
        if ($author === null || $author === "") {
            return $query;
        }
        return $query->where('author', 'like', '%' . $author . '%');
    }
}
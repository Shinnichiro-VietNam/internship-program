<?php

namespace App\Actions\Book;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

final class ListBooks
{
    public function handle(array $filters): Collection|LengthAwarePaginator
    {
        $query = Book::query()
            ->when(
                ! empty($filters['author']),
                fn ($q) => $q->where('author', 'like', '%' . $filters['author'] . '%')
            )
            ->when(
                isset($filters['min_price']) && $filters['min_price'] !== '',
                fn ($q) => $q->where('price', '>=', $filters['min_price'])
            )
            ->when(
                isset($filters['max_price']) && $filters['max_price'] !== '',
                fn ($q) => $q->where('price', '<=', $filters['max_price'])
            )
            ->orderBy('book_id', 'asc');

        if (! empty($filters['page'])) {
            $perPage = min((int) ($filters['per_page'] ?? 15), 50);

            return $query->paginate($perPage);
        }

        return $query->get();
    }
}

<?php

namespace App\Actions\Book;

use App\Models\Book;
use App\Support\Filter;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;

final class ListBooks
{
    public function handle(array $filters): Collection|LengthAwarePaginator
    {
        $query = Book::query()
            ->when(
                Filter::filled($filters, 'author'),
                fn (Builder $query) => $query->where('author', 'like', '%' . $filters['author'] . '%')
            )
            ->when(
                Filter::filled($filters, 'min_price'),
                fn (Builder $query) => $query->where('price', '>=', $filters['min_price'])
            )
            ->when(
                Filter::filled($filters, 'max_price'),
                fn (Builder $query) => $query->where('price', '<=', $filters['max_price'])
            )
            ->orderBy('book_id', 'asc');

        if (Filter::filled($filters, 'page')) {
            $perPage = min((int) ($filters['per_page'] ?? 15), 50);

            return $query->paginate($perPage);
        }

        return $query->get();
    }
}

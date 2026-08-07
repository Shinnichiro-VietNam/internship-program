<?php

namespace App\Policies;

use App\Models\Book;
use App\Models\User;

class BookPolicy
{
    public function viewAny(?User $user): bool
    {
        return true;
    }

    public function view(?User $user, Book $book): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->isReader() || $user->isAdmin();
    }

    public function update(User $user, Book $book): bool
    {
        return $user->isReader() || $user->isAdmin();
    }

    public function delete(User $user, Book $book): bool
    {
        return $user->isAdmin();
    }
}

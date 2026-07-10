<?php
namespace Repositories;

interface BookRepositoryInterface {

    public function all(): array;

    public function save(array $books): bool;
}
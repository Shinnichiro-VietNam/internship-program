<?php

namespace Tests\Unit\Policies;

use App\Models\Book;
use App\Models\User;
use App\Policies\BookPolicy;
use PHPUnit\Framework\TestCase;

class BookPolicyTest extends TestCase
{
    private BookPolicy $policy;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new BookPolicy;
    }

    public function test_guest_can_view_any_books(): void
    {
        $this->assertTrue($this->policy->viewAny(null));
    }

    public function test_guest_can_view_a_book(): void
    {
        $this->assertTrue($this->policy->view(null, new Book));
    }

    public function test_reader_can_create_and_update_books(): void
    {
        $reader = new User(['role' => 'reader']);
        $book = new Book;

        $this->assertTrue($this->policy->create($reader));
        $this->assertTrue($this->policy->update($reader, $book));
    }

    public function test_reader_cannot_delete_a_book(): void
    {
        $reader = new User(['role' => 'reader']);

        $this->assertFalse($this->policy->delete($reader, new Book));
    }

    public function test_admin_can_create_update_and_delete_books(): void
    {
        $admin = new User(['role' => 'admin']);
        $book = new Book;

        $this->assertTrue($this->policy->create($admin));
        $this->assertTrue($this->policy->update($admin, $book));
        $this->assertTrue($this->policy->delete($admin, $book));
    }
}

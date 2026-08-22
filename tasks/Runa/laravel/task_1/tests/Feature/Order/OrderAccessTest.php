<?php

namespace Tests\Feature\Order;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_list_orders(): void
    {
        Order::factory()->create();

        $response = $this->getJson('/api/orders');

        $response->assertStatus(401)
            ->assertJsonPath('errors.code', 'UNAUTHORIZED');
    }

    public function test_reader_can_list_orders(): void
    {
        $this->actingAsReader();
        $customer = Customer::factory()->create(['full_name' => 'Order Customer']);
        Order::factory()->create(['customer_id' => $customer->customer_id]);

        $response = $this->getJson('/api/orders');

        $response->assertStatus(200)
            ->assertJsonPath('status', 200)
            ->assertJsonCount(1, 'data')
            ->assertJsonPath('data.0.customer.full_name', 'Order Customer');
    }

    public function test_reader_can_show_an_order(): void
    {
        $this->actingAsReader();
        $order = Order::factory()->create(['status' => 'paid']);

        $response = $this->getJson("/api/orders/{$order->order_id}");

        $response->assertStatus(200)
            ->assertJsonPath('data.id', $order->order_id)
            ->assertJsonPath('data.status', 'paid');
    }

    public function test_show_unknown_order_returns_not_found(): void
    {
        $this->actingAsReader();

        $response = $this->getJson('/api/orders/999999');

        $response->assertStatus(404)
            ->assertJsonPath('errors.code', 'NOT_FOUND');
    }
}

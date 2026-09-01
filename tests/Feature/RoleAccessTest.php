<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_kasir_can_access_cashier_but_not_stock_management(): void
    {
        $user = User::factory()->create(['role' => 'kasir']);

        $this->actingAs($user)->get('/kasir')->assertOk();
        $this->actingAs($user)->get('/gudang/stok')->assertForbidden();
    }

    public function test_gudang_can_access_stock_but_not_cashier(): void
    {
        $user = User::factory()->create(['role' => 'gudang']);

        $this->actingAs($user)->get('/gudang/stok')->assertOk();
        $this->actingAs($user)->get('/kasir')->assertForbidden();
    }

    public function test_admin_can_access_user_management(): void
    {
        $user = User::factory()->create(['role' => 'admin']);

        $this->actingAs($user)->get('/pengguna')->assertOk();
    }
}

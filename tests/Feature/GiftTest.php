<?php

namespace Tests\Feature;

use App\Models\Gift;
use App\Models\GiftList;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GiftTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return array{user: User, list: GiftList}
     */
    private function userWithList(): array
    {
        $user = User::factory()->create();
        $list = $user->giftLists()->create(['name' => 'Lista de mi novix']);

        return ['user' => $user, 'list' => $list];
    }

    /**
     * Test user can view their gifts list with their items.
     */
    public function test_user_can_view_their_gifts_list(): void
    {
        ['user' => $user, 'list' => $list] = $this->userWithList();

        Gift::create([
            'user_id' => $user->id,
            'gift_list_id' => $list->id,
            'category' => 'ropa',
            'name' => 'Chaqueta de cuero',
            'price' => '89,99 €',
            'store' => 'Zara',
            'badge' => '⭐ Top Deseo',
            'note' => 'Talla M, color negro',
        ]);

        $response = $this->actingAs($user)->get('/');

        $response->assertStatus(200);
        $response->assertSee('Chaqueta de cuero');
        $response->assertSee('89,99 €');
        $response->assertSee('Zara');
        $response->assertSee('Talla M, color negro');
    }

    /**
     * Test user cannot see another user's gifts.
     */
    public function test_user_cannot_see_other_users_gifts(): void
    {
        ['user' => $userA, 'list' => $listA] = $this->userWithList();
        ['user' => $userB] = $this->userWithList();

        Gift::create([
            'user_id' => $userA->id,
            'gift_list_id' => $listA->id,
            'category' => 'ropa',
            'name' => 'Vestido de fiesta de User A',
            'price' => '50,00 €',
        ]);

        $response = $this->actingAs($userB)->get('/');

        $response->assertStatus(200);
        $response->assertDontSee('Vestido de fiesta de User A');
    }

    /**
     * Test user can create a gift.
     */
    public function test_user_can_create_a_gift(): void
    {
        ['user' => $user, 'list' => $list] = $this->userWithList();

        $response = $this->actingAs($user)->post('/gifts', [
            'gift_list_id' => $list->id,
            'category' => 'maquillaje',
            'name' => 'Pintalabios rojo',
            'price' => '22,00 €',
            'store' => 'Sephora',
            'badge' => 'Favorito',
            'note' => 'Tono Ruby Woo de MAC',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('gifts', [
            'user_id' => $user->id,
            'gift_list_id' => $list->id,
            'category' => 'maquillaje',
            'name' => 'Pintalabios rojo',
            'price' => '22,00 €',
            'store' => 'Sephora',
            'badge' => 'Favorito',
            'note' => 'Tono Ruby Woo de MAC',
        ]);
    }

    /**
     * Test user can update their gift.
     */
    public function test_user_can_update_their_gift(): void
    {
        ['user' => $user, 'list' => $list] = $this->userWithList();

        $gift = Gift::create([
            'user_id' => $user->id,
            'gift_list_id' => $list->id,
            'category' => 'comida',
            'name' => 'Bombones',
            'price' => '10,00 €',
            'store' => 'Supermercado',
            'note' => 'De chocolate con leche',
        ]);

        $response = $this->actingAs($user)->put("/gifts/{$gift->id}", [
            'category' => 'comida',
            'name' => 'Bombones Belgas Artesanales',
            'price' => '18,50 €',
            'store' => 'Pastelería Gourmet',
            'badge' => '⭐ Top Deseo',
            'note' => 'Solo chocolate negro y praliné',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('gifts', [
            'id' => $gift->id,
            'name' => 'Bombones Belgas Artesanales',
            'price' => '18,50 €',
            'store' => 'Pastelería Gourmet',
        ]);
    }

    /**
     * Test user cannot update someone else's gift.
     */
    public function test_user_cannot_update_other_users_gift(): void
    {
        ['user' => $owner, 'list' => $list] = $this->userWithList();
        ['user' => $stranger] = $this->userWithList();

        $gift = Gift::create([
            'user_id' => $owner->id,
            'gift_list_id' => $list->id,
            'category' => 'juguetes',
            'name' => 'Lego Star Wars',
        ]);

        $response = $this->actingAs($stranger)->put("/gifts/{$gift->id}", [
            'category' => 'juguetes',
            'name' => 'Hacked Name',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('gifts', [
            'id' => $gift->id,
            'name' => 'Lego Star Wars',
        ]);
    }

    /**
     * Test user can delete their gift.
     */
    public function test_user_can_delete_their_gift(): void
    {
        ['user' => $user, 'list' => $list] = $this->userWithList();

        $gift = Gift::create([
            'user_id' => $user->id,
            'gift_list_id' => $list->id,
            'category' => 'cremas',
            'name' => 'Crema de manos',
        ]);

        $response = $this->actingAs($user)->delete("/gifts/{$gift->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('gifts', [
            'id' => $gift->id,
        ]);
    }

    /**
     * Test user cannot delete someone else's gift.
     */
    public function test_user_cannot_delete_other_users_gift(): void
    {
        ['user' => $owner, 'list' => $list] = $this->userWithList();
        ['user' => $stranger] = $this->userWithList();

        $gift = Gift::create([
            'user_id' => $owner->id,
            'gift_list_id' => $list->id,
            'category' => 'otros',
            'name' => 'Vela Aromática',
        ]);

        $response = $this->actingAs($stranger)->delete("/gifts/{$gift->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('gifts', [
            'id' => $gift->id,
        ]);
    }

    /**
     * Test user can create a gift list.
     */
    public function test_user_can_create_a_gift_list(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post('/gift-lists', [
            'name' => 'Lista Cumpleaños Papá',
            'icon' => '🎂',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('gift_lists', [
            'user_id' => $user->id,
            'name' => 'Lista Cumpleaños Papá',
            'icon' => '🎂',
        ]);
    }

    /**
     * Test user can update a gift list name and icon.
     */
    public function test_user_can_update_a_gift_list_name(): void
    {
        ['user' => $user, 'list' => $list] = $this->userWithList();

        $response = $this->actingAs($user)->put("/gift-lists/{$list->id}", [
            'name' => 'Nuevo Nombre de Lista',
            'icon' => '💖',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('gift_lists', [
            'id' => $list->id,
            'name' => 'Nuevo Nombre de Lista',
            'icon' => '💖',
        ]);
    }

    /**
     * Test user cannot update another user's gift list.
     */
    public function test_user_cannot_update_other_users_gift_list(): void
    {
        ['user' => $owner, 'list' => $list] = $this->userWithList();
        ['user' => $stranger] = $this->userWithList();

        $response = $this->actingAs($stranger)->put("/gift-lists/{$list->id}", [
            'name' => 'Hacked Name',
        ]);

        $response->assertStatus(403);
        $this->assertDatabaseHas('gift_lists', [
            'id' => $list->id,
            'name' => 'Lista de mi novix',
        ]);
    }

    /**
     * Test user can delete a gift list.
     */
    public function test_user_can_delete_a_gift_list(): void
    {
        ['user' => $user, 'list' => $list] = $this->userWithList();

        $response = $this->actingAs($user)->delete("/gift-lists/{$list->id}");

        $response->assertRedirect();
        $this->assertDatabaseMissing('gift_lists', [
            'id' => $list->id,
        ]);
    }

    /**
     * Test user cannot delete another user's gift list.
     */
    public function test_user_cannot_delete_other_users_gift_list(): void
    {
        ['user' => $owner, 'list' => $list] = $this->userWithList();
        ['user' => $stranger] = $this->userWithList();

        $response = $this->actingAs($stranger)->delete("/gift-lists/{$list->id}");

        $response->assertStatus(403);
        $this->assertDatabaseHas('gift_lists', [
            'id' => $list->id,
        ]);
    }
}

<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EcommerceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Seed some essential categories and products for testing
        $this->category = Category::create([
            'name' => 'Gifts Box',
            'slug' => 'gifts-box',
            'image' => 'frontend/assets/img/product/01.png',
            'orders' => 1,
            'status' => 1,
        ]);

        $this->product = Product::create([
            'category_id' => $this->category->id,
            'name' => 'Supreme Sweet Hamper',
            'slug' => 'supreme-sweet-hamper',
            'description' => 'A sweet gift hamper filled with chocolates and premium nuts.',
            'price' => 120.00,
            'compare_price' => 150.00,
            'stock' => 15,
            'image' => 'frontend/assets/img/product/01.png',
            'is_featured' => 1,
            'status' => 1,
        ]);
    }

    /** @test */
    public function can_render_storefront_homepage_correctly()
    {
        $response = $this->get(route('home'));

        $response->assertStatus(200);
        $response->assertSee('Supreme Sweet Hamper');
        $response->assertSee('Gifts Box');
    }

    /** @test */
    public function can_render_storefront_shop_catalog_page()
    {
        $response = $this->get(route('shop.index'));

        $response->assertStatus(200);
        $response->assertSee('Supreme Sweet Hamper');
        $response->assertSee('Gifts Box');
    }

    /** @test */
    public function can_render_storefront_product_details_page()
    {
        $response = $this->get(route('shop.show', $this->product->slug));

        $response->assertStatus(200);
        $response->assertSee('Supreme Sweet Hamper');
        $response->assertSee('A sweet gift hamper filled with chocolates and premium nuts.');
        $response->assertSee('$120.00');
    }

    /** @test */
    public function can_add_product_to_session_cart()
    {
        $response = $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'qty' => 2,
        ]);

        $response->assertRedirect(route('cart.index'));
        
        $cart = session('cart');
        $this->assertNotNull($cart);
        $this->assertArrayHasKey($this->product->id, $cart);
        $this->assertEquals(2, $cart[$this->product->id]['qty']);
    }

    /** @test */
    public function can_render_checkout_page_with_active_cart()
    {
        // Place item in cart first
        $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'qty' => 1,
        ]);

        $response = $this->get(route('checkout.index'));

        $response->assertStatus(200);
        $response->assertSee('Secure Checkout');
        $response->assertSee('Jolly'); // Default pre-filled guest name
        $response->assertSee('Supreme Sweet Hamper');
    }

    /** @test */
    public function checkout_redirects_to_cart_if_cart_is_empty()
    {
        $response = $this->get(route('checkout.index'));
        $response->assertRedirect(route('cart.index'));
    }

    /** @test */
    public function can_place_order_successfully_as_jolly_guest()
    {
        // Add item to cart
        $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'qty' => 3, // Order 3 units
        ]);

        $this->assertEquals(15, $this->product->fresh()->stock);

        // Submit checkout form
        $response = $this->post(route('checkout.store'), [
            'name' => 'Jolly',
            'email' => 'jolly@example.com',
            'phone' => '+1 (555) 019-2834',
            'address' => '777 Celebration Boulevard, Suite 100',
            'city' => 'Joyville',
            'order_note' => "Please wrap this gift hamper beautifully with a hand-written card saying 'Welcome, Jolly!'",
        ]);

        // Assert order was placed successfully and redirects to complete page
        $order = Order::first();
        $this->assertNotNull($order);
        $response->assertRedirect(route('checkout.complete', $order->id));

        // Assert database order record is correct
        $this->assertEquals('Jolly', $order->name);
        $this->assertEquals('jolly@example.com', $order->email);
        $this->assertEquals('pending', $order->status);
        $this->assertEquals(360.00, $order->subtotal); // 120.00 * 3
        $this->assertEquals(15.00, $order->shipping);
        $this->assertEquals(375.00, $order->total);

        // Assert order items are saved
        $this->assertCount(1, $order->items);
        $orderItem = $order->items->first();
        $this->assertEquals('Supreme Sweet Hamper', $orderItem->product_name);
        $this->assertEquals(3, $orderItem->qty);
        $this->assertEquals(120.00, $orderItem->price);

        // Assert stock decrement
        $this->assertEquals(12, $this->product->fresh()->stock); // 15 - 3 = 12

        // Assert cart session was cleared
        $this->assertNull(session('cart'));
    }

    /** @test */
    public function cannot_place_order_if_insufficient_stock()
    {
        // Add item to cart exceeding stock
        $this->post(route('cart.add'), [
            'product_id' => $this->product->id,
            'qty' => 1,
        ]);

        // Force decrease product stock to 0 behind the scenes
        $this->product->update(['stock' => 0]);

        // Submit checkout form
        $response = $this->post(route('checkout.store'), [
            'name' => 'Jolly',
            'email' => 'jolly@example.com',
            'phone' => '+1 (555) 019-2834',
            'address' => '777 Celebration Boulevard, Suite 100',
            'city' => 'Joyville',
        ]);

        // Should rollback and redirect back with error
        $response->assertRedirect();
        $response->assertSessionHas('error');
        $this->assertEquals(0, Order::count()); // No order created
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Support\Str;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Categories
        $categories = [
            [
                'name' => 'Wedding Hampers',
                'orders' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Ring Ceremony Platters',
                'orders' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Bridal Accessories',
                'orders' => 3,
                'status' => 1,
            ],
            [
                'name' => 'Trousseau Packing',
                'orders' => 4,
                'status' => 1,
            ],
            [
                'name' => 'Designer Envelopes',
                'orders' => 5,
                'status' => 1,
            ],
            [
                'name' => 'Corporate Gifts',
                'orders' => 6,
                'status' => 1,
            ],
        ];

        $categoryModels = [];
        foreach ($categories as $cat) {
            $categoryModels[$cat['name']] = Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'orders' => $cat['orders'],
                    'status' => $cat['status'],
                ]
            );
        }

        // 2. Seed Products
        $products = [
            // Wedding Hampers
            [
                'category' => 'Wedding Hampers',
                'name' => 'Premium Peacock Theme Wedding Hamper',
                'price' => 15000.00,
                'compare_at_price' => 18000.00,
                'image' => 'frontend/assets/img/product/01.png',
                'short_description' => 'Exquisite peacock-themed wedding hamper featuring luxury dry fruits, premium sweets, and elegant packing.',
                'description' => 'Make your wedding celebrations unforgettable with our Premium Peacock Theme Wedding Hamper. Crafted with intricate zari work and golden motifs, this magnificent hamper includes imported dry fruits, traditional Indian sweets, and bespoke chocolates. Perfectly designed for elite gifting in Agra and beyond.',
                'stock' => 10,
                'is_featured' => 1,
            ],
            [
                'category' => 'Wedding Hampers',
                'name' => 'Royal Heritage Silver Tray Hamper',
                'price' => 8500.00,
                'compare_at_price' => 9500.00,
                'image' => 'frontend/assets/img/product/02.png',
                'short_description' => 'A royal silver-plated tray adorned with fresh floral arrangements and premium assorted nuts.',
                'description' => 'Inspired by the royal heritage of Agra, this stunning silver-plated tray hamper brings elegance to any occasion. Trimmed with fresh orchids and roses, it houses hand-picked almonds, cashews, and pistachios. Ideal for distinguished guests and close relatives.',
                'stock' => 15,
                'is_featured' => 0,
            ],

            // Ring Ceremony Platters
            [
                'category' => 'Ring Ceremony Platters',
                'name' => 'Crystal Lotus Ring Platter',
                'price' => 3500.00,
                'compare_at_price' => 4200.00,
                'image' => 'frontend/assets/img/product/03.png',
                'short_description' => 'An enchanting crystal lotus ring platter with LED lights and floral decor.',
                'description' => 'Present your engagement rings on this breathtaking Crystal Lotus Ring Platter. Featuring delicate LED lighting that illuminates the rings and surrounded by premium artificial flowers, it ensures the spotlight remains on your special moment.',
                'stock' => 20,
                'is_featured' => 1,
            ],
            [
                'category' => 'Ring Ceremony Platters',
                'name' => 'Classic Golden Engagement Tray',
                'price' => 2200.00,
                'compare_at_price' => null,
                'image' => 'frontend/assets/img/product/04.png',
                'short_description' => 'Traditional golden tray with velvet finishing and dual ring holders.',
                'description' => 'A timeless choice for your engagement. This Classic Golden Tray is finished with premium red velvet lining and features dual ring holders adorned with pearls. Simple, elegant, and perfectly crafted.',
                'stock' => 25,
                'is_featured' => 0,
            ],

            // Bridal Accessories
            [
                'category' => 'Bridal Accessories',
                'name' => 'Handcrafted Floral Chuda Box',
                'price' => 1800.00,
                'compare_at_price' => 2500.00,
                'image' => 'frontend/assets/img/product/05.png',
                'short_description' => 'A beautiful floral-decorated box designed specifically for the bridal chuda.',
                'description' => 'Preserve the tradition with our Handcrafted Floral Chuda Box. Customized with premium fabric, gota patti work, and delicate floral accents, it offers a secure and stunning presentation for the bride\'s most cherished accessory.',
                'stock' => 30,
                'is_featured' => 1,
            ],
            [
                'category' => 'Bridal Accessories',
                'name' => 'Embroidered Potli Bags Set (Pack of 5)',
                'price' => 1250.00,
                'compare_at_price' => 1500.00,
                'image' => 'frontend/assets/img/product/06.png',
                'short_description' => 'Set of 5 richly embroidered potli bags for gifting or bridal wear.',
                'description' => 'Add a touch of tradition to your bridal ensemble or use them as elegant return gifts. These heavily embroidered potli bags feature intricate beadwork and strong golden drawstrings.',
                'stock' => 40,
                'is_featured' => 0,
            ],

            // Trousseau Packing
            [
                'category' => 'Trousseau Packing',
                'name' => 'Luxury Velvet Saree Trays (Set of 3)',
                'price' => 4500.00,
                'compare_at_price' => 5500.00,
                'image' => 'frontend/assets/img/product/07.png',
                'short_description' => 'A set of three premium velvet trays for exquisite saree and suit presentation.',
                'description' => 'Display your bridal wardrobe with grace using our Luxury Velvet Saree Trays. The set includes three differently sized trays, each lined with premium velvet and bordered with golden zari lacework. A must-have for a complete trousseau presentation.',
                'stock' => 12,
                'is_featured' => 1,
            ],

            // Designer Envelopes
            [
                'category' => 'Designer Envelopes',
                'name' => 'Premium Shagun Envelopes (Pack of 50)',
                'price' => 1500.00,
                'compare_at_price' => 2000.00,
                'image' => 'frontend/assets/img/product/14.png',
                'short_description' => 'High-quality metallic finish shagun envelopes with traditional motifs.',
                'description' => 'Gift your blessings in style with our Premium Shagun Envelopes. Made from high-gsm metallic paper and embossed with traditional Indian motifs, these envelopes add prestige to your monetary gifts.',
                'stock' => 100,
                'is_featured' => 1,
            ],
        ];

        foreach ($products as $prod) {
            $catId = $categoryModels[$prod['category']]->id;
            Product::updateOrCreate(
                ['slug' => Str::slug($prod['name'])],
                [
                    'name' => $prod['name'],
                    'category_id' => $catId,
                    'price' => $prod['price'],
                    'compare_at_price' => $prod['compare_at_price'],
                    'image' => $prod['image'],
                    'short_description' => $prod['short_description'],
                    'description' => $prod['description'],
                    'stock' => $prod['stock'],
                    'status' => 1,
                    'is_featured' => $prod['is_featured'],
                ]
            );
        }
    }
}


<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\Post;
use App\Models\Testimonial;
use App\Models\SiteSetting;
use Illuminate\Support\Str;

class EcommerceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Seed Dynamic Site Settings
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'phone' => '+91 98765 43210',
                'whatsapp' => '+919876543210',
                'email' => 'contact@amarnathhampers.com',
                'address' => 'Kinari Bazar, Agra, Uttar Pradesh, India - 282003',
                'working_hours' => 'Monday - Saturday: 10:00 AM - 08:30 PM',
                'map_embed_url' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d113579.78749147572!2d77.90997194723049!3d27.176670116666838!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39740d857c2f41d9%3A0x784aef38a9523b42!2sAgra%2C%20Uttar%20Pradesh!5e0!3m2!1sen!2sin!4v1714000000000!5m2!1sen!2sin',
                'facebook' => 'https://facebook.com',
                'instagram' => 'https://instagram.com',
                'twitter' => 'https://twitter.com',
                'linkedin' => 'https://linkedin.com',
                'footer_desc' => 'Amar Nath Hampers & Materials is Agra\'s premier destination for bespoke wedding hampers, traditional ring ceremony platters, bridal trousseau packaging, and luxury festive gifting.',
                'copyright_text' => 'Amar Nath Hampers & Materials',
            ]
        );

        // 2. Seed Categories
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

        // 3. Seed Products
        $products = [
            [
                'category' => 'Wedding Hampers',
                'name' => 'Premium Peacock Theme Wedding Hamper',
                'price' => 15000.00,
                'compare_at_price' => 18000.00,
                'image' => 'frontend/assets/img/product/01.png',
                'short_description' => 'A royal trousseau packing hamper crafted with rich velvet and gold zari embroidery.',
                'description' => 'Elevate your grand wedding celebrations with our handcrafted Peacock Theme Wedding Hamper. Designed and assembled in Agra, this hamper combines regal aesthetics with functional luxury.',
                'stock' => 15,
                'is_featured' => 1,
            ],
            [
                'category' => 'Ring Ceremony Platters',
                'name' => 'Velvet Ring Ceremony Platter with LED Light',
                'price' => 4500.00,
                'compare_at_price' => 5500.00,
                'image' => 'frontend/assets/img/product/05.png',
                'short_description' => 'Designer ring platter featuring glowing ambient LED light and romantic floral accents.',
                'description' => 'Make your ring exchange moment unforgettable with this luxurious velvet-lined engagement platter.',
                'stock' => 25,
                'is_featured' => 1,
            ],
            [
                'category' => 'Bridal Accessories',
                'name' => 'Handcrafted Royal Bridal Chuda Box',
                'price' => 3200.00,
                'compare_at_price' => 4000.00,
                'image' => 'frontend/assets/img/product/09.png',
                'short_description' => 'Keep your sacred bridal bangles secure in our cushioned, silk-embroidered chuda box.',
                'description' => 'Crafted for the discerning Indian bride, our Royal Bridal Chuda Box offers maximum protection with royal flair.',
                'stock' => 30,
                'is_featured' => 1,
            ],
            [
                'category' => 'Designer Envelopes',
                'name' => 'Premium Shagun Envelopes (Pack of 50)',
                'price' => 1500.00,
                'compare_at_price' => 2000.00,
                'image' => 'frontend/assets/img/product/14.png',
                'short_description' => 'High-quality metallic finish shagun envelopes with traditional motifs.',
                'description' => 'Gift your blessings in style with our Premium Shagun Envelopes. Made from high-gsm metallic paper and embossed with traditional Indian motifs.',
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

        // 4. Seed Testimonials / Client Reviews
        $testimonials = [
            [
                'name' => 'Sylvia H Green',
                'designation' => 'Agra Bride',
                'photo' => 'frontend/assets/img/testimonial/01.jpg',
                'review_text' => 'Absolutely stunning work! Amar Nath Hampers transformed our wedding trousseau into something magical. Their attention to detail and traditional touches are unmatched in Agra.',
                'rating' => 5,
                'sort_order' => 1,
                'status' => 1,
            ],
            [
                'name' => 'Gordo Novak',
                'designation' => 'Engagement Client',
                'photo' => 'frontend/assets/img/testimonial/02.jpg',
                'review_text' => 'We ordered customized ring platters and shagun envelopes for our son\'s engagement. The quality is premium and the delivery was perfectly on time.',
                'rating' => 5,
                'sort_order' => 2,
                'status' => 1,
            ],
            [
                'name' => 'Reid E Butt',
                'designation' => 'Corporate Gifting Lead',
                'photo' => 'frontend/assets/img/testimonial/03.jpg',
                'review_text' => 'The dry fruit hampers were a huge hit with all our corporate clients this festive season. The packaging feels genuinely luxurious and prestigious.',
                'rating' => 5,
                'sort_order' => 3,
                'status' => 1,
            ],
            [
                'name' => 'Parker Jimenez',
                'designation' => 'Trousseau Client, Agra',
                'photo' => 'frontend/assets/img/testimonial/04.jpg',
                'review_text' => 'Beautiful handcrafted chuda boxes and saree trays! They use authentic high-grade materials and the embroidery work is truly flawless.',
                'rating' => 5,
                'sort_order' => 4,
                'status' => 1,
            ],
        ];

        foreach ($testimonials as $t) {
            Testimonial::updateOrCreate(
                ['name' => $t['name']],
                $t
            );
        }

        // 5. Seed Blog Posts
        $posts = [
            [
                'title' => 'Top 5 Trousseau Packing Trends for Agra Brides in 2026',
                'excerpt' => 'Discover the latest styles in trousseau packing, from velvet trays with intricate zari work to personalized floral boxes.',
                'content' => "Wedding trousseau packing has evolved into a fine art in Indian culture. In 2026, brides in Agra and across India are looking for personalized, royal aesthetics that honor our rich heritage.\n\n1. Regal Velvet Trays: Rich jewel tones like emerald green, royal blue, and deep maroon are dominating the bridal scene.\n2. Sustainable Handcrafted Baskets: Eco-conscious brides are choosing reusable cane and jute baskets adorned with gotapatti work.\n3. LED Illumination: Adding subtle ambient lighting to saree and jewelry trays makes nighttime reveal ceremonies magical.\n4. Customized Monogrammed Boxes: Embossing the couple's initials or wedding hashtag gives a modern signature touch.\n5. Floral Accents: Fresh and preserved florals add scent and visual elegance to every gift tier.\n\nAt Amar Nath Hampers & Materials, we customize every trousseau hamper to match your specific wedding theme and outfits.",
                'author_name' => 'Amar Nath Hampers',
                'featured_image' => 'frontend/assets/img/blog/01.jpg',
                'status' => 1,
                'published_at' => now()->subDays(5),
            ],
            [
                'title' => 'How to Choose the Perfect Ring Ceremony Platter',
                'excerpt' => 'A complete guide to selecting an engagement platter that highlights your rings and matches your celebration theme.',
                'content' => "The engagement ring ceremony is one of the most photographed moments of a wedding. Your ring platter should be as breathtaking as the rings themselves.\n\nKey Considerations:\n- Theme Matching: Align the platter design with your venue decor (e.g. Traditional Mughal Gold, Floral Pastel, or Minimalist Velvet).\n- Security & Ring Slots: Ensure the ring cushions hold both bride and groom rings securely without slipping.\n- Photo-Ready Angles: Raised centerpieces help wedding photographers capture crystal-clear close-up shots of your diamonds.\n\nExplore our bespoke Ring Ceremony Platters at Amar Nath Hampers located in Kinari Bazar, Agra.",
                'author_name' => 'Alicia Davis',
                'featured_image' => 'frontend/assets/img/blog/02.jpg',
                'status' => 1,
                'published_at' => now()->subDays(10),
            ],
            [
                'title' => 'The Complete Bridal Chuda & Bangle Box Care Guide',
                'excerpt' => 'Keep your sacred wedding chuda safe and preserved for years with proper storage techniques.',
                'content' => "The bridal chuda carries deep emotional and cultural significance for an Indian bride. Preserving its luster and intricate stones requires proper storage.\n\n- Cushioning: Always choose a velvet-lined box with dedicated partitions to prevent scratches.\n- Moisture Protection: Keep silica gel pouches inside the box during monsoon seasons.\n- Dust-Free Closures: Strong magnetic or brass latches prevent dust buildup on precious lac and stones.\n\nCheck out our collection of Royal Bridal Chuda Boxes handcrafted with genuine silk and gold embroidery.",
                'author_name' => 'Amar Nath Hampers',
                'featured_image' => 'frontend/assets/img/blog/03.jpg',
                'status' => 1,
                'published_at' => now()->subDays(15),
            ],
        ];

        foreach ($posts as $p) {
            Post::updateOrCreate(
                ['slug' => Str::slug($p['title'])],
                [
                    'title' => $p['title'],
                    'excerpt' => $p['excerpt'],
                    'content' => $p['content'],
                    'author_name' => $p['author_name'],
                    'featured_image' => $p['featured_image'],
                    'status' => $p['status'],
                    'published_at' => $p['published_at'],
                ]
            );
        }
    }
}

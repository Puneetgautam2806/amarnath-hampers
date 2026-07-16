# Amarnath Hampers — Full E-Commerce Development Plan

**Goal:** Convert the current static/partial-template storefront into a fully dynamic Laravel e-commerce platform where Home, Category, Product, Cart, Checkout, Payment, and Orders are all admin-controlled — nothing hardcoded.

---

## 0. Development Philosophy

Build **one vertical slice at a time** — DB → Model → Admin CRUD → Public Frontend → Test — rather than building all backend first or all frontend first. This way each phase is a working, demoable feature before you move to the next.

**Order of phases:**

| Phase | Module | Status |
|---|---|---|
| 1 | Homepage + Category + Product (dynamic) | 👉 **Start here** |
| 2 | Cart System | Next |
| 3 | Checkout + Order Flow | Next |
| 4 | Payment Gateway | Next |
| 5 | Admin Polish + Notifications + Customer Accounts | Final |

---

## PHASE 1 — Homepage + Category + Product (Detailed Plan)

### 1.1 Database Layer

You already have `categories` and `products` tables per your docs. Extend them so admin has full control:

**`categories` table**
- `id`
- `name`
- `slug` (unique, auto-generated from name)
- `image` (nullable — for category card)
- `status` (active/inactive — so admin can hide a category from frontend)
- `sort_order` (int — controls display order on homepage/shop)
- `parent_id` (nullable — only add this if you want subcategories, e.g. "Diwali Hampers" under "Festive Hampers"; skip if not needed now)
- timestamps

**`products` table**
- `id`
- `category_id` (FK)
- `name`
- `slug`
- `description` (long text)
- `short_description` (for cards/listing)
- `price`
- `compare_at_price` (nullable — drives the "Deals" logic: `compare_at_price > price`)
- `stock_status` (in_stock / out_of_stock, or better: `stock_quantity` int if you want real inventory tracking)
- `is_featured` (bool)
- `status` (active/inactive — draft vs published)
- `sort_order`
- `meta_title`, `meta_description` (basic SEO — cheap to add now, painful to retrofit later)
- timestamps

**`product_images` table** (new — don't cram multiple images into one column)
- `id`
- `product_id` (FK)
- `image_path`
- `is_primary` (bool — which one shows on the card/grid)
- `sort_order`

**`sliders` table** — already exists per your docs (homepage banners). No change needed for Phase 1.

> **Decision point before you start:** Do products need variants (size/weight of hamper, gift-wrap option, etc.)? If yes now, add a `product_variants` table early — retrofitting variants after checkout is built is a lot more painful. If hampers are fixed single-SKU items, skip variants entirely.

---

### 1.2 Admin Panel Side (build first, since frontend reads from it)

**Category Manager (`admin/categories`)**
- List view: name, image thumbnail, product count, status toggle, sort order
- Create/Edit form: name (auto-slug), image upload, status, sort order
- Delete with guard: block delete if products exist under it (or force reassign)

**Product Manager (`admin/products`)**
- List view: image, name, category, price, compare_at_price, stock status, featured toggle, status toggle
- Create/Edit form:
  - Basic info: name, slug, category dropdown, description, short description
  - Pricing: price, compare_at_price
  - Inventory: stock status/quantity
  - Media: multi-image upload with drag-to-reorder + "set primary" — this is the piece worth doing properly since your storefront leans on product photography
  - Flags: is_featured, status
  - SEO fields (collapsible section, optional to fill)
- Bulk actions (optional, nice-to-have): bulk activate/deactivate, bulk feature

**Homepage Manager** — already documented (sliders, site settings). No new work needed for Phase 1, just make sure product/category sections you're about to build pull live data instead of dummy template data.

---

### 1.3 Public Frontend Side

**Routes**
```
GET  /                          → HomeController@index
GET  /shop                      → ShopController@index        (all products, filters)
GET  /shop/category/{slug}      → ShopController@category      (filtered by category)
GET  /product/{slug}            → ProductController@show
```

**HomeController@index**
- Fetch active sliders (existing)
- Fetch active categories ordered by `sort_order`, with product count (`withCount('products')`)
- Fetch featured products (`is_featured = true`, `status = active`, limit ~8)
- Fetch deals (`compare_at_price > price`, `status = active`, limit ~8) — calculate discount % here so the view doesn't do math
- Fetch general "all products" grid (paginated or limited, your call)

**ShopController@index / @category**
- Base query: `status = active`
- Filters (build these now, they're cheap on a fresh query builder, painful to bolt on later):
  - by category
  - by price range
  - sort: newest, price low-high, price high-low
- Paginate (12–24 per page)

**ProductController@show**
- Fetch product by slug with images and category
- Related products (same category, exclude current, limit 4)

**Blade structure** (reusable partials — don't duplicate the product card markup across home/shop/category views)
```
resources/views/
  home.blade.php
  shop/
    index.blade.php
  product/
    show.blade.php
  partials/
    product-card.blade.php
    category-card.blade.php
    slider.blade.php
```

---

### 1.4 Phase 1 Build Order (step-by-step)

1. Migrations: extend `categories`, `products`, create `product_images`
2. Models + relationships (`Category hasMany Product`, `Product belongsTo Category`, `Product hasMany ProductImage`)
3. Admin: Category CRUD (simpler, do this first to unblock Product CRUD's dropdown)
4. Admin: Product CRUD with multi-image upload
5. Seed 15–20 real/dummy products across 3–4 categories so frontend has real data to render against
6. HomeController + home.blade.php wired to live data
7. ShopController + shop grid + category filter
8. ProductController + product detail page
9. QA pass: toggle a product inactive in admin → confirm it disappears from home/shop instantly (this is your proof that "fully dynamic" actually works)

---

### 1.5 Header & Menu — Make It Real

Looking at your actual template, the header nav is: **Home | All Category | About | Pages | Account | Shop | Blog | Contact**. Right now these are static links pointing nowhere real. Here's how each should resolve:

| Menu Item | Should Link To | Data Source |
|---|---|---|
| Home | `/` | HomeController |
| All Category | Mega-dropdown listing all active categories (hover/click) | `categories` table, live query, cached |
| About | `/about` | A `pages` table (see below) — not hardcoded HTML |
| Pages | Dropdown of misc static pages (FAQ, Terms, Privacy, Shipping Info, etc.) | Same `pages` table |
| Account | `/account` — login/register/order history | `users` + `orders` (Phase 3/5) |
| Shop | `/shop` | ShopController (Phase 1, already planned) |
| Blog | `/blog` | New `posts` table — see below |
| Contact | `/contact` | Contact form → stores in `contact_messages` table or emails admin |

**New table needed: `pages`** (for About Us, FAQ, Terms, Privacy, Shipping Info, etc.)
- `id`, `title`, `slug`, `content` (rich text/WYSIWYG), `status`, timestamps
- One simple admin CRUD screen handles About + every "Pages" dropdown item — you don't build a separate controller per static page.

**New table needed: `posts`** (for the Blog section visible on your homepage)
- `id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `author_name`, `status`, `published_at`
- Admin CRUD: Post Manager
- Homepage blog section = latest 3 published posts

**Top bar** (currency/language switcher, phone number, social icons) — pull phone/social links from the existing `site_settings` table (already in your CMS per the doc) instead of hardcoding in the blade layout. Currency/language switcher is cosmetic for now — skip functional multi-currency unless you actually need it; don't over-engineer.

---

### 1.6 Homepage — Section by Section Dynamic Mapping

Going section by section down your actual screenshot, top to bottom:

| # | Section (as seen in template) | Dynamic Source | Admin Control Needed | Priority |
|---|---|---|---|---|
| 1 | Hero slider ("Start From $15.99...") | `sliders` table | Already planned (Slider Manager) | Core |
| 2 | Category icon strip (Chocolate/Fruit/Birthday/Wedding/Wellness) | `categories` table, top N by `sort_order`, with live product count | Category Manager | Core |
| 3 | Trending Items carousel | `products` where `is_featured = true` (or a separate `is_trending` flag if you want it distinct from "Featured Products" on-page 5) | Product Manager toggle | Core |
| 4 | 3-banner promo strip (Gift Box / Occasion Gifts / Combo Sets) | New `promo_banners` table: `id, title, subtitle, image, link_url, sort_order, status` | New: Promo Banner Manager | Medium |
| 5 | Features strip (Free Delivery / Refund / Safe Payment / 24/7 Support) | New `site_features` table: `id, icon, title, subtitle, sort_order` — or just 4 fixed fields in `site_settings` since this rarely changes | Small admin form | Low (can hardcode initially, make dynamic later) |
| 6 | Popular Items (tabbed by category) + side banner image | Same `products`/`categories` data, tabs = categories, filtered by `is_popular` flag or just reuse featured | Reuse Product Manager | Core |
| 7 | Best Deals This Week + countdown timer | `products` where `compare_at_price > price`, `status = active` (matches your doc's "Deals" logic). Countdown timer needs an actual end datetime — add `deal_ends_at` field on `products` or a separate `deals` config in `site_settings` | Product Manager (mark as deal + set end date) | Core |
| 8 | About Us section (stats + bullet points) | One entry in `pages` table (slug: `about-us-home-block`), or dedicated `about_section` fields in `site_settings` if it's homepage-only content, separate from the full `/about` page | Homepage Manager | Medium |
| 9 | Mega Collections banner (single large promo) | Same `promo_banners` table as #4, or reuse `sliders` with a "type" field (hero vs. mid-page) | Promo Banner Manager | Medium |
| 10 | Photo Gallery (8 images) | New `gallery_images` table: `id, image, sort_order, status` | New: Gallery Manager | Low |
| 11 | Testimonials (3 client reviews) | New `testimonials` table: `id, name, photo, review_text, rating, status, sort_order` | New: Testimonial Manager | Medium |
| 12 | Blog section (3 latest posts) | `posts` table (see 1.5 above) — latest 3 published | Post Manager | Medium |
| 13 | Newsletter subscribe bar | New `newsletter_subscribers` table: `id, email, subscribed_at` — just needs a form POST + store | Simple export/list view for admin | Low |
| 14 | Footer (About text, Quick Links, Browse Category, Support Center, social, payment icons) | Quick Links/Support Center = another use of the `pages` table; Browse Category = live `categories`; About text/social/payment icons = `site_settings` | Already mostly covered by Homepage Manager | Core |

**Priority guidance:** Build **Core** rows first (they're the same `categories`/`products`/`sliders` work you're already doing in Phase 1). Do **Medium** rows once Core is working — they're new tables but simple CRUD, no business logic. Leave **Low** priority rows for last, or hardcode them for launch and revisit — a static "Free Delivery / Refund / Safe Payment / 24/7 Support" strip is not worth building a CMS for on day one.

---

### 1.7 Revised Phase 1 Build Order (incorporating the above)

1. `pages`, `posts`, `promo_banners`, `testimonials` migrations (alongside the `categories`/`products`/`product_images` ones from 1.4)
2. Category + Product admin CRUD (as planned) — unblocks category strip, trending, popular, deals
3. Simple CRUD for Pages, Posts, Promo Banners, Testimonials (all follow the same pattern — build one, the rest are copy-paste with different fields)
4. Wire header menu: Home, Shop, About, Pages dropdown, Blog all resolve to real routes/controllers
5. Wire homepage sections top to bottom against the table above
6. Skip Gallery/Newsletter/Features-strip CMS for now — hardcode or stub them, come back post-launch
7. QA: change something in every admin screen you built, confirm it reflects live on homepage with no redeploy

---

## PHASE 2 — Cart System (preview, detail when you get here)

- Session-based cart (guest-friendly, no login required)
- `Cart` stored in session as array: `[product_id => ['qty' => x, 'price' => y]]`, or use a `cart_items` DB table if you want cart to survive across devices for logged-in users later
- Endpoints: add, update qty, remove, view
- Mini-cart in header (count + total, live update via AJAX so page doesn't reload)

## PHASE 3 — Checkout + Order Flow (preview)

- Checkout form → validate → create `orders` + `order_items` rows
- Order confirmation page
- Admin: order status workflow (Pending → Processing → Completed/Cancelled)

## PHASE 4 — Payment Gateway (preview)

- Decision needed: Razorpay (better for Indian customers/UPI) vs Stripe (better if you'll have international customers)
- Order created as "pending" before payment, confirmed via webhook/callback on success

## PHASE 5 — Admin Polish (preview)

- Email notifications (order placed, status changed) — Laravel Mail + Queue
- Customer accounts (optional login for order history/tracking)
- Dashboard analytics (sales, top products) — nice-to-have, not core

---

## Notes on "Fully Dynamic" Discipline

As you build each phase, the test for "is this actually dynamic" is: **can I change this on the frontend by only touching the admin panel, with zero code deploy?** Apply that test to every hardcoded string/image/price you find in the current template while wiring Phase 1 — that's the real migration work, more than writing new features.

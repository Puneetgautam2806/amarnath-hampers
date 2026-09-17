<?php

namespace App\Http\Controllers\Backoffice;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        $products = Product::with(['category', 'variants'])->orderBy('id', 'desc')->get();
        return view('backoffice.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::where('status', 1)->orderBy('orders', 'asc')->get();
        return view('backoffice.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,webp|max:3072',
            'status' => 'required|in:0,1',
            'is_featured' => 'required|in:0,1',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'colors' => 'nullable|string|max:500',
            'sizes' => 'nullable|string|max:500',
            'variants' => 'nullable|array',
            'variants.*.color' => 'nullable|string|max:100',
            'variants.*.size' => 'nullable|string|max:100',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.compare_at_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $slug = Str::slug($request->name);
        $originalSlug = $slug;
        $count = 1;
        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count++;
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = 'prod_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $fileName);
            $imagePath = 'uploads/products/' . $fileName;
        }

        $product = Product::create([
            'name' => $request->name,
            'slug' => $slug,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'compare_at_price' => $request->compare_at_price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
            'colors' => $request->colors,
            'sizes' => $request->sizes,
            'short_description' => $request->short_description,
            'description' => $request->description,
        ]);

        // Save Product Variants if provided
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $index => $vData) {
                if (empty($vData['color']) && empty($vData['size']) && empty($vData['price'])) {
                    continue;
                }

                $variantImagePath = null;
                if ($request->hasFile("variants.{$index}.image")) {
                    $vFile = $request->file("variants.{$index}.image");
                    $vFileName = 'variant_' . time() . '_' . uniqid() . '.' . $vFile->getClientOriginalExtension();
                    $vFile->move(public_path('uploads/variants'), $vFileName);
                    $variantImagePath = 'uploads/variants/' . $vFileName;
                }

                \App\Models\ProductVariant::create([
                    'product_id' => $product->id,
                    'color' => !empty($vData['color']) ? trim($vData['color']) : null,
                    'size' => !empty($vData['size']) ? trim($vData['size']) : null,
                    'sku' => !empty($vData['sku']) ? trim($vData['sku']) : 'GH-' . $product->id . '-' . ($index + 1),
                    'price' => !empty($vData['price']) ? (float)$vData['price'] : $product->price,
                    'compare_at_price' => !empty($vData['compare_at_price']) ? (float)$vData['compare_at_price'] : null,
                    'stock' => isset($vData['stock']) && $vData['stock'] !== '' ? (int)$vData['stock'] : $product->stock,
                    'image' => $variantImagePath,
                ]);
            }
        }

        return redirect()->route('products.index')->with('success', 'Product and variations created successfully!');
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $categories = Category::where('status', 1)->orderBy('orders', 'asc')->get();
        $product->load('variants');
        return view('backoffice.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'compare_at_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
            'status' => 'required|in:0,1',
            'is_featured' => 'required|in:0,1',
            'colors' => 'nullable|string|max:500',
            'sizes' => 'nullable|string|max:500',
            'short_description' => 'nullable|string|max:1000',
            'description' => 'nullable|string',
            'variants' => 'nullable|array',
            'variants.*.id' => 'nullable|integer',
            'variants.*.color' => 'nullable|string|max:100',
            'variants.*.size' => 'nullable|string|max:100',
            'variants.*.price' => 'nullable|numeric|min:0',
            'variants.*.compare_at_price' => 'nullable|numeric|min:0',
            'variants.*.stock' => 'nullable|integer|min:0',
            'variants.*.image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:3072',
        ]);

        $slug = Str::slug($request->name);
        if ($slug !== $product->slug) {
            $originalSlug = $slug;
            $count = 1;
            while (Product::where('slug', $slug)->where('id', '!=', $product->id)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }
            $product->slug = $slug;
        }

        if ($request->hasFile('image')) {
            // Delete old image
            if ($product->image && File::exists(public_path($product->image))) {
                File::delete(public_path($product->image));
            }
            $file = $request->file('image');
            $fileName = 'prod_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads/products'), $fileName);
            $product->image = 'uploads/products/' . $fileName;
        }

        $product->update([
            'name' => $request->name,
            'slug' => $product->slug,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'compare_at_price' => $request->compare_at_price,
            'stock' => $request->stock,
            'status' => $request->status,
            'is_featured' => $request->is_featured,
            'colors' => $request->colors,
            'sizes' => $request->sizes,
            'short_description' => $request->short_description,
            'description' => $request->description,
        ]);

        // Handle Variants Sync
        $submittedVariantIds = [];
        if ($request->has('variants') && is_array($request->variants)) {
            foreach ($request->variants as $index => $vData) {
                if (empty($vData['color']) && empty($vData['size']) && empty($vData['price'])) {
                    continue;
                }

                $variant = null;
                if (!empty($vData['id'])) {
                    $variant = \App\Models\ProductVariant::where('product_id', $product->id)->find($vData['id']);
                }

                $variantImagePath = $variant ? $variant->image : null;
                if ($request->hasFile("variants.{$index}.image")) {
                    if ($variant && $variant->image && File::exists(public_path($variant->image))) {
                        File::delete(public_path($variant->image));
                    }
                    $vFile = $request->file("variants.{$index}.image");
                    $vFileName = 'variant_' . time() . '_' . uniqid() . '.' . $vFile->getClientOriginalExtension();
                    $vFile->move(public_path('uploads/variants'), $vFileName);
                    $variantImagePath = 'uploads/variants/' . $vFileName;
                }

                if ($variant) {
                    $variant->update([
                        'color' => !empty($vData['color']) ? trim($vData['color']) : null,
                        'size' => !empty($vData['size']) ? trim($vData['size']) : null,
                        'sku' => !empty($vData['sku']) ? trim($vData['sku']) : $variant->sku,
                        'price' => !empty($vData['price']) ? (float)$vData['price'] : $product->price,
                        'compare_at_price' => !empty($vData['compare_at_price']) ? (float)$vData['compare_at_price'] : null,
                        'stock' => isset($vData['stock']) && $vData['stock'] !== '' ? (int)$vData['stock'] : $product->stock,
                        'image' => $variantImagePath,
                    ]);
                    $submittedVariantIds[] = $variant->id;
                } else {
                    $newV = \App\Models\ProductVariant::create([
                        'product_id' => $product->id,
                        'color' => !empty($vData['color']) ? trim($vData['color']) : null,
                        'size' => !empty($vData['size']) ? trim($vData['size']) : null,
                        'sku' => !empty($vData['sku']) ? trim($vData['sku']) : 'GH-' . $product->id . '-' . ($index + 1),
                        'price' => !empty($vData['price']) ? (float)$vData['price'] : $product->price,
                        'compare_at_price' => !empty($vData['compare_at_price']) ? (float)$vData['compare_at_price'] : null,
                        'stock' => isset($vData['stock']) && $vData['stock'] !== '' ? (int)$vData['stock'] : $product->stock,
                        'image' => $variantImagePath,
                    ]);
                    $submittedVariantIds[] = $newV->id;
                }
            }
        }

        // Delete variants that were removed by admin
        $deletedVariants = \App\Models\ProductVariant::where('product_id', $product->id)
            ->whereNotIn('id', $submittedVariantIds)
            ->get();
        foreach ($deletedVariants as $dVar) {
            if ($dVar->image && File::exists(public_path($dVar->image))) {
                File::delete(public_path($dVar->image));
            }
            $dVar->delete();
        }

        return redirect()->route('products.index')->with('success', 'Product and variations updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->image && File::exists(public_path($product->image))) {
            File::delete(public_path($product->image));
        }
        foreach ($product->variants as $variant) {
            if ($variant->image && File::exists(public_path($variant->image))) {
                File::delete(public_path($variant->image));
            }
            $variant->delete();
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully!');
    }
}

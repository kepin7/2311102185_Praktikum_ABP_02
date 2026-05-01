<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProductController extends Controller
{
    private function currentUser(): User
    {
        /** @var User $user */
        $user = Auth::user();
        return $user;
    }

    public function index(): View
    {
        $products = Product::latest()->get();

        $stats = [
            'total'     => $products->count(),
            'active'    => $products->where('is_active', true)->count(),
            'low_stock' => $products->where('stock', '<=', 10)->where('stock', '>', 0)->count(),
            'out'       => $products->where('stock', 0)->count(),
        ];

        return view('products.index', compact('products', 'stats'));
    }

    public function create(): View
    {
        abort_unless($this->currentUser()->hasRole('admin'), 403, 'Hanya admin yang bisa menambah produk.');

        $categories = Product::CATEGORIES;
        $units      = Product::UNITS;

        return view('products.create', compact('categories', 'units'));
    }

    public function store(Request $request): RedirectResponse
    {
        abort_unless($this->currentUser()->hasRole('admin'), 403);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => 'required|string|max:50|unique:products,sku',
            'description' => 'nullable|string|max:1000',
            'category'    => 'required|in:' . implode(',', Product::CATEGORIES),
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'required|in:' . implode(',', Product::UNITS),
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['is_active'] = $request->boolean('is_active', true);

        if ($request->hasFile('image')) {
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        Product::create($validated);

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$validated['name']}\" berhasil ditambahkan!");
    }

    public function edit(Product $product): View
    {
        abort_unless($this->currentUser()->hasAnyRole(['admin', 'staff']), 403, 'Anda tidak memiliki akses untuk mengedit produk.');

        $categories = Product::CATEGORIES;
        $units      = Product::UNITS;

        return view('products.edit', compact('product', 'categories', 'units'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        abort_unless($this->currentUser()->hasAnyRole(['admin', 'staff']), 403);

        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'sku'         => "required|string|max:50|unique:products,sku,{$product->id}",
            'description' => 'nullable|string|max:1000',
            'category'    => 'required|in:' . implode(',', Product::CATEGORIES),
            'price'       => 'required|numeric|min:0',
            'cost_price'  => 'nullable|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'unit'        => 'required|in:' . implode(',', Product::UNITS),
            'is_active'   => 'boolean',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $validated['is_active'] = $request->boolean('is_active', false);

        if ($request->hasFile('image')) {
            if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
                unlink(public_path('uploads/products/' . $product->image));
            }
            $validated['image'] = $this->uploadImage($request->file('image'));
        }

        $product->update($validated);

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$product->name}\" berhasil diperbarui! ✅");
    }

    public function destroy(Product $product): RedirectResponse
    {
        abort_unless($this->currentUser()->hasRole('admin'), 403, 'Hanya admin yang bisa menghapus produk.');

        if ($product->image && file_exists(public_path('uploads/products/' . $product->image))) {
            unlink(public_path('uploads/products/' . $product->image));
        }

        $name = $product->name;
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', "Produk \"{$name}\" berhasil dihapus! 🗑️");
    }

    private function uploadImage($file): string
    {
        $filename   = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $uploadPath = public_path('uploads/products');

        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0755, true);
        }

        $file->move($uploadPath, $filename);

        return $filename;
    }
}
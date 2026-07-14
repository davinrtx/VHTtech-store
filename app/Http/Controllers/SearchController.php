<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\ExchangeRate;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function suggestions(Request $request)
    {
        $query = $request->get('q');

        if (strlen($query) < 2) {
            return response()->json(['products' => [], 'categories' => []]);
        }

        // Split query into individual words (Google-style: "lap top" → busca "lap" y "top")
        $words = array_filter(preg_split('/\s+/', trim($query)), fn($w) => strlen($w) >= 2);

        $products = Product::with('brand', 'primaryImage')
            ->active()
            ->where(function ($q) use ($words, $query) {
                // Match the full phrase
                $q->where(function ($exact) use ($query) {
                    $exact->where('name', 'like', "%{$query}%")
                          ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$query}%"));
                });
                // Also match individual words (Google-style)
                foreach ($words as $word) {
                    $q->orWhere(function ($part) use ($word) {
                        $part->where('name', 'like', "%{$word}%")
                              ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$word}%"));
                    });
                }
            })
            ->take(8)
            ->get()
            ->map(function ($product) {
                return [
                    'id'         => $product->id,
                    'name'       => $product->name,
                    'slug'       => $product->slug,
                    'base_price' => number_format($product->base_price, 2),
                    'brand'      => $product->brand?->name,
                    'image'      => $product->primaryImage->first()
                        ? asset('storage/' . $product->primaryImage->first()->path)
                        : null,
                ];
            });

        $categories = Category::where('is_active', true)
            ->where(function ($q) use ($words, $query) {
                $q->where('name', 'like', "%{$query}%");
                foreach ($words as $word) {
                    $q->orWhere('name', 'like', "%{$word}%");
                }
            })
            ->take(4)
            ->get(['id', 'name', 'slug']);

        return response()->json([
            'products'   => $products,
            'categories' => $categories,
        ]);
    }

    public function results(Request $request)
    {
        $query = $request->get('q');
        $categorySlug = $request->get('categoria');
        $brandSlug = $request->get('marca');
        $sort = $request->get('orden', 'latest');

        $products = Product::active()->with('brand', 'primaryImage');

        // Filtro por texto (Google-style: palabras individuales)
        if ($query && strlen(trim($query)) >= 2) {
            $words = array_filter(preg_split('/\s+/', trim($query)), fn($w) => strlen($w) >= 2);
            $products->where(function ($q) use ($words, $query) {
                $q->where('name', 'like', "%{$query}%");
                foreach ($words as $word) {
                    $q->orWhere('name', 'like', "%{$word}%")
                      ->orWhereHas('brand', fn($b) => $b->where('name', 'like', "%{$word}%"));
                }
            });
        }

        // Filtro por categoría (incluye subcategorías)
        if ($categorySlug) {
            $category = Category::where('slug', $categorySlug)->first();
            if ($category) {
                $categoryIds = $category->children->pluck('id')->push($category->id);
                $products->whereHas('categories', fn($q) => $q->whereIn('id', $categoryIds));
            }
        }

        // Filtro por marca
        if ($brandSlug) {
            $products->whereHas('brand', fn($q) => $q->where('slug', $brandSlug));
        }

        // Ordenamiento
        match ($sort) {
            'price_asc'  => $products->orderBy('base_price'),
            'price_desc' => $products->orderByDesc('base_price'),
            'newest'     => $products->latest(),
            default      => $products->latest(),
        };

        // Paginación
        $products = $products->paginate(12)->withQueryString();

        // Tasa de cambio para precios en Bs
        $exchangeRate = ExchangeRate::where('base', 'USD')
            ->where('quote', 'VES')
            ->latest()
            ->first();

        // Datos para filtros
        $categories = Category::where('is_active', true)
            ->whereNull('parent_id')
            ->orderBy('sort_order')
            ->get();

        $brands = Brand::where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('store.search', compact('products', 'query', 'categorySlug', 'brandSlug', 'sort', 'categories', 'brands', 'exchangeRate'));
    }
}

<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        $tags = [
            ['name' => 'Oferta',        'slug' => 'oferta',        'is_active' => true],
            ['name' => 'Nuevo',         'slug' => 'nuevo',         'is_active' => true],
            ['name' => 'Reacondicionado','slug' => 'reacondicionado','is_active' => true],
            ['name' => 'Más vendido',   'slug' => 'mas-vendido',   'is_active' => true],
            ['name' => 'Envío gratis',  'slug' => 'envio-gratis',  'is_active' => true],
            ['name' => 'Garantía extendida','slug' => 'garantia-extendida','is_active' => true],
            ['name' => 'Liquidación',   'slug' => 'liquidacion',   'is_active' => true],
            ['name' => 'Preventa',      'slug' => 'preventa',      'is_active' => true],
            ['name' => 'Última unidad', 'slug' => 'ultima-unidad', 'is_active' => true],
            ['name' => 'Gaming',        'slug' => 'gaming',        'is_active' => true],
        ];

        collect($tags)->each(fn ($tag) => Tag::firstOrCreate(
            ['slug' => $tag['slug']],
            $tag
        ));

        // Attach tags to existing products based on their attributes
        Product::with('tags')->each(function (Product $product) {
            $tagSlugs = [];

            if ($product->is_featured) {
                $tagSlugs[] = 'oferta';
            }

            if ($product->is_refurbished) {
                $tagSlugs[] = 'reacondicionado';
            }

            if (!empty($tagSlugs)) {
                $tagIds = Tag::whereIn('slug', $tagSlugs)->pluck('id');
                $product->tags()->syncWithoutDetaching($tagIds);
            }
        });

        $this->command?->info('Etiquetas creadas: ' . Tag::count());
    }
}

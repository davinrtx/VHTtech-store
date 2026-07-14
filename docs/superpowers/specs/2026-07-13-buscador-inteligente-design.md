# Buscador Inteligente con Autocompletado

## Resumen

Buscador en vivo con sugerencias automáticas mientras el usuario escribe, usando Alpine.js en el frontend y un controlador Laravel como backend API.

## Stack técnico

- **Frontend:** Alpine.js 3.x (vía CDN)
- **Backend:** Laravel controller + ruta API
- **Base de datos:** Consultas `LIKE` sobre índices existentes (sin motor externo)
- **Asset build:** Vite (para Alpine.js local si se requiere, pero se usará CDN por simplicidad)

## Arquitectura

```
[Input búsqueda] ←→ [Alpine.js component]
                         ↓ debounce 300ms
                  GET /buscar/sugerencias?q=...
                         ↓
                  [SearchController]
                         ↓
                  Product::where('name','LIKE',"%q%")
                  Brand::where('name','LIKE',"%q%")
                  Category::where('name','LIKE',"%q%")
                         ↓
                  JSON { products: [...], categories: [...] }
                         ↓
                  [Alpine renderiza dropdown]
```

## Componentes

### 1. SearchController (nuevo)

**Archivo:** `app/Http/Controllers/SearchController.php`

Método `suggestions(Request $request)`:
- Valida que `q` tenga al menos 2 caracteres
- Busca en `products.name`, incluye relación `brand` y `primaryImage`
- Busca en `categories.name` (categorías activas)
- Busca en `brands.name`
- Retorna JSON con estructura:

```json
{
  "products": [
    {
      "id": 1,
      "name": "Laptop HP Pavilion 15",
      "slug": "laptop-hp-pavilion-15",
      "base_price": 899.99,
      "brand": "HP",
      "image": "/storage/products/hp-pavilion.jpg"
    }
  ],
  "categories": [
    { "name": "Laptops", "slug": "laptops" }
  ]
}
```

Límites: 6 productos, 4 categorías. Order por nombre ascendente.

### 2. Ruta

**Archivo:** `routes/web.php`

```php
Route::get('/buscar/sugerencias', [SearchController::class, 'suggestions'])->name('search.suggestions');
```

### 3. Alpine.js component (en store.blade.php)

Reemplaza el formulario de búsqueda estático por un componente Alpine con:

- **x-data**: `{ query: '', results: [], loading: false, open: false, selectedIndex: -1 }`
- **x-init**: Escucha `search-form` submit para redirigir a página de resultados
- **watch query**: Debounce 300ms → fetch(`/buscar/sugerencias?q=${query}`) → actualiza results
- **Keyboard**: @keydown.down (incrementa selectedIndex), .up (decrementa), .enter (navega al seleccionado), .escape (cierra dropdown)
- **Dropdown**: Template con secciones "Productos" (con imagen, nombre, precio, marca) y "Categorías"
- **Click outside**: @click.outside para cerrar dropdown

### 4. Dropdown HTML

Estructura del panel de sugerencias:

```html
<div x-show="open && query.length >= 2" class="search-suggestions">
    <template x-if="results.products.length">
        <div class="suggestion-group">
            <div class="suggestion-group-title">Productos</div>
            <template x-for="(product, i) in results.products" :key="product.id">
                <a :href="'/producto/' + product.slug" class="suggestion-item"
                   :class="{ 'suggestion-active': selectedIndex === i }">
                    <img x-show="product.image" :src="product.image" class="suggestion-img">
                    <div class="suggestion-info">
                        <span class="suggestion-name" x-text="product.name"></span>
                        <span class="suggestion-meta" x-text="product.brand"></span>
                    </div>
                    <span class="suggestion-price" x-text="'$' + product.base_price"></span>
                </a>
            </template>
        </div>
    </template>
    <!-- Categorías similar -->
</div>
```

### 5. CSS

Estilos para el dropdown de sugerencias:
- Posicionamiento absoluto debajo del search form
- Ancho completo del search form
- Fondo blanco con sombra
- Items con hover highlight
- Imagen pequeña (40x40) del producto
- Precio alineado a la derecha
- Máximo 400px de alto con scroll

## Flujo de interacción

1. Usuario escribe → aparece dropdown con sugerencias
2. Usuario navega con teclado (↑↓) o mouse
3. Enter o clic → redirige a `/producto/{slug}`
4. Escape → cierra dropdown
5. Click fuera → cierra dropdown
6. Submit del form (Enter sin selección) → redirige a página de resultados de búsqueda (pendiente futuro)

## Consideraciones

- **Debounce 300ms** evita sobrecarga de peticiones
- **Mínimo 2 caracteres** para activar la búsqueda
- **Sin dependencias externas** más allá de Alpine.js vía CDN
- **Sin cambios en el layout visual existente**, solo se agrega funcionalidad

## Archivos afectados

| Archivo | Acción |
|---------|--------|
| `app/Http/Controllers/SearchController.php` | Crear |
| `routes/web.php` | Agregar ruta |
| `resources/views/layouts/store.blade.php` | Modificar (reemplazar form con Alpine) |
| `resources/views/layouts/store.blade.php` | Agregar Alpine.js CDN y CSS del dropdown |

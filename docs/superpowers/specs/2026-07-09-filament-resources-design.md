# Fase 3 — Recursos Filament + Policies

## Contexto
Panel admin VHTtech en `/admin`. Filament v4 instalado con login, tema Amber, Spatie permissions. Base de datos (34 tablas) y modelos (20) completos.

## Grupos de navegación

| Grupo | Icono | Recursos |
|---|---|---|
| Catálogo | `heroicon-o-computer-desktop` | BrandResource, CategoryResource, ProductResource, AttributeResource |
| Ventas | `heroicon-o-shopping-cart` | OrderResource, CustomerResource |
| Reparaciones | `heroicon-o-wrench-screwdriver` | RepairOrderResource |
| Sistema | `heroicon-o-cog-6-tooth` | PaymentMethodResource, ExchangeRateResource |

## Policies + Permisos

Se crea `app/Policies/` con 9 policies. Mapeo permiso → recursos:

| Permiso Spatie | Recursos protegidos |
|---|---|
| `manage catalog` | BrandPolicy, CategoryPolicy, ProductPolicy, AttributePolicy |
| `manage orders` | OrderPolicy |
| `manage repairs` | RepairOrderPolicy |
| `manage customers` | CustomerPolicy |
| `manage settings` | PaymentMethodPolicy, ExchangeRatePolicy |

Navegación filtrada con `->visible(fn() => auth()->user()->can('manage catalog'))`.

## Recursos

### BrandResource
- Form: name, slug (autogenerado de name), is_active toggle
- Table: name, slug, is_active badge, products_count
- Buscar por name

### CategoryResource
- Form: name, slug (autogenerado), parent (BelongsToSelect excluyendo self + descendientes), is_active toggle, sort_order
- Table: name, parent link, is_active badge, sort_order, products_count

### ProductResource (recurso principal)
- Form con tabs: General / Variantes / Imágenes / Especificaciones
- Tab General: name, slug, brand select, categorías multiselect, short_description, description (rich), base_price, is_active, is_featured, is_refurbished + grade select, condition_notes, warranty_months
- RelationManager ProductImageManager (dentro de la vista): upload image, is_primary toggle, sort_order, thumbnail preview
- RelationManager ProductVariantManager: sku, price, stock, is_active, pivot attribute values chips
- Table: name, brand, base_price, is_active badge, is_featured badge, stock count (sum variants)

### AttributeResource
- Form: name, slug, type select, is_variant toggle, is_filterable toggle, sort_order
- RelationManager AttributeValueManager: value, slug, swatch (color picker si type=color)
- Table: name, slug, type, is_variant badge, is_filterable badge, values_count

### OrderResource (solo vista + acciones)
- Table: order_number, customer link, status badge (coloreado por estado), total USD, ves_total, created_at
- Vista: billing_address / shipping_address como key-value, items read-only
- Acciones: transición de estado (pending→paid→shipping→delivered, cualquier→cancelled)
- Sin crear/editar ordenes directamente

### RepairOrderResource
- Table: order_number, customer, device_type, technician, status badge, created_at
- Form: device_type, brand, model, serial, issue_description, diagnosed_problem, estimated_cost, final_cost, technician select, warranty_months, notas
- RelationManager RepairStatusHistory (lista cronológica read-only)
- Acciones: transición de estado con nota obligatoria

### CustomerResource
- Form: name, email, phone (readonly password)
- Table: name, email, phone, orders_count, created_at
- Tabs en vista: Órdenes (OrderResource embed), Reparaciones (RepairOrderResource embed)

### PaymentMethodResource
- Form: code, name, gateway select, instructions key-value, is_active toggle, sort_order

### ExchangeRateResource
- Form: base readonly, quote readonly, rate, source select, fetched_at datetime picker
- Table: base/quote, rate, source badge, fetched_at

## Seeders complementarios
- RolesAndPermissionsSeeder: roles (super_admin, admin, gerente, vendedor, tecnico) + permisos
- AdminUserSeeder: admin@vhttech.com con rol super_admin
- Ambos llamados desde DatabaseSeeder

## Archivos a crear (~30 archivos)
- `app/Filament/Resources/*Resource.php` (×9)
- `app/Filament/Resources/*/Pages/*.php` (×27 — List, Create, Edit)
- `app/Filament/Resources/*/RelationManagers/*.php` (×6)
- `app/Policies/*Policy.php` (×9)
- `app/Filament/Resources/ProductResource/Pages/ViewProduct.php` (vista extra)
- Seeders (×2)

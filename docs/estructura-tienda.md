# Estructura de la tienda VHTtech

## Contexto
Laravel 13 + Filament v4 (panel `/admin`). Proyecto limpio. Se construye una tienda de tecnología con panel admin + storefront + checkout + productos con variantes + multidivisa (USD/VES).

---

## Modelo de datos

### Catálogo (`App\Models\Catalog`)
- **categories**
  - `id`, `name`, `slug`, `parent_id`?, `is_active`, `sort_order`, `timestamps`
  - Jerarquía anidada (parent_id self-reference)
- **brands**
  - `id`, `name`, `slug`, `is_active`, `timestamps`
- **products**
  - `id`, `brand_id`?, `name`, `slug`, `short_description`, `description`, `base_price` (USD), `is_active`, `is_featured`, `is_refurbished`, `refurbish_grade` (A/B/C), `condition_notes`?, `warranty_months`? 
- **product_images**
  - `id`, `product_id`, `path`, `is_primary`, `sort_order`
- **category_product** — pivot
- **attributes**
  - `id`, `name`, `slug`, `type` (select/color/number/text), `is_variant`, `is_filterable`, `sort_order`
- **attribute_values**
  - `id`, `attribute_id`, `value`, `slug`, `swatch` (color hex)?
- **product_variants**
  - `id`, `product_id`, `sku`, `price` (USD), `stock`, `is_active`
- **attribute_value_product_variant** — pivot

### Ventas (`App\Models\Sales`)
- **customers**
  - `id`, `name`, `email`, `phone`?, `password`, `email_verified_at`?, `remember_token`, `timestamps`
- **addresses**
  - `id`, `customer_id`, `label`, `recipient_name`, `phone`, `line1`, `line2`, `city`, `state`, `postal_code`, `country`, `is_default`
- **carts**
  - `id`, `customer_id`?, `session_id`?
- **cart_items**
  - `id`, `cart_id`, `product_variant_id`, `quantity`
- **orders**
  - `id`, `order_number`, `customer_id`?, `status` (pending/paid/shipping/delivered/cancelled), `subtotal`, `tax`, `shipping_cost`, `total` (USD), `currency`, `usd_to_ves_rate`, `ves_total`, `billing_address` (json), `shipping_address` (json), `notes`?, `paid_at`?
- **order_items**
  - `id`, `order_id`, `product_variant_id`?, `name`, `sku`, `price`, `quantity`
- **shipping_methods**
  - `id`, `name`, `base_cost`, `is_active`

### Reparaciones (`App\Models\Repairs`)
- **repair_orders**
  - `id`, `order_number`, `customer_id`?, `device_type`, `brand`?, `model`?, `serial`?, `issue_description`, `diagnosed_problem`?, `technician_id`?, `status` (received/in_diagnosis/in_repair/ready/delivered/cancelled/quote_pending), `estimated_cost`, `final_cost`, `warranty_months`?, `received_at`, `ready_at`?, `delivered_at`?
- **repair_status_histories**
  - `id`, `repair_order_id`, `status`, `note`?, `created_by`

### Sistema (`App\Models\System`)
- **exchange_rates**
  - `id`, `base` (USD), `quote` (VES), `rate`, `source` (manual/bcv), `fetched_at`, `timestamps`
- **payment_methods**
  - `id`, `code`, `name`, `gateway` (manual/pago_movil/binance/transfer/zelle/card/cash), `instructions`?, `is_active`, `sort_order`
- **payments**
  - `id`, `order_id`? (ventas), `repair_order_id`? (reparaciones), `payment_method_id`?, `gateway`, `amount` (USD), `ves_amount`, `status` (pending/paid/failed/verified), `transaction_id`?, `payload`?

---

## Permisos (Spatie)
- `spatie/laravel-permission`
- Roles: `super_admin`, `admin`, `gerente`, `vendedor`, `tecnico`
- Permisos: `view dashboard`, `manage catalog`, `manage orders`, `manage repairs`, `assign repairs`, `manage customers`, `manage settings`
- User `canAccessPanel()` ⇒ `hasRole([...])`
- Policies en `App\Policies` para cada recurso
- Navegación y acciones en Filament filtradas por `->visible(fn() => auth()->user()->can(...))`

---

## Panel admin (Filament)
Rutas de recursos: `/admin`
- BrandResource, CategoryResource (parent jerárquico)
- ProductResource (relation managers: ProductImage, ProductVariant, categorías multiselect, marca select, filtros refurbished)
- AttributeResource (AttributeValue RM)
- OrderResource (OrderItem RM, snapshot VES, acciones de estado)
- RepairOrderResource (asignar técnico, timeline estados, pago)
- CustomerResource, PaymentMethodResource, ExchangeRateResource

---

## Storefront (Livewire + Tailwind)
Rutas `shop.*`: `/`
- Home: destacados + categorías + banner refurbished
- `/categoria/{slug}`: listado filtrado por specs
- `/refurbished`: equipos refurbished (grade A/B/C badges)
- `/producto/{slug}`: detalle con variante + specs + precio USD + VES
- `/carrito`, `/checkout`
- `/reparaciones`: formulario solicitud
- `/cuenta/{login,register,pedidos,reparaciones}`: auth customer

Componentes: `ProductGrid`, `CategoryBrowser`, `ProductDetail`, `RefurbishedBrowser`, `Cart`, `Checkout`, `RepairRequest`

Servicios: `CheckoutService`, `CurrencyFormatter`, `ExchangeRateService`, `PaymentGateway` (interface) + `ManualPayment`

---

## Seeders
- `RolesAndPermissionsSeeder`, `AdminUserSeeder` (super_admin en `admin@vhttech.com`), `CategorySeeder`, `BrandSeeder`, `AttributeSeeder`, `ProductSeeder` (variantes, specs, refurbished), `ExchangeRateSeeder` (tasa demo), `PaymentMethodSeeder`, `CustomerSeeder`

---

## Flujo de trabajo
1. Instalar Spatie + guard `customer`
2. Migraciones + modelos
3. Recursos Filament + policies
4. Storefront Livewire
5. Multidivisa (snapshot VES en orders)
6. Seeders + datos de ejemplo

---

## Fase futura (NO implementar ahora)
- Gateway real: Pago Móvil, Binance Pay, Transferencia, Zelle, Tarjeta
- Tasa automática BCV vía cron
- Notificaciones de avance de reparación
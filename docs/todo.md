# VHTtech — Estado del proyecto

## ✅ Completado

### Fase 0 — Documentación
- [x] `docs/estructura-tienda.md` — documento completo con la arquitectura del proyecto
- [x] `config/auth.php` — guard `customer` + provider
- [x] `config/permission.php` — Spatie publicado
- [x] `.env` / `.env.example` — `APP_NAME="VHTtech"`, `APP_LOCALE=es`

### Fase 1 — Spatie permisos
- [x] Instalado `spatie/laravel-permission` v8.3.0
- [x] Migración publicada de permissions
- [x] `User` implementa `FilamentUser` + `HasRoles`
- [x] `Customer` con guard `customer`

### Fase 2 — Migraciones + Modelos
- [x] 26 migraciones ejecutadas (5 core + 21 custom)
- [x] 20 modelos creados con relaciones:
  - Catálogo: `Brand`, `Category`, `Product`, `ProductImage`, `ProductVariant`, `Attribute`, `AttributeValue`
  - Ventas: `Customer`, `Address`, `Cart`, `CartItem`, `Order`, `OrderItem`, `ShippingMethod`
  - Reparaciones: `RepairOrder`, `RepairStatusHistory`
  - Sistema: `ExchangeRate`, `PaymentMethod`, `Payment`

---

## ❌ Pendiente

### Fase 3 — Recursos Filament + Policies
- [ ] `BrandResource` — CRUD básico
- [ ] `CategoryResource` — con selector jerárquico (parent)
- [ ] `ProductResource` — CRUD + RelationManagers: `ProductImage`, `ProductVariant` (sku/price/stock/atributos)
- [ ] `AttributeResource` — con RelationManager `AttributeValue`
- [ ] `OrderResource` — vista + cambio de estado, items como RelationManager
- [ ] `RepairOrderResource` — asignar técnico, diagnóstico, timeline de estados
- [ ] `CustomerResource` — listado/edición básica
- [ ] `PaymentMethodResource` — solo roles con `manage settings`
- [ ] `ExchangeRateResource` — solo `manage settings`
- [ ] Policies en `App\Policies\*` para cada recurso
- [ ] Navegación filtrada por permiso con `->visible()`

### Fase 4 — Storefront Livewire + Rutas
- [ ] Rutas `shop.*` en `routes/web.php`
- [ ] `GET /` → home con destacados + categorías
- [ ] `GET /categoria/{slug}` → listado + filtros
- [ ] `GET /refurbished` → sección equipos refurbished con badge + grade
- [ ] `GET /producto/{slug}` → detalle + variante + precio USD/VES
- [ ] `GET /carrito` → carrito de compras
- [ ] `GET /checkout` → checkout + crear orden
- [ ] `GET /reparaciones` → formulario solicitud
- [ ] `GET /cuenta/{login,register,pedidos,reparaciones}` → auth customer
- [ ] Componentes `App\Livewire\Shop\*`

### Fase 5 — Multidivisa
- [ ] `ExchangeRateService` — última tasa vigente
- [ ] `CurrencyFormatter` — helper Blade `USD 100,00 ≈ VES 4.500,00`
- [ ] Snapshot en orders al crear (usd_to_ves_rate + ves_total)
- [ ] Admin de tasa de cambio

### Fase 6 — Seeders + datos
- [ ] `RolesAndPermissionsSeeder` — roles + permisos
- [ ] `AdminUserSeeder` — admin@vhttech.com / super_admin
- [ ] `CategorySeeder`, `BrandSeeder`
- [ ] `AttributeSeeder` — CPU, RAM, Almacenamiento, Color, Pantalla
- [ ] `ProductSeeder` — laptops + celulares con variantes
- [ ] `ExchangeRateSeeder` — tasa demo VES
- [ ] `PaymentMethodSeeder` — Pago Móvil, Binance, Transferencia, Zelle, Tarjeta, Efectivo
- [ ] `CustomerSeeder` — clientes demo
- [ ] `DatabaseSeeder` — orquestador

### Mejoras futuras (post-MVP)
- [ ] Integración real de pagos (Pago Móvil, Binance Pay, etc.)
- [ ] Tasa VES automática desde BCV (cron + parser)
- [ ] Notificaciones al cliente (reparaciones, pedidos)
- [ ] Tests feature

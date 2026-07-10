# Filament Resources + Policies Implementation Plan

> **For agentic workers:** REQUIRED SUB-SKILL: Use superpowers:subagent-driven-development (recommended) or superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Build the complete Filament admin panel (9 Resources, 9 Policies, navigation groups) and seeders for the VHTtech e-commerce platform.

**Architecture:** 11 sequential tasks — seeders first (so permissions exist), then policies, then resources grouped by navigation group. Each resource auto-discovers its pages via Filament's convention. RelationManagers handle sub-resources (images, variants, order items, etc.).

**Tech Stack:** Laravel 13, Filament v4, Spatie Laravel-Permission v8, Livewire

## Global Constraints
- Every resource must use Filament's auto-discovery in `app/Filament/Resources/`
- All pages inside `app/Filament/Resources/{Resource}/Pages/` — Filament convention
- Policies in `App\Policies\*` namespace, mapped via Laravel auto-discovery (no manual Gate registration)
- Navigation groups: Catálogo (heroicon-o-computer-desktop), Ventas (heroicon-o-shopping-cart), Reparaciones (heroicon-o-wrench-screwdriver), Sistema (heroicon-o-cog-6-tooth)
- Slug auto-generation: `Str::slug($record->name)` on save, not in form (use `afterStateHydrated` for display only)
- All table searchable by `name` unless specified otherwise
- Permission checks via `->visible(fn() => auth()->user()->can('manage catalog'))` on navigation
- No custom CSS or JS — use Filament defaults (Amber theme)

---

### Task 1: Roles, Permissions & Admin User Seeders

**Files:**
- Create: `database/seeders/RolesAndPermissionsSeeder.php`
- Create: `database/seeders/AdminUserSeeder.php`
- Modify: `database/seeders/DatabaseSeeder.php`

**Interfaces:**
- Consumes: Spatie `Role::create()`, `Permission::create()` models
- Produces: 5 roles, 6 permissions, 1 admin user — used by all policy checks downstream

- [ ] **Step 1: Create RolesAndPermissionsSeeder with all roles and permissions**

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        app()->make(\Spatie\Permission\PermissionRegistrar::class)->forgetCachedPermissions();

        // Permisos
        $permissions = [
            'view dashboard',
            'manage catalog',
            'manage orders',
            'manage repairs',
            'assign repairs',
            'manage customers',
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission, 'guard_name' => 'web']);
        }

        // Roles con permisos
        $super_admin = Role::create(['name' => 'super_admin', 'guard_name' => 'web']);
        $super_admin->givePermissionTo($permissions);

        $admin = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $admin->givePermissionTo(['view dashboard', 'manage catalog', 'manage orders', 'manage customers', 'manage settings']);

        $gerente = Role::create(['name' => 'gerente', 'guard_name' => 'web']);
        $gerente->givePermissionTo(['view dashboard', 'manage catalog', 'manage orders', 'manage repairs', 'manage customers']);

        $vendedor = Role::create(['name' => 'vendedor', 'guard_name' => 'web']);
        $vendedor->givePermissionTo(['view dashboard', 'manage catalog', 'manage orders', 'manage customers']);

        $tecnico = Role::create(['name' => 'tecnico', 'guard_name' => 'web']);
        $tecnico->givePermissionTo(['view dashboard', 'manage repairs', 'assign repairs']);
    }
}
```

- [ ] **Step 2: Create AdminUserSeeder**

```php
<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::factory()->create([
            'name' => 'Admin VHTtech',
            'email' => 'admin@vhttech.com',
            'password' => bcrypt('admin123'),
            'is_admin' => true,
        ]);

        $admin->assignRole('super_admin');
    }
}
```

- [ ] **Step 3: Update DatabaseSeeder to call both seeders**

```php
<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            RolesAndPermissionsSeeder::class,
            AdminUserSeeder::class,
        ]);
    }
}
```

- [ ] **Step 4: Run seeder to verify it works**

Run: `php artisan db:seed`
Expected: "Seeding: Database\Seeders\RolesAndPermissionsSeeder", "Seeding: Database\Seeders\AdminUserSeeder"

---

### Task 2: Policies (9 files)

**Files:**
- Create: `app/Policies/BrandPolicy.php`
- Create: `app/Policies/CategoryPolicy.php`
- Create: `app/Policies/ProductPolicy.php`
- Create: `app/Policies/AttributePolicy.php`
- Create: `app/Policies/OrderPolicy.php`
- Create: `app/Policies/CustomerPolicy.php`
- Create: `app/Policies/RepairOrderPolicy.php`
- Create: `app/Policies/PaymentMethodPolicy.php`
- Create: `app/Policies/ExchangeRatePolicy.php`

**Interfaces:**
- Consumes: Spatie permissions from Task 1
- Produces: `viewAny()` and `view()` checks via `$user->can('manage catalog')` pattern

- [ ] **Step 1: Create BrandPolicy**

```php
<?php

namespace App\Policies;

use App\Models\User;

class BrandPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('manage catalog');
    }

    public function view(User $user): bool
    {
        return $user->can('manage catalog');
    }

    public function create(User $user): bool
    {
        return $user->can('manage catalog');
    }

    public function update(User $user): bool
    {
        return $user->can('manage catalog');
    }

    public function delete(User $user): bool
    {
        return $user->can('manage catalog');
    }
}
```

- [ ] **Step 2: Create CategoryPolicy** (identical structure — `manage catalog`)

```php
<?php

namespace App\Policies;

use App\Models\User;

class CategoryPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage catalog'); }
    public function view(User $user): bool { return $user->can('manage catalog'); }
    public function create(User $user): bool { return $user->can('manage catalog'); }
    public function update(User $user): bool { return $user->can('manage catalog'); }
    public function delete(User $user): bool { return $user->can('manage catalog'); }
}
```

- [ ] **Step 3: Create ProductPolicy** (identical — `manage catalog`)

Same content as CategoryPolicy, permission `manage catalog`.

- [ ] **Step 4: Create AttributePolicy** (identical — `manage catalog`)

Same content, permission `manage catalog`.

- [ ] **Step 5: Create OrderPolicy** (`manage orders`)

```php
<?php

namespace App\Policies;

use App\Models\User;

class OrderPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage orders'); }
    public function view(User $user): bool { return $user->can('manage orders'); }
    public function create(User $user): bool { return $user->can('manage orders'); }
    public function update(User $user): bool { return $user->can('manage orders'); }
    public function delete(User $user): bool { return $user->can('manage orders'); }
}
```

- [ ] **Step 6: Create CustomerPolicy** (`manage customers`)

```php
<?php

namespace App\Policies;

use App\Models\User;

class CustomerPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage customers'); }
    public function view(User $user): bool { return $user->can('manage customers'); }
    public function create(User $user): bool { return $user->can('manage customers'); }
    public function update(User $user): bool { return $user->can('manage customers'); }
    public function delete(User $user): bool { return $user->can('manage customers'); }
}
```

- [ ] **Step 7: Create RepairOrderPolicy** (`manage repairs` + `assign repairs`)

```php
<?php

namespace App\Policies;

use App\Models\User;

class RepairOrderPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage repairs'); }
    public function view(User $user): bool { return $user->can('manage repairs'); }
    public function create(User $user): bool { return $user->can('manage repairs'); }
    public function update(User $user): bool { return $user->can('manage repairs'); }
    public function delete(User $user): bool { return $user->can('manage repairs'); }
}
```

- [ ] **Step 8: Create PaymentMethodPolicy** (`manage settings`)

```php
<?php

namespace App\Policies;

use App\Models\User;

class PaymentMethodPolicy
{
    public function viewAny(User $user): bool { return $user->can('manage settings'); }
    public function view(User $user): bool { return $user->can('manage settings'); }
    public function create(User $user): bool { return $user->can('manage settings'); }
    public function update(User $user): bool { return $user->can('manage settings'); }
    public function delete(User $user): bool { return $user->can('manage settings'); }
}
```

- [ ] **Step 9: Create ExchangeRatePolicy** (`manage settings`)

Same as PaymentMethodPolicy.

- [ ] **Step 10: Add relationship to Product model to count variants stock**

```php
// Add to app/Models/Product.php
public function totalStock(): int
{
    return $this->variants()->sum('stock');
}
```

---

### Task 3: AdminPanelProvider — Navigation Groups

**Files:**
- Modify: `app/Providers/Filament/AdminPanelProvider.php`

- [ ] **Step 1: Add navigation groups to the panel config**

```php
<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\NavigationGroup;
use Filament\Pages\Dashboard;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\PreventRequestForgery;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->colors([
                'primary' => Color::Amber,
            ])
            ->navigationGroups([
                NavigationGroup::make('Catálogo')
                    ->icon('heroicon-o-computer-desktop'),
                NavigationGroup::make('Ventas')
                    ->icon('heroicon-o-shopping-cart'),
                NavigationGroup::make('Reparaciones')
                    ->icon('heroicon-o-wrench-screwdriver'),
                NavigationGroup::make('Sistema')
                    ->icon('heroicon-o-cog-6-tooth'),
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\Filament\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\Filament\Pages')
            ->pages([
                Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\Filament\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                PreventRequestForgery::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
```

---

### Task 4: BrandResource

**Files:**
- Create: `app/Filament/Resources/BrandResource.php`
- Create: `app/Filament/Resources/BrandResource/Pages/ListBrands.php`
- Create: `app/Filament/Resources/BrandResource/Pages/CreateBrand.php`
- Create: `app/Filament/Resources/BrandResource/Pages/EditBrand.php`

- [ ] **Step 1: Create BrandResource**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BrandResource\Pages;
use App\Models\Brand;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Brand::class, 'slug', ignoreRecord: true),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Productos')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 2: Create ListBrands page**

```php
<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
```

- [ ] **Step 3: Create CreateBrand page**

```php
<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Resources\Pages\CreateRecord;

class CreateBrand extends CreateRecord
{
    protected static string $resource = BrandResource::class;
}
```

- [ ] **Step 4: Create EditBrand page**

```php
<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
```

---

### Task 5: CategoryResource

**Files:**
- Create: `app/Filament/Resources/CategoryResource.php`
- Create: `app/Filament/Resources/CategoryResource/Pages/ListCategories.php`
- Create: `app/Filament/Resources/CategoryResource/Pages/CreateCategory.php`
- Create: `app/Filament/Resources/CategoryResource/Pages/EditCategory.php`

- [ ] **Step 1: Create CategoryResource with hierarchical parent select**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-folder';
    protected static ?string $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Category::class, 'slug', ignoreRecord: true),
                Forms\Components\Select::make('parent_id')
                    ->label('Categoría padre')
                    ->relationship('parent', 'name')
                    ->searchable()
                    ->preload()
                    ->options(function (?Category $record = null) {
                        $query = Category::query();
                        if ($record && $record->exists) {
                            // Excluir la categoría actual y sus descendientes
                            $descendantIds = $record->children()->pluck('id')->toArray();
                            $excludeIds = array_merge([$record->id], $descendantIds);
                            $query->whereNotIn('id', $excludeIds);
                        }
                        return $query->pluck('name', 'id');
                    }),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('parent.name')
                    ->label('Categoría padre')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('products_count')
                    ->counts('products')
                    ->label('Productos')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 2: Create ListCategories page** (same pattern as ListBrands)

- [ ] **Step 3: Create CreateCategory page** (same pattern as CreateBrand)

- [ ] **Step 4: Create EditCategory page** (same pattern as EditBrand)

---

### Task 6: AttributeResource + AttributeValueManager

**Files:**
- Create: `app/Filament/Resources/AttributeResource.php`
- Create: `app/Filament/Resources/AttributeResource/Pages/ListAttributes.php`
- Create: `app/Filament/Resources/AttributeResource/Pages/CreateAttribute.php`
- Create: `app/Filament/Resources/AttributeResource/Pages/EditAttribute.php`
- Create: `app/Filament/Resources/AttributeResource/RelationManagers/AttributeValueManager.php`

- [ ] **Step 1: Create AttributeResource**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttributeResource\Pages;
use App\Filament\Resources\AttributeResource\RelationManagers\AttributeValueManager;
use App\Models\Attribute;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AttributeResource extends Resource
{
    protected static ?string $model = Attribute::class;

    protected static ?string $navigationIcon = 'heroicon-o-list-bullet';
    protected static ?string $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(Attribute::class, 'slug', ignoreRecord: true),
                Forms\Components\Select::make('type')
                    ->options([
                        'select' => 'Select',
                        'color' => 'Color',
                        'number' => 'Número',
                        'text' => 'Texto',
                    ])
                    ->default('select')
                    ->required(),
                Forms\Components\Toggle::make('is_variant')
                    ->label('¿Es variante?')
                    ->helperText('Define variantes de producto (talla, color, etc.)'),
                Forms\Components\Toggle::make('is_filterable')
                    ->label('¿Filtrable?')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_variant')
                    ->label('Variante')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_filterable')
                    ->label('Filtrable')
                    ->boolean(),
                Tables\Columns\TextColumn::make('values_count')
                    ->counts('values')
                    ->label('Valores'),
            ])
            ->defaultSort('sort_order')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            AttributeValueManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttributes::route('/'),
            'create' => Pages\CreateAttribute::route('/create'),
            'edit' => Pages\EditAttribute::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 2: Create AttributeValueManager**

```php
<?php

namespace App\Filament\Resources\AttributeResource\RelationManagers;

use App\Models\AttributeValue;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AttributeValueManager extends RelationManager
{
    protected static string $relationship = 'values';

    public function form(Form $form): Form
    {
        $attribute = $this->getOwnerRecord();
        $isColor = $attribute && $attribute->type === 'color';

        return $form
            ->schema([
                Forms\Components\TextInput::make('value')
                    ->required()
                    ->maxLength(255)
                    ->live(onBlur: true)
                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                        $set('slug', Str::slug($state));
                    }),
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->maxLength(255)
                    ->unique(AttributeValue::class, 'slug', ignoreRecord: true),
                Forms\Components\TextInput::make('swatch')
                    ->label($isColor ? 'Color (hex)' : 'Swatch')
                    ->maxLength(255)
                    ->visible(fn () => $isColor),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('value')
            ->columns([
                Tables\Columns\TextColumn::make('value'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\ColorColumn::make('swatch')
                    ->visible(fn () => $this->getOwnerRecord()->type === 'color'),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

- [ ] **Step 3: Create the 3 pages** (ListAttributes, CreateAttribute, EditAttribute — same pattern as Brand pages)

---

### Task 7: ProductResource (the big one)

**Files:**
- Create: `app/Filament/Resources/ProductResource.php`
- Create: `app/Filament/Resources/ProductResource/Pages/ListProducts.php`
- Create: `app/Filament/Resources/ProductResource/Pages/CreateProduct.php`
- Create: `app/Filament/Resources/ProductResource/Pages/EditProduct.php`
- Create: `app/Filament/Resources/ProductResource/RelationManagers/ProductImageManager.php`
- Create: `app/Filament/Resources/ProductResource/RelationManagers/ProductVariantManager.php`

- [ ] **Step 1: Create ProductResource with tabs in the form**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers\ProductImageManager;
use App\Filament\Resources\ProductResource\RelationManagers\ProductVariantManager;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-cpu-chip';
    protected static ?string $navigationGroup = 'Catálogo';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Tabs::make('Product')
                    ->tabs([
                        Forms\Components\Tabs\Tab::make('General')
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->maxLength(255)
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($state, Forms\Set $set) {
                                        $set('slug', Str::slug($state));
                                    })
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(255)
                                    ->unique(Product::class, 'slug', ignoreRecord: true)
                                    ->columnSpanFull(),
                                Forms\Components\Select::make('brand_id')
                                    ->relationship('brand', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Select::make('categories')
                                    ->relationship('categories', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\Textarea::make('short_description')
                                    ->maxLength(500)
                                    ->columnSpanFull(),
                                Forms\Components\RichEditor::make('description')
                                    ->columnSpanFull(),
                                Forms\Components\TextInput::make('base_price')
                                    ->required()
                                    ->numeric()
                                    ->prefix('USD')
                                    ->step(0.01),
                                Forms\Components\Grid::make(3)
                                    ->schema([
                                        Forms\Components\Toggle::make('is_active')
                                            ->default(true),
                                        Forms\Components\Toggle::make('is_featured')
                                            ->default(false),
                                        Forms\Components\Toggle::make('is_refurbished')
                                            ->default(false)
                                            ->reactive()
                                            ->afterStateUpdated(function ($state, Forms\Set $set) {
                                                if (!$state) {
                                                    $set('refurbish_grade', null);
                                                }
                                            }),
                                    ]),
                                Forms\Components\Grid::make(2)
                                    ->schema([
                                        Forms\Components\Select::make('refurbish_grade')
                                            ->options([
                                                'A' => 'Grado A — Como nuevo',
                                                'B' => 'Grado B — Buen estado',
                                                'C' => 'Grado C — Functional',
                                            ])
                                            ->visible(fn (Forms\Get $get) => $get('is_refurbished')),
                                        Forms\Components\TextInput::make('warranty_months')
                                            ->numeric()
                                            ->label('Garantía (meses)')
                                            ->suffix('meses'),
                                    ]),
                                Forms\Components\Textarea::make('condition_notes')
                                    ->label('Notas de condición')
                                    ->columnSpanFull(),
                            ]),
                    ])
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('brand.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('base_price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_featured')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('refurbish_grade')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'A' => 'success',
                        'B' => 'warning',
                        'C' => 'danger',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
                Tables\Filters\TernaryFilter::make('is_featured'),
                Tables\Filters\TernaryFilter::make('is_refurbished'),
                Tables\Filters\SelectFilter::make('brand_id')
                    ->relationship('brand', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            ProductImageManager::class,
            ProductVariantManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 2: Create ProductImageManager**

```php
<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProductImageManager extends RelationManager
{
    protected static string $relationship = 'images';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('path')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_primary')
                    ->label('Principal'),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('path')
            ->columns([
                Tables\Columns\ImageColumn::make('path')
                    ->label('Imagen')
                    ->size(60),
                Tables\Columns\IconColumn::make('is_primary')
                    ->label('Principal')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

- [ ] **Step 3: Create ProductVariantManager**

```php
<?php

namespace App\Filament\Resources\ProductResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class ProductVariantManager extends RelationManager
{
    protected static string $relationship = 'variants';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('sku')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('USD')
                    ->step(0.01),
                Forms\Components\TextInput::make('stock')
                    ->required()
                    ->numeric()
                    ->default(0),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\Select::make('attributeValues')
                    ->relationship('attributeValues', 'value')
                    ->multiple()
                    ->searchable()
                    ->preload(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('sku')
            ->columns([
                Tables\Columns\TextColumn::make('sku')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('stock')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('attributeValues.value')
                    ->label('Atributos')
                    ->badge()
                    ->separator(','),
            ])
            ->filters([])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
```

- [ ] **Step 4: Create the 3 pages** (ListProducts, CreateProduct, EditProduct — same pattern)

---

### Task 8: CustomerResource

**Files:**
- Create: `app/Filament/Resources/CustomerResource.php`
- Create: `app/Filament/Resources/CustomerResource/Pages/ListCustomers.php`
- Create: `app/Filament/Resources/CustomerResource/Pages/CreateCustomer.php`
- Create: `app/Filament/Resources/CustomerResource/Pages/EditCustomer.php`

- [ ] **Step 1: Create CustomerResource**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';
    protected static ?string $navigationGroup = 'Ventas';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(Customer::class, 'email', ignoreRecord: true),
                Forms\Components\TextInput::make('phone')
                    ->tel()
                    ->maxLength(255),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->revealable()
                    ->dehydrated(fn ($state) => filled($state))
                    ->dehydrateStateUsing(fn ($state) => bcrypt($state)),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('orders_count')
                    ->counts('orders')
                    ->label('Pedidos')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 2: Create the 3 pages** (same pattern as Brand)

---

### Task 9: OrderResource (view + actions only)

**Files:**
- Create: `app/Filament/Resources/OrderResource.php`
- Create: `app/Filament/Resources/OrderResource/Pages/ListOrders.php`
- Create: `app/Filament/Resources/OrderResource/Pages/ViewOrder.php`
- Create: `app/Filament/Resources/OrderResource/RelationManagers/OrderItemManager.php`

- [ ] **Step 1: Create OrderResource**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemManager;
use App\Models\Order;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-bag';
    protected static ?string $navigationGroup = 'Ventas';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del pedido')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->disabled(),
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->disabled(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'pending' => 'Pendiente',
                                'paid' => 'Pagado',
                                'shipping' => 'En envío',
                                'delivered' => 'Entregado',
                                'cancelled' => 'Cancelado',
                            ])
                            ->required(),
                        Forms\Components\TextInput::make('subtotal')
                            ->numeric()
                            ->prefix('USD')
                            ->disabled(),
                        Forms\Components\TextInput::make('tax')
                            ->numeric()
                            ->prefix('USD')
                            ->disabled(),
                        Forms\Components\TextInput::make('shipping_cost')
                            ->numeric()
                            ->prefix('USD')
                            ->disabled(),
                        Forms\Components\TextInput::make('total')
                            ->numeric()
                            ->prefix('USD')
                            ->disabled(),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('usd_to_ves_rate')
                                    ->label('Tasa USD/VES')
                                    ->numeric()
                                    ->disabled(),
                                Forms\Components\TextInput::make('ves_total')
                                    ->label('Total en VES')
                                    ->numeric()
                                    ->prefix('VES')
                                    ->disabled(),
                            ]),
                        ]),
                Forms\Components\Section::make('Direcciones')
                    ->schema([
                        Forms\Components\KeyValue::make('billing_address')
                            ->disabled(),
                        Forms\Components\KeyValue::make('shipping_address')
                            ->disabled(),
                    ]),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'paid' => 'Pagado',
                        'shipping' => 'En envío',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ])
                    ->sortable(),
                Tables\Columns\TextColumn::make('total')
                    ->money('USD')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ves_total')
                    ->label('VES')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pendiente',
                        'paid' => 'Pagado',
                        'shipping' => 'En envío',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ]),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            OrderItemManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            'view' => Pages\ViewOrder::route('/{record}'),
        ];
    }
}
```

- [ ] **Step 2: Create OrderItemManager**

```php
<?php

namespace App\Filament\Resources\OrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class OrderItemManager extends RelationManager
{
    protected static string $relationship = 'items';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('sku')
                    ->maxLength(255),
                Forms\Components\TextInput::make('price')
                    ->required()
                    ->numeric()
                    ->prefix('USD'),
                Forms\Components\TextInput::make('quantity')
                    ->required()
                    ->numeric(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\TextColumn::make('sku'),
                Tables\Columns\TextColumn::make('price')
                    ->money('USD'),
                Tables\Columns\TextColumn::make('quantity'),
                Tables\Columns\TextColumn::make('price')
                    ->label('Subtotal')
                    ->money('USD')
                    ->state(fn ($record) => $record->price * $record->quantity),
            ]);
    }
}
```

- [ ] **Step 3: Create ViewOrder page**

```php
<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewOrder extends ViewRecord
{
    protected static string $resource = OrderResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
```

- [ ] **Step 4: Create ListOrders page**

```php
<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\ListRecords;

class ListOrders extends ListRecords
{
    protected static string $resource = OrderResource::class;
}
```

No CreateOrder page — orders are created programmatically from checkout.

---

### Task 10: RepairOrderResource

**Files:**
- Create: `app/Filament/Resources/RepairOrderResource.php`
- Create: `app/Filament/Resources/RepairOrderResource/Pages/ListRepairOrders.php`
- Create: `app/Filament/Resources/RepairOrderResource/Pages/CreateRepairOrder.php`
- Create: `app/Filament/Resources/RepairOrderResource/Pages/EditRepairOrder.php`
- Create: `app/Filament/Resources/RepairOrderResource/RelationManagers/StatusHistoryManager.php`

- [ ] **Step 1: Create RepairOrderResource**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RepairOrderResource\Pages;
use App\Filament\Resources\RepairOrderResource\RelationManagers\StatusHistoryManager;
use App\Models\RepairOrder;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class RepairOrderResource extends Resource
{
    protected static ?string $model = RepairOrder::class;

    protected static ?string $navigationIcon = 'heroicon-o-wrench';
    protected static ?string $navigationGroup = 'Reparaciones';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make('Información del equipo')
                    ->schema([
                        Forms\Components\TextInput::make('order_number')
                            ->disabled()
                            ->dehydrated(false),
                        Forms\Components\Select::make('customer_id')
                            ->relationship('customer', 'name')
                            ->searchable()
                            ->preload(),
                        Forms\Components\TextInput::make('device_type')
                            ->required()
                            ->maxLength(255),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\TextInput::make('brand')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('model')
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('serial')
                                    ->maxLength(255),
                            ]),
                    ]),
                Forms\Components\Section::make('Diagnóstico')
                    ->schema([
                        Forms\Components\Textarea::make('issue_description')
                            ->required()
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('diagnosed_problem')
                            ->columnSpanFull(),
                    ]),
                Forms\Components\Section::make('Costos y asignación')
                    ->schema([
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('technician_id')
                                    ->relationship('technician', 'name')
                                    ->searchable()
                                    ->preload(),
                                Forms\Components\TextInput::make('estimated_cost')
                                    ->numeric()
                                    ->prefix('USD')
                                    ->step(0.01),
                                Forms\Components\TextInput::make('final_cost')
                                    ->numeric()
                                    ->prefix('USD')
                                    ->step(0.01),
                            ]),
                        Forms\Components\Grid::make(3)
                            ->schema([
                                Forms\Components\Select::make('status')
                                    ->options([
                                        'received' => 'Recibido',
                                        'in_diagnosis' => 'En diagnóstico',
                                        'quote_pending' => 'Cotización pendiente',
                                        'in_repair' => 'En reparación',
                                        'ready' => 'Listo',
                                        'delivered' => 'Entregado',
                                        'cancelled' => 'Cancelado',
                                    ])
                                    ->required(),
                                Forms\Components\TextInput::make('warranty_months')
                                    ->numeric()
                                    ->suffix('meses'),
                                Forms\Components\DateTimePicker::make('received_at'),
                            ]),
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\DateTimePicker::make('ready_at'),
                                Forms\Components\DateTimePicker::make('delivered_at'),
                            ]),
                    ]),
                Forms\Components\Textarea::make('notes')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('order_number')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('device_type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('technician.name')
                    ->label('Técnico')
                    ->sortable(),
                Tables\Columns\SelectColumn::make('status')
                    ->options([
                        'received' => 'Recibido',
                        'in_diagnosis' => 'En diagnóstico',
                        'quote_pending' => 'Cotización pendiente',
                        'in_repair' => 'En reparación',
                        'ready' => 'Listo',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ]),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'received' => 'Recibido',
                        'in_diagnosis' => 'En diagnóstico',
                        'quote_pending' => 'Cotización pendiente',
                        'in_repair' => 'En reparación',
                        'ready' => 'Listo',
                        'delivered' => 'Entregado',
                        'cancelled' => 'Cancelado',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [
            StatusHistoryManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRepairOrders::route('/'),
            'create' => Pages\CreateRepairOrder::route('/create'),
            'edit' => Pages\EditRepairOrder::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 2: Create StatusHistoryManager (timeline read-only)**

```php
<?php

namespace App\Filament\Resources\RepairOrderResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class StatusHistoryManager extends RelationManager
{
    protected static string $relationship = 'statusHistories';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('status')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Textarea::make('note'),
                Forms\Components\Select::make('created_by')
                    ->relationship('creator', 'name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('status')
            ->columns([
                Tables\Columns\TextColumn::make('status'),
                Tables\Columns\TextColumn::make('note')
                    ->limit(50),
                Tables\Columns\TextColumn::make('creator.name')
                    ->label('Creado por'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
```

- [ ] **Step 3: Create the 3 pages** (ListRepairOrders, CreateRepairOrder, EditRepairOrder)

---

### Task 11: PaymentMethodResource + ExchangeRateResource

**Files:**
- Create: `app/Filament/Resources/PaymentMethodResource.php`
- Create: `app/Filament/Resources/PaymentMethodResource/Pages/*.php` (3 pages)
- Create: `app/Filament/Resources/ExchangeRateResource.php`
- Create: `app/Filament/Resources/ExchangeRateResource/Pages/*.php` (3 pages)

- [ ] **Step 1: Create PaymentMethodResource**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PaymentMethodResource\Pages;
use App\Models\PaymentMethod;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class PaymentMethodResource extends Resource
{
    protected static ?string $model = PaymentMethod::class;

    protected static ?string $navigationIcon = 'heroicon-o-credit-card';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255)
                    ->unique(PaymentMethod::class, 'code', ignoreRecord: true),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Select::make('gateway')
                    ->options([
                        'manual' => 'Manual',
                        'pago_movil' => 'Pago Móvil',
                        'binance' => 'Binance',
                        'transfer' => 'Transferencia',
                        'zelle' => 'Zelle',
                        'card' => 'Tarjeta',
                        'cash' => 'Efectivo',
                    ])
                    ->default('manual')
                    ->required(),
                Forms\Components\KeyValue::make('instructions')
                    ->label('Instrucciones'),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\TextInput::make('sort_order')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('gateway')
                    ->badge(),
                Tables\Columns\IconColumn::make('is_active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->numeric()
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPaymentMethods::route('/'),
            'create' => Pages\CreatePaymentMethod::route('/create'),
            'edit' => Pages\EditPaymentMethod::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 2: Create ExchangeRateResource**

```php
<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ExchangeRateResource\Pages;
use App\Models\ExchangeRate;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class ExchangeRateResource extends Resource
{
    protected static ?string $model = ExchangeRate::class;

    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';
    protected static ?string $navigationGroup = 'Sistema';
    protected static ?int $navigationSort = 2;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('base')
                    ->default('USD')
                    ->disabled()
                    ->dehydrated(false)
                    ->required(),
                Forms\Components\TextInput::make('quote')
                    ->default('VES')
                    ->disabled()
                    ->dehydrated(false)
                    ->required(),
                Forms\Components\TextInput::make('rate')
                    ->required()
                    ->numeric()
                    ->step(0.0001),
                Forms\Components\Select::make('source')
                    ->options([
                        'manual' => 'Manual',
                        'bcv' => 'BCV',
                    ])
                    ->default('manual')
                    ->required(),
                Forms\Components\DateTimePicker::make('fetched_at')
                    ->default(now()),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('base')
                    ->searchable(),
                Tables\Columns\TextColumn::make('quote')
                    ->searchable(),
                Tables\Columns\TextColumn::make('rate')
                    ->numeric(4)
                    ->sortable(),
                Tables\Columns\TextColumn::make('source')
                    ->badge(),
                Tables\Columns\TextColumn::make('fetched_at')
                    ->dateTime()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListExchangeRates::route('/'),
            'create' => Pages\CreateExchangeRate::route('/create'),
            'edit' => Pages\EditExchangeRate::route('/{record}/edit'),
        ];
    }
}
```

- [ ] **Step 3: Create pages for both** (same pattern — List, Create, Edit for each)

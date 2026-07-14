@extends('layouts.store')

@section('title', 'VHTtech Store — Tecnología para gamers y profesionales')

@section('extra_styles')
    /* HERO */
    .hero-section{padding:1.875rem 0;background:var(--color-background);border-bottom:1px solid var(--color-theme-border)}
    .hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.875rem}
    .hero-card{position:relative;border-radius:var(--border-radius);overflow:hidden;min-height:300px;display:flex;align-items:center;padding:2.5rem 3.125rem;color:#fff;text-decoration:none}
    .hero-card:hover{color:#fff}
    .hero-card.primary{background:linear-gradient(135deg,var(--color-primary) 0%,#0a3a6e 100%)}
    .hero-card.secondary{background:linear-gradient(135deg,#1a1a2e 0%,#16213e 100%)}
    .hero-card .hero-content{max-width:70%}
    .hero-card .hero-sub{font-size:.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:.625rem;opacity:.8}
    .hero-card .hero-title{font-size:1.875rem;font-weight:800;line-height:1.2;margin-bottom:1rem}
    .hero-card .hero-desc{font-size:.9375rem;margin-bottom:1.5rem;opacity:.8;line-height:1.5}
    .hero-card .hero-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.875rem;background:var(--color-secondary);color:var(--color-main-text);border-radius:4px;font-weight:600;font-size:.875rem;text-decoration:none;transition:opacity .15s}
    .hero-card .hero-btn:hover{opacity:.9;color:var(--color-main-text)}
    .hero-card .hero-highlight{color:var(--color-secondary)}

    /* SECTIONS */
    .section{padding:2.5rem 0}
    .section-title{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding-bottom:.75rem;border-bottom:1px solid var(--color-theme-border)}
    .section-title h2{font-size:1.25rem;font-weight:700;color:var(--color-main-text)}
    .section-title a{font-size:.8125rem;color:var(--color-text-light);text-decoration:none}
    .section-title a:hover{color:var(--color-main-text)}

    .category-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:1rem}
    .category-card{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1.25rem .75rem;background:var(--color-background);border:1px solid var(--color-theme-border);border-radius:var(--border-radius);text-decoration:none;color:var(--color-main-text);transition:box-shadow .2s}
    .category-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.08)}
    .category-card .cat-icon{width:3rem;height:3rem;display:flex;align-items:center;justify-content:center;margin-bottom:.75rem;font-size:1.75rem;color:var(--color-primary)}
    .category-card .cat-name{font-size:.8125rem;font-weight:600;text-align:center;line-height:1.2}

    .banner-section{padding:1.25rem 0}
    .banner-card{position:relative;border-radius:var(--border-radius);overflow:hidden;min-height:220px;display:flex;align-items:center;padding:2.5rem;color:#fff;background:linear-gradient(135deg,#0d2b50,#1a4a7a)}
    .banner-card .banner-content{max-width:55%}
    .banner-card .banner-sub{font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;opacity:.7;margin-bottom:.5rem}
    .banner-card .banner-title{font-size:1.5rem;font-weight:700;line-height:1.2;margin-bottom:1rem}
    .banner-card .banner-btn{display:inline-flex;align-items:center;gap:.375rem;padding:.625rem 1.5rem;background:var(--color-secondary);color:var(--color-main-text);border-radius:4px;font-weight:600;font-size:.8125rem;text-decoration:none;transition:opacity .15s}
    .banner-card .banner-btn:hover{opacity:.9;color:var(--color-main-text)}
    .banner-card .banner-visual{position:absolute;right:1.875rem;top:50%;transform:translateY(-50%);font-size:5rem;opacity:.15}

    .features-bar{background:var(--color-background);border-top:1px solid var(--color-theme-border);border-bottom:1px solid var(--color-theme-border);padding:1.5625rem 0}
    .features-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.875rem}
    .feature-item{display:flex;align-items:center;gap:.9375rem}
    .feature-item .feat-icon{font-size:1.75rem;color:var(--color-primary);flex-shrink:0}
    .feature-item .feat-title{font-size:.8125rem;font-weight:600;margin-bottom:.1875rem;color:var(--color-main-text)}
    .feature-item .feat-desc{font-size:.75rem;color:var(--color-text-light)}

    @media(max-width:992px){
        .hero-grid{grid-template-columns:1fr}
        .category-grid{grid-template-columns:repeat(3,1fr)}
        .features-grid{grid-template-columns:repeat(2,1fr);gap:1.25rem}
    }
    @media(max-width:768px){
        .hero-card .hero-content{max-width:100%}
    }
@endsection

@section('content')
{{-- HERO --}}
<section class="hero-section">
    <div class="container">
        <div class="hero-grid">
            <a href="#" class="hero-card primary">
                <div class="hero-content">
                    <div class="hero-sub">Reacondicionados certificados</div>
                    <h1 class="hero-title">Tecnología al <span class="hero-highlight">mejor precio</span></h1>
                    <p class="hero-desc">Equipos reacondicionados con garantía de 12 meses. Calidad garantizada, ahorro asegurado.</p>
                    <span class="hero-btn">Ver catálogo <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></span>
                </div>
            </a>
            <a href="#" class="hero-card secondary">
                <div class="hero-content">
                    <div class="hero-sub">Nuevos ingresos</div>
                    <h1 class="hero-title">Componentes <span class="hero-highlight">gaming</span> 2025</h1>
                    <p class="hero-desc">Los últimos procesadores, GPUs y periféricos para llevar tu setup al siguiente nivel.</p>
                    <span class="hero-btn">Explorar <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></span>
                </div>
            </a>
        </div>
    </div>
</section>

{{-- CATEGORIES --}}
<section class="section">
    <div class="container">
        <div class="section-title">
            <h2>Categorías</h2>
            <a href="#">Ver todas →</a>
        </div>
        <div class="category-grid">
            @php $icons = ['🖥️','💻','📱','⌨️','🎧','🔧']; @endphp
            @forelse(\App\Models\Category::take(6)->get() as $cat)
            <a href="#" class="category-card">
                <div class="cat-icon">{{ $icons[$loop->index % 6] }}</div>
                <div class="cat-name">{{ $cat->name }}</div>
            </a>
            @empty
                @foreach(['Laptops','Componentes','Periféricos','Monitores','Accesorios','Audio'] as $i => $name)
                <a href="#" class="category-card">
                    <div class="cat-icon">{{ $icons[$i] }}</div>
                    <div class="cat-name">{{ $name }}</div>
                </a>
                @endforeach
            @endforelse
        </div>
    </div>
</section>

{{-- FEATURED PRODUCTS --}}
@php $products = \App\Models\Product::active()->with(['brand','primaryImage'])->take(8)->get(); @endphp

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section-title">
            <h2>Productos destacados</h2>
            <a href="#">Ver todos →</a>
        </div>
        <div class="product-grid">
            @forelse($products as $product)
            <div class="product-card">
                <div class="card-badge">
                    @if($product->is_featured)<span class="feat">Destacado</span>@endif
                    @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                </div>
                <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                    @if($product->primaryImage->first())
                        <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}">
                    @else
                        <svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    @endif
                </a>
                <div class="card-body">
                    @if($product->brand)<div class="card-brand">{{ $product->brand->name }}</div>@endif
                    <a href="{{ route('products.show', $product->slug) }}" class="card-title">{{ $product->name }}</a>
                    <div class="card-price">${{ number_format($product->base_price, 2) }}<span class="price-bs">Bs. {{ number_format($product->base_price * ($exchangeRate?->rate ?? 0), 2, ',', '.') }}</span></div>
                    @if($product->short_description)
                    <div class="card-meta">{{ Str::limit($product->short_description, 60) }}</div>
                    @endif
                </div>
                <div class="card-actions">
                    <a href="{{ route('products.show', $product->slug) }}" class="btn-cart">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                        Ver producto
                    </a>
                    <button class="btn-wish">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                    </button>
                </div>
            </div>
            @empty
                @for($i = 0; $i < 4; $i++)
                <div class="product-card" style="opacity:.6">
                    <a href="#" class="card-thumb">
                        <svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    </a>
                    <div class="card-body">
                        <div class="card-brand">—</div>
                        <a href="#" class="card-title">Producto de ejemplo</a>
                        <div class="card-price">$0.00<span class="price-bs">Bs. 0,00</span></div>
                    </div>
                    <div class="card-actions">
                        <a href="#" class="btn-cart">Ver producto</a>
                        <button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>
                    </div>
                </div>
                @endfor
            @endforelse
        </div>
    </div>
</section>

{{-- BANNER --}}
<section class="banner-section">
    <div class="container">
        <div class="banner-card">
            <div class="banner-content">
                <div class="banner-sub">Equipos reacondicionados</div>
                <h2 class="banner-title">Hasta <strong style="color:var(--color-secondary)">40% OFF</strong> en laptops certificadas</h2>
                <a href="#" class="banner-btn">Ver ofertas <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></a>
            </div>
            <div class="banner-visual">💻</div>
        </div>
    </div>
</section>

{{-- NEW ARRIVALS --}}
@php $newProducts = \App\Models\Product::active()->latest()->take(4)->get(); @endphp
@if($newProducts->isNotEmpty())
<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section-title">
            <h2>Nuevos productos</h2>
            <a href="#">Ver todos →</a>
        </div>
        <div class="product-grid">
            @foreach($newProducts as $product)
            <div class="product-card">
                <div class="card-badge">
                    <span class="feat">Nuevo</span>
                    @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                </div>
                <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                    @if($product->primaryImage->first())
                        <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}">
                    @else
                        <svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                    @endif
                </a>
                <div class="card-body">
                    @if($product->brand)<div class="card-brand">{{ $product->brand->name }}</div>@endif
                    <a href="{{ route('products.show', $product->slug) }}" class="card-title">{{ $product->name }}</a>
                    <div class="card-price">${{ number_format($product->base_price, 2) }}<span class="price-bs">Bs. {{ number_format($product->base_price * ($exchangeRate?->rate ?? 0), 2, ',', '.') }}</span></div>
                </div>
                <div class="card-actions">
                    <a href="{{ route('products.show', $product->slug) }}" class="btn-cart">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                        Ver producto
                    </a>
                    <button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FEATURES --}}
<section class="features-bar">
    <div class="container">
        <div class="features-grid">
            <div class="feature-item">
                <div class="feat-icon">🚚</div>
                <div><div class="feat-title">Envío rápido</div><div class="feat-desc">Entregas en 24-72 hrs</div></div>
            </div>
            <div class="feature-item">
                <div class="feat-icon">🛡️</div>
                <div><div class="feat-title">Garantía incluida</div><div class="feat-desc">12 meses en todos los equipos</div></div>
            </div>
            <div class="feature-item">
                <div class="feat-icon">💳</div>
                <div><div class="feat-title">Pago seguro</div><div class="feat-desc">Múltiples métodos de pago</div></div>
            </div>
            <div class="feature-item">
                <div class="feat-icon">↩️</div>
                <div><div class="feat-title">Devoluciones</div><div class="feat-desc">30 días de garantía</div></div>
            </div>
        </div>
    </div>
</section>
@endsection

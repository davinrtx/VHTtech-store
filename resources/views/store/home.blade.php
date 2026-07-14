@extends('layouts.store')

@section('title', 'VHTtech Store — Tecnología para gamers y profesionales')

@section('extra_styles')
    /* HERO */
    .hero-section{padding:1.875rem 0;background:var(--color-background);border-bottom:1px solid var(--color-theme-border)}
    .hero-grid{display:grid;grid-template-columns:1fr 1fr;gap:1.875rem}
    .hero-card{position:relative;border-radius:var(--border-radius);overflow:hidden;min-height:300px;display:flex;align-items:center;padding:2.5rem 3.125rem;color:#fff;text-decoration:none}
    .hero-card:hover{color:#fff}
    .hero-card.primary{background:linear-gradient(135deg,#1565C0 0%,#0d47a1 100%)}
    .hero-card.secondary{background:linear-gradient(135deg,#333e48 0%,#1a252f 100%)}
    .hero-card .hero-content{max-width:70%}
    .hero-card .hero-sub{font-size:.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;margin-bottom:.625rem;opacity:.8}
    .hero-card .hero-title{font-size:1.875rem;font-weight:800;line-height:1.2;margin-bottom:1rem}
    .hero-card .hero-desc{font-size:.9375rem;margin-bottom:1.5rem;opacity:.8;line-height:1.5}
    .hero-card .hero-btn{display:inline-flex;align-items:center;gap:.5rem;padding:.75rem 1.875rem;background:var(--color-primary);color:#fff;border-radius:4px;font-weight:600;font-size:.875rem;text-decoration:none;transition:opacity .15s}
    .hero-card .hero-btn:hover{opacity:.9;color:#fff}
    .hero-card .hero-highlight{color:#64b5f6}

    /* SECTIONS */
    .section{padding:2.5rem 0}
    .section-title{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem;padding-bottom:.75rem;border-bottom:1px solid var(--color-theme-border)}
    .section-title h2{font-size:1.25rem;font-weight:700;color:var(--color-main-text)}
    .section-title a{font-size:.8125rem;color:var(--color-text-light);text-decoration:none}
    .section-title a:hover{color:var(--color-main-text)}

    .banner-section{padding:1.25rem 0}
    .banner-card{position:relative;border-radius:var(--border-radius);overflow:hidden;min-height:220px;display:flex;align-items:center;padding:2.5rem;color:#fff;background:linear-gradient(135deg,#1565C0,#0d47a1)}
    .banner-card .banner-content{max-width:55%}
    .banner-card .banner-sub{font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:1px;opacity:.7;margin-bottom:.5rem}
    .banner-card .banner-title{font-size:1.5rem;font-weight:700;line-height:1.2;margin-bottom:1rem}
    .banner-card .banner-btn{display:inline-flex;align-items:center;gap:.375rem;padding:.625rem 1.5rem;background:var(--color-secondary);color:#fff;border-radius:4px;font-weight:600;font-size:.8125rem;text-decoration:none;transition:opacity .15s}
    .banner-card .banner-btn:hover{opacity:.9;color:#fff}
    .banner-card .banner-visual{position:absolute;right:1.875rem;top:50%;transform:translateY(-50%);font-size:5rem;opacity:.15}

    .features-bar{background:var(--color-background);border-top:1px solid var(--color-theme-border);border-bottom:1px solid var(--color-theme-border);padding:1.5625rem 0}
    .features-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.875rem}
    .feature-item{display:flex;align-items:center;gap:.9375rem}
    .feature-item .feat-icon{font-size:1.75rem;color:var(--color-primary);flex-shrink:0}
    .feature-item .feat-title{font-size:.8125rem;font-weight:600;margin-bottom:.1875rem;color:var(--color-main-text)}
    .feature-item .feat-desc{font-size:.75rem;color:var(--color-text-light)}

    @media(max-width:992px){
        .hero-grid{grid-template-columns:1fr}
        .features-grid{grid-template-columns:repeat(2,1fr);gap:1.25rem}
    }
    @media(max-width:768px){
        .hero-card .hero-content{max-width:100%}
    }
@endsection

@section('content')
{{-- ======================== --}}
{{-- HERO SECTION             --}}
{{-- ======================== --}}
<section class="hero-section">
    <div class="container">
        <div class="hero-grid">
            <a href="{{ route('search.results', ['categoria' => 'laptops']) }}" class="hero-card primary">
                <div class="hero-content">
                    <div class="hero-sub">Reacondicionados certificados</div>
                    <h1 class="hero-title">Tecnología al <span class="hero-highlight">mejor precio</span></h1>
                    <p class="hero-desc">Equipos reacondicionados con garantía de 12 meses. Calidad garantizada, ahorro asegurado.</p>
                    <span class="hero-btn">Ver catálogo <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></span>
                </div>
            </a>
            <a href="{{ route('search.results', ['orden' => 'newest']) }}" class="hero-card secondary">
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

{{-- ======================== --}}
{{-- BEST SELLERS TABS CAROUSEL --}}
{{-- ======================== --}}
@php
    $bestSellers = \App\Models\Product::active()->with(['brand','primaryImage'])->take(12)->get();
    $tabCategories = \App\Models\Category::where('is_active', true)->take(4)->get();
@endphp

<section class="section" x-data="tabsCarousel()">
    <div class="container">
        <div class="product-tabs-v5">
            <h3 class="pt-title">Los más vendidos</h3>
            <div class="pt-nav">
                <button :class="{ active: activeTab === 'all' }" @click="activeTab = 'all'">Todos</button>
                @foreach($tabCategories as $cat)
                    <button :class="{ active: activeTab === '{{ $cat->slug }}' }" @click="activeTab = '{{ $cat->slug }}'">{{ $cat->name }}</button>
                @endforeach
            </div>
            <a href="{{ route('search.results') }}" class="pt-action">Ver todos →</a>
        </div>

        <div class="ec-carousel" x-data="ecCarousel()">
            <div class="ec-nav">
                <button @click="scroll(-1)" :disabled="atStart" aria-label="Anterior">‹</button>
                <button @click="scroll(1)" :disabled="atEnd" aria-label="Siguiente">›</button>
            </div>
            <div class="ec-track" x-ref="track" @scroll="update">
                @forelse($bestSellers as $product)
                    <div class="product-card" x-show="activeTab === 'all' || activeTab === '{{ $product->categories->first()?->slug ?? 'all' }}'"
                         x-transition:enter.duration.200ms>
                        <div class="card-badge">
                            @if($product->is_featured)<span class="feat">Destacado</span>@endif
                            @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                            @if($product->primaryImage->first())
                                <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}" loading="lazy">
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
                                Añadir al carrito
                            </a>
                            <button class="btn-wish">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            </button>
                        </div>
                    </div>
                @empty
                    @for($i = 0; $i < 6; $i++)
                    <div class="product-card" style="opacity:.6">
                        <a href="#" class="card-thumb"><svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></a>
                        <div class="card-body"><div class="card-brand">—</div><a href="#" class="card-title">Producto de ejemplo</a><div class="card-price">$0.00<span class="price-bs">Bs. 0,00</span></div></div>
                        <div class="card-actions"><a href="#" class="btn-cart">Añadir</a><button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button></div>
                    </div>
                    @endfor
                @endforelse
            </div>
            <div class="ec-dots" x-show="pages > 1">
                <template x-for="(p, i) in pages" :key="i">
                    <button :class="{ active: i === currentPage }" @click="goTo(i)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- DEAL COUNTDOWN            --}}
{{-- ======================== --}}
@php
    $dealProducts = \App\Models\Product::active()->where('is_featured', true)->with(['brand','primaryImage'])->take(6)->get();
@endphp

<section class="section" x-data="countdownTimer({{ now()->addDays(7)->timestamp }})">
    <div class="container">
        <div class="deal-section">
            <div class="deal-header">
                <div class="dh-left">
                    <h3 class="dh-title">⚡ Ofertas relámpago</h3>
                    <div class="deal-countdown">
                        <div class="cd-item">
                            <span class="cd-value" x-text="pad(days)">00</span>
                            <span class="cd-label">Días</span>
                        </div>
                        <div class="cd-item">
                            <span class="cd-value" x-text="pad(hours)">00</span>
                            <span class="cd-label">Horas</span>
                        </div>
                        <div class="cd-item">
                            <span class="cd-value" x-text="pad(minutes)">00</span>
                            <span class="cd-label">Min</span>
                        </div>
                        <div class="cd-item">
                            <span class="cd-value" x-text="pad(seconds)">00</span>
                            <span class="cd-label">Seg</span>
                        </div>
                    </div>
                    <span class="dh-subtitle">Aprovechá estas ofertas por tiempo limitado</span>
                </div>
            </div>

            <div class="ec-carousel" x-data="ecCarousel()">
                <div class="ec-nav">
                    <button @click="scroll(-1)" :disabled="atStart" aria-label="Anterior">‹</button>
                    <button @click="scroll(1)" :disabled="atEnd" aria-label="Siguiente">›</button>
                </div>
                <div class="ec-track" x-ref="track" @scroll="update">
                    @forelse($dealProducts as $product)
                        <div class="product-card">
                            <div class="card-badge">
                                <span class="feat">Oferta</span>
                                @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                            </div>
                            <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                                @if($product->primaryImage->first())
                                    <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}" loading="lazy">
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
                                    Añadir al carrito
                                </a>
                                <button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>
                            </div>
                        </div>
                    @empty
                        @for($i = 0; $i < 6; $i++)
                        <div class="product-card" style="opacity:.6">
                            <a href="#" class="card-thumb"><svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></a>
                            <div class="card-body"><div class="card-brand">—</div><a href="#" class="card-title">Producto de ejemplo</a><div class="card-price">$0.00<span class="price-bs">Bs. 0,00</span></div></div>
                            <div class="card-actions"><a href="#" class="btn-cart">Añadir</a><button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button></div>
                        </div>
                        @endfor
                    @endforelse
                </div>
                <div class="ec-dots" x-show="pages > 1">
                    <template x-for="(p, i) in pages" :key="i">
                        <button :class="{ active: i === currentPage }" @click="goTo(i)"></button>
                    </template>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- PRODUCT TABS DISCOUNTS    --}}
{{-- ======================== --}}
@php
    $allActive = \App\Models\Product::active()->with(['brand','primaryImage'])->take(20)->get();
@endphp

<section class="section" x-data="discountTabs()">
    <div class="container">
        <div class="product-tabs-v5">
            <h3 class="pt-title">Descuentos por volumen</h3>
            <div class="pt-nav">
                <button :class="{ active: activeTab === 'all' }" @click="activeTab = 'all'">Todos</button>
                <button :class="{ active: activeTab === 'menor80' }" @click="activeTab = 'menor80'">-80%</button>
                <button :class="{ active: activeTab === 'menor65' }" @click="activeTab = 'menor65'">-65%</button>
                <button :class="{ active: activeTab === 'menor45' }" @click="activeTab = 'menor45'">-45%</button>
                <button :class="{ active: activeTab === 'menor25' }" @click="activeTab = 'menor25'">-25%</button>
            </div>
            <a href="{{ route('search.results') }}" class="pt-action">Ver todos →</a>
        </div>

        <div class="ec-carousel" x-data="ecCarousel()">
            <div class="ec-nav">
                <button @click="scroll(-1)" :disabled="atStart" aria-label="Anterior">‹</button>
                <button @click="scroll(1)" :disabled="atEnd" aria-label="Siguiente">›</button>
            </div>
            <div class="ec-track" x-ref="track" @scroll="update">
                @forelse($allActive as $product)
                    <div class="product-card">
                        <div class="card-badge">
                            @if($product->is_featured)<span class="feat">Destacado</span>@endif
                            @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                            @if($product->primaryImage->first())
                                <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}" loading="lazy">
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
                                Añadir al carrito
                            </a>
                            <button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>
                        </div>
                    </div>
                @empty
                    @for($i = 0; $i < 6; $i++)
                    <div class="product-card" style="opacity:.6">
                        <a href="#" class="card-thumb"><svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></a>
                        <div class="card-body"><div class="card-brand">—</div><a href="#" class="card-title">Producto</a><div class="card-price">$0.00<span class="price-bs">Bs. 0,00</span></div></div>
                        <div class="card-actions"><a href="#" class="btn-cart">Añadir</a><button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button></div>
                    </div>
                    @endfor
                @endforelse
            </div>
            <div class="ec-dots" x-show="pages > 1">
                <template x-for="(p, i) in pages" :key="i">
                    <button :class="{ active: i === currentPage }" @click="goTo(i)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- ADS BLOCK                 --}}
{{-- ======================== --}}
<section class="section" style="padding-top:0">
    <div class="container">
        <div class="ads-block">
            <a href="{{ route('search.results', ['categoria' => 'laptops']) }}" class="ad-card">
                <div class="ad-content">
                    <div class="ad-text">Laptops <strong>reacondicionadas</strong> con garantía</div>
                    <div class="ad-price">
                        <span class="prefix">Desde</span>
                        <span class="value">$<sup>299</sup><span style="font-size:1rem;font-weight:400;color:var(--color-text-light)">,99</span></span>
                    </div>
                </div>
                <div class="ad-visual">💻</div>
            </a>
            <a href="{{ route('search.results', ['categoria' => 'accesorios']) }}" class="ad-card">
                <div class="ad-content">
                    <div class="ad-text">Accesorios <strong>gaming</strong> con hasta 30% OFF</div>
                    <span class="ad-btn">Ver ofertas →</span>
                </div>
                <div class="ad-visual">🎮</div>
            </a>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- TRENDING PRODUCTS CAROUSEL --}}
{{-- ======================== --}}
@php
    $trending = \App\Models\Product::active()->inRandomOrder()->with(['brand','primaryImage'])->take(10)->get();
@endphp

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section-title">
            <h2>🔥 Tendencias</h2>
            <a href="{{ route('search.results') }}">Ver todos →</a>
        </div>
        <div class="ec-carousel" x-data="ecCarousel()">
            <div class="ec-nav">
                <button @click="scroll(-1)" :disabled="atStart" aria-label="Anterior">‹</button>
                <button @click="scroll(1)" :disabled="atEnd" aria-label="Siguiente">›</button>
            </div>
            <div class="ec-track" x-ref="track" @scroll="update">
                @forelse($trending as $product)
                    <div class="product-card">
                        <div class="card-badge">
                            @if($product->is_featured)<span class="feat">Trending</span>@endif
                            @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                            @if($product->primaryImage->first())
                                <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}" loading="lazy">
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
                                Añadir al carrito
                            </a>
                            <button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>
                        </div>
                    </div>
                @empty
                    @for($i = 0; $i < 5; $i++)
                    <div class="product-card" style="opacity:.6">
                        <a href="#" class="card-thumb"><svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></a>
                        <div class="card-body"><div class="card-brand">—</div><a href="#" class="card-title">Producto</a><div class="card-price">$0.00<span class="price-bs">Bs. 0,00</span></div></div>
                        <div class="card-actions"><a href="#" class="btn-cart">Añadir</a><button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button></div>
                    </div>
                    @endfor
                @endforelse
            </div>
            <div class="ec-dots" x-show="pages > 1">
                <template x-for="(p, i) in pages" :key="i">
                    <button :class="{ active: i === currentPage }" @click="goTo(i)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- POPULAR PRODUCTS CAROUSEL --}}
{{-- ======================== --}}
@php
    $popular = \App\Models\Product::active()->where('is_featured', true)->orWhere('is_refurbished', true)->with(['brand','primaryImage'])->take(10)->get();
@endphp

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section-title">
            <h2>⭐ Más populares</h2>
            <a href="{{ route('search.results') }}">Ver todos →</a>
        </div>
        <div class="ec-carousel" x-data="ecCarousel()">
            <div class="ec-nav">
                <button @click="scroll(-1)" :disabled="atStart" aria-label="Anterior">‹</button>
                <button @click="scroll(1)" :disabled="atEnd" aria-label="Siguiente">›</button>
            </div>
            <div class="ec-track" x-ref="track" @scroll="update">
                @forelse($popular as $product)
                    <div class="product-card">
                        <div class="card-badge">
                            @if($product->is_featured)<span class="feat">Popular</span>@endif
                            @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                            @if($product->primaryImage->first())
                                <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}" loading="lazy">
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
                                Añadir al carrito
                            </a>
                            <button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>
                        </div>
                    </div>
                @empty
                    @for($i = 0; $i < 5; $i++)
                    <div class="product-card" style="opacity:.6">
                        <a href="#" class="card-thumb"><svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></a>
                        <div class="card-body"><div class="card-brand">—</div><a href="#" class="card-title">Producto</a><div class="card-price">$0.00<span class="price-bs">Bs. 0,00</span></div></div>
                        <div class="card-actions"><a href="#" class="btn-cart">Añadir</a><button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button></div>
                    </div>
                    @endfor
                @endforelse
            </div>
            <div class="ec-dots" x-show="pages > 1">
                <template x-for="(p, i) in pages" :key="i">
                    <button :class="{ active: i === currentPage }" @click="goTo(i)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- FULL WIDTH BANNER         --}}
{{-- ======================== --}}
<section class="banner-section">
    <div class="container">
        <div class="banner-card">
            <div class="banner-content">
                <div class="banner-sub">Equipos reacondicionados</div>
                <h2 class="banner-title">Hasta <strong style="color:#64b5f6">40% OFF</strong> en laptops certificadas</h2>
                <a href="{{ route('search.results', ['categoria' => 'laptops']) }}" class="banner-btn">Ver ofertas <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m9 18 6-6-6-6"/></svg></a>
            </div>
            <div class="banner-visual">💻</div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- LAPTOPS & COMPUTERS CAROUSEL --}}
{{-- ======================== --}}
@php
    $laptopsCategory = \App\Models\Category::where('slug', 'laptops')->orWhere('name', 'like', '%laptop%')->orWhere('name', 'like', '%computador%')->first();
    $laptops = $laptopsCategory
        ? $laptopsCategory->products()->active()->with(['brand','primaryImage'])->take(10)->get()
        : \App\Models\Product::active()->with(['brand','primaryImage'])->take(10)->get();
@endphp

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section-title">
            <h2>💻 Laptops & Computación</h2>
            <a href="{{ route('search.results', ['categoria' => $laptopsCategory?->slug ?? '']) }}">Ver todos →</a>
        </div>
        <div class="ec-carousel" x-data="ecCarousel()">
            <div class="ec-nav">
                <button @click="scroll(-1)" :disabled="atStart" aria-label="Anterior">‹</button>
                <button @click="scroll(1)" :disabled="atEnd" aria-label="Siguiente">›</button>
            </div>
            <div class="ec-track" x-ref="track" @scroll="update">
                @forelse($laptops as $product)
                    <div class="product-card">
                        <div class="card-badge">
                            @if($product->is_featured)<span class="feat">Destacado</span>@endif
                            @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                            @if($product->primaryImage->first())
                                <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}" loading="lazy">
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
                                Añadir al carrito
                            </a>
                            <button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>
                        </div>
                    </div>
                @empty
                    @for($i = 0; $i < 5; $i++)
                    <div class="product-card" style="opacity:.6">
                        <a href="#" class="card-thumb"><svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></a>
                        <div class="card-body"><div class="card-brand">—</div><a href="#" class="card-title">Producto</a><div class="card-price">$0.00<span class="price-bs">Bs. 0,00</span></div></div>
                        <div class="card-actions"><a href="#" class="btn-cart">Añadir</a><button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button></div>
                    </div>
                    @endfor
                @endforelse
            </div>
            <div class="ec-dots" x-show="pages > 1">
                <template x-for="(p, i) in pages" :key="i">
                    <button :class="{ active: i === currentPage }" @click="goTo(i)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- TELEVISION & ENTERTAINMENT CAROUSEL --}}
{{-- ======================== --}}
@php
    $tvCategory = \App\Models\Category::where('slug', 'television')->orWhere('name', 'like', '%tv%')->orWhere('name', 'like', '%televis%')->orWhere('name', 'like', '%monitor%')->first();
    $tvProducts = $tvCategory
        ? $tvCategory->products()->active()->with(['brand','primaryImage'])->take(10)->get()
        : \App\Models\Product::active()->inRandomOrder()->with(['brand','primaryImage'])->take(10)->get();
@endphp

<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section-title">
            <h2>📺 TV & Entretenimiento</h2>
            <a href="{{ route('search.results', ['categoria' => $tvCategory?->slug ?? '']) }}">Ver todos →</a>
        </div>
        <div class="ec-carousel" x-data="ecCarousel()">
            <div class="ec-nav">
                <button @click="scroll(-1)" :disabled="atStart" aria-label="Anterior">‹</button>
                <button @click="scroll(1)" :disabled="atEnd" aria-label="Siguiente">›</button>
            </div>
            <div class="ec-track" x-ref="track" @scroll="update">
                @forelse($tvProducts as $product)
                    <div class="product-card">
                        <div class="card-badge">
                            @if($product->is_featured)<span class="feat">Destacado</span>@endif
                            @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                        </div>
                        <a href="{{ route('products.show', $product->slug) }}" class="card-thumb">
                            @if($product->primaryImage->first())
                                <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}" loading="lazy">
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
                                Añadir al carrito
                            </a>
                            <button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button>
                        </div>
                    </div>
                @empty
                    @for($i = 0; $i < 5; $i++)
                    <div class="product-card" style="opacity:.6">
                        <a href="#" class="card-thumb"><svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg></a>
                        <div class="card-body"><div class="card-brand">—</div><a href="#" class="card-title">Producto</a><div class="card-price">$0.00<span class="price-bs">Bs. 0,00</span></div></div>
                        <div class="card-actions"><a href="#" class="btn-cart">Añadir</a><button class="btn-wish"><svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg></button></div>
                    </div>
                    @endfor
                @endforelse
            </div>
            <div class="ec-dots" x-show="pages > 1">
                <template x-for="(p, i) in pages" :key="i">
                    <button :class="{ active: i === currentPage }" @click="goTo(i)"></button>
                </template>
            </div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- CATEGORIES BLOCK           --}}
{{-- ======================== --}}
@php $allCats = \App\Models\Category::where('is_active', true)->take(6)->get(); @endphp
<section class="section" style="padding-top:0">
    <div class="container">
        <div class="section-title">
            <h2>📂 Categorías</h2>
            <a href="{{ route('search.results') }}">Ver todas →</a>
        </div>
        <div class="categories-block">
            <div class="cat-grid">
                @php $catIcons = ['🖥️','💻','📱','⌨️','🎧','🔧']; @endphp
                @forelse($allCats as $cat)
                    <a href="{{ route('search.results', ['categoria' => $cat->slug]) }}" class="cat-item">
                        <div class="cat-icon">{{ $catIcons[$loop->index % 6] }}</div>
                        <div class="cat-name">{{ $cat->name }}</div>
                    </a>
                @empty
                    @foreach(['Laptops','Componentes','Periféricos','Monitores','Accesorios','Audio'] as $i => $name)
                    <a href="{{ route('search.results') }}" class="cat-item">
                        <div class="cat-icon">{{ $catIcons[$i] }}</div>
                        <div class="cat-name">{{ $name }}</div>
                    </a>
                    @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- ADS WITH BANNERS           --}}
{{-- ======================== --}}
<section class="section" style="padding-top:0">
    <div class="container">
        <div class="ads-banners-block">
            <a href="{{ route('search.results', ['categoria' => 'laptops']) }}" class="ads-banner-card bg-1">
                <div class="abc-content">
                    <div class="abc-title">Laptops <strong>reacondicionadas</strong></div>
                    <div class="abc-desc">
                        <span>✅ Certificadas</span>
                        <span>🔧 Garantía 12 meses</span>
                    </div>
                    <div class="abc-price"><span class="prefix">Desde</span><span class="value">$<sup>299</sup></span></div>
                    <span class="abc-btn">Comprar ahora →</span>
                </div>
                <div class="abc-visual">💻</div>
            </a>
            <a href="{{ route('search.results', ['categoria' => 'accesorios']) }}" class="ads-banner-card bg-2">
                <div class="abc-content">
                    <div class="abc-title">Accesorios <strong>gaming</strong></div>
                    <div class="abc-desc">
                        <span>🎮 Teclados</span>
                        <span>🖱️ Mouse</span>
                        <span>🎧 Audífonos</span>
                    </div>
                    <div class="abc-price"><span class="prefix">Hasta</span><span class="value">30% OFF</span></div>
                    <span class="abc-btn">Ver ofertas →</span>
                </div>
                <div class="abc-visual">🎮</div>
            </a>
        </div>
    </div>
</section>

{{-- ======================== --}}
{{-- FEATURES / SERVICES BAR   --}}
{{-- ======================== --}}
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

@push('head-scripts')
<script>
    // Carousel controller
    function ecCarousel() {
        return {
            atStart: true,
            atEnd: false,
            currentPage: 0,
            pages: 0,
            init() {
                this.update();
            },
            update() {
                const el = this.$refs.track;
                if (!el) return;
                const scrollLeft = el.scrollLeft;
                const scrollWidth = el.scrollWidth - el.clientWidth;
                this.atStart = scrollLeft <= 5;
                this.atEnd = scrollLeft >= scrollWidth - 5;
                // Calculate page (page size = 50% of container for accurate dot)
                const pageSize = el.clientWidth * 0.5;
                this.currentPage = Math.round(scrollLeft / pageSize);
                this.pages = Math.ceil(el.scrollWidth / (el.clientWidth * 0.5));
            },
            scroll(dir) {
                const el = this.$refs.track;
                if (!el) return;
                const itemWidth = el.querySelector('.product-card')?.offsetWidth + 20 || 220;
                el.scrollBy({ left: dir * itemWidth * 2.5, behavior: 'smooth' });
            },
            goTo(page) {
                const el = this.$refs.track;
                if (!el) return;
                el.scrollTo({ left: page * el.clientWidth * 0.5, behavior: 'smooth' });
            }
        }
    }

    // Tabs carousel controller (for Best Sellers tab switching)
    function tabsCarousel() {
        return {
            activeTab: 'all'
        }
    }

    // Discount tabs controller
    function discountTabs() {
        return {
            activeTab: 'all'
        }
    }

    // Countdown timer
    function countdownTimer(endTimestamp) {
        return {
            days: '00',
            hours: '00',
            minutes: '00',
            seconds: '00',
            interval: null,
            init() {
                this.tick();
                this.interval = setInterval(() => this.tick(), 1000);
            },
            destroy() {
                if (this.interval) clearInterval(this.interval);
            },
            tick() {
                const now = Math.floor(Date.now() / 1000);
                const diff = Math.max(0, endTimestamp - now);
                this.days = this.pad(Math.floor(diff / 86400));
                this.hours = this.pad(Math.floor((diff % 86400) / 3600));
                this.minutes = this.pad(Math.floor((diff % 3600) / 60));
                this.seconds = this.pad(diff % 60);
            },
            pad(n) {
                return String(n).padStart(2, '0');
            }
        }
    }
</script>
@endpush

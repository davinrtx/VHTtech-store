@extends('layouts.store')

@section('title', $query ? "Búsqueda: {$query} — VHTtech Store" : 'Buscar productos — VHTtech Store')

@section('extra_styles')
/* === SEARCH PAGE === */
.search-page{display:grid;grid-template-columns:260px 1fr;gap:2rem;padding:1.875rem 0;align-items:start}
.search-sidebar{position:sticky;top:1.25rem}
.search-sidebar .filter-block{margin-bottom:1.25rem;padding-bottom:1.25rem;border-bottom:1px solid var(--color-theme-border)}
.search-sidebar .filter-block:last-child{border-bottom:none}
.search-sidebar .filter-title{font-size:.8125rem;font-weight:600;text-transform:uppercase;margin-bottom:.75rem;color:var(--color-main-text);letter-spacing:.3px}
.search-sidebar .filter-list{list-style:none;padding:0;margin:0}
.search-sidebar .filter-list li{margin-bottom:.375rem}
.search-sidebar .filter-list a{
    display:flex;align-items:center;gap:.5rem;padding:.35rem .5rem;
    font-size:.8125rem;color:var(--color-text-light);text-decoration:none;
    border-radius:4px;transition:all .1s
}
.search-sidebar .filter-list a:hover{background:var(--color-theme-light);color:var(--color-main-text)}
.search-sidebar .filter-list a.active{background:var(--color-primary);color:#fff;font-weight:500}
.search-sidebar .filter-list a .count{font-size:.6875rem;color:inherit;opacity:.5;margin-left:auto}

/* RESULTS HEADER */
.search-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem;padding-bottom:1rem;border-bottom:1px solid var(--color-theme-border)}
.search-header .search-info{font-size:.875rem;color:var(--color-text-light)}
.search-header .search-info strong{color:var(--color-main-text)}
.search-header .search-info .search-query{color:var(--color-main-text);font-weight:600}
.search-sort{display:flex;align-items:center;gap:.5rem}
.search-sort label{font-size:.8125rem;color:var(--color-text-light)}
.search-sort select{
    padding:.4rem .75rem;font-size:.8125rem;border:1px solid var(--color-form-border);
    border-radius:4px;color:var(--color-main-text);background:var(--color-background);cursor:pointer;outline:none
}

/* ACTIVE FILTERS */
.active-filters{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1rem}
.active-filters .filter-tag{
    display:inline-flex;align-items:center;gap:.375rem;
    padding:.25rem .625rem;font-size:.75rem;font-weight:500;
    background:var(--color-theme-light);border-radius:4px;color:var(--color-main-text);text-decoration:none;
    transition:background .1s
}
.active-filters .filter-tag:hover{background:var(--color-primary);color:#fff}
.active-filters .filter-tag .tag-close{font-size:1rem;line-height:1}

/* AMAZON LIST VIEW */
.search-results-list{display:flex;flex-direction:column}
.search-result-item{
    display:flex;gap:1.25rem;padding:1.25rem 0;
    border-bottom:1px solid var(--color-theme-border);
    align-items:flex-start;position:relative
}
.search-result-item:last-child{border-bottom:none}

/* Image */
.search-result-item .sri-image{
    width:180px;min-width:180px;aspect-ratio:1;
    background:var(--color-theme-light);
    border-radius:var(--border-radius);overflow:hidden;
    display:flex;align-items:center;justify-content:center;
    position:relative
}
.search-result-item .sri-image img{max-width:85%;max-height:85%;object-fit:contain;transition:transform .2s}
.search-result-item:hover .sri-image img{transform:scale(1.05)}
.search-result-item .sri-image .thumb-placeholder{width:3rem;height:3rem;color:#d0d5dd}
.search-result-item .sri-badge{
    position:absolute;top:.5rem;left:.5rem;z-index:2;
    display:flex;flex-direction:column;gap:.25rem
}
.search-result-item .sri-badge span{
    display:inline-block;padding:.15rem .4rem;
    border-radius:3px;font-size:.625rem;font-weight:700;
    text-transform:uppercase;line-height:1.2
}
.search-result-item .sri-badge .feat{background:#fef3cd;color:#856404}
.search-result-item .sri-badge .refurb{background:var(--color-reacondicionado,#e8daef);color:var(--color-reacondicionado-text,#6c3483)}

/* Content */
.search-result-item .sri-content{flex:1;min-width:0;display:flex;flex-direction:column;gap:.35rem}
.search-result-item .sri-brand{
    font-size:.6875rem;color:var(--color-text-light);
    text-transform:uppercase;letter-spacing:.3px
}
.search-result-item .sri-title{
    font-size:1rem;font-weight:600;color:var(--color-main-text);
    text-decoration:none;line-height:1.3;transition:color .15s
}
.search-result-item .sri-title:hover{color:var(--color-link)}
.search-result-item .sri-desc{
    font-size:.8125rem;color:var(--color-text-light);
    line-height:1.5;display:-webkit-box;
    -webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden
}
.search-result-item .sri-price{
    font-size:1.25rem;font-weight:700;color:var(--color-main-text);
    margin-top:.25rem
}
.search-result-item .sri-price .price-bs{
    display:block;font-size:.75rem;font-weight:400;
    color:var(--color-text-light);margin-top:1px
}

/* Stock */
.search-result-item .sri-stock{
    font-size:.75rem;font-weight:500;display:flex;align-items:center;gap:.375rem;
    margin-top:.15rem
}
.search-result-item .sri-stock .in-stock{color:var(--color-shop-button)}
.search-result-item .sri-stock .out-stock{color:var(--color-theme-danger)}

/* Actions column */
.search-result-item .sri-actions{
    display:flex;flex-direction:column;gap:.5rem;
    min-width:160px;align-items:stretch;padding-top:.25rem
}
.search-result-item .sri-btn-cart{
    display:flex;align-items:center;justify-content:center;
    gap:.5rem;height:2.375rem;padding:0 1.25rem;
    border-radius:4px;background:var(--color-shop-button);color:#fff;
    border:none;cursor:pointer;font-size:.8125rem;font-weight:600;
    text-decoration:none;transition:background .15s
}
.search-result-item .sri-btn-cart:hover{background:var(--color-shop-button-active);color:#fff}
.search-result-item .sri-btn-cart svg{width:16px;height:16px;flex-shrink:0}
.search-result-item .sri-btn-detail{
    display:flex;align-items:center;justify-content:center;
    height:2.25rem;padding:0 .75rem;
    border-radius:4px;border:1px solid var(--color-theme-border);
    background:var(--color-background);color:var(--color-text-light);
    font-size:.75rem;font-weight:500;text-decoration:none;
    cursor:pointer;transition:all .15s
}
.search-result-item .sri-btn-detail:hover{border-color:var(--color-text-light);color:var(--color-main-text)}
.search-result-item .sri-btn-wish{
    width:2.25rem;height:2.25rem;display:flex;align-items:center;
    justify-content:center;border:1px solid var(--color-theme-border);
    border-radius:4px;background:none;cursor:pointer;
    color:var(--color-text-light);transition:all .15s;align-self:center
}
.search-result-item .sri-btn-wish:hover{border-color:var(--color-theme-danger);color:var(--color-theme-danger)}

/* PAGINATION */
.search-pagination{margin-top:2rem;display:flex;justify-content:center}
.search-pagination nav{display:flex;align-items:center;gap:.25rem}
.search-pagination .page-item{display:inline-flex}
.search-pagination .page-link{
    display:flex;align-items:center;justify-content:center;
    min-width:2.25rem;height:2.25rem;padding:0 .5rem;
    font-size:.8125rem;font-weight:500;color:var(--color-main-text);
    border:1px solid var(--color-theme-border);border-radius:4px;
    text-decoration:none;transition:all .1s
}
.search-pagination .page-link:hover{background:var(--color-theme-light);border-color:var(--color-text-light)}
.search-pagination .page-item.active .page-link{background:var(--color-primary);border-color:var(--color-primary);color:#fff}
.search-pagination .page-item.disabled .page-link{opacity:.4;pointer-events:none}

/* NO RESULTS */
.no-results{text-align:center;padding:4rem 1rem}
.no-results .no-icon{font-size:3rem;margin-bottom:1rem;opacity:.3}
.no-results h3{font-size:1.125rem;font-weight:600;margin-bottom:.5rem;color:var(--color-main-text)}
.no-results p{font-size:.875rem;color:var(--color-text-light);margin-bottom:1.5rem;max-width:400px;margin-left:auto;margin-right:auto}

@media(max-width:768px){
    .search-page{grid-template-columns:1fr}
    .search-sidebar{display:none}
    .search-header{flex-direction:column;align-items:flex-start}
    .search-result-item{flex-wrap:wrap}
    .search-result-item .sri-image{width:120px;min-width:120px}
    .search-result-item .sri-actions{min-width:100%;flex-direction:row;padding-top:.75rem}
}
@media(max-width:480px){
    .search-result-item{flex-direction:column}
    .search-result-item .sri-image{width:100%;aspect-ratio:1;max-width:280px}
    .search-result-item .sri-actions{min-width:100%}
}
@endsection

@section('content')
<div class="container">
    <div class="search-page">
        {{-- SIDEBAR FILTERS --}}
        <aside class="search-sidebar">
            {{-- CATEGORIES --}}
            <div class="filter-block">
                <div class="filter-title">Categorías</div>
                <ul class="filter-list">
                    <li><a href="{{ route('search.results', array_merge(request()->except(['categoria', 'page']))) }}" class="{{ !$categorySlug ? 'active' : '' }}">Todas</a></li>
                    @foreach($categories as $cat)
                        <li>
                            <a href="{{ route('search.results', array_merge(request()->except(['categoria', 'page']), ['categoria' => $cat->slug])) }}"
                               class="{{ $categorySlug === $cat->slug ? 'active' : '' }}">
                                {{ $cat->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- BRANDS --}}
            <div class="filter-block">
                <div class="filter-title">Marcas</div>
                <ul class="filter-list">
                    <li><a href="{{ route('search.results', array_merge(request()->except(['marca', 'page']))) }}" class="{{ !$brandSlug ? 'active' : '' }}">Todas</a></li>
                    @foreach($brands as $brand)
                        <li>
                            <a href="{{ route('search.results', array_merge(request()->except(['marca', 'page']), ['marca' => $brand->slug])) }}"
                               class="{{ $brandSlug === $brand->slug ? 'active' : '' }}">
                                {{ $brand->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="search-content">
            {{-- HEADER --}}
            <div class="search-header">
                <div class="search-info">
                    @if($query)
                        <span><strong>{{ $products->total() }}</strong> resultado(s) para "<span class="search-query">{{ $query }}</span>"</span>
                    @else
                        <span><strong>{{ $products->total() }}</strong> producto(s)</span>
                    @endif
                </div>
                <div class="search-sort">
                    <label for="sort-order">Ordenar por:</label>
                    <select id="sort-order" onchange="window.location.href=this.value">
                        <option value="{{ route('search.results', array_merge(request()->except(['orden', 'page']), ['orden' => 'latest'])) }}" {{ $sort === 'latest' ? 'selected' : '' }}>Más recientes</option>
                        <option value="{{ route('search.results', array_merge(request()->except(['orden', 'page']), ['orden' => 'price_asc'])) }}" {{ $sort === 'price_asc' ? 'selected' : '' }}>Menor precio</option>
                        <option value="{{ route('search.results', array_merge(request()->except(['orden', 'page']), ['orden' => 'price_desc'])) }}" {{ $sort === 'price_desc' ? 'selected' : '' }}>Mayor precio</option>
                    </select>
                </div>
            </div>

            {{-- ACTIVE FILTERS --}}
            <div class="active-filters">
                @if($categorySlug)
                    @php $catName = $categories->firstWhere('slug', $categorySlug)?->name ?? $categorySlug; @endphp
                    <a href="{{ route('search.results', request()->except(['categoria', 'page'])) }}" class="filter-tag">
                        {{ $catName }} <span class="tag-close">×</span>
                    </a>
                @endif
                @if($brandSlug)
                    @php $brandName = $brands->firstWhere('slug', $brandSlug)?->name ?? $brandSlug; @endphp
                    <a href="{{ route('search.results', request()->except(['marca', 'page'])) }}" class="filter-tag">
                        {{ $brandName }} <span class="tag-close">×</span>
                    </a>
                @endif
                @if($query)
                    <a href="{{ route('search.results') }}" class="filter-tag" style="background:var(--color-primary);color:#fff">
                        Limpiar todo <span class="tag-close">×</span>
                    </a>
                @endif
            </div>

            {{-- PRODUCTS (Amazon List View) --}}
            @if($products->count())
                <div class="search-results-list">
                    @foreach($products as $product)
                        <div class="search-result-item">
                            {{-- Image --}}
                            <a href="{{ route('products.show', $product->slug) }}" class="sri-image">
                                <div class="sri-badge">
                                    @if($product->is_featured)<span class="feat">Destacado</span>@endif
                                    @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                                </div>
                                @if($product->primaryImage->first())
                                    <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}">
                                @else
                                    <svg class="thumb-placeholder" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                @endif
                            </a>

                            {{-- Content --}}
                            <div class="sri-content">
                                @if($product->brand)
                                    <div class="sri-brand">{{ $product->brand->name }}</div>
                                @endif
                                <a href="{{ route('products.show', $product->slug) }}" class="sri-title">{{ $product->name }}</a>
                                @if($product->short_description)
                                    <div class="sri-desc">{{ Str::limit($product->short_description, 150) }}</div>
                                @endif
                                <div class="sri-price">
                                    ${{ number_format($product->base_price, 2) }}
                                    <span class="price-bs">Bs. {{ number_format($product->base_price * ($exchangeRate?->rate ?? 0), 2, ',', '.') }}</span>
                                </div>
                                <div class="sri-stock">
                                    <span class="in-stock">✓ En stock</span>
                                </div>
                            </div>

                            {{-- Actions --}}
                            <div class="sri-actions">
                                <a href="{{ route('products.show', $product->slug) }}" class="sri-btn-cart">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                                    Añadir al carrito
                                </a>
                                <a href="{{ route('products.show', $product->slug) }}" class="sri-btn-detail">Ver detalle</a>
                                <button class="sri-btn-wish">
                                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- PAGINATION --}}
                <div class="search-pagination">
                    @if($products->hasPages())
                        <nav>
                            {{-- Previous --}}
                            <a href="{{ $products->previousPageUrl() }}" class="page-item page-link {{ $products->onFirstPage() ? 'disabled' : '' }}" rel="prev">‹</a>

                            {{-- Pages --}}
                            @foreach($products->getUrlRange(1, $products->lastPage()) as $page => $url)
                                <a href="{{ $url }}" class="page-item page-link {{ $page === $products->currentPage() ? 'active' : '' }}">{{ $page }}</a>
                            @endforeach

                            {{-- Next --}}
                            <a href="{{ $products->nextPageUrl() }}" class="page-item page-link {{ $products->hasMorePages() ? '' : 'disabled' }}" rel="next">›</a>
                        </nav>
                    @endif
                </div>
            @else
                {{-- NO RESULTS --}}
                <div class="no-results">
                    <div class="no-icon">🔍</div>
                    <h3>Sin resultados</h3>
                    <p>
                        @if($query)
                            No encontramos productos para "<strong>{{ $query }}</strong>". Probá con otros términos o revisá los filtros.
                        @else
                            No hay productos que coincidan con los filtros seleccionados.
                        @endif
                    </p>
                    <a href="{{ route('search.results') }}" class="hero-btn" style="display:inline-flex">Ver todos los productos</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection

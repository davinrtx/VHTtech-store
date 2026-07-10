@extends('layouts.store')

@section('title', $product->name . ' — VHTtech')

@section('extra_styles')
    /* SINGLE PRODUCT */
    .single-product-wrapper{position:relative;margin-top:1.25rem}
    .single-product-container{margin-top:1.25rem}
    .single-product-container .row{display:grid;grid-template-columns:1fr 1fr;gap:2.5rem}

    .klb-product-gallery{position:relative}
    .single-thumbnails .woocommerce-product-gallery{position:relative}
    .single-thumbnails #product-images{border:1px solid #f0f3f7;border-radius:var(--border-radius);overflow:hidden;background:var(--color-theme-light);aspect-ratio:1;display:flex;align-items:center;justify-content:center;position:relative}
    .single-thumbnails #product-images img{width:100%;height:100%;object-fit:cover}
    .badge-float{position:absolute;top:1rem;left:1rem;z-index:2;display:flex;flex-direction:column;gap:.375rem}
    .badge-float span{display:inline-block;padding:.25rem .625rem;border-radius:3px;font-size:.75rem;font-weight:700;text-transform:uppercase;line-height:1.2}
    .badge-float .refurb{background:var(--color-reacondicionado,#e8daef);color:var(--color-reacondicionado-text,#6c3483)}
    .badge-float .featured{background:#fef3cd;color:#856404}
    .single-thumbnails #product-thumbnails{display:flex;gap:.375rem;margin-top:.625rem;flex-wrap:wrap}
    .single-thumbnails #product-thumbnails .swiper-slide{width:5rem;height:5rem;border:1px solid var(--color-theme-border);border-radius:4px;overflow:hidden;cursor:pointer;background:var(--color-theme-light);flex-shrink:0;transition:border-color .15s}
    .single-thumbnails #product-thumbnails .swiper-slide:hover{border-color:var(--color-main-text)}
    .single-thumbnails #product-thumbnails .swiper-slide.swiper-slide-thumb-active{border-color:var(--color-main-text)}
    .single-thumbnails #product-thumbnails .swiper-slide img{width:100%;height:100%;object-fit:cover}

    .klb-product-detail{}
    .product-brand{font-size:.8125rem;font-weight:500;margin-bottom:.4375rem}
    .product-brand a{text-decoration:none;color:var(--color-link)}
    .product_title{font-size:1.625rem;line-height:1.3;margin-bottom:.75rem;color:var(--color-main-text)}
    .product-meta{display:flex;align-items:center;font-size:.75rem;font-weight:500;margin-bottom:1rem;flex-wrap:wrap}
    .product-meta > *{position:relative;color:var(--color-text-light);padding-right:.625rem}
    .product-meta > *::after{content:"|";margin-left:.3125rem;color:var(--color-text-light)}
    .product-meta > *:last-child::after{display:none}
    .product-meta .sku{color:var(--color-main-text);font-weight:600}

    .product-tags{display:flex;flex-wrap:wrap;gap:.375rem;margin-bottom:1rem}
    .product-tags a{display:inline-flex;padding:.25rem .625rem;border-radius:3px;font-size:.6875rem;font-weight:500;background:var(--color-theme-light);color:var(--color-main-text);text-decoration:none}
    .product-tags a:hover{background:var(--color-primary);color:#fff}

    .product-ratings{display:flex;align-items:center;margin-top:1.25rem}
    .product-ratings .product-rating{display:flex;align-items:center;gap:.5rem}
    .product-ratings .stars{display:flex;gap:2px}
    .product-ratings .stars svg{width:1rem;height:1rem;color:var(--color-secondary)}
    .product-ratings .count-rating a{font-size:.8125rem;text-decoration:none;color:var(--color-main-text);border:1px solid #dde2e8;border-radius:4px;padding:5px 12px;display:inline-block}
    .klb-single-stock{margin-top:.75rem}
    .product-stock{display:inline-flex;align-items:center;font-size:.8125rem}
    .product-stock.in-stock{border-radius:4px;background:#f4faf6;color:var(--color-theme-success);padding:6px 14px}
    .product-stock.in-stock::before{content:"✓";font-weight:700;margin-right:6px;font-size:.875rem}
    .product-stock.out-of-stock{border-radius:4px;background:#fef2f2;color:var(--color-theme-danger);padding:6px 14px}

    .product-price{margin-top:1.25rem}
    .product-price .price{font-size:1.875rem;font-weight:700;color:var(--color-main-text)}
    .product-price .price del{font-size:65%;color:var(--color-text-light);opacity:.5;font-weight:400;vertical-align:super}
    .product-price .price ins{text-decoration:none}

    .product-extra-detail{margin-top:1.25rem;font-size:.875rem;color:#555;line-height:1.6}

    .product-info{border:1px solid var(--color-theme-border);border-radius:var(--border-radius);margin-top:1.25rem}
    .product-info .product-info-top{padding:1.25rem}
    .product-info .product-info-bottom{display:flex;flex-wrap:wrap;border-top:1px solid var(--color-theme-border);padding:1.25rem}
    .product-info .product-info-bottom .info-message{font-size:.8125rem;display:flex;align-items:center;gap:.375rem}
    .product-info .product-info-bottom .info-message::after{content:"|";margin:0 .9375rem;opacity:.3}
    .product-info .product-info-bottom .info-message:last-child::after{display:none}
    .product-info .product-info-bottom .info-message svg{width:1rem;height:1rem;flex-shrink:0}

    form.cart{display:flex;align-items:center;flex-flow:row wrap;width:100%;gap:.625rem}
    form.cart .quantity{display:flex;align-items:center;border:1px solid var(--color-theme-border);border-radius:4px;overflow:hidden;height:46px}
    form.cart .quantity .quantity-button{width:2.5rem;height:100%;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--color-main-text);user-select:none;transition:background .1s}
    form.cart .quantity .quantity-button:hover{background:var(--color-theme-light)}
    form.cart .quantity .qty{width:3rem;height:100%;border:none;border-left:1px solid var(--color-theme-border);border-right:1px solid var(--color-theme-border);text-align:center;font-size:.875rem;font-weight:600;color:var(--color-main-text);outline:none;background:none}
    form.cart .add_to_cart_button{border-radius:4px;height:46px;font-size:.9375rem;padding:0 1.875rem;background:var(--color-shop-button);color:#fff;border:none;cursor:pointer;font-weight:600;display:flex;align-items:center;gap:.5rem;transition:background .15s;font-family:var(--font-primary)}
    form.cart .add_to_cart_button:hover{background:var(--color-shop-button-active)}
    form.cart .add_to_cart_button svg{width:18px;height:18px}

    .product-actions{display:flex;align-items:center;gap:.625rem;margin-top:.625rem}
    .product-actions .wishlist-btn{height:46px;padding:0 1.25rem;display:flex;align-items:center;gap:.5rem;border:1px solid var(--color-theme-border);border-radius:4px;background:none;cursor:pointer;color:var(--color-text-light);font-size:.8125rem;font-weight:500;font-family:var(--font-primary);transition:all .15s}
    .product-actions .wishlist-btn:hover{border-color:var(--color-theme-danger);color:var(--color-theme-danger)}

    .product_meta{margin-top:1.25rem;font-size:.8125rem;color:var(--color-text-light)}
    .product_meta span{display:block;margin-bottom:.3125rem}
    .product_meta .sku{font-weight:600;color:var(--color-main-text)}
    .product_meta .posted_in a{color:var(--color-link);text-decoration:none}
    .product_meta .posted_in a:hover{text-decoration:underline}
    .product_meta .posted_in a::after{content:",";margin-right:2px}
    .product_meta .posted_in a:last-child::after{display:none}
    .product_meta .tagged_as a{color:var(--color-link);text-decoration:none}
    .product_meta .tagged_as a:hover{text-decoration:underline}
    .product_meta .tagged_as a::after{content:",";margin-right:2px}
    .product_meta .tagged_as a:last-child::after{display:none}

    .condition-note{margin-top:1.25rem;padding:14px 20px;background:#fffcf2;border:1px solid #faeecf;border-radius:var(--border-radius);font-size:.8125rem;color:#c28e00;display:flex;align-items:center;gap:.5rem}
    .condition-note strong{color:#856404}

    .variants-section{margin-top:1.25rem}
    .variants-section h3{font-size:.8125rem;font-weight:600;margin-bottom:.625rem;color:var(--color-main-text)}
    .variants-list{display:flex;flex-direction:column;gap:.5rem}
    .variants-list .variant-item{display:flex;align-items:center;justify-content:space-between;padding:.75rem 1rem;border:1px solid var(--color-theme-border);border-radius:var(--border-radius);background:var(--color-theme-light)}
    .variant-item .v-info{display:flex;align-items:center;gap:.75rem}
    .variant-item .v-info .v-img{width:2.5rem;height:2.5rem;border-radius:4px;overflow:hidden;background:var(--color-theme-light);flex-shrink:0}
    .variant-item .v-info .v-img img{width:100%;height:100%;object-fit:cover}
    .variant-item .v-info .v-sku{font-size:.875rem;font-weight:500;color:var(--color-main-text)}
    .variant-item .v-info .v-attrs{font-size:.75rem;color:var(--color-text-light)}
    .variant-item .v-pricing{text-align:right}
    .variant-item .v-pricing .amount{font-size:1rem;font-weight:700}
    .variant-item .v-pricing .stock{font-size:.6875rem;color:var(--color-theme-success)}

    .woocommerce-tabs{margin-top:3.75rem}
    .woocommerce-tabs .tabs{display:flex;list-style:none;border-bottom:1px solid var(--color-theme-border);gap:0;margin-bottom:1.875rem}
    .woocommerce-tabs .tabs li{margin-bottom:-1px}
    .woocommerce-tabs .tabs li a{display:block;padding:.75rem 1.5rem;font-size:.9375rem;font-weight:500;text-decoration:none;color:var(--color-text-light);border-bottom:2px solid transparent;transition:all .15s}
    .woocommerce-tabs .tabs li.active a,.woocommerce-tabs .tabs li a:hover{color:var(--color-main-text);border-bottom-color:var(--color-secondary)}
    .woocommerce-tabs .panel{font-size:.9375rem;line-height:1.7;color:#555}

    @media(max-width:992px){
        .single-product-container .row{grid-template-columns:1fr}
    }
    @media(max-width:768px){
        .klb-product-detail{margin-top:1.25rem}
        .product-info .product-info-bottom .info-message::after{display:none}
        .product-info .product-info-bottom{flex-direction:column;gap:.5rem}
    }
@endsection

@section('content')
{{-- BREADCRUMB --}}
<div class="woocommerce-breadcrumb">
    <div class="container">
        <a href="{{ route('home') }}">Inicio</a><span class="sep">/</span>
        <a href="#">Catálogo</a><span class="sep">/</span>
        @if($product->brand)<a href="#">{{ $product->brand->name }}</a><span class="sep">/</span>@endif
        <span style="color:var(--color-main-text);font-weight:500">{{ $product->name }}</span>
    </div>
</div>

<div id="product-{{ $product->id }}" class="single-product-wrapper">
    <div class="container">
        <div class="single-product-container">
            <div class="row">
                {{-- GALLERY --}}
                <div class="klb-product-gallery col col-12 col-lg-6">
                    <div class="single-thumbnails default">
                        <div class="woocommerce-product-gallery">
                            <div class="badge-float">
                                @if($product->is_refurbished)<span class="refurb">Reacondicionado</span>@endif
                                @if($product->is_featured)<span class="featured">Destacado</span>@endif
                            </div>
                            <div id="product-images">
                                @if($product->primaryImage->first())
                                    <img src="{{ Storage::url($product->primaryImage->first()->path) }}" alt="{{ $product->name }}">
                                @else
                                    <svg width="96" height="96" fill="none" stroke="#d0d5dd" viewBox="0 0 24 24"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                @endif
                            </div>
                            @if($product->images->count() > 1)
                            <div id="product-thumbnails">
                                @foreach($product->images as $image)
                                <div class="swiper-slide {{ $image->is_primary ? 'swiper-slide-thumb-active' : '' }}">
                                    <img src="{{ Storage::url($image->path) }}" alt="">
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                {{-- DETAIL --}}
                <div class="klb-product-detail col col-12 col-lg-6">
                    {{-- BRAND --}}
                    @if($product->brand)
                    <div class="product-brand"><a href="#">{{ $product->brand->name }}</a></div>
                    @endif

                    {{-- TITLE --}}
                    <h1 class="product_title entry-title">{{ $product->name }}</h1>

                    {{-- META (SKU, grade, brand) --}}
                    <div class="product-meta">
                        @if($product->variants->first()?->sku)
                        <div class="sku-wrapper"><span>SKU: </span><span class="sku">{{ $product->variants->first()->sku }}</span></div>
                        @endif
                        @if($product->refurbish_grade)
                        <div class="product-model"><span>Grado: </span><strong>{{ $product->refurbish_grade }}</strong></div>
                        @endif
                    </div>

                    {{-- TAGS --}}
                    @if($product->tags->isNotEmpty())
                    <div class="product-tags">
                        @foreach($product->tags as $tag)
                        <a href="#">{{ $tag->name }}</a>
                        @endforeach
                    </div>
                    @endif

                    {{-- RATING --}}
                    <div class="product-ratings">
                        <div class="product-rating">
                            <div class="stars">
                                @for($i=0;$i<5;$i++)
                                <svg viewBox="0 0 24 24" fill="@if($i<4)var(--color-secondary)@else none @endif" stroke="currentColor" stroke-width="1"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                                @endfor
                            </div>
                            <div class="count-rating"><a href="#" class="woocommerce-review-link"><span class="count">0</span> comentarios</a></div>
                        </div>
                    </div>

                    {{-- STOCK --}}
                    <div class="klb-single-stock">
                        <div class="product-stock in-stock">En stock</div>
                    </div>

                    {{-- PRICE --}}
                    <div class="product-price">
                        <span class="price">${{ number_format($product->base_price, 2) }} / Bs. {{ number_format($product->base_price * ($exchangeRate?->rate ?? 0), 2, ',', '.') }}</span>
                    </div>

                    {{-- SHORT DESCRIPTION --}}
                    @if($product->short_description)
                    <div class="product-extra-detail woocommerce-product-details__short-description">
                        {{ $product->short_description }}
                    </div>
                    @endif

                    {{-- VARIANTS --}}
                    @if($product->variants->where('is_active', true)->isNotEmpty())
                    <div class="variants-section">
                        <h3>Variantes disponibles</h3>
                        <div class="variants-list">
                            @foreach($product->variants->where('is_active', true) as $variant)
                            <div class="variant-item">
                                <div class="v-info">
                                    @if($variant->image)
                                    <div class="v-img"><img src="{{ Storage::url($variant->image) }}" alt=""></div>
                                    @endif
                                    <div>
                                        <div class="v-sku">{{ $variant->sku }}</div>
                                        @if($variant->attributeValues->isNotEmpty())
                                        <div class="v-attrs">{{ $variant->attributeValues->pluck('value')->implode(', ') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="v-pricing">
                                    <div class="amount">${{ number_format($variant->price, 2) }} / Bs. {{ number_format($variant->price * ($exchangeRate?->rate ?? 0), 2, ',', '.') }}</div>
                                    <div class="stock">{{ $variant->stock > 0 ? $variant->stock.' en stock' : 'Agotado' }}</div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- ADD TO CART --}}
                    <div class="product-info">
                        <div class="product-info-top">
                            <form class="cart" onsubmit="return false;">
                                <div class="quantity">
                                    <div class="quantity-button minus">−</div>
                                    <input type="text" class="qty" value="1">
                                    <div class="quantity-button plus">+</div>
                                </div>
                                <button type="submit" class="add_to_cart_button single_add_to_cart_button button alt">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 002 1.61h9.72a2 2 0 002-1.61L23 6H6"/></svg>
                                    <span>Agregar al carrito</span>
                                </button>
                            </form>
                            <div class="product-actions">
                                <button class="wishlist-btn">
                                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                    Añadir a favoritos
                                </button>
                            </div>
                        </div>
                        <div class="product-info-bottom">
                            <div class="info-message">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4M8 2v4M3 10h18"/></svg>
                                <strong>{{ $product->warranty_months ?? '12' }} meses de garantía</strong>
                            </div>
                            <div class="info-message">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="22,12 18,12 15,21 9,3 6,12 2,12"/></svg>
                                Envío rápido
                            </div>
                            <div class="info-message">
                                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20,6 9,17 4,12"/></svg>
                                Pago seguro
                            </div>
                        </div>
                    </div>

                    {{-- PRODUCT META (categories, tags) --}}
                    <div class="product_meta product-categories">
                        @if($product->variants->first()?->sku)
                        <span class="sku_wrapper">SKU: <span class="sku">{{ $product->variants->first()->sku }}</span></span>
                        @endif
                        @if($product->categories->isNotEmpty())
                        <span class="posted_in">Categorías:
                            @foreach($product->categories as $category)
                            <a href="#">{{ $category->name }}</a>
                            @endforeach
                        </span>
                        @endif
                        @if($product->tags->isNotEmpty())
                        <span class="tagged_as">Tags:
                            @foreach($product->tags as $tag)
                            <a href="#">{{ $tag->name }}</a>
                            @endforeach
                        </span>
                        @endif
                    </div>

                    {{-- CONDITION NOTES --}}
                    @if($product->condition_notes)
                    <div class="condition-note">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                        <span><strong>Notas de condición:</strong> {{ $product->condition_notes }}</span>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- TABS --}}
        @if($product->description)
        <div class="woocommerce-tabs">
            <ul class="tabs">
                <li class="active"><a href="#">Descripción</a></li>
            </ul>
            <div class="panel entry-content">
                {!! $product->description !!}
            </div>
        </div>
        @endif
    </div>
</div>
@endsection

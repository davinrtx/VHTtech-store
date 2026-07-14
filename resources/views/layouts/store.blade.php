<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VHTtech Store')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --color-background: #fff;
            --color-main-text: #021523;
            --color-text-light: #818ea0;
            --color-primary: #041e42;
            --color-secondary: #38bdf8;
            --color-link: #0070dc;
            --color-form-border: #d9dde3;
            --color-form-placeholder: #9aa5b3;
            --color-theme-danger: #ef262c;
            --color-theme-warning: #ff5c00;
            --color-theme-info: #e8e8e8;
            --color-theme-border: #e5e8ec;
            --color-theme-success: #00a046;
            --color-theme-light: #f2f3f5;
            --color-product-fade-border: #e0e5ea;
            --color-shop-button: #00a046;
            --color-shop-button-active: #037535;
            --font-primary: "Inter",-apple-system,BlinkMacSystemFont,sans-serif;
            --font-secondary: "Inter",sans-serif;
            --border-radius: 7px;
        }
        body{font-family:var(--font-primary);color:var(--color-main-text);background:var(--color-background);-webkit-font-smoothing:antialiased;font-size:16px;line-height:1.4}
        a{color:var(--color-link);text-decoration:none}
        a:hover{color:var(--color-main-text)}
        .container{max-width:1290px;margin:0 auto;padding:0 1rem}
        .site-header .custom-color-dark{color:#fff;background-color:#031424}
        .site-header .custom-color-dark .site-departments-wrapper > a{background-color:var(--color-secondary)!important}
        .site-header .custom-color-dark .input-search-button button{color:var(--color-main-text);background-color:var(--color-secondary);border-color:var(--color-secondary)}

        /* PREVIEW BANNER */
        .preview-banner{background:linear-gradient(135deg,#041e42,#0a3366);color:#fff;text-align:center;padding:.5rem;font-size:.75rem;letter-spacing:.5px}
        .preview-banner span{color:var(--color-secondary);font-weight:700}

        /* === TOP BAR === */
        .site-header .header-top{position:relative;font-size:.75rem;z-index:11}
        .site-header .header-top .header-wrapper{display:flex;align-items:center;position:relative}
        .site-header .header-top .column.left{display:flex;align-items:center}
        .site-header .header-top .column.right{margin-left:auto;display:flex;align-items:center}
        .site-header .header-top .site-menu .menu{display:flex;list-style:none;gap:0}
        .site-header .header-top .site-menu .menu > li > a{display:block;padding:.75rem 1rem;color:rgba(255,255,255,.7);text-decoration:none;transition:all .1s}
        .site-header .header-top .site-menu .menu > li > a:hover{color:rgba(255,255,255,.8)}
        .site-header .header-top .site-switcher{display:inline-flex;align-items:center;flex-shrink:0}
        .site-header .header-top .site-switcher > span{margin-right:.375rem}
        .site-header .header-top .column.right .site-menu + .site-switcher{margin-left:1.25rem;padding-left:1.25rem;position:relative}
        .site-header .header-top .column.right .site-menu + .site-switcher::before{content:"";position:absolute;width:1px;height:.9375rem;background:currentColor;opacity:.1;left:0}

        /* === MAIN HEADER === */
        .site-header .header-main{position:relative;color:var(--color-main-text);z-index:10;background:var(--color-background)}
        .site-header .header-main a{color:currentColor;transition:all .1s}
        .site-header .header-main.height-padding .header-wrapper{padding-top:1.25rem;padding-bottom:1.25rem}
        .site-header .header-main .header-wrapper{display:flex;align-items:center}
        .site-header .header-main .column.left{display:flex;align-items:center}
        .site-header .header-main .column.right{flex:1;display:flex;align-items:center}
        .site-header .header-main .site-brand{flex-shrink:0;margin-right:2.5rem}
        .site-header .site-brand a{font-size:1.75rem;font-weight:800;text-decoration:none;color:var(--color-primary);letter-spacing:-.5px}
        .site-brand .accent{color:var(--color-secondary)}

        /* SEARCH */
        .site-search{width:100%}
        .site-search .input-group{display:inline-flex;align-items:center;flex-shrink:0;width:100%}
        .site-search .input-group > *{position:relative;display:inline-flex;align-items:center}
        .site-search .input-group > *.input-search-field{flex:1}
        .site-search select{width:auto;border-top-right-radius:0;border-bottom-right-radius:0;border-right:0;height:2.75rem;padding:0 .9375rem;font-size:.875rem;border:1px solid var(--color-form-border);background:var(--color-background);color:var(--color-main-text);outline:none;cursor:pointer}
        @media(min-width:1200px){.site-search select{height:3.125rem}}
        .site-search input[type=search]{border-radius:0;padding-left:3.625rem;height:2.75rem;width:100%;border:1px solid var(--color-form-border);border-left:0;font-size:.875rem;color:var(--color-main-text);outline:none}
        .site-search input[type=search]::placeholder{color:var(--color-form-placeholder)}
        @media(min-width:1200px){.site-search input[type=search]{height:3.125rem}}
        .site-search i{position:absolute;font-size:1.5rem;left:.75rem;top:50%;transform:translateY(-50%);color:var(--color-form-placeholder);pointer-events:none;z-index:1;display:flex;align-items:center}
        @media(min-width:1200px){.site-search i{font-size:1.75rem}}
        .site-search button{border-top-left-radius:0;border-bottom-left-radius:0;height:2.75rem;padding:0 1.5625rem;background:var(--color-secondary);color:var(--color-main-text);border:1px solid var(--color-secondary);font-size:.875rem;font-weight:600;cursor:pointer;transition:opacity .15s;font-family:var(--font-primary)}
        .site-search button:hover{opacity:.9}
        @media(min-width:1200px){.site-search button{height:3.125rem}}

        /* HEADER ADDONS */
        .header-addons{display:inline-flex;align-items:center;flex-shrink:0;margin-left:1.25rem}
        .header-addons:first-of-type{margin-left:2.5rem}
        .header-addons a{display:inline-flex;align-items:center;text-decoration:none;color:currentColor}
        .header-addons-icon{position:relative;display:inline-flex;align-items:center;justify-content:center;font-size:1.5rem;width:2.25rem;height:2.25rem}
        .header-addons-icon svg{width:1.375rem;height:1.375rem}
        .header-addons-icon .button-count{position:absolute;display:inline-flex;align-items:center;justify-content:center;font-size:.6875rem;font-weight:700;min-width:1.125rem;height:1.125rem;top:2px;right:-3px;color:var(--color-main-text);background:var(--color-secondary);border-radius:50%}
        .header-addons-text{display:flex;flex-direction:column;margin-left:.625rem;line-height:1.1}
        .header-addons-text .sub-text{display:block;font-size:.6875rem;opacity:.5;margin-bottom:2px}
        .header-addons-text .primary-text{font-size:.9375rem;font-weight:500}

        /* === HEADER NAV === */
        .site-header .header-nav{color:var(--color-main-text)}
        .site-header .header-nav a{color:currentColor;transition:all .1s}
        .site-header .header-nav .header-wrapper{display:flex;align-items:center}
        .site-header .header-nav .column.left{display:flex;align-items:center}
        .site-header .header-nav .column.right{margin-left:auto;display:flex;align-items:center}
        .site-header .header-nav .site-menu .menu > li > a:hover{opacity:.7}
        .site-header .header-nav .site-menu .menu > li.menu-item-has-children:hover > a{opacity:.7}

        .site-departments.large{position:relative;margin-right:1.25rem}
        .site-departments-wrapper{display:flex;align-items:center}
        .site-departments-wrapper .all-categories{display:flex;align-items:center;gap:.625rem;padding:.75rem 1.125rem;background:var(--color-secondary);color:var(--color-main-text);text-decoration:none;font-size:.8125rem;font-weight:600;min-height:54px}
        .site-departments-wrapper .all-categories .departments-icon{font-size:1.25rem;line-height:1}
        .site-departments-wrapper .all-categories .departments-arrow{margin-left:.625rem;font-size:.75rem;line-height:1}

        /* === CATEGORIES DROPDOWN PANEL === */
        .site-departments-panel{
            position:absolute;top:100%;left:0;width:280px;
            background:#fff;border-radius:0 0 7px 7px;
            box-shadow:0 8px 20px rgba(0,0,0,.15);z-index:1000;
            display:none;color:var(--color-main-text)
        }
        .site-departments:hover .site-departments-panel,
        .site-departments-panel:hover{display:block}
        .departments-menu{list-style:none;padding:0;margin:0}
        .departments-menu .department-item{position:relative}
        .departments-menu .department-item > a{
            display:flex;align-items:center;padding:.75rem 1.25rem;
            font-size:.875rem;font-weight:500;color:var(--color-main-text);
            text-decoration:none;border-bottom:1px solid var(--color-theme-border);
            transition:background .15s
        }
        .departments-menu .department-item > a:hover{background:var(--color-theme-light)}
        .departments-menu .department-item:last-child > a{border-bottom:none}
        .departments-menu .department-item.has-children > a::after{
            content:"";margin-left:auto;width:16px;height:16px;flex-shrink:0;
            background:url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='%23818ea0' stroke-width='2'%3E%3Cpath d='m9 6 6 6-6 6'/%3E%3C/svg%3E") center/contain no-repeat
        }
        .department-submenu{
            position:absolute;top:0;left:100%;width:240px;
            background:#fff;border-radius:7px;
            box-shadow:0 8px 20px rgba(0,0,0,.15);
            list-style:none;padding:.5rem 0;margin:0;display:none
        }
        .department-item.has-children:hover > .department-submenu{display:block}
        .department-submenu li a{
            display:block;padding:.5rem 1.25rem;font-size:.8125rem;
            color:var(--color-main-text);text-decoration:none;transition:background .15s
        }
        .department-submenu li a:hover{background:var(--color-theme-light)}

        .site-header .site-menu.primary .menu{display:flex;list-style:none;margin-left:-.625rem}
        .site-header .site-menu.primary .menu > li{margin-right:.625rem}
        .site-header .site-menu.primary .menu > li > a{display:flex;align-items:center;height:54px;padding:0 .625rem;font-size:15px;font-weight:500;text-decoration:none;color:#fff;transition:opacity .15s}
        .site-header .site-menu.primary a{font-size:15px;font-weight:500}
        .site-header .site-menu.primary .menu > li > a:hover{opacity:.8}

        /* DISCOUNT BANNER */


        @yield('extra_styles')

        /* DARK HEADER OVERRIDES — must come after header styles */
        .site-header .custom-color-dark .site-menu .menu > li > a:hover{color:var(--color-secondary)}
        .site-header .custom-color-dark .site-menu.primary .menu > li > a:hover{color:var(--color-secondary)}
        .site-header .custom-color-dark .site-menu .menu > li.menu-item-has-children:hover > a{color:var(--color-secondary)}

        /* === BREADCRUMB (product) === */
        .woocommerce-breadcrumb{padding:1.25rem 0;font-size:.8125rem;color:var(--color-text-light)}
        .woocommerce-breadcrumb a{color:var(--color-text-light);text-decoration:none}
        .woocommerce-breadcrumb a:hover{color:var(--color-link)}
        .woocommerce-breadcrumb .sep{margin:0 .625rem;opacity:.4}

        /* FOOTER */
        .site-footer{margin-top:7.1875rem}
        .footer-newsletter{background:var(--color-primary);padding:3.75rem 0;color:#fff}
        .footer-newsletter .site-newsletter{display:flex;justify-content:space-between;align-items:center}
        .footer-newsletter .entry-title{font-size:1.375rem;font-weight:600}
        .footer-newsletter .entry-description p{color:var(--color-text-light);margin-bottom:0}
        .footer-newsletter .entry-description p strong{color:var(--color-secondary)}
        .footer-newsletter .subscribe-form{display:flex;max-width:33.125rem;width:100%}
        .footer-newsletter .subscribe-form input{height:3.125rem;border:0;padding:0 1.25rem;flex:1;border-radius:var(--border-radius) 0 0 var(--border-radius);font-family:var(--font-primary);font-size:.875rem;outline:none}
        .footer-newsletter .subscribe-form button{height:3.125rem;padding:0 1.875rem;border:0;border-radius:0 var(--border-radius) var(--border-radius) 0;background:var(--color-secondary);color:var(--color-main-text);font-weight:600;font-size:.875rem;cursor:pointer;font-family:var(--font-primary)}
        .footer-widgets{padding:6.25rem 0;background:var(--color-theme-light)}
        .footer-widgets .widget-row{display:grid;grid-template-columns:repeat(4,1fr);gap:1.875rem}
        .footer-widgets .widget-title{font-size:.875rem;font-weight:600;margin-bottom:.9375rem;color:var(--color-main-text)}
        .footer-widgets .widget{font-size:.8125rem;color:var(--color-text-light)}
        .footer-widgets .widget ul{list-style:none;padding:0;margin:0}
        .footer-widgets .widget ul li+li{margin-top:.5rem}
        .footer-widgets .widget ul li a{text-decoration:none;color:currentColor;transition:color .1s}
        .footer-widgets .widget ul li a:hover{color:var(--color-main-text);text-decoration:underline}
        .footer-details{color:#fff;background:var(--color-primary)}
        .footer-details .container{padding:3.75rem 1rem;border-top:1px solid #2c4260;border-bottom:1px solid #2c4260}
        .footer-details .site-details{display:flex;align-items:center;flex-flow:row wrap}
        .footer-details .site-details .site-brand-footer{margin-right:2.5rem}
        .footer-details .site-details .brand-text{font-size:1.5rem;font-weight:800;letter-spacing:-.5px;color:#fff}
        .footer-details .site-details .brand-text .accent{color:var(--color-secondary)}
        .footer-details .site-details .tags{display:flex;flex-flow:row wrap;list-style:none;padding:0;margin:0}
        .footer-details .site-details .tags li{position:relative;font-size:.8125rem;color:var(--color-text-light)}
        .footer-details .site-details .tags li::after{content:"|";margin:0 .5rem;color:var(--color-text-light)}
        .footer-details .site-details .tags li:last-child::after{display:none}
        .footer-details .site-details .tags li a{text-decoration:none;color:var(--color-text-light)}
        .footer-details .site-details .tags li a:hover{color:#fff}
        .footer-details .site-details .site-social{margin-left:auto}
        .footer-details .site-details .site-social a{display:inline-flex;width:2rem;height:2rem;border-radius:50%;background:#10315f;color:#fff;align-items:center;justify-content:center;text-decoration:none;margin-left:.5rem;font-size:.875rem}
        .footer-copyright .container{padding:1.875rem 1rem}
        .footer-copyright.bordered .container{border-top:1px solid var(--color-theme-border)}
        .footer-copyright .footer-bottom{display:flex;align-items:center;justify-content:space-between}
        .footer-copyright .site-copyright{font-size:.75rem;color:var(--color-text-light)}

        @media(max-width:992px){
            .footer-widgets .widget-row{grid-template-columns:repeat(2,1fr)}
        }
        @media(max-width:768px){
            .site-search select{display:none}
            .header-addons-text,.site-brand{margin-right:0}
            .header-addons:first-of-type{margin-left:.625rem}
            .site-header .site-departments-wrapper{display:none}
            .footer-newsletter .site-newsletter{flex-direction:column;align-items:stretch;gap:1rem}
            .footer-newsletter .subscribe-form{max-width:100%}
        }
        @yield('extra_styles')
    </style>
</head>
<body>

<div class="preview-banner">🛒 <span>Vista previa</span> — Diseño basado en Machic Theme.</div>

{{-- TOP BAR --}}
<div class="site-header">
<div class="header-top custom-color-dark">
    <div class="container">
        <div class="header-wrapper">
            <div class="column align-center left">
                <nav class="site-menu horizontal">
                    <ul class="menu">
                        <li><a href="#">Sobre nosotros</a></li>
                        <li><a href="#">Atención al cliente</a></li>
                        <li><a href="#">Ubicación</a></li>
                    </ul>
                </nav>
            </div>
            <div class="column align-center right">
                <nav class="site-menu horizontal">
                    <ul class="menu">
                        <li><a href="#">Seguimiento</a></li>
                        <li><a href="#">Ayuda</a></li>
                    </ul>
                </nav>
                <div class="site-switcher"><span>USD</span></div>
                <div class="site-switcher"><span>ES</span></div>
            </div>
        </div>
    </div>
</div>

{{-- MAIN HEADER --}}
<div class="header-main height-padding">
    <div class="container">
        <div class="header-wrapper">
            <div class="column align-center left">
                <div class="site-brand"><a href="{{ route('home') }}">VHT<span class="accent">tech</span></a></div>
            </div>
            <div class="column align-center right">
                <div class="header-form site-search">
                    <form class="search-form" role="search" method="get" id="searchform">
                        <div class="input-group">
                            <div class="input-search-addon">
                                <select class="form-select custom-width" name="product_cat" id="categories">
                                    <option value="" selected>Todas las categorías</option>
                                    @foreach($headerCategories as $category)
                                        <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-search-field">
                                <i class="klbth-icon-search">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                                </i>
                                <input type="search" class="form-control" name="s" placeholder="Busca tu producto favorito..." autocomplete="off">
                            </div>
                            <div class="input-search-button">
                                <button class="btn btn-primary" type="submit">Buscar</button>
                            </div>
                        </div>
                        <input type="hidden" name="post_type" value="product">
                    </form>
                </div>

                <div class="header-addons login-button">
                    <a href="#">
                        <div class="header-addons-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 10-16 0"/></svg>
                        </div>
                        <div class="header-addons-text">
                            <span class="sub-text">Iniciar sesión</span>
                            <span class="primary-text">Cuenta</span>
                        </div>
                    </a>
                </div>

                <div class="header-addons wishlist-button">
                    <a href="#">
                        <div class="header-addons-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            <span class="button-count">0</span>
                        </div>
                    </a>
                </div>

                <div class="header-addons cart-button">
                    <a href="#">
                        <div class="header-addons-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                            <span class="button-count">0</span>
                        </div>
                        <div class="header-addons-text">
                            <span class="sub-text">Total</span>
                            <span class="primary-text">$0.00</span>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- HEADER NAV --}}
<div class="header-nav custom-color-dark">
    <div class="container">
        <div class="header-wrapper">
            <div class="column align-center left">
                <div class="site-departments large">
                    <div class="site-departments-wrapper">
                        <a href="#" class="all-categories">
                            <span class="departments-icon">
                                <svg width="16" height="16" viewBox="0 0 16 16" fill="currentColor"><rect x="1" y="1" width="6" height="6" rx="1"/><rect x="9" y="1" width="6" height="6" rx="1"/><rect x="1" y="9" width="6" height="6" rx="1"/><rect x="9" y="9" width="6" height="6" rx="1"/></svg>
                            </span>
                            <span class="departments-text">Todas las categorías</span>
                            <span class="departments-arrow">
                                <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="m6 9 6 6 6-6"/></svg>
                            </span>
                        </a>
                    </div>
                    <div class="site-departments-panel">
                        <ul class="departments-menu">
                            @foreach($headerCategories as $category)
                                <li class="department-item{{ $category->children->count() ? ' has-children' : '' }}">
                                    <a href="#">{{ $category->name }}</a>
                                    @if($category->children->count())
                                        <ul class="department-submenu">
                                            @foreach($category->children as $child)
                                                <li><a href="#">{{ $child->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <nav class="site-menu horizontal primary shadow-enable">
                    <ul class="menu">
                        <li><a href="{{ route('home') }}">Inicio</a></li>
                        <li><a href="#">Catálogo</a></li>
                        <li><a href="#">Ofertas</a></li>
                        <li><a href="#">Reacondicionados</a></li>
                        <li><a href="#">Componentes</a></li>
                        <li><a href="#">Periféricos</a></li>
                        <li><a href="#">Contacto</a></li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
</div>

<main id="main" class="site-primary">
    <div class="site-content">
        @yield('content')
    </div>
</main>

{{-- FOOTER --}}
<footer class="site-footer">
    <div class="footer-newsletter">
        <div class="container">
            <div class="site-newsletter">
                <div>
                    <h3 class="entry-title">Mantente informado</h3>
                    <div class="entry-description"><p>Suscríbete para recibir <strong>ofertas exclusivas</strong></p></div>
                </div>
                <div class="subscribe-form">
                    <input type="email" placeholder="Tu correo electrónico">
                    <button type="submit">Suscribirse</button>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-widgets">
        <div class="container">
            <div class="widget-row">
                <div class="widget">
                    <h4 class="widget-title">Categorías</h4>
                    <ul>
                        <li><a href="#">Laptops</a></li>
                        <li><a href="#">Componentes</a></li>
                        <li><a href="#">Periféricos</a></li>
                        <li><a href="#">Accesorios</a></li>
                        <li><a href="#">Reacondicionados</a></li>
                    </ul>
                </div>
                <div class="widget">
                    <h4 class="widget-title">Compra</h4>
                    <ul>
                        <li><a href="#">Mi cuenta</a></li>
                        <li><a href="#">Carrito</a></li>
                        <li><a href="#">Favoritos</a></li>
                        <li><a href="#">Seguimiento</a></li>
                    </ul>
                </div>
                <div class="widget">
                    <h4 class="widget-title">Atención</h4>
                    <ul>
                        <li><a href="#">Contacto</a></li>
                        <li><a href="#">FAQ</a></li>
                        <li><a href="#">Envíos</a></li>
                        <li><a href="#">Garantías</a></li>
                    </ul>
                </div>
                <div class="widget">
                    <h4 class="widget-title">Sobre VHTtech</h4>
                    <ul>
                        <li><a href="#">Nosotros</a></li>
                        <li><a href="#">Términos</a></li>
                        <li><a href="#">Privacidad</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-details">
        <div class="container">
            <div class="site-details">
                <div class="site-brand-footer">
                    <span class="brand-text">VHT<span class="accent">tech</span></span>
                </div>
                <ul class="tags">
                    <li><a href="#">Laptops</a></li>
                    <li><a href="#">PC Gaming</a></li>
                    <li><a href="#">Componentes</a></li>
                    <li><a href="#">Periféricos</a></li>
                    <li><a href="#">Monitores</a></li>
                    <li><a href="#">Almacenamiento</a></li>
                </ul>
                <div class="site-social">
                    <a href="#" title="Instagram"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><rect x="2" y="2" width="20" height="20" rx="5"/><circle cx="12" cy="12" r="5"/><circle cx="17.5" cy="6.5" r="1.5"/></svg></a>
                    <a href="#" title="Facebook"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg></a>
                    <a href="#" title="WhatsApp"><svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg></a>
                </div>
            </div>
        </div>
    </div>
    <div class="footer-copyright bordered">
        <div class="container">
            <div class="footer-bottom">
                <div class="site-copyright"><p>Copyright {{ date('Y') }}. VHTtech Store. Todos los derechos reservados.</p></div>
                <div class="site-payment"><span style="font-size:.75rem;color:var(--color-text-light)">Vista previa — Tienda en construcción</span></div>
            </div>
        </div>
    </div>
</footer>

</body>
</html>

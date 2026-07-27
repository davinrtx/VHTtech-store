<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'VHTtech Store')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @stack('head-scripts')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        function searchSuggestions() {
            return {
                query: '',
                category: '',
                results: { products: [], categories: [] },
                loading: false,
                open: false,
                selectedIndex: 0,

                get totalResults() {
                    const p = this.results.products || [];
                    const c = this.results.categories || [];
                    return p.length + c.length;
                },

                async fetchSuggestions() {
                    if (this.query.length < 2) {
                        this.open = false;
                        return;
                    }
                    this.loading = true;
                    this.open = true;
                    this.selectedIndex = 0;
                    try {
                        const res = await fetch(`/buscar/sugerencias?q=${encodeURIComponent(this.query)}`);
                        this.results = await res.json();
                    } catch {
                        this.results = { products: [], categories: [] };
                    } finally {
                        this.loading = false;
                    }
                },

                selectSuggestion() {
                    const products = this.results.products || [];
                    const categories = this.results.categories || [];
                    const total = products.length + categories.length;
                    if (total === 0) return;

                    if (this.selectedIndex < products.length) {
                        const product = products[this.selectedIndex];
                        window.location.href = '/producto/' + product.slug;
                    } else {
                        const catIndex = this.selectedIndex - products.length;
                        if (categories[catIndex]) {
                            // Future: navigate to category page
                            this.open = false;
                        }
                    }
                },

                submitSearch() {
                    if (this.query.trim()) {
                        window.location.href = '/buscar?q=' + encodeURIComponent(this.query) + (this.category ? '&categoria=' + this.category : '');
                    }
                }
            }
        }
    </script>
    <style>
        *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
        :root{
            --color-background: #fff;
            --color-main-text: #021523;
            --color-text-light: #7c7c7c;
            --color-primary: #1565C0;
            --color-secondary: #333e48;
            --color-link: #1565C0;
            --color-form-border: #ddd;
            --color-form-placeholder: #9aa5b3;
            --color-theme-danger: #ef262c;
            --color-theme-warning: #ff5c00;
            --color-theme-info: #e8e8e8;
            --color-theme-border: #e5e5e5;
            --color-theme-success: #00a046;
            --color-theme-light: #f8f9fa;
            --color-product-fade-border: #e0e5ea;
            --color-shop-button: #1565C0;
            --color-shop-button-active: #0d47a1;
            --font-primary: "Inter",-apple-system,BlinkMacSystemFont,sans-serif;
            --font-secondary: "Inter",sans-serif;
            --border-radius: 10px;
        }
        body{font-family:var(--font-primary);color:var(--color-main-text);background:var(--color-background);-webkit-font-smoothing:antialiased;font-size:16px;line-height:1.4;overflow-x:hidden}
        a{color:var(--color-link);text-decoration:none}
        a:hover{color:var(--color-main-text)}
        .container{max-width:1430px;margin:0 auto;padding:0 1rem}
        /* ELECTRO V5 — top bar light, primary azul eléctrico */

        /* === TOP BAR (Electro V5 — light, no border) === */
        .top-bar{background:#f5f5f5;border-bottom:0;font-size:.8125rem;position:relative;z-index:11}
        .top-bar .top-bar-inner{display:flex;align-items:center;justify-content:space-between}
        .top-bar .top-bar-menu{display:flex;list-style:none;align-items:center;margin:0;padding:0}
        .top-bar .top-bar-menu li{display:flex;align-items:center}
        .top-bar .top-bar-menu li a{display:block;padding:.5rem .75rem;color:#333e48;text-decoration:none;font-size:.8125rem;transition:color .1s}
        .top-bar .top-bar-menu li a:hover{color:var(--color-primary)}
        .top-bar .top-bar-menu li+li::before{content:"|";color:#ccc;font-size:.75rem;padding:0}
        .top-bar .top-bar-switcher{display:flex;align-items:center;padding:.5rem .75rem;font-size:.8125rem;color:#333e48}
        .top-bar .top-bar-switcher+.top-bar-switcher::before{content:"|";color:#ccc;margin-right:.75rem;font-size:.75rem}

        /* === MAIN HEADER (masthead) === */
        .site-header .header-main{position:relative;color:var(--color-main-text);z-index:10;background:var(--color-background)}
        .site-header .header-main a{color:currentColor;transition:all .1s}
        .site-header .header-main .masthead{padding-top:9px;padding-bottom:9px}
        .masthead{display:flex;align-items:center}
        .masthead .header-logo-area{flex:0 0 230px;max-width:230px;min-width:230px;flex-shrink:0}
        .masthead .site-brand{flex-shrink:0;margin-right:2.5rem}
        .masthead .site-brand a{font-size:1.75rem;font-weight:800;text-decoration:none;color:var(--color-primary);letter-spacing:-.5px;white-space:nowrap}
        .masthead .site-brand .accent{color:var(--color-secondary)}
        .masthead .navbar-search{flex:1;padding:0 1.25rem}
        .masthead .header-icons{display:flex;align-items:center;flex-shrink:0}

        /* SEARCH — Electro V5 exact (borderless, 41px height, connected input+btn) */
        .site-search{width:100%}
        .site-search .input-group{display:inline-flex;align-items:center;flex-shrink:0;width:100%;height:41px}
        .site-search .input-group > *{position:relative;display:inline-flex;align-items:center}
        .site-search .input-group > *.input-search-field{flex:1}
        .site-search select{width:auto;border-top-right-radius:0;border-bottom-right-radius:0;border-right:0;height:41px;padding:0 .9375rem;font-size:.875rem;border:none;background:var(--color-background);color:var(--color-main-text);outline:none;cursor:pointer;border-radius:0}
        .site-search input[type=search]{border-radius:0;padding-left:3.625rem;height:41px;width:100%;border:none;font-size:.875rem;color:var(--color-main-text);outline:none;background:#f8f9fa}
        .site-search input[type=search]::placeholder{color:var(--color-form-placeholder)}
        .site-search i{position:absolute;font-size:1.5rem;left:.75rem;top:50%;transform:translateY(-50%);color:var(--color-form-placeholder);pointer-events:none;z-index:1;display:flex;align-items:center}
        @media(min-width:1200px){.site-search i{font-size:1.75rem}}
        .site-search button{border-top-left-radius:0;border-bottom-left-radius:0;height:41px;padding:0 1.25rem;background:#333e48;color:#fff;border:none;font-size:.875rem;font-weight:600;cursor:pointer;transition:opacity .15s;font-family:var(--font-primary);border-radius:0}
        .site-search button:hover{opacity:.85}

        /* === SEARCH SUGGESTIONS === */
        .search-wrapper{position:relative;width:100%}
        .search-suggestions{
            position:absolute;top:100%;left:0;right:0;z-index:2000;
            background:#fff;border:1px solid var(--color-theme-border);
            border-radius:0 0 var(--border-radius) var(--border-radius);
            box-shadow:0 8px 30px rgba(0,0,0,.12);max-height:420px;overflow-y:auto
        }
        .search-suggestions .suggestion-group{padding:.5rem 0}
        .search-suggestions .suggestion-group+.suggestion-group{border-top:1px solid var(--color-theme-border)}
        .search-suggestions .suggestion-group-title{
            padding:.25rem .75rem;font-size:.6875rem;font-weight:600;
            text-transform:uppercase;color:var(--color-text-light);letter-spacing:.5px
        }
        .search-suggestions .suggestion-item{
            display:flex;align-items:center;gap:.75rem;
            padding:.5rem .75rem;text-decoration:none;color:var(--color-main-text);
            transition:background .1s;cursor:pointer
        }
        .search-suggestions .suggestion-item:hover,
        .search-suggestions .suggestion-item.active{background:var(--color-theme-light)}
        .search-suggestions .suggestion-img{
            width:40px;height:40px;border-radius:4px;object-fit:cover;
            background:var(--color-theme-light);flex-shrink:0
        }
        .search-suggestions .suggestion-img-placeholder{
            width:40px;height:40px;border-radius:4px;
            background:var(--color-theme-light);flex-shrink:0;
            display:flex;align-items:center;justify-content:center;
            color:#d0d5dd
        }
        .search-suggestions .suggestion-info{flex:1;min-width:0}
        .search-suggestions .suggestion-name{display:block;font-size:.8125rem;font-weight:500;white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
        .search-suggestions .suggestion-meta{display:block;font-size:.6875rem;color:var(--color-text-light);margin-top:1px}
        .search-suggestions .suggestion-price{font-size:.8125rem;font-weight:600;color:var(--color-main-text);white-space:nowrap;flex-shrink:0}
        .search-suggestions .suggestion-cat{
            display:block;padding:.35rem .75rem;font-size:.8125rem;
            color:var(--color-main-text);text-decoration:none;transition:background .1s
        }
        .search-suggestions .suggestion-cat:hover{background:var(--color-theme-light)}
        .search-suggestions .suggestion-empty{
            padding:1.5rem;text-align:center;font-size:.8125rem;color:var(--color-text-light)
        }
        .search-suggestions .suggestion-loading{
            padding:1rem;text-align:center;font-size:.8125rem;color:var(--color-text-light)
        }
        .search-suggestions .suggestion-loading::after{
            content:"";display:inline-block;width:1rem;height:1rem;
            border:2px solid var(--color-theme-border);border-top-color:var(--color-primary);
            border-radius:50%;animation:spin .6s linear infinite;margin-left:.5rem;vertical-align:middle
        }
        @keyframes spin{to{transform:rotate(360deg)}}
        [x-cloak]{display:none!important}

        .header-addons{display:inline-flex;align-items:center;flex-shrink:0;margin-left:1.25rem}
        .header-addons:first-of-type{margin-left:2.5rem}
        .header-addons a{display:inline-flex;align-items:center;text-decoration:none;color:currentColor}
        .header-addons-icon{position:relative;display:inline-flex;align-items:center;justify-content:center;font-size:1.5rem;width:2.25rem;height:2.25rem}
        .header-addons-icon svg{width:1.375rem;height:1.375rem}
        .header-addons-icon .button-count{position:absolute;font-size:.75em;font-weight:700;width:1.75em;line-height:1.75em;text-align:center;border-radius:50%;color:#333e48;background:#fff;bottom:-3px;left:7px}
        .header-addons-icon .button-count[data-count="0"]{display:none}
        .header-addons-text{display:flex;flex-direction:column;margin-left:.625rem;line-height:1.1}
        .header-addons-text .sub-text{display:block;font-size:.6875rem;opacity:.5;margin-bottom:2px}
        .header-addons-text .primary-text{font-size:.9375rem;font-weight:500}

        /* === ELECTRO V5 NAVIGATION (full-width, white, box-shadow) === */
        .electro-navigation-v5{width:100%;position:relative;background:#fff;box-shadow:0 1px 2px 0 rgba(0,0,0,.16);border-bottom:1px solid #d7d7d7}
        .electro-navigation-v5 .electro-navigation{display:flex;align-items:center;margin-bottom:0}
        .electro-navigation-v5 .departments-menu-v2{flex:0 0 230px;max-width:230px;min-width:230px}

        .site-departments.large{position:relative}
        .site-departments-wrapper{display:flex;align-items:center}
        .departments-menu-v2-title{font-weight:700;font-size:1em;display:flex;height:100%;align-items:center;padding:0;background:#fff;color:#333e48;text-decoration:none;line-height:35px;border:none;border-radius:0}
        .departments-menu-v2-title .departments-menu-v2-icon{margin-right:9px;margin-left:6px;display:flex;align-items:center;line-height:1}
        .departments-menu-v2-title .departments-text{line-height:35px}

        /* === CATEGORIES DROPDOWN PANEL (Electro exact) === */
        .site-departments-panel{
            position:absolute;top:100%;left:0;width:280px;
            background:#fff;border:2px solid transparent;
            border-top-color:var(--color-primary);border-top-style:solid;border-top-width:2px;
            border-radius:0 0 .5em .5em;
            box-shadow:none;z-index:1000;
            display:none;color:var(--color-main-text);padding:.5em 0;min-width:270px
        }
        .site-departments:hover .site-departments-panel,
        .site-departments-panel:hover{display:block}
        .departments-menu{list-style:none;padding:0;margin:0}
        .departments-menu .department-item{position:relative;padding:0 1em}
        .departments-menu .department-item > a{
            display:flex;align-items:center;padding:6.5px 0 6.5px 5px;
            font-size:.875rem;font-weight:500;color:var(--color-main-text);
            text-decoration:none;border-bottom:1px solid #ddd;
            transition:background .15s;line-height:1.5;white-space:normal
        }
        .departments-menu .department-item > a:hover{background:#f5f5f5;font-weight:700}
        .departments-menu .department-item:last-child > a{border-bottom:none}
        .departments-menu .department-item.has-children > a::after{
            content:"";margin-left:auto;width:16px;height:16px;flex-shrink:0;
            background:url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' fill='none' stroke='%23818ea0' stroke-width='2'%3E%3Cpath d='m9 6 6 6-6 6'/%3E%3C/svg%3E") center/contain no-repeat
        }
        .department-submenu{
            position:absolute;top:0;left:100%;width:240px;
            background:#fff;border-radius:var(--border-radius);
            box-shadow:0 8px 20px rgba(0,0,0,.15);
            list-style:none;padding:.5rem 0;margin:0;display:none
        }
        .department-item.has-children:hover > .department-submenu{display:block}
        .department-submenu li a{
            display:block;padding:.5rem 1.25rem;font-size:.8125rem;
            color:var(--color-main-text);text-decoration:none;transition:background .15s
        }
        .department-submenu li a:hover{background:#f5f5f5}

        .secondary-nav .menu{display:flex;list-style:none;margin:0;padding:0}
        .secondary-nav .menu > li{margin:0}
        .secondary-nav .menu > li > a{display:flex;align-items:center;height:54px;padding:0 .9375rem;font-size:13px;font-weight:400;text-decoration:none;color:var(--color-main-text);transition:color .15s;line-height:35px}
        .secondary-nav .menu > li > a:hover{color:var(--color-primary)}

        /* DISCOUNT BANNER */


        /* === PRODUCT CARDS (shared grid) === */
        .product-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:1.25rem}
        .product-card{background:var(--color-background);border:1px solid var(--color-theme-border);border-radius:var(--border-radius);overflow:hidden;transition:box-shadow .2s;position:relative}
        .product-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.08)}
        .product-card .card-badge{position:absolute;top:.75rem;left:.75rem;z-index:2;display:flex;flex-direction:column;gap:.375rem}
        .product-card .card-badge span{display:inline-block;padding:.2rem .5rem;border-radius:3px;font-size:.6875rem;font-weight:700;text-transform:uppercase;line-height:1.2}
        .product-card .card-badge .feat{background:var(--color-primary);color:#fff}
        .product-card .card-badge .refurb{background:var(--color-reacondicionado,#e8daef);color:var(--color-reacondicionado-text,#6c3483)}
        .product-card .card-thumb{background:var(--color-theme-light);aspect-ratio:1;display:flex;align-items:center;justify-content:center;padding:1.5rem;position:relative}
        .product-card .card-thumb img{max-width:100%;max-height:100%;object-fit:contain}
        .product-card .card-thumb .thumb-placeholder{width:3rem;height:3rem;color:#d0d5dd}
        .product-card .card-body{padding:.75rem 1rem 1rem}
        .product-card .card-body .card-brand{font-size:.6875rem;color:var(--color-text-light);text-transform:uppercase;margin-bottom:.125rem}
        .product-card .card-body .card-title{font-size:.875rem;font-weight:500;margin-bottom:.5rem;display:block;color:var(--color-main-text);text-decoration:none;line-height:1.3;transition:color .15s}
        .product-card .card-body .card-title:hover{color:var(--color-link)}
        .product-card .card-body .card-price{font-size:1.125rem;font-weight:700;color:var(--color-main-text)}
        .product-card .card-body .card-price .price-bs{display:block;font-size:.75rem;font-weight:400;color:var(--color-text-light);margin-top:2px}
        .product-card .card-body .card-price del{font-size:70%;color:var(--color-text-light);opacity:.5;font-weight:400}
        .product-card .card-body .card-meta{font-size:.6875rem;color:var(--color-text-light);margin-top:.25rem}
        .product-card .card-actions{display:flex;gap:.375rem;padding:.625rem 1rem 1rem;border-top:1px solid var(--color-theme-border)}
        .product-card .card-actions .btn-cart{flex:1;height:2.25rem;display:flex;align-items:center;justify-content:center;border-radius:4px;background:var(--color-shop-button);color:#fff;border:none;cursor:pointer;font-size:.75rem;font-weight:600;gap:.375rem;text-decoration:none;transition:background .15s}
        .product-card .card-actions .btn-cart:hover{background:var(--color-shop-button-active);color:#fff}
        .product-card .card-actions .btn-wish{width:2.25rem;height:2.25rem;display:flex;align-items:center;justify-content:center;border:1px solid var(--color-theme-border);border-radius:4px;background:none;cursor:pointer;color:var(--color-text-light);transition:all .15s}
        .product-card .card-actions .btn-wish:hover{border-color:var(--color-theme-danger);color:var(--color-theme-danger)}

        /* Section titles with Electro accent underline */
        .section-title h2::after{content:'';display:block;border-bottom:2px solid var(--color-primary);width:80px;margin-top:4px}

        /* === CAROUSEL (Alpine.js powered) === */
        .ec-carousel{position:relative}
        .ec-carousel .ec-track{display:flex;overflow-x:auto;scroll-snap-type:x mandatory;-webkit-overflow-scrolling:touch;scrollbar-width:none;-ms-overflow-style:none;gap:1.25rem;padding-bottom:.5rem}
        .ec-carousel .ec-track::-webkit-scrollbar{display:none}
        .ec-carousel .ec-track > *{scroll-snap-align:start;flex-shrink:0;width:calc(16.666% - 1.042rem);min-width:180px}
        .ec-carousel .ec-track > .product-card{width:calc(16.666% - 1.042rem);min-width:180px}
        .ec-carousel .ec-nav{display:flex;gap:.25rem;position:absolute;top:-2.75rem;right:0}
        .ec-carousel .ec-nav button{width:2rem;height:2rem;display:flex;align-items:center;justify-content:center;border:1px solid var(--color-theme-border);border-radius:4px;background:#fff;color:var(--color-text-light);cursor:pointer;transition:all .15s;font-size:1rem;line-height:1}
        .ec-carousel .ec-nav button:hover{background:var(--color-primary);color:#fff;border-color:var(--color-primary)}
        .ec-carousel .ec-nav button:disabled{opacity:.3;pointer-events:none}
        .ec-carousel .ec-dots{display:flex;justify-content:center;gap:.375rem;margin-top:.75rem}
        .ec-carousel .ec-dots button{width:8px;height:8px;border-radius:50%;border:1px solid var(--color-theme-border);background:transparent;cursor:pointer;padding:0;transition:all .15s}
        .ec-carousel .ec-dots button.active{background:var(--color-primary);border-color:var(--color-primary)}
        @media(max-width:1200px){.ec-carousel .ec-track > *,.ec-carousel .ec-track > .product-card{width:calc(25% - .9375rem);min-width:200px}}
        @media(max-width:768px){.ec-carousel .ec-track > *,.ec-carousel .ec-track > .product-card{width:calc(50% - .625rem);min-width:160px}.ec-carousel .ec-nav{display:none}}

        /* === PRODUCT TABS (Electro V5 style) === */
        .product-tabs-v5{display:flex;align-items:center;gap:1rem;padding-bottom:.75rem;border-bottom:1px solid var(--color-theme-border);margin-bottom:1.5rem}
        .product-tabs-v5 .pt-title{font-size:1.25rem;font-weight:700;color:var(--color-main-text);margin:0;white-space:nowrap}
        .product-tabs-v5 .pt-nav{display:flex;gap:.375rem;flex-wrap:wrap}
        .product-tabs-v5 .pt-nav button{padding:.333em 1.05em;font-size:.875rem;line-height:1.2;color:#7b8186;border:2px solid transparent;border-radius:1.333em;background:none;cursor:pointer;transition:all .15s;white-space:nowrap}
        .product-tabs-v5 .pt-nav button.active{color:#333e48;font-weight:700;border-color:var(--color-primary);background:transparent}
        .product-tabs-v5 .pt-nav button:hover{color:#333e48}
        .product-tabs-v5 .pt-action{font-size:.8125rem;color:var(--color-text-light);text-decoration:none;margin-left:auto;white-space:nowrap}
        .product-tabs-v5 .pt-action:hover{color:var(--color-main-text)}
        @media(max-width:768px){.product-tabs-v5{flex-wrap:wrap;gap:.5rem}.product-tabs-v5 .pt-nav{order:3;width:100%}}

        /* === DEAL COUNTDOWN === */
        .deal-section{background:var(--color-theme-light);border-radius:var(--border-radius);padding:1.875rem;margin-bottom:2.5rem}
        .deal-header{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1rem;margin-bottom:1.25rem}
        .deal-header .dh-left{display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap}
        .deal-header .dh-title{font-size:1.125rem;font-weight:700;color:var(--color-main-text)}
        .deal-header .dh-subtitle{font-size:.8125rem;color:var(--color-text-light)}
        .deal-countdown{display:flex;gap:.5rem}
        .deal-countdown .cd-item{display:flex;flex-direction:column;align-items:center;min-width:3.5rem;background:var(--color-secondary);border-radius:6px;padding:.5rem .75rem}
        .deal-countdown .cd-item .cd-value{font-size:1.375rem;font-weight:700;color:#fff;line-height:1}
        .deal-countdown .cd-item .cd-label{font-size:.625rem;color:rgba(255,255,255,.7);text-transform:uppercase;margin-top:2px}
        @media(max-width:768px){.deal-header .dh-left{flex-direction:column;align-items:flex-start;gap:.75rem}}

        /* === ADS BLOCK === */
        .ads-block{display:grid;grid-template-columns:1fr 1fr;gap:1.875rem;margin-bottom:2.5rem}
        .ad-card{position:relative;border-radius:var(--border-radius);overflow:hidden;min-height:200px;display:flex;align-items:center;padding:2rem 2.5rem;background:linear-gradient(135deg,#f5f7fa 0%,#e4e9f0 100%);color:var(--color-main-text);text-decoration:none;transition:box-shadow .2s}
        .ad-card:hover{box-shadow:0 4px 20px rgba(0,0,0,.08);color:var(--color-main-text)}
        .ad-card .ad-content{max-width:65%}
        .ad-card .ad-text{font-size:1.25rem;font-weight:600;line-height:1.3;margin-bottom:.75rem}
        .ad-card .ad-text strong{color:var(--color-primary)}
        .ad-card .ad-btn{display:inline-flex;align-items:center;gap:.375rem;padding:.5rem 1.25rem;background:var(--color-primary);color:#fff;border-radius:4px;font-size:.8125rem;font-weight:600;text-decoration:none}
        .ad-card .ad-btn:hover{opacity:.9;color:#fff}
        .ad-card .ad-price{font-size:1.5rem;font-weight:800;color:var(--color-primary)}
        .ad-card .ad-price .prefix{font-size:.75rem;font-weight:400;display:block;color:var(--color-text-light)}
        .ad-card .ad-price .value sup{font-size:.625rem;top:-.5em}
        .ad-card .ad-visual{position:absolute;right:1.5rem;top:50%;transform:translateY(-50%);font-size:4rem;opacity:.12}
        @media(max-width:768px){.ads-block{grid-template-columns:1fr;gap:1rem}}

        /* === ADS WITH BANNERS === */
        .ads-banners-block{display:grid;grid-template-columns:1fr 1fr;gap:1.875rem;margin-bottom:2.5rem}
        .ads-banner-card{position:relative;border-radius:var(--border-radius);overflow:hidden;min-height:260px;display:flex;align-items:center;padding:2.5rem;text-decoration:none;color:#fff}
        .ads-banner-card:hover{color:#fff}
        .ads-banner-card.bg-1{background:linear-gradient(135deg,#1a1a2e 0%,#333e48 100%)}
        .ads-banner-card.bg-2{background:linear-gradient(135deg,#333e48 0%,#1a252f 100%)}
        .ads-banner-card .abc-content{max-width:60%}
        .ads-banner-card .abc-title{font-size:1.375rem;font-weight:700;line-height:1.3;margin-bottom:.5rem}
        .ads-banner-card .abc-title strong{color:var(--color-primary)}
        .ads-banner-card .abc-desc{font-size:.8125rem;opacity:.8;margin-bottom:1rem;line-height:1.5}
        .ads-banner-card .abc-desc span{display:inline-block;margin-right:.75rem}
        .ads-banner-card .abc-desc span+span::before{content:"|";margin-right:.75rem;opacity:.4}
        .ads-banner-card .abc-price{font-size:1.75rem;font-weight:800;margin-bottom:1rem}
        .ads-banner-card .abc-price .prefix{font-size:.6875rem;font-weight:400;opacity:.7;display:block}
        .ads-banner-card .abc-price .value sup{font-size:.625rem;top:-.5em}
        .ads-banner-card .abc-btn{display:inline-flex;align-items:center;gap:.375rem;padding:.5rem 1.25rem;background:var(--color-primary);color:#fff;border-radius:4px;font-size:.8125rem;font-weight:600;text-decoration:none}
        .ads-banner-card .abc-btn:hover{opacity:.9;color:#fff}
        .ads-banner-card .abc-visual{position:absolute;right:1.5rem;top:50%;transform:translateY(-50%);font-size:5rem;opacity:.12}
        @media(max-width:768px){.ads-banners-block{grid-template-columns:1fr;gap:1rem}.ads-banner-card .abc-content{max-width:75%}}

        /* === CATEGORIES BLOCK === */
        .categories-block{margin-bottom:2.5rem}
        .categories-block .cat-grid{display:grid;grid-template-columns:repeat(6,1fr);gap:1rem}
        .categories-block .cat-item{display:flex;flex-direction:column;align-items:center;justify-content:center;padding:1.25rem .75rem;background:var(--color-background);border:1px solid var(--color-theme-border);border-radius:var(--border-radius);text-decoration:none;color:var(--color-main-text);transition:box-shadow .2s}
        .categories-block .cat-item:hover{box-shadow:0 4px 20px rgba(0,0,0,.08)}
        .categories-block .cat-item .cat-icon{width:3rem;height:3rem;display:flex;align-items:center;justify-content:center;margin-bottom:.75rem;font-size:1.75rem}
        .categories-block .cat-item .cat-name{font-size:.8125rem;font-weight:600;text-align:center;line-height:1.2}
        @media(max-width:992px){.categories-block .cat-grid{grid-template-columns:repeat(3,1fr)}}
        @media(max-width:768px){.categories-block .cat-grid{grid-template-columns:repeat(2,1fr)}}

        @media(max-width:992px){
            .product-grid{grid-template-columns:repeat(2,1fr)}
        }
        @media(max-width:768px){
            .product-grid{grid-template-columns:1fr}
        }

        @yield('extra_styles')

        /* === BREADCRUMB (product) === */
        .woocommerce-breadcrumb{padding:1.25rem 0;font-size:.8125rem;color:var(--color-text-light)}
        .woocommerce-breadcrumb a{color:var(--color-text-light);text-decoration:none}
        .woocommerce-breadcrumb a:hover{color:var(--color-link)}
        .woocommerce-breadcrumb .sep{margin:0 .625rem;opacity:.4}

        /* FOOTER */
        .site-footer{margin-top:7.1875rem}
        .footer-newsletter{background:var(--color-primary);padding:.55em 0;color:#fff}
        .footer-newsletter .site-newsletter{display:flex;justify-content:space-between;align-items:center}
        .footer-newsletter .entry-title{font-size:1.375rem;font-weight:600}
        .footer-newsletter .entry-description p{color:rgba(255,255,255,.85);margin-bottom:0}
        .footer-newsletter .entry-description p strong{color:#fff}
        .footer-newsletter .subscribe-form{display:flex;max-width:33.125rem;width:100%}
        .footer-newsletter .subscribe-form input{height:3.125rem;border:0;padding:0 1.25rem;flex:1;border-radius:var(--border-radius) 0 0 var(--border-radius);font-family:var(--font-primary);font-size:.875rem;outline:none}
        .footer-newsletter .subscribe-form button{height:3.125rem;padding:0 1.875rem;border:0;border-radius:0 var(--border-radius) var(--border-radius) 0;background:var(--color-secondary);color:#fff;font-weight:600;font-size:.875rem;cursor:pointer;font-family:var(--font-primary)}
        .footer-widgets{padding:6.25rem 0;background:var(--color-theme-light)}
        .footer-widgets .widget-row{display:grid;grid-template-columns:repeat(4,1fr);gap:1.875rem}
        .footer-widgets .widget-title{font-size:.875rem;font-weight:600;margin-bottom:.9375rem;color:var(--color-main-text)}
        .footer-widgets .widget{font-size:.8125rem;color:var(--color-text-light)}
        .footer-widgets .widget ul{list-style:none;padding:0;margin:0}
        .footer-widgets .widget ul li+li{margin-top:.5rem}
        .footer-widgets .widget ul li a{text-decoration:none;color:currentColor;transition:color .1s}
        .footer-widgets .widget ul li a:hover{color:var(--color-main-text);text-decoration:underline}
        .footer-details{color:#333e48;background:#f8f8f8}
        .footer-details .container{padding:3.75rem 1rem;border-top:1px solid var(--color-theme-border);border-bottom:1px solid var(--color-theme-border)}
        .footer-details .site-details{display:flex;align-items:center;flex-flow:row wrap}
        .footer-details .site-details .site-brand-footer{margin-right:2.5rem}
        .footer-details .site-details .brand-text{font-size:1.5rem;font-weight:800;letter-spacing:-.5px;color:var(--color-main-text)}
        .footer-details .site-details .brand-text .accent{color:var(--color-primary)}
        .footer-details .site-details .tags{display:flex;flex-flow:row wrap;list-style:none;padding:0;margin:0}
        .footer-details .site-details .tags li{position:relative;font-size:.8125rem;color:var(--color-text-light)}
        .footer-details .site-details .tags li::after{content:"|";margin:0 .5rem;color:var(--color-text-light)}
        .footer-details .site-details .tags li:last-child::after{display:none}
        .footer-details .site-details .tags li a{text-decoration:none;color:var(--color-text-light)}
        .footer-details .site-details .tags li a:hover{color:var(--color-main-text)}
        .footer-details .site-details .site-social{margin-left:auto}
        .footer-details .site-details .site-social a{display:inline-flex;width:2rem;height:2rem;border-radius:50%;background:#e0e0e0;color:#333e48;align-items:center;justify-content:center;text-decoration:none;margin-left:.5rem;font-size:.875rem;transition:background .15s}
        .footer-details .site-details .site-social a:hover{background:var(--color-primary)}
        .footer-copyright{background:#eaeaea;padding:1.875rem 0}
        .footer-copyright .container{padding:0 1rem}
        .footer-copyright .footer-bottom{display:flex;align-items:center;justify-content:space-between}
        .footer-copyright .site-copyright{font-size:.75rem;color:#333e48}

        @media(max-width:992px){
            .footer-widgets .widget-row{grid-template-columns:repeat(2,1fr)}
        }
        @media(max-width:768px){
            .site-search select{display:none}
            .header-addons-text,.site-brand{margin-right:0}
            .header-addons:first-of-type{margin-left:.625rem}
            .masthead .header-logo-area{flex:0 0 auto;max-width:none;min-width:0}
            .masthead .navbar-search{padding:0 .625rem}
            .electro-navigation-v5 .departments-menu-v2{display:none}
            .footer-newsletter .site-newsletter{flex-direction:column;align-items:stretch;gap:1rem}
            .footer-newsletter .subscribe-form{max-width:100%}
        }
        @yield('extra_styles')
    </style>
</head>
<body>


{{-- TOP BAR (Electro light style) --}}
<div class="site-header">
<div class="top-bar">
    <div class="container">
        <div class="top-bar-inner">
            <ul class="top-bar-menu">
                <li><a href="#">Sobre nosotros</a></li>
                <li><a href="#">Atención al cliente</a></li>
                <li><a href="#">Ubicación</a></li>
            </ul>
            <div style="display:flex;align-items:center">
                <ul class="top-bar-menu">
                    <li><a href="#">Seguimiento</a></li>
                    <li><a href="#">Ayuda</a></li>
                </ul>
                <span class="top-bar-switcher">USD</span>
                <span class="top-bar-switcher">ES</span>
            </div>
        </div>
    </div>
</div>

{{-- MAIN HEADER (masthead — Electro V5) --}}
<div class="header-main height-padding">
    <div class="container">
        <div class="masthead header-wrapper row align-items-center">
            <div class="header-logo-area">
                <div class="site-brand"><a href="{{ route('home') }}">VHT<span class="accent">tech</span></a></div>
            </div>

            <form class="navbar-search site-search" role="search" method="get" action="#"
                  x-data="searchSuggestions()"
                  @click.outside="open = false"
                  @keydown.escape.prevent="open = false"
                  @submit.prevent="submitSearch()">
                <div class="input-group">
                    <div class="input-search-field search-wrapper">
                        <i class="klbth-icon-search">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        </i>
                        <input type="search" class="form-control search-field" name="s"
                               placeholder="Busca tu producto favorito..."
                               autocomplete="off"
                               x-model="query"
                               @input.debounce.300ms="fetchSuggestions()"
                               @keydown.down.prevent="selectedIndex = Math.min(selectedIndex + 1, totalResults - 1)"
                               @keydown.up.prevent="selectedIndex = Math.max(selectedIndex - 1, 0)"
                               @keydown.enter.prevent="selectSuggestion()">

                        {{-- SUGGESTIONS DROPDOWN --}}
                        <div class="search-suggestions" x-show="open && query.length >= 2" x-cloak>
                            <div class="suggestion-loading" x-show="loading">Buscando</div>
                            <template x-if="!loading && results.products && results.products.length">
                                <div class="suggestion-group">
                                    <div class="suggestion-group-title">Productos</div>
                                    <template x-for="(product, i) in results.products" :key="product.id">
                                        <a :href="'/producto/' + product.slug"
                                           class="suggestion-item"
                                           :class="{ 'active': selectedIndex === i }"
                                           @mouseenter="selectedIndex = i">
                                            <img x-show="product.image" :src="product.image" :alt="product.name" class="suggestion-img">
                                            <div x-show="!product.image" class="suggestion-img-placeholder">
                                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="2"/><circle cx="8.5" cy="8.5" r="1.5"/><path d="M21 15l-5-5L5 21"/></svg>
                                            </div>
                                            <div class="suggestion-info">
                                                <span class="suggestion-name" x-text="product.name"></span>
                                                <span class="suggestion-meta" x-text="product.brand"></span>
                                            </div>
                                            <span class="suggestion-price" x-text="'$' + product.base_price"></span>
                                        </a>
                                    </template>
                                </div>
                            </template>
                            <template x-if="!loading && results.categories && results.categories.length">
                                <div class="suggestion-group">
                                    <div class="suggestion-group-title">Categorías</div>
                                    <template x-for="cat in results.categories" :key="cat.id">
                                        <a :href="'#'" class="suggestion-cat" x-text="cat.name"></a>
                                    </template>
                                </div>
                            </template>
                            <div class="suggestion-empty" x-show="!loading && query.length >= 2 && (!results.products || !results.products.length) && (!results.categories || !results.categories.length)">
                                No se encontraron resultados para "<span x-text="query"></span>"
                            </div>
                        </div>
                    </div>
                    <div class="input-group-addon search-categories">
                        <select class="form-select" name="product_cat" id="categories"
                                x-model="category">
                            <option value="" selected>Todas las categorías</option>
                            @foreach($headerCategories as $category)
                                <option value="{{ $category->slug }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="input-group-btn">
                        <input type="hidden" name="post_type" value="product">
                        <button class="btn btn-secondary" type="submit">
                            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
                        </button>
                    </div>
                </div>
            </form>

            <div class="header-icons">
                @auth
                <div class="header-addons login-button">
                    <a href="#">
                        <div class="header-addons-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 10-16 0"/></svg>
                        </div>
                        <div class="header-addons-text">
                            <span class="sub-text">Hola,</span>
                            <span class="primary-text">{{ Auth::user()->name }}</span>
                        </div>
                    </a>
                </div>
                <div class="header-addons" style="margin-left:.5rem">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:var(--color-text-light);font-size:.75rem;cursor:pointer;font-family:var(--font-primary);padding:.25rem .5rem;transition:color .15s;white-space:nowrap"
                                onmouseover="this.style.color='var(--color-main-text)'" onmouseout="this.style.color='var(--color-text-light)'">Salir</button>
                    </form>
                </div>
                @else
                <div class="header-addons login-button">
                    <a href="{{ route('login') }}">
                        <div class="header-addons-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="12" cy="8" r="4"/><path d="M20 21a8 8 0 10-16 0"/></svg>
                        </div>
                        <div class="header-addons-text">
                            <span class="sub-text">Iniciar sesión</span>
                            <span class="primary-text">Cuenta</span>
                        </div>
                    </a>
                </div>
                @endauth

                <div class="header-addons wishlist-button">
                    <a href="#">
                        <div class="header-addons-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            <span class="button-count" data-count="0">0</span>
                        </div>
                    </a>
                </div>

                <div class="header-addons cart-button">
                    <a href="#">
                        <div class="header-addons-icon">
                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                            <span class="button-count" data-count="0">0</span>
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

{{-- ELECTRO V5 NAVIGATION (full-width, white, box-shadow) --}}
<div class="electro-navigation-v5">
    <div class="container">
        <div class="electro-navigation">
            <div class="departments-menu-v2">
                <div class="site-departments large">
                    <div class="site-departments-wrapper">
                        <a href="#" class="all-categories departments-menu-v2-title">
                            <span class="departments-menu-v2-icon">
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
                                    <a href="{{ route('search.results', ['categoria' => $category->slug]) }}">{{ $category->name }}</a>
                                    @if($category->children->count())
                                        <ul class="department-submenu">
                                            @foreach($category->children as $child)
                                                <li><a href="{{ route('search.results', ['categoria' => $child->slug]) }}">{{ $child->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <nav class="secondary-nav">
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
    <div class="footer-copyright">
        <div class="container">
            <div class="footer-bottom">
                <div class="site-copyright"><p>Copyright {{ date('Y') }}. VHTtech Store. Todos los derechos reservados.</p></div>
                <div class="site-payment"><span style="font-size:.75rem;color:var(--color-text-light)">Vista previa — Tienda en construcción</span></div>
            </div>
        </div>
    </div>
</footer>

@stack('scripts')
</body>
</html>

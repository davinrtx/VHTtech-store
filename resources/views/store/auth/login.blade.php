@extends('layouts.store')

@section('title', 'Iniciar sesión — VHTtech Store')

@section('extra_styles')
    /* AUTH PAGES */
    .auth-section{padding:3.75rem 0;min-height:70vh;display:flex;align-items:center}
    .auth-card{max-width:600px;margin:0 auto;width:100%;background:#fff;border:1px solid var(--color-theme-border);border-radius:var(--border-radius);padding:2.5rem;box-shadow:0 2px 12px rgba(0,0,0,.04)}
    .auth-card .auth-header{text-align:center;margin-bottom:2rem}
    .auth-card .auth-header .auth-logo{font-size:1.5rem;font-weight:800;color:var(--color-primary);letter-spacing:-.5px;margin-bottom:.5rem;display:block}
    .auth-card .auth-header .auth-logo .accent{color:var(--color-secondary)}
    .auth-card .auth-header h1{font-size:1.375rem;font-weight:700;color:var(--color-main-text);margin-bottom:.25rem}
    .auth-card .auth-header p{font-size:.875rem;color:var(--color-text-light)}
    .auth-card .form-group{margin-bottom:1.25rem}
    .auth-card .form-group label{display:block;font-size:.8125rem;font-weight:600;color:var(--color-main-text);margin-bottom:.375rem}
    .auth-card .form-group .form-input{display:block;width:100%;height:3rem;padding:0 .875rem;font-size:.875rem;color:var(--color-main-text);background:#fff;border:1px solid var(--color-form-border);border-radius:6px;outline:none;transition:border-color .15s;font-family:var(--font-primary)}
    .auth-card .form-group .form-input:focus{border-color:var(--color-primary);box-shadow:0 0 0 3px rgba(21,101,192,.1)}
    .auth-card .form-group .form-input::placeholder{color:#9aa5b3}
    .auth-card .form-row{display:flex;align-items:center;justify-content:space-between;margin-bottom:1.5rem}
    .auth-card .form-row label.check{display:flex;align-items:center;gap:.5rem;font-size:.8125rem;color:var(--color-text-light);cursor:pointer}
    .auth-card .form-row label.check input[type=checkbox]{width:1rem;height:1rem;accent-color:var(--color-primary);cursor:pointer}
    .auth-card .form-row .forgot-link{font-size:.8125rem;color:var(--color-link);text-decoration:none}
    .auth-card .form-row .forgot-link:hover{text-decoration:underline}
    .auth-card .btn-submit{display:block;width:100%;height:3rem;background:var(--color-primary);color:#fff;border:none;border-radius:6px;font-size:.9375rem;font-weight:600;cursor:pointer;transition:background .15s;font-family:var(--font-primary)}
    .auth-card .btn-submit:hover{background:var(--color-shop-button-active)}
    .auth-card .auth-footer{text-align:center;margin-top:1.5rem;padding-top:1.5rem;border-top:1px solid var(--color-theme-border)}
    .auth-card .auth-footer p{font-size:.8125rem;color:var(--color-text-light)}
    .auth-card .auth-footer a{color:var(--color-link);font-weight:600;text-decoration:none}
    .auth-card .auth-footer a:hover{text-decoration:underline}
    .auth-card .auth-divider{display:flex;align-items:center;gap:1rem;margin:1.5rem 0;color:var(--color-text-light);font-size:.75rem}
    .auth-card .auth-divider::before,.auth-card .auth-divider::after{content:'';flex:1;height:1px;background:var(--color-theme-border)}
    .auth-card .btn-social{display:flex;align-items:center;justify-content:center;gap:.625rem;width:100%;height:2.75rem;border:1px solid var(--color-theme-border);border-radius:6px;background:#fff;color:var(--color-main-text);font-size:.8125rem;font-weight:500;cursor:pointer;transition:all .15s;font-family:var(--font-primary);text-decoration:none}
    .auth-card .btn-social:hover{border-color:var(--color-primary);color:var(--color-primary)}
    .auth-card .auth-error{background:#fef2f2;border:1px solid #fecaca;border-radius:6px;padding:.75rem 1rem;margin-bottom:1.25rem;font-size:.8125rem;color:#991b1b}
    @media(max-width:576px){
        .auth-section{padding:2.5rem 0}
        .auth-card{padding:1.5rem;border-radius:0;border-left:none;border-right:none}
        .auth-card .form-row{flex-direction:column;gap:.75rem;align-items:flex-start}
    }
@endsection

@section('content')
<section class="auth-section">
    <div class="container">
        <div class="auth-card">
            <div class="auth-header">
                <span class="auth-logo">VHT<span class="accent">tech</span></span>
                <h1>Iniciar sesión</h1>
                <p>Ingresá tus credenciales para continuar</p>
            </div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                @if($errors->any())
                    <div class="auth-error">
                        @foreach($errors->all() as $error)
                            {{ $error }}<br>
                        @endforeach
                    </div>
                @endif

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input type="email" id="email" name="email" class="form-input"
                           placeholder="tucorreo@ejemplo.com" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-input"
                           placeholder="••••••••" required>
                </div>

                <div class="form-row">
                    <label class="check">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        Recordarme
                    </label>
                    <a href="#" class="forgot-link">¿Olvidaste tu contraseña?</a>
                </div>

                <button type="submit" class="btn-submit">Iniciar sesión</button>

                <div class="auth-divider">o continuá con</div>

                <a href="#" class="btn-social">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/></svg>
                    Continuar con Google
                </a>

                <div class="auth-footer">
                    <p>¿No tenés cuenta? <a href="{{ route('register') }}">Crear cuenta</a></p>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection

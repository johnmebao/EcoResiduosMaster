<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EcoResiduos') }} - Gestión Inteligente de Residuos</title>
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary-green: #10b981;
            --primary-green-dark: #059669;
            --secondary-green: #34d399;
            --light-green: #d1fae5;
            --dark-green: #065f46;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --bg-light: #f9fafb;
            --white: #ffffff;
            --border-light: #e5e7eb;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            line-height: 1.6;
            color: var(--text-dark);
            background-color: var(--white);
        }

        /* Header Styles */
        .header {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            padding: 1rem 0;
        }

        .nav {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--primary-green);
            text-decoration: none;
        }

        .logo svg {
            width: 32px;
            height: 32px;
        }

        .nav-links {
            display: flex;
            gap: 1.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-dark);
            font-weight: 500;
            transition: color 0.3s;
        }

        .nav-links a:hover {
            color: var(--primary-green);
        }

        .btn-primary {
            background: var(--primary-green);
            color: var(--white);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            background: var(--primary-green-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3);
        }

        .btn-secondary {
            background: transparent;
            color: var(--primary-green);
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
            display: inline-block;
            border: 2px solid var(--primary-green);
        }

        .btn-secondary:hover {
            background: var(--light-green);
        }

        /* Hero Section */
        .hero {
            padding: 8rem 2rem 4rem;
            background: linear-gradient(135deg, #ecfdf5 0%, #f0fdf4 100%);
            margin-top: 60px;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
        }

        .hero-text h1 {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
        }

        .hero-text h1 .highlight {
            color: var(--primary-green);
        }

        .hero-text p {
            font-size: 1.25rem;
            color: var(--text-light);
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .hero-image {
            position: relative;
            border-radius: 20px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.15);
        }

        .hero-image img {
            width: 100%;
            height: auto;
            display: block;
        }

        /* Stats Section */
        .stats {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            max-width: 1200px;
            margin: -3rem auto 4rem;
            padding: 0 2rem;
            position: relative;
            z-index: 10;
        }

        .stat-card {
            background: var(--white);
            padding: 2rem;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-green);
            display: block;
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: var(--text-light);
            font-weight: 500;
        }

        /* Section Styles */
        .section {
            padding: 5rem 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
        }

        .section-header h2 {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }

        .section-header p {
            font-size: 1.125rem;
            color: var(--text-light);
            max-width: 600px;
            margin: 0 auto;
        }

        /* Services Grid */
        .services-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
        }

        .service-card {
            background: var(--white);
            padding: 2.5rem;
            border-radius: 16px;
            border: 2px solid var(--border-light);
            transition: all 0.3s;
        }

        .service-card:hover {
            border-color: var(--primary-green);
            box-shadow: 0 8px 30px rgba(16, 185, 129, 0.15);
            transform: translateY(-5px);
        }

        .service-icon {
            width: 60px;
            height: 60px;
            background: var(--light-green);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1.5rem;
        }

        .service-icon svg {
            width: 32px;
            height: 32px;
            color: var(--primary-green);
        }

        .service-card h3 {
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .service-card p {
            color: var(--text-light);
            line-height: 1.7;
        }

        /* Process Steps */
        .process-steps {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .process-step {
            text-align: center;
            position: relative;
        }

        .process-step:not(:last-child)::after {
            content: '→';
            position: absolute;
            right: -1rem;
            top: 2rem;
            font-size: 2rem;
            color: var(--primary-green);
            opacity: 0.3;
        }

        .step-number {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
            color: var(--white);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            font-weight: 800;
            margin: 0 auto 1.5rem;
            box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
        }

        .process-step h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.75rem;
            color: var(--text-dark);
        }

        .process-step p {
            color: var(--text-light);
            font-size: 0.95rem;
        }

        /* Benefits Grid */
        .benefits-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 2rem;
            margin-top: 3rem;
        }

        .benefit-card {
            display: flex;
            gap: 1.5rem;
            padding: 2rem;
            background: var(--bg-light);
            border-radius: 12px;
            transition: all 0.3s;
        }

        .benefit-card:hover {
            background: var(--light-green);
        }

        .benefit-icon {
            width: 50px;
            height: 50px;
            background: var(--primary-green);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .benefit-icon svg {
            width: 28px;
            height: 28px;
            color: var(--white);
        }

        .benefit-content h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            color: var(--text-dark);
        }

        .benefit-content p {
            color: var(--text-light);
        }

        /* CTA Section */
        .cta {
            background: linear-gradient(135deg, var(--primary-green), var(--dark-green));
            padding: 5rem 2rem;
            text-align: center;
            color: var(--white);
        }

        .cta h2 {
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 1rem;
        }

        .cta p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            opacity: 0.95;
        }

        .cta .btn-primary {
            background: var(--white);
            color: var(--primary-green);
            font-size: 1.125rem;
            padding: 1rem 2.5rem;
        }

        .cta .btn-primary:hover {
            background: var(--light-green);
            color: var(--primary-green-dark);
        }

        /* Footer */
        .footer {
            background: var(--text-dark);
            color: var(--white);
            padding: 3rem 2rem 1.5rem;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 3rem;
            margin-bottom: 2rem;
        }

        .footer-section h3 {
            font-size: 1.25rem;
            font-weight: 700;
            margin-bottom: 1rem;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 0.75rem;
        }

        .footer-section ul li a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: color 0.3s;
        }

        .footer-section ul li a:hover {
            color: var(--secondary-green);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 1.5rem;
            text-align: center;
            color: rgba(255, 255, 255, 0.6);
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .hero-content {
                grid-template-columns: 1fr;
                gap: 3rem;
            }

            .hero-text h1 {
                font-size: 2.5rem;
            }

            .services-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .process-steps {
                grid-template-columns: repeat(2, 1fr);
            }

            .process-step:not(:last-child)::after {
                display: none;
            }

            .footer-content {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero {
                padding: 6rem 1.5rem 3rem;
            }

            .hero-text h1 {
                font-size: 2rem;
            }

            .hero-text p {
                font-size: 1rem;
            }

            .stats {
                grid-template-columns: 1fr;
                gap: 1.5rem;
            }

            .services-grid,
            .benefits-grid,
            .process-steps {
                grid-template-columns: 1fr;
            }

            .section-header h2 {
                font-size: 2rem;
            }

            .nav-links {
                gap: 1rem;
            }

            .hero-buttons {
                flex-direction: column;
            }

            .hero-buttons .btn-primary,
            .hero-buttons .btn-secondary {
                width: 100%;
                text-align: center;
            }

            .footer-content {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .cta h2 {
                font-size: 2rem;
            }

            .cta p {
                font-size: 1rem;
            }
        }

        @media (max-width: 480px) {
            .nav {
                padding: 0 1rem;
            }

            .logo {
                font-size: 1.25rem;
            }

            .section {
                padding: 3rem 1.5rem;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header">
        <nav class="nav">
            <a href="/" class="logo">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M12 2L2 7v10c0 5.55 3.84 10.74 9 12 5.16-1.26 9-6.45 9-12V7l-10-5zm0 2.18l8 3.6v8.72c0 4.45-3.08 8.63-7 9.81V4.18l-1-0.45v17.08c-3.92-1.18-7-5.36-7-9.81V7.78l7-3.15z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                <span>EcoResiduos</span>
            </a>
            <div class="nav-links">
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="btn-primary">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Iniciar Sesión</a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="btn-primary">Registrarse</a>
                        @endif
                    @endauth
                @endif
            </div>
        </nav>
    </header>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-text">
                <h1>Gestión Inteligente de <span class="highlight">Residuos</span> para un Futuro Sostenible</h1>
                <p>Transformamos la manera en que las empresas y hogares gestionan sus residuos. Soluciones ecológicas, eficientes y tecnológicas para un planeta más limpio.</p>
                <div class="hero-buttons">
                    <a href="#contacto" class="btn-primary">Solicitar Servicio</a>
                    <a href="#servicios" class="btn-secondary">Conocer Más</a>
                </div>
            </div>
            <div class="hero-image">
                <svg viewBox="0 0 600 400" style="width: 100%; height: auto;">
                    <defs>
                        <linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%">
                            <stop offset="0%" style="stop-color:#10b981;stop-opacity:1" />
                            <stop offset="100%" style="stop-color:#059669;stop-opacity:1" />
                        </linearGradient>
                    </defs>
                    <rect width="600" height="400" fill="#d1fae5"/>
                    <circle cx="300" cy="200" r="120" fill="url(#grad1)" opacity="0.3"/>
                    <circle cx="300" cy="200" r="80" fill="url(#grad1)" opacity="0.5"/>
                    <path d="M 250 180 L 270 200 L 250 220 M 350 180 L 330 200 L 350 220" stroke="#fff" stroke-width="8" fill="none" stroke-linecap="round"/>
                    <circle cx="300" cy="200" r="40" fill="url(#grad1)"/>
                    <text x="300" y="340" font-size="24" font-weight="bold" fill="#065f46" text-anchor="middle">♻️ Reciclaje Inteligente</text>
                </svg>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <div class="stats">
        <div class="stat-card">
            <span class="stat-number">15K+</span>
            <span class="stat-label">Clientes Satisfechos</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">500+</span>
            <span class="stat-label">Toneladas Recicladas</span>
        </div>
        <div class="stat-card">
            <span class="stat-number">98%</span>
            <span class="stat-label">Tasa de Reciclaje</span>
        </div>
    </div>

    <!-- Services Section -->
    <section class="section" id="servicios">
        <div class="section-header">
            <h2>Nuestros Servicios</h2>
            <p>Soluciones completas de gestión de residuos adaptadas a tus necesidades específicas</p>
        </div>
        <div class="services-grid">
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/>
                        <polyline points="9 22 9 12 15 12 15 22"/>
                    </svg>
                </div>
                <h3>Recolección Residencial</h3>
                <p>Servicio puerta a puerta con horarios flexibles y opciones de reciclaje diferenciado para hogares.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </div>
                <h3>Gestión Empresarial</h3>
                <p>Planes corporativos con contenedores industriales y gestión de residuos especiales para empresas.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"/>
                        <polyline points="7.5 4.21 12 6.81 16.5 4.21"/>
                        <polyline points="7.5 19.79 7.5 14.6 3 12"/>
                        <polyline points="21 12 16.5 14.6 16.5 19.79"/>
                        <polyline points="3.27 6.96 12 12.01 20.73 6.96"/>
                        <line x1="12" y1="22.08" x2="12" y2="12"/>
                    </svg>
                </div>
                <h3>Reciclaje Especializado</h3>
                <p>Procesamiento de materiales especiales: electrónicos, orgánicos, plásticos y materiales peligrosos.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 20v-6M6 20V10M18 20V4"/>
                    </svg>
                </div>
                <h3>Monitoreo en Tiempo Real</h3>
                <p>Plataforma digital para seguimiento de recolecciones, reportes y optimización de rutas.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <polyline points="12 6 12 12 16 14"/>
                    </svg>
                </div>
                <h3>Recolección Programada</h3>
                <p>Sistema de agendamiento flexible con notificaciones automáticas y recordatorios.</p>
            </div>
            <div class="service-card">
                <div class="service-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M22 12h-4l-3 9L9 3l-3 9H2"/>
                    </svg>
                </div>
                <h3>Consultoría Ambiental</h3>
                <p>Asesoría especializada en gestión de residuos, certificaciones y cumplimiento normativo.</p>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section class="section" style="background: var(--bg-light);">
        <div class="section-header">
            <h2>¿Cómo Funciona?</h2>
            <p>Un proceso simple y eficiente en solo 4 pasos</p>
        </div>
        <div class="process-steps">
            <div class="process-step">
                <div class="step-number">1</div>
                <h3>Registro</h3>
                <p>Crea tu cuenta y elige el plan que mejor se adapte a tus necesidades</p>
            </div>
            <div class="process-step">
                <div class="step-number">2</div>
                <h3>Programa</h3>
                <p>Agenda tu recolección según tu disponibilidad y frecuencia preferida</p>
            </div>
            <div class="process-step">
                <div class="step-number">3</div>
                <h3>Recolección</h3>
                <p>Nuestro equipo recoge tus residuos de forma puntual y profesional</p>
            </div>
            <div class="process-step">
                <div class="step-number">4</div>
                <h3>Reciclaje</h3>
                <p>Procesamos y reciclamos tus residuos de manera responsable y sostenible</p>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section class="section">
        <div class="section-header">
            <h2>Beneficios de EcoResiduos</h2>
            <p>Más que un servicio de recolección, una solución integral para el medio ambiente</p>
        </div>
        <div class="benefits-grid">
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
                    </svg>
                </div>
                <div class="benefit-content">
                    <h3>100% Confiable</h3>
                    <p>Servicio garantizado con cobertura completa y atención al cliente 24/7</p>
                </div>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/>
                        <line x1="7" y1="7" x2="7.01" y2="7"/>
                    </svg>
                </div>
                <div class="benefit-content">
                    <h3>Precios Competitivos</h3>
                    <p>Tarifas justas y transparentes sin costos ocultos ni sorpresas</p>
                </div>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/>
                        <path d="M8 14s1.5 2 4 2 4-2 4-2"/>
                        <line x1="9" y1="9" x2="9.01" y2="9"/>
                        <line x1="15" y1="9" x2="15.01" y2="9"/>
                    </svg>
                </div>
                <div class="benefit-content">
                    <h3>Fácil de Usar</h3>
                    <p>Plataforma intuitiva para gestionar todos tus servicios desde cualquier dispositivo</p>
                </div>
            </div>
            <div class="benefit-card">
                <div class="benefit-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                    </svg>
                </div>
                <div class="benefit-content">
                    <h3>Impacto Positivo</h3>
                    <p>Contribuye activamente a la reducción de huella de carbono y protección ambiental</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta" id="contacto">
        <h2>¿Listo para Comenzar?</h2>
        <p>Únete a miles de clientes que ya confían en EcoResiduos para un futuro más sostenible</p>
        <a href="{{ Route::has('register') ? route('register') : '#' }}" class="btn-primary">Solicitar Servicio Ahora</a>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-content">
            <div class="footer-section">
                <h3>EcoResiduos</h3>
                <p style="color: rgba(255, 255, 255, 0.7); line-height: 1.8;">Liderando la transformación hacia una gestión sostenible de residuos con tecnología e innovación.</p>
            </div>
            <div class="footer-section">
                <h3>Servicios</h3>
                <ul>
                    <li><a href="#servicios">Recolección Residencial</a></li>
                    <li><a href="#servicios">Gestión Empresarial</a></li>
                    <li><a href="#servicios">Reciclaje Especializado</a></li>
                    <li><a href="#servicios">Consultoría</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Empresa</h3>
                <ul>
                    <li><a href="#nosotros">Sobre Nosotros</a></li>
                    <li><a href="#equipo">Nuestro Equipo</a></li>
                    <li><a href="#blog">Blog</a></li>
                    <li><a href="#contacto">Contacto</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Legal</h3>
                <ul>
                    <li><a href="#privacidad">Política de Privacidad</a></li>
                    <li><a href="#terminos">Términos y Condiciones</a></li>
                    <li><a href="#cookies">Cookies</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; {{ date('Y') }} EcoResiduos. Todos los derechos reservados.</p>
        </div>
    </footer>
</body>
</html>

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EcoResiduos - Empresa líder en recolección de residuos. Sistema de puntos, recompensas y compromiso con el medio ambiente.">
    <meta name="keywords" content="recolección de residuos, reciclaje, residuos orgánicos, medio ambiente, sostenibilidad">

    <title>EcoResiduos - Recolección Inteligente de Residuos</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&family=poppins:600,700,800" rel="stylesheet" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        
        h1, h2, h3 {
            font-family: 'Poppins', sans-serif;
        }

        /* Animaciones personalizadas */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }

        @keyframes float {
            0%, 100% {
                transform: translateY(0px);
            }
            50% {
                transform: translateY(-20px);
            }
        }

        @keyframes pulse-custom {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.05);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.8s ease-out forwards;
        }

        .animate-fade-in {
            animation: fadeIn 1s ease-out forwards;
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        .delay-100 {
            animation-delay: 0.1s;
        }

        .delay-200 {
            animation-delay: 0.2s;
        }

        .delay-300 {
            animation-delay: 0.3s;
        }

        .delay-400 {
            animation-delay: 0.4s;
        }

        /* Gradiente Hero */
        .hero-gradient {
            background: linear-gradient(135deg, #059669 0%, #10b981 50%, #3b82f6 100%);
        }

        .hero-pattern {
            background-image: 
                radial-gradient(circle at 20% 50%, rgba(16, 185, 129, 0.3) 0%, transparent 50%),
                radial-gradient(circle at 80% 80%, rgba(59, 130, 246, 0.3) 0%, transparent 50%);
        }

        /* Efectos hover mejorados */
        .card-hover {
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .card-hover:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
        }

        /* Botones con efecto */
        .btn-primary {
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        /* Iconos con efecto pulse */
        .icon-pulse {
            animation: pulse-custom 2s ease-in-out infinite;
        }

        /* Scroll reveal */
        .scroll-reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease-out;
        }

        .scroll-reveal.revealed {
            opacity: 1;
            transform: translateY(0);
        }

        /* Contador de estadísticas */
        .stat-number {
            background: linear-gradient(135deg, #10b981, #059669);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-900 antialiased">
    
    <!-- Navbar -->
    <nav class="fixed w-full top-0 z-50 bg-white/90 backdrop-blur-lg shadow-md">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <div class="flex items-center justify-between h-20">
                <!-- Logo -->
                <a href="/" class="flex items-center space-x-3 group">
                    <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 p-2.5 rounded-xl group-hover:scale-110 transition-transform duration-300">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </div>
                    <span class="font-bold text-2xl bg-gradient-to-r from-emerald-600 to-emerald-700 bg-clip-text text-transparent">
                        EcoResiduos
                    </span>
                </a>

                <!-- Desktop Navigation -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#servicios" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors">Servicios</a>
                    <a href="#como-funciona" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors">¿Cómo Funciona?</a>
                    <a href="#beneficios" class="text-gray-700 hover:text-emerald-600 font-medium transition-colors">Beneficios</a>
                </div>

                <!-- Auth Buttons -->
                @if (Route::has('login'))
                <div class="hidden md:flex items-center space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}" class="px-6 py-2.5 rounded-lg font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-lg hover:shadow-xl">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-6 py-2.5 rounded-lg font-semibold text-gray-700 hover:text-emerald-600 hover:bg-gray-100 transition-all">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-6 py-2.5 rounded-lg font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-lg hover:shadow-xl btn-primary">
                            Registrarse
                        </a>
                        @endif
                    @endauth
                </div>
                @endif

                <!-- Mobile Menu Button -->
                <button id="mobile-menu-btn" class="md:hidden text-gray-700 hover:text-emerald-600">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-gray-200">
            <div class="px-6 py-4 space-y-4">
                <a href="#servicios" class="block text-gray-700 hover:text-emerald-600 font-medium">Servicios</a>
                <a href="#como-funciona" class="block text-gray-700 hover:text-emerald-600 font-medium">¿Cómo Funciona?</a>
                <a href="#beneficios" class="block text-gray-700 hover:text-emerald-600 font-medium">Beneficios</a>
                @if (Route::has('login'))
                    @auth
                        <a href="{{ url('/dashboard') }}" class="block px-6 py-2.5 rounded-lg font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 text-center">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="block px-6 py-2.5 rounded-lg font-semibold text-gray-700 hover:bg-gray-100 text-center">
                            Iniciar Sesión
                        </a>
                        @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block px-6 py-2.5 rounded-lg font-semibold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 text-center">
                            Registrarse
                        </a>
                        @endif
                    @endauth
                @endif
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-32 hero-gradient hero-pattern overflow-hidden">
        <!-- Elementos decorativos -->
        <div class="absolute top-20 left-10 w-72 h-72 bg-white/10 rounded-full blur-3xl animate-float"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-blue-400/10 rounded-full blur-3xl animate-float delay-200"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Contenido -->
                <div class="text-white animate-fade-in-up">
                    <div class="inline-flex items-center space-x-2 bg-white/20 backdrop-blur-sm px-4 py-2 rounded-full mb-6">
                        <i class="fas fa-leaf text-emerald-200"></i>
                        <span class="text-sm font-semibold">Compromiso con el Medio Ambiente</span>
                    </div>
                    
                    <h1 class="text-5xl lg:text-7xl font-extrabold leading-tight mb-6">
                        Transformando Residuos en 
                        <span class="bg-white/20 backdrop-blur-sm px-4 py-2 rounded-2xl inline-block">Oportunidades</span>
                    </h1>
                    
                    <p class="text-xl lg:text-2xl text-white/90 mb-8 leading-relaxed">
                        Únete a la revolución del reciclaje inteligente. Gana puntos, contribuye al planeta y recibe recompensas increíbles.
                    </p>

                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('register') }}" class="group px-8 py-4 rounded-xl font-bold text-emerald-700 bg-white hover:bg-gray-50 transition-all shadow-2xl hover:shadow-3xl transform hover:scale-105 inline-flex items-center justify-center space-x-2">
                            <span>Comenzar Ahora</span>
                            <i class="fas fa-arrow-right group-hover:translate-x-1 transition-transform"></i>
                        </a>
                        <a href="{{ route('login') }}" class="px-8 py-4 rounded-xl font-bold text-white border-2 border-white/50 hover:bg-white/10 backdrop-blur-sm transition-all inline-flex items-center justify-center space-x-2">
                            <span>Iniciar Sesión</span>
                            <i class="fas fa-sign-in-alt"></i>
                        </a>
                    </div>

                    <!-- Estadísticas rápidas -->
                    <div class="grid grid-cols-3 gap-6 mt-12 pt-12 border-t border-white/20">
                        <div>
                            <div class="text-4xl font-bold mb-2">5K+</div>
                            <div class="text-white/80 text-sm">Usuarios Activos</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold mb-2">50K+</div>
                            <div class="text-white/80 text-sm">Kg Reciclados</div>
                        </div>
                        <div>
                            <div class="text-4xl font-bold mb-2">98%</div>
                            <div class="text-white/80 text-sm">Satisfacción</div>
                        </div>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="hidden lg:block animate-fade-in-up delay-200">
                    <div class="relative">
                        <!-- Tarjeta de imagen con efecto glassmorphism -->
                        <div class="relative bg-white/10 backdrop-blur-lg rounded-3xl p-4 shadow-2xl border border-white/20">
                            <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?q=80&w=2940&auto=format&fit=crop" 
                                 alt="Reciclaje y sostenibilidad" 
                                 class="rounded-2xl w-full h-auto object-cover shadow-xl">
                            
                            <!-- Tarjetas flotantes con información -->
                            <div class="absolute -bottom-6 -left-6 bg-white rounded-2xl shadow-2xl p-4 animate-float">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-emerald-100 p-3 rounded-xl">
                                        <i class="fas fa-recycle text-emerald-600 text-2xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-gray-900">2,450</div>
                                        <div class="text-sm text-gray-600">Puntos Ganados</div>
                                    </div>
                                </div>
                            </div>

                            <div class="absolute -top-6 -right-6 bg-white rounded-2xl shadow-2xl p-4 animate-float delay-100">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-3 rounded-xl">
                                        <i class="fas fa-leaf text-blue-600 text-2xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-2xl font-bold text-gray-900">-85%</div>
                                        <div class="text-sm text-gray-600">CO₂ Reducido</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Wave separator -->
        <div class="absolute bottom-0 left-0 w-full">
            <svg viewBox="0 0 1440 120" fill="none" xmlns="http://www.w3.org/2000/svg" class="w-full h-auto">
                <path d="M0 120L60 105C120 90 240 60 360 45C480 30 600 30 720 37.5C840 45 960 60 1080 67.5C1200 75 1320 75 1380 75L1440 75V120H1380C1320 120 1200 120 1080 120C960 120 840 120 720 120C600 120 480 120 360 120C240 120 120 120 60 120H0V120Z" fill="#F9FAFB"/>
            </svg>
        </div>
    </section>

    <!-- Sección Nuestros Servicios -->
    <section id="servicios" class="py-20 lg:py-32 bg-gray-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16 scroll-reveal">
                <div class="inline-flex items-center space-x-2 bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full mb-4">
                    <i class="fas fa-recycle"></i>
                    <span class="text-sm font-semibold">Tipos de Residuos</span>
                </div>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6">
                    Nuestros Servicios
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Recolectamos y procesamos diferentes tipos de residuos de manera responsable y eficiente
                </p>
            </div>

            <!-- Tarjetas de Servicios -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Residuos Orgánicos (FO) -->
                <div class="bg-white rounded-2xl shadow-xl p-8 card-hover scroll-reveal border-t-4 border-emerald-600">
                    <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 icon-pulse">
                        <i class="fas fa-apple-alt text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Residuos Orgánicos</h3>
                    <div class="bg-emerald-100 text-emerald-700 text-sm font-bold px-3 py-1 rounded-full inline-block mb-4">FO</div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Restos de comida, cáscaras, residuos de jardín y todo material biodegradable que puede convertirse en compost.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-emerald-600"></i>
                            <span>Compostaje ecológico</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-emerald-600"></i>
                            <span>Recolección semanal</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-emerald-600"></i>
                            <span>+50 puntos por kg</span>
                        </li>
                    </ul>
                </div>

                <!-- Frutas y Verduras (FV) -->
                <div class="bg-white rounded-2xl shadow-xl p-8 card-hover scroll-reveal delay-100 border-t-4 border-green-600">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 icon-pulse">
                        <i class="fas fa-carrot text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Frutas y Verduras</h3>
                    <div class="bg-green-100 text-green-700 text-sm font-bold px-3 py-1 rounded-full inline-block mb-4">FV</div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Restos de frutas y verduras especialmente seleccionados para procesamiento especializado y creación de abonos orgánicos.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span>Abono orgánico premium</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span>Recolección bisemanal</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-green-600"></i>
                            <span>+75 puntos por kg</span>
                        </li>
                    </ul>
                </div>

                <!-- Residuos Inorgánicos -->
                <div class="bg-white rounded-2xl shadow-xl p-8 card-hover scroll-reveal delay-200 border-t-4 border-blue-600">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 icon-pulse">
                        <i class="fas fa-recycle text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Residuos Inorgánicos</h3>
                    <div class="bg-blue-100 text-blue-700 text-sm font-bold px-3 py-1 rounded-full inline-block mb-4">INORG</div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Plásticos, vidrios, metales, papel y cartón. Todo material reciclable que puede tener una segunda vida útil.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-blue-600"></i>
                            <span>Clasificación automática</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-blue-600"></i>
                            <span>Recolección semanal</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-blue-600"></i>
                            <span>+40 puntos por kg</span>
                        </li>
                    </ul>
                </div>

                <!-- Residuos Peligrosos -->
                <div class="bg-white rounded-2xl shadow-xl p-8 card-hover scroll-reveal delay-300 border-t-4 border-red-600">
                    <div class="bg-gradient-to-br from-red-500 to-red-600 w-16 h-16 rounded-2xl flex items-center justify-center mb-6 icon-pulse">
                        <i class="fas fa-exclamation-triangle text-white text-3xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">Residuos Peligrosos</h3>
                    <div class="bg-red-100 text-red-700 text-sm font-bold px-3 py-1 rounded-full inline-block mb-4">PELIGROSO</div>
                    <p class="text-gray-600 leading-relaxed mb-4">
                        Baterías, electrónicos, químicos y otros materiales que requieren manejo especializado y certificado.
                    </p>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-red-600"></i>
                            <span>Disposición certificada</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-red-600"></i>
                            <span>Recolección mensual</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <i class="fas fa-check-circle text-red-600"></i>
                            <span>+100 puntos por kg</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección ¿Cómo Funciona? -->
    <section id="como-funciona" class="py-20 lg:py-32 bg-white relative overflow-hidden">
        <!-- Elementos decorativos -->
        <div class="absolute top-0 right-0 w-96 h-96 bg-emerald-100 rounded-full blur-3xl opacity-30"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-blue-100 rounded-full blur-3xl opacity-30"></div>

        <div class="relative max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16 scroll-reveal">
                <div class="inline-flex items-center space-x-2 bg-blue-100 text-blue-700 px-4 py-2 rounded-full mb-4">
                    <i class="fas fa-lightbulb"></i>
                    <span class="text-sm font-semibold">Proceso Simple</span>
                </div>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6">
                    ¿Cómo Funciona?
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Cuatro simples pasos para comenzar a ganar puntos y ayudar al medio ambiente
                </p>
            </div>

            <!-- Pasos -->
            <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Paso 1 -->
                <div class="relative scroll-reveal">
                    <div class="bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-2xl p-8 text-center card-hover">
                        <div class="relative inline-block mb-6">
                            <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 w-20 h-20 rounded-2xl flex items-center justify-center shadow-xl">
                                <i class="fas fa-user-plus text-white text-3xl"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 bg-white text-emerald-600 font-bold text-lg w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                                1
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Regístrate</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Crea tu cuenta en minutos. Es gratis y sin compromisos. Solo necesitas tu email y listo.
                        </p>
                    </div>
                    <!-- Flecha conectora (desktop) -->
                    <div class="hidden lg:block absolute top-1/2 -right-4 transform -translate-y-1/2">
                        <i class="fas fa-arrow-right text-4xl text-emerald-300"></i>
                    </div>
                </div>

                <!-- Paso 2 -->
                <div class="relative scroll-reveal delay-100">
                    <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-2xl p-8 text-center card-hover">
                        <div class="relative inline-block mb-6">
                            <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-20 h-20 rounded-2xl flex items-center justify-center shadow-xl">
                                <i class="fas fa-calendar-alt text-white text-3xl"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 bg-white text-blue-600 font-bold text-lg w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                                2
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Programa</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Selecciona día y hora para tu recolección. Flexible y adaptado a tu horario.
                        </p>
                    </div>
                    <div class="hidden lg:block absolute top-1/2 -right-4 transform -translate-y-1/2">
                        <i class="fas fa-arrow-right text-4xl text-blue-300"></i>
                    </div>
                </div>

                <!-- Paso 3 -->
                <div class="relative scroll-reveal delay-200">
                    <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-2xl p-8 text-center card-hover">
                        <div class="relative inline-block mb-6">
                            <div class="bg-gradient-to-br from-purple-500 to-purple-600 w-20 h-20 rounded-2xl flex items-center justify-center shadow-xl">
                                <i class="fas fa-star text-white text-3xl"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 bg-white text-purple-600 font-bold text-lg w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                                3
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Acumula Puntos</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Gana puntos por cada kilogramo de residuos reciclados. Mientras más reciclas, más ganas.
                        </p>
                    </div>
                    <div class="hidden lg:block absolute top-1/2 -right-4 transform -translate-y-1/2">
                        <i class="fas fa-arrow-right text-4xl text-purple-300"></i>
                    </div>
                </div>

                <!-- Paso 4 -->
                <div class="scroll-reveal delay-300">
                    <div class="bg-gradient-to-br from-orange-50 to-orange-100 rounded-2xl p-8 text-center card-hover">
                        <div class="relative inline-block mb-6">
                            <div class="bg-gradient-to-br from-orange-500 to-orange-600 w-20 h-20 rounded-2xl flex items-center justify-center shadow-xl">
                                <i class="fas fa-gift text-white text-3xl"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 bg-white text-orange-600 font-bold text-lg w-10 h-10 rounded-full flex items-center justify-center shadow-lg">
                                4
                            </div>
                        </div>
                        <h3 class="text-2xl font-bold text-gray-900 mb-3">Canjea Beneficios</h3>
                        <p class="text-gray-600 leading-relaxed">
                            Usa tus puntos para obtener descuentos, productos y experiencias exclusivas.
                        </p>
                    </div>
                </div>
            </div>

            <!-- CTA -->
            <div class="text-center mt-16 scroll-reveal">
                <a href="{{ route('register') }}" class="inline-flex items-center space-x-3 px-10 py-4 rounded-xl font-bold text-white bg-gradient-to-r from-emerald-600 to-emerald-700 hover:from-emerald-700 hover:to-emerald-800 transition-all shadow-2xl hover:shadow-3xl transform hover:scale-105 btn-primary">
                    <span>Comenzar Ahora</span>
                    <i class="fas fa-rocket"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- Sección Beneficios -->
    <section id="beneficios" class="py-20 lg:py-32 bg-gradient-to-br from-gray-50 to-emerald-50">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            <!-- Header -->
            <div class="text-center mb-16 scroll-reveal">
                <div class="inline-flex items-center space-x-2 bg-emerald-100 text-emerald-700 px-4 py-2 rounded-full mb-4">
                    <i class="fas fa-trophy"></i>
                    <span class="text-sm font-semibold">Recompensas</span>
                </div>
                <h2 class="text-4xl lg:text-5xl font-extrabold text-gray-900 mb-6">
                    Beneficios Increíbles
                </h2>
                <p class="text-xl text-gray-600 max-w-3xl mx-auto">
                    Cada acción cuenta. Disfruta de recompensas mientras cuidas el planeta
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-12 items-center">
                <!-- Columna izquierda - Beneficios -->
                <div class="space-y-6 scroll-reveal">
                    <!-- Beneficio 1 -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl card-hover flex items-start space-x-4">
                        <div class="bg-gradient-to-br from-emerald-500 to-emerald-600 w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-coins text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Sistema de Puntos</h3>
                            <p class="text-gray-600">
                                Gana hasta 100 puntos por kg según el tipo de residuo. Los puntos nunca expiran.
                            </p>
                        </div>
                    </div>

                    <!-- Beneficio 2 -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl card-hover flex items-start space-x-4">
                        <div class="bg-gradient-to-br from-blue-500 to-blue-600 w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-leaf text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Impacto Ambiental</h3>
                            <p class="text-gray-600">
                                Mira en tiempo real cuánto CO₂ has ayudado a reducir y árboles que has salvado.
                            </p>
                        </div>
                    </div>

                    <!-- Beneficio 3 -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl card-hover flex items-start space-x-4">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-percentage text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Descuentos Exclusivos</h3>
                            <p class="text-gray-600">
                                Canjea puntos por descuentos en comercios aliados, productos ecológicos y más.
                            </p>
                        </div>
                    </div>

                    <!-- Beneficio 4 -->
                    <div class="bg-white rounded-2xl p-6 shadow-xl card-hover flex items-start space-x-4">
                        <div class="bg-gradient-to-br from-orange-500 to-orange-600 w-14 h-14 rounded-xl flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-users text-white text-2xl"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900 mb-2">Comunidad Activa</h3>
                            <p class="text-gray-600">
                                Únete a una comunidad comprometida con el medio ambiente y participa en eventos.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Columna derecha - Estadísticas e Imagen -->
                <div class="scroll-reveal delay-200">
                    <!-- Tarjeta de estadísticas -->
                    <div class="bg-white rounded-3xl p-8 shadow-2xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Nuestro Impacto</h3>
                        
                        <div class="space-y-6">
                            <!-- Estadística 1 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-emerald-100 p-3 rounded-lg">
                                        <i class="fas fa-recycle text-emerald-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-600">Toneladas Recicladas</div>
                                        <div class="text-3xl font-bold stat-number">50+</div>
                                    </div>
                                </div>
                                <div class="text-emerald-600 font-semibold">↑ 23%</div>
                            </div>

                            <!-- Estadística 2 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-blue-100 p-3 rounded-lg">
                                        <i class="fas fa-tree text-blue-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-600">Árboles Salvados</div>
                                        <div class="text-3xl font-bold stat-number">1,200+</div>
                                    </div>
                                </div>
                                <div class="text-emerald-600 font-semibold">↑ 45%</div>
                            </div>

                            <!-- Estadística 3 -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-3">
                                    <div class="bg-purple-100 p-3 rounded-lg">
                                        <i class="fas fa-smog text-purple-600 text-xl"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-600">CO₂ Reducido (kg)</div>
                                        <div class="text-3xl font-bold stat-number">85K+</div>
                                    </div>
                                </div>
                                <div class="text-emerald-600 font-semibold">↑ 67%</div>
                            </div>
                        </div>

                        <!-- Imagen decorativa -->
                        <div class="mt-8 relative">
                            <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?q=80&w=2940&auto=format&fit=crop" 
                                 alt="Impacto ambiental" 
                                 class="rounded-2xl w-full h-64 object-cover">
                            <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/50 to-transparent rounded-2xl"></div>
                            <div class="absolute bottom-4 left-4 right-4 text-white">
                                <div class="text-sm font-semibold mb-1">Juntos hacemos la diferencia</div>
                                <div class="text-2xl font-bold">+5,000 familias activas</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Sección CTA Final -->
    <section class="py-20 lg:py-32 bg-gradient-to-r from-emerald-600 to-emerald-700 relative overflow-hidden">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute top-10 left-10 w-64 h-64 bg-white rounded-full blur-3xl"></div>
            <div class="absolute bottom-10 right-10 w-96 h-96 bg-white rounded-full blur-3xl"></div>
        </div>
        
        <div class="relative max-w-7xl mx-auto px-6 lg:px-8 text-center">
            <div class="scroll-reveal">
                <h2 class="text-4xl lg:text-5xl font-extrabold text-white mb-6">
                    ¿Listo para Hacer la Diferencia?
                </h2>
                <p class="text-xl text-white/90 mb-10 max-w-2xl mx-auto">
                    Únete a miles de personas que ya están contribuyendo a un planeta más limpio y ganando recompensas
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}" class="inline-flex items-center justify-center space-x-3 px-10 py-4 rounded-xl font-bold text-emerald-700 bg-white hover:bg-gray-50 transition-all shadow-2xl hover:shadow-3xl transform hover:scale-105">
                        <span>Registrarse Gratis</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="#servicios" class="inline-flex items-center justify-center space-x-3 px-10 py-4 rounded-xl font-bold text-white border-2 border-white/50 hover:bg-white/10 backdrop-blur-sm transition-all">
                        <span>Ver Más Información</span>
                        <i class="fas fa-info-circle"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300">
        <div class="max-w-7xl mx-auto px-6 lg:px-8 py-12">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- Logo y descripción -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="bg-gradient-to-br from-emerald-600 to-emerald-700 p-2 rounded-xl">
                            <i class="fas fa-leaf text-white text-2xl"></i>
                        </div>
                        <span class="font-bold text-2xl text-white">EcoResiduos</span>
                    </div>
                    <p class="text-gray-400 mb-6 max-w-md">
                        Transformamos la manera en que gestionas tus residuos. Juntos construimos un futuro más sostenible.
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="bg-gray-800 hover:bg-emerald-600 w-10 h-10 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-emerald-600 w-10 h-10 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-emerald-600 w-10 h-10 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="bg-gray-800 hover:bg-emerald-600 w-10 h-10 rounded-lg flex items-center justify-center transition-colors">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Enlaces rápidos -->
                <div>
                    <h4 class="text-white font-bold mb-4">Enlaces Rápidos</h4>
                    <ul class="space-y-2">
                        <li><a href="#servicios" class="hover:text-emerald-500 transition-colors">Servicios</a></li>
                        <li><a href="#como-funciona" class="hover:text-emerald-500 transition-colors">¿Cómo Funciona?</a></li>
                        <li><a href="#beneficios" class="hover:text-emerald-500 transition-colors">Beneficios</a></li>
                        <li><a href="{{ route('register') }}" class="hover:text-emerald-500 transition-colors">Registrarse</a></li>
                    </ul>
                </div>

                <!-- Contacto -->
                <div>
                    <h4 class="text-white font-bold mb-4">Contacto</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-phone text-emerald-500"></i>
                            <span>+1 (555) 123-4567</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-emerald-500"></i>
                            <span>info@ecoresiduos.com</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-map-marker-alt text-emerald-500"></i>
                            <span>Calle Principal #123</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Copyright -->
            <div class="border-t border-gray-800 mt-12 pt-8 text-center text-gray-500">
                <p>&copy; {{ date('Y') }} EcoResiduos. Todos los derechos reservados. Hecho con <i class="fas fa-heart text-emerald-500"></i> para el planeta.</p>
            </div>
        </div>
    </footer>

    <!-- Botón Scroll to Top -->
    <button id="scrollTopBtn" class="fixed bottom-8 right-8 bg-gradient-to-r from-emerald-600 to-emerald-700 text-white w-12 h-12 rounded-full shadow-2xl hover:shadow-3xl transition-all opacity-0 pointer-events-none flex items-center justify-center z-40">
        <i class="fas fa-arrow-up"></i>
    </button>

    <!-- Scripts -->
    <script>
        // Mobile Menu Toggle
        const mobileMenuBtn = document.getElementById('mobile-menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        
        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }

        // Scroll Reveal Animation
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -100px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('revealed');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.scroll-reveal').forEach(el => {
            observer.observe(el);
        });

        // Scroll to Top Button
        const scrollTopBtn = document.getElementById('scrollTopBtn');
        
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 300) {
                scrollTopBtn.classList.remove('opacity-0', 'pointer-events-none');
                scrollTopBtn.classList.add('opacity-100');
            } else {
                scrollTopBtn.classList.add('opacity-0', 'pointer-events-none');
                scrollTopBtn.classList.remove('opacity-100');
            }
        });

        scrollTopBtn.addEventListener('click', () => {
            window.scrollTo({
                top: 0,
                behavior: 'smooth'
            });
        });

        // Smooth Scroll for Anchor Links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href !== '#' && href !== '') {
                    e.preventDefault();
                    const target = document.querySelector(href);
                    if (target) {
                        target.scrollIntoView({
                            behavior: 'smooth',
                            block: 'start'
                        });
                        // Cerrar menú móvil si está abierto
                        if (mobileMenu && !mobileMenu.classList.contains('hidden')) {
                            mobileMenu.classList.add('hidden');
                        }
                    }
                }
            });
        });

        // Navbar background on scroll
        const navbar = document.querySelector('nav');
        window.addEventListener('scroll', () => {
            if (window.pageYOffset > 50) {
                navbar.classList.add('shadow-lg');
            } else {
                navbar.classList.remove('shadow-lg');
            }
        });
    </script>
</body>
</html>


# EcoResiduos - Sistema de Gestión de Residuos

Sistema integral para la gestión de recolección de residuos sólidos con sistema de puntos y canjes.

## 📋 Descripción del Proyecto

EcoResiduos es una plataforma web desarrollada en Laravel que permite gestionar la recolección de residuos orgánicos, inorgánicos y peligrosos. El sistema incluye un programa de incentivos mediante puntos que los usuarios pueden canjear por descuentos en tiendas asociadas.

## 🎯 Características Principales

### Módulos Implementados

#### FASE 1 - Funcionalidades Básicas ✅
- Sistema de notificaciones por email
- Gestión de localidades y rutas
- Middleware de seguridad
- Autenticación y autorización con roles

#### FASE 2 - Recolecciones y Validaciones ✅
- **Recolecciones de Orgánicos**: Programación automática según rutas
- **Recolecciones de Inorgánicos**: Programadas y por demanda
- **Recolecciones de Peligrosos**: Sistema de solicitudes con aprobación administrativa
- Validaciones de negocio robustas
- Sistema de puntos mejorado

#### FASE 3 - Mejoras y Refactorización ✅
- **Módulo de Canjes**: Sistema completo de canjes de puntos por descuentos
- **Reportes Administrativos**: Reportes avanzados con exportación PDF/CSV
- **Service Layer**: Lógica de negocio centralizada
- **Repository Pattern**: Acceso a datos optimizado
- **Strategy Pattern**: Cálculo de puntos configurable

## 🛠️ Requisitos del Sistema

- PHP >= 8.1
- Composer
- MySQL/MariaDB >= 5.7
- Node.js >= 16.x (para assets)
- Extensiones PHP requeridas:
  - OpenSSL
  - PDO
  - Mbstring
  - Tokenizer
  - XML
  - Ctype
  - JSON
  - BCMath

## 📦 Instalación

### 1. Clonar el Repositorio

```bash
git clone https://github.com/tu-usuario/EcoResiduosMaster.git
cd EcoResiduosMaster
```

### 2. Instalar Dependencias

```bash
composer install
npm install
```

### 3. Configurar Variables de Entorno

```bash
cp .env.example .env
php artisan key:generate
```

Editar `.env` con tus configuraciones:

```env
# Base de datos
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ecoresiduos
DB_USERNAME=root
DB_PASSWORD=

# Email (configurar según tu proveedor)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=tu-email@gmail.com
MAIL_PASSWORD=tu-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=tu-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

# Configuración de Puntos
PUNTOS_ESTRATEGIA=simple
PUNTOS_MULTIPLICADOR=1.0
PUNTOS_BONUS=0
PUNTOS_MINIMO=1
```

### 4. Ejecutar Migraciones y Seeders

```bash
php artisan migrate
php artisan db:seed
```

### 5. Compilar Assets

```bash
npm run dev
# o para producción
npm run build
```

### 6. Iniciar Servidor de Desarrollo

```bash
php artisan serve
```

Acceder a: `http://localhost:8000`

## 🗂️ Estructura del Proyecto

```
EcoResiduosMaster/
├── app/
│   ├── Contracts/              # Interfaces (Strategy Pattern)
│   │   └── PuntosCalculatorInterface.php
│   ├── Http/
│   │   ├── Controllers/        # Controladores
│   │   ├── Middleware/         # Middleware personalizado
│   │   └── Requests/           # Form Requests (validaciones)
│   ├── Mail/                   # Clases de email
│   ├── Models/                 # Modelos Eloquent
│   ├── Repositories/           # Repository Pattern
│   │   ├── CanjeRepository.php
│   │   ├── PuntoRepository.php
│   │   └── RecoleccionRepository.php
│   └── Services/               # Service Layer
│       ├── CanjeService.php
│       ├── NotificacionService.php
│       ├── PuntosService.php
│       ├── RecoleccionService.php
│       └── PuntosCalculators/  # Estrategias de cálculo
│           ├── SimplePuntosCalculator.php
│           └── ConfigurablePuntosCalculator.php
├── config/
│   └── puntos.php              # Configuración de puntos
├── database/
│   ├── migrations/             # Migraciones de BD
│   └── seeders/                # Seeders
├── resources/
│   └── views/                  # Vistas Blade
└── routes/
    └── web.php                 # Rutas web
```

## 🎨 Patrones de Diseño Implementados

### 1. Service Layer
Centraliza la lógica de negocio fuera de los controladores:
- `RecoleccionService`: Gestión de recolecciones
- `CanjeService`: Procesamiento de canjes
- `NotificacionService`: Envío de notificaciones
- `PuntosService`: Gestión de puntos

### 2. Repository Pattern
Abstrae el acceso a datos:
- `RecoleccionRepository`: Queries de recolecciones
- `PuntoRepository`: Queries de puntos
- `CanjeRepository`: Queries de canjes

### 3. Strategy Pattern
Permite cambiar algoritmos de cálculo de puntos:
- `SimplePuntosCalculator`: 1 kg = 1 punto
- `ConfigurablePuntosCalculator`: Fórmula configurable

## 🔧 Comandos Artisan Disponibles

```bash
# Ejecutar migraciones
php artisan migrate

# Revertir última migración
php artisan migrate:rollback

# Refrescar base de datos
php artisan migrate:fresh --seed

# Limpiar caché
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Generar autoload
composer dump-autoload
```

## 📊 Módulos del Sistema

### Gestión de Usuarios
- Registro y autenticación
- Roles: Administrador, Usuario, Empresa
- Permisos granulares con Spatie Permission

### Gestión de Recolecciones
- **Orgánicos**: Programación automática según rutas
- **Inorgánicos**: Programadas o por demanda
- **Peligrosos**: Solicitudes con aprobación

### Sistema de Puntos
- Asignación automática al completar recolecciones
- Estrategias de cálculo configurables
- Historial de puntos ganados

### Módulo de Canjes
- Catálogo de tiendas asociadas
- Canje de puntos por descuentos
- Códigos únicos de canje
- Historial de canjes

### Reportes Administrativos
- Reportes por localidad
- Reportes por empresa
- Exportación a PDF
- Exportación a CSV
- Filtros por fecha y tipo de residuo

## 🔐 Seguridad

- Autenticación con Laravel Sanctum
- Autorización basada en roles y permisos
- Validación de datos en Form Requests
- Protección CSRF
- Sanitización de inputs
- Middleware de seguridad personalizado

## 📧 Sistema de Notificaciones

El sistema envía notificaciones por email para:
- Confirmación de recolección programada
- Recordatorio de recolección (día anterior)
- Notificación de recolección completada
- Solicitud de recolección recibida
- Canje realizado exitosamente

## 🧪 Testing

```bash
# Ejecutar tests
php artisan test

# Con cobertura
php artisan test --coverage
```

## 📝 Configuración de Puntos

Editar `config/puntos.php` o variables de entorno:

```php
// Estrategia: 'simple' o 'configurable'
'estrategia' => env('PUNTOS_ESTRATEGIA', 'simple'),

// Para estrategia configurable
'multiplicador' => env('PUNTOS_MULTIPLICADOR', 1.0),
'bonus' => env('PUNTOS_BONUS', 0),
'minimo_por_recoleccion' => env('PUNTOS_MINIMO', 1),
```

### Ejemplo de Uso

```php
// En un controlador o servicio
$puntosService = app(PuntosService::class);

// Cambiar estrategia dinámicamente
$puntosService->cambiarEstrategia('configurable');

// Calcular puntos
$puntos = $puntosService->calcularPuntos($pesoKg);

// Asignar puntos a usuario
$puntosService->asignarPuntos($userId, $pesoKg);
```

## 🚀 Despliegue en Producción

### 1. Optimizaciones

```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run build
```

### 2. Configurar Servidor Web

Apuntar el document root a `/public`

### 3. Configurar Permisos

```bash
chmod -R 755 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 4. Configurar Cron Jobs

```bash
* * * * * cd /path-to-project && php artisan schedule:run >> /dev/null 2>&1
```

## 🤝 Contribución

1. Fork el proyecto
2. Crear rama feature (`git checkout -b feature/AmazingFeature`)
3. Commit cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abrir Pull Request

## 📄 Licencia

Este proyecto es privado y confidencial.

## 👥 Equipo de Desarrollo

- Desarrollador Principal: [Tu Nombre]
- Arquitecto de Software: [Nombre]

## 📞 Soporte

Para soporte técnico, contactar a: soporte@ecoresiduos.com

## 🔄 Changelog

### Versión 3.0.0 (FASE 3)
- ✅ Módulo completo de canjes
- ✅ Reportes administrativos avanzados
- ✅ Service Layer implementado
- ✅ Repository Pattern implementado
- ✅ Strategy Pattern para puntos
- ✅ Documentación completa

### Versión 2.0.0 (FASE 2)
- ✅ Módulo de recolecciones orgánicos
- ✅ Módulo de recolecciones inorgánicos
- ✅ Módulo de recolecciones peligrosos
- ✅ Validaciones de negocio
- ✅ Sistema de puntos mejorado

### Versión 1.0.0 (FASE 1)
- ✅ Sistema de notificaciones
- ✅ Gestión de localidades y rutas
- ✅ Middleware de seguridad
- ✅ Autenticación y autorización

## 🔗 Enlaces Útiles

- [Documentación de Laravel](https://laravel.com/docs)
- [Documentación de Arquitectura](ARQUITECTURA.md)
- [Resumen de Cambios Fase 3](FASE3_RESUMEN_CAMBIOS.md)

1. Resumen / Objetivos (por si alguien viene a preguntar qué hacemos)

Implementar una app web para gestión de recolección de residuos (orgánicos, inorgánicos reciclables, peligrosos), registro de recolecciones, pesadas, puntos, canje y reportes. Requerimientos clave: recolecciones semanales/mensuales según tipo, notificaciones WhatsApp (registro, día anterior y día de recolección), registro de kilos y reportes por usuario/empresa/localidad. 

Proyecto-2-2025.

2. Stack tecnológico recomendado

Backend: Laravel 10+ (PHP 8.1+).

Frontend plantilla: AdminLTE (integrada como layout Blade).

Autenticación: Laravel Breeze (o Fortify) + Laravel Sanctum si necesitas API móvil.

Colas & Jobs: Redis + Laravel Queue.

Base de datos: MySQL / MariaDB.

Storage: S3-compatible (o disco local para prototipo).

Notificaciones WhatsApp: WhatsApp Business API o Twilio WhatsApp (adaptar según disponibilidad).

Exportes/Reportes: Laravel-Excel (CSV/XLSX) y Dompdf / Snappy (PDF).

Tests: PHPUnit + Pest (opcional).

CI/CD: GitHub Actions / GitLab CI para pipelines (migrations, tests, deploy).

3. Principios y reglas de diseño (no negociables)

Arquitectura en capas: Controllers → Services (o Actions) → Repositories → Models. Controllers ANCHA sólo para validar y orquestar, la lógica va en Services.

SRP y pequeñas clases: cada Service/Repository debe tener responsabilidad única.

DTOs/Value Objects para datos complejos (e.g., Resultado de pesaje, Fórmula de puntos).

Eventos + Listeners para flujos transversales (ej. CollectionRegistered → SendWhatsAppNotification, AwardPoints).

Uso de Jobs para envío de mensajes, generación de reportes y tareas que puedan fallar: encolados y reintentos.

Config dinámica: factores como la fórmula de puntos, días de recolección y horarios deben guardarse en una tabla settings editable por Admin. NO hardcodear.

RBAC: Roles y permisos (Administrador, Usuario, EmpresaRecolectora, Auditor). Implementar con spatie/laravel-permission.

APIs versionadas: /api/v1/... si hay integraciones móviles o bots.

Auditoría: guardar registro de cambios (who/when/what) para recolecciones y pesadas.

Seguridad: validations, rate limiting, CSP headers, escaping en views, protección CSRF y sanitización de inputs.

4. Estructura de proyecto (carpetería sugerida)
app/
  Http/
    Controllers/
      Api/
      Web/
  Actions/                # lógica por caso de uso (opcional)
  Services/
  Repositories/
  Notifications/
  Events/
  Listeners/
  Jobs/
  Policies/
  Models/
database/
  migrations/
  seeders/
resources/
  views/
    layouts/
      adminlte.blade.php
    components/
  js/
routes/
  web.php
  api.php
config/
  points.php              # fórmula por defecto (editable desde DB)

5. Modelo de datos principal (tablas clave y campos sugeridos)

Nota: campos created_at, updated_at y deleted_at (soft deletes) se omiten para brevedad.

users

id, nombre, email, password, telefono, localidad_id, rol_id, verified_at

roles (si no usas paquete externo)

id, name, description

companies (empresas recolectoras)

id, nombre, tipo_residuos (enum/array), contacto

subscriptions (si aplica suscripción del usuario)

id, user_id, plan, status

collections (solicitudes / recolecciones)

id, user_id, company_id, tipo_residuo (FO/FV/INORGANICO/PELIGROSO), programada (bool), fecha_programada, turno_num, peso_kg, estado (pendiente, programada, realizada, cancelada), notas

collection_items (detalles si se requiere)

id, collection_id, item_type, peso

points_balance

id, user_id, puntos_acumulados, puntos_usados

points_transactions

id, user_id, collection_id, puntos, motivo

reports (registro de exportes)

id, usuario_id, tipo, filtros, archivo_path

settings

id, key, value, description (usar JSON cuando necesario)

notifications_log

id, user_id, channel, payload, status, sent_at, error

localities

id, nombre, codigo_ruta

6. Migraciones / índices y tipos clave

Index: collections(user_id), collections(fecha_programada), collections(tipo_residuo).

Constraint: collections.peso_kg DECIMAL(8,2).

Enum o lookup para tipo_residuo y estado.

settings con key UNIQUE.

7. Rutas esenciales (web + api)

Web (AdminLTE)

GET /admin/dashboard

GET /admin/collections (filtros por fecha/tipo/localidad)

GET /admin/users

GET /admin/companies

GET /admin/settings

POST /admin/collections/{id}/mark-completed

API

POST /api/v1/collections — crear solicitud de recolección.

GET /api/v1/users/{id}/collections — historial del usuario.

POST /api/v1/collections/{id}/weigh — registrar peso (solo recolector).

POST /api/v1/notifications/whatsapp/webhook — webhook entrante (si aplica).

8. Flujos clave y eventos (pseudodiagrama)

Usuario solicita recolección → Controller valida → Service crea Collection + dispara CollectionRegistered event.

Listener SendWhatsAppNotification encola Job SendWhatsAppMessage(jobPayload).

Día anterior: Scheduler ejecuta job que consulta collections programadas y encola recordatorios.

Recolector pesa material → API weigh actualiza peso_kg y dispara CollectionWeighed → Listener AwardPointsIfEligible calcula puntos → escribe transacción en points_transactions.

9. Lógica de puntos (reglas)

La fórmula debe ser configurable (tabla settings). Ejemplo por defecto: puntos = floor(kilos * factor_localidad * calidad) donde factor_localidad y calidad (booleano) son parámetros. Guardar fórmula como expresión segura o implementar distintas funciones en código y sólo seleccionar la activa desde settings.

Reglas: Sólo se otorgarán puntos si la recolección está marcada como realizada y la recolección cumple criterios de separación (flag aprobado_separacion por parte del recolector).

Registrar transacción atómica con la colección (DB transaction).

10. Notificaciones WhatsApp (reglas y diseño)

Eventos que requieren WhatsApp: (1) Confirmación al registrar recolección, (2) Recordatorio día anterior, (3) Notificación día de recolección con turno_num. 

Proyecto-2-2025.

Implementar adaptador de notificación (strategy): WhatsAppProviderInterface con implementaciones TwilioWhatsAppProvider, MetaBusinessApiProvider. Configurar provider en .env.

Mensajes deben ser templates (multi-idioma en DB). Guardar plantillas en notifications_templates.

Enviar desde Job con reintentos y persistir resultado en notifications_log.

Fallback: si WhatsApp falla, loguear y enviar e-mail (si aplica). No bloquear flujo principal por fallas en mensajería.

11. AdminLTE — reglas de UI / UX

Layout principal: barra lateral (sidenav), header con usuario, breadcrumbs.

Componentes reutilizables: Cards, Tables (server-side pagination), Modals, Alerts.

Tablas grandes: usar server-side processing (DataTables o custom) con filtros por fecha/tipo/localidad.

Formularios: client-side validation + server-side validation (rules en FormRequest). Mostrar errores inline.

Mockups y rutas de navegación obligatorias: Dashboard (KPIs: total recolecciones, kilos por tipo, puntos totales), Users, Companies, Collections, Reports, Settings.

Accesibilidad: labels, roles ARIA en formularios.

Resposive: AdminLTE ya lo provee; validar en móvil.

12. Reporting y exportes

Reportes por usuario / por empresa / por localidad con filtros de fecha.

Exportes: CSV/XLSX (Laravel-Excel) y PDF (Dompdf).

Generación en background: exportar en Job, almacenar archivo en storage y notificar al usuario por email/WhatsApp cuando esté listo.

Paginación y límites: no cargar todo en memoria; usar chunking para exports grandes.

13. Scheduler & Cron (reglas)

Configurar cron: * * * * * php /path/artisan schedule:run

Tareas programadas:

daily:send-previous-day-reminders → consulta collections cuya fecha_programada = tomorrow → encola notificaciones.

daily:send-day-reminders → collections con fecha_programada = today y hora >= ahora → encola notificaciones.

monthly:handle-hazardous-collections → programar según reglas (1 vez al mes).

Registrar ejecución y errores.

14. Seguridad, validaciones y permisos

Validar teléfono con regex y normalizar (E.164) para WhatsApp.

Passwords: Bcrypt/Argon2. Mail verification obligatorio para funcionalidades sensibles.

Rate-limit endpoints públicos (throttle middleware).

Policies para recursos: CollectionPolicy (who can view/edit), UserPolicy.

Sanitizar HTML e inputs. Escapar en Blade ({{ }}) por defecto.

15. Tests mínimos obligatorios

Unit: Cálculo de puntos, repositorios.

Feature: Crear recolección, marcar como realizada, registrar peso, flujo de notificación encolada.

Integration: Seeder + migración + endpoints clave.

CI: ejecutar tests en cada PR.

16. Desarrollo local y despliegue (reglas)

Entorno .env.example con variables necesarias: DB, REDIS, QUEUE_CONNECTION, WHATSAPP_PROVIDER, TWILIO_* / META_*.

Usar Docker para reproducibilidad (servicio DB, Redis, queue worker).

En producción: configurar supervisor para workers, certs TLS, backup de DB y policy para env vars.

Deploy: migrations con php artisan migrate --force, después php artisan config:cache y php artisan route:cache.

17. Consideraciones de internacionalización y formato de fechas

Guardar todo en UTC en DB; mostrar en zona local del usuario (localidad).

Soporte multi-idioma si se espera expansión.

18. Observadores y patrones (por qué)

Observer en Collection::created para actividades simples.

Repository pattern para desacoplar ORM y facilitar pruebas.

Service pattern para orquestar procesos (ej. CollectionService::register() que llama repo, dispara evento).

Factory/Seeder para datos iniciales (roles, tipos de residuo, plantillas de mensajes).

19. Reglas de codificación y control de versiones

PSR-12, nombres en inglés para código (models y columnas en español si el dominio lo exige — coherencia).

Branching: main (producción), develop, feature branches feat/.... PR con revisión y tests.

Commits claros: feat(collection): add weigh endpoint.

20. Checklist mínimo antes de entregar el prototipo (sí/no rápido)

 Registro de usuarios funciona.

 Crear recolección (programada y por demanda) funciona.

 Registrar peso por recolector.

 Puntos calculados y registrados.

 Notificaciones WhatsApp encoladas (al menos envíos de prueba OK).

 Reporte por usuario exportable.

 Roles/Permisos básicos y AdminLTE integrado.

 Tests básicos verdes.

 Cron configurado y jobs funcionando.

21. Entregables técnicos sugeridos para la entrega del curso

Documento de diseño (este + DB schema + diagramas UML exportados).

Repositorio con commits ordenados y README con setup (Docker).

Seeders para roles, tipos de residuos y cuentas de prueba.

Video demostración (máx 10 min) recorriendo: registro, creación de recolección, pesaje y reporte. 

Proyecto-2-2025.

22. Tiempo y esfuerzo (estimación de trabajo en equipo)

(Lo pongo breve para que no haya duda): con 3 devs (frontend/backend/devops) y usando Laravel y AdminLTE, primer prototipo mínimo viable (registro + recolecciones + pesadas + reportes básicos + notificación de prueba) ≈ 6–8 semanas. (Esto es orientativo — ajusta según disponibilidad.)
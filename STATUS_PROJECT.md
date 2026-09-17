# Estado General del Proyecto — LMS Escuela Jurídica SJI Soluciones

**Fecha de corte:** Septiembre 2026  
**Entorno actual:** Desarrollo local / Staging  
**Plataforma:** LMS para formación jurídica y educación continua en vivo  
**Empresa:** Soluciones Jurídicas e Inmobiliarias de Colombia S.A.S. (**SJI Colombia**)  

---

## 1. Resumen Ejecutivo y Arquitectura

El proyecto consiste en una plataforma de educación continua (LMS) orientada a profesionales del derecho, administradores inmobiliarios y público especializado en Colombia. Está concebida como un monolito modular de alto rendimiento bajo el stack **Laravel 11 + Filament v3 + Tailwind CSS + Alpine.js**, optimizado para bajos costos de infraestructura en VPS, máxima velocidad de carga y cumplimiento normativo colombiano (Habeas Data y pasarela nacional de pagos).

```mermaid
graph TD
    User[Visitante / Estudiante / Docente] -->|HTTPS| Web[Catálogo Público & Aula Virtual (Blade + Alpine)]
    User -->|Checkout PSE/Nequi/Tarjetas| Bold[Pasarela Bold.co Colombia]
    Bold -->|Webhook Firmado| Webhook[WebhookController Idempotente]
    Webhook -->|Activa Matrícula| Queue[Laravel Queues / Workers]
    Queue -->|Email Transaccional| Mailer[EnrollmentConfirmedMail]
    Queue -->|Genera Diploma Oficial| CertGen[DomPDF + QR Engine]

    Admin[Administración SJI] -->|Autenticación| Filament[Panel Administrativo Filament v3]
    Filament -->|Gestión Total| DB[(SQLite Local / MySQL 8 Prod)]
    
    Verif[Público / Empleadores] -->|Escaneo QR o URL| VerifPage[Verificación Pública /verificar]
    VerifPage -->|Consulta Código| CertGen
```

---

## 2. Lo que Hemos Hecho (Módulos Completados)

### ✅ Sprint 1: Fundación del Sistema y Panel Administrativo
- **Arquitectura de Base de Datos Relacional:** Modelos Eloquent completos con relaciones y casts para `User`, `Course`, `CourseSession`, `Enrollment`, `Payment`, `CourseMaterial` y `Certificate`.
- **Panel Administrativo (Filament PHP v3):**
  - `UserResource`: Gestión de usuarios, asignación de roles (`admin`, `teacher`, `student`) y documentos colombianos (`CC`, `CE`, `PASAPORTE`, `NIT`).
  - `CourseResource`: Control integral de catálogo, precios en COP, intensidades horarias, cupos, temarios y estados (`draft`, `published`, `in_progress`, `finished`, `archived`).
  - `CourseSessionResource`: Programación de sesiones en vivo, fechas, horas y URLs de Google Meet / Zoom.
  - `EnrollmentResource`: Monitoreo de matrículas, estados (`pending`, `confirmed`, `cancelled`, `completed`), indicadores de certificado y botones de emisión individual/masiva.
  - `PaymentResource`: Auditoría de pagos, método (`PSE`, `NEQUI`, `CARD`), referencias e historial de transacciones.
  - `CourseMaterialResource`: Repositorio documental asociado a cursos o sesiones específicas.
  - `CertificateResource`: Panel de diplomas con códigos únicos, regeneración individual y en lote, y descarga directa.

### ✅ Sprint 2: Catálogo Público, Autenticación y Checkout con Pasarela
- **Landing y Catálogo Editorial:**
  - Página de inicio (`/`) con cursos destacados, propuesta de valor y enlaces rápidos.
  - Catálogo completo (`/cursos`) con fichas técnicas, intensidades horarias, perfil docente y temario desglosado.
  - Botón flotante persistente de WhatsApp corporativo para asesoría comercial y soporte.
- **Autenticación con Identificación Nacional:**
  - Registro de alumnos adaptado al marco colombiano: selección de tipo de documento (`CC`, `CE`, `NIT`, etc.), número de identificación, número móvil / WhatsApp y ciudad.
  - Inicio de sesión por correo electrónico o por documento de identidad.
- **Flujo de Pago y Matrícula Automatizada:**
  - Arquitectura modular de pasarelas (`PaymentManager` y `PaymentGatewayInterface`).
  - Driver funcional de **Bold.co** adaptado a montos en centavos y firmado criptográfico.
  - `WebhookController` con procesamiento idempotente: validación de firmas, actualización automática de matrícula a `confirmed`/`active` y registro contable en `payments`.
  - Correo transaccional de bienvenida y confirmación (`EnrollmentConfirmedMail`) con diseño institucional HTML.

### ✅ Sprint 3: Aula Virtual, Portal del Alumno y Control Docente
- **Portal del Estudiante ("Mis Cursos"):**
  - Panel privado (`/mis-cursos`) con estado de matriculación (Activo / Completado) y llamada a la próxima sesión agendada.
  - Acceso dinámico a clases en vivo mediante Google Meet / Zoom, condicionado a estar formalmente matriculado.
  - Aula virtual (`/cursos/{slug}/aula`) con desglose de sesiones, enlaces de videollamada y descarga de material de estudio protegido (`/materiales/{material}/descargar`).
- **Portal del Docente / Panel de Control de Sala:**
  - Vista especializada (`/docente/{slug}/asistencia`) para el profesor titular y administradores.
  - Roster de estudiantes inscritos con documento para verificación y control de ingreso a sala.
  - Subida directa de presentaciones, lecturas y guías en PDF sin necesidad de entrar al panel administrativo general.

### ✅ Sprint 4: Certificación Digital Oficial con Código QR
- **Motor de Certificación (`CertificateService`):**
  - Generación de código institucional alfanumérico único (`SJI-YYYY-XXXXX`).
  - Generación vectorial de código QR institucional (`simplesoftwareio/simple-qrcode`) con nivel de corrección de error alto (`H`).
  - Plantilla PDF en alta fidelidad (`certificates/template.blade.php`) en tamaño A4 apaisado (`landscape`), con tipografía jurídica, bordes ornamentales, firmas institucionales y sellos de autenticidad.
  - Renderizado en servidor mediante `barryvdh/laravel-dompdf` optimizado con tablas de alineación inferior.
- **Protección de Datos Personales (Ley 1581 de 2012 — Habeas Data):**
  - Algoritmo de enmascaramiento de cédula de derecha a izquierda (`CC *.***.***.890`) para evitar sustracción o exposición no consentida de datos del titular.
- **Portal Público de Verificación (`/verificar` y `/verificar/{codigo}`):**
  - Página accesible sin autenticación para validación inmediata por empleadores o autoridades al escanear el QR.
  - Buscador manual de códigos para usuarios que consulten sin escáner de cámara.
  - Descarga pública y directa del documento PDF original certificado.
- **Integración con Alumnos:**
  - Botón de descarga en el aula virtual y en la tarjeta del curso en "Mis Cursos" con generación en tiempo real (*on-the-fly*) si el archivo en disco no estuviera precompilado.
- **Cobertura de Pruebas Automatizadas:**
  - Suite de 12 pruebas unitarias y de integración en `tests/Feature/CertificateTest.php` (100% aprobadas).

---

## 3. Lo que Falta (Pendientes Inmediatos para Salida a Producción)

| Ítem | Descripción | Prioridad | Dependencia |
| :--- | :--- | :---: | :--- |
| **Definición y Contratación de Hosting** | Aprovisionamiento de VPS Linux (Ubuntu 24.04 LTS en Hostinger KVM 2, Hetzner o similar). | **Alta** | Decisión de negocio del cliente |
| **Configuración de Servidor VPS** | Instalación de NGINX, PHP 8.3 FPM, MySQL 8 / MariaDB, Redis, Git y Composer. | **Alta** | VPS activo |
| **Dominio y Certificados SSL** | Apuntar registros DNS de `cursos.sjicolombia.com` (o dominio asignado) y emisión de SSL Let's Encrypt con renovación automática. | **Alta** | Acceso al DNS |
| **Credenciales Bold.co de Producción** | Reemplazar llaves de Sandbox (`apiKey`, `secretKey`) por las credenciales Live del comercio formalmente verificado en Bold. | **Alta** | Cuenta comercial Bold |
| **Servicio de Correo Transaccional** | Configurar servicio SMTP en `.env` (Resend, Amazon SES, Sendgrid o SMTP corporativo) para envío real de credenciales y matrículas. | **Alta** | Proveedor de correo |
| **Supervisor de Colas (Workers)** | Configuración de demonio `supervisord` en el VPS para mantener corriendo `php artisan queue:work` de manera permanente y resiliente. | **Media** | Servidor VPS |
| **Prueba de Compra Real (Smoke Test)** | Transacción real de bajo valor ($1.000 o $5.000 COP) vía PSE/Nequi para comprobar el ciclo completo pasarela ➔ webhook ➔ correo ➔ aula. | **Media** | Bold Producción |

---

## 4. Implementaciones Opcionales e Importantes a Futuro (Roadmap V2 / V3)

A continuación se listan mejoras estratégicas de alto impacto que aumentarán el valor percibido del producto y optimizarán la operación académica:

### 🎓 Nivel Académico y Formativo
1. **Módulo de Evaluaciones y Quizzes:**
   - Cuestionarios al final de cada módulo o al término del programa.
   - Condicionamiento automático de la emisión del certificado a una nota mínima aprobatoria (ej. 80% de aciertos).
2. **Control de Asistencia Digital Automatizado:**
   - Generación de un código PIN o QR temporal proyectado por el docente durante la sesión en vivo para que los alumnos hagan "Check-in" desde su móvil.
   - Validación automática de asistencia mínima (ej. 80% de clases asistidas) antes de expedir el certificado.
3. **Repositorio de Clases Grabadas (Replay On-Demand):**
   - Soporte para incrustar grabaciones de clases pasadas con reproductores seguros (Vimeo OTT, Cloudflare Stream o YouTube Oculto) para alumnos que no pudieron conectarse en directo.

### 💰 Nivel Comercial y Conversión
4. **Cupones de Descuento y Becas:**
   - Sistema de códigos promocionales (`COUPONS`) para convenios empresariales, firmas de abogados, colegios de jueces o preventa temprana (*early-bird*).
5. **Reseñas y Testimonios de Alumnos:**
   - Sistema de calificación (estrellas y comentarios) accesible únicamente por egresados certificados, visible en la página pública del curso para generar prueba social.
6. **WhatsApp Transaccional Automatizado:**
   - Integración con API oficial de WhatsApp (Meta Cloud API) para enviar el enlace de la clase 1 hora y 15 minutos antes de iniciar la sesión directamente al móvil del alumno.

### ⚖️ Nivel Operativo y Legal
7. **Facturación Electrónica DIAN:**
   - Conexión vía API con proveedores de facturación en Colombia (Alegra, Factus o Siigo) para emitir automáticamente la factura electrónica o documento equivalente tras la aprobación del pago en Bold.
8. **Descarga de Certificado de Asistencia para Docentes:**
   - Emisión de constancias de docencia para los profesores titulares con registro de horas dictadas para su hoja de vida académica.

---

## 5. Resumen de Rutas y Endpoints Principales

### Rutas Públicas
- `/`: Portada institucional y cursos destacados.
- `/cursos`: Catálogo completo de programas.
- `/cursos/{slug}`: Ficha detallada de curso y temario.
- `/verificar`: Buscador institucional de certificados.
- `/verificar/{codigo}`: Página de autenticidad del certificado y descarga de copia pública en PDF.
- `/verificar/{codigo}/pdf`: Descarga directa del PDF certificado.

### Rutas de Autenticación
- `/registro`: Formulario con cédula, teléfono y ciudad.
- `/ingresar`: Login por email o por documento de identidad.
- `/salir`: Cierre de sesión seguro.

### Rutas de Estudiante (Requieren Login)
- `/mis-cursos`: Listado de programas inscritos y estado de avance.
- `/cursos/{slug}/aula`: Aula virtual con enlaces a clases y materiales.
- `/mis-cursos/{slug}/certificado`: Descarga oficial del PDF para el estudiante matriculado.
- `/materiales/{material}/descargar`: Descarga de lecturas y diapositivas de clase.

### Rutas del Docente / Coordinación
- `/docente/{slug}/asistencia`: Control de sala y listado de asistentes.
- `/docente/{slug}/materiales`: Subida de material pedagógico.

### Rutas de Pasarela y Webhooks
- `POST /checkout/{course}`: Inicio de sesión de pago con Bold.co.
- `POST /api/webhooks/bold`: Webhook seguro que procesa la confirmación de pago.
- `/pago/resultado`: Pantalla de retorno con resumen de la transacción.

### Panel Administrativo
- `/admin`: Dashboard Filament v3 para gestión global académica, financiera y documental.

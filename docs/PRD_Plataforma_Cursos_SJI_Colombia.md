# PRD — Plataforma de Cursos Jurídicos en Vivo
## SJI Colombia (Soluciones Jurídicas e Inmobiliarias de Colombia S.A.S.)

**Versión:** 1.1  
**Fecha:** Septiembre 2026  
**Elaborado por:** Cristian Ted Borrero Reina (LevelOne Agency)  
**Subdominio propuesto:** `cursos.sjicolombia.com` o `academia.sjicolombia.com` (Desplegado en VPS dedicado)  

---

## 1. Resumen ejecutivo

SJI Colombia es una firma de abogados especializada en derecho inmobiliario y propiedad horizontal, con sede en Santa Marta. Actualmente opera un sitio web informativo (`sjicolombia.com`). SJI desea dictar **cursos y capacitaciones en vivo sobre temas jurídicos e inmobiliarios** dirigidos a administradores de propiedad horizontal, miembros de consejos de administración, copropietarios, estudiantes y abogados.

**Punto clave para el cliente:** Esto no es una simple adición o plugin sobre el sitio actual. Es la construcción de una **aplicación web independiente con lógica de negocio propia** (LMS — Learning Management System): autenticación con roles, catálogo con checkout integrado, gestión de sesiones en vivo, entrega de materiales y expedición de certificados oficiales verificables con código QR.

---

## 2. Problema y oportunidad

- **Autoridad existente:** SJI cuenta con reconocimiento y autoridad en el nicho jurídico e inmobiliario.
- **Fuga operativa:** La gestión manual de inscripciones, cobros y enlaces por canales informales (WhatsApp/Excel) genera fricción, pérdida de pagos y sobrecarga administrativa.
- **Oportunidad:** Consolidar una línea de ingresos recurrente mediante programas de formación continua bajo la marca SJI, con trazabilidad contable y entrega profesional del servicio.
- **Referencia del sector:** Modelos formativos como el del Politécnico de Colombia demuestran el éxito de programas directos, con fichas de curso claras (intensidad horaria, requisitos, temario estructurado) y certificación verificable.

---

## 3. Objetivos del producto

1. Permitir que SJI publique cursos con ficha técnica detallada (temario, fechas, intensidad horaria y cupos).
2. Facilitar la inscripción y el pago directo de alumnos mediante pasarela colombiana (PSE, Nequi, tarjetas).
3. Centralizar el acceso a las clases en vivo y materiales de estudio en un panel de alumno privado.
4. Generar certificados digitales en PDF con código QR y URL de verificación pública institucional.
5. Garantizar estabilidad e independencia operativa alojando la plataforma en un VPS dedicado, aislando completamente el sitio corporativo principal.

### Alcance Fase 1 (MVP)
- Catálogo público de cursos y fichas detalladas de programa.
- Registro, inicio de sesión y panel privado de alumno.
- Cobro en **pago único** mediante integración con pasarela de pagos colombiana (Wompi).
- Botón directo de soporte y cierre comercial vía WhatsApp.
- Enlace seguro a clases en vivo (Zoom / Google Meet) visible solo para alumnos inscritos y confirmados.
- Panel administrativo para creación de cursos, control de inscritos y subida de recursos.
- Emisión automática de certificados en PDF con código alfanumérico y validación web por QR.

### Fuera de alcance (Fase 1)
- Pago fraccionado o suscripción recurrente en cuotas (diferido a Fase 2 para validar tracción).
- Aplicación móvil nativa (se implementa interfaz web responsive mobile-first).
- Sistema de streaming embebido propio (se delega en Zoom/Meet).
- Marketplace para instructores externos ajenos a SJI.
- Evaluaciones o quizes complejos con calificación automatizada.

---

## 4. Usuarios y roles

| Rol | Descripción | Permisos clave |
|---|---|---|
| **Administrador (SJI)** | Gestión global del negocio | Crear/editar cursos, consultar estados de pago, gestionar inscritos, emitir reportes y configurar certificados. |
| **Profesor / Abogado** | Encargado docente | Consultar calendario de clases, acceder a la lista de admitidos para control de sala, subir presentaciones y lecturas. |
| **Alumno** | Estudiante registrado | Adquirir cursos, consultar accesos a sesiones en vivo, descargar lecturas y generar su certificado oficial. |
| **Visitante** | Público general | Consultar oferta académica, temarios, precios y canal de atención vía WhatsApp. |

---

## 5. Requerimientos funcionales

### 5.1 Catálogo y Ficha de Curso
- Listado público de cursos activos con filtros por temática y fecha de inicio.
- Ficha de curso detallada:
  - Título, descripción y temario dividido por módulos o sesiones.
  - Intensidad horaria estimada (ej. "20 horas académicas").
  - Modalidad ("Clases en vivo vía Streaming").
  - Perfil del docente / abogado a cargo.
  - Perfil de ingreso ("Dirigido a administradores, consejeros, propietarios").
  - Precio en COP y botón de inscripción inmediata.
  - Botón flotante persistente de consulta vía WhatsApp.

### 5.2 Registro y Checkout
- Captura de datos requeridos para facturación y titulación colombiana:
  - Nombres y apellidos completos.
  - Tipo y número de identificación (Cédula de Ciudadanía, Cédula de Extranjería, Pasaporte).
  - Correo electrónico.
  - Número de celular (WhatsApp).
  - Ciudad / Municipio.
- Integración con pasarela Wompi en modalidad de pago único (PSE, Nequi, tarjetas de crédito/débito y Bancolombia).
- Webhook de confirmación de pago: cambio de estado de la orden a `aprobado` y alta inmediata de la matrícula sin intervención manual.

### 5.3 Aula y Clases en Vivo
- Acceso condicional: El botón o enlace a la sala de Zoom/Google Meet solo se habilita en el panel del alumno con pago confirmado.
- Prevención de acceso indebido: El panel del profesor proporciona la lista oficial de admitidos (nombre y cédula) para control de acceso mediante sala de espera en Zoom/Meet.
- Repositorio de recursos: Módulo para descarga de diapositivas, normatividad y formatos jurídicos complementarios por clase.

### 5.4 Módulo de Certificación Verificable
- Emisión automática del certificado en PDF una vez el administrador o docente marca el curso como completado.
- Contenido del certificado: Nombre completo del alumno, número de documento de identidad, nombre del programa, intensidad horaria, firma digitalizada de los directores de SJI y fecha de expedición.
- Sistema de verificación pública:
  - Código alfanumérico único por certificado.
  - Código QR impreso en el PDF que redirige a `https://cursos.sjicolombia.com/verificar/[CODIGO]`.
  - Página de consulta pública donde terceros (ej. juntas de copropietarios) pueden validar la autenticidad del diploma emitido por la firma.

### 5.5 Panel de Administración
- CRUD de programas formativos (borrador, publicado, en curso, finalizado).
- Módulo de conciliación de pagos con estado de transacciones recibidas vía pasarela.
- Exportación de listados de alumnos en formato Excel/CSV.

---

## 6. Requerimientos no funcionales

- **Infraestructura y Hosting:** Despliegue en un **Servidor Virtual Privado (VPS)** independiente (ej. Hostinger VPS o DigitalOcean/Hetzner). Esta decisión garantiza recursos dedicados para la base de datos, colas de correo y renderizado de PDFs, evitando cualquier caída o interferencia con el sitio web principal `sjicolombia.com`.
- **Seguridad y Privacidad:** Cumplimiento de la Ley Estatutaria 1581 de 2012 (Habeas Data Colombia). Conexión cifrada de punto a punto bajo protocolo HTTPS/TLS. Contraseñas de usuario cifradas con algoritmos robustos (bcrypt/argon2).
- **Usabilidad y Rendimiento:** Diseño minimalista y accesible para profesionales y adultos no técnicos. Carga ágil en conexiones móviles 4G.

---

## 7. Arquitectura técnica recomendada

- **Frontend / Backend:** Arquitectura basada en Node.js (Next.js / Express) o PHP moderno (Laravel), optimizada para despliegue en servidor Linux con NGINX como reverse proxy y certificados SSL automatizados con Certbot.
- **Base de Datos:** Motor relacional PostgreSQL o MySQL con soporte para migraciones versionadas.
- **Procesamiento Asíncrono:** Cola de tareas para el envío de correos transaccionales (confirmación de matrícula, recordatorios) y compilación de certificados PDF.
- **Pasarela:** API / Widget oficial de Wompi con validación criptográfica de firmas en webhooks.

---

## 8. Fases de implementación

| Fase | Alcance principal | Tiempo estimado |
|---|---|---|
| **Fase 1 — MVP Operativo** | Despliegue en VPS, catálogo, checkout Wompi (pago único), panel de alumno con acceso a salas en vivo, repositorio de materiales, panel admin y certificados PDF con QR verificable. | 5–6 semanas |
| **Fase 2 — Automatización** | Notificaciones automáticas por WhatsApp API, integración directa con API de Zoom para link personal por alumno, evaluación de opciones de pago diferido. | 3–4 semanas |
| **Fase 3 — Expansión** | Cursos pregrabados on-demand, biblioteca de modelos jurídicos por suscripción y evaluaciones modulares. | Según demanda comercial |

---

## 9. Criterios de éxito del MVP

1. Flujo de compra autónomo: Un alumno se registra, paga por PSE/Nequi y obtiene sus accesos sin soporte manual de SJI.
2. Trazabilidad financiera: Cero conciliaciones manuales por extractos bancarios o recibos de WhatsApp.
3. Validación externa: Al menos un tercero o copropiedad valida con éxito un certificado mediante el código QR público.

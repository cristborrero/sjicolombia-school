# SJI Colombia — Plataforma de Cursos Jurídicos en Vivo

Plataforma educativa y sistema de gestión de aprendizaje (LMS) para **SJI Colombia (Soluciones Jurídicas e Inmobiliarias de Colombia S.A.S.)**, orientada a la venta, impartición de cursos jurídicos e inmobiliarios en vivo, y emisión de certificaciones oficiales verificables.

---

## 📚 Documentación del Proyecto

- [PRD — Plataforma de Cursos Jurídicos en Vivo (v1.1)](docs/PRD_Plataforma_Cursos_SJI_Colombia.md)
- [Plan Técnico de Implementación & Arquitectura](docs/PLAN_TECNICO_IMPLEMENTACION_LMS.md)

---

## 🏛️ Arquitectura & Stack Tecnológico

- **Backend / Core:** PHP 8.3 + Laravel 11 LTS
- **Panel Administrativo:** Filament PHP v3
- **Frontend Alumno / Catálogo:** Blade + Tailwind CSS + Alpine.js
- **Base de Datos:** MySQL 8 / MariaDB (ACID)
- **Colas y Tareas Asíncronas:** Redis + Laravel Queue (Supervisor)
- **Pasarela de Pagos:** Wompi Colombia (PSE, Nequi, Tarjetas, Botón Bancolombia)
- **Certificación Digital:** DomPDF + Motor de Códigos QR con validación web pública
- **Infraestructura:** VPS Linux Ubuntu 24.04 LTS (NGINX + Let's Encrypt SSL)

---

## 🚀 Roadmap de Desarrollo

1. **Sprint 1:** Infraestructura VPS, Modelo Relacional y Panel Administrativo (Filament v3).
2. **Sprint 2:** Catálogo público, Registro y Checkout Wompi (Pago único).
3. **Sprint 3:** Aula virtual, Panel del Alumno y del Docente con acceso a sesiones en vivo.
4. **Sprint 4:** Módulo de Certificados con QR verificable, Testing Sandbox y Salida a Producción.

---

## 🔒 Licencia y Propiedad

Propiedad exclusiva de **Soluciones Jurídicas e Inmobiliarias de Colombia S.A.S. (SJI Colombia)**.  
Desarrollado y coordinado por **LevelOne Agency**.

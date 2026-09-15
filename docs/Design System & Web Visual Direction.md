# SJI ESCUELA JURÍDICA
## Sistema de Diseño y Dirección Visual Web (Living Design System)

> **Estado:** Implementado en Producción Local (v1.0)  
> **Ámbito:** Vistas públicas Blade (`layouts/app.blade.php`) + Panel Administrativo Filament (`AdminPanelProvider.php`)  
> **Última actualización:** Septiembre 2026

---

## 01. Posicionamiento de Marca y Principio Creativo

SJI Escuela Jurídica es una institución de formación jurídica conectada con la práctica profesional real.

### Principio Creativo Esencial
> **"EL CONOCIMIENTO TAMBIÉN ES UNA FORMA DE JUSTICIA."**
> 
> La interfaz debe comunicar esta idea sin necesidad de explicarla visualmente de manera literal.  
> Menos decoración, más criterio. Menos elementos, más jerarquía. Menos efectos, más presencia. Menos plantilla, más identidad.

### Sensación General
**PREMIUM + INSTITUCIONAL + EDITORIAL + CONTEMPORÁNEA + INTELECTUAL**  
Inspiración: *Unión entre una escuela de leyes de élite, una revista editorial de alto nivel y una institución contemporánea.*

### Atributos que transmite la marca
- Autoridad y rigor académico
- Claridad conceptual y criterio
- Prestigio profesional
- Evolución y conexión con la práctica real

### Anti-referencias (Lo que NO es la escuela)
- NO es una universidad tradicional anticuada
- NO es una academia genérica ni una startup EdTech estándar
- NO es una plataforma de cursos baratos ni una plantilla SaaS / WordPress
- NO utilizar clichés jurídicos decorativos (balanzas, mazos, martillos, columnas griegas, escudos). La sofisticación proviene exclusivamente de la tipografía, composición, espacio, proporción y ritmo.

---

## 02. Paleta Oficial de Colores (Color Tokens)

La paleta cromática está unificada a través de variables CSS nativas, configuración inline de Tailwind y providers de Filament.

| Nombre | HEX | Variable CSS / Token | Uso Principal |
| :--- | :--- | :--- | :--- |
| **Primary Navy** | `#0B1726` | `var(--navy)` / `navy` | Fondos institucionales, header, footer, hero sections, botones primarios, superficies oscuras. Transmite autoridad y rigor. |
| **Accent Gold** | `#B99A5B` | `var(--gold)` / `gold` | Acentos estratégicos, líneas divisorias, estados activos, focus rings, detalles de prestigio. **Regla de oro:** No debe dominar la interfaz, es un acento sobrio. |
| **Ivory** | `#F5F2EA` | `var(--ivory)` / `ivory` | Fondos de secciones editoriales, catálogo de cursos, formularios de autenticación, áreas de contenido cálido. |
| **Ink** | `#111111` | `var(--ink)` / `ink` | Tipografía principal, títulos sobre fondos claros, iconografía de alta precisión. |
| **White** | `#FFFFFF` | `var(--white)` / `white` | Tarjetas editoriales, superficies limpias, inputs, texto de alto contraste sobre fondos oscuros. |

### Activos Oficiales de Marca (Logos y Favicon)
Los archivos vectoriales oficiales se ubican en `public/images/logos/` y en la raíz `public/favicon.svg`:

- **`logo-sji-school-dark.svg`**: Isotipo + Logotipo completo con elementos oscuros (`#0B1726`, `#111111`) y acentos dorados (`#B99A58`). Diseñado para **fondos claros** (Header público, login, registro, Filament Light Mode).
- **`logo-sji-school-light.svg`**: Isotipo + Logotipo completo con elementos claros (`#FFFFFF`) y acentos dorados (`#B99A58`). Diseñado para **fondos oscuros** (Footer institucional Navy, Filament Dark Mode).
- **`favicon-sji-school.svg` / `favicon.svg`**: Sello / monograma circular oficial institucional sobre base Navy (`#0B1726`) con líneas doradas y blancas. Utilizado como favicon de navegador en la web pública y en el panel Filament.

---

## 03. Sistema Tipográfico

La identidad tipográfica descansa en una combinación jerárquica estricta de dos fuentes de Google Fonts:

```html
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;0,700;1,400&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
```

### 1. Display / Brand Typeface: **Playfair Display** (`font-display` / `serif`)
- **Personalidad:** Elegante, editorial, intelectual, institucional.
- **Uso:**
  - Titulares principales (`H1`, `H2` de alto impacto).
  - Títulos de cursos en tarjetas y páginas de detalle.
  - Frases institucionales y declaraciones de marca (con énfasis ocasional en *itálica* dorada).
- **Pesos:** Regular (400), SemiBold (600), Bold (700).

### 2. UI / Body Typeface: **Montserrat** (`font-sans` / `sans-serif`)
- **Personalidad:** Precisa, moderna, funcional, altamente legible.
- **Uso:**
  - Navegación y menús.
  - Botones, labels y formularios.
  - Metadata, badges, categorías (con tracking expandido: `uppercase tracking-wider`).
  - Párrafos de lectura (body copy).
  - **Panel Administrativo Filament:** Se utiliza exclusivamente Montserrat para garantizar densidad de datos y legibilidad óptima en tablas y formularios de gestión.
- **Pesos:** Light (300), Regular (400), Medium (500), SemiBold (600), Bold (700).

### Escala Tipográfica
- **Display / Hero H1:** 48px–64px (`text-4xl md:text-6xl`), line-height ajustado (`leading-tight`).
- **H2 (Sección):** 32px–40px (`text-2xl md:text-4xl`).
- **H3 (Tarjetas / Subtítulos):** 20px–24px (`text-xl md:text-2xl`).
- **Body Large:** 18px (`text-lg`), line-height holgado para lectura prolongada.
- **Body:** 15px–16px (`text-base`).
- **Eyebrow / Category Labels:** 11px–12px (`text-xs uppercase tracking-widest font-semibold text-[#B99A5B]`).

---

## 04. Reglas de Composición y Lenguaje Visual

### Proporciones y Radios
- **Botones:** `border-radius: 4px` (`rounded-[4px]`). Sobrios, estructurados.
- **Tarjetas / Contenedores:** `border-radius: 6px` (`rounded-[6px]`).
- **Divisores de Acento:** `.gold-line` (48px ancho × 2px alto, color `#B99A5B`).
- **Bordes:** Finos y sutiles: `border border-[#0B1726]/10` en tarjetas sobre marfil/blanco.

### Prohibiciones Estrictas (Anti-Patrones de Diseño)
1. **NO Glassmorphism:** Cero `backdrop-blur-md` o capas translúcidas tipo SaaS tecnológico genérico.
2. **NO Pill Buttons:** Cero `rounded-full` en botones de acción principales o tarjetas.
3. **NO Sombras Pesadas:** Cero `shadow-xl`, `shadow-2xl` o sombras coloreadas artificiales. Se utilizan cambios de superficie, contrastes limpios y bordes milimétricos.
4. **NO Degradados Gratuitos:** Cero gradientes multicolor, neón o de arcoíris.
5. **NO Playfair en Filament:** No forzar Playfair Display en tablas o formularios densos del panel administrativo.

---

## 05. Clases y Componentes Base Implementados

Los tokens y componentes están disponibles globalmente en todas las vistas que heredan de `resources/views/layouts/app.blade.php`:

### Botones (`Button System`)
```css
/* Primario Institucional */
.btn-navy {
    background-color: #0B1726;
    color: #FFFFFF;
    padding: 0.625rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    border-radius: 4px;
    transition: background-color 150ms ease;
}
.btn-navy:hover {
    background-color: #142338;
}

/* Secundario / Outline */
.btn-outline {
    border: 1px solid #0B1726;
    color: #0B1726;
    padding: 0.625rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    letter-spacing: 0.05em;
    border-radius: 4px;
    transition: all 150ms ease;
}
.btn-outline:hover {
    background-color: #0B1726;
    color: #FFFFFF;
}

/* Acento Estratégico (Dorado) */
.btn-gold {
    background-color: #B99A5B;
    color: #0B1726;
    padding: 0.625rem 1.25rem;
    font-size: 0.875rem;
    font-weight: 600;
    letter-spacing: 0.05em;
    border-radius: 4px;
    transition: background-color 150ms ease;
}
.btn-gold:hover {
    background-color: #c9aa6b;
}
```

### Tarjeta Editorial (`Card System`)
```css
.card-editorial {
    background-color: #FFFFFF;
    border: 1px solid rgba(11, 23, 38, 0.08);
    border-radius: 6px;
    padding: 1.5rem;
    transition: border-color 200ms ease, box-shadow 200ms ease;
}
.card-editorial:hover {
    border-color: rgba(185, 154, 91, 0.4);
    box-shadow: 0 4px 12px rgba(11, 23, 38, 0.04);
}
```

### Línea de Acento (`Accent Divider`)
```css
.gold-line {
    width: 3rem;       /* 48px */
    height: 2px;
    background-color: #B99A5B;
}
```

---

## 06. Estructura de Páginas y Secciones

### 1. Header Institucional (`Navigation`)
- **Altura fija:** 72px (`h-[72px]`).
- **Fondo:** `#0B1726` con borde inferior sutil `border-b border-[#B99A5B]/20`.
- **Branding:** Isotipo/Logotipo SJI + "ESCUELA JURÍDICA" en Playfair Display con acento dorado.
- **Navegación:** Enlaces en Montserrat, `text-xs uppercase tracking-widest text-slate-300 hover:text-[#B99A5B]`.
- **CTA Derecho:** Botón `.btn-gold` directo al catálogo / ingresar.
- **Mobile Menu:** Panel Alpine.js colapsable con fondo Navy y enlaces jerárquicos.

### 2. Secciones Principales
- **Hero Sections:** Fondo Navy (`#0B1726`), subtítulo eyebrow dorado (`#B99A5B`), H1 en Playfair Display destacando palabras clave en itálica dorada, selector de acciones en botones Navy y Outline.
- **Catálogo de Cursos:** Fondo Marfil (`#F5F2EA`), tarjetas blancas editoriales con borde fino, categorías en tracking mayúsculo, metadatos estructurados (duración, modalidad, precio en formato COP).
- **Detalle de Curso:** Header en Navy con migas de pan institucionales; desglose de temario (Syllabus) y sesiones en Marfil; sidebar de inscripción en tarjeta blanca de alto contraste con métodos de pago e instructor.
- **Formularios de Autenticación (Login / Registro):** Fondo Ivory centrado, tarjeta editorial blanca, labels técnicos en mayúsculas pequeñas, inputs con focus ring dorado (`focus:ring-[#B99A5B] focus:border-[#B99A5B]`).
- **Certificados y Pagos:** Páginas de validación institucional con estados de éxito en dorado y feedback de pago seguro.
- **Footer Institucional:** Fondo `#0B1726` con línea de acento superior dorada continua (`border-t-2 border-[#B99A5B]`), títulos de categoría en Montserrat dorado, información de contacto de SJI Soluciones Jurídicas y WhatsApp de soporte.

---

## 07. Integración con Filament Admin

Configurado centralmente en `app/Providers/Filament/AdminPanelProvider.php`:

```php
use Filament\Support\Colors\Color;
use Filament\View\PanelsRenderHook;
use Illuminate\Support\HtmlString;

return $panel
    ->default()
    ->id('admin')
    ->path('admin')
    ->brandName('SJI Escuela Jurídica')
    ->brandLogo(fn () => asset('images/logos/logo-sji-school-dark.svg'))
    ->darkModeBrandLogo(fn () => asset('images/logos/logo-sji-school-light.svg'))
    ->brandLogoHeight('2rem')
    ->favicon(fn () => asset('favicon.svg'))
    ->colors([
        'primary' => Color::hex('#B99A5B'),  // Dorado institucional
        'gray' => Color::Slate,              // Base Slate/Navy balanceada
    ])
    ->font('Montserrat')
    ->renderHook(
        PanelsRenderHook::HEAD_END,
        fn (): HtmlString => new HtmlString('
            <style>
                .fi-sidebar-item:not(.fi-active) .fi-sidebar-item-icon {
                    color: #94a3b8 !important;
                    opacity: 0.9;
                    transition: color 150ms ease, opacity 150ms ease;
                }
                .fi-sidebar-item:not(.fi-active):hover .fi-sidebar-item-icon {
                    color: #B99A5B !important;
                    opacity: 1;
                }
            </style>
        ')
    );
```

- **Logos Dinámicos:** Muestra la variante oscura sobre fondos claros y la variante clara sobre fondos oscuros.
- **Favicon:** Enlazado al sello circular oficial en formato SVG.
- **Localización:** Panel 100% en español (`config/app.php` -> `'locale' => 'es'`).
- **Iconografía:** Heroicons semánticos y diferenciados por recurso, con contraste de color garantizado y transición dorada en hover.

---

## 08. Mapeo de Vistas Implementadas

| Ruta / Vista | Archivo Fuente Blade | Estado Visual |
| :--- | :--- | :--- |
| **Layout Base** | `resources/views/layouts/app.blade.php` | Tokens, Fuentes, Header, Footer, CDN Config |
| **Inicio (Home)** | `resources/views/welcome.blade.php` | Hero editorial, propuestas de valor, cursos destacados, banner CTA |
| **Catálogo** | `resources/views/courses/index.blade.php` | Header institucional, grid editorial de cursos |
| **Detalle de Curso** | `resources/views/courses/show.blade.php` | Ficha técnica, temario, fechas, sidebar de matrícula |
| **Mis Cursos** | `resources/views/courses/my-courses.blade.php` | Dashboard del estudiante con sesiones activas |
| **Ingreso (Login)** | `resources/views/auth/login.blade.php` | Formulario centrado sobre Marfil, focus rings dorados |
| **Registro** | `resources/views/auth/register.blade.php` | Formulario alineado con términos legales y foco institucional |
| **Verificación Certificados** | `resources/views/certificates/verify.blade.php` | Validación oficial con sello institucional |
| **Pago Exitoso / Fallido** | `resources/views/payments/*.blade.php` | Pantallas de confirmación y soporte WhatsApp |
| **Panel Admin** | `app/Providers/Filament/AdminPanelProvider.php` | Tema Gold/Navy con Montserrat |

---

## 09. Guía para Futuros Desarrollos

Cualquier nueva vista, módulo o componente que se agregue al sistema debe ceñirse a las siguientes directrices:

1. **Extender del Layout Principal:**
   ```blade
   @extends('layouts.app')
   @section('title', 'Nombre de la Página | SJI Escuela Jurídica')
   @section('content')
       {{-- Contenido con clases del Design System --}}
   @endsection
   ```
2. **Jerarquía Tipográfica Obligatoria:**
   - Titulares de sección: `font-display text-3xl md:text-4xl text-[#0B1726]`
   - Eyebrows: `text-xs uppercase tracking-widest font-semibold text-[#B99A5B]`
   - Textos de apoyo: `font-sans text-slate-600`
3. **Fondos de Sección Alternados:**
   - Alternar entre `bg-[#0B1726]` (secciones institucionales o de quiebre), `bg-[#F5F2EA]` (secciones editoriales y catálogos) y `bg-white` (tarjetas y detalles de lectura).
4. **Uso de Botones:**
   - Acción principal: `.btn-navy`
   - Acción secundaria / alternativa: `.btn-outline`
   - Acción de conversión estratégica: `.btn-gold`
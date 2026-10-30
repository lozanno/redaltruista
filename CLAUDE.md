# redaltruista.org — contexto para Claude Code

Reconstrucción del sitio de la Red de Asociaciones Altruistas (Puerto Vallarta) **sin Avada**, con WordPress + Gutenberg.
El cliente mantiene su hosting de WordPress en GoDaddy (sin staging, producción en WP 7.1.4). Sitio solo en español (es_MX).

## Estructura

- `wp-content/themes/redaltruista/` — tema de bloques. El diseño vive en `theme.json`; `style.css` solo para lo que theme.json no cubre.
- `wp-content/plugins/ra-directorio/` — CPT `asociacion` (archivo en `/asociaciones-afiliadas/`), taxonomía `area-servicio` (`/area/{slug}/`), campos en `includes/fields.php` (fuente única), meta box clásica, bloques dinámicos `ra/asociacion-enlaces` y `ra/filtro-areas` (sin build: `editor.js` con `wp.*` globales + `render.php`), importador (`data/asociaciones.json`, WP-CLI `wp ra-directorio import` y pantalla Asociaciones → Importar), shortcode `[ra_total_asociaciones]` (número de asociaciones publicadas: usarlo siempre en lugar de escribir la cifra).
- `local/` — WordPress local 7.1.4 con SQLite (no versionado). `bin/serve.sh` lo arranca en http://localhost:8080 (admin/admin) con `bin/router.php` (agrega la barra final a carpetas como Apache; sin él `/wp-admin` rompe los enlaces del admin) y crea los symlinks del tema y plugin. `bin/wp` = WP-CLI del sitio local.
- `logos/` — logos descargados del sitio actual (no versionado).
- `*_full_*/` — respaldo completo de GoDaddy (no versionado: trae `wp-config.php` con credenciales). De ahí salieron los uploads y los 388 adjuntos del sitio local (mismos ID que en producción).
- `local/referencia/paginas/{slug}.txt` — contenido original (Avada) de cada página de producción, extraído del respaldo; fuente para la migración.

## Convenciones

- Sin page builders, sin dependencias de pago, sin paso de compilación JS.
- Prefijo `ra_` / `RA_DIR_` en el plugin; text domain `ra-directorio` y `redaltruista`. Textos de interfaz en español.
- Paleta (slugs de theme.json): primario `#00827b`, primario-claro `#00afa9`, acento `#00bcd4`, menta `#98dad9`, menta-suave, amarillo `#fec96b`, coral `#ed6967`, oscuro `#262e44`, texto `#5c6668`, gris-menu, gris-claro, blanco.
- Tipografías locales: Montserrat (títulos), Raleway (texto), Roboto Condensed (menú/botones).
- Validar PHP con `php -l` y probar en el sitio local antes de dar algo por terminado.

## Estado (oct 2026)

Hecho: tema, plugin, importación de las 28 asociaciones con sus logos (tomados de la Biblioteca de medios, como en producción), página de Inicio con patrones (hero, programas, cifras, CTA) y Sobre nosotros (patrón de página `redaltruista/pagina-sobre-nosotros`) en el sitio local.

Páginas institucionales: cada una es un patrón de página en `patterns/pagina-*.php` (`Post Types: page`, imágenes por ID de adjunto, mismos ID que producción). En producción se crea/edita la página y se elige el patrón; el contenido queda editable. El `wp-config.php` local define `WP_DEVELOPMENT_MODE` = `theme` para que los patrones nuevos se registren sin caché.

Pendiente:
1. Migrar el contenido de las páginas del sitio actual (redaltruista.org): Inicio, ~~Sobre nosotros (`/acerca-de/`)~~, Contribuye, Eventos, Transparencia, Contáctanos — reconstruir con bloques/patrones, sin shortcodes de Avada. Producción tiene además: Programas y Servicios, Registro, Encuentro 2017/2018/2019/2023/2024 y Diplomado 2019 (decidir con el cliente si se migran).
2. Formularios "Registro – Asociación" y "Constituirse" (eran modales de Avada): elegir plugin ligero y reemplazar.
3. Validar con el cliente: áreas asignadas a cada asociación, cifras de voluntarios/proyectos (`XX` en el patrón), correo del pie (`.org` vs `.com`). Sobre nosotros: año de fundación (la banda dice 2009, la historia 2008).
4. Plan de publicación en GoDaddy (ver README → Migración a producción).

Repo: https://github.com/lozanno/redaltruista.git

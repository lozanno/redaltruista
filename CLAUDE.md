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

Hecho: tema, plugin, importación de las 28 asociaciones con sus logos (tomados de la Biblioteca de medios, como en producción), página de Inicio con patrones (hero, programas, cifras, CTA), Sobre nosotros (`redaltruista/pagina-sobre-nosotros`) y Contribuye (`redaltruista/pagina-contribuye`; la lista de necesidades es una hoja de Google que mantiene el cliente, solo se incrusta) y Eventos (`redaltruista/pagina-eventos`: Query Loop de las páginas hijas de Eventos; las 6 hijas existen en local con imagen destacada y contenido pendiente) y Transparencia (`redaltruista/pagina-transparencia`: línea de tiempo) en el sitio local.

Páginas institucionales: cada una es un patrón de página en `patterns/pagina-*.php` (`Post Types: page`, imágenes por ID de adjunto, mismos ID que producción). En producción se crea/edita la página y se elige el patrón; el contenido queda editable. El `wp-config.php` local define `WP_DEVELOPMENT_MODE` = `theme` para que los patrones nuevos se registren sin caché.

Pendiente:
1. Migrar el contenido de las páginas del sitio actual (redaltruista.org): Inicio, ~~Sobre nosotros (`/acerca-de/`)~~, ~~Contribuye~~, ~~Eventos~~ (índice), ~~Transparencia~~, Contáctanos — reconstruir con bloques/patrones, sin shortcodes de Avada. Páginas hijas de Eventos por migrar, una por una con propuesta previa: Diplomado 2019 (imágenes en un dominio temporal viejo), Encuentro 2017, 2018, 2019, 2023 y 2024. Producción tiene además Programas y Servicios y Registro (decidir con el cliente si se migran).
2. Necesidades en el CPT `asociacion`: que cada asociación tenga sus necesidades (tipo: especie / económico / voluntariado, descripción, frecuencia o cantidad, contacto) editables desde WordPress, y un bloque dinámico que las liste (por tipo, con enlace a la ficha) para reemplazar la hoja de Google incrustada en Contribuye. Así el cliente actualiza todo desde WordPress. Datos iniciales: la hoja actual (`…/pub?output=csv`).
3. Formularios "Registro – Asociación" y "Constituirse" (eran modales de Avada): elegir plugin ligero y reemplazar.
4. Validar con el cliente: áreas asignadas a cada asociación, cifras de voluntarios/proyectos (`XX` en el patrón), correo del pie (`.org` vs `.com`). Sobre nosotros: año de fundación (la banda dice 2009, la historia 2008); la referencia es la línea de tiempo de /transparencia (2008 reuniones de vinculación, 2010 la RED opera formalmente, 2016 A.C.). Transparencia: qué documentos publicar (constancia de donataria autorizada, informes, estados financieros); el usuario lo consulta con el cliente.
5. Plan de publicación en GoDaddy (ver README → Migración a producción).

Repo: https://github.com/lozanno/redaltruista.git
